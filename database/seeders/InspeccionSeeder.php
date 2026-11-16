<?php

namespace Database\Seeders;

use App\Models\Inspeccion;
use Illuminate\Database\Seeder;

class InspeccionSeeder extends Seeder
{
    public function run(): void
    {
        $base = [
            'cliente'          => 'S. CIMS',
            'tipo'             => '22K2',
            'servicio'         => 'TANK 2,5Y',
            'depot'            => 'TEPORVAL',
            'dano'             => 0,
            'fecha_recepcion'  => '2026-10-26',
            'fecha_inspeccion' => '2026-10-27',
            'reporte_sv'       => '2026-10-28',
            'envio_cliente'    => '2026-10-28',
        ];

        foreach (['FLNU5003614', 'BGBU5020142', 'CXTU1124279', 'CXTU1121545'] as $contenedor) {
            Inspeccion::create($base + ['contenedor' => $contenedor]);
        }
    }
}