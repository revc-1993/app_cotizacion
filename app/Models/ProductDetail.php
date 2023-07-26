<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cargo_name',
        'amount_of_charge',
        'unit_of_weight_measurement',
        'weight',
        'unit_of_length_measurement',
        'length',
        'width',
        'high',
        'volumen',
        'weight_calculated',

        // foreign key
        'quote_id',
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quote()
    {
        return $this->belongsTo(Quote::class, 'quote_id');
    }
}
