<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buscador de GIFs</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f0f0f0;
    }

    .container {
        width: 400px;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    input[type="number"] {
        flex: 1;
        padding: 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    img {
        max-width: 100%;
        margin-top: 20px;
        display: block;
    }
</style>
</head>
<body>
    <div class="container">
        <h1>Buscador de GIFs</h1>
        <form method="post">
            <input type="number" id="numero" name="numero" placeholder="Ingrese un número" required>
            <button type="submit">Buscar</button>
        </form>
        <?php
        if (isset($_POST['numero'])) {
            $numero = $_POST['numero'];
            $url = "http://localhost:5162/api?numero={$numero}";
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            if ($data && isset($data['results'][$numero - 1]['media'][0]['gif']['url'])) {
                $gifUrl = $data['results'][$numero - 1]['media'][0]['gif']['url'];
                echo "<img src='{$gifUrl}' alt='GIF'>";
                echo "
                <form method='post'>
                    <input type='hidden' name='gif_url' value='{$gifUrl}'>
                    <button type='submit' name='save_gif' style='margin-top: 10px; background-color: #28a745;'>Guardar GIF</button>
                </form>";
            } else {
                echo '<p>No se encontró un GIF para el número ingresado</p>';
            }
        }

        if (isset($_POST['save_gif'])) {
            $gifUrl = $_POST['gif_url'];
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "gifdb";
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Error de conexión: " . $conn->connect_error);
            }
            $sql = "INSERT INTO gifs (url) VALUES ('{$gifUrl}')";
            if ($conn->query($sql) === TRUE) {
                echo "<p>URL del GIF guardada correctamente en la base de datos</p>";
            } else {
                echo "Error al guardar la URL del GIF en la base de datos: " . $conn->error;
            }
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
