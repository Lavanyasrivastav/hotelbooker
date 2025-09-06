<?php
// Include DB connection
require_once "../backend/db.php";


$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    if (!empty($username) && !empty($email) && !empty($_POST["password"])) {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Email already registered!";
        } else {
            // Insert user into database
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password);

            if ($stmt->execute()) {
                $message = "Signup successful! <a href='login.php'>Login here</a>";
            } else {
                $message = "Something went wrong. Try again!";
            }
        }
        $stmt->close();
    } else {
        $message = "All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #0f172a;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .signup-container {
            background: #fff;
            padding: 20px 25px;
            border-radius: 10px;
            box-shadow: 0px 2px 10px rgba(0,0,0,0.2);
            width: 350px;
        }
        .signup-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #218838;
        }
        .message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Create Account</h2>
        <?php if (isset($_GET['logged_out']) && $_GET['logged_out'] === 'true'): ?>
            <div class="alert alert-success text-center">You have been logged out successfully.</div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="username" placeholder="Enter Username" required>
            <input type="email" name="email" placeholder="Enter Email" required>
            <input type="password" name="password" placeholder="Enter Password" required>
            <button type="submit">Sign Up</button>
        </form>
        <p class="message"><?php echo $message; ?></p>
        <p style="text-align:center;">Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
v