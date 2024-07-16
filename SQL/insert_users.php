<?php

require_once('DB/config.php');

$password1 = password_hash('admin12345', PASSWORD_DEFAULT);

$sql = "INSERT INTO usuario (email, password) VALUES 
        ('admin@gmail.com', '$password1')";

if ($conn->query($sql) === TRUE) {
    echo "Usuario insertado exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
