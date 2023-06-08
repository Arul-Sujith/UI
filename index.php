<?php
  $page = 'index.html';
  if (isset($_GET['page'])) {
    $page = $_GET['page'] . '.html';
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Br0s_C0d3_;-)</title>
    <link rel="stylesheet" href="<?php echo $page; ?>.css">
  </head>
  <body>
    <?php include $page; ?>
  </body>
</html>
