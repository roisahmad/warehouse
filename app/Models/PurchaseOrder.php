<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $table = 't_purchase_orders';

    protected $fillable = ['user_id', 'supplier_id', 'status', 'approved_by', 'received_date', 'total_price', 'total_quantity'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function details()
    {
        return $this->hasMany(PurchaseOrderDetail::class);
    }

    public function warehouseEntries()
    {
        return $this->hasMany(WarehouseEntry::class);
    }
}
