<?php
// Path to the JSON file
$jsonFile = 'users.json';

// Function to retrieve users from JSON file
function getUsersFromJson($jsonFile) {
    if (file_exists($jsonFile)) {
        $jsonData = file_get_contents($jsonFile);
        return json_decode($jsonData, true); // Convert JSON to array
    }
    return [];
}

// Function to save a new user to the JSON file
function saveUserToJson($username, $email, $password, $jsonFile) {
    $users = getUsersFromJson($jsonFile);

    // Check if the username or email already exists
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            return "Username already taken";
        }
        if ($user['email'] === $email) {
            return "Email already in use";
        }
    }

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Add new user to the array
    $users[] = [
        'username' => $username,
        'email' => $email,
        'password' => $hashedPassword
    ];

    // Save the updated users list back to the JSON file
    file_put_contents($jsonFile, json_encode($users, JSON_PRETTY_PRINT));
    return "Account created successfully!";
}

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Save new user to JSON
    $result = saveUserToJson($username, $email, $password, $jsonFile);

    if ($result === "Account created successfully!") {
        // Redirect to login page after successful sign up
        header("Location: login.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>$result</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - SaveSmiles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SaveSmiles</a>
        </div>
    </nav>

    <section class="signup-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2 class="text-center">Sign Up</h2>
                    <form action="signup.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                    </form>
                    <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
