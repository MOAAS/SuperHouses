<?php 

function addErrorMessage($content) {
    if (isset($_SESSION['messages']))
        array_push($_SESSION['messages'],  array('type' => 'error', 'content' => $content));
    else $_SESSION['messages'][] = array('type' => 'error', 'content' => $content);
}

function addSuccessMessage($content) {
    if (isset($_SESSION['messages']))
        array_push($_SESSION['messages'],  array('type' => 'success', 'content' => $content));
    else $_SESSION['messages'][] = array('type' => 'success', 'content' => $content);
}

?>