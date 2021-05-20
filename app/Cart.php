<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'sender_id', 'reciever_id', 'item_id', 'remark', 'quantity', 'price', 'is_basket'
    ];
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function reciever()
    {
        return $this->belongsTo(User::class, 'reciever_id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
