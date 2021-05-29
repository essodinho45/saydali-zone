<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Item extends Model
{
    protected $fillable = [
        'barcode', 'name', 'user_id', 'composition', 'dosage', 'descr1', 'descr2', 'price',
        'customer_price', 'titer', 'item_type_id', 'item_category_id', 'image'
    ];
    //
    public function catergory()
    {
        return $this->belongsTo(ItemCategory::class, 'item_category_id');
    }
    public function type()
    {
        return $this->belongsTo(ItemType::class, 'item_type_id');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class,'order_item')
        ->withPivot('verified_at')
        ->withTimestamps();
    }
    public function freezedByUsers()
    {
        return $this->belongsToMany(User::class,'item_user')
        ->withPivot('freezed')
        ->withTimestamps();
    }
    public function baskets()
    {
        return $this->belongsToMany(Basket::class,'basket_item')->withTimestamps();
    }
    public function company()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    public function quantities()
    {
        return $this->hasMany(Quantity::class);
    }
    public function isFreezedByUser($user_id)
    {
        return (bool)(DB::table('item_user')->where(['user_id'=> $user_id, 'item_id'=>$this->id])->value('freezed'));
    }
}
