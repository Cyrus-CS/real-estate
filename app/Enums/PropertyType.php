<?php

namespace App\Enums;

enum PropertyType: string
{
    case APARTMENT = 'apartment';
    case VILLA = 'villa';
    case STUDIO = 'studio';
    case PENTHOUSE = 'penthouse';
    case TOWNHOUSE = 'townhouse';
    case COMMERCIAL = 'commercial';
    case LAND = 'land';
    case FARMHOUSE = 'farmhouse';
    case COTTAGE = 'cottage';
    case LOFT = 'loft';
    case DUPLEX = 'duplex';
    case TRIPLEX = 'triplex';
    case RANCH = 'ranch';
    case MOBILE_HOME = 'mobile_home';
    case CONDO = 'condo';
    case BUNGALOW = 'bungalow';
    case CASTLE = 'castle';

    /**
     * Retourne le label traduit
     */
    public function label(): string
    {
        return match($this) {
            self::APARTMENT => 'Appartement',
            self::VILLA => 'Villa',
            self::STUDIO => 'Studio',
            self::PENTHOUSE => 'Penthouse',
            self::TOWNHOUSE => 'Maison de ville',
            self::COMMERCIAL => 'Commercial',
            self::LAND => 'Terrain',
            self::FARMHOUSE => 'Ferme',
            self::COTTAGE => 'Cottage',
            self::LOFT => 'Loft',
            self::DUPLEX => 'Duplex',
            self::TRIPLEX => 'Triplex',
            self::RANCH => 'Ranch',
            self::MOBILE_HOME => 'Mobile Home',
            self::CONDO => 'Copropriété',
            self::BUNGALOW => 'Bungalow',
            self::CASTLE => 'Château',
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
            /**
             * <?php
                *[
                  *  'apartment' => 'Appartement',
                   * 'villa' => 'Villa',
                  *  'studio' => 'Studio',
                  *  // ... etc
               * ]  
             */
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
            self::APARTMENT, self::STUDIO, self::CONDO => 'bg-primary',
            self::VILLA, self::CASTLE => 'bg-success',
            self::PENTHOUSE => 'bg-warning',
            self::COMMERCIAL => 'bg-info',
            self::LAND => 'bg-secondary',
            default => 'bg-dark',
        };
    }
}