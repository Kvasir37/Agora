<?php

/**
 *  AGORA
 * 	©  Logma, 2019
 * @package default
 * @author MD
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 * 
 * Classe d'accès aux données. 
 * Utilise les services de la classe PDO
 * pour l'application AGORA
 * Les attributs sont tous statiques,
 * $monPdo de type PDO 
 * $monPdoJeux qui contiendra l'unique instance de la classe
 */
class PdoJeux {

    private static $monPdo;
    private static $monPdoJeux = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe
     */
    private function __construct() {
		// A) >>>>>>>>>>>>>>>   Connexion au serveur et à la base
		try {   
			// encodage
			$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''); 
			// Crée une instance (un objet) PDO qui représente une connexion à la base
			PdoJeux::$monPdo = new PDO(DSN,DB_USER,DB_PWD, $options);
			// configure l'attribut ATTR_ERRMODE pour définir le mode de rapport d'erreurs 
			// PDO::ERRMODE_EXCEPTION: émet une exception 
			PdoJeux::$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			// configure l'attribut ATTR_DEFAULT_FETCH_MODE pour définir le mode de récupération par défaut 
			// PDO::FETCH_OBJ: retourne un objet anonyme avec les noms de propriétés 
			//     qui correspondent aux noms des colonnes retournés dans le jeu de résultats
			PdoJeux::$monPdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		}
		catch (PDOException $e)	{	// $e est un objet de la classe PDOException, il expose la description du problème
			die('<section id="main-content"><section class="wrapper"><div class = "erreur">Erreur de connexion à la base de données !<p>'
				.$e->getmessage().'</p></div></section></section>');
		}
    }
	
    /**
     * Destructeur, supprime l'instance de PDO  
     */
    public function _destruct() {
        PdoJeux::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe
     * Appel : $instancePdoJeux = PdoJeux::getPdoJeux();
     * 
     * @return l'unique objet de la classe PdoJeux
     */
    public static function getPdoJeux() {
        if (PdoJeux::$monPdoJeux == null) {
            PdoJeux::$monPdoJeux = new PdoJeux();
        }
        return PdoJeux::$monPdoJeux;
    }

	//==============================================================================
	//
	//	METHODES POUR LA GESTION DES GENRES
	//
	//==============================================================================
	
    /**
     * Retourne tous les genres sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (Genre)
     */
    public function getLesGenres(): array {
  		$requete =  'SELECT idGenre as identifiant, libGenre as libelle 
						FROM genre 
						ORDER BY libGenre';
		try	{	 
			$resultat = PdoJeux::$monPdo->query($requete);
			$tbGenres  = $resultat->fetchAll();	
			return $tbGenres;		
		}
		catch (PDOException $e)	{  
			die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
		}
    }

	
	/**
	 * Ajoute un nouveau genre avec le libellé donné en paramètre
	 * 
	 * @param string $libGenre : le libelle du genre à ajouter
	 * @return int l'identifiant du genre crée
	 */
    public function ajouterGenre(string $libGenre): int {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO genre "
                    . "(idGenre, libGenre) "
                    . "VALUES (0, :unLibGenre) ");
            $requete_prepare->bindParam(':unLibGenre', $libGenre, PDO::PARAM_STR);
            $requete_prepare->execute();
			// récupérer l'identifiant crée
			return PdoJeux::$monPdo->lastInsertId(); 
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	
	
	 /**
     * Modifie le libellé du genre donné en paramètre
     * 
     * @param int $idGenre : l'identifiant du genre à modifier  
     * @param string $libGenre : le libellé modifié
     */
    public function modifierGenre(int $idGenre, string $libGenre): void {
        try {
            $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE genre "
                    . "SET libGenre = :unLibGenre "
                    . "WHERE genre.idGenre = :unIdGenre");
            $requete_prepare->bindParam(':unIdGenre', $idGenre, PDO::PARAM_INT);
            $requete_prepare->bindParam(':unLibGenre', $libGenre, PDO::PARAM_STR);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	
	
	/**
     * Supprime le genre donné en paramètre
     * 
     * @param int $idGenre :l'identifiant du genre à supprimer 
     */
    public function supprimerGenre(int $idGenre): void {
       try {
            $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM genre "
                    . "WHERE genre.idGenre = :unIdGenre");
            $requete_prepare->bindParam(':unIdGenre', $idGenre, PDO::PARAM_INT);
            $requete_prepare->execute();
        } catch (Exception $e) {
            die('<div class = "erreur">Erreur dans la requête !<p>'
				.$e->getmessage().'</p></div>');
        }
    }
	

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------Plateformes------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------
public function getLesPlateformes(): array {
    $requete =  'SELECT idPlateforme as identifiant, libPlateforme as libelle 
                  FROM plateforme 
                  ORDER BY libPlateforme';
  try	{	 
      $resultat = PdoJeux::$monPdo->query($requete);
      $tbPlateforme  = $resultat->fetchAll();	
      return $tbPlateforme;		
  }
  catch (PDOException $e)	{  
      die('<div class = "erreur">Erreur dans la requête !<p>'
          .$e->getmessage().'</p></div>');
  }
}



public function ajouterPlateforme(string $libPlateforme): int {
  try {
      $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO plateforme "
              . "(idPlateforme, libPlateforme) "
              . "VALUES (0, :unLibPlateforme) ");
      $requete_prepare->bindParam(':unLibPlateforme', $libPlateforme, PDO::PARAM_STR);
      $requete_prepare->execute();
      // récupérer l'identifiant crée
      return PdoJeux::$monPdo->lastInsertId(); 
  } catch (Exception $e) {
      die('<div class = "erreur">Erreur dans la requête !<p>'
          .$e->getmessage().'</p></div>');
  }
}


/**
* Modifie le libellé du genre donné en paramètre
* 
* @param int $idPlateforme: l'identifiant du genre à modifier  
* @param string $libPlateforme : le libellé modifié
*/
public function modifierPlateforme(int $idPlateforme, string $libPlateforme): void {
  try {
      $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE plateforme "
              . "SET libPlateforme = :unLibPlateforme "
              . "WHERE plateforme.idPlateforme = :unIdPlateforme");
      $requete_prepare->bindParam(':unIdPlateforme', $idPlateforme, PDO::PARAM_INT);
      $requete_prepare->bindParam(':unLibPlateforme', $libPlateforme, PDO::PARAM_STR);
      $requete_prepare->execute();
  } catch (Exception $e) {
      die('<div class = "erreur">Erreur dans la requête !<p>'
          .$e->getmessage().'</p></div>');
  }
}


/**
* Supprime le genre donné en paramètre
* 
* @param int $idPlateforme :l'identifiant du genre à supprimer 
*/
public function supprimerPlateforme(int $idPlateforme): void {
 try {
      $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM Plateforme "
              . "WHERE plateforme.idPlateforme = :unIdPlateforme");
      $requete_prepare->bindParam(':unIdPlateforme', $idPlateforme, PDO::PARAM_INT);
      $requete_prepare->execute();
  } catch (Exception $e) {
      die('<div class = "erreur">Erreur dans la requête !<p>'
          .$e->getmessage().'</p></div>');
  }
}



//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------Marques------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------
public function getLesMarques(): array {
    $requete =  'SELECT idMarque as identifiant, nomMarque as libelle 
                  FROM marque 
                  ORDER BY nomMarque';
  try	{	 
      $resultat = PdoJeux::$monPdo->query($requete);
      $tbMarque = $resultat->fetchAll();	
      return $tbMarque;		
  }
  catch (PDOException $e)	{  
      die('<div class = "erreur">Erreur dans la requête !<p>'
          .$e->getmessage().'</p></div>');
  }
}



public function ajouterMarque(string $nomMarque): int {
  try {
      $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO marque "
              . "(idMarque, nomMarque) "
              . "VALUES (0, :unNomMarque) ");
      $requete_prepare->bindParam(':unNomMarque', $nomMarque, PDO::PARAM_STR);
      $requete_prepare->execute();
      // récupérer l'identifiant crée
      return PdoJeux::$monPdo->lastInsertId(); 
  } catch (Exception $e) {
      die('<div class = "erreur">Erreur dans la requête !<p>'
          .$e->getmessage().'</p></div>');
  }
}


/**
* Modifie le libellé du genre donné en paramètre
* 
* @param int $idPlateforme: l'identifiant du genre à modifier  
* @param string $libPlateforme : le libellé modifié
*/
public function modifierMarque(int $idMarque, string $nomMarque): void {
  try {
      $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE marque "
              . "SET nomMarque = :unNomMarque "
              . "WHERE marque.idMarque = :unIdMarque");
      $requete_prepare->bindParam(':unIdMarque', $idMarque, PDO::PARAM_INT);
      $requete_prepare->bindParam(':unNomMarque', $nomMarque, PDO::PARAM_STR);
      $requete_prepare->execute();
  } catch (Exception $e) {
      die('<div class = "erreur">Erreur dans la requête !<p>'
          .$e->getmessage().'</p></div>');
  }
}


/**
* Supprime le genre donné en paramètre
* 
* @param int $idPlateforme :l'identifiant du genre à supprimer 
*/
public function supprimerMarque(int $idMarque): void {
 try {
      $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM marque "
              . "WHERE marque.idMarque = :unIdMarque");
      $requete_prepare->bindParam(':unIdMarque', $idMarque, PDO::PARAM_INT);
      $requete_prepare->execute();
  } catch (Exception $e) {
      die('<div class = "erreur">Erreur dans la requête !<p>'
          .$e->getmessage().'</p></div>');
  }
}

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------Jeux------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------------------------

public function getLesJeux(): array {
    $requete =  'SELECT refJeu, idPlateforme, idPegi, idGenre, idMarque, nom, prix, dateParution
                  FROM jeu_video 
                  ORDER BY nom';
  try	{	 
      $resultat = PdoJeux::$monPdo->query($requete);
      $tbJeux  = $resultat->fetchAll();	
      return $tbJeux;		
  }
  catch (PDOException $e)	{  
      die('<div class = "erreur">Erreur dans la requête !<p>'
          .$e->getmessage().'</p></div>');
  }
}

  /**
   * Ajoute un nouveau jeu avec le nom donné en paramètre
   * 
   * @param string $libJeu : le libelle du PEGI à ajouter
   * @return string l'identifiant du PEGI créé
   */
public function ajouterJeux(string $libJeu, int $prixJeu, int $idPegiJeu, int $idPlatJeu, int $idMarqueJeu, int $idGenreJeu, datetime $dateParutionJeu): string {
  try {
      $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO jeu_video "
              . "(refJeu, nom, prix, idPegi, idPlateforme, idMarque, idGenre, dateParution) "
              . "VALUES (0, :unLibJeu, :unPrixJeu, :unIdPegiJeu, :unIdPlatJeu, :unIdMarqueJeu, :unIdGenreJeu, :unDateParutionJeu) ");
      $requete_prepare->bindParam(':unLibJeu', $libJeu, PDO::PARAM_STR);
      $requete_prepare->bindParam(':unPrixJeu', $prixJeu, PDO::PARAM_INT);
      $requete_prepare->bindParam(':unIdPegiJeu', $idPegiJeu, PDO::PARAM_INT);
      $requete_prepare->bindParam(':unIdPlatJeu', $idPlatJeu, PDO::PARAM_INT);
      $requete_prepare->bindParam(':unIdMarqueJeu', $idMarqueJeu, PDO::PARAM_INT);
      $requete_prepare->bindParam(':unIdGenreJeu', $idGenreJeu, PDO::PARAM_INT);
      $requete_prepare->bindParam(':unDateParutionJeu', $dateParutionJeu, PDO::PARAM_STR);
      $requete_prepare->execute();
      // récupérer l'identifiant crée
      return PdoJeux::$monPdo->lastInsertId(); 
  } catch (Exception $e) {
      die('<div class = "erreur">Erreur dans la requête !<p>'
          .$e->getmessage().'</p></div>');
  }
}


/**
* Modifie le libellé du jeu donné en paramètre
* 
* @param string $refJeu
* @param string $libJeu
*/
public function modifierJeux(string $refJeu, string $libJeu, int $prixJeu, int $idPegiJeu, int $idPlatJeu, int $idMarqueJeu, int $idGenreJeu, datetime $dateParutionJeu): void {
    try {
        $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE jeu_video "
            . "SET refJeu = :unRefJeu, nom = :unLibJeu, prix = :unPrix, idPegi = :unIdPegiJeu, idPlateforme = :unIdPlatJeu, idMarque = :unIdMarqueJeu, idGenre = :unIdGenreJeu, dateParution = :unDateParutionJeu"
            . "WHERE jeu_video.refJeu = :unRefJeu");
        $requete_prepare->bindParam(':unRefJeu', $refJeu, PDO::PARAM_STR);
        $requete_prepare->bindParam(':unLibJeu', $libJeu, PDO::PARAM_STR);
        $requete_prepare->bindParam(':unPrixJeu', $prixJeu, PDO::PARAM_INT);
        $requete_prepare->bindParam(':unIdPegiJeu', $idPegiJeu, PDO::PARAM_INT);
        $requete_prepare->bindParam(':unIdPlatJeu', $idPlatJeu, PDO::PARAM_INT);
        $requete_prepare->bindParam(':unIdMarqueJeu', $idMarqueJeu, PDO::PARAM_INT);
        $requete_prepare->bindParam(':unIdGenreJeu', $idGenreJeu, PDO::PARAM_INT);
        $requete_prepare->bindParam(':unDateParutionJeu', $dateParutionJeu, PDO::PARAM_STR);
        $requete_prepare->execute();
    }
    catch (Exception $e) {
        die('<div class = "erreur">Erreur dans la requête !<p>'
          .$e->getmessage().'</p></div>');
    }
}


/**
* Supprime le genre donné en paramètre
* 
* @param string $refJeu
*/
public function supprimerJeux(string $refJeu): void {
 try {
      $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM jeu_video"
              . "WHERE jeu_video.refJeu = :unRefJeu");
      $requete_prepare->bindParam(':unRefJeu', $refJeu, PDO::PARAM_STR);
      $requete_prepare->execute();
  } catch (Exception $e) {
      die('<div class = "erreur">Erreur dans la requête !<p>'
          .$e->getmessage().'</p></div>');
  }
}

		//==============================================================================
	//
	//	METHODES POUR LA GESTION DES PEGIS
	//
	//==============================================================================
	
    /**
     * Retourne tous les PEGIS sous forme d'un tableau d'objets 
     * 
     * @return array le tableau d'objets  (PEGI)
     */
    public function getLesPegis(): array {
        $requete =  'SELECT idPegi as identifiant, descPegi as libelle, ageLimite as age
                      FROM pegi 
                      ORDER BY idPegi';
      try	{	 
          $resultat = PdoJeux::$monPdo->query($requete);
          $tbPegis  = $resultat->fetchAll();	
          // cette methode retourne un oblhet de type tableau qui contient l'ensemble des enregistrements repondant à la requete
          return $tbPegis;		
      }
      catch (PDOException $e)	{  
          die('<div class = "erreur">Erreur dans la requête !<p>'
              .$e->getmessage().'</p></div>');
      }
  }

  
  /**
   * Ajoute un nouveau PEGI avec le libellé donné en paramètre
   * 
   * @param string $libPegi : le libelle du PEGI à ajouter
   * @return int l'identifiant du PEGI créé
   */
  public function ajouterPegi(string $libPegi, string $agePegi): int {
      try {
          $requete_prepare = PdoJeux::$monPdo->prepare("INSERT INTO pegi "
                  . "(idPegi, ageLimite, descPegi) "
                  . "VALUES (0, :unAgePegi, :unLibPegi) ");
          $requete_prepare->bindParam(':unAgePegi', $agePegi, PDO::PARAM_INT);
          $requete_prepare->bindParam(':unLibPegi', $libPegi, PDO::PARAM_STR);
          $requete_prepare->execute();
          // cette méthode renvoie l'ID généré lors de l'insersion
          return PdoJeux::$monPdo->lastInsertId(); 
      } catch (Exception $e) {
          die('<div class = "erreur">Erreur dans la requête !<p>'
              .$e->getmessage().'</p></div>');
      }
  }
  
  
   /**
   * Modifie le libellé du Pegi donné en paramètre
   * 
   * @param int $idPegi : l'identifiant du Pegi à modifier  
   * @param string $libPegi : le libellé modifié
   */
  public function modifierPegi(int $idPegi, string $libPegi, string $agePegi): void {
      try {
          $requete_prepare = PdoJeux::$monPdo->prepare("UPDATE pegi "
                  . "SET descPegi = :unLibPegi, ageLimite = :unAgePegi "
                  . "WHERE pegi.idPegi = :unIdPegi");
          $requete_prepare->bindParam(':unIdPegi', $idPegi, PDO::PARAM_INT);
          $requete_prepare->bindParam(':unLibPegi', $libPegi, PDO::PARAM_STR);
          $requete_prepare->bindParam(':unAgePegi', $agePegi, PDO::PARAM_INT);
          $requete_prepare->execute();
          //cette méthode ne retourne rien et modifie juste le libellé du Pegi dont l'identififant et $idMarque
      } catch (Exception $e) {
          die('<div class = "erreur">Erreur dans la requête !<p>'
              .$e->getmessage().'</p></div>');
      }
  }
  
  
  /**
   * Supprime le PEGI donné en paramètre
   * 
   * @param int $idPegi :l'identifiant du PEGI à supprimer 
   */
  public function supprimerPegi(int $idPegi): void {
     try {
          $requete_prepare = PdoJeux::$monPdo->prepare("DELETE FROM pegi "
                  . "WHERE pegi.idPegi = :unIdPegi");
          $requete_prepare->bindParam(':unIdPegi', $idPegi, PDO::PARAM_INT);
          $requete_prepare->execute();
          // cette methode ne retourne rien, et supprime juste l'enregistrement dont l'ID est égal à $idMarque
      } catch (Exception $e) {
          die('<div class = "erreur">Erreur dans la requête !<p>'
              .$e->getmessage().'</p></div>');
      }
  }

    //==============================================================================
    //
    // METHODES POUR LA GESTION DES MEMBRES
    //
    //==============================================================================
    /**
    * Retourne l'identifiant, le nom et le prénom de l'utilisateur correspondant au compte et mdp
    *
    * @param string $compte le compte de l'utilisateur
    * @param string $mdp le mot de passe de l'utilisateur
    * @return object l'objet ou null si ce membre n'existe pas
    */

    public function getUnMembre(string $loginMembre, string $mdpMembre): ?object {
        try {
        // préparer la requête
            $requete_prepare = PdoJeux::$monPdo->prepare(
                'SELECT idMembre, prenomMembre, nomMembre, mdpMembre, selMembre 
                FROM membre 
                WHERE loginMembre = :unLoginMembre');
        
        // associer les valeurs aux paramètres
            $requete_prepare->bindParam(':unLoginMembre', $loginMembre, PDO::PARAM_STR);
        
        // exécuter la requête
            $requete_prepare->execute();

        // récupérer l'objet
            if ($utilisateur = $requete_prepare->fetch()) {
        
        // vérifier le mot de passe
        // le mot de passe transmis par le formulaire est le hash du mot de passe saisi
        // le mot de passe enregistré dans la base doit correspondre au hash du (hash transmis concaténé au sel)
                $mdpHash = hash('SHA512', $mdpMembre . $utilisateur->selMembre);
                if($mdpHash == $utilisateur->mdpMembre) {
                    return $utilisateur;
                }
             
            else {
                return NULL;
            }
        }
        }
        catch (PDOException $e) {
        die('<div class = "erreur">Erreur dans la requête !<p>'
        .$e->getmessage().'</p></div>');
        }
    }

/**
* Retourne tous les genres sous forme d'un tableau d'objets
* avec également le nombre de jeux de ce genre
*
* @return le tableau d'objets (Genre)
*/
public function getLesGenresComplet() {
    $requete = 'SELECT G.idGenre as identifiant, G.libGenre as libelle, G.idSpecialiste AS
   idSpecialiste, CONCAT(P.prenomMembre, " ", P.nomMembre) AS nomSpecialiste,
    (SELECT COUNT(refJeu) FROM jeu_video AS J WHERE J.idGenre = G.idGenre) AS nbJeux
    FROM genre AS G
    LEFT OUTER JOIN membre AS P ON G.idSpecialiste = P.idMembre
    ORDER BY G.libGenre';
    try {
    $resultat = PdoJeux::$monPdo->query($requete);
    $tbGenres = $resultat->fetchAll();
    return $tbGenres;
    }
    catch (PDOException $e) {
    die('<div class = "erreur">Erreur dans la requête !<p>'
    .$e->getmessage().'</p></div>');
    }
   }
   /**
   * Retourne l'identifiant et le nom complet de toutes les personnes sous forme d'un tableau d'objets
   *
   * @return le tableau d'objets
   */
   public function getLesPersonnes() {
    $requete = 'SELECT idMembre as identifiant, CONCAT(prenomMembre;, " ", nomMembre) AS
   libelle
    FROM personne
    ORDER BY nomMembre';
   try {
    $resultat = PdoJeux::$monPdo->query($requete);
    $tbPersonnes = $resultat->fetchAll();
    return $tbPersonnes;
   }
   catch (PDOException $e) {
    die('<div class = "erreur">Erreur dans la requête !<p>'
    .$e->getmessage().'</p></div>');
   }
    }
   
}
?>
