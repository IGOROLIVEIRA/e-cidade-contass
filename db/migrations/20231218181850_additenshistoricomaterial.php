<?php

use Phinx\Migration\AbstractMigration;

class Additenshistoricomaterial extends AbstractMigration
{

    public function getItensSicom(){
        return $this->fetchAll("SELECT DISTINCT *
FROM
    ( SELECT '10' AS db150_tiporegistro,
             pc01_codmater ||''|| pc17_unid AS db150_coditem,
             pc01_codmater AS db150_pcmater,
             substring(pc01_descrmater ||'-'|| pc01_complmater
                       FROM 0
                       FOR 999) AS db150_dscitem,
             m61_abrev AS db150_unidademedida,
             '1' AS db150_tipocadastro,
             EXTRACT (MONTH
                      FROM pc01_data) AS db150_mes,
                     pc01_instit AS db150_instit,
                     pc01_data
     FROM solicitem
     INNER JOIN solicitempcmater ON pc16_solicitem=pc11_codigo
     INNER JOIN pcmater ON pc16_codmater = pc01_codmater
     INNER JOIN solicitemunid ON pc17_codigo = pc11_codigo
     INNER JOIN matunid ON pc17_unid = m61_codmatunid
     UNION SELECT '10' AS db150_tiporegistro,
                  pc01_codmater ||''|| m61_codmatunid AS db150_coditem,
                  pc01_codmater AS db150_pcmater,
                  substring(pc01_descrmater ||'-'|| pc01_complmater
                            FROM 0
                            FOR 999) AS db150_dscitem,
                  m61_abrev AS db150_unidademedida,
                  '1' AS db150_tipocadastro,
                  EXTRACT (MONTH
                           FROM pc01_data) AS db150_mes,
                          pc01_instit AS db150_instit,
                          pc01_data
     FROM acordoposicao
     INNER JOIN acordoitem ON ac20_acordoposicao = ac26_sequencial
     INNER JOIN pcmater ON pc01_codmater = ac20_pcmater
     INNER JOIN matunid ON ac20_matunid = m61_codmatunid ) AS x
WHERE db150_coditem::int8 NOT IN
        (SELECT db150_coditem
         FROM historicomaterial)");
    }
    function sanitizeString($string) {
        $what = array('\\', '/','"','\'');
        $by   = array('','','','');
        return str_replace($what, $by, $string);
    }
    public function up()
    {

        $aItens = $this->getItensSicom();

        foreach ($aItens as $item){

            $db150_dscitem = $this->sanitizeString($item['db150_dscitem']);
            $db150_unidademedida = $this->sanitizeString($item['db150_unidademedida']);

            $sSql = "";
            $sSql = "insert into historicomaterial values (nextval('historicomaterial_db150_sequencial_seq'),
                        {$item['db150_tiporegistro']},
                        {$item['db150_coditem']},
                        {$item['db150_pcmater']},
                        '{$db150_dscitem}',
                        '{$db150_unidademedida}',
                        {$item['db150_tipocadastro']},
                        '',
                        {$item['db150_mes']},
                        '{$item['pc01_data']}',
                        {$item['db150_instit']});";
            $this->execute($sSql);
        }
    }
}
