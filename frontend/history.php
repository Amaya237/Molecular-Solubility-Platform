
<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.html");
    exit();
}

require_once __DIR__ . "/../backend/config/database.php";

$username = htmlspecialchars($_SESSION["username"]);

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

    <title>Prediction History | Molecular Platform</title>

    <link rel="stylesheet" href="css/history.css">
</head>

<body>

    <div class="dashboard-layout">

        <!-- Sidebar -->
        <aside class="sidebar">

            <div class="logo">
                Molecular Platform
            </div>

            <nav>
                <a href="../dashboard.php">Dashboard</a>
                <a href="prediction.php">New Prediction</a>
                <a href="history.php" class="active">Prediction History</a>
                <a href="../backend/auth/logout.php">Logout</a>
            </nav>

        </aside>


        <!-- Main Content -->
        <main class="main-content">

            <div class="topbar">
                <h2>Prediction History</h2>
                <p>Welcome, <?php echo $username; ?></p>
            </div>


            <!-- Page Introduction -->
            <section class="page-header">

                <div>
                    <h1>Your Prediction History</h1>

                    <p>
                        Review your previous molecular
                        solubility predictions.
                    </p>
                </div>

                <a href="prediction.php" class="primary-button">
                    + New Prediction
                </a>

            </section>


            <!-- History Summary -->
            <section class="summary-card">

                <div>
                    <h3>Total Predictions</h3>

                    <p class="total-count">
                        <?php echo count($history); ?>
                    </p>
                </div>

            </section>


            <!-- Prediction Table -->
            <section class="history-section">

                <h2>Previous Predictions</h2>

                <?php if (count($history) > 0): ?>

                    <div class="table-container">

                        <table>

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>SMILES</th>
                                    <th>Predicted logS</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php foreach ($history as $prediction): ?>

                                    <tr>

                                        <td>
                                            #<?php echo htmlspecialchars((string)$prediction["id"]); ?>
                                        </td>

                                        <td class="smiles">
                                            <?php echo htmlspecialchars($prediction["smiles"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars((string)$prediction["predicted_solubility"]); ?>
                                        </td>

                                        <td>
                                            <?php echo htmlspecialchars($prediction["created_at"]); ?>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                <?php else: ?>

                    <div class="empty-state">

                        <h3>No Predictions Yet</h3>

                        <p>
                            You haven't made any molecular
                            solubility predictions yet.
                        </p>

                        <a href="prediction.php" class="primary-button">
                            Make Your First Prediction
                        </a>

                    </div>

                <?php endif; ?>

            </section>

        </main>

    </div>

</body>
</html>
