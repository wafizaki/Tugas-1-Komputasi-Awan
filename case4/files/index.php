<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Chuck Norris Knowledge Warehouse</title>
    <style>
        body { font-family: sans-serif; max-width: 800px; margin: 2rem auto; padding: 0 1rem; background-color: #f4f4f9; }
        h1 { color: #333; border-bottom: 2px solid #e67e22; padding-bottom: 10px; }
        .card { background: white; padding: 1.5rem; margin-bottom: 1rem; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .timestamp { color: #888; font-size: 0.8rem; margin-bottom: 0.5rem; }
        .joke-content { font-size: 1.2rem; color: #2c3e50; line-height: 1.6; }
        .refresh-btn { display: inline-block; padding: 10px 20px; background: #e67e22; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px; }
        .refresh-btn:hover { background: #d35400; }
    </style>
</head>
<body>

    <h1>🤠 Chuck Norris Facts Archive</h1>
    <a href="index.php" class="refresh-btn">🔄 Refresh Data</a>

    <?php
    $servername = "mysql1"; // Nama container MySQL
    $username = "root";
    $password = "mydb6789tyui";
    $dbname = "mydb";

    // 1. Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 2. Check connection
    if ($conn->connect_error) {
        echo "<div class='card' style='color:red'>Connection failed: " . $conn->connect_error . "</div>";
    } else {
        // 3. Query Data
        $sql = "SELECT * FROM jokes ORDER BY created_at DESC LIMIT 10";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // 4. Output Data
            while($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<div class='timestamp'>📅 " . $row["created_at"] . " | ID: " . $row["filename"] . "</div>";
                echo "<div class='joke-content'>\"" . $row["content"] . "\"</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='card'>Belum ada jokes yang masuk. Tunggu sebentar lagi...</div>";
        }
        $conn->close();
    }
    ?>

</body>
</html>
