<!-- Basic page template! Please modify but do not delete! -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/argon.min.css"/>
    <script src="assets/js/argon.min.js"></script>
    <title><?php echo $params["title"]; ?></title>
</head>
<body>
    <?php include("views/".$name.".php"); ?>
</body>
</html>
