<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItems extends Model
{
    protected $fillable = [
        'business_id',
        'inventory_id',
        'metrics_id',
        'qty',
        'invoice_number',
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class);
    }


    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class);
    }

   
    public function metric(): BelongsTo
    {
        return $this->belongsTo(Metrics::class, 'metrics_id'); 
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_number', 'invoice_number');
    }

}
