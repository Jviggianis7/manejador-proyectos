<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Editar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4" style="color: dodgerblue;">Editar Tarea</h2>
        <?php
        include_once "../DB/config.php";
        $idTarea = $_GET['idTarea'];
        $sql = "SELECT * FROM tareas WHERE IdTarea='$idTarea'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        ?>
        <div class="d-flex justify-content-center">
            <form action="../controllers/controller.php" method="post" style="width: 50%;">
                <input type="hidden" name="action" value="actualizarTarea">
                <input type="hidden" name="idTarea" value="<?php echo $idTarea; ?>">

                <div class="mb-3">
                    <label for="descripcion" class="form-label fw-medium">Descripción</label>
                    <input type="text" id="descripcion" name="descripcion" class="form-control fw-medium" value="<?php echo $row['Descripcion']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="fechaInicio" class="form-label fw-medium">Fecha de Inicio</label>
                    <input type="date" id="fechaInicio" name="fechaInicio" class="form-control fw-medium" value="<?php echo $row['FechaInicio']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="fechaFinal" class="form-label fw-medium">Fecha Final</label>
                    <input type="date" id="fechaFinal" name="fechaFinal" class="form-control fw-medium" value="<?php echo $row['FechaFinal']; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="idActividad" class="form-label fw-medium">ID Actividad</label>
                    <select id="idActividad" name="idActividad" class="form-select fw-medium" required>
                        <?php
                        $sqlActividades = "SELECT IdActividad FROM actividades";
                        $resultActividades = mysqli_query($conn, $sqlActividades);
                        while ($actividad = mysqli_fetch_array($resultActividades)) {
                            $selected = ($actividad['IdActividad'] == $row['IdActividad']) ? "selected" : "";
                            echo "<option value='{$actividad['IdActividad']}' $selected>{$actividad['IdActividad']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label fw-medium">Estado</label>
                    <select name="estado" id="estado" class="form-select fw-medium">
                        <option value="En progreso" <?php if ($row['Estado'] == 'En progreso') echo 'selected'; ?>>En progreso</option>
                        <option value="Finalizada" <?php if ($row['Estado'] == 'Finalizada') echo 'selected'; ?>>Finalizar</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-outline-primary shadow-sm">Actualizar</button>
                    <a href="tasks.php" class="btn btn-outline-danger shadow-sm" style="width: 110px;"><i class="bi bi-x-lg"></i> Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
