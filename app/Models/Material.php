<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'm_materials';

    protected $fillable = ['name', 'code', 'supplier_id', 'stock', 'condition', 'price'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
