<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspeccion extends Model
{
    protected $table = 'inspecciones';

    protected $fillable = [
        'cliente', 'contenedor', 'tipo', 'servicio', 'depot', 'dano',
        'fecha_recepcion', 'fecha_inspeccion', 'reporte_sv',
        'envio_cliente', 'comentarios',
    ];

    protected $casts = [
        'fecha_recepcion'  => 'date',
        'fecha_inspeccion' => 'date',
        'reporte_sv'       => 'date',
        'envio_cliente'    => 'date',
    ];
}