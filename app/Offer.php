<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    //
    protected $fillable = [
        'user_id', 'item_id', 'remark', 'discount', 'free_quant', 'free_item', 'from_date', 'to_date'
    ];
    protected $appends = ['free_item_name'];
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function freeItem()
    {
        return $this->hasOne(Item::class, 'id', 'free_item');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getFreeItemNameAttribute()
    {
        if($this->item_id != $this->free_item)
            return $this->freeItem->name;
        return '';
    }
}
