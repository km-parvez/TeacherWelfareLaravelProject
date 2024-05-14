<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * Get all of the deposites fnk
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deposites()
    {
        return $this->hasMany(Deposite::class);
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
