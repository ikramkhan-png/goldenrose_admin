<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientServiceBilling extends Model
{
    protected $fillable = [
        'client_service_id',
        'amount_billed',
        'amount_paid',
        'payment_date',
        'status',
        'invoice',
        'notes'
    ];

    public function clientService()
    {
        return $this->belongsTo(ClientService::class);
    }
}