<?php
/**
 * Created by PhpStorm.
 * User: Ahmad
 * Date: 2/1/2016
 * Time: 3:15 AM
 */

namespace App\Repositories;


use Morilog\Jalali\jDate;

trait ShamsiTrait
{
    public function getShamsiCreatedAtAttribute(){
        return jDate::forge($this->attribute['created_at'])->format('Y/m/d');
    }

    public function getShamsiUpdatedAtAttribute(){
        return jDate::forge($this->attribute['updated_at'])->format('Y/m/d');
    }

    public function getHumanShamsiCreatedAtAttribute(){
        return jDate::forge($this->attributes['created_at'])->ago();
    }

    public function getHumanShamsiUpdatedAtAttribute(){
        return jDate::forge($this->attributes['updated_at'])->ago();
    }
}