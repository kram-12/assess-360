<?php
$email = $_POST["email"];
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

session_start();
require_once 'sql.php';

$conn = mysqli_connect($host, $user, $ps, $project);
if (!$conn) {
    echo "<script>alert(\"Database Error! Retry after some time !\")</script>";
} else {
    $sql = "UPDATE staff
            SET reset_token_hash = '$token_hash',
                reset_token_expires_at = '$expiry'
            WHERE mail = '$email'";

    mysqli_query($conn, $sql);
}
?>
