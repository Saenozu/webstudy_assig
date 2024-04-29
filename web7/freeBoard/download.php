<?php
    include('./config.php');
    include('./db.php');

    if (isset($_SESSION['is_login'])) {
        echo "<meta http-equiv='refresh' content='0;url=./''>";
    }

    $con_no = intval($_GET['no']);

    $query = "SELECT file FROM FreeBoard_Post WHERE no=$con_no";
    
    if (mysqli_num_rows($result=mysqli_query($conn,$query))) {
        $row = mysqli_fetch_array($result);
        $file_name = $row['file'];
        $download_name = substr($file_name,11);
        
        $path = "./WkZoQ2MySXlSbXM9/$file_name";
        $file_size = filesize($path);
        echo $path;
        
        header("Pragma: public");
        header("expires: 0");
        header("Content-Type: application/octet-stream");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: ".$file_size);
        header("Content-Disposition: attachment; filename=\"$download_name\"");
        
        ob_clean();
        flush();
        readfile($path);
    }
?>
