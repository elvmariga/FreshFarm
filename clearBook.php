<?php
session_start();

if($_SESSION['ID']!=null){

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "FreshFarm";
    $post_id = $_POST["book_id"];
//Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql ="use FreshFarm";
    if($conn->query($sql)==TRUE){

        $stmt = $conn->prepare("DELETE FROM bookprduct WHERE book_id=?");
        $stmt->bind_param("s",$post_id);
        if($stmt->execute()){

        }else{

        }

        $stmt->close();
        header("Location:viewBooked.php");

    }
}
?>;