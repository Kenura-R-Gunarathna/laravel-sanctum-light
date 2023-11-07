<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fieldable extends Model
{
    use HasFactory;

    protected $table = 'fieldables';

    protected $fillable = ['fieldable_id', 'fieldable_type'];
}
