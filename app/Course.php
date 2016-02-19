<?php

namespace App;

use App\Repositories\ShamsiTrait;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use ShamsiTrait;
    protected $table='courses';

    protected $fillable=[
        'user_id',
        'name',
        'description',
        'price',
        'image',
        'num_student',
        'num_dislike',
        'num_like',
        'num_comment',
        'active',
        'sub_category_id'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    public function sessions(){
        return $this->hasMany('App\Session');
    }

    public function comments(){
        return $this->morphMany('App\Comment','parentable');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

}
