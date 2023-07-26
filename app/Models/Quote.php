<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type_of_transport',
        'cargo_type',
        'containerized_cargo_type',
        'incoterm',
        'registration_date',

        'subtotal_12',
        'subtotal_0',
        'iva',
        'total',

        'international_freight_information',
        'additional_information',
        'transit_time',
        'quote_validity',

        // foreign key
        'customer_id',
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class, 'quote_id');
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function serviceDetails()
    {
        return $this->hasMany(ServiceDetail::class, 'quote_id');
    }
}
