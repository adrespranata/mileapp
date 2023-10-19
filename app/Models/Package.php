<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customerAttribute()
    {
        return $this->hasOne(CustomerAttribute::class);
    }

    public function connote()
    {
        return $this->hasOne(Connote::class);
    }

    public function originData()
    {
        return $this->hasOne(OriginData::class);
    }

    public function destinationData()
    {
        return $this->hasOne(DestinationData::class);
    }

    public function koliData()
    {
        return $this->hasMany(KoliData::class);
    }

    public function customField()
    {
        return $this->hasOne(CustomField::class);
    }

    public function currentLocation()
    {
        return $this->hasOne(CurrentLocation::class);
    }
}
