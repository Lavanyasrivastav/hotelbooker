<?php
session_start();
require_once __DIR__ . "/../backend/db.php";

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $designation = trim($_POST["designation"]);
    $contact = trim($_POST["contact"]);
    $advice = trim($_POST["advice"]);
    $user_id = $_SESSION['user_id'];

    if (empty($name) || empty($advice)) {
        $message = "Name and advice are required.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO suggestions (user_id, name, designation, contact, advice) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $name, $designation, $contact, $advice]);
            $message = "Thank you! Your advice has been submitted successfully.";
        } catch (PDOException $e) {
            $message = "Error: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggest Advice - Smart Krishi Sahayak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f9fafb; font-family: 'Inter', sans-serif; }
        .container { max-width: 700px; margin-top: 50px; }
        .card { border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); }
        .btn-success { background: #16a34a; border: none; }
        .btn-success:hover { background: #15803d; }
        footer { text-align: center; padding: 15px; margin-top: 20px; background: #111827; color: #fff; }
        footer a { color: #16a34a; text-decoration: none; }
    </style>
</head>
<body>
<div class="container">
    <div class="card p-4">
        <h3 class="mb-3 text-success">Submit Your Advisory Suggestion</h3>
        <?php if ($message): ?>
            <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Your Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Designation (Village/District Role)</label>
                <input type="text" name="designation" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Your Advisory</label>
                <textarea name="advice" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-success w-100">Submit Advice</button>
        </form>
    </div>
</div>

<footer>
    Contact Organizer: <a href="tel:+919876543210">+91 98765 43210</a>
    <br>
    <a href="logout.php" style="color:#fbbf24;">Logout</a>
</footer>
</body>
</html>
