
<?php
require_once 'sql.php';
$conn = mysqli_connect($host, $user, $ps, $project);       if (!$conn) {
    echo "<script>alert(\"Database Error! Retry after some time!\")</script>";
}
$sql = "CREATE VIEW attempt_quiz_view AS
SELECT q.quiz_id as quiz_id,q.quiz_name AS quiz_name, f.name AS name, f.email AS email, q.date_created AS date_created
FROM quiz q
INNER JOIN faculty f ON q.email = f.email;
";
if (mysqli_query($conn, $sql)) {
    echo "<script>
    alert('Successfully Signed Up!');</script>";
}
