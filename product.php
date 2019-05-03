<?php
$user_error="";
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada.">
    <meta name="Elvis Mariga" content="">
    <link rel="icon" href="img/icon.jpg">

    <title>FreshFarm | Product</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="dist/css/bootstrap.min.css">


    <!--custom CSS-->

    <link href="carousel.css" rel="stylesheet" type="text/css">
</head>
<body>
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
            $product = $_POST["product"];
            $price = $_POST["price"];
            $status = $_POST["status"];
            $description= $_POST["description"];

            $img_url = "ddd";
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
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
            if ($_FILES["fileToUpload"]["size"] > 500000) {
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
                    $stmt = $conn->prepare("insert into product (product_name, price, quantity, status, image_url, description) values (?,?,?,?,?,?)");
                    $stmt->bind_param("ssfssss",$product_name,$target_file, $price, $quantity, $status, $description, $_SESSION["ID"]);
                    if($stmt->execute()){
                        echo "Product posted";
                        header("Location:farmer_profile.php");


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
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="index.html"> <img class="rounded-circle" src="img/images%20(2).jpg" alt="fruits" width="20" height="20">FreshFarm</a>


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsDefault" aria-controls="navbarsDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <div class="container pl-20px">
                <div class="collapse navbar-collapse" id="navbarsDefault">
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
            <button class="btn btn-secondary my-2 my-sm-0" id="post1" data-toggle="modal" data-target="#modal-post">Post to the MarketPlace</button>
            <div class="modal fade bd-example-modal-lg" id="modal-post" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="container pt-5">
                            <h2>Product to sell</h2>
                            <p> <b>Please enter the details of the product</b></p>
                            <form class="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" role="form">
                                <div class="form-group">
                                    <div class="row text-center pb-3">
                                        <div class="col-sm-4   pt-3">


                                            <label for="product" required="required">Product</label>
                                            <input type="text" class="form-control" id="product" name="product" placeholder="enter product">
                                        </div>
                                        <div class="col-sm-4   pt-3">
                                            <label for="price" required="required">Price</label>
                                            <span class="input-group-addon">KShs.</span>
                                            <input type="text" class="form-control" name="price" placeholder="Price" aria-label="Amount (to the nearest Kshs)">
                                        </div>
                                        <div class="col-sm-4   pt-3">
                                            <label for="price" required="required">Quantity</label>
                                            <input type="text" class="form-control" id="quantity"  name="quantity" placeholder="quantity">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group  ">
                                    <div class="row text-center pb-3">
                                        <div class="col-sm-4   pt-3">
                                            <label for="price">Status</label>
                                            <input type="text" class="form-control" id="status"  name="status" placeholder="Status">
                                        </div>
                                        <div class="col-sm-8   pt-3">
                                            <span class="label label-Description pb-3">Description</span>
                                            <textarea name="description" id="description" class="form-control" rows="6" required="required"></textarea>
                                            <div class="col-sm-4   pt-3">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" p-5>Close</button>
                                                <input type="submit" name="submit_profile" value="save" class="btn btn-success">
                                            </div>
                                        </div>

                                    </div>



                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
    </nav>
    <button  role="button" class="btn btn-success mr-5" data-target="#exampleModal" data-toggle="modal">Post Product</button>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header all-color-primary">
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
                                <input type="text" class="form-control" name="price" placeholder="Price" aria-label="Amount (to the nearest Kshs)">
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

    <button class="btn-floating btn-lg purple-gradient" id="post1" data-toggle="modal" data-target="#modal-post">Post to the MarketPlace</button>
    <div class="modal fade bd-example-modal-lg" id="modal-post" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="container pt-5">
                    <h2>Product to sell</h2>
                    <p> <b>Please enter the details of the product</b></p>
                    <form class="form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data" role="form">
                        <div class="form-group">
                            <div class="row text-center pb-3">
                                <div class="col-sm-4   pt-3">


                                    <label for="product" required="required">Product</label>
                                    <input type="text" class="form-control" id="product" name="product" placeholder="enter product">
                                </div>
                                <div class="col-sm-4   pt-3">
                                    <label for="price" required="required">Price</label>
                                    <span class="input-group-addon">KShs.</span>
                                    <input type="text" class="form-control" name="price" placeholder="Price" aria-label="Amount (to the nearest Kshs)">
                                </div>
                                <div class="col-sm-4   pt-3">
                                    <label for="price" required="required">Quantity</label>
                                    <input type="text" class="form-control" id="quantity"  name="quantity" placeholder="quantity">
                                </div>
                            </div>
                        </div>
                        <div class="form-group  ">
                            <div class="row text-center pb-3">
                                <div class="col-sm-4   pt-3">
                                    <label for="price">Status</label>
                                    <input type="text" class="form-control" id="status"  name="status" placeholder="Status">
                                </div>
                                <div class="col-sm-8   pt-3">
                                    <span class="label label-Description pb-3">Description</span>
                                    <textarea name="description" id="description" class="form-control" rows="6" required="required"></textarea>
                                    <div class="col-sm-4   pt-3">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" p-5>Close</button>
                                        <input type="submit" name="submit_profile" value="save" class="btn btn-success">
                                    </div>
                                </div>

                            </div>



                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
</html>