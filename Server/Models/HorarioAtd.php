<?php
    namespace Server\Models;
    //Class Horário de atendimento
    Class HorarioAtd {
        private static $table = 'horario_atendimento';
        private static $idhorario_atd;
        private static $horarioEntrada;
        private static $horarioSaida;
        private static $intervalo_atd;
        //Method constructor
        function __construct() {
            self::$idhorario_atd = 0;
            self::$horarioEntrada = '';
            self::$horarioSaida = '';
            self::$intervalo_atd = '';
        }
        //Encapsulation
        public static function getIdhorario_atd() {
            return self::$idhorario_atd;
        }
        public static function setIdhorario_atd($idhorario_atd) {
            self::$idhorario_atd = $idhorario_atd;
        }
        public static function getHorarioEntrada() {
            return self::$horarioEntrada;
        }
        public static function setHorarioEntrada($horarioEntrada) {
            self::$horarioEntrada = $horarioEntrada;
        }
        public static function getHorarioSaida() {
            return self::$horarioSaida;
        }
        public static function setHorarioSaida($horarioSaida) {
            self::$horarioSaida = $horarioSaida;
        }
        public static function getIntervalo_atd() {
            return self::$intervalo_atd;
        }
        public static function setIntervalo_atd($intervalo_atd) {
            self::$intervalo_atd = $intervalo_atd;
        }
        //Method insert
        public static function cadastrar() {
            $conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
            $sql = "INSERT INTO ".self::$table." VALUES(0,:horarioEntrada,:horarioSaida,:intervalo_atd)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':horarioEntrada',self::$horarioEntrada);
            $stmt->bindParam(':horarioSaida',self::$horarioSaida);
            $stmt->bindParam(':intervalo_atd',self::$intervalo_atd);
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
            $list = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            return $list;
        }
        //Method delete
        public static function excluir() {
            $conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
            $sql = "DELETE FROM ".self::$table." WHERE idhorario_atendimento = :idhorario_atd";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idhorario_atd',self::$idhorario_atd);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
        //Method for to get data from database for to edit
        public static function getData() {
            $conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
            $sql = "SELECT * FROM ".self::$table." WHERE idhorario_atendimento = :idhorario_atd";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idhorario_atd', self::$idhorario_atd);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $data;
        }
        //Method update
        public static function editar() {
            $conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
            $sql = "UPDATE ".self::$table." SET horarioEntrada = :horarioEntrada, horarioSaida = :horarioSaida, intervalo_atendimento = :intervalo_atendimento WHERE idhorario_atendimento = :idhorario_atendimento";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':horarioEntrada',self::$horarioEntrada);
            $stmt->bindParam(':horarioSaida', self::$horarioSaida);
            $stmt->bindParam(':intervalo_atendimento', self::$intervalo_atd);
            $stmt->bindParam(':idhorario_atendimento', self::$idhorario_atd);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
        //Method that returns only one record
        public static function listing() {
            $conn = new \PDO(DBDRIVE.':hostname='.DBHOST.';dbname='.DBNAME,DBUSER,DBPASS);
            $sql = "SELECT horarioEntrada, horarioSaida, intervalo_atendimento FROM ".self::$table;
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            return $data;
        }

    }
?>