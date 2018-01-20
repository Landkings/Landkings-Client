<?php
    include("conn.php");
    if (isset($_POST["recordToDelete"]) && strlen($_POST["recordToDelete"]) > 0 && is_numeric($_POST["recordToDelete"])){
        
        $id_to_delete = filter_var($_POST["recordToDelete"], FILTER_SANITIZE_NUMBER_INT);

        if (!mysqli_query($conn, "DELETE FROM list WHERE id = " . $id_to_delete)){
            header('HTTP/1.1 500 Could not delete record!');
            exit();
        }
    }
    if (isset($_POST["SuccessTask"]) && strlen($_POST["SuccessTask"]) > 0 && is_numeric($_POST["SuccessTask"])){
        
        $id_to_update = filter_var($_POST["SuccessTask"], FILTER_SANITIZE_NUMBER_INT);

        if (!mysqli_query($conn, "UPDATE list SET status = 1 WHERE id = " . $id_to_update)){
            header('HTTP/1.1 500 Could not delete record!');
            exit();
        }
    }
    if (isset($_POST["LoseTask"]) && strlen($_POST["LoseTask"]) > 0 && is_numeric($_POST["LoseTask"])){
        
        $id_to_update = filter_var($_POST["LoseTask"], FILTER_SANITIZE_NUMBER_INT);

        if (!mysqli_query($conn, "UPDATE list SET status = -1 WHERE id = " . $id_to_update)){
            header('HTTP/1.1 500 Could not delete record!');
            exit();
        }
    } 
    mysqli_close($conn);
?>