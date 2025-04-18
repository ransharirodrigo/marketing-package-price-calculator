<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $table = "invoices";

    protected $fillable = [
        'name',
        'address',
        'mobile',
        'email',
        'invoice_number',
        'status',
    ];


    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItems::class, 'invoice_number', 'invoice_number');
    }
}
