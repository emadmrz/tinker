<?php

namespace App;

use Baum\Node;
use Illuminate\Database\Eloquent\Model;

class Category extends Node
{
    protected $table='categories';

    protected $fillable=['name'];

    public function courses(){
        return $this->hasMany('App\Course','sub_category_id','id');
    }

    public function articles(){
        return $this->hasMany('App\Article','sub_category_id','id');
    }

}
