<?php
session_start();
?>;
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada.">
    <meta name="Elvis Mariga" content="">
    <link rel="icon" href="img/icon.jpg">

    <title>FreshFarm | Farmer Profile</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="dist/css/all.css" rel="stylesheet" type="text/css">
    <link href="dist/fontawesome/css/all.min.css" rel="stylesheet" type="text/css">


    <!--custom CSS-->

    <link href="carousel.css" rel="stylesheet" type="text/css">

</head>
<?php
if($_SESSION["ID"]!=null){
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
    $sql =" use FreshFarm";
    if($conn->query($sql)===TRUE) {
        $stmt = $conn->prepare("select email from buyer Where ID_no=? ");
        $stmt->bind_param("s", $_SESSION['ID']);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->fetch();
        $stmt->close();
    }else{
        echo "connection error".$conn->error;
    }

}else{

    header("Location:farmer-login.php");
}
?>
<body>

    <div class="main-container">
        <div class="row text-center">
            <div class="col-2 pt-2">

            </div>
            <div class="col-8 p-2">
                <div class="container-fluid m-2">
                    <?php
                    $stmt = $conn->prepare("select first_name, last_name, email,phone_no, location from farmer where ID_no=?");
                    $stmt->bind_param("i", $ID_no);
                    $stmt->execute();
                    $stmt->bind_result($first_name,$last_name,$email,$phone_no, $location);
                    $stmt->fetch();
                    $stmt-> close()

                    ?>
                    <form class="col-sm-12 col-md-10 col-lg-9 col-xl-8 align-self-center" action="shop.php " method="post" enctype="multipart/form-data">
                        <div class="col-sm-11 col-md-5 col-lg-3 col-xl-3">
                            <div class="form-group">
                                <label for="name"><b> Name:</b></label>
                                <input class="form-control " type="text" value="<?php echo $first_name;?>" required name="firsy_name">
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
        <div class="col-2">

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