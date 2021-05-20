<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'sender_id', 'reciever_id', 'remark', 'reciever_remark', 'price', 'free_quant'
    ];
    protected $dates = ['verified_at'];
    //
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function reciever()
    {
        return $this->belongsTo(User::class, 'reciever_id');
    }
    public function items()
    {
        return $this->belongsToMany(Item::class,'order_item')
        ->withPivot('verified_at','price','quantity','free_quant', 'sender_remark', 'reciever_remark')
        ->withTimestamps();
    }
    public function baskets()
    {
        return $this->belongsToMany(Basket::class,'basket_order')
        ->withPivot('verified_at','quantity')        
        ->withTimestamps();
    }
}
