<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
include 'db.php';

$crop = $_GET['crop'] ?? '';
$soil_type = $_GET['soil_type'] ?? '';
$lang = $_GET['lang'] ?? 'en';

$sql = "SELECT advice_$lang AS advice FROM advisory WHERE crop='$crop' AND soil_type='$soil_type' LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo json_encode(["status" => "success", "advice" => $result->fetch_assoc()['advice']]);
} else {
    echo json_encode(["status" => "error", "message" => "No advisory found"]);
}
?>
