<?php
session_start();
?>
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
    $sql ="use FreshFarm";
    if($conn->query($sql)===TRUE){
        $stmt = $conn->prepare("select email from farmer Where user_id=? ");
        $stmt->bind_param("s",$_SESSION['ID']);
        if($_SERVER["REQUEST_METHOD"]=="POST"){

            $ID_no = $_SESSION["ID"];
            if (isset($_POST['edit'])) {

                $product_name = $_POST["product"];
                $price = $_POST["price"];
                $quantity= $_POST["quantity"];
                $status = $_POST["status"];
                $description= $_POST["description"];

                $img_url = "ddd";
                $target_dir = "uploads/";
                $target_file = $target_dir.basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


                $stmt= $conn->prepare("UPDATE product SET product_name = $product_name, price = $price, quantity= $quantity,status=$status, desccription=$description, image_url= $target_file WHERE product_id = $product_id");
                $stmt->bind_param("i", $product_id);
                $stmt->execute();
                $stmt->fetch();
                $stmt->bind_result($product_name, $price, $quantity, $status, $description, $target_file);
                $stmt-> close();



                header( 'Location: index.php' ) ;



                $stmt->bind_result($username);
                $stmt->fetch();
                $stmt->close();

                $stmt = $conn->prepare(" select  product_name, price, quantity, status, description, image_url from  product where product_id=?");
                $stmt->bind_param("i", $product_id );
                $stmt->execute();
                $stmt->fetch();
                $stmt->bind_result($product_name,$price,$quantity, $status, $description, $target_file);
                $stmt->close();


                }
            echo "edit product successful";
            header("Location:farmer-profile.php");
        }

    }else{
        echo "connection error".$conn->error;
    }

}else{


    header("Location:farmer-profile.php");
}



?>
<body>
<div class="main-container">
    <div class="row text-center">
        <div class="col-sm-3 pt-2">

        </div>
        <div class="col-sm-6 pt-2">

                    <p class="pt-2"> <b>Please enter the details of the product</b></p>
                    <form class="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" role="form">
                        <img class="img-fluid" src="<?php echo $image_url; ?>" height="200px">
                        <hr>
                        <div class="custom-file mt-1">
                            <input type="file" class="custom-file-input"  id="customFile" name="fileToUpload" required>
                            <label class="custom-file-label" for="customFile"><b>Choose file</b></label>
                        </div>
                        <hr>
                        <div class="row text-center   p-3 ">
                            <div class col-sm-6>
                                <label for="product" required="required"><b>Product</b></label>
                                <input class="form-control " type="text" value="<?php echo $product_name;?>" required name="product">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <div class="row text-center ">
                                <div class="col-sm-4   ">
                                    <label for="price" required="required"><b>Price</b></label>
                                    <span class="input-group-addon">(KShs.)</span>
                                    <input class="form-control " type="text" value="<?php echo $price;?>" required name="price">
                                </div>
                                <div class="col-sm-4   pt-sm-1">
                                    <label for="price" required="required"><b>Quantity</b></label>
                                    <input class="form-control " type="text" value="<?php echo $quantity;?>" required name="quantity">
                                </div>
                                <div class="col-sm-4   pt-sm-1">
                                    <label for="price"><b>Status</b></label>
                                    <input class="form-control " type="text" value="<?php echo $status;?>" required name="status">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group  ">
                            <div class="row text-center pb-sm-1">

                                <div class="col-sm-12   pt-sm-2">
                                    <span class="label label-Description pb-3"><b>Description</b></span>
                                    <textarea class="form-control align-self-center" value="<?php echo $description;?>" required name="description"></textarea>
                                    <div class="modal-footer">
                                        <a class="btn btn-danger" href="farmer-profile.php">Close</a>
                                        <input type="submit" value="submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>

                        </div>



                </div>

                </form>

            </div>
        </div>
        <div class="col-sm-3 pt-2">

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

