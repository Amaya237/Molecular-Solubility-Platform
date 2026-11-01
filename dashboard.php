
<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: frontend/login.html");
    exit();
}

$username = htmlspecialchars($_SESSION["username"]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | Molecular Platform</title>

    <link rel="stylesheet" href="frontend/css/dashboard.css">
</head>

<body>

    <div class="dashboard-layout">

        <!-- Sidebar -->
        <aside class="sidebar">

            <div class="logo">
                Molecular Platform
            </div>

            <nav>
                <a href="#overview" class="active">Dashboard</a>
                <a href="frontend/prediction.php">New Prediction</a>
                <a href="#history">Prediction History</a>
                <a href="backend/auth/logout.php">Logout</a>
            </nav>

        </aside>


        <!-- Main Content -->
        <main class="main-content">

            <div class="topbar">
                <h2>Dashboard</h2>
                <p>Welcome, <?php echo $username; ?></p>
            </div>


            <!-- Welcome Section -->
            <section class="welcome-section" id="overview">

                <h1>Welcome to Molecular Platform!</h1>

                <p>
                    Explore molecular properties and predict
                    solubility using machine learning.
                </p>

                <a href="frontend/prediction.php" class="primary-button">
                    Start Prediction
                </a>

            </section>


            <!-- Features -->
            <h2 class="section-title">Your Workspace</h2>

            <div class="card-container">

                <div class="feature-card" id="prediction">

                    <h3>Molecular Prediction</h3>

                    <p>
                        Enter a molecular SMILES string and
                        predict its solubility using our
                        machine learning model.
                    </p>

                    <a href="#prediction" class="primary-button">
                        Coming Soon
                    </a>

                </div>


                <div class="feature-card" id="history">

                    <h3>Prediction History</h3>

                    <p>
                        View and manage your previous
                        molecular solubility predictions.
                    </p>

                    <a href="#history" class="primary-button">
                        Coming Soon
                    </a>

                </div>


                <div class="feature-card">

                    <h3>About the Platform</h3>

                    <p>
                        Learn how machine learning helps
                        estimate molecular solubility.
                    </p>

                </div>

            </div>

        </main>

    </div>

</body>
</html>
