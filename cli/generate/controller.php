<?php
/**
 * This file is used to generate the basic skeleton of a Controller class.
 */
$content = "<?php\n"
."use Core\\Controller;\n"
."class ".$argv[3]." extends Controller\n {\n\n"
."}";
file_put_contents(getcwd()."/Controller/".$argv[3]."Controller.php", $content);
echo "Created ".$argv[3]."Controller\n";
file_put_contents(getcwd()."/test/Controller/".$argv[3]."ControllerTest.php", "<?php\n#Please add your tests here");
echo "Created ".$argv[3]."ControllerTest\n";