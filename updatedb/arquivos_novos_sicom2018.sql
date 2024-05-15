BEGIN;
SELECT fc_startsession();

DROP TABLE IF EXISTS iderp102018;
DROP TABLE IF EXISTS iderp112018;
DROP TABLE IF EXISTS iderp202018;

DROP TABLE IF EXISTS conge102018;
DROP TABLE IF EXISTS conge202018;
DROP TABLE IF EXISTS conge302018;
DROP TABLE IF EXISTS conge402018;
DROP TABLE IF EXISTS conge502018;

DROP TABLE IF EXISTS tce102018;
DROP TABLE IF EXISTS tce112018;


-- Criando  sequences
CREATE SEQUENCE iderp102018_si179_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE iderp112018_si180_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


CREATE SEQUENCE iderp202018_si181_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


-- TABELAS E ESTRUTURA

-- Módulo: sicom
CREATE TABLE conge102018(
si182_sequencial		int8 NOT NULL default 0,
si182_tiporegistro		int8 NOT NULL default 0,
si182_codconvenioconge		int8 NOT NULL default 0,
si182_codorgao		varchar(2) NOT NULL ,
si182_codunidadesub		varchar(8) NOT NULL ,
si182_nroconvenioconge		varchar(30) NOT NULL ,
si182_dscinstrumento		varchar(50) NOT NULL ,
si182_dataassinaturaconge		date NOT NULL default null,
si182_datapublicconge		date NOT NULL default null,
si182_nrocpfrespconge		varchar(11) NOT NULL ,
si182_dsccargorespconge		varchar(50) NOT NULL ,
si182_objetoconvenioconge		varchar(500) NOT NULL ,
si182_datainiciovigenciaconge		varchar(8) NOT NULL ,
si182_datafinalvigenciaconge		date NOT NULL default null,
si182_formarepasse		int8 NOT NULL default 0,
ai182_tipodocumentoincentivador		int8 NOT NULL default 0,
si182_nrodocumentoincentivador		varchar(14) NOT NULL ,
si182_quantparcelas		int8 NOT NULL default 0,
si182_vltotalconvenioconge		float8 NOT NULL default 0,
si182_vlcontrapartidaconge		float8 NOT NULL default 0,
si182_tipodocumentobeneficiario		int8 NOT NULL default 0,
si182_nrodocumentobeneficiario		varchar(14) NOT NULL ,
si182_mes		int8 NOT NULL default 0,
si182_instit		int8 default 0,
CONSTRAINT conge102018_sequ_pk PRIMARY KEY (si182_sequencial));


-- Módulo: sicom
CREATE TABLE conge202018(
si183_sequencial		int8 NOT NULL default 0,
si183_tiporegistro		int8 NOT NULL default 0,
si183_codorgao		varchar(2) NOT NULL ,
si183_codunidadesub		varchar(8) NOT NULL ,
si183_nroconvenioconge		varchar(30) NOT NULL ,
si183_dataassinaturaconvoriginalconge		date NOT NULL default null,
si183_nroseqtermoaditivoconge		int8 NOT NULL default 0,
si183_dscalteracaoconge		varchar(500) NOT NULL ,
si183_dataassinaturatermoaditivoconge		date NOT NULL default null,
si183_datafinalvigenciaconge		date NOT NULL default null,
si183_valoratualizadoconvenioconge		float8 NOT NULL default 0,
si183_valoratualizadocontrapartidaconge		float8 NOT NULL default 0,
si183_mes		int8 NOT NULL default 0,
si183_instit		int8 default 0,
CONSTRAINT conge202018_sequ_pk PRIMARY KEY (si183_sequencial));


-- Módulo: sicom
CREATE TABLE conge302018(
si184_sequencial		int8 NOT NULL default 0,
si184_tiporegistro		int8 NOT NULL default 0,
si184_codorgao		varchar(2) NOT NULL ,
si184_codunidadesub		varchar(8) NOT NULL ,
si184_nroconvenioconge		varchar(30) NOT NULL ,
si184_dataassinaturaconvoriginalconge		date NOT NULL default null,
si184_numeroparcela		int8 NOT NULL default 0,
si184_datarepasseconge		date NOT NULL default null,
si184_vlrepassadoconge		float8 NOT NULL default 0,
si184_banco		int8 NOT NULL default 0,
si184_agencia		varchar(6) NOT NULL ,
si184_digitoverificadoragencia		varchar(2) NOT NULL ,
si184_contabancaria		int8 NOT NULL default 0,
si184_digitoverificadorcontabancaria		varchar(2) NOT NULL ,
si184_tipodocumentotitularconta		int8 NOT NULL default 0,
si184_nrodocumentotitularconta		varchar(14) NOT NULL ,
si184_prazoprestacontas		date NOT NULL default null,
si184_mes		int8 NOT NULL default 0,
si184_instit		int8 default 0,
CONSTRAINT conge302018_sequ_pk PRIMARY KEY (si184_sequencial));


-- Módulo: sicom
CREATE TABLE conge402018(
si185_sequencial		int8 NOT NULL default 0,
si185_tiporegistro		int8 NOT NULL default 0,
si185_codorgao		varchar(2) NOT NULL ,
si185_codunidadesub		varchar(8) NOT NULL ,
si185_nroconvenioconge		varchar(30) NOT NULL ,
si185_dataassinaturaconvoriginalconge		date NOT NULL default null,
si185_numeroparcela		int8 NOT NULL default 0,
si185_datarepasseconge		date NOT NULL default null,
si185_prestacaocontasparcela		int8 NOT NULL default 0,
si185_dataprestacontasparcela		date NOT NULL default null,
si185_prestacaocontas		int8 NOT NULL default 0,
si185_datacienfatos		date NOT NULL default null,
si185_prorrogprazo		int8 NOT NULL default 0,
si185_dataprorrogprazo		date NOT NULL default null,
si185_nrocpfrespprestconge		varchar(11) NOT NULL ,
si185_dsccargorespprestconge		varchar(50) NOT NULL ,
si185_mes		int8 NOT NULL default 0,
si185_instit		int8 default 0,
CONSTRAINT conge402018_sequ_pk PRIMARY KEY (si185_sequencial));


-- Módulo: sicom
CREATE TABLE conge502018(
si186_sequencial		int8 NOT NULL default 0,
si186_tiporegistro		int8 NOT NULL default 0,
si186_codorgao		varchar(2) NOT NULL ,
si186_codunidadesub		varchar(8) NOT NULL ,
si186_nroconvenioconge		varchar(30) NOT NULL ,
si186_dataassinaturaconvoriginalconge		date NOT NULL default null,
si186_dscmedidaadministrativa		varchar(500) NOT NULL ,
si186_datainiciomedida		date NOT NULL default null,
si186_datafinalmedida		date NOT NULL default null,
si186_adocaomedidasadmin		int8 NOT NULL default 0,
si186_nrocpfrespmedidaconge		varchar(11) NOT NULL ,
si186_dsccargorespmedidaconge		varchar(50) NOT NULL ,
si186_mes		int8 NOT NULL default 0,
si186_instit		int8 default 0,
CONSTRAINT conge502018_sequ_pk PRIMARY KEY (si186_sequencial));


-- Módulo: sicom
CREATE TABLE iderp102018(
si179_sequencial		int8 NOT NULL default 0,
si179_tiporegistro		int8 NOT NULL default 0,
si179_codreduzidoiderp		int8 NOT NULL default 0,
si179_codorgao		varchar(2) NOT NULL ,
si179_codunidadesub		varchar(8) NOT NULL ,
si179_nroempenho		int8 NOT NULL default 0,
si179_tiporestospagar		int8 NOT NULL default 0,
si179_disponibilidadecaixa		int8 NOT NULL default 0,
si179_vlinscricao		float8 NOT NULL default 0,
si179_mes		int8 NOT NULL default 0,
si179_instit		int8 default 0,
CONSTRAINT iderp102018_sequ_pk PRIMARY KEY (si179_sequencial));


-- Módulo: sicom
CREATE TABLE iderp112018(
si180_sequencial		int8 NOT NULL default 0,
si180_tiporegistro		int8 NOT NULL default 0,
si180_codreduzidoiderp		int8 NOT NULL default 0,
si180_codfontrecursos		int8 NOT NULL default 0,
si180_vlinscricaofonte		float8 NOT NULL default 0,
si180_reg10		int8 NOT NULL default 0,
si180_mes		int8 NOT NULL default 0,
si180_instit		float8 default 0,
CONSTRAINT iderp112018_sequ_pk PRIMARY KEY (si180_sequencial));


-- Módulo: sicom
CREATE TABLE iderp202018(
si181_sequencial		int8 NOT NULL default 0,
si181_tiporegistro		int8 NOT NULL default 0,
si181_codorgao		varchar(2) NOT NULL ,
si181_codfontrecursos		int8 NOT NULL default 0,
si181_vlcaixabruta		float8 NOT NULL default 0,
si181_vlrspexerciciosanteriores		float8 NOT NULL default 0,
si181_vlrestituiveisrecolher		float8 NOT NULL default 0,
si181_vlrestituiveisativofinanceiro		float8 NOT NULL default 0,
si181_vlsaldodispcaixa		float8 NOT NULL default 0,
si181_mes		int8 NOT NULL default 0,
si181_instit		int8 default 0,
CONSTRAINT iderp202018_sequ_pk PRIMARY KEY (si181_sequencial));


-- Módulo: sicom
CREATE TABLE tce102018(
si187_sequencial		int8 NOT NULL default 0,
si187_tiporegistro		int8 NOT NULL default 0,
si187_numprocessotce		varchar(12) NOT NULL ,
si187_datainstauracaotce		date NOT NULL default null,
si187_codunidadesub		varchar(8) NOT NULL ,
si187_nroconvenioconge		varchar(30) NOT NULL ,
si187_dataassinaturaconvoriginalconge		date NOT NULL default null,
si187_dscinstrumelegaltce		varchar(50) NOT NULL ,
si187_nrocpfautoridadeinstauratce		varchar(11) NOT NULL ,
si187_dsccargoresptce		varchar(50) NOT NULL ,
si187_vloriginaldano		float8 NOT NULL default 0,
si187_vlatualizadodano		float8 NOT NULL default 0,
si187_dataatualizacao		date NOT NULL default null,
si187_indice		varchar(20) NOT NULL ,
si187_ocorrehipotese		int8 NOT NULL default 0,
si187_identiresponsavel		int8 NOT NULL default 0,
si187_mes		int8 NOT NULL default 0,
si187_instit		int8 default 0,
CONSTRAINT tce102018_sequ_pk PRIMARY KEY (si187_sequencial));


-- Módulo: sicom
CREATE TABLE tce112018(
si188_sequencial		int8 NOT NULL default 0,
si188_tiporegistro		int8 NOT NULL default 0,
si188_tipodocumentorespdano		int8 NOT NULL default 0,
si188_nrodocumentorespdano		varchar(14) NOT NULL ,
si188_reg10		int8 NOT NULL default 0,
si188_mes		int8 NOT NULL default 0,
si188_instit		int8 default 0,
CONSTRAINT tce112018_sequ_pk PRIMARY KEY (si188_sequencial));




-- CHAVE ESTRANGEIRA


ALTER TABLE iderp112018
ADD CONSTRAINT iderp112018_reg10_fk FOREIGN KEY (si180_reg10)
REFERENCES iderp102018;

ALTER TABLE tce112018
ADD CONSTRAINT tce112018_reg10_fk FOREIGN KEY (si188_reg10)
REFERENCES tce112018;

COMMIT;

