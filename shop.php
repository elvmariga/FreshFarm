<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

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
            $stmt = $conn->prepare("select * from buyer Where user_id=? ");
            $stmt->bind_param("s",$_SESSION['ID']);
            $stmt->execute();
            $stmt->bind_result($ID_no, $first_name,$last_name,$email, $buyer_password,$date, $user_id);
            $stmt->fetch();
            $stmt->close();


echo $_SESSION['ID'];
        }elseif($email==null && $_SERVER["REQUEST_METHOD"]=="POST"){
                $username= $_POST["username"];
                $phone_no=$_POST['phone_no'];
                $location=$_POST['location'];
                echo $_SESSION['ID'];

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
                        $stmt = $conn->prepare("insert into buyer_profile (username, phone_no, location, image_url,profile_id,owner_id) values (?,?,?,?,?,?)");
                        $owner_id= $user_id;
                        $stmt->bind_param("sissii",$username,$phone_no, $location,$target_file,$_SESSION["ID"], $owner_id);
                        echo $stmt->error;
                        if($stmt->execute()){
                            header("Location:shop.php");


                        }else{
                            echo $stmt->error;
                        }
                        echo $_SESSION['ID'];
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }

                }else{

                 echo "error in editting";
            }
        }else {
        echo "connection error" . $conn->error;
    }

    ?>



    <?php
    $stmt = $conn->prepare("select * from buyer_profile where profile_id=?");
    $X=1;
    $stmt->bind_param("s",  $X);
    $stmt->execute();

    $stmt->bind_result($username,$phone_no, $location, $target_file, $profile_id, $owner_id);
    $stmt->fetch();

    $stmt-> close();
echo $_SESSION['ID'];

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
                        <a class="nav-link" href="shop.php">Shop</a>
                    </li>
                    <li>
                        <a class="nav-link" href="logout.php">Logout</a>

                    </li>
                </ul>

            </div>
        </div>

    </nav>
    <div class="container">
        <div class=" row text-center">
            <div class="col-3  p-2 mr-2 ">
                <div class="col-sm-11 col-md-10 col-lg-9 col-xl-8 justify-content-center">
                    <div class="justify-content-center d-flex">
                        <img src="<?php echo $target_file;?>" class="rounded rounded-circle img mt-5 shadow-lg" width="100" height="100">
                    </div>


                </div>
                <div class="mt-5 col-12" ><h5  class="text-info text-center"><?php echo $first_name, $last_name;?></h5></div>

                <hr>
                <div class=" container text-center">

                    <p><b>Email</b> <?php echo $email;?> </p>
                        <hr>
                    <p><b>Phone Number:</b> <?php echo $phone_no;?> </p>
                    <hr>
                    <p><b>Location</b> <?php echo $location;?> </p>


                </div>
                <div class="row justify-content-center col-4">
<!--                    modal edit profile-->
                    <button  role="button" class="btn btn-success mr-5" data-target="#exampleModal" data-toggle="modal">Edit Profile</button>
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
                                <form class="col-sm-12 col-md-10 col-lg-9 col-xl-8 align-self-center" action="<?php echo $_SERVER["PHP_SELF"];?> " method="post" enctype="multipart/form-data">
                                    <div class="row align-items-center">
                                        <div class="custom-file mt-1  col-4 offset-4 ">
                                            <input type="file" class="custom-file-input" id="customFile" name="fileToUpload" required>
                                            <label class="custom-file-label" for="customFile">Choose a profile image to upload</label>
                                        </div>
                                    </div>
                                    <div class="row justify-content-around">
                                        <div class="col-sm-11 col-md-5 col-lg-3 col-xl-3 pt-3">



                                            <div class="form-group">
                                                <label for="input username"><b>Username</b></label>
                                                <input type="text" class="form-control" id="Username" name="username" placeholder="Enter Username " required>

                                            </div>


                                            <div class="form-group">
                                                <label for="input username"><b>Phone No.</b></label>
                                                <input type="number" class="form-control" id="phone_no" name="phone_no" placeholder="Enter Phone No. " required>
                                            </div>
                                            <div class="form-group">
                                                <label for="input username"><b>Location</b></label>
                                                <input type="text" class="form-control" id="location" name="location" placeholder="Enter location " required>
                                            </div>




                                        </div>

                                    </div>

                            </div>


                            <div class="row mt-5 mb-5 justify-content-center">
                                <input type="submit" name="submit_profile" value="save" class="btn btn-success">

                            </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-7 p-2 pt-3 shadow-lg">
                <div class="row justify-content-between m-5 p-2 ">
                    <div class="col-12">
                    <h5>Shop Organic Fruits, Melons,kalimoni Seasonal Baskets, Berries & Mangoes, Citrus Fruits, Azuri Dried Fruit,carrots, Butternut, Potatoes, Kale (Sukuma Wiki), Matoke, Potatoes, Tomatoes, Mushrooms, Peas, Onion, Managu, Spinanch</h5>
                    </div>
                </div>
                <hr>

                <div class="container m-2 p-2">

                    <?php
                    if($_SESSION["ID"]!=null){
                        $stmt = $conn->prepare("select* from product");

                        if($stmt->execute()){
                            $stmt->bind_result($product_id,$product_name,$price,$quantity,$status, $description,$image_url,$date, $owner_id);
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
                <div class="row justify-content-center col- 10">
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
                            <a  class ="btn btn-info" href="bookProduct.php?product_id='.$product_id.'">Book</a>
                                   
                            </div>
                            <div class=" row col-2 pb-2">
                           
                                    
                               <button  role="button" class="btn btn-success mr-5" data-target="#id'.$product_id.'" data-toggle="modal">View</button>
        <div class="modal fade text-center col-10" id="id'.$product_id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content text-center">
                    <div class="modal-header ">
                        <h5 class="modal-title" id="exampleModalLabel">Product Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <form style="color:black"  enctype="multipart/form-data" method="post">
                        <div class="modal-body">
                            <div class="w-70">
                                  <div class=" tex-center col-6 pr-3 pl-5">
                        <img src="'.$image_url.'" class="card-img-top" height="180">

                    </div>
                    <hr>
                    <div class="col-12">
                        <div class="row justify-content-between pl-3 pr-1 pt-2 col-2">
                        <label for="price"><b>Product Name:</b></label>
                            <h5>'.$product_name.'</h5>

                        </div>
                        <hr>
                        <div class="row text-center p-3 col-12">
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
                        <div class="row p-2 mt-0 col-3">
                            <strong> Description  </strong>
                        </div>
                        <div class="row">

                            '.$description.'
                              <hr>

                        </div>
                                    <small class="small text-muted pl-1">Posted On: '.$date.'</small>


                            </div>


                        </div>
                        <div class="modal-footer">
                                    
                            <!--<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->

                        </div>
                    </form>
                </div>
            </div>
        </div>
                            </div>


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
                    }
                    ?>





                </div>
            </div>
            <div class="col-1 p-2">
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