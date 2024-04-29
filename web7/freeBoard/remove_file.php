<?php
    include('./config.php');
    include('./db.php');

    if (!isset($_SESSION['is_login'])) {
        echo "<meta http-equiv='refresh' content='0;url=./''>";
    }

    echo "document.getElementById('edit_input_file').value = '';";
    echo "document.getElementById('print_file_name').style.display='none';";
        $query = "UPDATE FreeBoard_Post SET file=NULL WHERE no=$con_no";
        if($result = mysqli_query($conn, $query)) {
            unlink('./WkZoQ2MySXlSbXM9/'.$m_file);
            $m_file = NULL;
        }
?>