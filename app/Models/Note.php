<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['Title', 'Description', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shared()
    {
        return $this->belongsToMany(User::class, 'note_user');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
