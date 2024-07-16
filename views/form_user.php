<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Registrar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</head>

<body>
    <h2 class="text-center mx-auto p-2" style="font-weight: 600;color:dodgerblue;">Registrar usuarios</h2>
    <div class="d-flex justify-content-center align-items-center ">
        <div class="card shadow-lg border-0 rounded-lg mt-5" style="width: 50%;">
            <div class="card-body">
                <form action="../controllers/controller.php" method="POST">
                    <input type="hidden" name="action" value="guardarUsuario">

                    <div class="mb-3">
                        <label for="idPersona" class="form-label fw-medium">Identificación</label>
                        <input type="number" class="form-control requiredField Highlighted-label fw-medium" id="id_persona" name="id_persona" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-medium">Nombre</label>
                        <input type="text" class="form-control  fw-medium" id="nombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos" class="form-label fw-medium">Apellidos</label>
                        <input type="text" class="form-control fw-medium" id="apellidos" name="apellidos" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label fw-medium">Dirección</label>
                        <input type="text" class="form-control  fw-medium" id="direccion" name="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label fw-medium">Teléfono</label>
                        <input type="text" class="form-control  fw-medium" id="telefono" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="sexo" class="form-label fw-medium">Sexo</label>
                        <select class="form-select  fw-medium" id="sexo" name="sexo" required>
                            <option value="">Seleccione el sexo</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fechaNacimiento" class="form-label fw-medium">Fecha de Nacimiento</label>
                        <input type="date" class="form-control  fw-medium" id="fechaNacimiento" name="fechaNacimiento" required>
                    </div>
                    <div class="mb-3">
                        <label for="profesion" class="form-label fw-medium">Profesión</label>
                        <input type="text" class="form-control fw-medium" id="profesion" name="profesion" required>

                    </div>
                    <div class="mb-3 text-center p-2">
                        <button type="submit" value="Registrar" class="btn btn-outline-primary shadow-sm">Registrar</button>
                        <a href="./users.php" type="button" class="btn btn-outline-danger shadow-sm" style="width: 110px;"><i class="fa-solid fa-xmark"></i> Cancelar</a>
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