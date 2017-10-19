<?php
include_once 'BD.php';
require_once 'BD_lecture.php';

class Utilisateurs
{
    private $bdd;
    private $utilisateurs;

    public function inscrireUtilisateur($pseudo, $mail, $motDePasse, $nom, $prenom)
    {
        $cle = md5(microtime(TRUE) * 100000);
        $mdpHash = sha1($motDePasse);
        $reqInsertionUtilisateur = BD::connexionBDD()->exec("INSERT INTO JOUEUR(nom, prenom, pseudo, motDePasse, mail, etat, dateInscription, cle) 
                                              VALUES('$nom' , '$prenom', '$pseudo', '$mdpHash', '$mail', 0, NOW(), '$cle');");  //requete pour l'insertion d'un utilisateur
        $destinataire = $_POST['mail'];
        $sujet = "Activer votre compte";
        $entete = "From: inscription@annoncetonjdr.fr";

        //Le lien d'activation est composé du pseudo(log) et de la clé(cle)
        $message = 'Bienvenue sur annonceTonJDR,
    		
			Pour activer votre compte, veuillez cliquer sur le lien ci dessous
			ou le copier/coller dans votre navigateur internet.
			    		
			http://lucasoms.alwaysdata.net/controler/connexion/validerInscription.php?log=' . urlencode($pseudo) . '&cle=' . urlencode($cle) . '
			    		
			    		
			---------------
			Ceci est un mail automatique, Merci de ne pas y répondre.';

        mail($destinataire, $sujet, $message, $entete); // Envoi du mail

    }

    public function __construct()
    {
        $this->bdd = BD::connexionBDD();
        $this->utilisateurs = array();

        $reqSelectUser = $this->bdd->prepare("SELECT *,DATE_FORMAT(dateInscription, '%d %m %Y') AS dateInsc FROM JOUEUR;");
        $reqSelectUser->execute();
        $res = $reqSelectUser->fetchall();
        foreach ($res as $user) {
            $this->utilisateurs[] = new Utilisateur($user['id'], $user['pseudo'], $user['mail'], $user['motDePasse'], $user['etat'], $user['cle'], $user['nom'], $user['prenom'], $user['dateInsc']);
        }
    }

    public function getUtilisateurs()
    {
        return $this->utilisateurs;
    }

    public function changerProfil($pseudo, $mail, $motDePasse, $id)
    {
        $sel = md5(microtime(TRUE) * 1000000);
        $reqModifUtilisateur = BD::connexionBDD()->prepare("UPDATE Administrateur SET motDePasse = :mdp, sel = :sel, pseudo = :pseudo, mail = :mail  WHERE idAdministrateur = :id;",
            array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));  //requete pour l'insertion d'un utilisateur
        $mdpHash = $motDePasse . $sel;
        $reqModifUtilisateur->execute(array('mdp' => sha1($mdpHash), 'sel' => $sel, 'pseudo' => $pseudo, 'mail' => $mail, 'id' => $id));
        $this->getById($id)->modifierProfil($pseudo, $mail, sha1($mdpHash), $sel);
    }

    public function getByIdentifiantConnexion($identifiant)
    {
        foreach ($this->utilisateurs as $user)
            if ($user->getMail() == $identifiant || $user->getPseudo() == $identifiant)
                return $user;
    }

    public function getById($id)
    {
        foreach ($this->utilisateurs as $user)
            if ($user->getId() == $id)
                return $user;
    }

    public function getByPseudo($pseudo)
    {
        foreach ($this->utilisateurs as $user)
            if ($user->getPseudo() == $pseudo)
                return $user;
    }

    public function pseudoExisteDeja($pseudo)
    {
        foreach ($this->utilisateurs as $user)
            if ($user->getPseudo() == $pseudo)
                return true;
        return false;
    }

    public function mailExisteDeja($mail)
    {
        foreach ($this->utilisateurs as $user)
            if ($user->getMail() == $mail)
                return true;
        return false;
    }

    public function supprimerUser($id)
    {
        $reqSupressionUtilisateur = BD::connexionBDD()->exec("UPDATE Administrateur SET etat = 2 WHERE idAdministrateur = $id;");  //requete pour l'insertion d'un utilisateur
        if ($reqSupressionUtilisateur > 0) {
            $admin = $this->getById($id);
            $key = array_search($admin, $this->administrateurs);
            unset($this->administrateurs[$key]);
        }
    }

    public function getUtilisateursLike($search)
    {
        foreach ($this->utilisateurs as $user)
            if (strpos(strtolower($user->getNom()), $search) !== false
                || strpos(strtolower($user->getPrenom()), $search) !== false
                || strpos(strtolower($user->getPseudo()), $search) !== false
            )
                $users[] = $user;
        return $users;
    }
}

class Utilisateur
{
    private $id;
    private $pseudo;
    private $mail;
    private $motDePasse;
    private $etat;
    private $cle;
    private $prenom;
    private $nom;
    private $dateInscription;

    public function __construct($id, $pseudo, $mail, $motDePasse, $etat, $cle, $nom, $prenom, $dateInscription)
    {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->mail = $mail;
        $this->motDePasse = $motDePasse;
        $this->etat = $etat;
        $this->cle = $cle;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateInscription = $dateInscription;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getDateInscription()
    {
        return $this->dateInscription;
    }

    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    public function getEtat()
    {
        return $this->etat;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getCle()
    {
        return $this->cle;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function validerInscription()
    {
        $reqValider = BD::connexionBDD()->exec("UPDATE JOUEUR SET etat = 1 WHERE id = $this->id;");
        if ($reqValider != 0) {
            $this->etat = 1;
            return true;
        } else {
            return false;
        }
    }

    public function modifierProfil($pseudo, $mail, $motDePasse, $sel)
    {
        $this->pseudo = $pseudo;
        $this->mail = $mail;
        $this->motDePasse = $motDePasse;
        $this->sel = $sel;
    }

    public function changerMotDePasse($motDePasse)
    {
        $mdpHash = sha1($motDePasse);
        if ($mdpHash == $this->motDePasse)
            return true;
        $reqModifPWD = BD::connexionBDD()->exec("UPDATE JOUEUR SET motDePasse = '$mdpHash' WHERE id = $this->id;");
        if ($reqModifPWD != 0)
            return true;
        else
            return false;
    }

    public function verifierMotDePasse($motDePasse)
    {
        $pass_hache = sha1($motDePasse);
        if ($pass_hache == $this->motDePasse)
            return true;
    }

    public function estProprietaire($idVille): bool
    {
        return !is_bool(BD_lecture::connexionBDD_lecture()->query("SELECT idVille FROM POSSEDE WHERE idJoueur=" . $this->id . " AND idVille=" . $idVille)->fetch());
    }

}

?>