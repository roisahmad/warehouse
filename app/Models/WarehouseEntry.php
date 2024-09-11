<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseEntry extends Model
{
    use HasFactory;

    protected $table = 't_warehouse_entries';

    protected $fillable = ['purchase_order_id', 'supplier_id', 'status', 'arrival_date'];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function details()
    {
        return $this->hasMany(WarehouseEntryDetail::class);
    }

}
