<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InProcess extends Model
{
    use HasFactory;

    public function completed() {
        return $this->hasMany(Completed::class);
    }

    protected $fillable = [
        'responsible',
        'tasks_id'
    ];
}
