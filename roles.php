<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Utenti</title>
</head>
<body>
    <h1>Gestione Utenti</h1>

    <?php
    // Connessione al database
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "nome_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica della connessione
    if ($conn->connect_error) {
        die("Connessione fallita: " . $conn->connect_error);
    }

    // Funzione per ottenere la lista paginata di utenti
    function getUsers($page, $perPage) {
        global $conn;
        $start = ($page - 1) * $perPage;
        $sql = "SELECT users.*, roles.role_name FROM users LEFT JOIN roles ON users.role_id = roles.id LIMIT $start, $perPage";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }

    // Funzione per contare il numero totale di utenti
    function getTotalUsers() {
        global $conn;
        $sql = "SELECT COUNT(*) AS total FROM users";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    // Parametri per la paginazione
    $perPage = 10; // Numero di utenti per pagina
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $totalUsers = getTotalUsers();
    $totalPages = ceil($totalUsers / $perPage);

    // Ottenere la lista degli utenti per la pagina corrente
    $users = getUsers($page, $perPage);

    // Mostrare la tabella degli utenti
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Ruolo</th></tr>";
    foreach ($users as $user) {
        echo "<tr>";
        echo "<td>" . $user['id'] . "</td>";
        echo "<td>" . $user['username'] . "</td>";
        echo "<td>" . $user['email'] . "</td>";
        echo "<td>" . $user['role_name'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";

    // Mostrare i link per la paginazione
    echo "<br>";
    echo "Pagina: ";
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
            echo "<strong>$i</strong> ";
        } else {
            echo "<a href='?page=$i'>$i</a> ";
        }
    }

    // Chiudere la connessione al database
    $conn->close();
    ?>

</body>
</html>
