﻿<?php
/**
 * paramètres de configuration de l'application AgoraBo
 * 
 * @package default
 * @author md
 * @version    1.0
 */

// gestion d'erreur 
ini_set('error_reporting', E_ALL);  	// en phase de développement
//ini_set('error_reporting', 0);  		// en phase de production 

// constantes pour l'accès à la base de données
define('DB_SERVER', 'localhost');	// serveur MySql
define('DB_DATABASE', 'agora');		// nom de la base de données
define('DB_USER', 'userAgoraBo');			// nom d'utilisateur userAgoraBo
define('DB_PWD', 'FM4ILxgMhhoOKFv9');              	// mot de passe FM4ILxgMhhoOKFv9
define('DSN','mysql:dbname='.DB_DATABASE.';host='.DB_SERVER);
?>