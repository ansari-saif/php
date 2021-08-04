<?php
// This code should included in the global file (like header)
session_start();
if (!empty($_SESSION['expert'])) {
    $expert = $_SESSION['expert'];
    $GLOBALS['expert_id'] = $expert['id'];
    if (basename($_SERVER["PHP_SELF"]) == 'index.php') {
        echo "
        <script>
            location.href = 'profile.php';
        </script>";
    }
} elseif (basename($_SERVER["PHP_SELF"]) != 'index.php') {
    echo "
	<script>
		location.href = 'index.php';
	</script>";
}
