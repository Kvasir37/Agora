<?php
	// si le paramètre action n'est pas positionné alors
	//		si aucun bouton "action" n'a été envoyé alors par défaut on affiche les genres
	//		sinon l'action est celle indiquée par le bouton

	if (!isset($_POST['cmdAction'])) {
		 $action = 'afficherJeu';
	}
	else {
		// par défaut
		$action = $_POST['cmdAction'];
	}

	$idJeuModif = -1;		// positionné si demande de modification
	$notification = 'rien';	// pour notifier la mise à jour dans la vue

	// selon l'action demandée on réalise l'action 
	switch($action) {

		case 'ajouterNouveauJeu': {		
			if (!empty($_POST['txtNomJeu'])) {
				$idJeuNotif = $db->ajouterJeux($_POST['txtNomJeu'], $_POST['txtPrixJeu'], $_POST['txtPegiJeu'], $_POST['txtPlatJeu'], $_POST['txtMarqueJeu'], $_POST['txtGenreJeu'], $_POST['txtDateParutionJeu']);
				// $idJeuNotif est l'idJeu du Jeu ajouté
				$notification = 'Ajouté';	// sert à afficher l'ajout réalisé dans la vue
			}
		  break;
		}

		case 'demanderModifierJeu': {
			$idJeuModif = $_POST['txtRefJeu']; // sert à créer un formulaire de modification pour ce Jeu
			break;
		}
			
		case 'validerModifierJeu': {
			$db->modifierJeux($_POST['txtRefJeu'], $_POST['txtNomJeu'],$_POST['txtPrixJeu'], $_POST['txtPegiJeu'], $_POST['txtPlatJeu'], $_POST['txtMarqueJeu'], $_POST['txtGenreJeu'], $_POST['txtDateParutionJeu']); 
			$idJeuNotif = $_POST['txtRefJeu']; // $idJeuNotif est l'idJeu du Jeu modifié
			$notification = 'Modifié';  // sert à afficher la modification réalisée dans la vue
			break;
		}

		case 'supprimerJeu': {
			$idJeu = $_POST['txtRefJeu'];
			$db-> supprimerJeux($_POST['txtRefJeu']);//  à compléter, voir quelle méthode appeler dans le modèle
			break;
		}
	}
		
	// l' affichage des Jeus se fait dans tous les cas	
	$tbJeux  = $db->getLesJeux();		
	require 'vue/v_lesJeux.php';
	?>