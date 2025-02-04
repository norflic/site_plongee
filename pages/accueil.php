<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="style.css">
</head>
<?php
require '../functions/bdd.php';
session_start();
$sorties = get_sorties()



?>
<body>
<div id="sorties_cards">

</div>

<script>
    var sorties = <?php echo json_encode($sorties); ?>;
</script>
<script src="afficheSorties.js"></script>
</body>
</html>