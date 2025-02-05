<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <style>
        body {
            margin: 0;
            --font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom, #003366, #005599);
            color: white;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #002244;
            padding: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            max-width: 1200px;
            width: 100%;
        }

        .logo img {
            height: 50px;
            margin-right: 2rem;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #FFCC00;
        }

        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem;
        }

        h1 {
            color: #FFCC00;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin-bottom: 1rem;
        }

        .contact-form {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 2rem;
            max-width: 600px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            width: 100%;
            color: black;
        }

        .contact-form form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .contact-form input,
        .contact-form textarea {
            padding: 0.8rem;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            outline: none;
            border-color: #003366;
            box-shadow: 0 0 8px rgba(0, 51, 102, 0.5);
        }

        .contact-form button {
            background-color: #003366;
            color: white;
            cursor: pointer;
            border: none;
            border-radius: 8px;
            padding: 0.8rem;
            font-size: 1rem;
            transition: background-color 0.3s, transform 0.2s;
        }

        .contact-form button:hover {
            background-color: #FFCC00;
            color: black;
            transform: scale(1.05);
        }

        footer {
            background-color: #002244;
            padding: 1rem;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <header class="main-header">
        <nav class="navbar">
            <div class="logo">
                <img src="assets/logo.jpg" alt="Logo">
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="courses.php">Cursos</a></li>
                <li><a href="diplomados.php">Diplomados</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>Contáctanos</h1>
        <div class="contact-form">
            <form action="php/enviar_contacto.php" method="post">
                <input type="text" name="nombre" placeholder="Nombre completo" required>
                <input type="email" name="email" placeholder="Correo electrónico" required>
                <textarea name="mensaje" placeholder="Escribe tu mensaje aquí" rows="5" required></textarea>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Your Company. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
