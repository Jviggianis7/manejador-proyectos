<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Proyectos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
</head>

<body>
    <a>
        <h2 class="text-center" style="color:dodgerblue; margin-top: 35px;">Lista de Proyectos</h2>
    </a>
    <form class="d-flex mx-auto p-2" role="search" action="projects.php" method="GET">
        <label for="estado" class="me-2 fw-bolder fw-medium">Filtrar por Estado:</label>
        <select name="estado" id="estado" class="me-2 fw-bolder fw-medium rounded">
            <option value="">Todos</option>
            <option value="En progreso">En progreso</option>
            <option value="No terminado">No terminado</option>
            <option value="Entregado">Entregado</option>
            <option value="Cancelado">Cancelado</option>
        </select>
        <button class="btn btn-outline-success" type="submit">Buscar</button>
    </form>

    <?php
    if (isset($_GET['message'])) {
        echo " <div class='d-flex justify-content-center'>
               <div class='alert alert-success w-50 d-flex align-items-center' style='margin-top:35px;'>
               {$_GET['message']}</div>
               </div>";
    }
    ?>
    <div class="container-fluid" style="overflow-y: scroll; max-height: 600px;">

        <table class="table table-hovers md-50">
            <thead>
                <tr>
                    <th scope="col">ID proyecto</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Fecha de inicio</th>
                    <th scope="col">Fecha de entrega</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Lugar</th>
                    <th scope="col">Responsable</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Ver</th>
                    <th scope="col">Acciones</th>
                </tr>

            </thead>
            <tbody>
                <?php
                include_once "../DB/config.php";

                $current_date = date("Y-m-d");
                $estado = isset($_GET['estado']) ? mysqli_real_escape_string($conn, $_GET['estado']) : '';

                $sql = "SELECT proyectos.*, CONCAT(personas.Nombre, ' ', personas.Apellidos) AS ResponsableNombre 
                        FROM proyectos 
                        JOIN personas ON proyectos.Responsable = personas.IdPersona";

                if ($estado) {
                    $sql .= " WHERE proyectos.Estado = '$estado'";
                }

                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_array($result)) {
                    if ($row['FechaEntrega'] < $current_date && $row['Estado'] == "En progreso") {
                        $update_sql = "UPDATE proyectos SET Estado = 'No terminado' WHERE IdProyecto = '{$row['IdProyecto']}'";
                        mysqli_query($conn, $update_sql);
                        $row['Estado'] = "No terminado";
                    }

                    echo "<tr>
                        <td>{$row['IdProyecto']}</td>
                        <td>{$row['Descripcion']}</td>
                        <td>{$row['FechaInicio']}</td>
                        <td>{$row['FechaEntrega']}</td>
                        <td>$ {$row['Valor']}</td>
                        <td>{$row['Lugar']}</td>
                        <td>{$row['ResponsableNombre']}</td>
                        <td>{$row['Estado']}</td>
                        <td>
                            <div class='dropdown'>
                                <button class='btn btn-outline-primary dropdown-toggle' type='button' id='dropdownMenuButton{$row['IdProyecto']}' data-bs-toggle='dropdown' aria-expanded='false'>
                                    Opciones
                                </button>
                                <ul class='dropdown-menu' aria-labelledby='dropdownMenuButton{$row['IdProyecto']}'>
                                    <li><a class='dropdown-item' href='project_resources.php?idProyecto={$row['IdProyecto']}'>Ver Recursos</a></li>
                                    <li><a class='dropdown-item' href='project_persons.php?idProyecto={$row['IdProyecto']}'>Ver Personas</a></li>
                                    <li><a class='dropdown-item' href='project_detail.php?idProyecto={$row['IdProyecto']}'>Ver Detalles</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <form action='edit_project.php' method='get' style='display:inline;'>
                                <input type='hidden' name='idProyecto' value='{$row['IdProyecto']}'>
                                <button class='btn btn-outline-primary' type='submit'><i class='bi bi-pencil-square'></i> Editar</button>
                            </form>
                            <form action='../controllers/controller.php' method='post' style='display:inline;'>
                                <input type='hidden' name='action' value='entregarProyecto'>
                                <input type='hidden' name='idProyecto' value='{$row['IdProyecto']}'>
                                <button class='btn btn-outline-primary' type='submit'>Entregar</button>
                            </form>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex align-items-center text-center justify-content-between">
        <div class="w-100">
            <a href="form_project.php" class="btn btn-outline-success"><i class="bi bi-plus"></i> Registrar nuevo proyecto</a>
            <a href="./dash.php" type="button" class="btn btn-outline-danger shadow-sm" style="width: 110px;"><i class="bi bi-arrow-left"></i> Regresar</a>
        </div>
    </div>
    <!-- jQuery, Popper.js, y Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>
