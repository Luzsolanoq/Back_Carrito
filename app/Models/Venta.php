<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'ventas';
    protected $primaryKey = 'venta_id';
    public $timestamps = false;
    protected $fillable = ['cliente_id', 'total'];

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class);
    }
}