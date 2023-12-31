<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'precio',
        'stock',
        'categoria',
        'tags',
        'descripcion',
        'informacion',
        'valoracion',
        'sku',
        'url_imagen',
    ];

}
