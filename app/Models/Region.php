<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Region extends Model
{
    protected $fillable = ['nom'];

    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class);
    }

    public function rapportEpargnes(): HasManyThrough
    {
        return $this->hasManyThrough(RapportEpargne::class, Province::class);
    }
}
