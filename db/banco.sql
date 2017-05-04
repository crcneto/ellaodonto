create table usuario(
    id serial unique not null,
    nome varchar(120) not null,
    cpfcnpj bigint not null unique,
    email varchar(120) not null unique,
    tel varchar(30),
    apelido varchar(120),
    sexo integer not null default 1,
    senha varchar not null,
    datanasc date, 
    ts timestamp default now(),
    secretaria integer,
    profissional integer,
    sysadmin integer,
    status integer default 1
);


insert into usuario (nome, cpfcnpj, email, tel, apelido, senha, datanasc, secretaria, profissional, sysadmin, status) values ('Claudio Neto', 00468168958, 'claudiorcneto@yahoo.com.br', '47-98425-2559', 'Neto', md5('0000'), '1981-03-10', 1, 1, 1, 2);

create table ultimoacesso(
    id serial unique not null,
    usuario integer references usuario(id),
    login timestamp default now()
);


create table area(
    id serial unique not null,
    nome varchar(120) not null,
    status integer default 2
);

create table especialidade(
    id serial unique not null,
    nome varchar(120) not null,
    area integer references area(id),
    obs text,
    status integer default 2
);

/*Paciente*/
create table paciente(
    id serial unique not null,
    usuario integer references usuario(id),
    nome varchar(120) not null,
    dn date,
    sexo integer not null default 1,
    ts timestamp default now(),
    operador integer references usuario(id),
    status integer not null default 2
);

/*Até aqui */
create table formacao (
    id serial unique not null,
    profissional integer references profissional(id),
    especializacao integer references especializacao(id)
);


