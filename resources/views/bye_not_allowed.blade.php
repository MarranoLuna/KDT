<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .logo {
            width: 7rem;
            position:absolute;
            top:10rem;
            left:20rem;
        }

        .forbidden_img {
            width: 40%;
        }

        body {
            width: 99%;
            text-align: center;
            max-width: 100%;
            max-height: 100%;
            font-family: Arial, Helvetica, sans-serif;
            pointer-events: none;
            user-select: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div>
            <img src="{{ asset('img/logo_kdt.png') }}" class="logo">
            <h1>Solo los administradores pueden entrar a este sitio</h1>
            <h2>Puedes descargar la app para solicitar un cadete o registrarte para comenzar a completar pedidos!</h2>
        </div>

        <img src="{{ asset('img/forbidden.png') }}" class="forbidden_img">
    </div>

</body>

</html>