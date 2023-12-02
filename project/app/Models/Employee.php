<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;

    protected $primaryKey = 'email';
    protected $fillable = [
        'org_id',
        'name',
        'email',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }
}
