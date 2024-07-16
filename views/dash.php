<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/94b15666b0.js" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-md">
            <a class="navbar-brand" href="./dash.php">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="../controllers/logout.php">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="#" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline">Menu</span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li>
                            <a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                                <i class="fs-4 bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span> </a>
                            <ul class="collapse show nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                                <li class="w-100">
                                    <a href="./users.php" class="nav-link px-0"> <i class="fs-4 bi-person-add"></i> <span class="d-none d-sm-inline">Registrar Usuario</span>
                                    </a>
                                </li>
                                <li class="w-100">
                                    <a href="./projects.php" class="nav-link px-0"> <i class="fs-4 bi-rocket-takeoff-fill"></i> <span class="d-none d-sm-inline">Agregar proyecto</span>
                                    </a>
                                </li>
                                <li class="w-100">
                                    <a href="./activities.php" class="nav-link px-0"> <i class="fs-4 bi-table"></i><span class="d-none d-sm-inline"> Agregar Actividades</span>
                                    </a>
                                </li>
                                <li class="w-100">
                                    <a href="./tasks.php" class="nav-link px-0"> <i class="fs-4 bi-person-workspace"></i> <span class="d-none d-sm-inline"> Agregar tareas</span>
                                    </a>
                                </li>
                                <li class="w-100">
                                    <a href="./sources.php" class="nav-link px-0"> <i class="fs-4 bi-grid"></i> <span class="d-none d-sm-inline"> Agregar recursos</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="d-flex justify-content-center align-items-center col py-3">
                <main>
                    <h1>Manejador de Proyectos</h1>
                    <h2>Bienvenido, <?php echo $_SESSION['email']; ?></h2>
                    <div class="tenor-gif-embed" data-postid="1310919070073587715" data-share-method="host" data-aspect-ratio="1" data-width="100%"><a href="https://tenor.com/view/dancing-dragon-gif-1310919070073587715">Dancing Dragon GIF</a>from <a href="https://tenor.com/search/dancing+dragon-gifs">Dancing Dragon GIFs</a></div>
                    <script type="text/javascript" async src="https://tenor.com/embed.js"></script>
                </main>
            </div>
        </div>
    </div>
    <footer class="text-center bg-dark bg-body-tertiary" data-bs-theme="dark">
        <!-- Grid container -->
        <div class="container pt-4">
            <!-- Section: Social media -->
            <section class="mb-4">
                <!-- Facebook -->
                <a data-mdb-ripple-init class="btn btn-link btn-floating btn-lg text-body m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i class="fab fa-facebook-f"></i></a>

                <!-- Twitter -->
                <a data-mdb-ripple-init class="btn btn-link btn-floating btn-lg text-body m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i class="fab fa-twitter"></i></a>

                <!-- Google -->
                <a data-mdb-ripple-init class="btn btn-link btn-floating btn-lg text-body m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i class="fab fa-google"></i></a>

                <!-- Instagram -->
                <a data-mdb-ripple-init class="btn btn-link btn-floating btn-lg text-body m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i class="fab fa-instagram"></i></a>

                <!-- Linkedin -->
                <a data-mdb-ripple-init class="btn btn-link btn-floating btn-lg text-body m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i class="fab fa-linkedin"></i></a>
                <!-- Github -->
                <a data-mdb-ripple-init class="btn btn-link btn-floating btn-lg text-body m-1" href="#!" role="button" data-mdb-ripple-color="dark"><i class="fab fa-github"></i></a>
            </section>
            <!-- Section: Social media -->
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            <a class="text-body" href="https://mdbootstrap.com/"> © 2024 Copyright</a>
        </div>
        <!-- Copyright -->
    </footer>
</body>

</html>
