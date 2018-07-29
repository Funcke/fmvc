<?php

function renderErrorPage($params) {
    http_response_code($params["code"]);
    $name = "error";
    include("views/base.php");
    exit();
}

?>