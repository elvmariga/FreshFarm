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

    <title>FreshFarm | Shop</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="dist/css/all.css" rel="stylesheet" type="text/css">
    <link href="dist/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">


    <!--custom CSS-->

    <link href="carousel.css" rel="stylesheet" type="text/css">
</head>
<?php
if($_SESSION["ID"]!=null && $_SERVER["REQUEST_METHOD"]=="POST") {
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
        $stmt->bind_param("s", $_SESSION['ID']);
        $stmt->execute();
        $stmt->bind_result($ID_no, $first_name, $last_name, $email, $buyer_password, $date, $user_id);
        $stmt->fetch();
        $stmt->close();

        echo $_SESSION['ID'];
        // if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //get from db


        //  if(isset($_POST['btnbook'])){
        $getProd = $_POST['product_id'];
        $quantity = $_POST["quantity"];
// prepare and bind
        $stmt = $conn->prepare("insert into bookprduct (prod_id,quantity,veiw,owner_id) values (?,?,?,?)");
        $view='no';
        $owner_id = $_SESSION['ID'];
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
<form action="<?php // echo $_SERVER['PHP_SELF'] ?> " class="align-content-center" method="post" enctype="multipart/form-data">


   <div class="form-group offset-4 col-4">
       <input type="text" class="d-none" name="product_id" value="<?php echo $_GET['product_id']?>">
       <label for=" quantity">Quantity</label>
       <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity " required>
   </div>
    <button class="btn-mktg btn-primary-mktg btn-large-mktg f4 btn-block" type="submit" data-ga-click="Signup, Attempt, location:home hero">
        Submit Quantity
    </button>
</form>

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