<?php
include("connectdb.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['registerUsername'];
    $password = $_POST['registerPassword'];
    $role = 'user'; // default role

    // Check if the username already exists
    $check_sql = "SELECT username FROM user WHERE username = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        // Username already exists
        echo "<script>alert('Username already exists. Please choose a different username.');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        // Directly use the password without hashing
        $plain_password = $password;

        // Insert the new user into the database
        $sql = "INSERT INTO user (username, password, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $plain_password, $role);

        if ($stmt->execute()) {
            echo "<script>alert('Registration Successful');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $check_stmt->close();
    $conn->close();
}
?>
