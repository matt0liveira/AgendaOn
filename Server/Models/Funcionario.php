<?php
    namespace Server\Models;
    class Funcionario {
        private static $table = 'funcionario';
        private static $idfuncionario;
        private static $nome;
        private static $telefone;
        private static $dtNascimento;
		private static $especializacao;
        private static $foto;
        //Method Constructor
        function __construct() {
            self::$idfuncionario = 0;
            self::$nome = '';
            self::$telefone = '';
            self::$dtNascimento = '';
            self::$foto = '';
        }

        /**
         * Get the value of idfuncionario
         */ 
        public static function getIdfuncionario()
        {
                return self::$idfuncionario;
        }

        /**
         * Set the value of idfuncionario
         *
         * @return  self
         */ 
        public static function setIdfuncionario($idfuncionario)
        {
                self::$idfuncionario = $idfuncionario;
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
         * Get the value of dtNascimento
         */ 
        public static function getDtNascimento()
        {
                return self::$dtNascimento;
        }

        /**
         * Set the value of dtNascimento
         *
         * @return  self
         */ 
        public static function setDtNascimento($dtNascimento)
        {
                self::$dtNascimento = $dtNascimento;
        }

        /**
         * Get the value of foto
         */ 
        public static function getEspecializacao()
        {
                return self::$especializacao;
        }

		 /**
         * Set the value of dtNascimento
         *
         * @return  self
         */ 
        public static function setEspecializacao($especializacao)
        {
                self::$especializacao = $especializacao;
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
        public static function cadastrar(){
            $conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
            $sql = 'INSERT INTO '.self::$table.' VALUES(0,:nome,:telefone,:dtNascimento,:especializacao,:foto)';
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome',self::$nome);
            $stmt->bindParam(':telefone',self::$telefone);
            $stmt->bindParam(':dtNascimento',self::$dtNascimento);
			$stmt->bindParam(':especializacao', self::$especializacao);
            $stmt->bindParam(':foto',self::$foto);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return true;   
            } else{
                return false;
            }
        }
        //Method select
        public static function listar() {
            $conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
            $sql = "SELECT * FROM ".self::$table;
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $list = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $list;  
        }
		//Method that get foto
		public static function gettingFoto() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT foto FROM ".self::$table." WHERE idfuncionario = :idfuncionario";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idfuncionario', self::$idfuncionario);
			$stmt->execute();
			$dataFoto = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $dataFoto;
		}
        //Method update
        public static function editar() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "UPDATE ".self::$table." SET nome = :nome, telefone = :telefone, dtNascimento = :dtNascimento, especializacao = :especializacao, foto = :foto WHERE idfuncionario = :idfuncionario";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idfuncionario', self::$idfuncionario);
			$stmt->bindParam(':nome', self::$nome);
			$stmt->bindParam(':telefone', self::$telefone);
			$stmt->bindParam(':dtNascimento', self::$dtNascimento);
			$stmt->bindParam(':especializacao', self::$especializacao);
			$stmt->bindParam(':foto', self::$foto);
			$stmt->execute();
			if($stmt->rowCount() > 0){
				return true;
			} else{
				return false;
			}
        }
		//Method update without 'foto'
		public static function editarSemfoto() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "UPDATE ".self::$table." SET nome = :nome,telefone = :telefone,dtNascimento = :dtNascimento, especializacao = :especializacao WHERE idfuncionario = :idfuncionario";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':nome', self::$nome);
			$stmt->bindParam(':telefone', self::$telefone);
			$stmt->bindParam(':dtNascimento', self::$dtNascimento);
			$stmt->bindParam(':especializacao', self::$especializacao);
			$stmt->bindParam(':idfuncionario', self::$idfuncionario);
			$stmt->execute();
			if($stmt->rowCount() > 0){
					return true;
			} else{
					return false;
			}
        }
        //Method for to verify if the funcionário exists
        public static function checkSql(){
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$checkSql = "SELECT COUNT(*) 'qtd', foto FROM ".self::$table." WHERE idfuncionario = :idfuncionario";
			$stmt = $conn->prepare($checkSql);
			$stmt->bindParam(':idfuncionario', self::$idfuncionario);
			$stmt->execute();
			$dataCheck = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $dataCheck;
        }
        //Method delete
        public static function excluir(){
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "DELETE FROM ".self::$table." WHERE idfuncionario = :idfuncionario";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idfuncionario',self::$idfuncionario);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
        }
		//Method for to get data of funcionário
		public static function getDados() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT COUNT(*) 'qtd', funcionario.* FROM ".self::$table. " WHERE idfuncionario = :idfuncionario";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idfuncionario',self::$idfuncionario);
			$stmt->execute();
			$data = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $data;
		}
		//Method of search funcionário
		public static function buscar() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT * FROM ".self::$table." WHERE nome LIKE :nome";
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':nome', '%'.self::$nome.'%');
			$stmt->execute();
			$resultSearch = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $resultSearch;
		}
		//Method of listing funcionário on the pag serviço
		public static function listing() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT idfuncionario, nome FROM ".self::$table;
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$returnList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $returnList;
		}
    }
?>