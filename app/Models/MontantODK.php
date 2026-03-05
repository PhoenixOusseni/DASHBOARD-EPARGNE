<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MontantODK extends Model
{
    protected $fillable = [
        'mois',
        'annee',
        'montant_odk',
    ];

    protected $casts = [
        'montant_odk' => 'integer',
        'mois'        => 'integer',
        'annee'       => 'integer',
    ];

    /**
     * Retourne le nom du mois en français
     */
    public function getNomMoisAttribute(): string
    {
        $mois = [
            1  => 'Janvier', 2  => 'Février',  3  => 'Mars',
            4  => 'Avril',   5  => 'Mai',       6  => 'Juin',
            7  => 'Juillet', 8  => 'Août',      9  => 'Septembre',
            10 => 'Octobre', 11 => 'Novembre',  12 => 'Décembre',
        ];

        return $mois[$this->mois] ?? '';
    }
}
