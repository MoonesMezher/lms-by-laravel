<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'age'
    ];

    public function books() {
        return $this->belongsToMany(Book::class, 'author_book', 'author_id', 'book_id');
    }

    public function reviews() {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
