<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Contoh: Reguler, Unggulan
        'fee',  // Nominal SPP
    ];

    // Satu program bisa dimiliki banyak siswa
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
