<?php
include 'config.php';

// Aggiungi Utente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql = "INSERT INTO utenti (nome, email) VALUES ('$nome', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo "Utente aggiunto con successo.";
    } else {
        echo "Errore durante l'aggiunta dell'utente: " . $conn->error;
    }
}

// Modifica Utente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql = "UPDATE utenti SET nome='$nome', email='$email' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Utente aggiornato con successo.";
    } else {
        echo "Errore durante l'aggiornamento dell'utente: " . $conn->error;
    }
}

// Elimina Utente
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM utenti WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Utente eliminato con successo.";
    } else {
        echo "Errore durante l'eliminazione dell'utente: " . $conn->error;
    }
}

// Recupera tutti gli utenti
$sql = "SELECT * FROM utenti";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestione Utenti</title>
</head>
<body>
    <h2>Aggiungi Nuovo Utente</h2>
    <form method="post">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <input type="submit" name="add_user" value="Aggiungi Utente">
    </form>

    <h2>Lista Utenti</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Azioni</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nome"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td><a href='?delete_id=" . $row["id"] . "'>Elimina</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nessun utente trovato.</td></tr>";
        }
        ?>
    </table>

    <h2>Modifica Utente</h2>
    <form method="post">
        <label for="id">ID Utente:</label>
        <input type="number" name="id" required><br>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <input type="submit" name="update_user" value="Aggiorna Utente">
    </form>
</body>
</html>
