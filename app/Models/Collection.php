<?php

namespace App\Models;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'picture'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function todos() {
        return $this->hasMany(Todo::class);
    }
}
