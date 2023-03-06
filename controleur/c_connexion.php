<?php 

if (!isset($_POST['cmdAction'])){
    $action = 'demanderConnexion';
} else {     
    // par défaut
    $action = $_POST['cmdAction'];
} 

switch ($action) {
    case 'demanderConnexion': {
        require 'vue/v_connexion.php';
        break;
    } 
    case 'validerConnexion': { 
        // vérifier si l'utilisateur existe avec ce mot de passe 
        $utilisateur = $db->getUnMembre($_POST['txtLogin'], $_POST['hdMdp']);
        // si l'utilisateur n'existe pas
        if($utilisateur == null) {
            // positionner le message d'erreur $erreur
            $erreur = 'Identifiant ou mot de passe incorrect';
            // inclure la vue correspondant au formulaire d'authentification
            require 'vue/v_connexion.php';
        } else {
            // créer trois variables de session pour id utilisateur, nom et prénom
            $_SESSION['idUtilisateur'] = $utilisateur->idMembre;
            $_SESSION['nomUtilisateur'] = $utilisateur->nomMembre;
            $_SESSION['pnomUtilisateur'] = $utilisateur->prenomMembre;
            
            // redirection du navigateur vers la page d'accueil
            header('Location: index.php'); 
            exit;
        } 
        break;
    }
}
?> 