 -- Ocorrência 4604
BEGIN;

SELECT fc_startsession();

 -- Início do script

ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_tiporegistro;


ALTER TABLE flpgo102018 ADD COLUMN si195_tiporegistro bigint;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_codvinculopessoa;


ALTER TABLE flpgo102018 ADD COLUMN si195_codvinculopessoa bigint;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_regime;


ALTER TABLE flpgo102018 ADD COLUMN si195_regime varchar(1);


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_indtipopagamento;


ALTER TABLE flpgo102018 ADD COLUMN si195_indtipopagamento varchar(1);


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_dsctipopagextra;


ALTER TABLE flpgo102018 ADD COLUMN si195_dsctipopagextra varchar(150);


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_indsituacaoservidorpensionista;


ALTER TABLE flpgo102018 ADD COLUMN si195_indsituacaoservidorpensionista varchar(1);


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_dscsituacao;


ALTER TABLE flpgo102018 ADD COLUMN si195_dscsituacao varchar(120);


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_datconcessaoaposentadoriapensao;


ALTER TABLE flpgo102018 ADD COLUMN si195_datconcessaoaposentadoriapensao date;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_dsccargo;


ALTER TABLE flpgo102018 ADD COLUMN si195_dsccargo varchar(150);


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_codcargo;


ALTER TABLE flpgo102018 ADD COLUMN si195_codcargo bigint;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_sglcargo;


ALTER TABLE flpgo102018 ADD COLUMN si195_sglcargo varchar(3);


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_dscsiglacargo;


ALTER TABLE flpgo102018 ADD COLUMN si195_dscsiglacargo varchar(150);


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_dscapo;


ALTER TABLE flpgo102018 ADD COLUMN si195_dscapo varchar(3);


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_reqcargo;


ALTER TABLE flpgo102018 ADD COLUMN si195_reqcargo bigint;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_dscreqcargo;


ALTER TABLE flpgo102018 ADD COLUMN si195_dscreqcargo varchar(150);


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_indcessao;


ALTER TABLE flpgo102018 ADD COLUMN si195_indcessao varchar(3);


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_dsclotacao;


ALTER TABLE flpgo102018 ADD COLUMN si195_dsclotacao varchar(120);


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_vlrcargahorariasemanal;


ALTER TABLE flpgo102018 ADD COLUMN si195_vlrcargahorariasemanal bigint;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_datefetexercicio;


ALTER TABLE flpgo102018 ADD COLUMN si195_datefetexercicio date;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_datcomissionado;


ALTER TABLE flpgo102018 ADD COLUMN si195_datcomissionado date;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_datexclusao;


ALTER TABLE flpgo102018 ADD COLUMN si195_datexclusao date;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_datcomissionadoexclusao;


ALTER TABLE flpgo102018 ADD COLUMN si195_datcomissionadoexclusao date;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_vlrremuneracaobruta;


ALTER TABLE flpgo102018 ADD COLUMN si195_vlrremuneracaobruta double PRECISION;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_vlrdescontos;


ALTER TABLE flpgo102018 ADD COLUMN si195_vlrdescontos double PRECISION;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_vlrremuneracaoliquida;


ALTER TABLE flpgo102018 ADD COLUMN si195_vlrremuneracaoliquida double PRECISION;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_natsaldoliquido;


ALTER TABLE flpgo102018 ADD COLUMN si195_natsaldoliquido varchar(1);


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_mes;


ALTER TABLE flpgo102018 ADD COLUMN si195_mes bigint;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_inst;


ALTER TABLE flpgo102018 ADD COLUMN si195_inst bigint;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_desctipopagextra;


ALTER TABLE flpgo102018
DROP COLUMN IF EXISTS si195_vlrdeducoes;


ALTER TABLE flpgo112018
DROP COLUMN IF EXISTS si196_tiporegistro;


ALTER TABLE flpgo112018
DROP COLUMN IF EXISTS si196_tiporemuneracao;


ALTER TABLE flpgo112018
DROP COLUMN IF EXISTS si196_desctiporemuneracao;


ALTER TABLE flpgo112018
DROP COLUMN IF EXISTS si196_vlrremuneracaodetalhada;


ALTER TABLE flpgo112018
DROP COLUMN IF EXISTS si196_mes;


ALTER TABLE flpgo112018
DROP COLUMN IF EXISTS si196_inst;


ALTER TABLE flpgo112018
DROP COLUMN IF EXISTS si196_indtipopagamento;


ALTER TABLE flpgo112018
DROP COLUMN IF EXISTS si196_codvinculopessoa;


ALTER TABLE flpgo112018
DROP COLUMN IF EXISTS si196_codrubricaremuneracao;


ALTER TABLE flpgo112018
DROP COLUMN IF EXISTS si196_desctiporubrica;


ALTER TABLE flpgo112018 ADD COLUMN si196_tiporegistro bigint;


ALTER TABLE flpgo112018 ADD COLUMN si196_indtipopagamento varchar(1);


ALTER TABLE flpgo112018 ADD COLUMN si196_codvinculopessoa varchar(15);


ALTER TABLE flpgo112018 ADD COLUMN si196_codrubricaremuneracao varchar(4);


ALTER TABLE flpgo112018 ADD COLUMN si196_desctiporubrica varchar(150);


ALTER TABLE flpgo112018 ADD COLUMN si196_vlrremuneracaodetalhada double PRECISION;


ALTER TABLE flpgo112018 ADD COLUMN si196_mes bigint;


ALTER TABLE flpgo112018 ADD COLUMN si196_inst bigint;


ALTER TABLE flpgo122018
DROP COLUMN IF EXISTS si197_tiporegistro;


ALTER TABLE flpgo122018
DROP COLUMN IF EXISTS si197_tipodesconto;


ALTER TABLE flpgo122018
DROP COLUMN IF EXISTS si197_vlrdescontodetalhado;


ALTER TABLE flpgo122018
DROP COLUMN IF EXISTS si197_mes;


ALTER TABLE flpgo122018
DROP COLUMN IF EXISTS si197_inst;


ALTER TABLE flpgo122018
DROP COLUMN IF EXISTS si197_indtipopagamento;


ALTER TABLE flpgo122018
DROP COLUMN IF EXISTS si197_codvinculopessoa;


ALTER TABLE flpgo122018
DROP COLUMN IF EXISTS si197_codrubricadesconto;


ALTER TABLE flpgo122018
DROP COLUMN IF EXISTS si197_desctiporubrica;

ALTER TABLE flpgo122018
DROP COLUMN IF EXISTS si197_desctiporubricadesconto;


ALTER TABLE flpgo122018 ADD COLUMN si197_tiporegistro bigint;


ALTER TABLE flpgo122018 ADD COLUMN si197_indtipopagamento varchar(1);


ALTER TABLE flpgo122018 ADD COLUMN si197_codvinculopessoa varchar(15);


ALTER TABLE flpgo122018 ADD COLUMN si197_codrubricadesconto varchar(4);


ALTER TABLE flpgo122018 ADD COLUMN si197_desctiporubricadesconto varchar(150);


ALTER TABLE flpgo122018 ADD COLUMN si197_vlrdescontodetalhado double PRECISION;


ALTER TABLE flpgo122018 ADD COLUMN si197_mes bigint;


ALTER TABLE flpgo122018 ADD COLUMN si197_inst bigint;

 -- Fim do script
 COMMIT;

