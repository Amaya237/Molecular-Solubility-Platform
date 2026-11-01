
<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Molecular Prediction | Molecular Platform</title>

    <link rel="stylesheet" href="css/prediction.css">
</head>

<body>

    <div class="prediction-container">

        <header class="page-header">
            <a href="../dashboard.php">← Back to Dashboard</a>
            <h1>Molecular Solubility Prediction</h1>
            <p>
                Predict the aqueous solubility of molecules
                using machine learning.
            </p>
        </header>

        <section class="prediction-card">

            <h2>Enter Molecular Structure</h2>

            <p>
                Provide the SMILES notation of the molecule
                you want to analyse.
            </p>

            <form action="../backend/prediction/predict.php"
                  method="POST">

                <label for="smiles">SMILES Notation</label>

                <textarea
                    id="smiles"
                    name="smiles"
                    placeholder="Example: CCO"
                    rows="4"
                    required
                ></textarea>

                <p class="input-hint">
                    Example: CCO represents ethanol.
                </p>

                <button type="submit">
                    Predict Solubility
                </button>

            </form>

        </section>

        <section class="information-card">

            <h2>About SMILES</h2>

            <p>
                SMILES (Simplified Molecular Input Line Entry
                System) is a notation used to represent
                molecular structures as text.
            </p>

            <p>
                Our platform uses molecular fingerprints
                and machine learning to estimate solubility.
            </p>

        </section>

    </div>

</body>
</html>
