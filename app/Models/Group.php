<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';

    protected $fillable = ['name'];

    public function children(): HasMany
    {
        return $this->hasMany(Group::class, 'parent_id', 'id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'parent_id', 'id');
    }

    public function fields(): MorphToMany
    {
        return $this->morphToMany(Field::class, 'fieldable');
    }
}
