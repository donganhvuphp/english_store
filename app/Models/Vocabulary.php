<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vocabulary extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vocabulary';

    protected $fillable = [
        'text',
        'translate',
        'spelling',
        'pronounce'
    ];
}
