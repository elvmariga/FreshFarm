<?php
session_start();

if(true){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "FreshFarm";
    $post_id = $_POST["product_id"];
//Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql ="use FreshFarm";
    if($conn->query($sql)===TRUE){

        $stmt = $conn->prepare("DELETE FROM product WHERE product_id=?");
        $stmt->bind_param("s",$post_id);
        $stmt->execute();
        $stmt->close();
        header("Location:farmer-profile.php");

    }
}
?>;