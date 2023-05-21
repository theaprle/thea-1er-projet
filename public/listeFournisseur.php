<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Liste des fournisseurs</title>
        <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
    </head>

<?php

include("../include/connexion.php");
include("../include/menu.php");

// Page qui affiche la liste de tout les fournisseurs
$requete = "SELECT f.code
            , c.libelle
            , f.nom
            , f.contact
            , v.codepostal
            , v.nom as ville
            FROM fournisseur f
            , civilite c
            , ville v
            where f.civilite = c.code
            and f.ville = v.code";
?>

<body>
        <div class="container">
            <h1>Les fournisseurs</h1>
<table class="table table-striped table-hover">
    <thead>
            <tr>
                <th>Code</th>
                <th>Civilité</th>
                <th>Nom</th>
                <th>Contact</th>
                <th>Code postal</th>
                <th>Ville</th>
            </tr>
    </thead>

<?php

try {
    foreach($bdd->query($requete) as $ligne) {
        echo '<tr class = "clickable-row table-hover" data-href="fournisseurs.php?id=' . $ligne['code'] . '">';
        echo '<td>' . $ligne['code'] . '</td>';
        echo '<td>' . $ligne['nom'] . '</td>';
        echo '<td>' . $ligne['libelle'] . '</td>';
        echo '<td>' . $ligne['contact'] . '</td>';
        echo '<td>' . $ligne['codepostal'] . '</td>'; 
        echo '<td>' . $ligne['ville'] . "</td>\n";
    }
} catch (PDOException $e) {
    echo 'Erreur !: ' . $e->getMessage() . '<br/>';
    die();
}

?>
             </div>
            </table>
        <script src="../node_modules/jquery/dist/jquery.js"></script>
            <script>
                $(document).ready(function($) {
                $(".clickable-row").click(function() {
                window.location = $(this).data("href");
                });
                });
            </script>

    </body>
</html>


