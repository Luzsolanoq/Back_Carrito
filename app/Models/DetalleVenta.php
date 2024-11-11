<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;
    protected $table = 'detalle_ventas';
    protected $primaryKey = 'detalleventa_id';
    public $timestamps = false;
    protected $fillable = ['venta_id', 'idproducto', 'descripcion', 'precio', 'cantidad'];

    public function venta()
    {
        return $this->belongsTo(Venta::class,'venta_id');
    }
}