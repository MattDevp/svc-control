<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingreso | Control de Inspección</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: system-ui, sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            color: #222;
        }
        .card {
            background: #fff;
            width: 100%;
            max-width: 380px;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .1);
        }
        h1 { margin: 0 0 .25rem; font-size: 1.5rem; }
        p.sub { margin: 0 0 1.5rem; color: #666; font-size: .9rem; }
        label { display: block; font-weight: 600; margin-bottom: .25rem; font-size: .9rem; }
        input[type=email], input[type=password] {
            width: 100%;
            padding: .6rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
            margin-bottom: 1rem;
        }
        input:focus { outline: 2px solid #1a73e8; border-color: transparent; }
        .remember { display: flex; align-items: center; gap: .5rem; margin-bottom: 1.25rem; font-size: .9rem; }
        .remember input { margin: 0; }
        button {
            width: 100%;
            padding: .7rem;
            border: 0;
            border-radius: 6px;
            background: #1a73e8;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
        }
        button:hover { background: #1558b0; }
        .error { color: #b00020; font-size: .85rem; margin: -.5rem 0 1rem; }
        .aviso { background: #e6f4ea; padding: .6rem; border-radius: 6px; margin-bottom: 1rem; font-size: .9rem; }
        a.enlace { display: block; text-align: center; margin-top: 1rem; color: #1a73e8; font-size: .9rem; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Control de Inspección</h1>

        @auth
            <p class="sub">Ya iniciaste sesión como {{ auth()->user()->name }}.</p>
            <a href="{{ route('inspecciones.index') }}" class="enlace" style="margin-top:0;">Ir al sistema</a>
        @else
            <p class="sub">Ingresa con tu correo y contraseña.</p>

            @if (session('status'))
                <div class="aviso">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <label for="email">Correo</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus autocomplete="email">
                @error('email') <div class="error">{{ $message }}</div> @enderror

                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password"
                       required autocomplete="current-password">
                @error('password') <div class="error">{{ $message }}</div> @enderror

                <label class="remember">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                    Recordarme
                </label>

                <button type="submit">Ingresar</button>
            </form>
        @endauth
    </div>
</body>
</html>
