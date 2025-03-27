<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Barbería Torus</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        body {
            background-color: #1A202C;
            color: #E2E8F0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-container {
            background-color: #2D3748;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            max-width: 400px;
            width: 100%;
            min-height: auto;
        }

        .logo {
            text-align: center;
            margin-bottom: 0.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo img {
            max-width: 150px;
            margin-bottom: 1rem;
            border-radius: 50%;
            align-self: center;
        }

        .input-field {
            background-color: #4A5568;
            border-radius: 0.5rem;
            padding: 0.6rem 1rem;
            border: none;
            color: #E2E8F0;
            width: 100%;
            margin-bottom: 1rem;
        }

        .input-field:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.5);
        }

        .btn-primary {
            background-color: #D2A679;
            color: #2D3748;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            width: 100%;
            text-align: center;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #B48E67;
        }

        .login-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .login-link a {
            color: #D2A679;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex flex-col justify-center items-center">
        <div class="register-container">
            <div class="logo">
                <img src="{{ asset('img/logo2.png') }}" alt="Logo de Barbería Torus">
                <h2 class="text-2xl font-semibold mb-4">Barbería Torus</h2>
            </div>

            <form method="POST" action="{{ route('register') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <div>
                    <input id="name" class="input-field" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Nombre">
                    @if($errors->has('name'))
                        <span class="text-red-500 text-sm mt-2">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                
                <div>
                    <input id="email" class="input-field" type="email" name="email" value="{{ old('email') }}" required placeholder="Correo">
                    @if($errors->has('email'))
                        <span class="text-red-500 text-sm mt-2">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                
                <div>
                    <input id="password" class="input-field" type="password" name="password" required placeholder="Contraseña">
                    @if($errors->has('password'))
                        <span class="text-red-500 text-sm mt-2">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                
                <div>
                    <input id="password_confirmation" class="input-field" type="password" name="password_confirmation" required placeholder="Confirmar Contraseña">
                    @if($errors->has('password_confirmation'))
                        <span class="text-red-500 text-sm mt-2">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn-primary">Registrarse</button>
                </div>

                <div class="login-link">
                    <a href="{{ route('login') }}">¿Ya tienes una cuenta? Iniciar sesión</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
