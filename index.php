<?php

$host = getenv('DB_HOST') ?: 'mysql-service';
$db   = getenv('DB_NAME') ?: 'employee_db';
$user = getenv('DB_USER') ?: 'appuser';
$pass = getenv('DB_PASSWORD') ?: 'app123';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $address = $_POST["address"];

    $stmt = $conn->prepare(
        "INSERT INTO employees (name, address) VALUES (?, ?)"
    );

    $stmt->bind_param("ss", $name, $address);

    if ($stmt->execute()) {
        $message = "Employee saved successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Application</title>
</head>

<body>

<h1>ABC Technologies</h1>

<h2>Employee Registration</h2>

<form method="POST">

    <label>Employee Name:</label>
    <input type="text" name="name" required>

    <br><br>

    <label>Employee Address:</label>
    <textarea name="address" required></textarea>

    <br><br>

    <button type="submit">Save Employee</button>

</form>

<p>
<?php echo htmlspecialchars($message); ?>
</p>

</body>
</html>
