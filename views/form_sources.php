<?php
require_once '../controllers/controller.php';
redirectIfNotLoggedIn();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Agregar Nuevo Recurso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
</head>

<body>
    <h2 class="text-center mx-auto p-2" style="margin-top:35px; color: dodgerblue;">Agregar Nuevo Recurso</h2>
    <div class="d-flex justify-content-center align-items-center">
        <div class="card shadow-lg border-0 rounded-lg mt-5" style="width: 50%;">
            <div class="card-body">
                <form action="../controllers/controller.php" method="post">
                    <input type="hidden" name="action" value="guardarRecurso">
                    <div class="mb-3">
                        <label for="descripcion" class="form-label fw-medium">Descripción</label>
                        <input type="text" class="form-control fw-medium" id="descripcion" name="descripcion" required>
                    </div>
                    <div class="mb-3">
                        <label for="valor" class="form-label fw-medium">Valor:</label>
                        <input type="number" class="form-control fw-medium" id="valor" name="valor" required>
                    </div>
                    <div class="mb-3 text-center p-2">
                        <button type="submit" value="Guardar" class="btn btn-outline-primary shadow-sm">Registrar</button>
                        <a href="sources.php" class="btn btn-outline-danger shadow-sm" style="width: 110px;"><i class="bi bi-x-lg"></i> Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>

</html>