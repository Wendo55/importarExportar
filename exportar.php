<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd a xml";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tabla = $_POST['tabla'];

    $sql = "SELECT * FROM $tabla";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $xmlDoc = new DOMDocument('1.0', 'utf-8');
        $xmlDoc->formatOutput = true; 
        $root = $xmlDoc->createElement($tabla);
        $xmlDoc->appendChild($root);

        while ($row = $result->fetch_assoc()) {
            $elemento = $xmlDoc->createElement('registro');
            foreach ($row as $key => $value) {
                $campo = $xmlDoc->createElement($key, $value);
                $elemento->appendChild($campo);
            }
            $root->appendChild($elemento);
        }

        $xmlDoc->save($tabla . 'from_db.xml');
        echo 'Datos extraídos y guardados en XML correctamente.';
    } else {
        echo 'No se encontraron datos en la tabla seleccionada.';
    }
} else {
    echo 'Error: No se han enviado datos del formulario.';
}

$conn->close();
?>
