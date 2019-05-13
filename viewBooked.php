<?php
session_start();
if($_SESSION["ID"]!=null) {
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
//    if ($conn->query($sql) === TRUE) {
//        $sql = "SELECT * FROM product INNER JOIN bookprduct, buyer WHERE product.owner_id=? and buyer.ID_no=bookprduct.customer_id";
//        $stmt = $conn->prepare($sql);
//        $stmt->bind_param("s", $_SESSION['ID']);
//        if ($stmt->execute()) {
//            $stmt->bind_result($product_id, $product_name, $price, $quantity, $status, $description,
//                $image_url, $date, $owner_id, $book_id, $prod_id, $quantity, $view, $customer_id, $ID_no, $first_name,
//                $last_name, $email, $buyer_password, $date, $user_id);
//            while ($stmt->fetch()) {
//                echo $first_name . "<br>";
//                echo $product_name . "<br>";
//            }
//        }
//    }


//        echo $_SESSION['ID'];
//        // if ($_SERVER["REQUEST_METHOD"] == "POST") {
//
//        //get from db
//
//
//        //  if(isset($_POST['btnbook'])){
//// prepare and bind
//        $sql = "SELECT product.owner_id FROM product INNER JOIN bookprduct WHERE product.owner_id = ?";
//        $stmt = $conn->prepare($sql);
//        $view='no';
//        $owner_id = $_SESSION['ID'];
//        $stmt->bind_param("s",$owner_id);
//
//        if($stmt->execute()){
//            $stmt->bind_result($xx);
//            while ($stmt->fetch()){
//                echo $xx;
//            }
//        }


}else{

}
?>;



<!DOCtype html>
<html>



<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada.">
    <meta name="Elvis Mariga" content="">
    <link rel="icon" href="img/icon.jpg">

    <title>FreshFarm | View Booked Products</title>

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

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault" aria-controls="navbarsDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="container pl-20px">
        <div class="collapse navbar-collapse" id="navbarsDefault">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item mr-5 active">
                    <a class="nav-link" href="index.html">Home <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item mr-5">
                    <a class="nav-link" href="farmer-profile.php">Profile</a>
                </li>
                <li>
                    <a class="nav-link" href="logout.php">Logout</a>

                </li>
            </ul>

        </div>
    </div>

</nav>
<div class="main-container page-3">
    <div class="row align-content-center">
        <div class="col-3">
            <?php
            $stmt = $conn->prepare(" select  ID_no, first_name, last_name, email,  phone_no, location from  farmer where ID_no=?");
            $stmt->bind_param("s",$_SESSION['ID']);
            if ($stmt->execute()) {
                $stmt->bind_result($ID_no, $first_name, $last_name, $email, $phone_no, $location);
                while ($stmt->fetch()) {
                    echo '
                        <div class="container">
                             <div class="row text-center">
                                 <div class="align-content-center">
                    <div class=" justify-content-between col-12 offset-6">
                    <h3 class="text-secondary">Your Profile '.$first_name.'</h3>
                    <hr>
                    <label for="price"><b>Farmer Name:</b></label>
                        <h6>'.$first_name." ".''.$last_name.'</h6><hr>
                    <label for="price"><b>Email:</b></label>
                        <h6>'.$email.'</h6><hr>
                    <label for="price"><b>Phone No. :</b></label>
                        <h6>'.$phone_no.'</h6><hr>
                        
                    <label for="price"><b>Location:</b></label>
                        <h6>'.$location.'</h6><hr>
                       
                    </div>
                             </div>
                        </div>
                        ';






                }

            }
            ?>
        </div>
        </div>
        <div class="col-8 pt">
            <?php
            if ($conn->query($sql) === TRUE) {

                $sql = "SELECT * FROM product INNER JOIN bookprduct, buyer,buyer_profile WHERE product.owner_id=? and buyer.ID_no=bookprduct.customer_id and buyer_profile.owner_id=buyer.ID_no";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $_SESSION['ID']);
            if ($stmt->execute()) {
            $stmt->bind_result($product_id, $product_name, $price, $quantity, $status, $description,
            $image_url, $date, $owner_id, $book_id, $prod_id, $quantity, $view, $customer_id, $ID_no, $first_name,
            $last_name, $email, $buyer_password, $date, $user_id,$username, $phone_no, $location, $target_file, $profile_id, $owner_id);
            while ($stmt->fetch()) {
                echo '
                <div class="row  mt-3">
        <div class="col-12 bg-light mt-2 ">
            <div class="row justify-content-between">
                <div class="col-4 pr-3 pl-2">
                    <img src="'.$image_url.'" class="card-img-top" height="200" width="100">

                </div>
                <div class="col-8">
                    <div class="row justify-content-between pr-3 pt-2">
                    <label for="price"><b>Product Name:</b></label>
                        <h6>'.$product_name.'</h6><br>
                    <label for="price"><b>Buyer Name:</b></label>
                        <h6>'.$first_name." ".''.$last_name.'</h6><br>
                    <label for="price"><b>Quantity:</b></label>
                        <h6>'.$quantity.'</h6>
                        </div>
                        <div class="row justify-content-between pr-3 pt-2"
                    <label for="price"><b>Email:</b></label>
                        <h6>'.$email.'</h6><br>
                       <label for="price"><b>Phone No. :</b></label>
                        <h6>'.$phone_no.'</h6><br>
                       
                    </div>
                </div>
                  <form class="form-inline" action="clearBook.php" method="post" enctype="multipart/form-data">
                                    <input class="d-none" type="text" name="product_id" value="' .$book_id .'" >
                                    <input type="submit" value="Remove Book" class="btn btn-danger ml-5">
                                    </form>
                
                </div>
                </div>
                </div>
                ';
            }
            }
            }
            ?>;

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