<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Quiz</title>
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

button {
        width: 100px;
        height: 50px;
        font-family: 'Work Sans', sans-serif;
        font-size: 0.938em;
        outline: none;
        border: none;
        margin:10px;
        background-color: #12192C;
        color: #fff;
        border-radius: .5rem;
        cursor: pointer;
        transition: .3s;
}

.dash_button {
        width: 120px;
        height: 40px;
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
#delq,#addq,#viewq{
        width: 50vw;
        margin-left: 5vw;
        margin-right: 5vw;
        justify-content: center;
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
                <li onclick="prof()"><a>Profile</a></li>
                <li onclick="score()"><a>Quizzes</a></li>
                <li onclick="lo()"><a>Sign Out</a></li>
            </ul>
          </nav>
        </div>
    </header>
    <?php
        $type1 = $_SESSION["type"];
        $email1 = $_SESSION["email"];
        $sql = "select * from " . $type1 . " where email='{$email1}'";
        $res =   mysqli_query($conn, $sql);
        if ($res == true) {
            global $dbmail;
            while ($row = mysqli_fetch_array($res)) {
                $dbmail = $row['email'];
                $dbname = $row['name'];
                $dbusn = $row['faculty_id'];
                $dbphno = $row['ph_no'];
                $dbgender = $row['gender'];
                $dbdob = $row['dob'];
                $dbdept = $row['dept'];
            }
        }
    ?>
    <section style="margin-top: 4vw;width:80vw;margin-left:10vw;margin-right:10vw"> 
    <?php 
    if(isset($_GET["qid"])){
        $qid=$_GET["qid"];
        $sql_temp = "SELECT * FROM quiz WHERE quiz_id = '$qid' and email = '$dbmail' ";
        $result = $res=mysqli_query($conn,$sql_temp);
        if (!($result->num_rows > 0) ){
            echo "There is no quiz associated with this ID!<br>";
        } else {
            $sql ="select * from questions where quiz_id='{$qid}'";
            $res=mysqli_query($conn,$sql);
            if($res) {
                $count=mysqli_num_rows($res);
                if(mysqli_num_rows($res)==0) {
                    echo "No questions found under this quiz!";
                    echo "<form method=\"POST\">";
                    echo "<br><input id=\"btn\" type=\"submit\" name=\"submit\" class=\"dash_button\" value=\"Add Questions\"><br><br><br>";
                    echo "</form><br><br>";
                } else {
                    $i=1;
                    $j=0;
                    echo "<form method=\"POST\">";
                    echo "<input id=\"btn\" type=\"submit\" name=\"submit\" class=\"dash_button\" value=\"Add Questions\"><br><br><br>";
                    echo "</form><br><br>";

                    while ($row = mysqli_fetch_assoc($res)) { 
                        echo $i.". ".$row["que"]."<br><br>";
                        echo "<font color=\"green\"><input type=\"radio\" value=\"".$j."\" name=\"ans".$i.$j."\">".$row["ans"]."</font><br>";
                        echo "<input type=\"radio\" value=\"".($j+1)."\" name=\"ans".$i.$j."\">".$row["opt2"]."<br>";               
                        echo "<input type=\"radio\" value=\"".($j+2)."\" name=\"ans".$i.$j."\">".$row["opt3"]."<br>";               
                        echo "<input type=\"radio\" value=\"".($j+3)."\" name=\"ans".$i.$j."\">".$row["opt4"]."<br><br><br>";  
                        $i++;                            
                    }
                    echo "</form><br><br>";
                }
            } else {
                echo "error".mysqli_error($conn).".";
            }
            if(isset($_POST["submit"])){
                echo "<script>window.location.href ='add_question.php?qid=".$qid."';</script>";
            }
        }
    } 
    ?>
</section>
        </section>
        <section class="prof" id="prof" style="display: none;">
        <fieldset>
    <center>
                <p><b>Type of User&nbsp;:&nbsp;<?php if($type1=="faculty") echo "Faculty" ?></b></p>
                <p><b>Name&nbsp;:&nbsp;<?php echo $dbname ?></b></p>
                <p><b>Faculty ID&nbsp;:&nbsp;<?php echo $dbusn ?></b></p>
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
            $sql ="select * from quiz_view where email='{$email1}'";
            $res=mysqli_query($conn,$sql);
            if($res)
            {
                echo "<center><h1>List of Quizes added by You</h1>";
                echo "<table id=\"sc\"><thead><tr><td>Quiz ID</td><td>Quiz Title</td><td>Created on</td><td>Attempts Count</td></tr></thead>";
                while ($row = mysqli_fetch_assoc($res)) {                
                    echo "<tr><td>".$row["quiz_id"]."</td><td>".$row["quiz_name"]."</td><td>".$row["date_created"]."</td><td>".$row["attempt_count"]."</td></tr>"; 
                }
                echo "</table></center><br><br>";
            }
            ?>
            </fieldset>
            </section>
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
    "window.location.replace(\"faculty_home.php\");".
    "}".
"function lo(){".
"alert(\"Thank you for using Assess 360°\");";
//session_unset();
//session_destroy();
echo "window.location.replace(\"index.php\");".
"}</script>";
?>
</html>