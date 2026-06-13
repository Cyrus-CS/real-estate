<?php

namespace App\Enums;

enum PropertyStatus: string
{
    case FOR_RENT = 'for_rent';
    case FOR_SALE = 'for_sale';
    case SOLD = 'sold';
    case RENTED = 'rented';
    case OFF_MARKET = 'off_market';

    /**
     * Retourne le label traduit
     */
    public function label(): string
    {
        return match($this) {
            self::FOR_RENT => 'À louer',
            self::FOR_SALE => 'À vendre',
            self::SOLD => 'Vendu',
            self::RENTED => 'Loué',
            self::OFF_MARKET => 'Hors marché',
        };
    }

    /**
     * Retourne tous les cas sous forme de tableau [value => label]
     */
    public static function toArray(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }

    /**
     * Retourne toutes les valeurs possibles
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Badge de couleur pour l'affichage
     */
    public function badge(): string
    {
        return match($this) {
            self::FOR_RENT => 'bg-info',
            self::FOR_SALE => 'bg-primary',
            self::SOLD => 'bg-success',
            self::RENTED => 'bg-warning',
            self::OFF_MARKET => 'bg-secondary',
        };
    }

    /**
     * Icône pour l'affichage
     */
    public function icon(): string
    {
        return match($this) {
            self::FOR_RENT => 'bi-key',
            self::FOR_SALE => 'bi-cart',
            self::SOLD => 'bi-check-circle',
            self::RENTED => 'bi-lock',
            self::OFF_MARKET => 'bi-eye-slash',
        };
    }
}
