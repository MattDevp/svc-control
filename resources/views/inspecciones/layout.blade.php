<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Control de Inspección</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 2rem; color: #222; }
        table { border-collapse: collapse; width: 100%; font-size: .9rem; }
        th { background: #ffeb3b; text-align: left; }
        th, td { border: 1px solid #ccc; padding: .4rem .6rem; }
        .ok { background: #e6f4ea; padding: .6rem; margin-bottom: 1rem; }
        .error { color: #b00020; font-size: .85rem; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; }
        label { display: block; font-weight: 600; margin-bottom: .2rem; }
        input, textarea { width: 100%; padding: .4rem; box-sizing: border-box; }
        .btn { padding: .5rem 1rem; border: 0; background: #1a73e8; color: #fff; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-red { background: #d93025; }
        .btn-gray { background: #666; }
        nav[role=navigation] svg { width: 2rem; height: 2rem; }

    </style>
</head>
<body>
    @if (session('ok'))
        <div class="ok">{{ session('ok') }}</div>
    @endif

    @auth
        <form method="POST" action="{{ route('logout') }}" style="text-align:right; margin-bottom:1rem;">
            @csrf
            <span style="margin-right:.5rem;">{{ auth()->user()->name }}</span>
            <button class="btn btn-gray" style="padding:.3rem .8rem;">Cerrar sesión</button>
        </form>
    @endauth

    @yield('content')
</body>
</html>