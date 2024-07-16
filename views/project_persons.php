<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Personas Asignadas al Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
</head>

<body>
    <h2 class="text-center" style="color:dodgerblue; margin-top: 35px;">Personas Asignadas al Proyecto</h2>
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
            $sql_personas = "SELECT tp.*, p.Nombre, p.Apellidos FROM tareaxpersona tp INNER JOIN personas p ON tp.IdPersona = p.IdPersona WHERE tp.IdTarea IN ($tareas_list)";
            $result_personas = mysqli_query($conn, $sql_personas);

            echo "<div class='container-fluid' style='overflow-y: scroll; max-height: 600px;'>
             <table class = 'table table-hovers md-20'>
             <thead>
                <tr>
                    <th scope='col'>Nombre de la Persona</th>
                    <th scope='col'>Duración Asignada</th>
                </tr>
               </thead>";

            $total_duracion_asignada = 0;
            while ($row_personas = mysqli_fetch_array($result_personas)) {
                echo "<tbody>
                    <tr>
                    <td>{$row_personas['Nombre']} {$row_personas['Apellidos']}</td>
                    <td>{$row_personas['Duracion']}</td>
                  </tr>
                  </tbody>";
                $total_duracion_asignada += $row_personas['Duracion'];
            }

            echo "</table>";
            echo "</div>";
            echo "<h3 class= 'text-center' style= 'margin-top: 35px;'>Total Duración Asignada: $total_duracion_asignada días</h3>";
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