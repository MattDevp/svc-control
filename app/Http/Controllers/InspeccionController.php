<?php

namespace App\Http\Controllers;

use App\Models\Inspeccion;
use Illuminate\Http\Request;
use App\Exports\InspeccionesExport;
use App\Imports\InspeccionesImport;
use Maatwebsite\Excel\Facades\Excel;

class InspeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
    {
        $inspecciones = Inspeccion::query()
            ->when($request->q, function ($query, $q) {
                $query->where('contenedor', 'like', "%{$q}%")
                      ->orWhere('cliente', 'like', "%{$q}%");
            })
            ->orderByDesc('fecha_recepcion')
            ->orderByDesc('id')
            ->paginate(25)
            ->withQueryString();

        return view('inspecciones.index', compact('inspecciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('inspecciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Inspeccion::create($this->validar($request));

        return redirect()->route('inspecciones.index')
            ->with('ok', 'Inspección registrada.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Inspeccion $inspeccion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inspeccion $inspeccione)
    {
        //
        return view('inspecciones.edit', ['inspeccion' => $inspeccione]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inspeccion $inspeccione)
    {
        //
        $inspeccione->update($this->validar($request));

        return redirect()->route('inspecciones.index')
            ->with('ok', 'Inspección actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inspeccion $inspeccione)
    {
        //
        $inspeccione->delete();

        return redirect()->route('inspecciones.index')
            ->with('ok', 'Inspección eliminada.');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'cliente'          => 'required|string|max:255',
            'contenedor'       => 'required|string|max:20',
            'tipo'             => 'required|string|max:10',
            'servicio'         => 'required|string|max:255',
            'depot'            => 'required|string|max:255',
            'dano'             => 'required|numeric|min:0',
            'fecha_recepcion'  => 'nullable|date',
            'fecha_inspeccion' => 'nullable|date|after_or_equal:fecha_recepcion',
            'reporte_sv'       => 'nullable|date',
            'envio_cliente'    => 'nullable|date',
            'comentarios'      => 'nullable|string',
        ]);
    }

    public function exportar(Request $request)
{
    return Excel::download(
        new InspeccionesExport($request->q),
        'inspecciones_' . now()->format('Y-m-d') . '.xlsx'
    );
}

public function importar(Request $request)
{
    $request->validate([
        'archivo' => 'required|file|mimes:xlsx,xls,csv|max:10240',
    ]);

    $import = new InspeccionesImport();
    Excel::import($import, $request->file('archivo'));

    return redirect()->route('inspecciones.index')
        ->with('ok', "Importación lista: {$import->importados} registros procesados, {$import->omitidos} filas omitidas.");
}

}
