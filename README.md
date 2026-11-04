🧪 Molecular Solubility Prediction Platform

An AI-powered web application that predicts the aqueous solubility of chemical compounds using Machine Learning. The platform combines a Python-based predictive model with a PHP and MySQL web application, allowing users to submit molecular structures, obtain solubility predictions, and track their prediction history.

🚀 Overview

Molecular solubility is an important property in chemistry and drug discovery. This project uses Machine Learning to estimate the aqueous solubility of molecules based on their chemical structures.

The application integrates a trained Machine Learning model into a web-based platform with user authentication and prediction history management.

✨ Features

- Molecular Solubility Prediction: Predicts the aqueous solubility (logS) of chemical compounds.
- Machine Learning Integration: Uses a trained Random Forest model for prediction.
- Molecular Fingerprints: Generates Morgan fingerprints using RDKit.
- User Authentication: Supports user registration and login.
- Prediction History: Stores and displays previous predictions for individual users.
- Database Integration: Uses MySQL to manage user accounts and prediction records.
- Web Interface: Provides an interface for submitting molecules and viewing prediction results.

🧠 Machine Learning

The predictive model was developed using the ESOL (Delaney) dataset.

Dataset information:

- Dataset: ESOL (Delaney)
- Number of molecules: 1,128
- Target variable: Experimental aqueous solubility (logS)

Model development:

1. Load and preprocess molecular data.
2. Convert molecular structures into Morgan fingerprints.
3. Generate molecular representations using RDKit.
4. Train a Random Forest Regression model.
5. Evaluate model performance.
6. Save the trained model for integration into the web application.

Model configuration:

- Algorithm: Random Forest Regressor
- Number of estimators: 300
- Fingerprint radius: 2
- Fingerprint size: 2,048 bits

🛠️ Technologies Used

Category| Technologies
Programming Language| Python
Machine Learning| Scikit-learn
Cheminformatics| RDKit
Data Processing| Pandas, NumPy
Backend| PHP
Database| MySQL
Frontend| HTML, CSS, JavaScript
Local Development| Laragon
Version Control| Git, GitHub

🏗️ System Architecture

The application combines two main components:

1. Machine Learning Component

- Processes molecular structures.
- Generates molecular fingerprints.
- Loads the trained Random Forest model.
- Produces solubility predictions.

2. Web Application Component

- Handles user registration and authentication.
- Accepts molecular input.
- Communicates with the Python prediction backend.
- Displays prediction results.
- Stores prediction history in MySQL.

📂 Project Structure

molecular-solubility-platform/
│
├── backend/
│   ├── config/
│   └── prediction/
│       └── predict.php
│
├── frontend/
│   ├── prediction.php
│   └── history.php
│
├── app.py
├── predict_solubility.py
├── solubility_model.joblib
│
└── README.md

Note: Update this structure if your actual repository contains additional folders or files.

⚙️ Installation and Setup

Prerequisites

- Python 3.x
- Laragon
- MySQL
- Git

1. Clone the repository

git clone https://github.com/Amaya237/molecular-solubility-platform.git

2. Move the project

Place the project folder inside the Laragon "www" directory.

3. Install Python dependencies

pip install pandas numpy scikit-learn rdkit joblib

4. Configure the database

- Start Apache and MySQL through Laragon.
- Open phpMyAdmin.
- Create the required MySQL database.
- Configure the database connection in the backend configuration file.

5. Run the application

Open the following URL in your browser:

http://localhost/molecular-solubility-platform/

🎯 Project Objectives

- Apply Machine Learning to a real-world chemistry problem.
- Explore molecular representations and cheminformatics.
- Integrate a Python-based ML model into a web application.
- Develop practical experience with backend development and database management.
- Build an end-to-end application combining AI/ML and full-stack technologies.

🔮 Future Improvements

- Add additional regression algorithms such as XGBoost.
- Improve model evaluation and generalization.
- Introduce molecular similarity analysis.
- Add prediction confidence and applicability-domain assessments.
- Improve the user interface and visualization of molecular properties.

👩‍💻 Author

Amaya Perera

Computer Science Undergraduate | AI & Machine Learning Enthusiast

- GitHub: "@Amaya237" (https://github.com/Amaya237)

---

This project was developed as an educational and portfolio project exploring the integration of Machine Learning, cheminformatics, and full-stack web development.