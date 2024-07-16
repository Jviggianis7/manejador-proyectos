<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>
?><!DOCTYPE html>
<html>

<head>
    <title>Registrar Actividad</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
</head>

<body>
    <h2 class="text-center mx-auto p-2" style="margin-top:35px; color: dodgerblue;">Registrar Actividad</h2>
    <div class="d-flex justify-content-center align-items-center">
        <div class="card shadow-lg border-0 rounded-lg mt-5" style="width: 50%;">
            <div class="card-body">
                <form action="../controllers/controller.php" method="post">
                    <input type="hidden" name="action" value="guardarActividad">

                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-medium">Descripción</label>
                        <input type="text" class="form-control fw-medium" id="descripcion" name="descripcion" required>
                    </div>

                    <div class="mb-3">
                        <label for="fechaInicio" class="form-label fw-medium">Fecha de Inicio</label>
                        <input type="date" class="form-control fw-medium" id="fechaInicio" name="fechaInicio" required>
                    </div>

                    <div class="mb-3">
                        <label for="fechaFinal" class="form-label fw-medium">Fecha Final</label>
                        <input type="date" class="form-control fw-medium" id="fechaFinal" name="fechaFinal" required>
                    </div>

                    <div class="mb-3">
                        <label for="idProyecto" class="form-label fw-medium">Proyecto</label>
                        <select class="form-select fw-medium" id="idProyecto" name="idProyecto" required>
                            <?php
                            include_once "../DB/config.php";
                            $sql = "SELECT IdProyecto, Descripcion FROM proyectos";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<option value='{$row['IdProyecto']}'>{$row['Descripcion']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="responsable" class="form-label fw-medium">Responsable</label>
                        <select class="form-select fw-medium" id="responsable" name="responsable" required>
                            <?php
                            $sql = "SELECT IdPersona, CONCAT(Nombre, ' ', Apellidos) AS NombreCompleto FROM personas";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<option value='{$row['IdPersona']}'>{$row['NombreCompleto']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="presupuesto" class="form-label fw-medium">Presupuesto</label>
                        <input type="number" class="form-control fw-medium" id="presupuesto" name="presupuesto" required>
                    </div>

                    <div class="mb-3 text-center p-2">
                        <button type="submit" class="btn btn-outline-primary shadow-sm">Registrar</button>
                        <a href="./activities.php" class="btn btn-outline-danger shadow-sm" style="width: 110px;"><i class="bi bi-x-lg"></i> Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>