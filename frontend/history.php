
<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

require_once __DIR__ . "/../backend/config/database.php";

$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM search_history
        WHERE user_id = :user_id
        ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ":user_id" => $user_id
]);

$history = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prediction History</title>
</head>
<body>

    <h1>Prediction History</h1>

    <?php if (count($history) > 0): ?>

        <?php foreach ($history as $prediction): ?>

            <div>
                <h3>Prediction #<?php echo $prediction["id"]; ?></h3>

                <p>
                    <strong>SMILES:</strong>
                    <?php echo htmlspecialchars($prediction["smiles"]); ?>
                </p>

                <p>
                    <strong>Predicted logS:</strong>
                    <?php echo htmlspecialchars((string)$prediction["predicted_solubility"]); ?>
                </p>

                <p>
                    <strong>Date:</strong>
                    <?php echo htmlspecialchars($prediction["created_at"]); ?>
                </p>

                <hr>
            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <p>You have no prediction history yet.</p>

    <?php endif; ?>

    <a href="prediction.php">Make a New Prediction</a>
    <br>
    <a href="../dashboard.php">Back to Dashboard</a>

</body>
</html>
