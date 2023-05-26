<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type_of_transport',
        'product',
        'cargo_type',
        'weight',
        'unit_of_weight_measurement',
        'length',
        'unit_of_length_measurement',
        'containerized_cargo_type',
        'number_of_containers',
        'single_cargo_name',
        'registration_date',
    ];
}
