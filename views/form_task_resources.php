<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Asignar Recursos a Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4" style="color: dodgerblue;">Asignar Recursos a Tarea</h2>
        <?php
        if (isset($_GET['message'])) {
            echo "<div class='alert alert-info'>{$_GET['message']}</div>";
        }
        ?>
        <form action="../controllers/controller.php" method="post">
            <input type="hidden" name="action" value="asignarRecursosTarea">
            <input type="hidden" name="idTarea" value="<?php echo $_GET['idTarea']; ?>">
            <div class="d-flex justify-content-center">
                <div class="mb-3 w-50">
                    <label for="idRecurso" class="form-label fw-medium">Seleccionar Recurso</label>
                    <select name="idRecurso" id="idRecurso" class="form-select fw-medium" required>
                        <?php
                        include_once "../DB/config.php";
                        $sql_recursos = "SELECT * FROM recursos";
                        $result_recursos = mysqli_query($conn, $sql_recursos);
                        while ($row_recursos = mysqli_fetch_array($result_recursos)) {
                            echo "<option value='{$row_recursos['IdRecurso']}'>{$row_recursos['Descripcion']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-outline-primary shadow-sm">Asignar Recurso</button>
            </div>
        </form>

        <h2 class="text-center mt-5 mb-4" style="color: dodgerblue;">Recursos Asignados a la Tarea</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Descripción del Recurso</th>
                    <th>Valor Asignado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql_tareaxrecurso = "SELECT tr.*, r.Descripcion, r.Valor FROM tareaxrecurso tr INNER JOIN recursos r ON tr.IdRecurso = r.IdRecurso WHERE tr.IdTarea = '{$_GET['idTarea']}'";
                $result_tareaxrecurso = mysqli_query($conn, $sql_tareaxrecurso);
                $total_valor_asignado = 0;
                while ($row_tareaxrecurso = mysqli_fetch_array($result_tareaxrecurso)) {
                    echo "<tr>
                            <td>{$row_tareaxrecurso['Descripcion']}</td>
                            <td>{$row_tareaxrecurso['Valor']}</td>
                          </tr>";
                    $total_valor_asignado += $row_tareaxrecurso['Valor'];
                }
                ?>
            </tbody>
        </table>
        <h3 class="text-center" style="margin-top:35px;">Total Valor Asignado: <?php echo $total_valor_asignado; ?></h3>


        <div class="mb-3 text-center p-2">
            <a href="tasks.php" class="btn btn-outline-danger shadow-sm" style="width: 110px;"><i class="bi bi-arrow-left"></i> Regresar</a></a>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>