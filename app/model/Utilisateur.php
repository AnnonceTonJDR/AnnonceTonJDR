<?php
include_once 'BD.php';
require_once 'BD_lecture.php';

class Utilisateurs
{
    private $bdd;
    private $utilisateurs;

    public function inscrireUtilisateur($pseudo, $mail, $motDePasse, $nom, $prenom, $dateNaissance)
    {
        $resp = BD::connexionBDD()->query("SELECT MAX(id) AS maxId FROM Utilisateur")->fetch()['maxId'];
        $id = ($resp != null ? $resp : 0) + 1;
        $salt = md5(microtime(TRUE) * 100000);
        $mdpHash = hash('sha512', $motDePasse . $salt);
        //Ajout des infos de base
        BD::connexionBDD()->exec("INSERT INTO Utilisateur(id, nom, prenom, pseudo, dateInscription) 
                                              VALUES($id , '$nom' , '$prenom', '$pseudo', NOW());");  //requete pour l'insertion d'un utilisateur
        //Ajout des données sensibles
        BD::connexionBDD()->exec("INSERT INTO UtilisateurPrivate(id, dateNaissance, mail, motDePasse, sel) 
                                              VALUES($id, '$dateNaissance', '$mail', '$mdpHash','$salt');");
        $destinataire = $_POST['mail'];
        $sujet = "Activer votre compte";
        $entete = "From: inscription@annoncetonjdr.fr";

        //Le lien d'activation est composé du pseudo(log) et de la clé(cle)
        $message = 'Bienvenue sur annonceTonJDR,
    		
			Pour activer votre compte, veuillez cliquer sur le lien ci dessous
			ou le copier/coller dans votre navigateur internet.
			    		
			http://lucasoms.alwaysdata.net/app/controller/connection/validateRegister.php?log=' . urlencode($pseudo) . '&cle=' . urlencode($salt) . '
			    		
			    		
			---------------
			Ceci est un mail automatique, Merci de ne pas y répondre.';

        mail($destinataire, $sujet, $message, $entete); // Envoi du mail

    }

    public function __construct()
    {
        $this->bdd = BD::connexionBDD();
        $this->utilisateurs = array();

        $reqSelectUser = $this->bdd->prepare("SELECT *,DATE_FORMAT(dateInscription, '%d %m %Y') AS dateInsc FROM Utilisateur JOIN UtilisateurPrivate ON Utilisateur.id=UtilisateurPrivate.id;");
        $reqSelectUser->execute();
        $res = $reqSelectUser->fetchall();
        foreach ($res as $user) {
            $this->utilisateurs[] = new Utilisateur($user['id'], $user['pseudo'], $user['mail'], $user['motDePasse'], $user['etat'], $user['sel'], $user['nom'], $user['prenom'], $user['dateInsc']);
        }
    }

    public function getUtilisateurs()
    {
        return $this->utilisateurs;
    }

    public function getByIdentifiantConnexion($identifiant)
    {
        foreach ($this->utilisateurs as $user)
            if ($user->getMail() == $identifiant || $user->getPseudo() == $identifiant)
                return $user;
        return null;
    }

    public function getById($id)
    {
        foreach ($this->utilisateurs as $user)
            if ($user->getId() == $id)
                return $user;
        return null;
    }

    public function getByPseudo($pseudo)
    {
        foreach ($this->utilisateurs as $user)
            if ($user->getPseudo() == $pseudo)
                return $user;
        return null;
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

    public function getByMail($mail)
    {
        foreach ($this->utilisateurs as $user)
            if ($user->getMail() == $mail)
                return $user;
        return false;
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
        $reqValider = BD::connexionBDD()->exec("UPDATE UtilisateurPrivate SET etat = 1 WHERE id = $this->id;");
        if ($reqValider != 0) {
            $this->etat = 1;
            return true;
        } else {
            return false;
        }
    }

    public function changerMotDePasse($motDePasse)
    {
        $mdpHash = hash('sha512', $motDePasse . $this->cle);
        if ($mdpHash == $this->motDePasse)
            return true;
        $reqModifPWD = BD::connexionBDD()->exec("UPDATE UtilisateurPrivate SET motDePasse = '$mdpHash' WHERE id = $this->id;");
        return $reqModifPWD != 0;
    }

    public function verifierMotDePasse($motDePasse)
    {
        //On vérifie si le mdp+sel de la DB correspond au mdp+sel entré
        $pass_hache = hash('sha512', $motDePasse . $this->cle);
        if ($pass_hache == $this->motDePasse)
            return true;
        return false;
    }
}