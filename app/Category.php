<?php

namespace App;

use Baum\Node;
use Illuminate\Database\Eloquent\Model;

class Category extends Node
{
    protected $table='categories';

    protected $fillable=['name'];
}
