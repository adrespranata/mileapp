<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentLocation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
