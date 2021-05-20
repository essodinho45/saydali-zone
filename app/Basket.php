<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $fillable = [
        'price', 'user_id', 'remark', 'from_date', 'to_date'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function items()
    {
        return $this->belongsToMany(Item::class,'basket_item')->withTimestamps()->withPivot('quantity');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class,'basket_order')->withTimestamps()->withPivot('quantity');
    }
}