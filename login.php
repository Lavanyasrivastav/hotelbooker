<?php
session_start();
require_once __DIR__ . "/../backend/db.php";

$message = "";
if (!isset($pdo)) {
    die("Database connection not established. Check db.php.");
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $message = "Please enter both email and password.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Store session data
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                // Redirect to Suggest Advice page
                header("Location: suggest_advice.php");
                exit;
            } else {
                $message = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            $message = "Database error: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Krishi Sahayak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; font-family: 'Inter', sans-serif; }
        .login-container { max-width: 400px; margin: 80px auto; padding: 25px; background: #f3f1f1ff; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.1); }
        .login-container h2 { text-align: center; margin-bottom: 20px; font-weight: 700; color: #16a34a; }
        .btn-success { background: #16a34a; border: none; }
        .btn-success:hover { background: #15803d; }
    </style>
</head>
<body>
<div class="login-container">
    <h2>User Login</h2>
    <?php if ($message): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Login</button>
    </form>
    <p class="text-center mt-3">Don't have an account? <a href="signup.php">Sign Up</a></p>
</div>
</body>
</html>
