<?php
var_dump($_POST);
    session_start() ;
        include("../include/menu.php");
        echo afficheMessages();
        require_once('../include/connexion.php');
        require_once('../include/fonction.php');

        $id = (isset($_GET['id']))?$_GET['id']:0;
        if($id == 0) {
        header("Location:$url/listeVille.php");
        die();
    }
    
        try {
            $requete = $bdd->prepare('select code, nom, codepostal, pays from ville where code =?');
            $requete->execute(array($id));
                $ville = $requete->fetch();
            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
    }

    // Pour afficher les messages d'erreur
    if((isset($_POST['Modifier'])  or isset($_POST['creer'])) and $_SESSION['ville'] = 1) {

        $allowedValues = array('France', 'Andorre', 'Monaco');
        $nom0 = $_POST['nom'];
        $requete = $bdd->prepare('select count(*) as cpt from ville where nom = :nom');
        $requete->execute(array( 'nom' => $nom0 ));
        $compteur = $requete->fetch();

        if ((!is_numeric($_POST['codepostal']) || ((strlen(strval($_POST['codepostal']))) != 5))) {
            $_SESSION['MSG_CP'] = "Le Codepostal est oblogatoirement composer de 5 numero";
        }
        elseif (strlen($_POST['nom']) <= 2) {
            $_SESSION['MSG_NAME'] = "2 caractères minimum requis";
        }
        elseif (!in_array(($_POST['pays']), $allowedValues)) {
            $_SESSION['MSG_PAYS'] = "Le Pays doit être : France, Andorre ou Monaco";
        }
        elseif($compteur['cpt'] == 1) {
            $_SESSION['MSG_NAME'] = "le nom (".$_POST['nom'].") est déjà pris";
            }

    elseif(isset($_POST['Modifier']) and $_SESSION['ville'] = 1 ) {
                try {
                    $requete = $bdd->prepare('update ville
                                    set nom = :nom
                                    , codepostal = :codepostal
                                    , pays = :pays
                                    where code = :code');

                    $requete->execute(array('nom' => $_POST['nom']
                    , 'codepostal' => $_POST['codepostal']
                    , 'pays' => $_POST['pays']
                    , 'code' => $id
                    ));
                } catch (PDOException $e) {
                    print "Erreur !: " . $e->getMessage() . "<br/>";
                    die();
                }
                $_SESSION['MSG_OK'] = "Modification bien enregistrée";
            }

    // Quand on clique sur le bouton "modifier" 
    if(isset($_POST['Modifier'])) {
        $_SESSION['MSG_OK'] = "Modification bien enregistrée";
        try {
            $requete = $bdd->prepare('update ville
                set nom = :nom
                , codepostal = :codepostal
                , pays = :pays
                where code = :code');
            $requete->execute(array('nom' => $_POST['nom']
                , 'codepostal' => $_POST['codepostal']
                , 'pays' => $_POST['pays']
                , 'code' => $_POST['code']
            ));
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
        // Si on à cliqué sur "Modifier"
        try {
            $requete = $bdd->prepare('select nom, codepostal, pays,
            code from ville where code = ?');
            $requete->execute(array($id));
                $ville = $requete->fetch();
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
?>

<!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>ville <?php echo $ville['nom']; ?></title>
            <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
            <link href="../css/style.css" rel="stylesheet">
        </head>

        <body>
            <div class="container">
              <h1>ville <?php echo $ville['nom']; ?></h1>
              <form method="post">
                    <div class="formulaire">
                        <label for="examplenom" class="form-label">Nom</label>
                        <input name="nom" class="form-control" id="examplenom" value="<?php echo $ville['nom'] ?>">
                    </div>

                    <div class="formulaire">
                        <label for="examplecodepostal" class="form-label">Code postal</label>
                        <input name="codepostal" class="form-control" id="examplecodepostal" value="<?php echo $ville['codepostal'] ?>">
                    </div>

                    <div class="formulaire">
                        <label for="examplepays" class="form-label">Pays</label>
                        <input name="pays" class="form-control" id="examplepays" value="<?php echo $ville['pays'] ?>">
                    </div>

                    <div class="mb">
                        <label for="code" class="form-label"></label>
                        <input type="hidden" class="form-control" id='code' name="code" aria-describedby="emailHelp" value="<?php echo $ville['code'] ?>">
                    </div>

                    <!-- Pour créer les différents boutons -->
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <input type="submit" class="btn btn-default btn-small" name="Annuler" value="Annuler">
                        <?php if($_SESSION['fournisseur'] == 1) ?>
                        <input type="submit" class="btn btn-primary btn-small" name="Modifier" value="Modifier">
                        <input type="submit" class="confirm btn btn-danger btn-small" name="Supprimer" value="Supprimer">
                    </div>
                    </div>
                </div>
                </form>
            </div>
    </body>
</html>