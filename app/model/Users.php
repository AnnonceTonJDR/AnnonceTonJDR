<?php
include_once 'DB.php';
require_once 'DB_readOnly.php';

class Users
{
    public static function registerUser($pseudo, $mail, $pwd, $lastName, $firstName, $birthday)
    {
        $resp = DB::connectionDB()->query("SELECT MAX(id) AS maxId FROM Utilisateur")->fetch()['maxId'];
        $id = ($resp != null ? $resp : 0) + 1;
        $salt = md5(microtime(TRUE) * 100000);
        $mdpHash = hash('sha512', $pwd . $salt);
        //Ajout des infos de base
        DB::connectionDB()->exec("INSERT INTO Utilisateur(id, nom, prenom, pseudo, dateInscription) 
                                              VALUES($id , '$lastName' , '$firstName', '$pseudo', NOW());");  //requete pour l'insertion d'un utilisateur
        //Ajout des données sensibles
        DB::connectionDB()->exec("INSERT INTO UtilisateurPrivate(id, dateNaissance, mail, motDePasse, sel) 
                                              VALUES($id, '$birthday', '$mail', '$mdpHash','$salt');");
        $destinataire = $_POST['mail'];
        $sujet = "Activer votre compte";
        $entete = "From: inscription@annoncetonjdr.fr";

        //Le lien d'activation est composé du pseudo(log) et de la clé(cle)
        $message = 'Bienvenue sur Annonce Ton JDR,
    		
			Pour activer votre compte, veuillez cliquer sur le lien ci dessous
			ou le copier/coller dans votre navigateur internet.
			    		
			http://lucasoms.alwaysdata.net/app/controller/connection/validateRegister.php?log=' . urlencode($pseudo) . '&cle=' . urlencode($salt) . '
			    		
			    		
			---------------
			Ceci est un mail automatique, Merci de ne pas y répondre.';

        mail($destinataire, $sujet, $message, $entete); // Envoi du mail

    }

    public static function mailUser($idUser, $subject, $msg, $compactSubject)
    {
        $user = Users::getById($idUser);

        mail($user->getMail(), $subject, $msg, "From: " . $compactSubject . "inscription@annoncetonjdr.fr"); // Envoi du mail
    }

    public static function mailUsers(Array $idUsers, $subject, $msg, $compactSubject)
    {
        foreach ($idUsers as $idUser) {
            mail(Users::getById($idUser)->getMail(), $subject, $msg, "From: " . $compactSubject . "inscription@annoncetonjdr.fr"); // Envoi du mail
        }
    }

    //region =========================== Getters ===========================
    public static function getUsers(): array
    {
        $bdd = DB_readOnly::connectionDB_readOnly();
        $utilisateurs = array();
        $reqSelectUser = $bdd->prepare("SELECT *,DATE_FORMAT(dateInscription, '%d %m %Y') AS dateInsc FROM Utilisateur JOIN UtilisateurPrivate ON Utilisateur.id=UtilisateurPrivate.idJoueur;");
        $reqSelectUser->execute();
        $res = $reqSelectUser->fetchAll();
        foreach ($res as $user) {
            $utilisateurs[] = new User($user['id'], $user['pseudo'], $user['mail'], $user['motDePasse'],
                $user['etat'], $user['sel'], $user['nom'], $user['prenom'], $user['dateInsc']);
        }
        return $utilisateurs;
    }

    public static function getByConnectionId($identifiant)
    {
        $req = DB_readOnly::connectionDB_readOnly()->query("SELECT * FROM Utilisateur U JOIN UtilisateurPrivate P ON U.id = P.id " .
            "WHERE P.mail = \"" . $identifiant . "\" OR U.pseudo=\"" . $identifiant . "\"");
        $user = $req->fetch();
        if ($user != null)
            return new User($user['id'],
                $user['pseudo'],
                $user['mail'],
                $user['motDePasse'],
                $user['etat'],
                $user['sel'],
                $user['nom'],
                $user['prenom'],
                $user['dateInsc']);
        return null;
    }

    public static function getById($id)
    {
        $req = DB_readOnly::connectionDB_readOnly()->query("SELECT * FROM Utilisateur U JOIN UtilisateurPrivate P ON U.id = P.id " .
            "WHERE U.id=\"" . $id . "\"");
        $user = $req->fetch();
        if ($user != null)
            return new User($user['id'],
                $user['pseudo'],
                $user['mail'],
                $user['motDePasse'],
                $user['etat'],
                $user['sel'],
                $user['nom'],
                $user['prenom'],
                $user['dateInsc']);
        return null;
    }

    public static function getByPseudo($pseudo)
    {
        $req = DB_readOnly::connectionDB_readOnly()->query("SELECT * FROM Utilisateur U JOIN UtilisateurPrivate P ON U.id = P.id " .
            "WHERE U.pseudo=\"" . $pseudo . "\"");
        $user = $req->fetch();
        if ($user != null)
            return new User($user['id'],
                $user['pseudo'],
                $user['mail'],
                $user['motDePasse'],
                $user['etat'],
                $user['sel'],
                $user['nom'],
                $user['prenom'],
                $user['dateInsc']);
        return null;
    }

    public static function getByMail($mail)
    {
        $req = DB_readOnly::connectionDB_readOnly()->query("SELECT * FROM Utilisateur U JOIN UtilisateurPrivate P ON U.id = P.id " .
            "WHERE P.mail=\"" . $mail . "\"");
        $user = $req->fetch();
        if ($user != null)
            return new User($user['id'],
                $user['pseudo'],
                $user['mail'],
                $user['motDePasse'],
                $user['etat'],
                $user['sel'],
                $user['nom'],
                $user['prenom'],
                $user['dateInsc']);
        return null;
    }

    public static function pseudoAlreadyExists($pseudo): bool
    {
        return !is_bool(DB_readOnly::connectionDB_readOnly()
            ->query("SELECT id FROM Utilisateur WHERE pseudo=\"" . $pseudo . "\"")->fetch());
    }

    public static function mailAlreadyExists($mail): bool
    {
        return !is_bool(DB_readOnly::connectionDB_readOnly()
            ->query("SELECT id FROM UtilisateurPrivate WHERE mail=\"" . $mail . "\"")->fetch());
    }

    //endregion
}

class User
{
    private $id;
    private $pseudo;
    private $mail;
    private $pwd;
    private $state;
    private $salt;
    private $firstName;
    private $lastName;
    private $subscriptionDate;

    public function __construct($id, $pseudo, $mail, $pwd, $state, $salt, $lastName, $firstName, $subDate)
    {
        $this->id = $id;
        $this->pseudo = $pseudo;
        $this->mail = $mail;
        $this->pwd = $pwd;
        $this->state = $state;
        $this->salt = $salt;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->subscriptionDate = $subDate;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getSubscriptionDate()
    {
        return $this->subscriptionDate;
    }

    public function getPwd()
    {
        return $this->pwd;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function validateRegister()
    {
        $valdiateReq = DB::connectionDB()->exec("UPDATE UtilisateurPrivate SET etat = 1 WHERE id = $this->id;");
        if ($valdiateReq != 0) {
            $this->state = 1;
            return true;
        } else {
            return false;
        }
    }

    public function changePwd($pwd)
    {
        $pwd_hashed = hash('sha512', $pwd . $this->salt);
        if ($pwd_hashed == $this->pwd)
            return true;
        $modifPwdReq = DB::connectionDB()->exec("UPDATE UtilisateurPrivate SET motDePasse = '$pwd_hashed' WHERE id = $this->id;");
        return $modifPwdReq != 0;
    }

    public function verifyPwd($pwd)
    {
        //On vérifie si le mdp+sel de la DB correspond au mdp+sel entré
        $pass_hashed = hash('sha512', $pwd . $this->salt);
        if ($pass_hashed == $this->pwd)
            return true;
        return false;
    }
}