<?php
    /**
     * Control structure to run the entity generation cycle
     */
    if(sizeof($argv) >= 4) {
        switch($argv[2]) {
            case 'controller': require_once('generate/controller.php'); break;
            case 'model': require_once('generate/model.php'); break;
        }
    } else {
        echo "Error. To few arguments for generate.";
    }