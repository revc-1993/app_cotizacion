<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public function quotes()
    {
        return $this->hasMany(Quote::class); // Cambia a hasMany si es una relación uno a muchos
    }
}
