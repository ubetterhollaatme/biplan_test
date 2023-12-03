<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static firstOrCreate(array $array)
 */
class Organization extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function employees(): HasMany
    {
        return $this->hasMany('App\Models\Employee');
    }
}
