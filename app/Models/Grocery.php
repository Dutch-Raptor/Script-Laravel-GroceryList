<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grocery extends Model {
    use HasFactory;

    // add fillable property to allow mass assignment
    protected $fillable = [
        'name',
        'price',
        'quantity',
        'category_id',
        'purchased',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }


    public function scopeFilter($query) {
        if (request('category')) {
            $query->where('category_id', "like", request('category'));
        }
        if (request('purchased')) {
            $query->where('purchased', request('purchased'));
        }
    }
}
