@php
    $campos = [
        'cliente' => ['Cliente', 'text'],
        'contenedor' => ['Contenedor', 'text'],
        'tipo' => ['Tipo', 'text'],
        'servicio' => ['Servicio', 'text'],
        'depot' => ['Depot', 'text'],
        'dano' => ['Daño', 'number'],
        'fecha_recepcion' => ['F. de recepción', 'date'],
        'fecha_inspeccion' => ['F. de inspección', 'date'],
        'reporte_sv' => ['Reporte a SV', 'date'],
        'envio_cliente' => ['Envío a cliente', 'date'],
    ];
@endphp

<div class="grid">
    @foreach ($campos as $name => [$label, $type])
        <div>
            <label for="{{ $name }}">{{ $label }}</label>
            <input id="{{ $name }}" type="{{ $type }}" name="{{ $name }}"
                     @if ($type === 'number') step="0.01" min="0" @endif
                   value="{{ old($name, isset($inspeccion) ? ($type === 'date' ? $inspeccion->$name?->format('Y-m-d') : $inspeccion->$name) : ($name === 'dano' ? 0 : '')) }}">
            @error($name) <div class="error">{{ $message }}</div> @enderror
        </div>
    @endforeach
</div>

<div style="margin-top:1rem;">
    <label for="comentarios">Comentarios</label>
    <textarea id="comentarios" name="comentarios" rows="3">{{ old('comentarios', $inspeccion->comentarios ?? '') }}</textarea>
    @error('comentarios') <div class="error">{{ $message }}</div> @enderror
</div>

<div style="margin-top:1rem;">
    <button class="btn">Guardar</button>
    <a href="{{ route('inspecciones.index') }}" class="btn btn-gray">Cancelar</a>
</div>