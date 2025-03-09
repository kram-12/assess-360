<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student | Home</title>
    <?php
      session_start();
      require_once 'sql.php';
      $conn = mysqli_connect($host, $user, $ps, $project);if (!$conn) {
        echo "<script>alert(\"Database Error! Retry after some time!\")</script>";
      }
    ?>
    <style>
        
        @import url('https://fonts.googleapis.com/css?family=Work+Sans:400,600');
body {
	margin: 0;
	background: #fff;
	font-family: 'Work Sans', sans-serif;
	font-weight: 800;
}

.container {
	width: 80%;
	margin: 0 auto;
}

header {
  background: #55d6aa;
}

header::after {
  content: '';
  display: table;
  clear: both;
}

.logo {
  float: left;
  padding: 10px 0;
}

nav {
  float: right;
}

nav ul {
  margin: 0;
  padding: 0;
  list-style: none;
}

nav li {
  display: inline-block;
  margin-left: 70px;
  padding-top: 35px;

  position: relative;
}

nav a {
  color: #444;
  text-decoration: none;
  text-transform: uppercase;
  font-size: 14px;
}

nav a:hover {
  color: #000;
  cursor: pointer;
}

nav a::before {
  content: '';
  display: block;
  height: 5px;
  background-color: #444;

  position: absolute;
  top: 0;
  width: 0%;

  transition: all ease-in-out 250ms;
}

nav a:hover::before {
  width: 100%;
}

table {
    width: 80%;
    border-collapse: collapse;
}
th, td {
    padding: 12px; 
    text-align: center;
    border: 1px solid #dddddd;
}
th {
    font-weight: bold;
}
.prof,#score{
        top: 3vw;
        position: fixed;
            width: 50vw !important;
            margin-left: 25vw !important;
            margin-right: 25vw !important;
            background-color: #fff !important;
            display: none !important;
            border-radius: 10px;
            margin-top: 2vw;
            z-index: 1;
            padding: 1vw;
            padding-left: 2vw;
            color: #042A38;
}
</style>
</head>
<body>
    <header>
        <div class="container">
          <h2 class="logo">Assess 360°</h2>
          
          <nav>
            <ul>
                <li onclick="dash()"><a>Dashboard</a></li>
                <li onclick="prof()"><a>profile</a></li>
                <li onclick="score()"><a>Score</a></li>
                <li onclick="lo()"><a>Sign Out</a></li>
            </ul>
          </nav>
        </div>
    </header>
    <?php
        $type1 = $_SESSION["type"];
        $email1 = $_SESSION["email"];

           $select_sql = "select * from profile_view where email='{$email1}'";
           $res_select = mysqli_query($conn, $select_sql);

           if ($res_select !== false) {
           if ($row = mysqli_fetch_array($res_select)) {
            $dbmail = $row['email'];
            $dbname = $row['name'];
            $dbreg = $row['id'];
            $dbphno = $row['ph_no'];
            $dbgender = $row['gender'];
            $dbdob = $row['dob'];
            $dbdept = $row['dept'];
            $dbtype = $row['member_type'];
          } 
} 
    ?>
    <br><br>
    <center><h1 style="font-size:2vw;">Welcome&nbsp;<?php echo $dbname ?></h1></center>
    <section>
      <br><br>
    <?php 
            $sql ="select * from attempt_quiz_view where dept='{$dbdept}'";
            $res=mysqli_query($conn,$sql);
            if($res)
            {
                echo "<center><h1 style=\"font-size:1.5vw;\">Attempt any Quiz</h1></center>";
                echo "<center><table><thead><tr><th>Quiz Title</th><th>Created By</th><th>Faculty Email</th><th>Created On</th><th>Link to Test</th></tr></thead>";
                while ($row = mysqli_fetch_assoc($res)) {                
                    echo "<tr><td>".$row["quiz_name"]."</td><td>".$row["name"]."</td><td>".$row["email"]."</td><td>".$row["date_created"]."</td><td><a id=\"tq\" href='attempt_quiz.php?qid=".$row['quiz_id']."'>Take Quiz</td></tr>"; 
                }
                echo "</table></center>";
            }
            ?>
    </section>
    <section class="prof" id="prof" style="display: none;">
    <fieldset>
    <center>
                <p><b>Type of User&nbsp;:&nbsp;<?php echo $dbtype ?></b></p>
                <p><b>Name&nbsp;:&nbsp;<?php echo $dbname ?></b></p>
                <p><b>Registration Number&nbsp;:&nbsp;<?php echo $dbreg ?></b></p>
                <p><b>Department&nbsp;:&nbsp;<?php echo $dbdept ?></b></p>
                <p><b>e-Mail&nbsp;:&nbsp;<?php echo $dbmail ?></b></p>
                <p><b>Phone Number&nbsp;:&nbsp;<?php echo $dbphno ?></b></p>
                <p><b>Gender&nbsp;:&nbsp;<?php echo $dbgender ?></b></p>
                <p><b>Date of Birth&nbsp;:&nbsp;<?php echo $dbdob ?></b></p>
    </center>
    </fieldset>
    </section>
    <section id="score" style="display:none;">
    <fieldset>
        <?php 
            $sql ="select * from quiz_score_view where email='{$email1}'";
            $res=mysqli_query($conn,$sql);
            if($res)
            {
                echo "<center><h1>Scoreboard</h1><center>";
                echo "<center><table id=\"sc\"><thead><tr><td>Quiz Title</td><td>Score Obtained</td><td>Total Score</td><td>Remarks</td></tr></thead>";
                while ($row = mysqli_fetch_assoc($res)) {                
                    echo "<tr><td>".$row["quiz_name"]."</td><td>".$row["score"]."</td><td>".$row["total_score"]."</td><td>".$row["remark"]."</tr>"; 
                }
                echo "</table><center><br><br>";
            }
            else{
                echo " ".mysqli_error($conn);
            }
        ?>
      </fieldset>
      </section>
      <br><br><br>
      <section>
          <?php
            $sql="select * from leaderboard_view where dept='{$dbdept}'";
            $res=mysqli_query($conn,$sql);
            if($res)
            {
                echo "<center><h1 style=\"font-size: 1.5vw\">Leaderboard</h1></center>";
                echo "<center><table><thead><tr><th>Quiz Title</th><th>Score</th><th>Total Score</th><th>Student Name</th><th>Student Mail ID</th></tr></thead>";
                while ($row = mysqli_fetch_assoc($res)) {                
                    echo "<tr><td>".$row["quiz_name"]."</td><td>".$row["score"]."</td><td>".$row["total_score"]."</td><td>".$row["name"]."</td><td>".$row["email"]."</td></tr>"; 
                }
                echo "</table><center><br><br><br>";
            }
            else{
                echo mysqli_error($conn);
            }
          ?>
      </section>
    </div>
    <?php require("footer.php");?>
</body>
<?php
echo '<script>'.
"function prof(){".
"document.getElementById(\"prof\").style=\"display: block !important;\";".
"document.getElementById(\"score\").style=\"display: none !important;\";".
"}".
"function score(){".
"document.getElementById(\"prof\").style=\"display: none !important;\";".
"document.getElementById(\"score\").style=\"display: block !important;\";".
"}".
"function dash(){".
    "document.getElementById(\"prof\").style=\"display: none !important;\";".
    "document.getElementById(\"score\").style=\"display: none !important;\";".
    "}".
"function lo(){".
"alert(\"Thank You for Using Assess 360°\");";
//session_unset();
//session_destroy();
echo "window.location.replace(\"index.php\");".
"}</script>";
?>
</html>