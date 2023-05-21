<?php
/**
 * Fonction qui génère un input type select avec toutes les villes
 * @param $id id du select
 * @return code HTML à afficher
 */

function selectVille($id, $code)
    {
    global $bdd;
    $retour = "<select class=\"form-control\" id=\"$id\" name=\"$id\">\n";
    try {
        $requete = 'select code, nom from ville';
        foreach ($bdd->query($requete) as $ligne) {
            if($ligne['code']==$code){
                $retour .= "<option selected='selected' value=".$ligne['code'].">".$ligne['nom']."</option>";
            } else {
                $retour .= '<option value=' . $ligne['code'] . '>' . $ligne['nom'] . '</option>' . "\n";
            }

        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }$retour .= "</select>";
    return $retour;
}


function selectCivilite($id, $code)
    {
    global $bdd;
    $retour = "<select class=\"form-control\" id=\"$id\" name=\"$id\">\n";
    try {
        $requete = 'select code, libelle from civilite';
        foreach ($bdd->query($requete) as $ligne) {
            if($ligne['code']==$code){
                $retour .= "<option selected='selected' value=".$ligne['code'].">".$ligne['libelle']."</option>";
            } else {
                $retour .= '<option value=' . $ligne['code'] . '>' . $ligne['libelle'] . '</option>' . "\n";
            }

        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }$retour .= "</select>";
    return $retour;
}

function menuActif($menu)
{
    $ecran = basename($_SERVER['SCRIPT_FILENAME'], ".php");

if ($menu == $ecran) {
    return "active";
} else {
    return "";
}
}

// Pour afficher les messages d'erreur
function afficheMessages()
{
    $retour = '';
    if (!empty($_SESSION['MSG_OK'])) {
        $retour .= '<div class="alert alert-success">' . $_SESSION['MSG_OK'] . '</div>' . "\n";
        unset($_SESSION['MSG_OK']);
    }
    if (!empty($_SESSION['MSG_ADD'])) {
        $retour .= '<div class="alert alert-danger">' . $_SESSION['MSG_ADD'] . '</div>' . "\n";
        unset($_SESSION['MSG_ADD']) ;
    }

    if (!empty($_SESSION['MSG_NAME'])) {
        $retour .= '<div class="alert alert-danger">' . $_SESSION['MSG_NAME'] . '</div>' . "\n";
        unset($_SESSION['MSG_NAME']);
    }

    if (!empty($_SESSION['MSG_CP'])) {
        $retour .= '<div class="alert alert-danger">' . $_SESSION['MSG_CP'] . '</div>' . "\n";
        unset($_SESSION['MSG_CP']);
    }
    if (!empty($_SESSION['MSG_PAYS'])) {
        $retour .= '<div class="alert alert-danger">' . $_SESSION['MSG_PAYS'] . '</div>' . "\n";
        unset($_SESSION['MSG_PAYS']);
    }
    if (!empty($_SESSION['MSG_KO'])) {
        $retour .= '<div class="alert alert-danger">' . $_SESSION['MSG_KO'] . '</div>' . "\n";
        unset($_SESSION['MSG_KO']);
    }
    echo $retour;
}

?>
