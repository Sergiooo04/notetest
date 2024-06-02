<?php
// login.php
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'];
$password = $input['password'];

// Conectar a la base de datos
$servername = "localhost";
$dbname = "notetest";
$dbusername = "root";
$dbpassword = "";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Preparar y ejecutar la consulta
$sql = $conn->prepare("SELECT * FROM usuarios WHERE username = ? AND password = ?");
$sql->bind_param("ss", $username, $password);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    echo($result);
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}

$sql->close();
$conn->close();
?>
