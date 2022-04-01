<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'responsible',
        'tasks_id'
    ];
}
