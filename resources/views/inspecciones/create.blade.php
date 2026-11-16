@extends('inspecciones.layout')

@section('content')
<h1>Nueva inspección</h1>
<form action="{{ route('inspecciones.store') }}" method="POST">
    @csrf
    @include('inspecciones._form')
</form>
@endsection