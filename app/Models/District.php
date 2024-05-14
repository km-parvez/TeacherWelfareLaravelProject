<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * Get all of the subDistricts for the District
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subDistricts()
    {
        return $this->hasMany(SubDistrict::class);
    }
}
