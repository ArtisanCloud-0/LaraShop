<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case SHIPPED = 'shipped';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';

    /**
     * Get Tailwind badge classes with dark mode support.
     */
    public function badgeColor(): string
    {
        return match($this) {
            self::PENDING   => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
            self::PAID      => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
            self::SHIPPED   => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
            self::CANCELLED => 'bg-red-500/10 text-red-400 border-red-500/20',
            self::COMPLETED => 'bg-green-500/10 text-green-400 border-green-500/20',
        };
    }

    /**
     * Get a human-readable label.
     */
    public function label(): string
    {
        return match($this) {
            self::PENDING   => 'Pending',
            self::PAID      => 'Paid',
            self::SHIPPED   => 'Shipped',
            self::CANCELLED => 'Cancelled',
            self::COMPLETED => 'completed',
        };
    }

    /**
     * Returns key-value pairs convenient for select inputs.
     */
    public static function options(): array
    {
        return array_column(self::cases(), 'value', 'value');
    }
}
