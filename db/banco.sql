/*
Tabela de persistência dos usuários. 
Nesta tabela serão gravadas as informações principais (indispensáveis) dos usuários e seus respectivos acessos.
*/
create table usuario(
    id serial unique not null primary key,
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
    id serial unique not null primary key,
    usuario integer references usuario(id),
    login timestamp default now()
);


create table area(
    id serial unique not null primary key,
    nome varchar(120) not null,
    status integer default 2
);

create table especialidade(
    id serial unique not null primary key,
    nome varchar(120) not null,
    area integer references area(id),
    obs text,
    status integer default 2
);

/*Paciente*/
create table paciente(
    id serial unique not null primary key,
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
    id serial unique not null primary key,
    profissional integer references profissional(id),
    especializacao integer references especializacao(id)
);

create table consulta(
    id serial unique not null primary key,
    paciente integer references paciente(id),
    profissional integer references usuario(id),
    data_prevista date,
    hora_inicial time,
    hora_final time,
    queixa varchar,
    tipo integer default 1, /*1-Nova/2-Retorno*/
    
    area integer references area(id),
    
    usuario_responsavel integer references usuario(id),
    ts_gravacao timestamp default now(),
    status integer default 1 /*0-cancelada/1-pendente aprovação/2-aprovada/3-em andamento/4-finalizada parcial/5-finalizada*/
);

create table diagnostico(
    id serial unique not null primary key,
    paciente integer references paciente(id),
    consulta integer references consulta(id),
    area integer references area(id),
    
);

create table local(
    id serial unique not null primary key,
    nome varchar(255),
    tp_log integer default 1,
    logradouro varchar(255),
    nro varchar(20),
    bairro varchar(120),
    cidade varchar(120),
    uf varchar(2),
    cep varchar(9),
    complemento varchar(120),
    tel varchar(40),
    cel varchar(40),
    status integer not null default 2
);

create table meu_local(
    id serial unique not null primary key,
    local integer references local(id) not null,
    usuario integer references usuario(id) not null
);

create table horario_atendimento(
    id serial unique not null primary key,
    usuario integer references usuario(id) not null,
    data date not null,
    ti1 time,
    tf1 time,
    ti2 time,
    tf2 time,
    local integer references local(id)
);

create table assistente(
    id serial unique not null primary key,
    profissional integer references usuario(id),
    assistente integer references usuario(id)
);

create table profissional(
    id serial unique not null primary key,
    usuario int references usuario(id) not null
);

create table administrador(
    id serial unique not null primary key,
    usuario int references usuario(id) not null
);

create table sysadmin(
    id serial unique not null primary key,
    usuario int references usuario(id) not null
);

create table area_profissional(
    id serial unique not null primary key,
    profissional integer references usuario(id),
    area integer references area(id)
);

create table consulta(
    id serial unique not null primary key,
    profissional integer references usuario(id),
    paciente integer references paciente(id),
    data date,
    hora time,
    queixa text,
    lembrete date,
    ajustavel integer default 0, /*qtd de dias para adequação*/
    obs text,
    operador integer references usuario(id),
    ts timestamp default now(),
    status integer default 1, /*0-cancelada, 1-pendente, 2-confirmada, 3-atendida em tratamento, 4-atendida, 5-finalizada*/
    cancelamento timestamp default null,
    cancelador integer references usuario(id)
);

create table compromisso(
    id serial unique not null primary key,
    data date not null default now(),
    hora time,
    usuario integer not null references usuario(id),
    descricao text,
    obs text,
    consulta integer references consulta(id),
    prioridade integer default 1, /*0-sem prioridade, 1-normal, 2-ocupado, 3-ocupado sem encaixe, 4-total*/
    lembrete date,
    operador integer references usuario(id),
    ts timestamp default now(),
    cancelamento timestamp,
    cancelador integer references usuario(id),
    status integer default 1  /*0-excluido, 1-pendente, 2-em andamento, 3-aguardando, 4-não atendido, 5-cancelado*/
);


