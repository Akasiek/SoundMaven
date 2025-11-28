<?php

namespace App\Models\Abstract;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

abstract class Review extends Model
{
    use BlameableTrait, HasFactory, HasUuids;

    protected $perPage = 25;

    protected $fillable = [
        'rating',
        'body',
    ];
}
