<?php
	class Utilisateur{
		private $id;
		private $nom;
		private $prenom;
		private $age;
		private $mail;
		private $mdp;

	
		public function __construct($nom, $prenom, $age, $mail, $mdp){
			require_once "base.php";
			if(!isset($_SESSION["existe"])){
				session_start();
				$_SESSION["existe"] = 1;
			}
			$this->baseCo = new Base();
			$this->base = $this->baseCo->connexionBase();
			if(!is_int((int)$age)){
				echo "l'age doit etre un entier";
				return;
			}
			$this->id = -1;
			$this->nom = $nom;
			$this->prenom = $prenom;
			$this->age = $age;
			$this->mail = $mail;
			$this->mdp = $mdp;
		}
		
		public function inscription(){
			$write = $this->base->prepare("INSERT INTO Utilisateur(prenom, nom, age, mail, mdp) VALUES(:prenom, :nom, :age, :mail, :mdp)");
			$write->execute(array("prenom" => $this->prenom, "nom" => $this->nom, "age" => $this->age, "mail" => $this->mail, "mdp" => $this->mdp));
		}

		public function connexion(){
			$read = $this->base->prepare("SELECT * FROM Utilisateur WHERE mail = :mail AND mdp = :mdp");
			$read->execute(array("mail" => $this->mail, "mdp" => $this->mdp));
			$compte = $read->fetch();
			//print_r($compte);

			if(isset($compte['Id']))
			{
				$this->id = $compte['Id'];
				$this->nom = $compte['nom'];
				$this->prenom = $compte['prenom'];
				$this->age = $compte['age'];
				$this->mail = $compte['mail'];
				$this->mdp = "";

				echo "bonjour ". $this->prenom;
			}
			else echo "erreur id/mdp";
		}
		

		
		public function getNom(){
			return $this->nom;
		}
		public function getPrenom(){
			return $this->prenom;
		}
		public function getAge(){
			return $this->age;
		}
		public function getmail(){
			return $this->mail;
		}

		public function setNom($nom){
			$this->nom = $nom;
		}
		public function setPrenom($prenom){
			 $this->prenom = $prenom;
		}
		public function setAge($age){
			if(!is_int((int)$age)){
				echo "l'age doit etre un entier";
				return;
			}
			$this->age = $age;
		}
		public function setmail(){
			$this->mail = $mail;
		}

		public function getmdp()
		{
			return $this->mdp;
		}

		public function setmdp($mdp)
		{ 
			$this->nom=$mdp; 
		}
		
		public function initSession(){
			$base = $this->base;
			unset($this->base);
			$_SESSION["utilisateur"] = serialize($this);
			$this->base = $base;
		}
		
		public static function lireSession(){
			if(!isset($_SESSION["existe"])){
				session_start();
				$_SESSION["existe"] = 1;
			}
			if(isset($_SESSION['utilisateur'])){
				return unserialize($_SESSION['utilisateur']);
			}else{
				echo "cette variable de session n'existe pas";
				return null;
			}
		}
		
	}

?>