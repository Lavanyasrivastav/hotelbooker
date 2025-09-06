<?php
header('Content-Type: application/json');

// Check if file uploaded
if (!isset($_FILES['crop_image'])) {
    echo json_encode(['status' => 'error', 'message' => 'No image uploaded']);
    exit;
}

$image = $_FILES['crop_image'];
$allowed = ['jpg', 'jpeg', 'png'];

$ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
if (!in_array($ext, $allowed)) {
    echo json_encode(['status' => 'error', 'message' => 'Only JPG, JPEG, PNG allowed']);
    exit;
}

// Save image in uploads folder
$uploadDir = __DIR__ . '/uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$filename = uniqid('crop_', true) . '.' . $ext;
$filepath = $uploadDir . $filename;

if (move_uploaded_file($image['tmp_name'], $filepath)) {
    // ✅ Call AI model (Python script or API)
    $command = escapeshellcmd("python analyze_crop.py " . escapeshellarg($filepath));
    $output = shell_exec($command);

    // For now, use dummy AI output
    $result = [
        'status' => 'success',
        'diagnosis' => 'Leaf Spot Disease',
        'recommendation' => 'Spray Mancozeb 2g/L of water, maintain field hygiene.',
        'organic' => 'Use neem oil spray (5 ml/L) every 7 days.'
    ];

    echo json_encode($result);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to upload image']);
}
?>
