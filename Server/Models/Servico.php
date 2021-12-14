<?php
    namespace Server\Models;
    //Class Servico
    Class Servico {
		private static $table = 'servico';
        private static $idservico;
        private static $fkfuncionario;
        private static $nome;
        private static $descricao;
        private static $duracao;
        private static $preco;
        private static $foto;
        //Method constructor
        function __construct() {
            self::$idservico = 0;
            self::$fkfuncionario = '';
            self::$nome = '';
            self::$descricao = '';
            self::$duracao = '';
            self::$preco = '';
            self::$foto = '';
        }

        /**
         * Get the value of idservico
         */ 
        public static function getIdservico()
        {
                return self::$idservico;
        }

        /**
         * Set the value of idservico
         *
         * @return  self
         */ 
        public static function setIdservico($idservico)
        {
                self::$idservico = $idservico;
        }

        /**
         * Get the value of fkfuncionario
         */ 
        public static function getFkfuncionario()
        {
                return self::$fkfuncionario;
        }

        /**
         * Set the value of fkfuncionario
         *
         * @return  self
         */ 
        public static function setFkfuncionario($fkfuncionario)
        {
                self::$fkfuncionario = $fkfuncionario;
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
         * Get the value of descricao
         */ 
        public static function getDescricao()
        {
                return self::$descricao;
        }

        /**
         * Set the value of descricao
         *
         * @return  self
         */ 
        public static function setDescricao($descricao)
        {
                self::$descricao = $descricao;
        }

        /**
         * Get the value of duracao
         */ 
        public static function getDuracao()
        {
                return self::$duracao;
        }

        /**
         * Set the value of duracao
         *
         * @return  self
         */ 
        public static function setDuracao($duracao)
        {
                self::$duracao = $duracao;
        }

        /**
         * Get the value of preco
         */ 
        public static function getPreco()
        {
                return self::$preco;
        }

        /**
         * Set the value of preco
         *
         * @return  self
         */ 
        public static function setPreco($preco)
        {
                self::$preco = $preco;
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
			$sql = "INSERT INTO ".self::$table." VALUES(0,:fkfuncionario, :nome, :descricao, :duracao, :preco, :foto)";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':fkfuncionario', self::$fkfuncionario);
			$stmt->bindParam(':nome', self::$nome);
			$stmt->bindParam(':descricao', self::$descricao);
			$stmt->bindParam(':duracao', self::$duracao);
			$stmt->bindParam(':preco', self::$preco);
			$stmt->bindParam(':foto', self::$foto);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		}
		//Method select
		public static function listar() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT * FROM ".self::$table;
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$lista = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $lista;
		}
		//Method for getting data of serviços
		public static function getData() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT * FROM ".self::$table." WHERE idservico = :idservico";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idservico', self::$idservico);
			$stmt->execute();
			$data = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $data;
		}
		//Method for to get 'foto' of serviço
		public static function gettingFoto() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT foto FROM ".self::$table." WHERE idservico = :idservico";
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':idservico', self::$idservico);
			$stmt->execute();
			$dataFoto = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $dataFoto;
		}
		//Method update
		public static function editar() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "UPDATE ".self::$table." SET fkfuncionario = :fkfuncionario, nome = :nome, descricao = :descricao, duracao = :duracao, preco = :preco, foto = :foto WHERE idservico = :idservico";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idservico', self::$idservico);
			$stmt->bindParam(':fkfuncionario', self::$fkfuncionario);
			$stmt->bindParam(':nome', self::$nome);
			$stmt->bindParam(':descricao', self::$descricao);
			$stmt->bindParam(':duracao', self::$duracao);
			$stmt->bindParam(':preco', self::$preco);
			$stmt->bindParam(':foto', self::$foto);
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
			$sql = "UPDATE ".self::$table." SET fkfuncionario = :fkfuncionario, nome = :nome, descricao = :descricao, duracao = :duracao, preco = :preco WHERE idservico = :idservico";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idservico', self::$idservico);
			$stmt->bindParam(':fkfuncionario', self::$fkfuncionario);
			$stmt->bindParam(':nome', self::$nome);
			$stmt->bindParam(':descricao', self::$descricao);
			$stmt->bindParam(':duracao', self::$duracao);
			$stmt->bindParam(':preco', self::$preco);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		}
		//Method delete
		public static function excluir() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "DELETE FROM ".self::$table." WHERE idservico = :idservico";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idservico',self::$idservico);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		}
		//Method of search
		public static function buscar() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT * FROM ".self::$table." WHERE nome LIKE :nome";
			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':nome', '%'.self::$nome.'%');
			$stmt->execute();
			$resultSearch = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $resultSearch;
		}
		//Method of listing serviços on the pag agendamento
		public static function listing() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT idservico, nome FROM ".self::$table;
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$returnList = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $returnList;
		}
		//Method of listing details serviços
		public static function details() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT duracao, preco, foto FROM ".self::$table." WHERE idservico = :idservico";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idservico', self::$idservico);
			$stmt->execute();
			$details = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $details;
		}
		//Method of listing funcionário on the pag agendamento
		public static function listingFuncionario() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT funcionario.idfuncionario, funcionario.nome FROM funcionario LEFT JOIN servico ON funcionario.idfuncionario = servico.fkfuncionario WHERE servico.idservico = :idservico";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idservico', self::$idservico);
			$stmt->execute();
			$funcionario = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $funcionario;
		}
    }
?>
