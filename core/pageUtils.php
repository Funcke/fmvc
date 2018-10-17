<?php
namespace Core {
    class PageUtils {
      public static function renderErrorPage($params) {
          http_response_code($params["code"]);
          $name = "error";
          require_once("views/base.php");
          exit();
      }
    }
}
?>
