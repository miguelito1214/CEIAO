<?php
session_start(); // Inicia la sesión

// Verifica si el usuario está logueado
$is_logged_in = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venta de Cursos - CEIAO</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Incluye Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<!-- Incluye Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Agregar Font Awesome para los iconos de redes sociales -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Cargar TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0f4c75] text-white font-sans">

   <!-- Header -->
<header class="main-header">
    <nav class="navbar">
        <div class="logo">
            <img src="assets/logo.jpg" alt="CEIAO Logo">
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="courses.php">Cursos</a></li>
            <li><a href="diplomados.php">Diplomados</a></li>
            <li><a href="contacto.php">Contacto</a></li>
            <!-- Solo muestra el enlace de "Mi Perfil" si el usuario está logueado -->
            <?php if ($is_logged_in): ?>
                <li><a href="php/perfil.php">Mi Perfil</a></li>
            <?php endif; ?>
        </ul>

        <!-- Si el usuario está logueado, muestra un botón de cerrar sesión. Si no, muestra el botón de inicio de sesión. -->
        <?php if ($is_logged_in): ?>
            <a href="php/logout.php" class="btn-logout" style="background-color: #f8c32e; color: white; padding: 10px 20px; border-radius: 5px; margin-left: 10px; margin-top: 10px; text-decoration: none; transition: background-color 0.3s, transform 0.2s;" onmouseover="this.style.backgroundColor='#e5b600'; this.style.transform='scale(1.05)';" onmouseout="this.style.backgroundColor='#f8c32e'; this.style.transform='scale(1)';">
                Cerrar sesión
            </a>
        <?php else: ?>
            <a href="login.html" class="btn-login">Iniciar sesión</a>
        <?php endif; ?>
    </nav>
</header>

<!-- Agrega esto en el <head> para usar los íconos de FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="social-buttons">
    <a href="https://wa.me/521XXXXXXXXXX" class="btn whatsapp" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
    <a href="https://www.facebook.com/TU_PAGINA" class="btn facebook" target="_blank">
        <i class="fab fa-facebook-f"></i>
    </a>
    <a href="https://www.instagram.com/TU_USUARIO" class="btn instagram" target="_blank">
        <i class="fab fa-instagram"></i>
    </a>
</div>

<style>
.social-buttons {
    position: fixed;
    right: 20px; /* Ajusta la distancia del borde derecho */
    top: 20%; /* Mueve los iconos aún más arriba */
    transform: translateY(-50%);
    display: flex;
    flex-direction: column;
    gap: 10px;
    z-index: 1000;
}

.btn {
    width: 50px;
    height: 50px;
    border-radius: 50%; /* Hace los botones circulares */
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: white;
    font-size: 24px;
    transition: all 0.3s ease;
}

.whatsapp { background: #25D366; }
.facebook { background: #1877F2; }
.instagram { background: #C13584; }

.btn i {
    margin: 0; /* Asegura que los iconos estén bien centrados */
}

.btn:hover {
    opacity: 0.8;
    transform: scale(1.1);
}





</style>

 <section class="hero">
        <div class="hero-image">
            <img src="assets/Muchacha.jpg" alt="Odontología Hero">
            <div class="circle-image">
                <img src="assets/circulo.jpg" alt="Imagen Circular">
            </div>
        </div>
        <!-- Línea Rosa Vertical -->
        <div class="line"></div>
        <div class="hero-content">
            <div class="hero-text">
                <h1>
                    <span class="blue-light">Educación,</span>
                    <span class="yellow">Tecnología,</span>
                    <span class="aqua">Odontología,</span>
                    <span class="white">Salud</span>
                </h1>
                <p>Descubre cómo CEIAO se alinea con la tecnología en la educación odontológica de especialidad.</p>
            </div>
        </div>
    </section>

  <!-- Cursos On-Demand -->
<section>
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold">Descubre nuestros novedosos cursos <span class="text-yellow-400">On-Demand</span></h1>
        </div>
        <div class="flex justify-center gap-8">
            <!-- Bloque de curso 1 -->
            <div class="bg-[#1f6f8b] p-6 rounded-3xl flex flex-col items-center max-w-xs w-80">
                <img src="images/medicine_7638377.png" alt="Icono de cápsula de medicamento" class="mb-4 w-24 h-24" />
                <h2 class="text-2xl font-semibold">Farmacología</h2>
            </div>
            <!-- Bloque de curso 2 -->
            <div class="bg-[#1f6f8b] p-6 rounded-3xl flex flex-col items-center max-w-xs w-80">
                <img src="images/mouth_10367923.png" alt="Icono de ATM" class="mb-4 w-24 h-24" />
                <h2 class="text-2xl font-semibold">ATM</h2>
            </div>
            <!-- Bloque de curso 3 -->
            <div class="bg-[#1f6f8b] p-6 rounded-3xl flex flex-col items-center max-w-xs w-80">
                <img src="images/smile_9902460.png" alt="Icono de prótesis dental" class="mb-4 w-24 h-24" />
                <h2 class="text-2xl font-semibold">Prostodoncia</h2>
            </div>
        </div>
        <div class="text-center mt-8 flex justify-center gap-6">
            <!-- Botón 1: Hablar con un asesor -->
            <button class="px-8 py-3 bg-[#1f6f8b] text-white rounded-full text-lg">Hablar con un asesor</button>
            <!-- Botón 2: Ver todos los cursos -->
            <button class="px-8 py-3 bg-[#1f6f8b] text-white rounded-full text-lg">Ver todos los cursos</button>
        </div>
    </div>
</section>

<!-- ¿Por qué elegir CEIAO? -->
<section class="bg-gradient-to-r from-[#00b5e2] to-[#0096b0]">
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-white">¿Por qué elegir <span class="text-yellow-400">CEIAO</span>?</h1>
            <p class="mt-4 text-lg text-white">En CEIAO procuramos tener ventajas competitivas de alto valor tecnológico y de educación.</p>
        </div>
        <div class="flex justify-center gap-8">
            <!-- Bloque de sección 1 -->
            <div class="bg-[#1f6f8b] p-6 rounded-3xl flex flex-col items-center max-w-xs w-80">
                <img src="assets/timer_6524925.png" alt="Icono de reloj" class="mb-4 w-24 h-24" />
                <h2 class="text-2xl font-semibold text-white">Estudia en cualquier momento</h2>
                <p class="mt-2 text-center text-sm text-white">En tu tiempo libre, en tu horario agendado, antes de ir a dormir, cuando tú decidas estudiar, estaremos ahí para ti.</p>
            </div>
            <!-- Bloque de sección 2 -->
            <div class="bg-[#1f6f8b] p-6 rounded-3xl flex flex-col items-center max-w-xs w-80">
                <img src="assets/eight_16297033.png" alt="Icono de infinito" class="mb-4 w-24 h-24" />
                <h2 class="text-2xl font-semibold text-white">Disponible de por vida</h2>
                <p class="mt-2 text-center text-sm text-white">Olvídate de los plazos limitados y las presiones, tú decides cuando es el mejor momento para comenzar o recordar lo estudiado.</p>
            </div>
            <!-- Bloque de sección 3 -->
            <div class="bg-[#1f6f8b] p-6 rounded-3xl flex flex-col items-center max-w-xs w-80">
                <img src="assets/double-arrows_11607020.png" alt="Icono de avanzar" class="mb-4 w-24 h-24" />
                <h2 class="text-2xl font-semibold text-white">Avanza a tu ritmo</h2>
                <p class="mt-2 text-center text-sm text-white">Nuestro compromiso es la educación efectiva, no la educación forzada, si prefieres estudiar en un plazo de una semana o dos meses, con CEIAO es posible.</p>
            </div>
        </div>
   </div>
</section>

<!-- Sección con fondo oscuro hasta la mitad -->
<section class="bg-[#0c3b4d] p-6 rounded-3xl mt-12 max-w-2xl mx-auto">
    <div class="flex justify-center mb-4">
        <img src="images/certificate_3561320.png" alt="Icono de certificado" class="mb-4 w-24 h-24"/>
    </div>
    <p class="text-center text-lg text-white">Los documentos de constancias y diplomas que emitimos están registrados en el <span class="font-semibold text-[#00b5e2]">Departamento de Educación Médica Continua</span>.</p>
</section>


<!-- Sección con fondo blanco y columnas con títulos en azul -->
<section class="py-8 bg-white">
    <!-- Línea amarilla sin margen ni padding, para que toque directamente las columnas -->
    <div class="bg-yellow-400 h-20 w-full flex items-center justify-center m-0 p-0">
        <h1 class="text-white text-4xl font-bold">Líderes en Educación Odontológica</h1>
    </div>

    <section>
        <div class="container mx-auto mt-0 p-0">
            <!-- Contenedor con flex para asegurar que las columnas se toquen -->
            <div class="flex m-0 p-0">
                <!-- Columna 1 -->
                <div class="flex-1 m-0 p-0">
                    <!-- Título con fondo azul fuerte y altura ajustada -->
                    <div class="bg-[#004b6e] p-16 relative">
                        <!-- Imagen centrada encima del título -->
                        <img src="assets/Wifi.jpg" alt="Imagen título" class="absolute top-0 left-1/2 transform -translate-x-1/2 w-auto h-24 z-10">
                        <h2 class="text-4xl font-semibold text-white mt-24 text-center">
                            Cursos y Diplomados <br> <span class="text-5xl font-bold">On-Line</span>
                        </h2>
                    </div>
                    <!-- Texto con fondo blanco y un toque gris claro -->
                    <div class="bg-white p-6">
                        <h3 class="text-2xl font-semibold text-[#004b6e]">Método de estudio On-line</h3>
                        <ul class="mt-4 text-lg text-[#004b6e] list-inside list-disc">
                            <li>El horario lo elige el profesor</li>
                            <li>Clases en vivo</li>
                            <li>Preguntas y respuestas en tiempo real</li>
                            <li>Tiempo de espera semestral</li>
                            <li>Requiere inscripción</li>
                            <button onclick="window.location.href='courses.php';" style="background-color: #f8c32e; color: white; padding: 10px 20px; border-radius: 5px; margin-left: 10px; margin-top: 10px; text-decoration: none; transition: background-color 0.3s, transform 0.2s;" onmouseover="this.style.backgroundColor='#e5b600'; this.style.transform='scale(1.05)';" onmouseout="this.style.backgroundColor='#f8c32e'; this.style.transform='scale(1)';">Ver Cursos</button>
                        </ul>
                    </div>
                </div>
                
                <!-- Columna 2 -->
                <div class="flex-1 m-0 p-0 bg-gray-100">
                    <!-- Título con fondo azul fuerte y altura ajustada -->
                    <div class="bg-[#006fa6] p-16 relative">
                        <!-- Imagen centrada encima del título -->
                        <img src="assets/Mano.jpg" alt="Imagen título" class="absolute top-0 left-1/2 transform -translate-x-1/2 w-auto h-24 z-10">
                        <h2 class="text-4xl font-semibold text-white mt-24 text-center">
                            Cursos y Diplomados <br> <span class="text-5xl font-bold">On-Demand</span>
                        </h2>
                    </div>
                    <!-- Texto con fondo blanco -->
                    <div class="bg-white p-6">
                        <h3 class="text-2xl font-semibold text-[#006fa6]">Método de estudio On-Demand</h3>
                        <ul class="mt-4 text-lg text-[#006fa6] list-inside list-disc">
                            <li>Tu horario lo eliges tú</li>
                            <li>Clases pre-grabadas</li>
                            <li>Caja de preguntas y respuestas</li>
                            <li>Accede en cualquier momento</li>
                            <li>No requiere inscripción</li>
                            <li>Tu curso estará siempre disponible</li>
                            <button onclick="window.location.href='courses.php';" style="background-color: #f8c32e; color: white; padding: 10px 20px; border-radius: 5px; margin-left: 10px; margin-top: 10px; text-decoration: none; transition: background-color 0.3s, transform 0.2s;" onmouseover="this.style.backgroundColor='#e5b600'; this.style.transform='scale(1.05)';" onmouseout="this.style.backgroundColor='#f8c32e'; this.style.transform='scale(1)';">Ver Cursos</button>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
<!-- Sección de Ahorro y Modalidad On-Demand -->
<section class="mt-0">
    <div class="container mx-auto p-0">
        <!-- Sección con 2 renglones de texto -->
        <div class="flex flex-col m-0 p-0">
            <!-- Primer renglón: Ahorra en tu educación -->
            <div class="bg-[#003d59] p-8 text-center">
                <h2 class="text-5xl font-bold text-[#00b3e6]">Ahorra en tu educación</h2>
                <p class="mt-6 text-3xl font-semibold text-orange-500">
                    <span class="line-through text-[#d1d1d1]">$8000 mxn</span>
                    <span class="text-orange-500 ml-2">$1599 mxn</span>
                </p>
                <p class="mt-2 text-lg text-white">¡Ahorra el 80% invirtiendo en la modalidad On Demand y estudia con tus propios horarios!</p>
            </div>
            
            <!-- Segundo renglón: Modalidad On-Demand sin inscripción -->
            <div class="bg-[#004b6e] p-8 text-center relative">
                <!-- Espacio para imagen -->
                <img src="assets/Ahorro.jpg" alt="Imagen adicional" class="absolute top-0 left-1/2 transform -translate-x-1/2 w-auto h-24 z-10">
                <p class="text-2xl font-semibold text-white mt-24">
                    En la modalidad <span class="text-yellow-400 font-bold">On-Demand</span> no pagas inscripción
                </p>
            </div>
        </div>
    </div>
</section>

<section class="mt-0">
    <div class="container mx-auto p-0">
        <div class="flex m-0 p-0">
            <!-- Columna de la imagen (3/4) -->
            <div class="w-3/4 p-0">
                <img src="assets/Chica en lap.jpg" alt="Imagen representativa" class="w-full h-auto">
            </div>

            <!-- Columna del cuadro azul aqua (1/4) -->
            <div class="w-1/4 bg-[#00b3b3] p-6 text-center">
                <!-- Contenedor flex para el icono y el título en la misma línea -->
                <div class="flex items-center justify-center mb-3">
                    <img src="assets/man_8022646.png" alt="Icono de accesibilidad" class="w-10 h-10 mr-2">
                    <p class="text-lg font-bold text-white">Accesibilidad</p>
                </div>
                <p class="text-sm font-normal text-white mb-4">
                    Crea tu cuenta gratis hoy mismo y explora los cursos que diseñamos para ti, sin agregar tarjetas de crédito.
                </p>
                <!-- Botón Crear cuenta -->
                <a href="register.html" class="inline-block bg-[#005f73] text-white py-1.5 px-3 rounded-lg text-sm hover:bg-[#004e5c] transition-colors">
                    Crear cuenta
                </a>
            </div>
            
</section>


<section class="mt-0">
    <div class="container mx-auto p-0">
        <!-- Renglón blanco dentro de la sección -->
        <div class="bg-white p-8">
            <div class="flex m-0 p-0">
                <!-- Columna de la imagen (50%) -->
                <div class="w-1/2 p-0">
                    <img src="assets/Rosa.jpg" alt="Imagen representativa" class="w-full h-auto rounded-lg">
                </div>

                <!-- Columna del cuadro azul con bordes redondeados (50%) -->
                <div class="w-1/2 bg-[#004b6e] p-8 text-center rounded-lg">
                    <h2 class="text-xl font-bold text-white mb-4">Taller de ATM</h2>
                    <p class="text-sm text-white mb-6">
                        Aprende las últimas técnicas para tratar la disfunción de la articulación temporo-mandibular desde cualquier lugar. ¡Inscríbete hoy y aparta tu lugar!
                    </p>
                    <div class="flex justify-center gap-4 mt-4">
                        <button class="bg-orange-500 text-white px-4 py-2 rounded">Inscríbete</button>
                        <button class="bg-blue-400 text-white px-4 py-2 rounded">Conoce más</button>
                        <button class="bg-teal-400 text-white px-4 py-2 rounded">Contáctanos</button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>


<section class="bg-[#004b6e] py-12">
    <div class="container mx-auto text-center">
        <h2 class="text-4xl font-bold text-white mb-8">Opiniones de nuestros clientes</h2>
        <!-- Carrusel de opiniones -->
        <div class="swiper-container w-full">
            <div class="swiper-wrapper">
                <!-- Opinión 1 -->
                <div class="swiper-slide">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-xs mx-auto">
                        <div class="flex items-center justify-center mb-4">
                            <img src="ruta/a/foto1.jpg" alt="Cliente 1" class="w-16 h-16 rounded-full border-4 border-[#00b3e6]">
                        </div>
                        <h3 class="text-xl font-semibold text-[#004b6e]">Juan Pérez</h3>
                        <p class="text-lg text-gray-700 mb-4">"Excelente servicio, los cursos son muy completos y fáciles de entender. ¡Recomendado!"</p>
                        <!-- Estrellas -->
                        <div class="flex justify-center">
                            <span class="text-yellow-400">★</span>
                            <span class="text-yellow-400">★</span>
                            <span class="text-yellow-400">★</span>
                            <span class="text-yellow-400">★</span>
                            <span class="text-gray-300">★</span>
                        </div>
                    </div>
                </div>
                <!-- Opinión 2 -->
                <div class="swiper-slide">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-xs mx-auto">
                        <div class="flex items-center justify-center mb-4">
                            <img src="ruta/a/foto2.jpg" alt="Cliente 2" class="w-16 h-16 rounded-full border-4 border-[#00b3e6]">
                        </div>
                        <h3 class="text-xl font-semibold text-[#004b6e]">María González</h3>
                        <p class="text-lg text-gray-700 mb-4">"Muy buena experiencia de aprendizaje, pude estudiar a mi ritmo. ¡Gracias!"</p>
                        <!-- Estrellas -->
                        <div class="flex justify-center">
                            <span class="text-yellow-400">★</span>
                            <span class="text-yellow-400">★</span>
                            <span class="text-yellow-400">★</span>
                            <span class="text-yellow-400">★</span>
                            <span class="text-yellow-400">★</span>
                        </div>
                    </div>
                </div>
                <!-- Opinión 3 -->
                <div class="swiper-slide">
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-xs mx-auto">
                        <div class="flex items-center justify-center mb-4">
                            <img src="ruta/a/foto3.jpg" alt="Cliente 3" class="w-16 h-16 rounded-full border-4 border-[#00b3e6]">
                        </div>
                        <h3 class="text-xl font-semibold text-[#004b6e]">Carlos Ruiz</h3>
                        <p class="text-lg text-gray-700 mb-4">"La plataforma es muy intuitiva, y la calidad de los cursos es excelente. ¡Muy satisfecho!"</p>
                        <!-- Estrellas -->
                        <div class="flex justify-center">
                            <span class="text-yellow-400">★</span>
                            <span class="text-yellow-400">★</span>
                            <span class="text-yellow-400">★</span>
                            <span class="text-yellow-400">★</span>
                            <span class="text-yellow-300">★</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Agrega los controles de navegación si deseas -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>

<!-- Inicializa Swiper -->
<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true, // Permite el loop (se repiten las opiniones)
        autoplay: {
            delay: 3000, // Cambia la opinión cada 3 segundos
            disableOnInteraction: false, // Mantiene la animación aún si interactúan
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 40
            }
        }
    });
</script>

<section class="relative mt-0">
    <!-- Imagen en grande con fondo azul transparente -->
    <div class="relative w-full h-96">
        <img src="ruta/a/tu/imagen.jpg" alt="Imagen Comunidad" class="w-full h-full object-cover opacity-50">
        <!-- Fondo azul transparente -->
        <div class="absolute inset-0 bg-[#004b6e] bg-opacity-50 flex items-center justify-center">
            <!-- Texto centrado dentro de la imagen -->
            <div class="text-center text-white px-6 py-4">
                <h2 class="text-5xl font-bold leading-tight">Únete a nuestra comunidad</h2>
                <p class="text-3xl mt-4">de más de 3,000 estudiantes</p>
                <p class="text-2xl mt-2">y comienza a estudiar hoy mismo.</p>
            </div>
        </div>
    </div>
</section>

<footer class="bg-[#006fa6] py-8 text-center text-white">
    <p class="text-lg">CEIAO | Diplomados Dentales y Consulta Especializada ®2024 Todos los Derechos Reservados</p>
</footer>

</body>

</html>
