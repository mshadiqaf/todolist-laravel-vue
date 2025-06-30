<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'due_date',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    public function getIsDoneAttribute() {
        return $this->status === 'done';
    }
}
