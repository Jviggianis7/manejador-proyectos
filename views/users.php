<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Lista de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-solid-rounded/css/uicons-solid-rounded.css'>
</head>

<body>

    <h2 class="text-center" style="color:dodgerblue; margin-top: 35px;">Lista de Usuarios</h2>

    <?php
    if (isset($_GET['message'])) {
        echo " <div class='d-flex justify-content-center'>
               <div class='alert alert-success w-50 d-flex align-items-center' style='margin-top:35px;'>
               {$_GET['message']}</div>
               </div>";
    }
    ?>


    <div class="container-fluid" style="overflow-y: scroll; max-height: 600px;">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID usuario</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Fecha nacimiento</th>
                    <th scope="col">Profesion</th>
                    <th scope="col">Acción</th>

                </tr>
            </thead>
            <tbody>
                <?php
                include_once "../DB/config.php";
                $sql = "SELECT * FROM personas";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                         <td>{$row['IdPersona']}</td>
                         <td>{$row['Nombre']}</td>
                         <td>{$row['Apellidos']}</td>
                         <td>{$row['Direccion']}</td>
                         <td>{$row['Telefono']}</td>
                         <td>{$row['Sexo']}</td>
                         <td>{$row['FechaNacimiento']}</td>
                         <td>{$row['Profesion']}</td>
                         <td><a href='edit_user.php?idPersona={$row['IdPersona']}' type='button' class='btn btn-outline-primary shadow-sm' style='width: 110px;'><i class='bi bi-pencil-square'></i> Editar</a>
                      </tr>";
                }

                ?>
        </table>
        <div class="card-footer d-flex align-items-center text-center justify-content-between">
            <div class="w-100">
                <a href="form_user.php" class="btn btn-outline-success"><i class="bi bi-plus"></i> Registrar nuevo usuario</a>
                <a href="./dash.php" type="button" class="btn btn-outline-danger shadow-sm" style="width: 110px;"><i class="bi bi-arrow-left"></i> Regresar</a>
            </div>
        </div>

    </div>
</body>

</html>