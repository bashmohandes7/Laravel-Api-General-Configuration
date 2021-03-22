<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name_ar', 'name_en', 'created_at', 'updated_at' , 'active'];
    public function scopeSelection($q){
        return $q->select('id', 'name_'.app()->getLocale(). ' as name')->get();
    }
}
