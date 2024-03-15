<?php
session_start();
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php");
    exit();
}

include 'db_connection.php';

// Verifica se o formulário de geração de QR code foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $data = $_POST['data'];

    // Gera o QR code e insere no banco de dados
    $api_url = "https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl=" . urlencode($data);
    $sql = "INSERT INTO qrcodes (title, data, image_url) VALUES ('$title', '$data', '$api_url')";
    if ($conn->query($sql) === TRUE) {
        echo "QR code gerado e inserido com sucesso";
    } else {
        echo "Erro ao gerar QR code: " . $conn->error;
    }
}

// Verifica se a requisição de exclusão foi enviada
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete']) && isset($_GET['id'])) {
    // Exclui o QR code do banco de dados
    $id = $_GET['id'];
    $sql_delete_qrcode = "DELETE FROM qrcodes WHERE id=$id";
    if ($conn->query($sql_delete_qrcode) === TRUE) {
        echo "QR code excluído com sucesso";
    } else {
        echo "Erro ao excluir QR code: " . $conn->error;
    }
}

// Consulta o banco de dados para recuperar todos os QR codes
$sql_select_qrcodes = "SELECT * FROM qrcodes";
$result_select_qrcodes = $conn->query($sql_select_qrcodes);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
      body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
}

.form {
    margin-bottom: 20px;
}

.form input[type="text"] {
    width: calc(100% - 80px);
    padding: 10px;
    margin-right: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.form button {
    padding: 10px 20px;
    border: none;
    background-color: #007bff;
    color: #fff;
    border-radius: 4px;
    cursor: pointer;
}

.qrcodes-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.qrcode {
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 20px;
}

.qrcode img {
    width: 150px;
    height: 150px;
    margin-bottom: 10px;
}

.qrcode p {
    margin: 0;
}

.qrcode button {
    padding: 5px 10px;
    border: none;
    background-color: #dc3545;
    color: #fff;
    border-radius: 4px;
    cursor: pointer;
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Painel de Administração</h1>
        <form id="qrForm" action="" method="post">
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="data">Dados do QR Code:</label>
                <input type="text" id="data" name="data" required>
            </div>
            <button type="submit">Gerar QR Code</button>
        </form>
        <div id="qrcodes" class="qrcodes-container">
            <!-- Exibe os QR Codes gerados -->
            <?php
            if ($result_select_qrcodes->num_rows > 0) {
                while($row = $result_select_qrcodes->fetch_assoc()) {
                    echo '<div class="qrcode">';
                    echo '<h2>' . $row['title'] . '</h2>';
                    echo '<img src="' . $row['image_url'] . '" alt="QR Code">';
                    echo '<p><strong>Dados:</strong> ' . $row['data'] . '</p>';
                    echo '<button class="delete-btn" onclick="deleteQRCode(' . $row['id'] . ')">Excluir</button>';
                    echo '</div>';
                }
            } else {
                echo "Nenhum QR code encontrado";
            }
            ?>
        </div>
        <a href="logout.php">Sair</a>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function deleteQRCode(id) {
            if (confirm("Tem certeza de que deseja excluir este QR code?")) {
                window.location.href = "admin.php?delete=true&id=" + id;
            }
        }
    </script>
</body>
</html>
