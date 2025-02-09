
<?php
include 'header.php';
require '../functions/bdd.php';
require '../functions/accounts.php';
connexion_rederector();
create_table_sorties();
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