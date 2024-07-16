<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Editar Actividad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
    <h2 class="text-center mx-auto" style="color: dodgerblue; margin-top: 35px;">Editar Actividad</h2>
    <?php
    include_once "../DB/config.php";
    $idActividad = $_GET['idActividad'];
    $sql = "SELECT * FROM actividades WHERE IdActividad='$idActividad'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    ?>
    <div class="d-flex justify-content-center align-items-center">
        <div class="card shadow-lg border-0 rounded-lg mt-5" style="width: 50%;">
            <div class="card-body">
                <form action="../controllers/controller.php" method="post">
                    <input type="hidden" name="action" value="actualizarActividad">
                    <input type="hidden" name="idActividad" value="<?php echo $idActividad; ?>">

                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-medium">Descripción:</label>
                        <input type="text" class="form-control fw-medium" id="descripcion" name="descripcion" value="<?php echo $row['Descripcion']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="fechaInicio" class="form-label fw-medium">Fecha de Inicio:</label>
                        <input type="date" class="form-control fw-medium" id="fechaInicio" name="fechaInicio" value="<?php echo $row['FechaInicio']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="fechaFinal" class="form-label fw-medium">Fecha Final:</label>
                        <input type="date" class="form-control fw-medium" id="fechaFinal" name="fechaFinal" value="<?php echo $row['FechaFinal']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="idProyecto" class="form-label fw-medium">Proyecto:</label>
                        <select class="form-select fw-medium" id="idProyecto" name="idProyecto" required>
                            <?php
                            $sqlProyectos = "SELECT IdProyecto, Descripcion FROM proyectos";
                            $resultProyectos = mysqli_query($conn, $sqlProyectos);
                            while ($proyecto = mysqli_fetch_array($resultProyectos)) {
                                $selected = ($proyecto['IdProyecto'] == $row['IdProyecto']) ? "selected" : "";
                                echo "<option value='{$proyecto['IdProyecto']}' $selected>{$proyecto['Descripcion']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="responsable" class="form-label fw-medium">Responsable:</label>
                        <select class="form-select fw-medium" id="responsable" name="responsable">
                            <?php
                            $sql_personas = "SELECT IdPersona, CONCAT(Nombre, ' ', Apellidos) AS NombreCompleto FROM personas";
                            $result_personas = mysqli_query($conn, $sql_personas);
                            while ($row_personas = mysqli_fetch_array($result_personas)) {
                                $selected = ($row_personas['IdPersona'] == $row['Responsable']) ? "selected" : "";
                                echo "<option value='{$row_personas['IdPersona']}' $selected>{$row_personas['NombreCompleto']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="presupuesto" class="form-label fw-medium">Presupuesto:</label>
                        <input type="number" class="form-control fw-medium" id="presupuesto" name="presupuesto" value="<?php echo $row['Presupuesto']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label fw-medium">Estado:</label>
                        <select class="form-select fw-medium" id="estado" name="estado">
                            <option value="En progreso" <?php if ($row['Estado'] == 'En progreso') echo 'selected'; ?>>En progreso</option>
                            <option value="Finalizada" <?php if ($row['Estado'] == 'Finalizada') echo 'selected'; ?>>Finalizada</option>
                        </select>
                    </div>

                    <div class="mb-3 text-center p-2">
                        <button type="submit" class="btn btn-outline-success">Actualizar</button>
                        <a href="./activities.php" class="btn btn-outline-danger shadow-sm" style="width: 110px;"><i class="bi bi-x-lg"></i> Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
</body>

</html>
