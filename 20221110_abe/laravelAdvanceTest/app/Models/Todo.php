<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $fillable = ['todo_value','users_id','tags_id'];
    protected $guarded = ['id'];

    public function Tag(){
        return $this->belongsTo('App\Models\Tag');
    }

}
