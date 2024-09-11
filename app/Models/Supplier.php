<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'm_suppliers';

    protected $fillable = ['name', 'contact', 'address'];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
