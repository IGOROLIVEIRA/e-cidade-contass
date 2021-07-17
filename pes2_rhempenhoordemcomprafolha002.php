<?
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

require_once("fpdf151/scpdf.php");
require_once("fpdf151/impcarne.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_pagordem_classe.php");
require_once("classes/db_pagordemele_classe.php");
require_once("model/retencaoNota.model.php");
require_once("classes/db_empautitem_classe.php");
require_once("classes/db_empagetipo_classe.php");
require_once("classes/db_pcforneconpad_classe.php");
require_once("classes/db_empempitem_classe.php");
require_once("classes/db_cgmalt_classe.php");

require_once("classes/db_emite_nota_liq.php");
require_once("classes/db_emite_nota_empenho.php");

$clpagordem         = new cl_pagordem;
$clpagordemele      = new cl_pagordemele;
$clempautitem       = new cl_empautitem;
$clempagetipo       = new cl_empagetipo;
$clcgmalt           = new cl_cgmalt;
$cldb_pcforneconpad = new cl_pcforneconpad;
$clempempitem       = new cl_empempitem;

$clemite_nota_liq   = new cl_emite_nota_liq;
$clemite_nota_emp   = new cl_emite_nota_empenho;

$oGet       = db_utils::postMemory($_GET);
$iInstit    = db_getsession("DB_instit");
$iAnoUso    = db_getsession('DB_anousu');

if (isset($oGet->sEmpenhosGerados) && $oGet->sEmpenhosGerados != '') {
    $sWhere = " e60_numemp in ({$oGet->sEmpenhosGerados}) and e60_anousu = {$iAnoUso}";
}

$sqlpref    = "select * from db_config where codigo = {$iInstit}";
$resultpref = db_query($sqlpref);
db_fieldsmemory($resultpref,0);

$pdf = new scpdf();
$pdf->Open();
$pdfOrdemPagamento = new db_impcarne($pdf,'7');
$pdfOrdemPagamento->objpdf->SetTextColor(0,0,0);

$pdfEmpenho = new db_impcarne($pdf, '6');
$pdfEmpenho->objpdf->SetTextColor(0,0,0);

$sCampos        = 'e50_codord, e71_codnota, e60_numemp, e60_codemp';
$sSqlPagordem   = $clpagordem->sql_query_notaliquidacao('', $sCampos,' e50_codord ', $sWhere);
$result         = $clpagordem->sql_record($sSqlPagordem);

if ($clpagordem->numrows == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não foi possível encontrar a Ordem de Pagamento. Verifique!');
}

$result2 = db_query("select * from empparametro where e39_anousu = {$iAnoUso}");

if (pg_numrows($result2) > 0) {
    
    db_fieldsmemory($result2,0);
    $pdfOrdemPagamento->nvias = $e30_nroviaord;
    $pdfEmpenho->nvias = $e30_nroviaemp;
    $pdfEmpenho->casadec = $e30_numdec;
    $pdfEmpenho->dadosbancoemprenho = $e30_dadosbancoempenho;

}

for ($i = 0;$i < pg_numrows($result); $i++) {

    //Inicia impressão da ordem de pagamento
    db_fieldsmemory($result,$i);

    $oRetencaoNota = new retencaoNota($e71_codnota);
    $oRetencaoNota->setINotaLiquidacao($e50_codord);

    $sqlOrdem   = $clemite_nota_liq->get_sql_ordem_pagamento($iInstit, $iAnoUso, $e50_codord);
    $resultord  = db_query($sqlOrdem);

    if (pg_numrows($resultord) == 0) continue;

    db_fieldsmemory($resultord,0);

    $sqlordass      = $clemite_nota_liq->get_sql_assinaturas($e50_codord);
    $resultordass   = db_query($sqlordass);
    db_fieldsmemory($resultordass,0);

    $sqlitem    = $clemite_nota_liq->get_sql_item_ordem($e50_codord);  
    $resultitem = db_query($sqlitem);

    $sqloutrasordens    = $clemite_nota_liq->get_sql_outras_ordens($e50_codord, $e50_numemp);
    $resultoutrasordens = db_query($sqloutrasordens);
    db_fieldsmemory($resultoutrasordens,0);

    $aRetencoes = $oRetencaoNota->getRetencoesFromDB($e50_codord, false, 0, "","",true);

    $sqlfornecon        = $clemite_nota_liq->get_sql_fornecedor($z01_cgccpf);
    $result_pcfornecon  = db_query($sqlfornecon);
    
    if (pg_numrows($result_pcfornecon) > 0) {
        db_fieldsmemory($result_pcfornecon,0);
    }

    if ($o41_cnpj != "" && $o41_cnpj!= $cgc) {

        $nomeinst = $o41_descr;
        $cgc      = $o41_cnpj;

    }

    $sSqlFuncaoOrdenaPagamento                  = $clemite_nota_liq->get_sql_funcao_ordena_pagamento($z01_cgccpf);    
    $pdfOrdemPagamento->cargoordenapagamento    = db_utils::fieldsMemory(db_query($sSqlFuncaoOrdenaPagamento),0)->cargoordenapagamento;

    $sSqlFuncaoOrdenadespesa                = $clemite_nota_liq->get_sql_funcao_ordena_despesa($cgmordenadespesa);    
    $pdfOrdemPagamento->cargoordenadespesa  = db_utils::fieldsMemory(db_query($sSqlFuncaoOrdenadespesa),0)->cargoordenadespesa;

    $sSqlFuncaoLiquida                  = $clemite_nota_liq->get_sql_funcao_ordena_liquida($cgmliquida);
    $pdfOrdemPagamento->cargoliquida    = db_utils::fieldsMemory(db_query($sSqlFuncaoLiquida),0)->cargoliquida; 

    $pdfOrdemPagamento->usuario = $usuario;

    //assinaturas
    $pdfOrdemPagamento->ordenadespesa       = $assindsp;
    $pdfOrdemPagamento->liquida             = $assinlqd;
    $pdfOrdemPagamento->ordenapagamento     = $assinord;
    $pdfOrdemPagamento->contador            = $contador;
    $pdfOrdemPagamento->crccontador         = $crc;
    $pdfOrdemPagamento->controleinterno     = $controleinterno;

    $pdfOrdemPagamento->numeronota          = $e69_numero;
    $pdfOrdemPagamento->datanota            = $e69_dtnota;
    $pdfOrdemPagamento->valor_ordem         = '';
    $pdfOrdemPagamento->logo                = $logo;
    $pdfOrdemPagamento->processo            = $processo;
    $pdfOrdemPagamento->prefeitura          = $nomeinst;
    $pdfOrdemPagamento->enderpref           = $ender;
    $pdfOrdemPagamento->municpref           = $munic;
    $pdfOrdemPagamento->telefpref           = $telef;
    $pdfOrdemPagamento->emailpref           = $email;
    $pdfOrdemPagamento->cgcpref             = $cgc;
    $pdfOrdemPagamento->banco               = $pc63_banco;
    $pdfOrdemPagamento->agencia             = $pc63_agencia;
    $pdfOrdemPagamento->agenciadv           = $pc63_agencia_dig;
    $pdfOrdemPagamento->conta               = $pc63_conta;
    $pdfOrdemPagamento->tipoconta           = $pc63_tipoconta;
    $pdfOrdemPagamento->contadv             = $pc63_conta_dig;
    $pdfOrdemPagamento->numcgm              = $z01_numcgm;
    $pdfOrdemPagamento->nome                = $z01_nome;
    $pdfOrdemPagamento->cnpj                = $z01_cgccpf;
    $pdfOrdemPagamento->ender               = $z01_ender;
    $pdfOrdemPagamento->bairro              = $z01_bairro;
    $pdfOrdemPagamento->cep                 = $z01_cep;
    $pdfOrdemPagamento->ufFornecedor        = $z01_uf;
    $pdfOrdemPagamento->munic               = $z01_munic;
    $pdfOrdemPagamento->ordpag              = $e50_codord;
    $pdfOrdemPagamento->coddot              = $o58_coddot;
    $pdfOrdemPagamento->dotacao             = $estrutural;
    $pdfOrdemPagamento->outrasordens        = $outrasordens;
    $pdfOrdemPagamento->recorddositens      = $resultitem;
    $pdfOrdemPagamento->ano		            = $e60_anousu;
    $pdfOrdemPagamento->linhasdositens      = pg_numrows($resultitem);
    $pdfOrdemPagamento->elementoitem        = "o56_elemento";
    $pdfOrdemPagamento->descr_elementoitem  = "o56_descr";
    $pdfOrdemPagamento->vlremp              = "e53_valor";
    $pdfOrdemPagamento->vlranu              = "e53_vlranu";
    $pdfOrdemPagamento->vlrpag              = "e53_vlrpag";
    $pdfOrdemPagamento->vlrsaldo            = "saldo";
    $pdfOrdemPagamento->saldo_final         = "saldo_final";
    $pdfOrdemPagamento->aRetencoes          = $aRetencoes;
    $pdfOrdemPagamento->orcado	            = $e60_vlrorc;
    $pdfOrdemPagamento->saldo_ant           = $e60_salant;
    $pdfOrdemPagamento->empenhado           = $e60_vlremp;
    $pdfOrdemPagamento->empenho_anulado     = $e60_vlranu;
    $pdfOrdemPagamento->numemp              = $e60_codemp.'/'.$e60_anousu;
    $pdfOrdemPagamento->orgao               = $o58_orgao;
    $pdfOrdemPagamento->descr_orgao         = $o40_descr;
    $pdfOrdemPagamento->unidade             = $o58_unidade;
    $pdfOrdemPagamento->descr_unidade       = $o41_descr;
    $pdfOrdemPagamento->funcao              = $o58_funcao;
    $pdfOrdemPagamento->descr_funcao        = $o52_descr;
    $pdfOrdemPagamento->subfuncao           = $o58_subfuncao;
    $pdfOrdemPagamento->descr_subfuncao     = $o53_descr;
    $pdfOrdemPagamento->programa            = $o58_programa;
    $pdfOrdemPagamento->descr_programa      = $o54_descr;
    $pdfOrdemPagamento->projativ            = $o58_projativ;
    $pdfOrdemPagamento->descr_projativ      = $o55_descr;
    $pdfOrdemPagamento->recurso             = $o58_codigo;
    $pdfOrdemPagamento->descr_recurso       = $o15_descr;
    $pdfOrdemPagamento->elemento     	    = $o56_elemento;
    $pdfOrdemPagamento->descr_elemento      = $o56_descr;
    $pdfOrdemPagamento->obs		            = substr($e50_obs,0,300);
    $pdfOrdemPagamento->emissao             = db_formatar($e50_data,'d');
    $pdfOrdemPagamento->texto		        = db_getsession("DB_login").'  -  '.date("d-m-Y",db_getsession("DB_datausu")).'    '.db_hora(db_getsession("DB_datausu"));
    $pdfOrdemPagamento->telef               = $z01_telef;
    $pdfOrdemPagamento->fax                 = $z01_numero;

    /**
    * Variáveis utilizadas na assinatura. Sómente utilizada na impressão por movimento
    */
    $pdfOrdemPagamento->iReduzido         = "";
    $pdfOrdemPagamento->sContaContabil    = "";
    $pdfOrdemPagamento->sBanco            = "";
    $pdfOrdemPagamento->sAgencia          = "";
    $pdfOrdemPagamento->sDigtoAgencia     = "";
    $pdfOrdemPagamento->sContaBanco       = "";
    $pdfOrdemPagamento->sDigitoContaBanco = "";
    $pdfOrdemPagamento->iTipoPagamento    = "";
    $pdfOrdemPagamento->sCheque           = "";
    $pdfOrdemPagamento->sAutenticacao     = "";
    $pdfOrdemPagamento->nValorMovimento   = "";

    if ($clpagordem->numrows == 1 && isset($valor_ordem)) {

   	    if( $valor_ordem > pg_result($resultitem,0,"saldo") ){
            $valor_ordem = pg_result($resultitem,0,"saldo");
        }

        $pdfOrdemPagamento->valor_ordem  = "$valor_ordem";
        if (isset($historico) && trim($historico)!= "") {
            $pdfOrdemPagamento->obs = "$historico";
        } else {
            $pdfOrdemPagamento->obs = "$e50_obs";
        }
    } else {

   	    $pdfOrdemPagamento->valor_ordem = "";
   	    $pdfOrdemPagamento->obs 		= "$e50_obs";

    }

    if (in_array($e54_tipoautorizacao, array('0','1','2','3','4'))) {

        $oAutoriza = $clemite_nota_liq->get_dados_licitacao($e54_tipoautorizacao, $e54_autori);

        $pdfOrdemPagamento->processo         = $oAutoriza->processo;
        $pdfOrdemPagamento->descr_tipocompra = $oAutoriza->descr_tipocompra;

    }   

    if ($e50_contapag != '') {

        $sCampos            = " e83_conta, e83_descr, c63_agencia, c63_dvagencia, c63_conta, c63_dvconta ";
        $sWhere             = " e83_codtipo = {$e50_contapag} ";
        $sSqlContaPagadora  = $clempagetipo->sql_query_conplanoconta(null, $sCampos, null, $sWhere);
        $rsContaPagadora    = $clempagetipo->sql_record($sSqlContaPagadora);

        if ($clempagetipo->numrows > 0) {
            
            db_fieldsmemory($rsContaPagadora, 0);
            $pdfOrdemPagamento->conta_pagadora_reduz     = $e83_conta;
            $pdfOrdemPagamento->conta_pagadora_agencia   = "{$c63_agencia}-{$c63_dvagencia}";
            $pdfOrdemPagamento->conta_pagadora_conta     = "{$c63_conta}-{$c63_dvconta} {$e83_descr}";

        }
    }

    $pdfOrdemPagamento->imprime();
    //Finaliza impressão da ordem de pagamento

    //Inicia impressão do empenho
    $sSqlPcFornecOnPad  = $cldb_pcforneconpad->sql_query(null, "*", null, "pc63_numcgm = {$e60_numcgm}");
    $rsSqlPcFornecOnPad = $cldb_pcforneconpad->sql_record($sSqlPcFornecOnPad);

    if (!$rsSqlPcFornecOnPad == false && $cldb_pcforneconpad->numrows > 0) {
        $oPcFornecOnPad     = db_utils::fieldsMemory($rsSqlPcFornecOnPad,0);
    } else {

        $oPcFornecOnPad = new stdClass();
        $oPcFornecOnPad->pc63_banco       = '';
        $oPcFornecOnPad->pc63_agencia     = '';
        $oPcFornecOnPad->pc63_agencia_dig = '';
        $oPcFornecOnPad->pc63_conta       = '';
        $oPcFornecOnPad->pc63_conta_dig   = '';
    }

    $sSqlPacto  = $clemite_nota_emp->get_sql_pacto($e61_autori);
    $rsPacto    = db_query($sSqlPacto);

    $o74_descricao       = null;
    $o78_pactoplano      = null;
    
    if (@pg_num_rows($rsPacto) > 0) {

        $oPacto              = db_utils::fieldsMemory($rsPacto, 0);
        $o74_descricao       = $oPacto->o74_descricao;
        $o78_pactoplano      = $oPacto->o74_sequencial;
    }

    $sProcessoAdministrativo = $clemite_nota_emp->get_sql_processo_administrativo($e61_autori);

    $sqlitem    = $clemite_nota_emp->get_sql_item("1 as tipos, ", $e60_numemp);
    $resultitem = db_query($sqlitem);

    $result_cgmalt = $clcgmalt->sql_record($clcgmalt->sql_query_file(null,"z05_numcgm as z01_numcgm,z05_nome as z01_nome,z05_telef as z01_telef,z05_ender as z01_ender,z05_numero as z01_numero,z05_munic as z01_munic,z05_cgccpf as z01_cgccpf,z05_cep as z01_cep"," abs(z05_data_alt - date '$e60_emiss') asc, z05_sequencia desc limit 1","z05_numcgm = $z01_numcgm and z05_data_alt > '$e60_emiss' "));
    
    if ($clcgmalt->numrows > 0) {
        db_fieldsmemory($result_cgmalt,0);
    }

    /**
     * Verificamos o cnpj da unidade. caso diferente de null, e diferente do xcnpj da instituição,
     * mostramos a descrição e o cnpj da unidade
     */
    if ($o41_cnpj != "" && $o41_cnpj != $cgc) {
        $nomeinst = $o41_descr;
        $cgc      = $o41_cnpj;
    }

    $sSqlFuncaoOrdenaPagamento = $clemite_nota_emp->get_sql_funcao_ordena_pagamento($cgmpaga, 
                                                                                    date( 'Y',strtotime($e60_emiss)), 
                                                                                    date('m',strtotime($e60_emiss)));

    $pdfEmpenho->cargoordenapagamento = db_utils::fieldsMemory(db_query($sSqlFuncaoOrdenaPagamento),0)->cargoordenapagamento;

    $sSqlFuncaoOrdenadespesa = $clemite_nota_emp->get_sql_funcao_ordena_despesa($cgmordenadespesa,
                                                                                date( 'Y',strtotime($e60_emiss)),
                                                                                date( 'm',strtotime($e60_emiss)));

    $pdfEmpenho->cargoordenadespesa = db_utils::fieldsMemory(db_query($sSqlFuncaoOrdenadespesa),0)->cargoordenadespesa;

    //assinaturas
    $pdfEmpenho->ordenadespesa          = $ordenadesp;
    $pdfEmpenho->liquida                = $liquida;
    $pdfEmpenho->ordenapagamento        = $ordenapaga;
    $pdfEmpenho->contador               = $contador;
    $pdfEmpenho->crccontador            = $crc;
    $pdfEmpenho->controleinterno        = $controleinterno;
    $pdfEmpenho->emptipo                = $e41_descr;
    $pdfEmpenho->prefeitura             = $nomeinst;
    $pdfEmpenho->enderpref              = $ender.", ".$numero;
    $pdfEmpenho->cgcpref                = $cgc;
    $pdfEmpenho->municpref              = $munic;
    $pdfEmpenho->telefpref              = $telef;
    $pdfEmpenho->emailpref              = $email;
    
    $pdfEmpenho->inscricaoestadualinstituicao       = '';
    if ($db21_usasisagua == 't') {
        $pdfEmpenho->inscricaoestadualinstituicao   = "- Inscrição Estadual: ".$inscricaoestadualinstituicao;
    }

    $pdfEmpenho->numcgm                 = $z01_numcgm;
    $pdfEmpenho->nome                   = $z01_nome;
    $pdfEmpenho->telefone               = $z01_telef;
    $pdfEmpenho->ender                  = $z01_ender;
    $pdfEmpenho->bairro                 = $z01_bairro;
    $pdfEmpenho->munic                  = $z01_munic;
    $pdfEmpenho->cnpj                   = $z01_cgccpf;
    $pdfEmpenho->cep                    = $z01_cep;
    $pdfEmpenho->ufFornecedor           = $z01_uf;
    $pdfEmpenho->prazo_entrega          = $e54_praent;
    $pdfEmpenho->condicao_pagamento     = $e54_conpag;
    $pdfEmpenho->outras_condicoes       = $e54_codout;
    $pdfEmpenho->iBancoFornecedor       = $oPcFornecOnPad->pc63_banco;
    $pdfEmpenho->iAgenciaForncedor      = $oPcFornecOnPad->pc63_agencia."-".$oPcFornecOnPad->pc63_agencia_dig;
    $pdfEmpenho->iContaForncedor        = $oPcFornecOnPad->pc63_conta."-".$oPcFornecOnPad->pc63_conta_dig;
    $pdfEmpenho->dotacao                = $estrutural;
    $pdfEmpenho->solicitacao            = $pc10_numero;
    $pdfEmpenho->num_licitacao          = $e60_numerol;
    $pdfEmpenho->cod_concarpeculiar     = $e60_concarpeculiar;
    $pdfEmpenho->descr_concarpeculiar   = substr($c58_descr,0,34);
    $pdfEmpenho->logo                   = $logo;
    $pdfEmpenho->SdescrPacto            = $o74_descricao;
    $pdfEmpenho->iPlanoPacto            = $o78_pactoplano;
    $pdfEmpenho->contrapartida          = $e56_orctiporec;
    $pdfEmpenho->observacaoitem         = "pc23_obs";
    $pdfEmpenho->Snumeroproc            = "pc81_codproc";
    $pdfEmpenho->Snumero                = "pc11_numero";
    $pdfEmpenho->marca                  = "e55_marca";
    $pdfEmpenho->processo_administrativo = $sProcessoAdministrativo;
    $pdfEmpenho->coddot                 = $o58_coddot;
    $pdfEmpenho->destino                = $e60_destin;
    $pdfEmpenho->licitacao              = $e60_codtipo;
    $pdfEmpenho->recorddositens         = $resultitem;
    $pdfEmpenho->linhasdositens         = pg_numrows($resultitem);
    //Zera as variáveis
    $pdfEmpenho->resumo = "";
    $resumo_lic   = "";

    $result_licita = $clempautitem->sql_record($clempautitem->sql_query_lic(null, null, "distinct l20_edital, l20_numero, l20_anousu, l20_objeto,l03_descr", null, "e55_autori = $e54_autori "));

    if ($clempautitem->numrows > 0) {
        db_fieldsmemory($result_licita, 0);
        $pdfEmpenho->edital_licitacao = $l20_edital . '/' . $l20_anousu;
        $pdfEmpenho->ano_licitacao = $l20_anousu;
        $pdfEmpenho->modalidade = $l20_numero . '/' . $l20_anousu;
        $resumo_lic = $l20_objeto;
        $pdfEmpenho->observacaoitem = "pc23_obs";
    }


    if (isset($resumo_lic) && $resumo_lic!=""){
        if ($e30_impobslicempenho=='t') {
            $pdfEmpenho->resumo = $resumo_lic."\n".$e60_resumo;
        } else {
            $pdfEmpenho->resumo = $e60_resumo;
        }
    } else {
        $pdfEmpenho->resumo = $e60_resumo;
    }


    $Sresumo = $pdfEmpenho->resumo;
    $vresumo = split("\n",$Sresumo);

    if (count($vresumo) > 1){
        $Sresumo   = "";
        $separador = "";
        for ($x = 0; $x < count($vresumo); $x++){
            if (trim($vresumo[$x]) != ""){
                $separador = ". ";
                $Sresumo  .= $vresumo[$x].$separador;
            }
        }
    }

    if (count($vresumo) == 0){
        $Sresumo = str_replace("\n",". ",$Sresumo);
    }

    $Sresumo = str_replace("\r","",$Sresumo);

    $pdfEmpenho->resumo = substr($Sresumo,0,730);

    if (in_array($e54_tipoautorizacao, array('0','1','2','3','4'))) {

        $oAutoriza = $clemite_nota_emp->get_dados_licitacao($e54_tipoautorizacao, $e54_autori);

        $pdfEmpenho->edital_licitacao = $oAutoriza->edital_licitacao;
        $pdfEmpenho->modalidade       = $oAutoriza->modalidade;
        $pdfEmpenho->resumo           = $oAutoriza->resumo;
        $pdfEmpenho->descr_tipocompra = $oAutoriza->descr_tipocompra;
        $pdfEmpenho->descr_modalidade = $oAutoriza->descr_modalidade;

    }

    $oAcordo = $clemite_nota_emp->get_acordo($e60_numemp);

    $pdfEmpenho->resumo  = substr($pdfEmpenho->resumo, 0, 730);

    if (!empty($e54_praent)) {
        $pdfEmpenho->prazo_ent              = $e54_praent;
    }else{
        $pdfEmpenho->prazo_ent              = db_utils::fieldsMemory($resultitem, 0)->l20_prazoentrega;
    }

    $pdfEmpenho->quantitem        = "e62_quant";
    $pdfEmpenho->valoritem        = "e62_vltot";
    $pdfEmpenho->valor            = "e62_vlrun";
    $pdfEmpenho->descricaoitem    = "pc01_descrmater";
    $pdfEmpenho->complmater       = "pc01_complmater";

    $pdfEmpenho->orcado	            = $e60_vlrorc;
    $pdfEmpenho->saldo_ant        = $e60_salant;
    $pdfEmpenho->empenhado        = $e60_vlremp;
    $pdfEmpenho->numemp           = $e60_numemp;
    $pdfEmpenho->usuario          = $nome;
    $pdfEmpenho->codemp           = $e60_codemp;
    $pdfEmpenho->numaut           = $e61_autori;
    $pdfEmpenho->orgao            = $o58_orgao;
    $pdfEmpenho->descr_orgao      = $o40_descr;
    $pdfEmpenho->unidade          = $o58_unidade;
    $pdfEmpenho->descr_unidade    = $o41_descr;
    $pdfEmpenho->funcao           = $o58_funcao;
    $pdfEmpenho->descr_funcao     = $o52_descr;
    $pdfEmpenho->subfuncao        = $o58_subfuncao;
    $pdfEmpenho->descr_subfuncao  = $o53_descr;
    $pdfEmpenho->programa         = $o58_programa;
    $pdfEmpenho->descr_programa   = $o54_descr;
    $pdfEmpenho->projativ         = $o58_projativ;
    $pdfEmpenho->descr_projativ   = $o55_descr;
    $pdfEmpenho->analitico        = "o56_elemento";
    $pdfEmpenho->descr_analitico  = "o56_descr";
    $pdfEmpenho->sintetico        = $sintetico;
    $pdfEmpenho->descr_sintetico  = $descr_sintetico;
    $pdfEmpenho->recurso          = $o58_codigo;
    $pdfEmpenho->descr_recurso    = $o15_descr;
    $pdfEmpenho->banco            = null;
    $pdfEmpenho->agencia          = null;
    $pdfEmpenho->conta            = null;
    $pdfEmpenho->tipos            = $tipos;
    $pdfEmpenho->numero           = $z01_numero;
    $pdfEmpenho->marca            = 'e55_marca';
    $pdfEmpenho->acordo           = $oAcordo->ac16_numeroacordo;
    $pdfEmpenho->anoacordo        = $oAcordo->ac16_anousu;

    $sql  = "select c61_codcon
              from conplanoreduz
                   inner join conplano on c60_codcon = c61_codcon and c60_anousu=c61_anousu
                   inner join consistema on c52_codsis = c60_codsis
             where c61_instit   = ".db_getsession("DB_instit")."
               and c61_anousu   =".db_getsession("DB_anousu")."
               and c61_codigo   = $o58_codigo
               and c52_descrred = 'F' ";
    $result_conta = db_query($sql);

    if ($result_conta != false && (pg_numrows($result_conta) == 1)) {

        db_fieldsmemory($result_conta,0);
        $sqlconta     = "select * from conplanoconta where c63_codcon = $c61_codcon and c63_anousu = ".db_getsession("DB_anousu");
        $result_conta = db_query($sqlconta);

        if (pg_result($result_conta,0) == 1) {

            db_fieldsmemory($result_conta,0);
            $pdfEmpenho->banco   = $c63_banco;
            $pdfEmpenho->agencia = $c63_agencia;
            $pdfEmpenho->conta   = $c63_conta;
        }
    }

    $pdfEmpenho->emissao = db_formatar($e60_emiss,'d');
    $pdfEmpenho->texto   = "";
    $pdfEmpenho->imprime();

    //Finaliza impressão do empenho
}

$pdf->Output();

?>