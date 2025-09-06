<?php
header('Content-Type: application/json');
include 'db.php';

$action = $_GET['action'] ?? '';
$crop = $_GET['crop'] ?? '';
$lang = $_GET['lang'] ?? 'en';

$sql = "SELECT guide_$lang AS guide FROM quick_guides WHERE action='$action' AND crop='$crop' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode(["status" => "success", "guide" => $result->fetch_assoc()['guide']]);
} else {
    echo json_encode(["status" => "error", "message" => "No guide found"]);
}
?>
