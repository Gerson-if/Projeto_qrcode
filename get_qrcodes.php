<?php
include 'db_connection.php';

// Recuperação de todos os QR codes do banco de dados
$sql = "SELECT * FROM qrcodes";
$result = $conn->query($sql);

// Exibição dos QR codes
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='qrcode'>";
        echo "<img src='".$row['image_url']."'>";
        echo "<p>".$row['data']."</p>";
        echo "<button class='deleteBtn' data-id='".$row['id']."'>Excluir</button>";
        echo "</div>";
    }
} else {
    echo "Nenhum QR code encontrado";
}

$conn->close();
?>
