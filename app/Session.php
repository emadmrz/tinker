<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table='sessions';

    protected $fillable=[
        'title','description','file','active','user_id','level',
        'course_id','capacity','duration','level','num_like','num_dislike','num_comment'
    ];

    public function course(){
        return $this->belongsTo('App\Course');
    }

    public function attachments(){
        return $this->morphMany('App\Attachment','parentable');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
