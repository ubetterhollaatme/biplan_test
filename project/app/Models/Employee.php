<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static firstOrCreate(array $array, array $array1)
 */
class Employee extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'email';
    protected $fillable = [
        'org_id',
        'name',
        'email',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo('App\Models\Organization');
    }
}
