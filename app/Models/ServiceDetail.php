<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type_of_service',
        'amount_of_service',
        'service',
        'pvp_provider',
        'utility',
        'utility_usd',
        'subtotal',
        'quote_id'
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
