<?php

namespace App\Livewire\Reservation;

use App\Models\Reservation;
use Filament\Forms\Components\{DatePicker};
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\{IconColumn, TextColumn};
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\{Filter, SelectFilter};
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\{Layout, Title};
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Reservar Auditório')]
class ReservationTable extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Reservation::query()
                    ->with('user')
                    ->orderByRaw('(date < CURDATE()) ASC, date ASC')
            )
            ->columns([
                TextColumn::make('date')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_time')
                    ->label('Início')
                    ->time('H:i'),
                TextColumn::make('end_time')
                    ->label('Término')
                    ->time('H:i'),
                TextColumn::make('subject')
                    ->label('Assunto')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Responsável')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('ti_equipment')
                   ->label('Equip. da TI?')
                    ->alignCenter()
                   ->boolean(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'success' => 'RESERVADO',
                        'primary' => 'CONCLUIDO',
                        'danger'  => 'CANCELADO',
                    ])
                    ->sortable()
                    ->alignCenter(),
            ])
            ->filters([
                SelectFilter::make('status')
                ->options([
                    'RESERVADO' => 'Reservado',
                    'CONCLUIDO' => 'Concluído',
                    'CANCELADO' => 'Cancelado',
                ])
                ->default('RESERVADO')
                ->label('Filtrar por Status')
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['value'])) {
                        $query->where('status', $data['value']);
                    }
                }),
                Filter::make('date')
                    ->form([
                        DatePicker::make('date_filter')
                            ->label('Filtrar por data')
                            ->displayFormat('d/m/Y'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_filter'],
                                fn (Builder $query, $date) => $query->whereDate('date', $date)
                            );
                    }),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Action::make('edit')
                    ->icon('heroicon-m-pencil-square')
                    ->url(fn (Reservation $record) => route('reservations.edit', $record))
                    ->visible(function (Reservation $record) {
                        $user = auth()->user();

                        return $user->hasRole('admin')
                            || $user->hasRole('auditorium')
                            || $user->can('edit auditorium')
                            || $record->user_id === $user->id;
                    }),
            ])
            ->bulkActions([
                //
            ]);
    }

    public function render(): View
    {
        return view('livewire.reservation.reservation-table');
    }
}
