<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResellerDeal extends Model
{
    public function reseller_deal_products()
    {
        return $this->hasMany(ResellerDealProduct::class);
    }
}
