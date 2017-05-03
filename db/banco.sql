create table usuario(
    id serial unique not null,
    nome varchar(60) not null,
    email varchar(120) not null unique,
    senha varchar not null,
    ts timestamp default now(),
    acesso integer default 1,
    status integer default 1
);


insert into usuario (nome, email, senha, datanasc, acesso, status) values ('Claudio', 'claudiorcneto@yahoo.com.br', md5('0000'), 9, 2);

create table ultimoacesso(
    id serial unique not null,
    usuario integer references usuario(id),
    login timestamp default now()
);

create table profissional(
    id serial unique not null,
    usuario integer references usuario(id),
    apelido varchar(60),
    sexo integer default 1,
    status integer default 2
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
    nome varchar(60) not null,
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


