<?php

namespace Plugin\CartLooksCore\Models;

use Illuminate\Database\Eloquent\Model;
use Plugin\CartLooksCore\Models\Customers;
use Plugin\CartLooksCore\Models\GuestCustomers;

class PaymentTransaction extends Model
{
    protected $table = "tl_com_payment_transactions";

    public function customer_info()
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }
    public function guest_customer_info()
    {
        return $this->belongsTo(GuestCustomers::class, 'guest_customer', 'id');
    }
}
