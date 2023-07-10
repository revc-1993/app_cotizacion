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
        'unit_of_weight_measurement',
        'weight',
        'unit_of_length_measurement',
        'length',
        'width',
        'high',
        'containerized_cargo_type',
        'number_of_containers',
        'single_cargo_name',
        'registration_date',

        // foreign key
        'customer_id',
    ];

    /**
     * Get the User that owns the Commitment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
