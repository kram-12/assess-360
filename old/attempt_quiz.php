<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <?php
      session_start();
      error_reporting(E_ERROR | E_PARSE);
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

.button {
        height: 30px;
        font-family: 'Work Sans', sans-serif;
        font-size: 0.938em;
        outline: none;
        border: none;
        background-color: #12192C;
        color: #fff;
        border-radius: .5rem;
        cursor: pointer;
        transition: .3s;
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
        $sql = "select * from profile_view where email='{$email1}'";
        $res =   mysqli_query($conn, $sql);
        if ($res == true) {
            global $dbmail, $dbpw;
            while ($row = mysqli_fetch_array($res)) {
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
    <section>
      <br><br>
      <section style="width:80vw;margin-left:10vw;margin-right:10vw"> 
        <?php 
        if(isset($_GET["qid"])){
        $qname = $_SESSION['qname'];
        $qid=$_GET["qid"];
            $sql ="select * from questions where quiz_id='{$qid}'";
            $res=mysqli_query($conn,$sql);
            if($res)
            {
                $count=mysqli_num_rows($res);
                if(mysqli_num_rows($res)==0)
                {
                    echo "No questions found under this quiz please come later!<br>";
                }else{
                $i=1;
                $j=0;
                echo "<center><h1 style=\"font-size:2vw;\">$qname</h1></center>";
                echo "<form method=\"POST\">";
                while ($row = mysqli_fetch_assoc($res)) { 
                  // Shuffle options and answer
                  $options = array($row["ans"], $row["opt2"], $row["opt3"], $row["opt4"]);
                  shuffle($options);
                  
                  echo $i.". ".$row["que"]."<br><br>";
                  
                  // Print shuffled options
                  foreach ($options as $option) {
                      echo "<input type=\"radio\" value=\"".$j."\" name=\"ans".$i.$j."\">".$option."<br>";
                      $j++;
                  }
                  
                  $j = 0; // Reset $j for next question
                  $i++; // Increment $i for next question
                }
                echo "<br><input id=\"btn\" type=\"submit\" name=\"submit\" value=\"submit\" class=\"button\"><br><br><br>";
                echo "</form><br><br><br>";
            }
            }
            else
            {
                echo "error".mysqli_error($conn).".";
            }
            if(isset($_POST["submit"])) {
              $score = 0;
    for($i = 1; $i <= $count; $i++) {
        $correct_answer_index = $row["ans"] - 1; // Convert to zero-based index
        $selected_answer_index = isset($_POST["ans".$i]) ? intval($_POST["ans".$i]) : -1; // Get selected answer index, -1 if not selected

        // Check if the selected answer index matches the correct answer index
        if($selected_answer_index === $correct_answer_index) {
            $score++;
        }
    }
          
              echo "<script>alert(\"You scored ".$score." out of ".$count."\");</script>";
              
              // Insert score into the database
              $sql = "INSERT INTO score (score, email, quiz_id, total_score) VALUES ('$score', '$dbmail', '$qid', '$count')";
              $res = mysqli_query($conn, $sql);
              
              if($res) {
                  echo '<script>history.pushState({}, "", "");</script>';
                  echo "<script>window.location.replace(\"student_home.php\");</script>";
              } else {
                  echo "<script>alert(\"Error occurred updating score in database: ".mysqli_error($conn)."\");</script>";
              }
          }
     } ?>
    </section>
    <section class="prof" id="prof" style="display: none;">
    <fieldset>
    <center>
                <p><b>Type of User&nbsp;:&nbsp;<?php echo $dbtype ?></b></p>
                <p><b>Name&nbsp;:&nbsp;<?php echo $dbname ?></b></p>
                <p><b>e-Mail&nbsp;:&nbsp;<?php echo $dbmail ?></b></p>
                <p><b>Phone Number&nbsp;:&nbsp;<?php echo $dbphno ?></b></p>
                <p><b>Registration Number&nbsp;:&nbsp;<?php echo $dbreg ?></b></p>
                <p><b>Gender&nbsp;:&nbsp;<?php echo $dbgender ?></b></p>
                <p><b>Date of Birth&nbsp;:&nbsp;<?php echo $dbdob ?></b></p>
                <p><b>Department&nbsp;:&nbsp;<?php echo $dbdept ?></b></p>
    </center>
    </fieldset>
    </section>
    <section id="score" style="display:none;">
    <fieldset>
        <?php 
            $sql = "select * from quiz_score_view where email='{$email1}'";
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
    "window.location.replace(\"student_home.php\");".
    "}".
"function lo(){".
"alert(\"Thank You for Using Assess 360°\");";
//session_unset();
//session_destroy();
echo "window.location.replace(\"index.php\");".
"}</script>";
?>
</html>