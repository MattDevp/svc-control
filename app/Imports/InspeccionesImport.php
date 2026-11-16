<?php

namespace App\Imports;

use App\Models\Inspeccion;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class InspeccionesImport implements ToCollection, WithStartRow
{
    public int $importados = 0;
    public int $omitidos = 0;

    public function startRow(): int
    {
        return 2; // salta la fila de encabezados
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $contenedor = strtoupper(trim((string) ($row[1] ?? '')));

            if ($contenedor === '') {
                $this->omitidos++;
                continue;
            }

            Inspeccion::updateOrCreate(
                [
                    'contenedor'      => $contenedor,
                    'fecha_recepcion' => $this->fecha($row[6] ?? null),
                ],
                [
                    'cliente'          => trim((string) ($row[0] ?? '')),
                    'tipo'             => trim((string) ($row[2] ?? '')),
                    'servicio'         => trim((string) ($row[3] ?? '')),
                    'depot'            => trim((string) ($row[4] ?? '')),
                    'dano'             => (int) ($row[5] ?? 0),
                    'fecha_inspeccion' => $this->fecha($row[7] ?? null),
                    'reporte_sv'       => $this->fecha($row[8] ?? null),
                    'envio_cliente'    => $this->fecha($row[9] ?? null),
                    'comentarios'      => $row[10] ?? null,
                ]
            );

            $this->importados++;
        }
    }

    private function fecha($valor): ?string
    {
        if ($valor === null || $valor === '') {
            return null;
        }

        try {
            // Excel guarda las fechas como número de serie
            if (is_numeric($valor)) {
                return Date::excelToDateTimeObject($valor)->format('Y-m-d');
            }

            // Texto tipo 26-10-2026
            return Carbon::createFromFormat('d-m-Y', trim($valor))->format('Y-m-d');
        } catch (\Throwable $e) {
            return null;
        }
    }
}