<?php

namespace App\Exports;

use App\Models\Inspeccion;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Database\Eloquent\Builder;

class InspeccionesExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public function __construct(private ?string $q = null) {}

    public function query(): Builder
    {
        return Inspeccion::query()
            ->when($this->q, function ($query, $q) {
                $query->where('contenedor', 'like', "%{$q}%")
                      ->orWhere('cliente', 'like', "%{$q}%");
            })
            ->latest('fecha_inspeccion');
    }

    public function headings(): array
    {
        return [
            'CLIENTE', 'Contenedor', 'Tipo', 'Servicio', 'Depot', 'Daño',
            'F. de Recepción', 'F. de inspección', 'Reporte a SV',
            'Envío a cliente', 'Comentarios',
        ];
    }

    public function map($i): array
    {
        return [
            $i->cliente,
            $i->contenedor,
            $i->tipo,
            $i->servicio,
            $i->depot,
            $i->dano,
            $i->fecha_recepcion?->format('d-m-Y'),
            $i->fecha_inspeccion?->format('d-m-Y'),
            $i->reporte_sv?->format('d-m-Y'),
            $i->envio_cliente?->format('d-m-Y'),
            $i->comentarios,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        // Encabezado amarillo y en negrita, como tu Excel
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'FFEB3B'],
                ],
            ],
        ];
    }
}