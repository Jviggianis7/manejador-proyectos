<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <h2 class="text-center" style="color:dodgerblue; margin-top: 35px;">Lista de Tareas</h2>

    <form class="d-flex mx-auto p-2" role="search" action="tasks.php" method="GET">
        <label for="estado" class="me-2 fw-bolder fw-medium">Filtrar por Estado:</label>
        <select name="estado" id="estado" class="me-2 fw-bolder fw-medium rounded">
            <option value="">Todos</option>
            <option value="En progreso">En progreso</option>
            <option value="No terminado">No terminado</option>
            <option value="Entregado">Entregado</option>
            <option value="Cancelado">Cancelado</option>
        </select>
        <button class="btn btn-outline-success" type="submit">Filtrar</button>
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
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID Tarea</th>
                    <th>Descripción</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Final</th>
                    <th>ID Actividad</th>
                    <th>Estado</th>
                    <th>Asignar Recursos</th>
                    <th>Asignar Personas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include_once "../DB/config.php";

                $current_date = date("Y-m-d");
                $estado = isset($_GET['estado']) ? mysqli_real_escape_string($conn, $_GET['estado']) : '';

                $sql = "SELECT * FROM tareas";
                if ($estado) {
                    $sql .= " WHERE Estado = '$estado'";
                }

                $result = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_array($result)) {
                    if ($row['FechaFinal'] < $current_date && $row['Estado'] == "En progreso") {
                        $update_sql = "UPDATE tareas SET Estado = 'No terminado' WHERE IdTarea = '{$row['IdTarea']}'";
                        mysqli_query($conn, $update_sql);
                        $row['Estado'] = "No terminado"; 
                    }

                    echo "<tr>
                            <td>{$row['IdTarea']}</td>
                            <td>{$row['Descripcion']}</td>
                            <td>{$row['FechaInicio']}</td>
                            <td>{$row['FechaFinal']}</td>
                            <td>{$row['IdActividad']}</td>
                            <td>{$row['Estado']}</td>
                            <td><a href='form_task_resources.php?idTarea={$row['IdTarea']}' class='btn btn-outline-primary'><i class='bi bi-archive'></i> Asignar Recursos</a></td>
                            <td><a href='form_task_person.php?idTarea={$row['IdTarea']}' class='btn btn-outline-primary'><i class='bi bi-people'></i> Asignar Personas</a></td>
                            <td>
                                <form action='edit_task.php' method='get' style='display:inline;'>
                                    <input type='hidden' name='idTarea' value='{$row['IdTarea']}'>
                                    <button class='btn btn-outline-primary' type='submit'><i class='bi bi-pencil-square'></i> Editar</button>
                                </form>
                                <form action='../controllers/controller.php' method='post' style='display:inline;'>
                                    <input type='hidden' name='action' value='entregarTareas'>
                                    <input type='hidden' name='idTarea' value='{$row['IdTarea']}'>
                                    <button class='btn btn-outline-primary' type='submit'><i class='bi bi-check-circle'></i> Entregar</button>
                                </form>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <br>
    <div class="card-footer d-flex align-items-center text-center justify-content-between">
        <div class="w-100">
        <a href="form_task.php" class="btn btn-outline-success"><i class="bi bi-plus"></i> Registrar Nueva Tarea</a>
        <a href="dash.php" class="btn btn-outline-danger"><i class="bi bi-arrow-left"></i> Regresar</a>
        </div>
    </div>

</body>

</html>
