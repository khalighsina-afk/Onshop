<?php
session_start();
$username = $_SESSION['username'] ?? 'Guest';
$_SESSION = [];
session_destroy();

echo "Goodbye, " . htmlspecialchars($username) . "!";
echo "<a href='login.php'>Login again</a>";
exit;