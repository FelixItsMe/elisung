<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mesin extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mesin';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get all of the spesifikasi for the Mesin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spesifikasi(): HasMany
    {
        return $this->hasMany(SpesifikasiMesin::class, 'mesin_id');
    }
}
