<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Liste des villes</title>
        <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
    </head>

<?php

include("../include/connexion.php");
include("../include/menu.php");

 // Page qui affiche la liste de toutes les villes
$requete = "SELECT code, nom, codepostal, pays FROM ville";

?>

    <body>
        <div class="container">
            <h1>Les villes</h1>
<table class="table table-striped display table-hover" style="width:100%" id="villes">
    <thead>
            <tr>
                <th>Code</th>
                <th>Nom</th>
                <th>Code postal</th>
                <th>Pays</th>
            </tr>
    </thead>

<?php

try {
    foreach($bdd->query($requete) as $ligne) {
        echo '<tr class = "clickable-row table-hover" data-href="villes.php?id=' . $ligne['code'] . '">';
        echo '<td>' . $ligne['code'] . '</td>';
        echo '<td>' . $ligne['nom'] . '</td>';
        echo '<td>' . $ligne['codepostal'] . '</td>'; 
        echo '<td>' . $ligne['pays'] . "</td>\n";
    }
} catch (PDOException $e) {
    echo 'Erreur !: ' . $e->getMessage() . '<br/>';
    die();
}

?>
            </div>
        </table>
     
        <script src="../node_modules/jquery/dist/jquery.min.js"></script>
        <script src="../node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="../node_modules/dataTables.net-bs5/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#villes').DataTable({
                    language: {
                        url: '../include/fr_FR.json'
                    }
            });
            });
        </script>

            <script>
                $(document).ready(function($) {
                $(".clickable-row").click(function() {
                window.location = $(this).data("href");
                });
                });
            </script>
    </body>
</html>
































    