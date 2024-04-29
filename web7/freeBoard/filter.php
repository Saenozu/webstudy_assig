<?php
include("./db.php");

$dir = "./WkZoQ2MySXlSbXM9/";
$query = "SELECT file FROM FreeBoard_Post WHERE LOWER(file) LIKE '%.php%' OR LOWER(file) LIKE '%.asp%' OR LOWER(file) LIKE '%.jsp%'";
if (mysqli_num_rows($result=mysqli_query($conn,$query))) {
    while($row=mysqli_fetch_array($result)) {
        $filepath = $dir.$row['file'];
        unlink($filepath);
    }
    $query = "UPDATE FreeBoard_Post SET file=NULL WHERE LOWER(file) LIKE '%.php%' OR LOWER(file) LIKE '%.asp%' OR LOWER(file) LIKE '%.jsp%'";
    mysqli_query($conn,$query);
}

?>