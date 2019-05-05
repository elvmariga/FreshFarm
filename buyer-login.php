<!DOCTYPE html>
<?php
session_start();
$user_error="";
?>


<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "FreshFarm";
    $email = $_POST['email'];
    $buyer_password = $_POST['buyer_password'];
// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {

        $sql = "use FreshFarm";
        if ($conn->query($sql) == TRUE) {

            // prepare and bind
            $stmt = $conn->prepare("SELECT * FROM buyer where email=?");

            $user_id = md5($email);
            $stmt->bind_param("s", $email);
            $stmt->execute();


            $stmt->bind_result($ID_no, $first_name,$last_name, $email, $pass_to_store,  $date, $user_id);

            $stmt->fetch();



//              if ($ID_no != null) {
//                  echo "sign in succeful";
//                  header("Location:farmer-profile.html");
//
//              } else {
//                  $user_error = '<div class="alert alert-danger alert-dismissible fade show w-100">Wrong username
//                         or Password
//                          <button class="close" role="button" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
//                      </div>';
//
//              }

            if($email ==null){
                echo '<div class="alert alert-danger alert-dismissible fade show w-100">Wrong Email address
                       <button class="close" role="button" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
                      </div>';
            }
            else {
                if (password_verify($buyer_password, $pass_to_store)){
                        $_SESSION['ID'] = $ID_no;
                        echo "Login Successfull!";
                        header("Location: shop.php");

                }else{

                    echo '<div class="alert alert-danger alert-dismissible fade show w-100">Wrong Password
                       <button class="close" role="button" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
                      </div>';
                }
            }

            // set parameters and execute
            $stmt->close();
            $conn->close();
        } else {
            echo $conn->error;
        }

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

    <title>FreshFarm | Buyer log_in</title>

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
                    <a class="nav-link" href="#username">Shop</a>
                </li>

            </ul>
            <a class="btn btn-secondary btn-lg" href="#username" role="button">Log in</a>

            <a class="btn btn-secondary btn-lg" href="buyer-registration.php" role="button">Create Account</a>

        </div>
    </div>
</nav>
<div class="container">
    <div class="row text-center">
        <div class="col-sm-4 p-5 pt-3">

        </div>

        <div class="log-in col-sm-4 p-5 pt-3 shadow-lg mt-5">
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">

                <label for="username"><b>Username</b>
                </label>
                <input type="text" class="form-control" id="username" name="email" placeholder="Enter Email " required>
             </div>
            <div class="form-group">
            <label for="InputPassword"><b>Password</b></label>
            <input type="password" class="form-control" id="InputPassword" name="buyer_password" placeholder=" EnterPassword">
             </div>
            <div class="log">
            <input class="btn btn-secondary" type="submit" role="button" width=50px value="submit">


            <a class="btn btn-link" href="#" role="button">Forgot password?</a>
             </div>
        </div>
                  </form>
        <div class="col-sm-4 p-5 pt-3">

</div>

         </div>
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