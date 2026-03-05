<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RapportEpargne extends Model
{
    protected $fillable = [
        'province_id',
        'mois',
        'annee',
        'montant_warehouse',
        'montant_cahier',
        'montant_caisse',
        'rapports_g50',
    ];

    protected $casts = [
        'montant_warehouse' => 'integer',
        'montant_cahier'    => 'integer',
        'montant_caisse'   => 'integer',
        'rapports_g50'      => 'integer',
        'mois'              => 'integer',
        'annee'             => 'integer',
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Écart Cahier = montant_cahier - montant_warehouse
     */
    public function getEcartAttribute(): int
    {
        return $this->montant_cahier - $this->montant_warehouse;
    }

    /**
     * Écart Caisse = montant_caisse - montant_warehouse
     */
    public function getEcartCaisseWarehouseAttribute(): int
    {
        return ($this->montant_caisse ?? 0) - $this->montant_warehouse;
    }

    /**
     * Écart ODK = montant_odk - montant_warehouse
     */
    public function getEcartOdkWarehouseAttribute(): int
    {
        // ODK est maintenant dans une table séparée MontantODK
        return 0;
    }

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
