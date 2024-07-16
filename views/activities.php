<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Actividades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
</head>

<body>
    <h2 class="text-center" style="color:dodgerblue; margin-top: 35px;">Lista de Actividades</h2>

    <form class="d-flex mx-auto p-2" role="search" action="activities.php" method="GET">
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
        <table class="table table-hovers md-50">
            <tr>
                <th>ID Actividad</th>
                <th>Descripción</th>
                <th>Fecha Inicio</th>
                <th>Fecha Final</th>
                <th>ID Proyecto</th>
                <th>Responsable</th>
                <th>Presupuesto</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            <?php
            include_once "../DB/config.php";

            $current_date = date("Y-m-d");
            $estado = isset($_GET['estado']) ? mysqli_real_escape_string($conn, $_GET['estado']) : '';

            $sql = "SELECT actividades.*, CONCAT(personas.Nombre, ' ', personas.Apellidos) AS ResponsableNombre 
                    FROM actividades 
                    JOIN personas ON actividades.Responsable = personas.IdPersona";

            if ($estado) {
                $sql .= " WHERE actividades.Estado = '$estado'";
            }

            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_array($result)) {
                if ($row['FechaFinal'] < $current_date && $row['Estado'] == "En progreso") {
                    $update_sql = "UPDATE actividades SET Estado = 'No terminado' WHERE IdActividad = '{$row['IdActividad']}'";
                    mysqli_query($conn, $update_sql);
                    $row['Estado'] = "No terminado"; 
                }

                echo "<tr>
                <td>{$row['IdActividad']}</td>
                <td>{$row['Descripcion']}</td>
                <td>{$row['FechaInicio']}</td>
                <td>{$row['FechaFinal']}</td>
                <td>{$row['IdProyecto']}</td>
                <td>{$row['ResponsableNombre']}</td>
                <td>$ {$row['Presupuesto']}</td>
                <td>{$row['Estado']}</td>
                <td>
                    <form action='edit_activity.php' method='get' style='display:inline;'>
                        <input type='hidden' name='idActividad' value='{$row['IdActividad']}'>
                        <button class='btn btn-outline-primary' type='submit' value='Editar'><i class='bi bi-pencil-square'></i> Editar</button>
                    </form>
                    <form action='../controllers/controller.php' method='post' style='display:inline;'>
                        <input type='hidden' name='action' value='entregarActividad'>
                        <input type='hidden' name='idActividad' value='{$row['IdActividad']}'>
                        <button class='btn btn-outline-primary' type='submit' value='Entregado'><i class='bi bi-check-circle'></i> Entregar</button>
                    </form>
                </td>
              </tr>";
            }
            ?>
        </table>
    </div>
    <br>
    <div class="card-footer d-flex align-items-center text-center justify-content-between">
        <div class="w-100">
            <a href="form_activity.php" class="btn btn-outline-success"><i class="bi bi-plus"></i> Registrar nueva actividad</a>
            <a href="./dash.php" type="button" class="btn btn-outline-danger shadow-sm" style="width: 110px;"><i class="bi bi-arrow-left"></i> Regresar</a>
        </div>
    </div>
</body>

</html>
