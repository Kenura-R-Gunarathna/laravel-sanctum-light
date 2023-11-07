<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Institution extends Model
{
    use HasFactory;

    protected $table = 'institutions';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(Account::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->using(Account::class);
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class, /* uuid of the accounts table */'id', 'id');
    }

    public function fields(): MorphToMany
    {
        return $this->morphToMany(Field::class, 'fieldable');
    }
}
