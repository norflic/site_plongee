
<?php
include 'header.php';
?>
<?php
require '../functions/bdd.php';
session_start();
$sorties = get_sorties()



?>
<body>
<?php
include 'navBar.php';
?>
<div id="sorties_cards">

</div>

<script>
    var sorties = <?php echo json_encode($sorties); ?>;
</script>
<script src="afficheSorties.js"></script>
</body>
</html>