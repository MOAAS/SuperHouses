<?php
    include_once('../database/db_users.php');
    
    echo json_encode(userExists($_GET['username'])?true:false);
?>