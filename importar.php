<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd a xml";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['archivoXML'])) {
    $archivoXML = $_FILES['archivoXML']['tmp_name'];
    $xml = simplexml_load_file($archivoXML) or die("Error al cargar el archivo XML");

    foreach ($xml->registro as $registro) {
        $id = $registro->id;
        $nombre = $registro->nombre;
        $email = $registro->email;
        $clave = $registro->clave;

        $sql = "INSERT INTO usuarios (id, nombre, email, clave)
                VALUES ('$id', '$nombre', '$email', '$clave')";

        if ($conn->query($sql) === TRUE) {
            echo "Datos insertados correctamente en la base de datos.<br>";
        } else {
            echo "Error al insertar datos: " . $conn->error . "<br>";
        }
    }
} else {
    echo 'Error: No se ha enviado un archivo XML.';
}

$conn->close();
?>
