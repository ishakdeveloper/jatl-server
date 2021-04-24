<?php

namespace App\Models;

use App\Models\User;
use App\Models\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = ['collection_id', 'user_id', 'title', 'description'];

    public function collection() {
        return $this->belongsTo(Collection::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
