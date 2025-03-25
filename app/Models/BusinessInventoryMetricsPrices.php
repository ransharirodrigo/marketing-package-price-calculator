<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessInventoryMetricsPrices extends Model
{
    use HasFactory;

    protected $table = "business_inventory_metric_prices";

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function inventory(): BelongsTo
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function metrics(): BelongsTo
    {
        return $this->belongsTo(Metrics::class, 'metrics_id');
    }
}
