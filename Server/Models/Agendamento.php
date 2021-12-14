<?php
    namespace Server\Models;
    //Class Agendamento
    Class Agendamento {
        private static $table = 'agendamento';
        private static $idagendamento;
        private static $fkcliente;
        private static $fkservico;
        private static $fkfuncionario;
        private static $data;
        private static $horario;
        //Method constructor
        function __construct() {
            self::$idagendamento = 0;
            self::$fkcliente = '';
            self::$fkservico = '';
            self::$fkfuncionario = '';
            self::$data = '';
            self::$horario = '';
        }

        /**
         * Get the value of idagendamento
         */ 
        public static function getIdagendamento()
        {
                return self::$idagendamento;
        }

        /**
         * Set the value of idagendamento
         *
         * @return  self
         */ 
        public static function setIdagendamento($idagendamento)
        {
                self::$idagendamento = $idagendamento;
        }

        /**
         * Get the value of fkcliente
         */ 
        public static function getFkcliente()
        {
                return self::$fkcliente;
        }

        /**
         * Set the value of fkcliente
         *
         * @return  self
         */ 
        public static function setFkcliente($fkcliente)
        {
                self::$fkcliente = $fkcliente;
        }

        /**
         * Get the value of fkservico
         */ 
        public static function getFkservico()
        {
                return self::$fkservico;
        }

        /**
         * Set the value of fkservico
         *
         * @return  self
         */ 
        public static function setFkservico($fkservico)
        {
                self::$fkservico = $fkservico;
        }

        /**
         * Get the value of data
         */ 
        public static function getData()
        {
                return self::$data;
        }

        /**
         * Set the value of data
         *
         * @return  self
         */ 
        public static function setData($data)
        {
                self::$data = $data;
        }

        /**
         * Get the value of horario
         */ 
        public static function getHorario()
        {
                return self::$horario;
        }

        /**
         * Set the value of horario
         *
         * @return  self
         */ 
        public static function setHorario($horario)
        {
                self::$horario = $horario;
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
        //Method insert
        public static function cadastrar() {
            $conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
            $sql = "INSERT INTO ".self::$table." VALUES(0,:fkcliente,:fkservico,:fkfuncionario,:data,:horario)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':fkcliente', self::$fkcliente);
            $stmt->bindParam(':fkservico', self::$fkservico);
            $stmt->bindParam(':fkfuncionario',self::$fkfuncionario);
            $stmt->bindParam(':data', self::$data);
            $stmt->bindParam(':horario', self::$horario);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
		//Method of listing data of agendamento
		public static function listingAgendamento() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT agendamento.idagendamento, servico.nome AS 'nomeServico', funcionario.nome AS 'nomeFuncionario', agendamento.data, agendamento.horario FROM servico INNER JOIN ".self::$table." ON servico.idservico = agendamento.fkservico INNER JOIN funcionario ON agendamento.fkfuncionario = funcionario.idfuncionario WHERE servico.idservico = agendamento.fkservico AND funcionario.idfuncionario = agendamento.fkfuncionario AND fkcliente = :idcliente";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idcliente', self::$fkcliente);
			$stmt->execute();
			$agenda = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $agenda;
		}
		//Method that get data from database
		public static function gettingData() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT servico.idservico, servico.nome AS 'nomeServico', funcionario.nome AS 'nomeFuncionario', funcionario.idfuncionario, agendamento.idagendamento, agendamento.data, agendamento.horario FROM servico INNER JOIN ".self::$table." ON servico.idservico = agendamento.fkservico INNER JOIN funcionario ON agendamento.fkfuncionario = funcionario.idfuncionario WHERE servico.idservico = agendamento.fkservico AND funcionario.idfuncionario = agendamento.fkfuncionario AND idagendamento = :idagendamento";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idagendamento',self::$idagendamento);
			$stmt->execute();
			$data = $stmt->fetch(\PDO::FETCH_ASSOC);
			return $data;
		}
		//Method for to edit agendamento
		public static function editar() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "UPDATE ".self::$table." SET fkservico = :fkservico, fkfuncionario = :fkfuncionario, data = :data, horario = :horario WHERE idagendamento = :idagendamento AND fkcliente = :fkcliente";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idagendamento', self::$idagendamento);
			$stmt->bindParam(':fkcliente', self::$fkcliente);
			$stmt->bindParam(':fkservico', self::$fkservico);
			$stmt->bindParam(':fkfuncionario', self::$fkfuncionario);
			$stmt->bindParam(':data', self::$data);
			$stmt->bindParam(':horario', self::$horario);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		}
		//Method for to delete agendamento
		public static function excluir() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "DELETE FROM ".self::$table." WHERE idagendamento = :idagendamento";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':idagendamento',self::$idagendamento);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		}
		//Method for to get horario from database
		public static function gettingHorario() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT horario FROM ".self::$table." WHERE data = :data";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':data', self::$data);
			$stmt->execute();
			$hr = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $hr;
		}
		//Method for to list agendamentos for admin
		public static function listar() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT servico.nome 'servico', funcionario.nome 'funcionario', cliente.nome 'cliente', agendamento.idagendamento, agendamento.horario FROM servico INNER JOIN ".self::$table." ON servico.idservico = agendamento.fkservico INNER JOIN funcionario ON agendamento.fkfuncionario = funcionario.idfuncionario INNER JOIN cliente ON agendamento.fkcliente = cliente.idcliente WHERE agendamento.data = curdate() ORDER BY horario";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$agenda = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $agenda;
		}
		//Method for to list agendamentos with param data
		public static function buscar() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "SELECT servico.nome 'servico', funcionario.nome 'funcionario', cliente.nome 'cliente', agendamento.idagendamento, agendamento.horario, agendamento.data FROM servico INNER JOIN ".self::$table." ON servico.idservico = agendamento.fkservico INNER JOIN funcionario ON agendamento.fkfuncionario = funcionario.idfuncionario INNER JOIN cliente ON agendamento.fkcliente = cliente.idcliente WHERE agendamento.data = :data ORDER BY horario";
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':data', self::$data);
			$stmt->execute();
			$agenda = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			return $agenda;
		}
		//Method for to delete agendamentos
		public static function excluir_agendamento() {
			$conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
			$sql = "DELETE FROM ".self::$table." WHERE datediff(curdate(), data) > 0";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			if($stmt->rowCount() > 0) {
				return true;
			} else {
				return false;
			}
		}
	}
?>