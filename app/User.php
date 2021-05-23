<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'f_name', 's_name', 'commercial_name', 'username', 'email', 'user_category_id', 'licence_number', 'password',
        'country', 'city', 'region', 'address', 'tel1', 'tel2', 'mob1', 'mob2', 'fax1', 'fax2', 'email2', 'logo_image', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(UserCategory::class, 'user_category_id');
    }
    public function itsCity()
    {
        return $this->belongsTo(City::class, 'city');
    }
    public function itsCountry()
    {
        return $this->belongsTo(Country::class, 'country');
    }
    public function children()
    {
        return $this->belongsToMany(User::class, 'user_relations', 'parent_id', 'child_id')
        ->withPivot(['comp_id','verified','freezed'])
        ->withTimestamps();
    }
    public function parents()
    {
        return $this->belongsToMany(User::class, 'user_relations', 'child_id', 'parent_id')
        ->withPivot(['comp_id','verified','freezed'])
        ->withTimestamps();
    }
    public function freezedItems()
    {
        return $this->belongsToMany(Item::class,'item_user')
        ->withPivot('freezed')
        ->withTimestamps();
    }
    public function ordersFromUser()
    {
        return $this->hasMany(Order::class, 'sender_id');
    }
    public function ordersToUser()
    {
        return $this->hasMany(Order::class, 'reciever_id');
    }
    public function cartsFromUser()
    {
        return $this->hasMany(Cart::class, 'sender_id');
    }
    public function cartsToUser()
    {
        return $this->hasMany(Cart::class, 'reciever_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function items()
    {
        return $this->hasMany(Item::class);
    }
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    public function quantities()
    {
        return $this->hasMany(Quantity::class);
    }
    public function baskets()
    {
        return $this->hasMany(Basket::class);
    }
    public function generate_token()
    {
        $this->api_token = Str::random(60);
        $this->save();

        return $this->api_token;
    }
}
