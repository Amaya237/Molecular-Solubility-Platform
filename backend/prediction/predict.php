
<?php

session_start();

require_once __DIR__ . "/../config/database.php";

// Check login status
if (!isset($_SESSION["user_id"])) {
    header("Location: ../../frontend/login.html");
    exit();
}

// Accept POST requests only
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request.");
}

// Get SMILES input
$smiles = trim($_POST["smiles"] ?? "");

if ($smiles === "") {
    exit("Please enter a SMILES string.");
}

if (strlen($smiles) > 1000) {
    exit("SMILES input is too long.");
}

// Define Python file location
$pythonScript = __DIR__ . "/../../ml/predict_for_web.py";

// Execute Python
$command = "py " .
    escapeshellarg($pythonScript) . " " .
    escapeshellarg($smiles);

exec($command, $output, $returnCode);

// Convert Python output into a string
$pythonOutput = implode("\n", $output);

// Decode JSON
$result = json_decode($pythonOutput, true);

// Check prediction result
if ($returnCode !== 0 || !is_array($result) || !isset($result["success"])) {
    exit("Unable to process the prediction. Please try again.");
}

if (!$result["success"]) {
    exit(htmlspecialchars($result["error"] ?? "Prediction failed."));
}


// Save prediction to database
try {

    $sql = "INSERT INTO search_history
            (user_id, smiles, predicted_solubility)
            VALUES (:user_id, :smiles, :solubility)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ":user_id" => $_SESSION["user_id"],
        ":smiles" => $result["smiles"],
        ":solubility" => $result["logS"]
    ]);

} catch (PDOException $e) {

    error_log($e->getMessage());

    exit("Unable to save prediction history.");

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prediction Result</title>
</head>

<body>

    <h1>Molecular Prediction Result</h1>

    <p>
        <strong>SMILES:</strong>
        <?php echo htmlspecialchars($result["smiles"]); ?>
    </p>

    <p>
        <strong>Predicted logS:</strong>
        <?php echo htmlspecialchars((string)$result["logS"]); ?>
    </p>

    <p>
        <strong>Classification:</strong>
        <?php echo htmlspecialchars($result["classification"]); ?>
    </p>

    <p>
        <strong>Similarity:</strong>
        <?php echo htmlspecialchars((string)$result["similarity"]); ?>
    </p>

    <?php if (!empty($result["warning"])): ?>
        <p>
            <strong>Warning:</strong>
            <?php echo htmlspecialchars($result["warning"]); ?>
        </p>
    <?php endif; ?>

    <a href="../../frontend/prediction.php">Try Another Molecule</a>

</body>
</html>
