<!DOCTYPE>
<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "FreshFarm";
    $ID_no = $_POST['ID_no'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email=$_POST['email'];
    $password_one=$_POST['password_one'];
    $password_two=$_POST['password_two'];
    $phone_no=$_POST['phone_no'];
    $location=$_POST['location'];
// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql ="use FreshFarm";
    if($conn->query($sql)===TRUE){
// prepare and bind
        $stmt = $conn->prepare("INSERT INTO farmer ( ID_no, first_name, last_name, email,  farmer_password, phone_no,location, user_id) VALUES (?, ?, ?, ?, ?, ?,?,?)");
        $pass_to_store = password_hash($password_one,PASSWORD_DEFAULT);
        $user_id = md5($email);
        $stmt->bind_param("issssiss", $ID_no, $first_name,$last_name, $email, $pass_to_store,  $phone_no, $location, $user_id);
        if($stmt->execute()){
            header("Location: farmer-login.php");
        }else{
            echo $stmt->error;
        }
        $stmt->close();
        $conn->close();
    }else{
        echo $conn->error;
    }
}
?>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada.">
    <meta name="Elvis Mariga" content="">
    <link rel="icon" href="img/icon.jpg">

    <title>FreshFarm | Farmer Create Account</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="dist/css/all.css" rel="stylesheet" type="text/css">
    <link href="dist/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">
    <!--custom CSS-->

    <link href="carousel.css" rel="stylesheet" type="text/css">
</head>

<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">


    <a class="navbar-brand" href="index.html"> <img class="rounded-circle" src="img/images%20(2).jpg" alt="fruits" width="20" height="20">FreshFarm</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="container pl-20px">
        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mr-5 active">
                    <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item mr-5">
                    <a class="nav-link" href="#">Shop</a>
                </li>

            </ul>
            <a class="btn btn-secondary btn-lg" href="farmer-login.php" role="button">Log in</a>
        </div>
    </div>





</nav>
<div class="row text-center">
    <div class="col-sm-4 p-5 pt-3">

    </div>


    <div id="register" class="col-sm-4 p-5 pt-3">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">

            <div class="row text-center pb-3">
                <strong> <h1> Create a New Farmer Account</h1></strong>
                <div class="col-sm-6   pt-3">
                    <label for="input username"><b>Firstname</b>
                    </label>
                    <input type="text" class="form-control" id="First_name" name="first_name" placeholder="Enter First_name " required>
                </div>
                <div class="col-sm-6  pt-3 ">
                    <label for="input username"><b>Lastname</b>
                    </label>
                    <input type="text" class="form-control" id="Last_name" name="last_name" placeholder="Enter Last_name " required>
                </div>

            </div>
                <div class="from-group ">
                    <label for="input username"><b>ID no.</b>
                    </label>
                    <input type="text" class="form-control" id="name" name="ID_no" placeholder="Enter ID no. " required>
                </div>
                <div class="form-group">
                    <label for="InputEmail"><b>Email address</b></label>
                    <input type="email" class="form-control" id="InputEmail" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="input username"><b>Phone No.</b></label>
                    <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Enter Phone No. " required>
                </div>
                <div class="form-group">
                    <label for="input username"><b>Location</b></label>
                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter location " required>
                </div>

                <div>
                    <password-strength data-minimum-character-count="8" data-passphrase-length="15">
                        <dl class="form-group">
                            <dt class="input-label">
                                <label class="form-label f5" for="farmer_password">Password</label>
                            </dt>
                            <dd>
                                <input type="password" name="password_one" id="farmer_password" class="form-control form-control-lg input-block" placeholder="Create a password" required>
                                <input type="password" name="password_two" id="farmer_password1" class="form-control form-control-lg input-block mt-5 mb-5" placeholder="Confirm password" required>
                                <p class="form-control-note">Make sure it's <span class="js-more-than-n-chars">more than 15 characters</span> OR <span class="js-min-chars">at least 8 characters</span> <span class="js-number-requirement">including a number</span> <span class="js-letter-requirement">and a lowercase letter</span>. <a href="password.html" class="tooltipped tooltipped-s" aria-label="Learn more about strong passwords">Learn more</a>.</p>
                            </dd>
                        </dl>
                    </password-strength>
                </div>
                <button class="btn-mktg btn-primary-mktg btn-large-mktg f4 btn-block" type="submit" data-ga-click="Signup, Attempt, location:home hero">
                    Sign up as a Farmer
                </button>
                <p class="form-control-note mb-0 mt-3 text-center">

                    By clicking “Sign up as a Farmer”, you agree to our terms of service and privacy statement.
                    <span class="js-email-notice">We’ll occasionally send you account related emails.</span>
                </p>
            </div>
        </form>
    </div>
</div>



<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
    <script src="dist/js/jquery-3.3.1.min.js"></script>
    <script src="dist/bootstrap/js/bootstrap.min.js"></script>
    <script src="dist/js/all.js"></script>
    <script src="dist/fontawesome/js/all.min.js"></script>
    <script src="dist/js/nicEdit.js"></script>
</body>
</html>