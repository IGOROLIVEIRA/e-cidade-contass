<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_empempenho_classe.php");
require_once("classes/db_empautoriza_classe.php");
require_once("classes/db_emppresta_classe.php");
require_once("classes/db_empprestatip_classe.php");
require_once("classes/db_cflicita_classe.php");
require_once("classes/db_pctipocompra_classe.php");
require_once("classes/db_emptipo_classe.php");
require_once("classes/db_empemphist_classe.php");
require_once("classes/db_emphist_classe.php");
require_once("classes/db_concarpeculiar_classe.php");
require_once("classes/db_empempenhonl_classe.php");
require_once("classes/db_empparametro_classe.php");
require_once("classes/db_pagordem_classe.php");
require_once("classes/db_empempaut_classe.php");
require_once("classes/db_empautidot_classe.php");
require_once("classes/db_orcdotacao_classe.php");
require_once("libs/db_liborcamento.php");
require_once("classes/db_orcelemento_classe.php");
require_once("classes/db_empautitem_classe.php");
require_once("classes/db_empelemento_classe.php");
require_once("classes/db_empempitem_classe.php");
require_once("classes/db_convconvenios_classe.php");
require_once("std/Modification.php");
require_once("classes/db_empnotaele_classe.php");
require_once("classes/db_empnota_classe.php");

$clempempaut			= new cl_empempaut;
$clempempenho	  	= new cl_empempenho;
$clempautoriza  	= new cl_empautoriza;
$clemppresta	  	= new cl_emppresta;
$clempprestatip 	= new cl_empprestatip;
$clcflicita	    	= new cl_cflicita;
$clpctipocompra 	= new cl_pctipocompra;
$clemptipo	    	= new cl_emptipo;
$clemphist	    	= new cl_emphist;
$clempparametro 	= new cl_empparametro;
$clconvconvenios   = new cl_convconvenios;

$clempemphist	  	= new cl_empemphist;
$clconcarpeculiar = new cl_concarpeculiar;
$oDaoEmpenhoNl  	= new cl_empempenhonl;
$clempautidot	  	= new cl_empautidot;
$clpagordem				= new cl_pagordem;
$clorcdotacao	  	= new cl_orcdotacao;
$clorcelemento    = new cl_orcelemento;
$clempautitem	  	= new cl_empautitem;
$clempelemento	  = new cl_empelemento;
$clempempitem			= new cl_empempitem;
$clempnotaele           = new cl_empnotaele;
$clempnota           = new cl_empnota;

//Atualiza o campo historico da op
if(isset($HTTP_POST_VARS['alterar'])){
    $clempempenho->e60_informacaoop = $HTTP_POST_VARS['e60_informacaoop'];
    $clempempenho->alterar($e60_numemp);
    if($HTTP_POST_VARS['historico_alterado'] === 'true'){
        if(isset($msgCampoAlterado)){
            $msgCampoAlterado .= " - Histórico da OP\n";
        }else{
            $msgCampoAlterado = "\n\nCampos alterados: \n";
            $msgCampoAlterado .= " - Histórico da OP\n";
        }
    }
}

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$db_opcao =  22;
$db_botao = false;
if(isset($alterar)){

    $sqlerro=false;
    $db_botao = true;
    db_inicio_transacao();
    /*rotina de incluir  na tabela empempenho*/    
    $data_empenho = str_replace('/','-',$data_empenho);
    $data_empenho = date('Y-m-d', strtotime($data_empenho));
    $e60_emiss_ano = date('Y',strtotime($e60_emiss));
    $e60_emiss_mes = date('m', strtotime($e60_emiss));

    //Verifica se a data do empenho esta sendo alterada de um ano para outro
    if ($sqlerro == false){
        if ($e60_emiss_ano !== $data_empenho_ano){
            $erro_msg = "Alteração não realizada! Ano inválido.";
            $sqlerro = true;
        }
    }

    //Verifica se o periodo contabil esta encerrado na data do empenho
    $sSqlConsultaFimPeriodoContabil   = "SELECT * FROM condataconf WHERE c99_anousu = ".db_getsession('DB_anousu')." and c99_instit = ".db_getsession('DB_instit');
    $rsConsultaFimPeriodoContabil     = db_query($sSqlConsultaFimPeriodoContabil);    

    if($sqlerro == false){
        if (pg_num_rows($rsConsultaFimPeriodoContabil) > 0) {
            
            $oFimPeriodoContabil = db_utils::fieldsMemory($rsConsultaFimPeriodoContabil, 0);
            
            if ($oFimPeriodoContabil->c99_data != '' && 
            (db_strtotime($e60_emiss) < db_strtotime($oFimPeriodoContabil->c99_data) || 
            db_strtotime($data_empenho) < db_strtotime($oFimPeriodoContabil->c99_data))) {
                $erro_msg = "Período contábil encerrado.";
                $sqlerro = true;
            }
            
        }
        
    }
    
    //Verifica se é empenho de prestação de contas
    if($sqlerro == false && isset($e44_tipo)){
        if($e44_tipo == 4){
            $erro_msg = "Alteração não realizada! Não é possivel alterar empenhos de prestação de contas.";
            $sqlerro = true;
        }
    }

    //Verifica se a data nova é posterior ao lançamento contabil mais antigo
    if($sqlerro == false){
        $sql = "SELECT DISTINCT c70_data, c71_coddoc
            FROM conlancam 
            INNER JOIN conlancamval ON c69_codlan = c70_codlan
            INNER JOIN conlancamdoc ON c71_codlan = c70_codlan  
            INNER JOIN conhistdoc   ON c71_coddoc = c53_coddoc  
            INNER JOIN conlancamemp ON c75_codlan = c70_codlan  
            WHERE c75_numemp = {$e60_numemp} AND c71_coddoc NOT IN (1, 410)
            ORDER BY c70_data ASC
            ";
        $result = db_query($sql);
        if(pg_num_rows($result) > 0){
            $result = pg_fetch_assoc($result);
            if (strtotime($data_empenho) > strtotime($result['c70_data'])){
                $erro_msg = "Alteração não realizada! Verifique as datas dos lançamentos contábeis.";
                $sqlerro = true;
            }
        }
    }

    //Verifica se a dotação do empenho tem saldo
    if ($sqlerro == false){
        $tipoSaldo = 2; //Saldo do mês
        if ($data_empenho_mes === $e60_emiss_mes){
            $tipoSaldo = 3;//Saldo do dia
        } 
        $result = db_dotacaosaldo(8,2,$tipoSaldo,true," o58_coddot = $e60_coddot and o58_anousu = $e60_emiss_ano",$e60_emiss_ano,$data_empenho,$data_empenho);
        $result = pg_fetch_assoc($result);
        $saldoDotacao = $result['atual_menos_reservado'];            
        if($saldoDotacao < $e60_vlremp){                
            $erro_msg = "Alteração não realizada! A dotação não possui saldo nesta data.";
            $sqlerro = true;
        }
    }

    //Altera a data do empenho
    if($sqlerro == false){
        if(strtotime($data_empenho) < strtotime(db_getsession("DB_anousu"))){
            $mesAtual = date('m',db_getsession('DB_datausu'));
            if ($data_empenho_mes > $e60_emiss_mes){
                $mesMenor = $e60_emiss_mes;
            } else {
                $mesMenor = $data_empenho_mes;
            }
            
            //ALTERAR DATA EMPENHO
            $sqlAlteraData = "SELECT fc_startsession();

            CREATE TEMP TABLE cod_lan ON COMMIT DROP AS
            SELECT DISTINCT c75_codlan
            FROM conlancamemp 
            JOIN conlancamdoc on c71_codlan = c75_codlan
            JOIN conhistdoc on c71_coddoc = c53_coddoc
            WHERE c75_numemp = {$e60_numemp} AND c53_tipo = 10;

            CREATE TEMP TABLE saldo_ctas ON COMMIT DROP AS 
            SELECT DISTINCT conplanoexesaldo.*, deb.c69_data c69_data 
            FROM conplanoexesaldo 
            JOIN conlancamval deb ON (deb.c69_debito, deb.c69_anousu, EXTRACT (MONTH FROM deb.c69_data)::integer) = (c68_reduz, c68_anousu, c68_mes) 
            WHERE deb.c69_codlan IN (SELECT c75_codlan from cod_lan) 
            UNION ALL 
            SELECT DISTINCT conplanoexesaldo.*, cred.c69_data c69_data 
            FROM conplanoexesaldo 
            JOIN conlancamval cred ON (cred.c69_credito, cred.c69_anousu, EXTRACT (MONTH FROM cred.c69_data)::integer) = (c68_reduz, c68_anousu, c68_mes)
            WHERE cred.c69_codlan IN (SELECT c75_codlan from cod_lan);

            CREATE TEMP TABLE alt_emp ON COMMIT DROP AS
            SELECT e60_numemp AS nro_emp,
                e60_emiss AS data_emp,
                e61_autori AS autoriza
            FROM empempenho
            INNER JOIN empempaut ON e61_numemp = e60_numemp
            INNER JOIN conlancamemp ON e60_numemp = c75_numemp
            WHERE e60_numemp IN ({$e60_numemp})
            AND c75_codlan IN (SELECT c75_codlan from cod_lan);
            
            CREATE TEMP TABLE w_lancamentos ON COMMIT DROP AS
            SELECT * FROM conlancamval
            JOIN conlancamdoc ON c71_codlan = c69_codlan
            WHERE c69_codlan IN
                (SELECT c75_codlan FROM conlancamemp
                WHERE c75_numemp IN 
                    (SELECT nro_emp FROM alt_emp))
            AND c71_codlan IN (SELECT c75_codlan from cod_lan);
            
            ALTER TABLE conlancamval DISABLE TRIGGER ALL;
            
            UPDATE conlancamval
            SET c69_data = '{$data_empenho}'
            WHERE c69_codlan IN
                (SELECT c69_codlan FROM w_lancamentos);
            
            ALTER TABLE conlancamval ENABLE TRIGGER ALL;
            
            UPDATE conlancamemp
            SET c75_data = '{$data_empenho}'
            WHERE c75_codlan IN
                (SELECT c71_codlan FROM w_lancamentos);
            
            UPDATE conlancam
            SET c70_data = '{$data_empenho}'
            WHERE c70_codlan IN
                (SELECT c71_codlan FROM w_lancamentos);
            
            UPDATE conlancamdot
            SET c73_data = '{$data_empenho}'
            WHERE c73_codlan IN
                (SELECT c71_codlan FROM w_lancamentos);
            
            UPDATE conlancamdoc
            SET c71_data = '{$data_empenho}'
            WHERE c71_codlan IN
                (SELECT c71_codlan FROM w_lancamentos);

            UPDATE conlancamcorrente
            SET c86_data = '{$data_empenho}'
            WHERE c86_conlancam IN 
                (SELECT c71_codlan FROM w_lancamentos);

            UPDATE empempenho
            SET e60_emiss = '{$data_empenho}',
                e60_vencim = '{$data_empenho}'
            WHERE e60_numemp IN
                (SELECT nro_emp FROM alt_emp);
            
            UPDATE empautoriza
            SET e54_emiss = '{$data_empenho}'
            WHERE e54_autori IN
                (SELECT autoriza FROM alt_emp);";

            for($i = $mesMenor; $i <= $mesAtual; $i++){
                $sqlAlteraData .= " DELETE FROM conplanoexesaldo
                USING saldo_ctas
                WHERE (saldo_ctas.c68_reduz, saldo_ctas.c68_anousu) = (conplanoexesaldo.c68_reduz, conplanoexesaldo.c68_anousu)
                AND conplanoexesaldo.c68_mes = {$i};

                CREATE TEMP TABLE landeb".$i." ON COMMIT DROP AS
                SELECT c69_anousu,
                    c69_debito,
                    to_char(conlancamval.c69_data,'MM')::integer,
                    sum(round(c69_valor,2)),0::float8
                FROM conlancamval
                JOIN saldo_ctas ON (saldo_ctas.c68_reduz, saldo_ctas.c68_anousu) = (conlancamval.c69_debito, conlancamval.c69_anousu)
                WHERE conlancamval.c69_anousu = {$data_empenho_ano}
                AND EXTRACT (MONTH FROM conlancamval.c69_data)::integer = {$i}
                GROUP BY conlancamval.c69_anousu, conlancamval.c69_debito, to_char(conlancamval.c69_data,'MM')::integer;
                
                CREATE TEMP TABLE lancre".$i." ON COMMIT DROP AS
                SELECT c69_anousu,
                    c69_credito,
                    to_char(conlancamval.c69_data,'MM')::integer as c69_data,
                    0::float8,
                    sum(round(c69_valor,2))
                FROM conlancamval
                JOIN saldo_ctas ON (saldo_ctas.c68_reduz, saldo_ctas.c68_anousu) = (conlancamval.c69_credito, conlancamval.c69_anousu)
                WHERE conlancamval.c69_anousu = {$data_empenho_ano}
                AND EXTRACT (MONTH FROM conlancamval.c69_data)::integer = {$i}
                GROUP BY conlancamval.c69_anousu, conlancamval.c69_credito, to_char(conlancamval.c69_data,'MM')::integer;
                
                INSERT INTO conplanoexesaldo
                SELECT * FROM landeb".$i."
                WHERE c69_anousu = {$data_empenho_ano};
                
                UPDATE conplanoexesaldo
                SET c68_credito = lancre".$i.".sum
                FROM lancre".$i."
                WHERE c68_anousu = lancre".$i.".c69_anousu
                AND c68_reduz = lancre".$i.".c69_credito
                AND c68_mes = lancre".$i.".c69_data
                AND c68_anousu = {$data_empenho_ano};
                
                DELETE FROM lancre".$i."
                USING conplanoexesaldo
                WHERE lancre".$i.".c69_anousu = conplanoexesaldo.c68_anousu
                AND conplanoexesaldo.c68_reduz = lancre".$i.".c69_credito
                AND conplanoexesaldo.c68_mes = lancre".$i.".c69_data
                AND c68_anousu = {$data_empenho_ano};
                
                INSERT INTO conplanoexesaldo
                SELECT * FROM lancre".$i."
                WHERE c69_anousu = {$data_empenho_ano};
                ";
            }
            db_query($sqlAlteraData);
            //FIM ALTERAR DATA EMPENHO
        }else{
            $erro_msg = "Alteração não realizada! A data do empenho não pode ser posterior a data atual.";
            $sqlerro = true;  
        }
    }

    if($sqlerro==false){

        $db_opcao = 2;
        $dados = (object) array(
            'tabela' => 'empempenho',
            'campo'  => 'e60_codemp',
            'sigla'  => 'e60'
        );
        $veConvMSC = $clempempenho->verificaConvenioSicomMSC($e60_codemp, db_getsession("DB_anousu"), $dados);

        $fontesMsg = "122, 123, 124, 142, 163, 171, 172, 173, 176, 177, 178, 181, 182 e 183";

        if (db_getsession("DB_anousu") > 2022) {
            $fontesMsg = "15700000, 16310000, 17000000, 16650000, 17130070, 15710000, 15720000, 15750000, 16320000, 16330000, 16360000, 17010000, 17020000 e 17030000";
        }

        if ($veConvMSC > 0) {
            $rsResult = $clconvconvenios->sql_record("select c206_sequencial from convconvenios where c206_sequencial = $e60_numconvenio");

            if (!$rsResult) {
                $sqlerro  = true;

                $erro_msg  = "Inclusão Abortada!\n";
                $erro_msg .= "É obrigatório informar o convênio para os empenhos de fontes:\n";
                $erro_msg .= $fontesMsg;
            }

        }

        if($sqlerro==false){
            $clempempenho->alterar($e60_numemp);
            if($clempempenho->erro_status == 0) {
                $sqlerro=true;
            }
            $erro_msg = "Alteração não realizada! Houve um erro durante a alteração.";
        }
    }
    /**
     * Manutenção da tabela emppresta
     */
    if ($sqlerro==false && isset($e44_tipo) && $e44_tipo != "") {

        $result = $clempprestatip->sql_record($clempprestatip->sql_query_file($e44_tipo,"e44_obriga"));
        $opera = true;

        db_fieldsmemory($result,0);
        $clemppresta->e45_tipo = $e44_tipo;

        $sSqlEmppresta = $clemppresta->sql_query_file(null, 'e45_sequencial', null, "e45_numemp = $e60_numemp");
        $rsEmppresta =  $clemppresta->sql_record($sSqlEmppresta);

        if ( $clemppresta->numrows > 0 ) {

            $e45_sequencial = db_utils::fieldsMemory($rsEmppresta, 0)->e45_sequencial;
            $clemppresta->e45_sequencial = $e45_sequencial;
        }

        if ( !empty($e45_sequencial) && $e44_obriga != 0 ) {

            $clemppresta->e45_numemp = $e60_numemp;
            $clemppresta->alterar($e45_sequencial);

        } else if (!empty($e45_sequencial) && $e44_obriga == 0) {

            $clemppresta->e45_numemp = $e60_numemp;
            $clemppresta->excluir($e45_sequencial);

        } else if ($e44_obriga != 0) {

            $clemppresta->e45_data   = date("Y-m-d",db_getsession("DB_datausu"));
            $clemppresta->e45_numemp = $e60_numemp;
            $clemppresta->incluir(null);

        } else {
            $opera = false;
        }

        if ($opera == true) {

            $erro_msg = $clemppresta->erro_msg;
            if ($clemppresta->erro_status == '0') {

                $sqlerro  = true;
            }
        }

    }

    /**
     * rotina que inclui na tabela empemphist
     */
    if($sqlerro == false){

        $clempemphist->sql_record($clempemphist->sql_query_file($e60_numemp));

        if($clempemphist->numrows>0){

            $clempemphist->e63_numemp  = $e60_numemp ;
            $clempemphist->excluir($e60_numemp);
            $erro_msg=$clempemphist->erro_msg;

            if($clempemphist->erro_status==0){
                $sqlerro=true;
            }
        }
    }

    if($sqlerro==false && $e63_codhist!="Nenhum"){

        $clempemphist->e63_numemp  = $e60_numemp ;
        $clempemphist->e63_codhist = $e63_codhist ;
        $clempemphist->incluir($e60_numemp);
        $erro_msg=$clempemphist->erro_msg;

        if($clempemphist->erro_status==0){
            $sqlerro=true;
        }
    }

    if ($sqlerro==false && isset($e68_numemp) && $e68_numemp == "s") {
        
        $oDaoEmpenhoNl->e68_numemp = $e60_numemp;
        $oDaoEmpenhoNl->e68_data   = date("Y-m-d",db_getsession("DB_datausu"));
        $oDaoEmpenhoNl->incluir(null);
        if ($oDaoEmpenhoNl->erro_status == 0) {
            $sqlerro=true;
        }
    }

    if($sqlerro==false && isset($e64_codele)){

        $clempelemento->e64_codele = $e56_codele;
        $clempelemento->e64_numemp = $e60_numemp;
        $clempelemento->alterar($e60_numemp);
        if($clempelemento->erro_status=="0"){
            $sqlerro=true;
            $erro_msg = $clempelemento->erro_msg;
        }
    }

    if($sqlerro==false && isset($e64_codele)){

        $sqlNota = $clempnota->sql_query_file(null,"e69_codnota",null,"e69_numemp = {$e60_numemp}");
        $rsNota = db_query($sqlNota);

        $iNumRows = pg_num_rows($rsNota);

        if($iNumRows > 0) {

            for ($i=0; $i < $iNumRows; $i++) {

                $oRow = db_utils::fieldsMemory($rsNota,$i);

                $result = $clempnotaele->sql_record($clempnotaele->sql_query($oRow->e69_codnota));
                db_fieldsmemory($result,0);

                $clempnotaele->e70_codele = $e56_codele;
                $clempnotaele->e70_codnota = $e69_codnota;
                
                $clempnotaele->alterar($oRow->e69_codnota);
                
                if($clempnotaele->erro_status=="0"){
                    $sqlerro=true;
                    $erro_msg = $clempnotaele->erro_msg;

                }

            }
        }
    }

    if($sqlerro==false && isset($e64_codele)){

        $result = $clempempitem->sql_record($clempempitem->sql_query_file($e60_numemp,null,"e62_numemp,e62_sequen,e62_item"));

        $iNumRows = pg_num_rows($result);

        for ($i = 0; $i < $iNumRows; $i++) {

            $oRow = db_utils::fieldsMemory($result,$i);
            $clempempitem->e62_codele  = $e56_codele;
            $clempempitem->e62_numemp  = $oRow->e62_numemp;
            $clempempitem->e62_sequen  = $oRow->e62_sequen;
            $clempempitem->alterar($oRow->e62_numemp,$oRow->e62_sequen);

            if ($clempempitem->erro_status=="0") {

                $sqlerro=true;
                $erro_msg = $clempempitem->erro_msg;
                break;

            }
        }

    }

    if($sqlerro==false){

        $sSql = "SELECT c75_codlan, c67_codele from conlancamele inner join conlancamemp on c75_codlan = c67_codlan
                                     inner join conlancamdoc on c71_codlan = c75_codlan
              where c71_coddoc = 1 and c75_numemp = $e60_numemp ";
        $rsSql = db_query($sSql);

        $iNumRows = pg_num_rows($rsSql);
        if(isset($e56_codele) && $e56_codele != ""){
            for($i = 0; $i < $iNumRows; $i++){
                $oRow = db_utils::fieldsMemory($rsSql,$i);
                $sSqlUpdate = "update conlancamele set c67_codele = $e56_codele where c67_codlan = $oRow->c75_codlan ";

                if(db_query($sSqlUpdate)===false){
                    $sqlerro = true;
                    $erro_msg = "Usuário: \\n\\n Itens conlancamele nao Alterado. Alteracao Abortada \\n\\n";
                    break;
                }

            }
        }

    }

    if ($sqlerro==false) {

        try {

            $oEmpenhoFinanceiro = new EmpenhoFinanceiro($e60_numemp);
            $iRecursoDotacao    = $oEmpenhoFinanceiro->getDotacao()->getRecurso();

            if ($iRecursoDotacao == ParametroCaixa::getCodigoRecursoFUNDEB(db_getsession("DB_instit"))) {

                $oEmpenhoFinanceiro->setFinalidadePagamentoFundeb(FinalidadePagamentoFundeb::getInstanciaPorCodigo($e151_codigo));
                $oEmpenhoFinanceiro->salvarFinalidadePagamentoFundeb();
            }

        } catch (Exception $eErro) {

            $sqlerro  = true;
            $erro_msg = $eErro->getMessage();
        }
    }

    if ($sqlerro==false) {
        $result = $clempempenho->sql_record($clempempenho->sql_query($e60_numemp,"e60_anousu,e60_vlrliq"));

        if ( $clempempenho->erro_status == '0' ) {

            $sqlerro = true;
            $erro_msg = $clempempenho->erro_msg;
        } else {
            db_fieldsmemory($result,0);
        }
    }
    
    if ($sqlerro==false) {
        $erro_msg = "Alteração realizada com sucesso!";
    }
    
    /**[Extensao Ordenador Despesa] inclusao_ordenador*/

    db_fim_transacao($sqlerro);
  
    // atualiza o campo do gestor do empenho
    if (isset($e54_gestaut) && isset($e54_autori) && !empty($e54_gestaut)) {
        $sSql = " UPDATE empautoriza SET e54_gestaut = '{$e54_gestaut}' WHERE e54_autori={$e54_autori} AND e54_numcgm={$e60_numcgm} ";
        db_query($sSql);
        if($gestor_alterado === 'true'){
            if(isset($msgCampoAlterado)){
                $msgCampoAlterado .= " - Gestor do Empenho\n";
            }else{
                $msgCampoAlterado = "\n\nCampos alterados: \n";
                $msgCampoAlterado .= " - Gestor do Empenho\n";
            }
        }
    }

} else if(isset($chavepesquisa)) {

    $rsPar = $clempparametro->sql_record($clempparametro->sql_query_file(DB_getsession("DB_anousu")));
    if ( $clempparametro->numrows > 0) {
        db_fieldsmemory($rsPar, 0);
    }
    $db_opcao = 1;
    $result = $clempempenho->sql_record($clempempenho->sql_query($chavepesquisa));
    db_fieldsmemory($result,0);

    $result=$clempemphist->sql_record($clempemphist->sql_query_file($e60_numemp));
    if($clempemphist->numrows>0){
        db_fieldsmemory($result,0);
    }


    $result=$clemppresta->sql_record($clemppresta->sql_query_file(null,"e45_tipo as e44_tipo", null, "e45_numemp = $e60_numemp"));
    if($clemppresta->numrows > 0){
        db_fieldsmemory($result,0);
    }
    $db_botao = true;
}
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/classes/empenho/ViewCotasMensais.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbtextField.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/windowAux.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body style="background-color: #CCCCCC; margin-top:35px;" >

<center>
    <fieldset style="width: 800px;">
        <legend><b>Alteração de Empenho</b></legend>
        <?php require_once (modification::getFile("forms/db_frmempempenhoaltera.php")); ?>
    </fieldset>
</center>
</body>
</html>
<?php
if(isset($alterar)){
    if($sqlerro == true){
        db_msgbox($erro_msg.$msgCampoAlterado);
        if($clempempenho->erro_campo!=""){
            echo "<script> document.form1.".$clempempenho->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clempempenho->erro_campo.".focus();</script>";
        }
    }else{
        db_msgbox($erro_msg);
        db_redireciona('emp1_aba1empempenho002.php');
    }
}


if($db_opcao==22){
    echo "<script>document.form1.pesquisar.click();</script>";
}

if(isset($mensagem)){
    $msg = "Usuário:\\n\\n".$mensagem."\\n\\n";
    db_msgbox($msg);
}
?>
