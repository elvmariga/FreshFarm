<!DOCtype html>
<html>
<?php
session_start();
?>;

<?php
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
    if ($conn->query($sql) === TRUE) {

// prepare and bind
        $stmt = $conn->prepare("select prod_id,quantity,veiw from book_prduc where owner_id=?");
        $view = 'yes';
        $stmt->bind_param("s", $owner_id);
        $stmt->execute();
        $stmt->bind_result($quantity, $view);
        $stmt->close();
        header("location:farmer-profile.php");
    }else{
        echo $stmt->error;
    }
}