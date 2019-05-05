<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

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
    if($conn->query($sql)===TRUE){
        $stmt = $conn->prepare("select email from farmer Where ID_no=? ");
        $stmt->bind_param("s",$_SESSION['ID']);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->fetch();
        $stmt->close();
        if($email!=null && $_SERVER["REQUEST_METHOD"]=="POST"){
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
// Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }
// Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
// Check file size
            if ($_FILES["fileToUpload"]["size"] > 1000000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }
// Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
// Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    $stmt = $conn->prepare("insert into product (product_name, price, quantity, status, image_url, description, owner_id) values (?,?,?,?,?,?,?)");
                    $stmt->bind_param("ssissss",$product_name, $price, $quantity, $status,$target_file, $description, $_SESSION["ID"]);
                    if($stmt->execute()){
                        echo "Product posted";
                        header("Location:farmer-profile.php");


                    }else{
                        echo $stmt->error;
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }


        }elseif ($email!=null){


        }else{
            header("Location:farmer-login.php");

        }

    }else{
        echo "connection error".$conn->error;
    }

}else{

    header("Location:farmer-login.php");
}

?>


<?php
if($conn->query($sql)===TRUE){
//    $stmt = $conn->prepare("select product_name from product Where product_id=? ");
//    $stmt->bind_param("i",$_SESSION['ID']);
//    if($_SERVER["REQUEST_METHOD"]=="GET"){
//        $product_id = $_SESSION["ID"];
//    }
//
//
//    if(!$stmt->execute()){
//        echo $stmt->error;
//    }
//    $stmt->bind_result($username);
//    $stmt->fetch();
//    $stmt->close();

    $stmt = $conn->prepare(" select product_id,product_name, price, quantity,status, description, image_url from product where owner_id=?" );
    $stmt->bind_param("s", $_SESSION['ID']);
    $stmt->execute();

    $stmt->bind_result($product_id, $product_name, $price, $quantity, $status, $description, $target_file);
    $stmt->fetch();
    $stmt->close();
echo $_SESSION['ID'];
//    $stmt= $conn->prepare(" select file_path from product where product_id=? ");
//    $stmt -> bind_param("i", $session['ID']);
//    $stmt->execute();
//    $stmt->bind_result($file_path);
//    $stmt->fetch();
//    $stmt->close();



}else{
    echo "connection error".$conn->error;
}
?>
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
                    <a class="nav-link" href="buyer-login.php">Shop</a>
                </li>
                <li>
                    <a class="nav-link" href="logout.php">Logout</a>

                </li>
            </ul>

        </div>
    </div>

</nav>
<div class="row text-center mt-5">
    <div class="col-sm-4 p-5 pt-3">


            <!--modal for post product-->
        <button  role="button" class="btn btn-success mr-5" data-target="#exampleModal" data-toggle="modal">Post Product</button>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content p-5">
                    <div class="modal-header all-color-successful" id="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Post Products to the MarketPlace</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                        <p> <b>Please enter the details of the product</b></p>
                        <form class="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" role="form">
                            <img class="img-fluid" src="img/images%20(3).jpg" height="200px">
                            <hr>
                            <div class="custom-file mt-1">
                                <input type="file" class="custom-file-input"  id="customFile" name="fileToUpload" required>
                                <label class="custom-file-label" for="customFile"><b>Choose file</b></label>
                            </div>
                            <hr>
                            <div class="row text-center   p-3 ">
                            <div class col-sm-6>
                                <label for="product" required="required"><b>Product</b></label>
                                <input type="text" class="form-control ml-9" id="product" name="product" placeholder="enter product">
                            </div>
                            </div>
                            <hr>
                            <div class="form-group">
                                <div class="row text-center ">
                                    <div class="col-sm-4   ">
                                        <label for="price" required="required"><b>Price</b></label>
                                        <span class="input-group-addon">KShs.</span>
                                        <input type="number" class="form-control" name="price" placeholder="Price" aria-label="Amount (to the nearest Kshs)">
                                    </div>
                                    <div class="col-sm-4   pt-sm-1">
                                        <label for="price" required="required"><b>Quantity</b></label>
                                        <input type="text" class="form-control" id="quantity"  name="quantity" placeholder="quantity">
                                    </div>
                                    <div class="col-sm-4   pt-sm-1">
                                        <label for="price"><b>Status</b></label>
                                        <input type="text" class="form-control" id="status"  name="status" placeholder="Status">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group  ">
                                <div class="row text-center pb-sm-1">

                                    <div class="col-sm-12   pt-sm-2">
                                        <span class="label label-Description pb-3"><b>Description</b></span>
                                        <textarea name="description" id="description" class="form-control" rows="6" required="required"></textarea>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <input type="submit" value="submit" class="btn btn-primary">
                                        </div>
                                        </div>
                                    </div>

                                </div>



                            </div>

                        </form>

                    </div>
                </div>
        <div class="row mt-5 justify-content-center">


            <?php
            $stmt = $conn->prepare(" select  ID_no, first_name, last_name, email,  phone_no, location from  farmer where ID_no=?");
            $stmt->bind_param("i",$ID_no);
            if ($stmt->execute()) {
                $stmt->bind_result($ID_no, $first_name, $last_name, $email, $phone_no, $location);
                while ($stmt->fetch()) {

                    echo '
            <p> Name: '.$first_name.'</p>
            ';
                }
            }else{
                echo $stmt->error;
            }
            ?>

                <div class="row justify-content-around">
                    <div class="col-sm-11 col-md-5 col-lg-3 col-xl-3">
                        <div class="mt-5 col-12" ><h1  class="text-info text-center"><?php echo $first_name;?></h1></div>
                    </div>

                </div>

            </div>
    </div>
    <div class="col-sm-6 p-5 pt-3 ">
        <form class="form-inline my-5 my-lg- ml-5 ">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
        </form>

        <div class="container">

            <?php
            $stmt = $conn->prepare("select* from product");
            if($stmt->execute()){
                $stmt->bind_result($product_id2,$product_name,$price,$quantity,$status, $description,$image_url,$date, $owner_id);
                while ($stmt->fetch()){

                    $p= strpos($description,"<div>");
                    $shot;
                    if($p==false){
                        $shot = substr($description,0,30).".....";

                    }else{
                        strpos($description,"<div>");
                        if($p<33)
                            $shot = substr($description,0,$p-3)."......";
                        else{
                            $shot = substr($description,0,30).".....";
                        }

                    }




                    echo '
        <div class="row  mt-3">
        <div class="col-12 bg-light mt-2 ">
            <div class="row justify-content-between">
                <div class="col-4 pr-3 pl-0">
                    <img src="'.$image_url.'" class="card-img-top" height="180">

                </div>
                <div class="col-8">
                    <div class="row justify-content-between pr-3 pt-2">
                    <label for="price"><b>Product Name:</b></label>
                        <h6>'.$product_name.'</h6>
                        <small class="small text-muted pl-1">'.$date.'</small>
                    </div>
                    <hr>
                    <div class="row text-center p-1">
                        <div class="col-sm-3">
                            <label for="price"><b>Price</b></label>
                            <p>'.$price.'</p>
                        </div>
                        <div class="col-sm-3">
                            <label for="quantity"><b>Quantity</b></label>
                            <p>'.$quantity.'</p>
                        </div>
                        <div class="col-sm-3">
                            <label for="status"><b>Status</b></label>
                            <p>'.$status.'</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row p-1 mt-0">
                        <strong> Description  </strong>
                    </div>
                    <div class="row">
                        
                        '.$shot.'
                          <hr>
                    </div>
                        <div class="row al align-content-end">
                            <div class="col-9">
                                     </div>
                                <div class=" col-2 pb-2">
                                   <form class="form-inline" action="deletePost.php" method="post" enctype="multipart/form-data">
                                    <input class="d-none" type="text" name="product_id" value="' .$product_id2 .'" >
                                    <input type="submit" value="Remove" class="btn btn-danger">
                                    </form>
                                </div>
                             
                            </div>



                </div>
                </div>


             </div>

            ';






                }
            }else{
                echo $stmt->error;
            }

            ?>



        </div>






        <script>
            bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
        </script>

    </div>
    <div class="col-sm-2 p-5 pt-3">
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
