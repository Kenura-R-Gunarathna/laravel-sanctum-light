<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slug extends Model
{
    use HasFactory;

    protected $table = 'slugs';

    protected $fillable = [ 'name' ];

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class, 'slug_id', 'id');
    }
}
