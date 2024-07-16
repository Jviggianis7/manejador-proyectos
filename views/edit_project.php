<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Editar Proyecto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
    <h2 class="text-center mx-auto" style="color:dodgerblue; margin-top: 35px;">Editar Proyecto</h2>
    <?php


    if (isset($_GET['idProyecto'])) {
        $idProyecto = $_GET['idProyecto'];

        include_once "../DB/config.php";
        $sql = "SELECT * FROM proyectos WHERE IdProyecto='$idProyecto'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    ?>

        <div class="d-flex justify-content-center align-items-center">
            <div class="card shadow-lg border-0 rounded-lg mt-5" style="width: 50%;">
                <div class="card-body">
                    <form action="../controllers/controller.php" method="POST">
                        <input type="hidden" name="action" value="actualizarProyecto">
                        <input type="hidden" name="idProyecto" value="<?php echo $idProyecto; ?>">
                        <div class="mb-3">
                            <label for="descripcion" class="form-label fw-medium">Descripción:</label>
                            <input type="text" class="form-control fw-medium" id="descripcion" name="descripcion" value="<?php echo $row['Descripcion']; ?>" required><br>
                        </div>
                        <div class="mb-3">
                            <label for="fechaInicio" class="form-label fw-medium">Fecha de Inicio:</label>
                            <input type="date" class="form-control fw-medium" id="fechaInicio" name="fechaInicio" value="<?php echo $row['FechaInicio']; ?>" required><br>
                        </div>
                        <div class="mb-3">
                            <label for="fechaEntrega" class="form-label fw-medium">Fecha de Entrega:</label>
                            <input type="date" class="form-control fw-medium" id="fechaEntrega" name="fechaEntrega" value="<?php echo $row['FechaEntrega']; ?>" required><br>
                        </div>
                        <div class="mb-3">
                            <label for="valor" class="form-label fw-medium">Valor:</label>
                            <input type="number" class="form-control fw-medium" id="valor" name="valor" value="<?php echo $row['Valor']; ?>" required><br>
                        </div>
                        <div class="mb-3">
                            <label for="lugar" class="form-label fw-medium">Lugar:</label>
                            <input type="text" class="form-control fw-medium" id="lugar" name="lugar" value="<?php echo $row['Lugar']; ?>" required><br>
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
                            </select><br>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label fw-medium">Estado:</label>
                            <select class="form-select fw-medium" id="estado" name="estado">
                                <option value="En progreso" <?php if ($row['Estado'] == 'En progreso') echo 'selected'; ?>>En progreso</option>
                                <option value="Cancelado" <?php if ($row['Estado'] == 'Cancelado') echo 'selected'; ?>>Cancelado</option>
                            </select><br>
                        </div>
                        <div class="mb-3 text-center p-2">
                            <button type="submit" class="btn btn-outline-success">Actualizar</button>
                            <a href="./projects.php" type="button" class="btn btn-outline-danger shadow-sm" style="width: 110px;"><i class="fa-solid fa-xmark"></i> Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
    <?php } else {
        echo "<p>No se ha proporcionado el ID del proyecto.</p>";
    } ?>

</body>

</html>