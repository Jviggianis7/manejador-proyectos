<?php
session_start();
require_once '../DB/config.php';

function login($email, $password) {
    global $conn;

    $email = $conn->real_escape_string($email);
    $sql = "SELECT * FROM usuario WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['email'] = $user['email'];
            header("Location: ../views/dash.php");
            exit();
        } else {
            return "Contraseña incorrecta.";
        }
    } else {
        return "Usuario no encontrado.";
    }
}

function isLoggedIn() {
    return isset($_SESSION['email']);
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header("Location: ../index.php");
        exit();
    }
}


function guardarUsuario( $id_persona, $nombre, $apellidos, $direccion, $telefono, $sexo, $fechaNacimiento, $profesion)
{
    global $conn;
    $hoy = new DateTime();
    $fecha_nac = new DateTime($fechaNacimiento);
    $diferencia = $hoy->diff($fecha_nac);
    if ($diferencia->y < 15) {
        return "El $profesion debe tener al menos 15 años.";
    }
    $sql = "INSERT INTO personas (IdPersona, Nombre, Apellidos, Direccion, Telefono, Sexo, FechaNacimiento, Profesion) 
            VALUES ('$id_persona', '$nombre', '$apellidos', '$direccion', '$telefono', '$sexo', '$fechaNacimiento', '$profesion')";
    if (mysqli_query($conn, $sql)) {
        return "Usuario registrado con éxito.";
    } else {
        return "Error al registrar el usuario: " . mysqli_error($conn);
    }
}

function actualizarUsuario($id_persona, $nombre, $apellidos, $direccion, $telefono, $sexo, $fechaNacimiento, $profesion)
{
    global $conn;
    $sql = "UPDATE personas SET 
            Nombre='$nombre', Apellidos='$apellidos', Direccion='$direccion', 
            Telefono='$telefono', Sexo='$sexo', FechaNacimiento='$fechaNacimiento', Profesion='$profesion' 
            WHERE IdPersona='$id_persona'";
    if (mysqli_query($conn, $sql)) {
        return "Usuario actualizado con éxito.";
    } else {
        return "Error al actualizar el usuario: " . mysqli_error($conn);
    }
}

function guardarProyecto($descripcion, $fechaInicio, $fechaEntrega, $valor, $lugar, $responsable, $estado)
{
    global $conn;
    $fechaInicioObj = new DateTime($fechaInicio);
    $fechaFinalObj = new DateTime($fechaEntrega);
    $diferencia = $fechaInicioObj->diff($fechaFinalObj);
    if ($diferencia->days < 1) {
        return "Error en las fechas";
    } else {
        $estado = "En progreso";
    }
    if ($valor <= 0) {
        return "El valor del proyecto debe ser mayor que cero.";
    }

    $sql = "INSERT INTO proyectos (Descripcion, FechaInicio, FechaEntrega, Valor, Lugar, Responsable, Estado) 
            VALUES ('$descripcion', '$fechaInicio', '$fechaEntrega', '$valor', '$lugar', '$responsable', '$estado')";
    if (mysqli_query($conn, $sql)) {
        return "Proyecto registrado con éxito.";
    } else {
        return "Error al registrar el proyecto.";
    }
}

function actualizarProyecto($idProyecto, $descripcion, $fechaInicio, $fechaEntrega, $valor, $lugar, $responsable, $estado)
{
    global $conn;
    $fechaInicioObj = new DateTime($fechaInicio);
    $fechaFinalObj = new DateTime($fechaEntrega);
    $diferencia = $fechaInicioObj->diff($fechaFinalObj);
    if ($diferencia->days < 1) {
        return "Error en las fechas";
    }
    if ($valor <= 0) {
        return "El valor del proyecto debe ser mayor que cero.";
    }

    $sql = "UPDATE proyectos 
            SET Descripcion='$descripcion', FechaInicio='$fechaInicio', FechaEntrega='$fechaEntrega', Valor='$valor', Lugar='$lugar', Responsable='$responsable', Estado='$estado' 
            WHERE IdProyecto='$idProyecto'";
    if (mysqli_query($conn, $sql)) {
        return "Proyecto actualizado con éxito.";
    } else {
        return "Error al actualizar el proyecto.";
    }
}

function guardarActividad($descripcion, $fechaInicio, $fechaFinal, $idProyecto, $responsable, $presupuesto)
{
    global $conn;

    $fechaInicioObj = new DateTime($fechaInicio);
    $fechaFinalObj = new DateTime($fechaFinal);
    $diferencia = $fechaInicioObj->diff($fechaFinalObj);

    if ($diferencia->days < 1) {
        return "Error en las fechas";
    } else {
        $estado = "En progreso";
    }

    $sql_proyecto = "SELECT FechaInicio, FechaEntrega, Valor FROM proyectos WHERE IdProyecto='$idProyecto'";
    $result_proyecto = mysqli_query($conn, $sql_proyecto);
    $row_proyecto = mysqli_fetch_assoc($result_proyecto);

    $fechaInicioProyecto = new DateTime($row_proyecto['FechaInicio']);
    $fechaEntregaProyecto = new DateTime($row_proyecto['FechaEntrega']);
    $valor_proyecto = $row_proyecto['Valor'];

    if ($fechaInicioObj < $fechaInicioProyecto || $fechaFinalObj > $fechaEntregaProyecto) {
        return "El tiempo de la actividad excede el tiempo del proyecto.";
    }

    if ($presupuesto > $valor_proyecto) {
        return "El presupuesto de la actividad no puede ser mayor al valor del proyecto.";
    }

    $sql = "INSERT INTO actividades (Descripcion, FechaInicio, FechaFinal, IdProyecto, Responsable, Presupuesto, Estado) 
            VALUES ('$descripcion', '$fechaInicio', '$fechaFinal', '$idProyecto', '$responsable', '$presupuesto', '$estado')";
    if (mysqli_query($conn, $sql)) {
        return "Actividad registrada con éxito.";
    } else {
        return "Error al registrar la actividad: " . mysqli_error($conn);
    }
}


function actualizarActividad($idActividad, $descripcion, $fechaInicio, $fechaFinal, $idProyecto, $responsable, $presupuesto, $estado)
{
    global $conn;
    $fechaInicioObj = new DateTime($fechaInicio);
    $fechaFinalObj = new DateTime($fechaFinal);
    $diferencia = $fechaInicioObj->diff($fechaFinalObj);
    if ($diferencia->days < 1) {
        return "Error en las fechas";
    }
    $sql_proyecto = "SELECT FechaInicio, FechaEntrega FROM proyectos WHERE IdProyecto='$idProyecto'";
    $result_proyecto = mysqli_query($conn, $sql_proyecto);
    $row_proyecto = mysqli_fetch_assoc($result_proyecto);
    $fechaInicioProyecto = new DateTime($row_proyecto['FechaInicio']);
    $fechaEntregaProyecto = new DateTime($row_proyecto['FechaEntrega']);
    if ($fechaInicioObj < $fechaInicioProyecto || $fechaFinalObj > $fechaEntregaProyecto) {
        return "El tiempo de la actividad excede el tiempo del proyecto.";
    }
    $sql_valor_proyecto = "SELECT Valor FROM proyectos WHERE IdProyecto='$idProyecto'";
    $result_valor_proyecto = mysqli_query($conn, $sql_valor_proyecto);
    $valor_proyecto = mysqli_fetch_assoc($result_valor_proyecto)['Valor'];
    if ($presupuesto > $valor_proyecto) {
        return "El presupuesto de la actividad no puede ser mayor al valor del proyecto.";
    }

    $sql = "UPDATE actividades 
            SET Descripcion='$descripcion', FechaInicio='$fechaInicio', FechaFinal='$fechaFinal', IdProyecto='$idProyecto', Responsable='$responsable', Presupuesto='$presupuesto', Estado='$estado' 
            WHERE IdActividad='$idActividad'";
    if (mysqli_query($conn, $sql)) {
        return "Actividad actualizada con éxito.";
    } else {
        return "Error al actualizar la actividad.";
    }
}

function guardarTarea($descripcion, $fechaInicio, $fechaFinal, $idActividad)
{
    global $conn;
    $fechaInicioObj = new DateTime($fechaInicio);
    $fechaFinalObj = new DateTime($fechaFinal);
    $diferencia = $fechaInicioObj->diff($fechaFinalObj);
    if ($diferencia->days < 1) {
        return "Error en las fechas";
    } else {
        $estado = "En progreso";
    }
    $sql_actividad = "SELECT FechaInicio, FechaFinal FROM actividades WHERE IdActividad='$idActividad'";
    $result_actividad = mysqli_query($conn, $sql_actividad);
    $row_actividad = mysqli_fetch_assoc($result_actividad);
    $fechaInicioActividad = new DateTime($row_actividad['FechaInicio']);
    $fechaFinalActividad = new DateTime($row_actividad['FechaFinal']);
    if ($fechaInicioObj < $fechaInicioActividad || $fechaFinalObj > $fechaFinalActividad) {
        return "El tiempo de la tarea excede el tiempo de la actividad.";
    }

    $sql = "INSERT INTO tareas (Descripcion, FechaInicio, FechaFinal, IdActividad, Estado) 
            VALUES ('$descripcion', '$fechaInicio', '$fechaFinal', '$idActividad', '$estado')";
    if (mysqli_query($conn, $sql)) {
        return "Tarea registrada con éxito.";
    } else {
        return "Error al registrar la tarea.";
    }
}

function actualizarTarea($idTarea, $descripcion, $fechaInicio, $fechaFinal, $idActividad, $estado)
{
    global $conn;
    $fechaInicioObj = new DateTime($fechaInicio);
    $fechaFinalObj = new DateTime($fechaFinal);
    $diferencia = $fechaInicioObj->diff($fechaFinalObj);
    if ($diferencia->days < 1) {
        return "Error en las fechas";
    }
    $sql_actividad = "SELECT FechaInicio, FechaFinal FROM actividades WHERE IdActividad='$idActividad'";
    $result_actividad = mysqli_query($conn, $sql_actividad);
    $row_actividad = mysqli_fetch_assoc($result_actividad);
    $fechaInicioActividad = new DateTime($row_actividad['FechaInicio']);
    $fechaFinalActividad = new DateTime($row_actividad['FechaFinal']);
    if ($fechaInicioObj < $fechaInicioActividad || $fechaFinalObj > $fechaFinalActividad) {
        return "El tiempo de la tarea excede el tiempo de la actividad.";
    }

    $sql = "UPDATE tareas 
            SET Descripcion='$descripcion', FechaInicio='$fechaInicio', FechaFinal='$fechaFinal', IdActividad='$idActividad', Estado='$estado' 
            WHERE IdTarea='$idTarea'";
    if (mysqli_query($conn, $sql)) {
        return "Tarea actualizada con éxito.";
    } else {
        return "Error al actualizar la tarea.";
    }
}

function guardarRecurso($descripcion, $valor)
{
    global $conn;
    if ($valor <= 0) {
        return "El valor del recurso debe ser mayor que cero.";
    }

    $sql = "INSERT INTO recursos (Descripcion, Valor) VALUES ('$descripcion', '$valor')";
    if (mysqli_query($conn, $sql)) {
        return "Recurso registrado con éxito.";
    } else {
        return "Error al registrar el recurso.";
    }
}

function asignarRecursoTarea($idTarea, $idRecurso)
{
    global $conn;

    $sql_actividad = "SELECT a.Presupuesto FROM actividades a INNER JOIN tareas t ON a.IdActividad = t.IdActividad WHERE t.IdTarea='$idTarea'";
    $result_actividad = mysqli_query($conn, $sql_actividad);
    $row_actividad = mysqli_fetch_assoc($result_actividad);
    $presupuesto_actividad = $row_actividad['Presupuesto'];

    $sql_valor_recurso = "SELECT Valor FROM recursos WHERE IdRecurso='$idRecurso'";
    $result_valor_recurso = mysqli_query($conn, $sql_valor_recurso);
    $row_valor_recurso = mysqli_fetch_assoc($result_valor_recurso);
    $valor_recurso = $row_valor_recurso['Valor'];

    $sql_total_recursos_asignados = "SELECT SUM(r.Valor) AS Total FROM tareaxrecurso tr INNER JOIN recursos r ON tr.IdRecurso = r.IdRecurso WHERE tr.IdTarea = '$idTarea'";
    $result_total_recursos_asignados = mysqli_query($conn, $sql_total_recursos_asignados);
    $row_total_recursos_asignados = mysqli_fetch_assoc($result_total_recursos_asignados);
    $total_recursos_asignados = $row_total_recursos_asignados['Total'];

    if (($total_recursos_asignados + $valor_recurso) > $presupuesto_actividad) {
        return "El valor total de los recursos asignados excede el presupuesto de la actividad.";
    }
    $sql = "INSERT INTO tareaxrecurso (IdTarea, IdRecurso) VALUES ('$idTarea', '$idRecurso')";
    if (mysqli_query($conn, $sql)) {
        return "Recurso asignado a tarea con éxito.";
    } else {
        return "Error al asignar recurso a tarea.";
    }
}

function assignPersonToTask($idTarea, $idPersona, $duracion)
{
    global $conn;
    if ($duracion < 1) {
        return "La duración debe ser al menos 1 día.";
    }
    $sql = "SELECT FechaInicio, FechaFinal FROM tareas WHERE IdTarea = '$idTarea'";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $fechaInicio = new DateTime($row['FechaInicio']);
        $fechaFinal = new DateTime($row['FechaFinal']);
        $duracionMaxima = $fechaInicio->diff($fechaFinal)->days;

        $sql = "SELECT SUM(duracion) AS duracion_total FROM tareaxpersona WHERE IdTarea = '$idTarea'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $duracionTotalAsignada = $row['duracion_total'] ?? 0;

        if (($duracionTotalAsignada + $duracion) > $duracionMaxima) {
            return "La duración total asignada no puede exceder la duración disponible de la tarea.";
        }
    } else {
        return "Tarea no encontrada.";
    }
    $sql = "INSERT INTO tareaxpersona (IdTarea, IdPersona, duracion) VALUES ('$idTarea', '$idPersona', '$duracion')";
    if (mysqli_query($conn, $sql)) {
        return "Persona asignada con éxito.";
    } else {
        return "Error al asignar la persona.";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'entregarProyecto':
            $idProyecto = $_POST['idProyecto'];
            $sql = "UPDATE proyectos SET Estado = 'Entregado' WHERE IdProyecto = '$idProyecto'";
            if (mysqli_query($conn, $sql)) {
                header("Location: ../views/projects.php?message=Proyecto entregado con éxito");
            } else {
                header("Location: ../views/projects.php?message=Error al entregar el proyecto");
            }
            break;
        case 'entregarActividad':
            $idActividad = $_POST['idActividad'];
            $sql = "UPDATE actividades SET Estado = 'Entregado' WHERE idActividad = '$idActividad'";
            if (mysqli_query($conn, $sql)) {
                header("Location: ../views/activities.php?message=Actividad entregada con éxito");
            } else {
                header("Location: ../views/activities.php?message=Error al entregar la actividad");
            }
            break;
        case 'entregarTareas':
            $idTareas = $_POST['idTarea'];
            $sql = "UPDATE Tareas SET Estado = 'Entregado' WHERE idTarea = '$idTareas'";
            if (mysqli_query($conn, $sql)) {
                header("Location: ../views/tasks.php?message=Tarea entregada con éxito");
            } else {
                header("Location: ../views/tasks.php?message=Error al entregar la tarea");
            }
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    switch ($_POST['action']) {
        case 'guardarUsuario':
            $id_persona = $_POST['id_persona'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $sexo = $_POST['sexo'];
            $fechaNacimiento = $_POST['fechaNacimiento'];
            $profesion = $_POST['profesion'];
            $message = guardarUsuario($id_persona,$nombre, $apellidos, $direccion, $telefono, $sexo, $fechaNacimiento, $profesion);
            header("Location: ../views/users.php?message=$message");
            break;
        case 'actualizarUsuario':
            $id_persona = $_POST['id_persona'];
            $nombre = $_POST['nombre'];
            $apellidos = $_POST['apellidos'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $sexo = $_POST['sexo'];
            $fechaNacimiento = $_POST['fechaNacimiento'];
            $profesion = $_POST['profesion'];
            $message = actualizarUsuario($id_persona, $nombre, $apellidos, $direccion, $telefono, $sexo, $fechaNacimiento, $profesion);
            header("Location: ../views/users.php?message=$message");
            break;
        case 'guardarProyecto':
            $descripcion = $_POST['descripcion'];
            $fechaInicio = $_POST['fechaInicio'];
            $fechaEntrega = $_POST['fechaEntrega'];
            $valor = $_POST['valor'];
            $lugar = $_POST['lugar'];
            $responsable = $_POST['responsable'];
            $estado = $_POST['estado'];
            $message = guardarProyecto($descripcion, $fechaInicio, $fechaEntrega, $valor, $lugar, $responsable, $estado);
            header("Location: ../views/projects.php?message=$message");
            break;
        case 'actualizarProyecto':
            $idProyecto = $_POST['idProyecto'];
            $descripcion = $_POST['descripcion'];
            $fechaInicio = $_POST['fechaInicio'];
            $fechaEntrega = $_POST['fechaEntrega'];
            $valor = $_POST['valor'];
            $lugar = $_POST['lugar'];
            $responsable = $_POST['responsable'];
            $estado = $_POST['estado'];
            $message = actualizarProyecto($idProyecto, $descripcion, $fechaInicio, $fechaEntrega, $valor, $lugar, $responsable, $estado);
            header("Location: ../views/projects.php?message=$message");
            break;
        case 'guardarTarea':
            $descripcion = $_POST['descripcion'];
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFinal = $_POST['fechaFinal'];
            $idActividad = $_POST['idActividad'];
            $estado = $_POST['estado'];
            $message = guardarTarea($descripcion, $fechaInicio, $fechaFinal, $idActividad, $estado);
            header("Location: ../views/tasks.php?message=$message");
            break;
        case 'actualizarTarea':
            $idTarea = $_POST['idTarea'];
            $descripcion = $_POST['descripcion'];
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFinal = $_POST['fechaFinal'];
            $idActividad = $_POST['idActividad'];
            $estado = $_POST['estado'];
            $message = actualizarTarea($idTarea, $descripcion, $fechaInicio, $fechaFinal, $idActividad, $estado);
            header("Location: ../views/tasks.php?message=$message");
            break;
        case 'guardarActividad':
            $descripcion = $_POST['descripcion'];
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFinal = $_POST['fechaFinal'];
            $idProyecto = $_POST['idProyecto'];
            $responsable = $_POST['responsable'];
            $presupuesto = $_POST['presupuesto'];
            $estado = $_POST['estado'];
            $message = guardarActividad($descripcion, $fechaInicio, $fechaFinal, $idProyecto, $responsable, $presupuesto, $estado);
            header("Location: ../views/activities.php?message=$message");
            break;
        case 'actualizarActividad':
            $idActividad = $_POST['idActividad'];
            $descripcion = $_POST['descripcion'];
            $fechaInicio = $_POST['fechaInicio'];
            $fechaFinal = $_POST['fechaFinal'];
            $idProyecto = $_POST['idProyecto'];
            $responsable = $_POST['responsable'];
            $presupuesto = $_POST['presupuesto'];
            $estado = $_POST['estado'];
            $message = actualizarActividad($idActividad, $descripcion, $fechaInicio, $fechaFinal, $idProyecto, $responsable, $presupuesto, $estado);
            header("Location: ../views/activities.php?message=$message");
            break;
        case 'guardarRecurso':
            $descripcion = $_POST['descripcion'];
            $valor = $_POST['valor'];
            $message = guardarRecurso($descripcion, $valor);
            header("Location: ../views/sources.php?message=$message");
            break;
        case 'asignarRecursosTarea':
            $idTarea = $_POST['idTarea'];
            $idRecurso = $_POST['idRecurso'];
            $message = asignarRecursoTarea($idTarea, $idRecurso);
            header("Location: ../views/tasks.php?message=$message");
            break;
        case 'assignPersonToTask':
            $idTarea = $_POST['idTarea'];
            $idPersona = $_POST['idPersona'];
            $duracion = $_POST['duracion'];
            $message = assignPersonToTask($idTarea, $idPersona, $duracion);
            header("Location: ../views/form_task_person.php?idTarea=$idTarea&message=$message");
            break;
    }
}
