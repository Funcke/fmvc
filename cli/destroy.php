<?php
    /**
     * Control structure to run the entity generation cycle
     */
    if(sizeof($argv) >= 4) {
        switch($argv[2]) {
            case 'controller': {
                unlink(getcwd()."/Controller/".$argv[3]."Controller.php"); 
                unlink(getcwd()."/test/Controller/".$argv[3]."ControllerTest.php");
             } break;
            case 'model': {
                unlink(getcwd()."/Models/".$argv[3].".php"); 
                unlink(getcwd()."/test/Models/".$argv[3]."Test.php");
            } break;
        }
    } else {
        echo "Error. To few arguments for generate.";
    }