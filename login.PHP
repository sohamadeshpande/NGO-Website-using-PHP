<?php
session_start();

// Path to the JSON file
$jsonFile = 'users.json';

// Function to retrieve users from the JSON file
function getUsersFromJson($jsonFile) {
    if (file_exists($jsonFile)) {
        $jsonData = file_get_contents($jsonFile);
        return json_decode($jsonData, true); // Convert JSON to array
    }
    return [];
}

// Function to verify login credentials
function verifyLogin($username, $password, $jsonFile) {
    $users = getUsersFromJson($jsonFile);

    foreach ($users as $user) {
        // Verify username and hashed password
        if ($user['username'] == $username && password_verify($password, $user['password'])) {
            return true;
        }
    }
    return false;
}

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Verify login
    if (verifyLogin($username, $password, $jsonFile)) {
        $_SESSION['username'] = $username; // Store username in session
        echo "Login successful! Welcome, " . $username;
        // Redirect to a dashboard or homepage
        header("Location: wt_Cp_newcss.html");
        exit();
    } else {
        echo "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SaveSmiles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="WT_CP_css.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SaveSmiles</a>
        </div>
    </nav>

    <section class="login-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2 class="text-center">Login</h2>
                    <form action="login.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                    <p class="mt-3 text-center">Don't have an account? <a href="signup.php">Sign Up</a></p>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
