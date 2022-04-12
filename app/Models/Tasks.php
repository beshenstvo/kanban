<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    public function inprocess() {
        return $this->hasMany(InProcess::class);
    }

    use HasFactory;
    protected $fillable = [
        'taskName',
        'description',
        'deadline',
        'user_id'
    ];
}
