<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [ 'name' ];

    public function slug(): BelongsTo
    {
        return $this->belongsTo(Slug::class, 'slug_id', 'id');
    }

    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'role_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(Account::class);
    }

    public function institutions(): BelongsToMany
    {
        return $this->belongsToMany(Institution::class)->using(Account::class);
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class, /* uuid of the accounts table */'id', 'id');
    }
}
