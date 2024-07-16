<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Asignar Personas a Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4" style="color: dodgerblue;">Asignar Personas a Tarea</h2>
        <?php
        if (isset($_GET['message'])) {
            echo "<div class='alert alert-info'>{$_GET['message']}</div>";
        }
        ?>
        <div class="d-flex justify-content-center">
            <form action="../controllers/controller.php" method="post" style="width: 50%;">
                <input type="hidden" name="action" value="assignPersonToTask">
                <input type="hidden" name="idTarea" value="<?php echo $_GET['idTarea']; ?>">
                <div class="mb-3">
                    <label for="idPersona" class="form-label fw-medium">Seleccionar Persona</label>
                    <select name="idPersona" id="idPersona" class="form-select fw-medium" required>
                        <?php
                        include_once "../DB/config.php";
                        $sql_personas = "SELECT * FROM personas";
                        $result_personas = mysqli_query($conn, $sql_personas);
                        while ($row_personas = mysqli_fetch_array($result_personas)) {
                            echo "<option value='{$row_personas['IdPersona']}'>{$row_personas['Nombre']} {$row_personas['Apellidos']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="duracion" class="form-label fw-medium">Duración (días)</label>
                    <input type="number" name="duracion" id="duracion" class="form-control fw-medium" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-outline-primary shadow-sm">Asignar Persona</button>
                </div>
            </form>
        </div>

        <h2 class="text-center mt-5 mb-4" style="color: dodgerblue;">Personas Asignadas a la Tarea</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre de la Persona</th>
                    <th>Duración Asignada</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql_tareaxpersona = "SELECT tp.*, p.Nombre, p.Apellidos FROM tareaxpersona tp INNER JOIN personas p ON tp.IdPersona = p.IdPersona WHERE tp.IdTarea = '{$_GET['idTarea']}'";
                $result_tareaxpersona = mysqli_query($conn, $sql_tareaxpersona);
                $total_duracion_asignada = 0;
                while ($row_tareaxpersona = mysqli_fetch_array($result_tareaxpersona)) {
                    echo "<tr>
                            <td>{$row_tareaxpersona['Nombre']} {$row_tareaxpersona['Apellidos']}</td>
                            <td>{$row_tareaxpersona['Duracion']}</td>
                          </tr>";
                    $total_duracion_asignada += $row_tareaxpersona['Duracion'];
                }
                ?>
            </tbody>
        </table>
        <h3 class="text-center">Total Duración Asignada: <?php echo $total_duracion_asignada; ?> días</h3>
    </div>
    <div class="mb-3 text-center p-2">
        <a href="tasks.php" class="btn btn-outline-danger shadow-sm" style="width: 110px;"><i class="bi bi-arrow-left"></i> Regresar</a></a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>