<?php

namespace App;

use App\Repositories\ShamsiTrait;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use ShamsiTrait;
    protected $table='articles';

    protected $fillable=['title','content','image','published','active','num_comment',
        'num_visit','num_like','num_dislike','sub_category_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }

    public function comments(){
        return $this->morphMany('App\Comment','parentable');
    }

    public function category(){
        return $this->belongsTo('App\Category','sub_category_id');
    }


}
