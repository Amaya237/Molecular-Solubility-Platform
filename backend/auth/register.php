
<?php

require_once __DIR__ . "/../config/database.php";

// Check whether the form was submitted
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request.");
}

// Get form values
$username = trim($_POST["username"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

// Validate input
if ($username === "" || $email === "" || $password === "") {
    exit("All fields are required.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Please enter a valid email address.");
}

if (strlen($username) > 100) {
    exit("Username is too long.");
}

if (strlen($email) > 150) {
    exit("Email is too long.");
}

if (strlen($password) < 8) {
    exit("Password must contain at least 8 characters.");
}

// Hash the password
$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);

// Insert user into database
try {

    $sql = "INSERT INTO users (username, email, password)
            VALUES (:username, :email, :password)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ":username" => $username,
        ":email" => $email,
        ":password" => $hashedPassword
    ]);

    echo "Registration successful!";

} catch (PDOException $e) {

    if ($e->getCode() === "23000") {
        echo "This email is already registered.";
    } else {
        error_log($e->getMessage());
        echo "Something went wrong. Please try again.";
    }

}

?>
