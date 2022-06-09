<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'company', 'location', 'website', 'email', 'description', 'tags', 'logo']; // mass assigment

  /**
   * Undocumented function
   *
   * @param Illuminate\Database\Eloquent\Builder $query
   * @param array $filters
   *
   * @return void
   */
  public function scopeFilter($query, array $filters) { // query scope https://laravel.com/docs/5.0/eloquent#query-scopes
    // dd($query);

    if($filters['tag'] ?? false) { // ?? null coalescing operator
      $query->where('tags', 'like', '%' . request('tag') . '%'); // search by tag
    }

    if($filters['search'] ?? false) {
      $query->where('title', 'like', '%' . request('search') . '%') // general search from index search input
        ->orWhere('description', 'like', '%' . request('search') . '%')
        ->orWhere('tags', 'like', '%' . request('search') . '%');
    }
  }

  // Relationship To User
  public function user() {
    return $this->belongsTo(User::class, 'user_id');
  }
}
