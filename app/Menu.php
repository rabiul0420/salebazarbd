<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
	protected $fillable = [
        'name', 'commision_rate','parent_id', 'banner', 'icon', 'featured', 'top', 'digital', 'slug', 'meta_title', 'meta_description', 'sort_n'
    ];
   
}