<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Lista de Recursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4" style="color: dodgerblue;">Lista de Recursos</h2>
        <?php
        if (isset($_GET['message'])) {
            echo " <div class='d-flex justify-content-center'>
               <div class='alert alert-success w-50 d-flex align-items-center' style='margin-top:35px;'>
               {$_GET['message']}</div>
               </div>";
        }
        ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID Recurso</th>
                        <th>Descripción</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once "../DB/config.php";
                    $sql = "SELECT * FROM recursos";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>
                                <td>{$row['IdRecurso']}</td>
                                <td>{$row['Descripcion']}</td>
                                <td>$ {$row['Valor']}</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-4">
            <a href="form_sources.php" class="btn btn-outline-success shadow-sm"><i class="bi bi-plus-lg"></i> Agregar Nuevo Recurso</a>
            <a href="dash.php" class="btn btn-outline-danger"><i class="bi bi-arrow-left"></i> Regresar</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>