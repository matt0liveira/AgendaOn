CREATE DATABASE IF NOT EXISTS agendaOn;
USE agendaOn;

CREATE TABLE IF NOT EXISTS cliente(
    idcliente INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(250) NOT NULL,
    senha VARCHAR(250) NOT NULL,
    telefone CHAR(15) NOT NULL,
    foto VARCHAR(80) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS admin(
    idadmin INTEGER PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(250) NOT NULL,
    senha VARCHAR(250) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS funcionario(
    idfuncionario INTEGER PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    telefone CHAR(11) NOT NULL,
    dtNascimento DATE NOT NULL,
    especializacao VARCHAR(100) NOT NULL,
    foto VARCHAR(80) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS servico(
    idservico INTEGER PRIMARY KEY AUTO_INCREMENT,
    fkfuncionario INTEGER NOT NULL,
    nome VARCHAR(50) NOT NULL,
    descricao VARCHAR(255),
    duracao VARCHAR(50) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    foto VARCHAR(80) NOT NULL,
    FOREIGN KEY (fkfuncionario) REFERENCES funcionario(idfuncionario)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS agendamento(
    idagendamento INTEGER PRIMARY KEY AUTO_INCREMENT,
    fkcliente INTEGER NOT NULL,
    fkservico INTEGER NOT NULL,
    fkfuncionario INTEGER,
    data DATE NOT NULL,
    horario TIME NOT NULL,
    FOREIGN KEY (fkcliente) REFERENCES cliente(idcliente),
    FOREIGN KEY (fkservico) REFERENCES servico(idservico),
    FOREIGN KEY (fkfuncionario) REFERENCES funcionario(idfuncionario)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS horario_atendimento(
    idhorario_atendimento INTEGER PRIMARY KEY AUTO_INCREMENT,
    horarioEntrada VARCHAR(20) NOT NULL,
    horarioSaida VARCHAR(20) NOT NULL,
    intervalo_atendimento VARCHAR(20) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS dispositivo(
    iddispositivo INTEGER PRIMARY KEY AUTO_INCREMENT,
    so VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    datacriacao DATETIME NOT NULL,
    fkcliente INTEGER, FOREIGN KEY (fkcliente) REFERENCES cliente(idcliente),
    fkadmin INTEGER, FOREIGN KEY (fkadmin) REFERENCES admin(idadmin)
) ENGINE=InnoDB;