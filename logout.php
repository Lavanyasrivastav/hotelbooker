<?php
session_start();

// Remove all session variables
session_unset();
session_destroy();

header("Location: http://localhost/smart-crop-advisory/frontend/index.html?logged_out=true");

exit;
