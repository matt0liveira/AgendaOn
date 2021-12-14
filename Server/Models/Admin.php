<?php
    namespace Server\Models;
    // require_once "Conexao.php";
    //Class admin
    Class Admin{
        private static $table = 'admin';
        private static $idadmin;
        private static $email;
        private static $senha;
        //Method constructor
        function __construct(){
            self::$idadmin = 0;
            self::$email = '';
            self::$senha = '';
        }
        //Encapsulation
        /**
         * Get the value of idadmin
         */ 
        public static function getIdadmin()
        {
                return self::$idadmin;
        }

        /**
         * Set the value of idadmin
         *
         * @return  self
         */ 
        public static function setIdadmin($idadmin)
        {
                self::$idadmin = $idadmin;
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
        //Method logar
        public static function logar(){
            $connPDO = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
            $sql = "SELECT idadmin, senha FROM ".self::$table." WHERE email = :email";
            $stmt = $connPDO->prepare($sql);
            $stmt->bindParam(':email', self::$email);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $data = $stmt->fetch(\PDO::FETCH_ASSOC);
                return $data;
            } else{
                return false;
            }
        }
        //Method validateLogin
        public static function validationLogin(){
            $conn = new \PDO(DBDRIVE.":hostname=".DBHOST.";dbname=".DBNAME,DBUSER,DBPASS);
            $sql = "SELECT count(*) 'qtd' FROM dispositivo WHERE fkadmin = :idadmin AND token = :token AND now() <= DATE_ADD(datacriacao, INTERVAL 30 DAY)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idadmin', $_COOKIE['idadmin']);
            $stmt->bindParam(':token', $_COOKIE['token']);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            if($data['qtd'] == 1) {
                return true;
            } else{
                return false;
            }
        }
        //Method logout
        public static function logout(){
            $conn = new \PDO(DBDRIVE.":hostname=".DBHOST.";dbname=".DBNAME,DBUSER,DBPASS);
            $sql = "DELETE FROM dispositivo WHERE fkadmin = :fkadmin AND token = :token";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":fkadmin", $_COOKIE['idadmin']);
            $stmt->bindParam(":token", $_COOKIE['token']);
            $stmt->execute();
            setcookie("idadmin", 0, time() - 1);
            setcookie("token", 0, time() - 1);
        }
    }
?>