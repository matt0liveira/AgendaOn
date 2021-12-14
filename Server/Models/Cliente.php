<?php
    namespace Server\Models;
    //Class Cliente
    Class Cliente {
        private static $table = 'cliente';
        private static $idcliente;
        private static $nome;
        private static $email;
        private static $senha;
        private static $telefone;
        private static $foto;
        //Method constructor
        function __construct() {
            self::$idcliente = 0;
            self::$nome = '';
            self::$email = '';
            self::$senha = '';
            self::$foto = '';
        }
        

        /**
         * Get the value of idcliente
         */ 
        public static function getIdcliente()
        {
                return self::$idcliente;
        }

        /**
         * Set the value of idcliente
         *
         * @return  self
         */ 
        public static function setIdcliente($idcliente)
        {
                self::$idcliente = $idcliente;
        }

        /**
         * Get the value of nome
         */ 
        public static function getNome()
        {
                return self::$nome;
        }

        /**
         * Set the value of nome
         *
         * @return  self
         */ 
        public static function setNome($nome)
        {
                self::$nome = $nome;
        }

        /**
         * Get the value of email
         */ 
        public static function getEmail()
        {
                return self::$email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public static function setEmail($email)
        {
                self::$email = $email;
        }

        /**
         * Get the value of senha
         */ 
        public static function getSenha()
        {
                return self::$senha;
        }

        /**
         * Set the value of senha
         *
         * @return  self
         */ 
        public static function setSenha($senha)
        {
                self::$senha = $senha;
        }
        /**
         * Get the value of telefone
         */ 
        public static function getTelefone()
        {
                return self::$telefone;
        }

        /**
         * Set the value of telefone
         *
         * @return  self
         */ 
        public static function setTelefone($telefone)
        {
                self::$telefone = $telefone;
        }

        /**
         * Get the value of foto
         */ 
        public static function getFoto()
        {
                return self::$foto;
        }

        /**
         * Set the value of foto
         *
         * @return  self
         */ 
        public static function setFoto($foto)
        {
                self::$foto = $foto;
        }
        //Method insert
        public static function cadastrar() {
            $conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
            $sql = "INSERT INTO ".self::$table." VALUES(0,:nome, :email, :senha, :telefone, :foto)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome',self::$nome);
            $stmt->bindParam(':email',self::$email);
            $stmt->bindParam(':senha',self::$senha);
            $stmt->bindParam(':telefone',self::$telefone);
            $stmt->bindParam(':foto', self::$foto);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
        //Method login
        public static function logar() {
            $conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
            $sql = "SELECT idcliente, senha FROM ".self::$table." WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email',self::$email);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $data;
        }
        //Method validationLogin
        public static function validationLogin() {
            $conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
            $sql = "SELECT COUNT(*) 'qtd' FROM dispositivo WHERE fkcliente = :idcliente AND token = :token AND now() <= DATE_ADD(datacriacao, INTERVAL 30 DAY)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idcliente', $_COOKIE['idcliente']);
            $stmt->bindParam(':token', $_COOKIE['token']);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($data['qtd'] == 1) {
                return true;
            } else {
                return false;
            }
        }
        //Method logout
        public static function logout() {
            $conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
            $sql = "DELETE FROM dispositivo WHERE fkcliente = :fkcliente AND token = :token";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":fkcliente", $_COOKIE['idcliente']);
            $stmt->bindParam(":token", $_COOKIE['token']);
            $stmt->execute();
            setcookie("idcliente", 0, time() - 1);
            setcookie("token", 0, time() - 1);
        }
        //Method select
        public static function listar() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT * FROM ".self::$table." WHERE idcliente = :idcliente";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idcliente', $_COOKIE['idcliente']);
			$stmt->execute();
			$data = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $data;
        }
		//Getting foto of cliente
		public static function gettingFoto() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT foto FROM ".self::$table." WHERE idcliente = :idcliente";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idcliente', $_COOKIE['idcliente']);
			$stmt->execute();
			$dataFoto = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $dataFoto;
		}
		//Method update
		public static function editar() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "UPDATE ".self::$table." SET nome = :nome, telefone = :telefone, foto = :foto WHERE idcliente = :idcliente";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':nome', self::$nome);
			$stmt->bindParam(':telefone', self::$telefone);
			$stmt->bindParam(':foto', self::$foto);
			$stmt->bindParam(':idcliente', $_COOKIE['idcliente']);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		}
		//Method update without 'foto'
		public static function editarSemfoto() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "UPDATE ".self::$table." SET nome = :nome, telefone = :telefone WHERE idcliente = :idcliente";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':nome', self::$nome);
			$stmt->bindParam(':telefone', self::$telefone);
			$stmt->bindParam(':idcliente', $_COOKIE['idcliente']);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		}
    }
?>