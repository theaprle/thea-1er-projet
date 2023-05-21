<?php
var_dump($_POST);
    session_start() ;
        include("../include/menu.php");
        echo afficheMessages();
        require_once('../include/connexion.php');
        require_once('../include/fonction.php');

        $id = (isset($_GET['id']))?$_GET['id']:0;
        if($id == 0) {
        header("Location:$url/listefournisseur.php");
        die();  
    }
        
        // Pour que les messages d'erreur s'affiche
        if((isset($_POST['Modifier']) or isset($_POST['creer'])) and $_SESSION['fournisseur'] = 1) {
            $nom0 = $_POST['nom'];
            $requete = $bdd->prepare('select count(*) as cpt from fournisseur where nom = :nom');
            $requete->execute(array( 'nom' => $nom0 ));
            $compteur = $requete->fetch();

            if (empty($_POST['adresse1'])) {
                $_SESSION['MSG_ADD'] = "L'adresse est obligatoire";
            }
            elseif (strlen($_POST['nom']) < 3) {
                $_SESSION['MSG_NAME'] = "3 caractères minimum requis";
            }
            elseif($compteur['cpt'] == 1) {
                $_SESSION['MSG_NAME'] = "le nom (".$_POST['nom'].") est déjà pris";
                }

        // Quand on clique sur le bouton "modifier" 
        if(isset($_POST['Modifier'])) {
            $_SESSION['MSG_OK'] = "Modification bien enregistrée";
            if(empty($_POST['adresse1'])) {
                $_SESSION['MSG_KO'] .= "L'adresse est obligatoire<br>" ;
            }
            try {
                $requete = $bdd->prepare('update fournisseur
                    set nom = :nom
                    , adresse1 = :adresse1
                    , adresse2 = :adresse2
                    , ville = :ville
                    , contact = :contact
                    , civilite = :civilite
                    where code = :code');
                $requete->execute(array('nom' => $_POST['nom']
                    , 'adresse1' => $_POST['adresse1']
                    , 'adresse2' => $_POST['adresse2']
                    , 'ville' => $_POST['ville']
                    , 'contact' => $_POST['contact']
                    , 'civilite' => $_POST['civilite']
                    , 'code' => $_POST['code']
                ));
            } catch (PDOException $e) {
                print "Erreur !: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }
        // Si on a cliqué sur "Modifier"
        try {
            $requete = $bdd->prepare('select nom, adresse1, adresse2, ville, contact,
            civilite, code from fournisseur where code = ?');
            $requete->execute(array($id));
                $fournisseur = $requete->fetch();
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
?>

<!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="utf-8">
            <title>fournisseur <?php echo $fournisseur['nom']; ?></title>
            <link href="../node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        </head>
     <body>
     </table>
        <div class="container">

                <h1>Fournisseur : <?php echo $fournisseur['nom']; ?></h1>

                    <form method="post">
                <div class="mb">
                    <label for="nom" class="form-label">Nom : </label>
                    <input type="text" class="form-control" id='nom' name="nom" aria-describedby="emailHelp" value="<?php echo $fournisseur['nom'] ?>">
                </div>

                <div class="mb">
                    <label for="adresse1" class="form-label">Addresse 1 : </label>
                    <input type="text" class="form-control" id='adresse1' name='adresse1' aria-describedby="emailHelp" value="<?php echo $fournisseur['adresse1'] ?>">
                </div>
                <div class="mb">
                    <label for="adresse2" class="form-label">Addresse 2 : </label>
                    <input type="text" class="form-control" id="adresse2"name='adresse2' aria-describedby="emailHelp" value="<?php echo $fournisseur['adresse2'] ?>">
                </div>
                <div class="mb">

                    <div class="mb">
                    <label class="ville"id='ville' name='ville' for="ville">Ville : </label>
                    <div class="col-sm-10"> 
                        <?php echo selectVille('ville', $fournisseur['ville']); ?>
                    </div>
                    </div>

                </div>
                <div class="mb">
                    <label for="contact" class="form-label">Contact : </label>
                    <input type="text" class="form-control" id="contact"name='contact' aria-describedby="emailHelp" value="<?php echo $fournisseur['contact'] ?>">
                </div>

                <div class="formulaire">
                    <div class="form-group row">
                    <label class="civilite" id='civilite'name='civilite' for="civilite">Civilité</label>
                    <div class="col-sm-10">
                        <?php echo selectCivilite('civilite', $fournisseur['civilite']); ?>
                    </div>

                    <div class="mb">
                    <label for="code" class="form-label"></label>
                    <input type="hidden" class="form-control" id='code' name="code" aria-describedby="emailHelp" value="<?php echo $fournisseur['code'] ?>">
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
                </div>
                </form>
            </div>
            <script src="../js/jquery.js"></script>
                <script>
                $(function() {
                    $('.confirm').click(function() {
                        return window.confirm("Êtes-vous sur ?");
                    });
                });
        </script>
    </body>
</html>
