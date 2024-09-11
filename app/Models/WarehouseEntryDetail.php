<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseEntryDetail extends Model
{
    use HasFactory;

    protected $table = 't_warehouse_entry_details';

    protected $fillable = ['warehouse_entry_id', 'material_id', 'quantity', 'condition', 'unique_code'];

    public function warehouseEntry()
    {
        return $this->belongsTo(WarehouseEntry::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

}
