<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSdr-1bVaRWRDsiiJYizyKcapHgaeTpGQ"></script>
    <title>Bienvenidos a KDT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --main-color:rgb(173, 175, 76);
            --accent-color: #f0f0f0;
            --text-color: #333;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom right, #e9f5ee,rgb(240, 233, 146));
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        header {
            text-align: center;
            margin-bottom: 2rem;
        }

        h1 {
            font-size: 3rem;
            color: var(--main-color);
        }

        p {
            font-size: 1.2rem;
            margin-top: 1rem;
        }

        .btn {
            margin-top: 2rem;
            padding: 0.8rem 1.5rem;
            background-color: var(--main-color);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color:rgb(196, 193, 70);
        }

        footer {
            position: absolute;
            bottom: 20px;
            font-size: 0.9rem;
            color: #888;
        }
    </style>
</head>
<body>
    <header>
        <h1>¡Bienvenido!</h1>
        <p>Esta es la página de inicio de KDT . 🎉</p></BR> </BR>
        <a href="{{ url('/dashboard') }}" class="btn">Iniciar sesión</a>
    </header>

    <footer>
        Desarrollado con ❤️ FEDE LUNA ELI
    </footer>
</body>
</html>
