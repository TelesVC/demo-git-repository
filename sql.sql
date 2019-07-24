CREATE TABLE Pedido (
	nro int PRIMARY KEY NOT NULL AUTO_INCREMENT,
    cliente int NOT NULL,
 	dataemissao date,
    dataentrega date,
    dataefetuada date,
    condpag varchar(50),
    valortotal float(8,2),
    FOREIGN KEY (cliente) References Cliente(idCliente),
);


CREATE TABLE Carrinho_compras (
	nro int PRIMARY KEY NOT NULL AUTO_INCREMENT,
 	data date,
    hora time,
    condpag varchar(50),
    valortotal float(8,2)
);

CREATE TABLE Item_carrinho (
	nro int NOT NULL,
	produto varchar(50),
	quantidade int,
	FOREIGN KEY (nro) References Carrinho_compras(nro),
 	FOREIGN KEY (produto) References Produto(codigo)
);

CREATE TABLE Endereco_aternativo (
    cliente int PRIMARY KEY NOT NULL,
    cep varchar(11),
    cidade varchar(50),
    rua varchar(50),
    bairro varchar(50),
    estado varchar(50),
    complemento varchar(50),
    FOREIGN KEY (cliente) References Cliente(idCliente)
);