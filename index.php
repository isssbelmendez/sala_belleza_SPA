<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inicio - Beauty Salon y Spa</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./public/css/style.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-rosa">
        <a class="navbar-brand text-gris" href="#">
            <i class="fas fa-spa fa-lg mr-2"></i>
            Beauty Salon y Spa
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-gris" href="./index.php">
                        <i class="fas fa-home fa-lg mr-1"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-gris" href="./View/Empleados/empleado_select.php">
                        <i class="fas fa-users fa-lg mr-1"></i> Empleados
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-gris" href="./View/Citas/cita_select.php">
                        <i class="fas fa-calendar-alt fa-lg mr-1"></i> Citas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-gris" href="./View/Servicios/servicio_select.php">
                        <i class="fas fa-spa fa-lg mr-1"></i> Servicios
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="text-center">
        <img src="./public/img/Logo.png" alt="Logo de la sala de belleza" class="img-fluid rounded-circle logo">
            <h1 class="titulo">Beauty Salon y Spa</h1>
        </div><br>
       

        <!--<div class="welcome-message mt-5">
            <p>Bienvenido a nuestro oasis de relajación y belleza. En <strong>Beauty Salon y Spa</strong>, ofrecemos los mejores servicios para tu bienestar.</p>
            <p>Sumérgete en un mundo de tranquilidad y disfruta de nuestros tratamientos especializados, diseñados para rejuvenecer tu cuerpo y alma.</p>
        </div>-->

        <!-- Sección de Sala de Spa -->
        <div class="spa-section mt-5">
            <div class="row d-flex align-items-center">
                <div class="col-md-6 text-right">
                    <img src="./public/img/spa.jpg" alt="Imagen de Sala de Belleza" class="img-fluid rounded">
                </div>
                <div class="col-md-6 text-left">
                    <h2>Spa</h2>
                    <p class="parrafo">Ofrecemos una experiencia de spa única que combina tratamientos relajantes con instalaciones de lujo. Descubre la armonía y el equilibrio en nuestro spa.</p>
                    <p><i class="fas fa-leaf"></i> Masajes rejuvenecedores</p>
                    <p><i class="fas fa-hot-tub"></i> Baños termales</p>
                    <p><i class="fas fa-gem"></i> Tratamientos faciales y corporales</p>
                </div>

            </div>
        </div>

        <!-- Sección de Sala de Belleza -->
        <div class="sala-de-belleza-section mt-5">
            <div class="row d-flex align-items-center">
                <div class="col-md-6 text-left">
                    <h2>Sala de Belleza</h2>
                    <p class="parrafo2">Descubre la belleza que llevas dentro con nuestros servicios de alta calidad. Nuestro equipo de estilistas expertos está aquí para realzar tu belleza natural.</p>
                    <p><i class="fas fa-cut"></i> Cortes de pelo y peinados de moda</p>
                    <p><i class="fas fa-paint-brush"></i> Maquillaje profesional</p>
                    <p><i class="fas fa-leaf"></i> Tratamientos capilares</p>
                </div>
                <div class="col-md-6 text-right">
                    <img src="./public/img/sala.jpeg" alt="Imagen de Sala de Belleza" class="img-fluid rounded">
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>