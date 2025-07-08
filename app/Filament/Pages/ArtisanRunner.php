<?php

namespace App\Filament\Pages;

use Filament\Forms\{ComponentContainer, Form};
use Filament\Forms\Components\{Section, Select, TextInput, Toggle};
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\{Artisan, Log};

/**
 * @property ComponentContainer $form
 */
class ArtisanRunner extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-command-line';

    protected static ?string $navigationLabel = 'Artisan Runner';

    protected static ?string $title = 'Executar Comandos Artisan';

    protected static ?string $navigationGroup = 'Sistema';

    protected static ?int $navigationSort = 999;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    /** @var array<string, mixed> */
    public ?array $data = [];

    public string $output = '';

    protected static string $view = 'filament.pages.artisan-runner';

    public function mount(): void
    {
        $this->form->fill([
            'command_type'   => 'migrate',
            'custom_command' => '',
            'force'          => false,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Executar Comandos Artisan')
                    ->description('Execute comandos Artisan diretamente pelo painel admin')
                    ->schema([
                        Select::make('command_type')
                            ->label('Tipo de Comando')
                            ->options([
                                'migrate'        => 'php artisan migrate',
                                'migrate:status' => 'php artisan migrate:status',
                                'db:seed'        => 'php artisan db:seed',
                                'cache:clear'    => 'php artisan cache:clear',
                                'config:clear'   => 'php artisan config:clear',
                                'config:cache'   => 'php artisan config:cache',
                                'route:clear'    => 'php artisan route:clear',
                                'route:cache'    => 'php artisan route:cache',
                                'view:clear'     => 'php artisan view:clear',
                                'view:cache'     => 'php artisan view:cache',
                                'queue:work'     => 'php artisan queue:work',
                                'storage:link'   => 'php artisan storage:link',
                                'optimize'       => 'php artisan optimize',
                                'optimize:clear' => 'php artisan optimize:clear',
                                'custom'         => 'Comando Personalizado',
                            ])
                            ->reactive()
                            ->required(),

                        TextInput::make('custom_command')
                            ->label('Comando Personalizado')
                            ->placeholder('Ex: make:model User')
                            ->visible(fn ($get) => $get('command_type') === 'custom')
                            ->required(fn ($get) => $get('command_type') === 'custom'),

                        Toggle::make('force')
                            ->label('Forçar Execução (--force)')
                            ->visible(fn ($get) => in_array($get('command_type'), [
                                'migrate',
                                'migrate:fresh',
                                'migrate:reset',
                            ])),

                        TextInput::make('additional_params')
                            ->label('Parâmetros Adicionais')
                            ->placeholder('Ex: --step=1, --seed, etc.')
                            ->helperText('Parâmetros extras para o comando'),
                    ]),
            ])
            ->statePath('data');
    }

    public function executeCommand(): void
    {
        try {
            $data = $this->form->getState();

            $command = $data['command_type'];

            // Se for comando customizado
            if ($command === 'custom') {
                $command = $data['custom_command'];
            }

            // Adicionar parâmetros
            $params = [];

            if ($data['force'] ?? false) {
                $params['--force'] = true;
            }

            if (!empty($data['additional_params'])) {
                // Parse dos parâmetros adicionais
                $additionalParams = explode(' ', $data['additional_params']);

                foreach ($additionalParams as $param) {
                    if (str_starts_with($param, '--')) {
                        $paramParts = explode('=', $param, 2);

                        if (count($paramParts) === 2) {
                            $params[$paramParts[0]] = $paramParts[1];
                        } else {
                            $params[$param] = true;
                        }
                    }
                }
            }

            // Log da execução
            Log::info('Executando comando Artisan', [
                'command' => $command,
                'params'  => $params,
                'user'    => auth()->user()->email,
            ]);

            // Capturar output
            $exitCode = Artisan::call($command, $params);
            $output   = Artisan::output();

            $this->output = "Comando: php artisan {$command}\n";
            $this->output .= "Exit Code: {$exitCode}\n";
            $this->output .= "Output:\n" . $output;

            if ($exitCode === 0) {
                Notification::make()
                    ->title('Comando executado com sucesso!')
                    ->success()
                    ->send();
            } else {
                Notification::make()
                    ->title('Comando executado com avisos')
                    ->warning()
                    ->body("Exit code: {$exitCode}")
                    ->send();
            }

        } catch (\Exception $e) {
            $this->output = "ERRO: " . $e->getMessage();

            Log::error('Erro ao executar comando Artisan', [
                'error'   => $e->getMessage(),
                'command' => $command ?? 'unknown',
                'user'    => auth()->user()->email,
            ]);

            Notification::make()
                ->title('Erro ao executar comando')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }

    public function clearOutput(): void
    {
        $this->output = '';
    }

    public function getMigrationStatus(): void
    {
        try {
            Artisan::call('migrate:status');
            $this->output = "Status das Migrations:\n" . Artisan::output();

            Notification::make()
                ->title('Status obtido com sucesso!')
                ->success()
                ->send();
        } catch (\Exception $e) {
            $this->output = "ERRO: " . $e->getMessage();

            Notification::make()
                ->title('Erro ao obter status')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }
}
