<?php

namespace App\Models\Abstract;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

abstract class Review extends Model
{
    use SoftDeletes, HasFactory, HasUuids, BlameableTrait;

    protected $fillable = [
        'rating',
        'body',
    ];
}
