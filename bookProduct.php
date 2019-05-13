<!DOCtype html>
<html>

<?php
session_start();
?>;
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada.">
    <meta name="Elvis Mariga" content="">
    <link rel="icon" href="img/icon.jpg">

    <title>FreshFarm | Book Product</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="dist/css/all.css" rel="stylesheet" type="text/css">
    <link href="dist/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">


    <!--custom CSS-->

    <link href="carousel.css" rel="stylesheet" type="text/css">
</head>
<?php
if($_SESSION['IDb']!=null && $_SERVER["REQUEST_METHOD"]=="POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "FreshFarm";
//Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = " use FreshFarm";
    if ($conn->query($sql) === TRUE) {
        $stmt = $conn->prepare("select * from buyer Where user_id=? ");
        $stmt->bind_param("s", $_SESSION['IDb']);
        $stmt->execute();
        $stmt->bind_result($ID_no, $first_name, $last_name, $email, $buyer_password, $date, $user_id);
        $stmt->fetch();
        $stmt->close();

        echo $_SESSION['IDb'];
        // if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //get from db


        //  if(isset($_POST['btnbook'])){
        $getProd = $_POST['product_id'];
        $quantity = $_POST["quantity"];
// prepare and bind
        $stmt = $conn->prepare("insert into bookprduct (prod_id,quantity,veiw,customer_id) values (?,?,?,?)");
        $view='no';
        $owner_id = $_SESSION['IDb'];
        $stmt->bind_param("ssss",$getProd,  $quantity,$view, $owner_id);

        if($stmt->execute()){
            header("location:shop.php");
        }
        echo '<div class="alert alert-danger alert-dismissible fade show w-100"> Product Book successfull.
                       <button class="close" role="button" data-dismiss="alert" aria-label="close"><span aria-hidden="true">&times;</span></button>
                      </div>';

        // header("location:farmer-profile.php");
        //   } else {


        // }
    }
}else{
//    echo $stmt->error;
}
?>;


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
                    <a class="nav-link" href="shop.php">Shop</a>
                </li>

            </ul>

        </div>
    </div>
</nav>
<div class="main-container">
    <div class="row align-content-center">
        <div class="col-2">

        </div>
        <div class="col-8">
            <form action="<?php // echo $_SERVER['PHP_SELF'] ?> " class="align-content-center" method="post" enctype="multipart/form-data">


                <div class="form-group offset-4 col-4">
                    <input type="text" class="d-none" name="product_id" value="<?php echo $_GET['product_id']?>">
                    <label for=" quantity"><strong><h4>Quantity</h4></strong></label>
                    <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity " required>
                </div>
                <button class="btn btn-success offset-5" type="submit">Submit Quantity</button>
            </form>

        </div>
        <div class="col-2">

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
</html