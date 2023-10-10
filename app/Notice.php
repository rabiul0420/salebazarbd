<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notice';
	protected $fillable = [
        'id','title', 'content','user_id', 'notice_show','only_seller','only_customer','created_at', 'updated_at'
    ];
   
}