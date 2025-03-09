<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Quiz</title>
    <?php
session_start();
require_once 'sql.php';
                $conn = mysqli_connect($host, $user, $ps, $project);if (!$conn) {
    echo "<script>alert(\"Database Error! Retry after some time!\")</script>";
} else {
    $type1 = $_SESSION["type"];
    $email1 = $_SESSION["email"];
    $sql = "select * from profile_view where email='{$email1}'";
        $res =   mysqli_query($conn, $sql);
        if ($res == true) {
            global $dbmail, $dbpw;
            while ($row = mysqli_fetch_array($res)) {
                $dbmail = $row['email'];
                $dbname = $row['name'];
                $dbfaculty_id = $row['id'];
                $dbphno = $row['ph_no'];
                $dbgender = $row['gender'];
                $dbdob = $row['dob'];
                $dbdept = $row['dept'];
                $dbtype = $row['member_type'];
            }
        }
    $qname = $_SESSION['qname'];
    $sql = "select quiz_id from quiz where quiz_name='{$qname}'";
    $res =   mysqli_query($conn, $sql);
    if ($res == true) {
        global $qid;
        while ($row = mysqli_fetch_array($res)) {
            $qid = $row['quiz_id'];
        }
    }
    if (isset($_POST['submit'])) {
        $qs = $_POST["que"];
        $op1 = $_POST["ans"];
        $op2 = $_POST["opt2"];
        $op3 = $_POST["opt3"];
        $ans = $_POST["opt4"];
        $sql = "insert into questions(que,ans,opt2,opt3,opt,quiz_id) values('$qs','$op1','$op2','$op3','$ans','$qid');";
        $res =   mysqli_query($conn, $sql);
        if ($res == true) {
            echo '<script>history.pushState({}, "", "");</script>';
        } elseif ($res != true) {
            echo '<script>alert("Question already exsits!");</script>';
        }
    }
    if (isset($_POST['submit1'])) {
        $qs = $_POST["que"];
        $op1 = $_POST["ans"];
        $op2 = $_POST["opt2"];
        $op3 = $_POST["opt3"];
        $ans = $_POST["opt4"];
        $sql = "insert into questions(que,ans,opt2,opt3,opt4,quiz_id) values('$qs','$op1','$op2','$op3','$ans','$qid');";
        $res =   mysqli_query($conn, $sql);
        if ($res == true) {
            header("Location: faculty_home.php");
        } elseif ($res != true) {
            echo '<script>alert("Question already exsits!");</script>';
        }
    }
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
        margin:10px;
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
    .textbox {
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 6px 10px;
        box-sizing: border-box;
        margin-bottom: 10px;
        width: 300px; /* You can adjust the width as needed */
        height: 50px;
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
        $sql = "select * from profile_view where email='{$email1}'";
        $res =   mysqli_query($conn, $sql);
        if ($res == true) {
            global $dbmail, $dbpw;
            while ($row = mysqli_fetch_array($res)) {
                $dbmail = $row['email'];
                $dbname = $row['name'];
                $dbfaculty_id = $row['id'];
                $dbphno = $row['ph_no'];
                $dbgender = $row['gender'];
                $dbdob = $row['dob'];
                $dbdept = $row['dept'];
                $dbtype = $row['member_type'];
            }
        }
    ?><section>
    <center>
    <section id="ans">
        <form method="post">
    <label for="quiz_name"><h1 style="font-size: 2em;">Add Questions</h1></label><br>
    <div id="QS">
    <label for="que">Question:</label><br>
        <input type="text" name="que" placeholder="Enter Question " class="textbox" required><br><br>
        <label for="ans">Option 1 | Answer:</label><br>
        <input type="text" name="ans" placeholder="Answer" class="textbox" required><br><br>
        <label for="opt2">Option 2:</label><br>
        <input type="text" name="opt2" placeholder="Option 1" class="textbox" required><br><br>
        <label for="opt3">Option 3:</label><br>
        <input type="text" name="opt3" placeholder="Option 2" class="textbox" required><br><br>
        <label for="opt4">Option 4:</label><br>
        <input type="text" name="opt4" placeholder="Option 3" class="textbox" required><br><br> 
    </div>
    <input type="submit" name="submit" value="Add More" class="button">
    <input type="submit" name="submit1" value="Done" class="button">
</form>
    </section>
    </center>
</section>
        <fieldset class="prof" id="prof" style="display: none;">
            <center>
                <p><b>Type of User&nbsp;:&nbsp;<?php echo $dbtype ?></b></p>
                <p><b>Name&nbsp;:&nbsp;<?php echo $dbname ?></b></p>
                <p><b>e-Mail&nbsp;:&nbsp;<?php echo $dbmail ?></b></p>
                <p><b>Phone Number&nbsp;:&nbsp;<?php echo $dbphno ?></b></p>
                <p><b>Employee ID&nbsp;:&nbsp;<?php echo $dbfaculty_id ?></b></p>
                <p><b>Gender&nbsp;:&nbsp;<?php echo $dbgender ?></b></p>
                <p><b>Date of Birth&nbsp;:&nbsp;<?php echo $dbdob ?></b></p>
                <p><b>Department&nbsp;:&nbsp;<?php echo $dbdept ?></b></p>
            </center>
        </fieldset>
        <section id="score" style="display:none;">
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
"alert(\"Thank You for Using Assess 360°\");";
//session_unset();
//session_destroy();
echo "window.location.replace(\"index.php\");".
"}".
"function addquiz(){" .
    "document.getElementById(\"addq\").style=\"display: initial;\";" .
"}" .
"</script>";
?>
</html>