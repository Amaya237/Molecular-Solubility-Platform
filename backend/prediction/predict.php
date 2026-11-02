
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

    <title>Prediction Results | Molecular Platform</title>

    <link rel="stylesheet" href="../../frontend/css/result.css">
</head>

<body>

    <div class="result-container">

        <!-- Header -->
        <div class="result-header">

            <h1>Molecular Prediction Results</h1>

            <p>
                Your molecular solubility prediction has been completed.
            </p>

        </div>


        <!-- Main Result -->
        <div class="main-result">

            <span class="result-label">
                Predicted Solubility (logS)
            </span>

            <div class="log-value">
                <?php echo htmlspecialchars((string)$result["logS"]); ?>
            </div>

            <p>
                Estimated logarithmic solubility in mol/L.
            </p>

        </div>


        <!-- Result Cards -->
        <div class="result-grid">

            <div class="result-card">

                <h3>Classification</h3>

                <p>
                    <?php echo htmlspecialchars($result["classification"]); ?>
                </p>

            </div>


            <div class="result-card">

                <h3>Molecular Similarity</h3>

                <p>
                    <?php
                    echo htmlspecialchars(
                        (string)($result["similarity"] * 100)
                    ) . "%";
                    ?>
                </p>

            </div>

        </div>


        <!-- SMILES -->
        <div class="smiles-box">

            <h3>Input Molecule (SMILES)</h3>

            <p class="smiles-text">
                <?php echo htmlspecialchars($result["smiles"]); ?>
            </p>

        </div>


        <!-- Warning -->
        <?php if (!empty($result["warning"])): ?>

            <div class="warning-box">

                <strong>Prediction Warning</strong>

                <p>
                    <?php echo htmlspecialchars($result["warning"]); ?>
                </p>

            </div>

        <?php endif; ?>


        <!-- Actions -->
        <div class="result-actions">

            <a href="../../frontend/prediction.php"
               class="action-button">
                Try Another Molecule
            </a>

            <a href="../../frontend/history.php"
               class="action-button secondary-button">
                View History
            </a>

            <a href="../../dashboard.php"
               class="action-button secondary-button">
                Dashboard
            </a>

        </div>

    </div>

</body>
</html>
