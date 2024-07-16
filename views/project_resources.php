<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Recursos del Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
</head>

<body>
    <h2 class="text-center" style="color:dodgerblue; margin-top: 35px;">Recursos Asignados al Proyecto</h2>
    <?php
    include_once "../DB/config.php";

    $idProyecto = $_GET['idProyecto'];

    $sql_actividades = "SELECT IdActividad FROM actividades WHERE idProyecto = '$idProyecto'";
    $result_actividades = mysqli_query($conn, $sql_actividades);
    $actividades = [];
    while ($row_actividades = mysqli_fetch_array($result_actividades)) {
        $actividades[] = $row_actividades['IdActividad'];
    }

    if (!empty($actividades)) {
        $actividades_list = implode(",", $actividades);
        $sql_tareas = "SELECT IdTarea FROM tareas WHERE IdActividad IN ($actividades_list)";
        $result_tareas = mysqli_query($conn, $sql_tareas);
        $tareas = [];
        while ($row_tareas = mysqli_fetch_array($result_tareas)) {
            $tareas[] = $row_tareas['IdTarea'];
        }

        if (!empty($tareas)) {
            $tareas_list = implode(",", $tareas);
            $sql_recursos = "SELECT tr.*, r.Descripcion, r.Valor FROM tareaxrecurso tr INNER JOIN recursos r ON tr.IdRecurso = r.IdRecurso WHERE tr.IdTarea IN ($tareas_list)";
            $result_recursos = mysqli_query($conn, $sql_recursos);

            echo "<div class='container-fluid' style='overflow-y: scroll; max-height: 600px;'>
              <table class = 'table table-hovers md-50'>
                <thead>
                 <tr>
                 <th>Descripción del Recurso</th>
                 <th>Valor Asignado</th>
                  </tr>
                </thead>";


            $total_valor_asignado = 0;
            while ($row_recursos = mysqli_fetch_array($result_recursos)) {
                echo "<tbody>
                    <tr>
                    <td>{$row_recursos['Descripcion']}</td>
                    <td>{$row_recursos['Valor']}</td>
                    </tr>
                  </tbody>";
                $total_valor_asignado += $row_recursos['Valor'];
            }

            echo "</table>";
            echo "</div>";
            echo "<h3 class= 'text-center'>Total Valor Asignado: $total_valor_asignado</h3>";
        } else {
            echo "<p>No se encontraron tareas para las actividades de este proyecto.</p>";
        }
    } else {
        echo "<p>No se encontraron actividades para este proyecto.</p>";
    }
    ?>

    <div class="card-footer d-flex align-items-center text-center justify-content-between">
        <div class="w-100">
            <a href="./projects.php" type="button" class="btn btn-outline-success shadow-sm" style="width: 150px;"><i class='fa-solid fa-circle-arrow-left'></i> Regresar</a>
        </div>
    </div>
</body>

</html>