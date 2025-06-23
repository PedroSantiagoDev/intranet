<?php

namespace App\Livewire\Reservation;

use App\Models\{Reservation, Room};
use Carbon\Carbon;
use Filament\Forms\{ComponentContainer, Form};
use Filament\Forms\Components\{DatePicker, Grid, Hidden, Section, Select, TextInput, Textarea, TimePicker, Toggle};
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Attributes\{Layout, Title};
use Livewire\Attributes\Url;
use Livewire\Component;

/**
 * @property ComponentContainer $form
 */
#[Layout('components.layouts.app')]
#[Title('Reservar Auditório')]
class ReservationForm extends Component implements HasForms
{
    use InteractsWithForms;

    /** @var array<string, mixed> */
    public ?array $data = [];

    #[Url]
    public ?Reservation $reservation = null;

    public function mount(): void
    {
        if ($this->reservation) {
            $this->form->fill([
                'date'         => $this->reservation->date,
                'start_time'   => $this->reservation->start_time,
                'end_time'     => $this->reservation->end_time,
                'event_link'   => $this->reservation->event_link,
                'ti_equipment' => $this->reservation->ti_equipment,
                'observation'  => $this->reservation->observation,
                'subject'      => $this->reservation->subject,
                'status'       => $this->reservation->status,
                'user_id'      => $this->reservation->user_id,
                'unit_id'      => $this->reservation->unit_id,
                'room_id'      => $this->reservation->room_id,
            ]);
        } else {
            $this->form->fill([
                'status'  => 'RESERVADO',
                'user_id' => Auth::id(),
                'unit_id' => Auth::user()->unit_id,
            ]);
        }
    }

    public function form(Form $form): Form
    {
        $isPastDate = $this->reservation && Carbon::parse($this->reservation->date)->isBefore(Carbon::today());

        return $form
            ->schema([
                Section::make('Detalhes da Reserva')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                Select::make('room_id')
                                    ->label('Sala')
                                    ->options(Room::where('is_active', true)->pluck('name', 'id'))
                                    ->required()
                                    ->searchable()
                                    ->preload(),
                                DatePicker::make('date')
                                    ->label('Data da Reserva')
                                    ->required()
                                    ->minDate($isPastDate ? $this->reservation->date : today())
                                     ->rules($isPastDate ? [] : ['required', 'date', 'after_or_equal:today'])
                                    ->validationMessages($isPastDate ? [] : [
                                        'after_or_equal' => 'A data não pode ser anterior a hoje',
                                    ])
                                    ->disabled($isPastDate),
                                TimePicker::make('start_time')
                                    ->label('Hora de Início')
                                    ->required()
                                    ->seconds(false)
                                    ->displayFormat('H:i')
                                    ->format('H:i:s')
                                    ->validationMessages([
                                        'required' => 'A hora de início é obrigatória',
                                    ])->disabled($isPastDate),
                                TimePicker::make('end_time')
                                    ->label('Hora de Término')
                                    ->required()
                                    ->seconds(false)
                                    ->displayFormat('H:i')
                                    ->format('H:i:s')
                                    ->rules(['required', 'after:start_time'])
                                    ->validationMessages([
                                        'after' => 'O horário de término deve ser após a hora de início',
                                    ])->disabled($isPastDate),
                            ]),
                    ]),

                Section::make('Informações Adicionais')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextInput::make('subject')
                                    ->label('Assunto')
                                    ->maxLength(255)
                                    ->required()
                                    ->disabled($isPastDate),
                                TextInput::make('event_link')
                                    ->label('Link da Reunião')
                                    ->url()
                                    ->placeholder('https://meet.google.com/...')
                                    ->nullable()
                                    ->validationMessages([
                                        'url' => 'O link deve ser uma URL válida',
                                        'max' => 'O link não pode ter mais que 2048 caracteres',
                                    ])
                                    ->disabled($isPastDate),
                                Toggle::make('ti_equipment')
                                    ->label('Necessita equipamentos de TI?')
                                    ->default(false)
                                    ->inline(false)
                                    ->disabled($isPastDate),
                                $this->reservation && (
                                    auth()->user()->hasRole(['admin', 'auditorium']) ||
                                    auth()->user()->can('change_status auditorium')
                                ) ? Select::make('status')
                                        ->label('Status da Reserva')
                                        ->options([
                                            'RESERVADO' => 'Reservado',
                                            'CONCLUIDO' => 'Concluído',
                                            'CANCELADO' => 'Cancelado',
                                        ])
                                        ->required()
                                        ->live()
                                    : Hidden::make('status'),
                            ]),
                        Textarea::make('cancellation_reason')
                            ->label('Motivo do Cancelamento')
                            ->placeholder('Informe o motivo do cancelamento')
                            ->rows(3)
                            ->columnSpanFull()
                            ->required(fn (callable $get) => $get('status') === 'CANCELADO')
                            ->visible(fn (callable $get) => $get('status') === 'CANCELADO'),
                        Textarea::make('observation')
                            ->label('Observações')
                            ->placeholder('Informe detalhes relevantes sobre a reserva')
                            ->rows(3)
                            ->columnSpanFull()
                            ->nullable(),
                    ]),
                Hidden::make('user_id'),
                Hidden::make('unit_id'),
            ])
            ->columns(1)
            ->statePath('data');
    }

    public function save(): void
    {
        if ($this->reservation) {
            $this->update($this->reservation);
        } else {
            $this->create();
        }
    }

    public function create(): void
    {
        $validated = $this->form->validate();
        $data      = $validated['data'];

        $this->validateTimes($data);
        $this->checkForOverlaps($data);

        Reservation::create($data);

        Notification::make()
            ->title('Reserva criada com sucesso!')
            ->success()
            ->send();

        $this->redirect(route('reservations.index'));
    }

    public function update(Reservation $reservation): void
    {
        $validated  = $this->form->validate();
        $data       = $validated['data'];
        $isPastDate = Carbon::parse($reservation->date)->isPast();

        if ($isPastDate) {
            $data['date']         = $reservation->date;
            $data['start_time']   = $reservation->start_time;
            $data['end_time']     = $reservation->end_time;
            $data['subject']      = $reservation->subject;
            $data['event_link']   = $reservation->event_link;
            $data['ti_equipment'] = $reservation->ti_equipment;
        } else {
            $this->validateTimes($data);
            $this->checkForOverlaps($data, $reservation);
        }

        $reservation->update($data);

        Notification::make()
            ->title('Reserva atualizada com sucesso!')
            ->success()
            ->send();

        $this->redirect(route('reservations.index'));
    }

    /**
     * @param array<string, mixed> $data
     */
    private function validateTimes(array $data): void
    {
        $requestedStart = Carbon::parse($data['start_time']);
        $requestedEnd   = Carbon::parse($data['end_time']);

        if ($requestedEnd->lte($requestedStart)) {
            throw ValidationException::withMessages([
                'data.end_time' => ['O horário de término deve ser após o horário de início.'],
            ]);
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    private function checkForOverlaps(array $data, ?Reservation $exclude = null): void
    {
        $query = Reservation::whereDate('date', $data['date'])
            ->where('status', '!=', 'CANCELADO')
            ->where(function ($q) use ($data) {
                $q->where(function ($inner) use ($data) {
                    $inner->where('start_time', '<', $data['end_time'])
                          ->where('end_time', '>', $data['start_time']);
                });
            });

        if ($exclude) {
            $query->where('id', '!=', $exclude->id);
        }

        $overlaps = $query->get(['start_time', 'end_time']);

        if ($overlaps->isNotEmpty()) {
            $latestEnd = $overlaps
                ->map(fn ($r) => Carbon::parse($r->end_time))
                ->max();

            throw ValidationException::withMessages([
                'data.start_time' => [
                    "Este horário está ocupado. O próximo horário disponível é às " .
                    $latestEnd->format('H:i') . ".",
                ],
            ]);
        }
    }

    public function render(): View
    {
        return view('livewire.reservation.reservation-form');
    }
}
