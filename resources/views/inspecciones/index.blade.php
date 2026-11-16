@extends('inspecciones.layout')

@section('content')
<h1>Control de Inspección</h1>

<div style="display:flex; gap:1rem; align-items:center; margin-bottom:1rem; flex-wrap:wrap;">
    <form action="{{ route('inspecciones.importar') }}" method="POST" enctype="multipart/form-data"
          style="display:flex; gap:.5rem; align-items:center;">
        @csrf
        <input type="file" name="archivo" accept=".xlsx,.xls,.csv" required style="width:auto;">
        <button class="btn">Importar Excel</button>
    </form>

    <a href="{{ route('inspecciones.exportar', ['q' => request('q')]) }}" class="btn btn-gray">
        Exportar Excel
    </a>
</div>

@error('archivo') <div class="error">{{ $message }}</div> @enderror

<form method="GET" style="margin-bottom:1rem; display:flex; gap:.5rem;">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar contenedor o cliente">
    <button class="btn">Buscar</button>
    <a href="{{ route('inspecciones.create') }}" class="btn btn-gray" style="white-space:nowrap;">+ Nueva</a>
</form>

<table>
    <thead>
        <tr>
            <th>Cliente</th>
            <th>Contenedor</th>
            <th>Tipo</th>
            <th>Servicio</th>
            <th>Depot</th>
            <th>Daño</th>
            <th>F. Recepción</th>
            <th>F. Inspección</th>
            <th>Reporte a SV</th>
            <th>Envío a cliente</th>
            <th>Comentarios</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($inspecciones as $i)
            <tr>
                <td>{{ $i->cliente }}</td>
                <td>{{ $i->contenedor }}</td>
                <td>{{ $i->tipo }}</td>
                <td>{{ $i->servicio }}</td>
                <td>{{ $i->depot }}</td>
                <td>{{ $i->dano }}</td>
                <td>{{ $i->fecha_recepcion?->format('d-m-Y') }}</td>
                <td>{{ $i->fecha_inspeccion?->format('d-m-Y') }}</td>
                <td>{{ $i->reporte_sv?->format('d-m-Y') }}</td>
                <td>{{ $i->envio_cliente?->format('d-m-Y') }}</td>
                <td>{{ $i->comentarios }}</td>
                <td style="white-space:nowrap;">
                    <a href="{{ route('inspecciones.edit', $i) }}">Editar</a>
                    <form action="{{ route('inspecciones.destroy', $i) }}" method="POST" style="display:inline"
                          onsubmit="return confirm('¿Eliminar esta inspección?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-red" style="padding:.2rem .5rem;">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="12">No hay inspecciones registradas.</td></tr>
        @endforelse
    </tbody>
</table>

<div style="margin-top:1rem;">{{ $inspecciones->links() }}</div>
@endsection