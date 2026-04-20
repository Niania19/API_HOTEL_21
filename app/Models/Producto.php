<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre',
        'precio',
        'stock',
        'imagen'
    ];

    // Para que siempre se incluya imagen_url en la respuesta JSON
    protected $appends = ['imagen_url'];

    public function getImagenUrlAttribute()
    {
        // Como en la BD guardamos "productos/archivo.png", aquí construimos la URL completa
        return $this->imagen ? asset('storage/' . $this->imagen) : null;
    }
}
