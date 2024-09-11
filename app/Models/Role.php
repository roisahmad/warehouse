<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'm_roles';

    protected $fillable = ['name', 'level'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
