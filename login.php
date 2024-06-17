<?php
include("connectdb.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['loginUsername'];
    $password = $_POST['loginPassword'];

    // Fetch the user from the database using a prepared statement
    $sql = "SELECT id_user, username, password, role FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Directly compare the password
        if ($password == $user['password']) {
            echo "Login successful. Welcome, " . $user['username'];
            session_start();
            $_SESSION['username'] = $user['username']; // Start the session and set session variables
            header("Location: admin_dasboard.php");
            exit(); // Ensure no further code is executed
        } else {
            echo "<script>alert('Login Failed!');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        }
    } else {
        echo "<script>alert('Login Failed!');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
