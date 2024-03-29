<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'company', 'location', 'email', 'website', 'tags','description', 'logo', 'user_id' ];

    public function scopefilter($query, array $filters){
        // dd($filters);
        if($filters['tag'] ?? false){
            // request() method is global
            $query->where('tags', 'like', '%' . request('tag'). '%'); 
        }

        if($filters['search'] ?? false) {
            $query->where('title', 'like', '%' . request('search'). '%')
            ->orWhere('description', 'like', '%' . request('search'). '%')
            ->orWhere('tags', 'like', '%' . request('search'). '%');
        }
    }


    // User Relationship
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}