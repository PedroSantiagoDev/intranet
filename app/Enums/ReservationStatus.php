<?php

namespace App\Enums;

enum ReservationStatus: string
{
    case RESERVED  = 'RESERVADO';
    case CONCLUDED = 'CONCLUIDO';
    case CANCELLED = 'CANCELADO';
    case PENDING   = 'PENDENTE';

    public function label(): string
    {
        return match($this) {
            self::RESERVED  => 'Reservado',
            self::CONCLUDED => 'Concluído',
            self::CANCELLED => 'Cancelado',
            self::PENDING   => 'Pendente',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::RESERVED  => 'warning',
            self::CONCLUDED => 'success',
            self::CANCELLED => 'danger',
            self::PENDING   => 'gray',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
