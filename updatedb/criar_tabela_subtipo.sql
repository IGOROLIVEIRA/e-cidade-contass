begin;
select fc_startsession();
create table subtipo (
 c200_tipo int8 not null,
 c200_subtipo int8 not null,
 c200_descsubtipo varchar(100) not null,
primary key (c200_tipo,c200_subtipo));

create table desdobrasubtipo (
 c201_tipo int8 not null,
 c201_subtipo int8 not null,
 c201_desdobrasubtipo int8 not null,
 c201_descdesdobrasubtipo varchar(100) not null,
primary key (c201_tipo,c201_subtipo,c201_desdobrasubtipo),
CONSTRAINT desdobrasubtipo_c201_subtipo_fk foreign key (c201_tipo,c201_subtipo) references subtipo(c200_tipo,c200_subtipo));

insert into subtipo values (1,1,'0001-INSS'),(1,2,'0002-RPPS'),(1,3,'0003-IRRF'),(1,4,'0004-ISSQN');
insert into subtipo values (2,1,'0001-ARO');
insert into subtipo values (3,1,'0001-Salario-familia'),(3,2,'0002-Salario-maternidade'),(3,3,'0003-Outros beneficios com mais de um favorecido');

insert into subtipo values (4,1,'0001-Duodecimo Camara Municipal'),(4,2,'0002-Devolucao de Numerario para a prefeitura'),(4,3,'0003-Aporte de Recursos para Cobertura de Insuficiencia Financeira para o RPPS'),(4,4,'0004-Aporte de Recursos para Formacao de Reserva Financeira para o RPPS'),(4,5,'0005-Outros Aportes Financeiros para o RPPS'),(4,6,'0006-Aporte de Recursos para Cobertura de Deficit Financeiro para o RPPS'),(4,7,'0007-Aporte de Recursos para Cobertura ou Amortizacao de Deficit Atuarial para o RPPS'),(4,8,'0008-Outros Aportes Previdenciarios para o RPPS');

commit;
