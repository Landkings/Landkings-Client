<?php
    if (isset($_POST["submit"])){
        $title = addslashes($_POST['title']);
        $description = addslashes($_POST['description']);
        $query = "INSERT INTO list (name, description, status) VALUES ('".$title."', '".$description."', 0)";
        mysqli_query($conn, $query);
    }
?>