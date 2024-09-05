<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhishListProduct extends Model
{
    use HasFactory;

    public function whishList()
    {
        return $this->belongsTo(WhishList::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
