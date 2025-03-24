<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessInventoryMetricsPrices extends Model
{
    use HasFactory;

    protected $table = "business_inventory_metric_prices";
}
