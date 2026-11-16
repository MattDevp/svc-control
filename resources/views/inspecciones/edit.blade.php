@extends('inspecciones.layout')

@section('content')
<h1>Editar inspección</h1>
<form action="{{ route('inspecciones.update', $inspeccion) }}" method="POST">
    @csrf @method('PUT')
    @include('inspecciones._form')
</form>
@endsection