
<?php

session_start();

require_once __DIR__ . "/../config/database.php";

// Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request.");
}

// Get form values
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

// Validate input
if ($email === "" || $password === "") {
    exit("Email and password are required.");
}

// Find user by email
$sql = "SELECT * FROM users WHERE email = :email";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ":email" => $email
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check whether user exists and password is correct
if ($user && password_verify($password, $user["password"])) {

    // Prevent session fixation
    session_regenerate_id(true);

    // Store user information in session
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["username"] = $user["username"];

    header("Location: ../../dashboard.php");
    exit(); 

} else {

    echo "Invalid email or password.";

}

?>
