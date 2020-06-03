<?php

$content = "<?php\n"
."namespace Models {\n"
."\tuse Core\Data\DataObject;\n\n"
."/**\n* @table ".$argv[3]."\n*/\n"
."class ".$argv[3]." extends DataObject {\n"
."  /**\n"
."  * @var integer PRIMARY KEY AUTOINCREMENT\n"
."  */\n"
."  public $id\n"
."}";
file_put_contents(getcwd()."/Models/".$argv[3].".php", $content);
echo "Created ".$argv[3]."\n";
file_put_contents(getcwd()."/test/Models/".$argv[3]."Test.php", "<?php\n#Please add your tests here");
echo "Created ".$argv[3]."Test\n";