<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'banner', 'stock', 'price', 'discount', 'publish', 'slug'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    //category
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    //gallery
    public function gallery()
    {
        return $this->hasMany('App\Gallery');
    }
}
