<?php
try {
    $name = $_POST['name'];
    $date_of_birth = $_POST['date_of_birth'];
    $date_of_death = $_POST['date_of_death'];
    $content = $_POST['content'];
    $author = $_POST['author'];

    $db = new PDO('sqlite:obituary_platform.db');

    $db->exec("CREATE TABLE IF NOT EXISTS obituaries (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        date_of_birth DATE NOT NULL,
        date_of_death DATE NOT NULL,
        content TEXT NOT NULL,
        author TEXT NOT NULL
    )");

    $stmt = $db->prepare("INSERT INTO obituaries (name, date_of_birth, date_of_death, content, author) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$name, $date_of_birth, $date_of_death, $content, $author]);

    echo "Obituary submitted successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
