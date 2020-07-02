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

require_once("fpdf151/scpdf.php");
require_once("fpdf151/impcarne.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_empparametro_classe.php");
require_once("classes/db_pcprocitem_classe.php");
require_once("classes/db_empautitem_classe.php");

require_once ("integracao_externa/ged/GerenciadorEletronicoDocumento.model.php");
require_once ("integracao_externa/ged/GerenciadorEletronicoDocumentoConfiguracao.model.php");
require_once ("libs/exceptions/BusinessException.php");

$oGet = db_utils::postMemory($_GET);
$oConfiguracaoGed = GerenciadorEletronicoDocumentoConfiguracao::getInstance();
if ($oConfiguracaoGed->utilizaGED()) {

    if (empty($oGet->e54_autori_ini) && !empty($oGet->e54_autori)) {
        $oGet->e54_autori_ini = $oGet->e54_autori;
    }

    if (empty($oGet->e54_autori_fim) && !empty($oGet->e54_autori)) {
        $oGet->e54_autori_fim = $oGet->e54_autori;
    }

    if ( !empty($oGet->dtInicial) || !empty($oGet->dtFinal) || $oGet->e54_autori_ini != $oGet->e54_autori_fim) {

        $sMsgErro  = "O parâmetro para utilização do GED (Gerenciador Eletrônico de Documentos) está ativado.<br><br>";
        $sMsgErro .= "Neste não é possível informar interválos de códigos ou datas.<br><br>";
        db_redireciona("db_erros.php?fechar=true&db_erro={$sMsgErro}");
        exit;
    }
}


$clempparametro	= new cl_empparametro;
$clpcprocitem   = new cl_pcprocitem;
$clempautitem = new cl_empautitem;

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//echo($HTTP_SERVER_VARS['QUERY_STRING']); exit;

$sql = "select * from orcparametro where o50_anousu = ".db_getsession("DB_anousu");
$result = db_query($sql);
db_fieldsmemory($result,0);
//echo " [1] " . db_criatabela($result) . "<br>------------------<br>";

$usa_sub = $o50_subelem;

$sqlpref = "select * from db_config where codigo = ".db_getsession("DB_instit");
$resultpref = db_query($sqlpref);
db_fieldsmemory($resultpref,0);
//echo " [2] " . db_criatabela($resultpref). "<br>------------------<br>";
$dbwhere = '1=1 ';

if (isset($e54_autori)) {

    $dbwhere = "   e54_autori  = $e54_autori";

} else if (isset($e54_autori_ini) && $e54_autori_ini != "" || isset($e54_autori_fim) && $e54_autori_fim != "") {

    $dbwhereautori = "";
    if (isset($e54_autori_ini) && $e54_autori_ini != "") {
        $dbwhereautori .= " and  e54_autori>$e54_autori_ini";
    }

    if (isset($e54_autori_fim) && $e54_autori_fim != "") {

        if( trim($dbwhereautori) == "") {
            $dbwhereautori = " and  e54_autori<$e54_autori_fim";
        } else {
            if ($e54_autori_fim != $e54_autori_ini) {
                $dbwhereautori = " and  e54_autori between $e54_autori_ini and  $e54_autori_fim";
            } else {
                $dbwhereautori = " and  e54_autori=$e54_autori_ini ";
            }
        }
    }
    $dbwhere .= $dbwhereautori;

} else if (isset($sDocAutorizacoes) && trim($sDocAutorizacoes) != "") {
    /**
     * Adicionado para recupearar uma STRING já tratada para ser utilizada como IN na busca das autorizações.
     */
    $dbwhere .= " and e54_autori in ({$sDocAutorizacoes}) ";

} else {

    if( isset($dtini_dia) ){
        $dbwhere .= " and e54_emiss>='$dtini_ano-$dtini_mes-$dtini_dia'";
    }
    if( isset($dtfim_dia) ){
        $dbwhere .= " and e54_emiss<='$dtfim_ano-$dtfim_mes-$dtfim_dia'";
    }
}
//$dbwhere .= " and e54_anulad is null";

$sqlmater = "
	select empautoriza.*,
		pc50_descr,
		o58_orgao,
		o40_descr,
		o58_unidade,
		o41_descr,
       		o58_coddot,
              	o56_descr,
		o55_projativ,
		o55_descr,
		o15_codigo,
		o15_descr,
		  orcdotacao.o58_subfuncao,
		  orcdotacao.o58_programa,
		  orcsubfuncao.o53_subfuncao as o53_subfuncao,
		  orcsubfuncao.o53_descr     as o53_descr,
		  orcprograma.o54_programa   as o54_programa,
		  orcprograma.o54_descr      as o54_descr,
		  cgm.*,
		  z01_uf,
      e60_numemp,e60_anousu,e60_codemp,
		  fc_estruturaldotacao(e54_anousu,o58_coddot) as estrutural,
      e54_concarpeculiar,
      c58_descr
	  from empautoriza
        inner join concarpeculiar on concarpeculiar.c58_sequencial = empautoriza.e54_concarpeculiar
	      inner join empautidot on e56_autori=e54_autori

		  inner join orcdotacao 	on  o58_coddot = empautidot.e56_coddot
					  and o58_anousu = e54_anousu
					  and o58_instit = ".db_getsession("DB_instit")."

		  inner join orcsubfuncao on orcsubfuncao.o53_subfuncao = orcdotacao.o58_subfuncao
		  inner join orcprograma  on orcprograma.o54_programa   = orcdotacao.o58_programa and
								     orcprograma.o54_anousu     = orcdotacao.o58_anousu

		  inner join orcorgao 	on  o58_orgao = o40_orgao
					  and o58_anousu = o40_anousu

		  inner join orcunidade 	on  o58_unidade = o41_unidade
					  and o58_orgao = o41_orgao
					  and o58_anousu = o41_anousu

	/*
	  não pode haver projeto atividas com mesmo numero, nao importa a instituição

	 */
		  inner join orcprojativ 	on  o58_projativ = o55_projativ
									  and o58_anousu   = o55_anousu

		  inner join orctiporec 	on  o58_codigo = o15_codigo

		  inner join orcelemento 	on o58_codele = o56_codele
					 and o58_anousu = o56_anousu

		  left join cgm 		on e54_numcgm = z01_numcgm


		  left join empempaut on e61_autori=e54_autori
		  left join empempenho on e61_numemp=e60_numemp

		  inner join pctipocompra on e54_codcom = pc50_codcom

	  where $dbwhere
	  order by e54_autori
	  ";
$result = db_query($sqlmater);

$newResult = $result;
if (pg_numrows($result)==0){
    db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum Registro Encontrado ! ");
    exit;
}else{
    db_fieldsmemory($result,0);

    $sResumo = db_utils::fieldsMemory($result,0)->e54_resumo;

    //echo " [3] " . db_criatabela($result). "<br>------------------<br>";
    //echo $e54_resumo. "<br>";
    if ($e54_anulad!=""){
        db_redireciona("db_erros.php?fechar=true&db_erro=Autorização Anulada !");
        exit;
    }
    $result_item = $clempautitem->sql_record($clempautitem->sql_query_file($e54_autori));
    if ($clempautitem->numrows==0){
        db_redireciona("db_erros.php?fechar=true&db_erro=Autorização Sem Itens !");
        exit;
    }
}



//db_criatabela($result);
//echo $e54_resumo;
//exit;

//rotina que pega o numero de vias
$result02 = $clempparametro->sql_record($clempparametro->sql_query_file(db_getsession("DB_anousu"),"e30_nroviaaut,e30_numdec"));

if($clempparametro->numrows>0){
    db_fieldsmemory($result02,0);
    //echo " [4] " . db_criatabela($result02). "<br>------------------<br>";

}

$pdf = new scpdf();
$pdf->Open();
$pdf1 = new db_impcarne($pdf,'5');
//$pdf1->modelo = 5;
$pdf1->nvias= @$e30_nroviaaut;
$pdf1->objpdf->SetTextColor(0,0,0);
$autorizacoes = array();

for ($i = 0;$i < pg_numrows($newResult);$i++) {
    db_fieldsmemory($newResult, $i);

    $sqlitem = " select distinct (pc01_descrmater||' '||(case when pc11_resum is null then pc01_complmater else pc11_resum end)||' '||(case when l21_codpcprocitem is null and coalesce((select 'Marca'||pc23_obs from pcorcamval
inner join pcorcamitem on pcorcamitem.pc22_orcamitem = pcorcamval.pc23_orcamitem
inner join pcorcamjulgamentologitem on pcorcamjulgamentologitem.pc93_pcorcamitem = pcorcamitem.pc22_orcamitem
inner join pcorcamitemproc on pcorcamitemproc.pc31_orcamitem = pcorcamitem.pc22_orcamitem
inner join pcprocitem on pcprocitem.pc81_codprocitem = pcorcamitemproc.pc31_pcprocitem
inner join empautitempcprocitem on empautitempcprocitem.e73_pcprocitem = pcprocitem.pc81_codprocitem
inner join empautitem on empautitem.e55_autori = empautitempcprocitem.e73_autori and e73_sequen = e55_sequen
inner join pcmater as material on material.pc01_codmater = empautitem.e55_item
where e55_autori=$e54_autori and pc93_pontuacao=1),'') = '' then (coalesce((SELECT DISTINCT (CASE WHEN pc23_obs IS NOT NULL and pc23_obs <> '' THEN 'Marca: '||pc23_obs ELSE pc23_obs END)
FROM empautitem empautiteminter
inner JOIN empautitempcprocitem ON empautiteminter.e55_autori = empautitempcprocitem.e73_autori
AND e73_sequen = e55_sequen
inner JOIN pcprocitem ON pc81_codprocitem = e73_pcprocitem
inner JOIN pcorcamitemproc ON pc81_codprocitem = pc31_pcprocitem
inner JOIN pcorcamitem ON pc22_orcamitem = pc31_orcamitem
inner JOIN pcorcamval ON pc23_orcamitem = pc22_orcamitem
inner JOIN pcorcamjulg ON pc24_orcamitem = pc22_orcamitem and pc23_orcamforne = pc24_orcamforne
WHERE e55_autori=$e54_autori
    and empautiteminter.e55_item = empautitem.e55_item
  AND pc24_pontuacao = 1),''))
else
    coalesce((select 'Marca'||pc23_obs from pcorcamval
inner join pcorcamitem on pcorcamitem.pc22_orcamitem = pcorcamval.pc23_orcamitem
inner join pcorcamjulgamentologitem on pcorcamjulgamentologitem.pc93_pcorcamitem = pcorcamitem.pc22_orcamitem
inner join pcorcamitemproc on pcorcamitemproc.pc31_orcamitem = pcorcamitem.pc22_orcamitem
inner join pcprocitem on pcprocitem.pc81_codprocitem = pcorcamitemproc.pc31_pcprocitem
inner join empautitempcprocitem on empautitempcprocitem.e73_pcprocitem = pcprocitem.pc81_codprocitem
inner join empautitem on empautitem.e55_autori = empautitempcprocitem.e73_autori and e73_sequen = e55_sequen
inner join pcmater as material on material.pc01_codmater = empautitem.e55_item
where e55_autori=$e54_autori and pc93_pontuacao=1),'')
 end)) as pc01_descrmater,
       				   e55_autori,
                       e55_sequen,
		                   e55_marca,
		                   e55_item,
		                   e55_quant,
		                   e55_vltot,
		                   e55_vlrun,
		                   o56_elemento,
		                   o56_descr,
		                   pc81_codproc,
		                   pc11_numero,
                           e56_orctiporec,
                           m61_descr,
		                   (CASE WHEN pc23_obs IS NOT NULL and pc23_obs <> '' THEN 'Marca: ' ELSE '' END)||coalesce(trim(pc23_obs),'') as pc23_obs
	   									 from empautitem
                      		  inner join pcmater        			on pc01_codmater = e55_item
                            inner join orcelemento          on e55_codele    = o56_codele and o56_anousu = " . db_getsession("DB_anousu") . "
                            left join empautitempcprocitem  on empautitempcprocitem.e73_autori = empautitem.e55_autori
                                                           and empautitempcprocitem.e73_sequen = empautitem.e55_sequen
                            inner join matunid on matunid.m61_codmatunid = empautitem.e55_unid
                            left join pcprocitem            on pcprocitem.pc81_codprocitem     = empautitempcprocitem.e73_pcprocitem
                      		  left  join solicitem            on solicitem.pc11_codigo          = pcprocitem.pc81_solicitem
                      		  left  join liclicitem           on liclicitem.l21_codpcprocitem   = pcprocitem.pc81_codprocitem
                      		  left  join pcorcamitemlic       on pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
                      		  left  join pcorcamjulg          on pcorcamjulg.pc24_orcamitem     = pcorcamitemlic.pc26_orcamitem
                      		  														   and pcorcamjulg.pc24_pontuacao     = 1
                      		  left  join pcorcamval     			on pcorcamval.pc23_orcamitem      = pcorcamjulg.pc24_orcamitem
                      		  															 and pcorcamval.pc23_orcamforne     = pcorcamjulg.pc24_orcamforne
                            left  join empautidot     		  on e56_autori                     = e55_autori
	   						 where e55_autori = $e54_autori
	   						   and o56_anousu =" . db_getsession("DB_anousu") . "
	   				  order by e55_sequen,o56_elemento,e55_item
	   					";

    $sqltot = "select sum(e55_vltot) as tot_item from empautitem where e55_autori = $e54_autori";
    $resulttot = db_query($sqltot);
    db_fieldsmemory($resulttot, 0);
    $resultitem = db_query($sqlitem);

    //echo " [6] " . db_criatabela($resulttot). "<br>------------------<br>";

    $sSqlPacto = " SELECT distinct pactoplano.* ";
    $sSqlPacto .= "   from empautitem ";
    $sSqlPacto .= "        inner join empautitempcprocitem       on empautitempcprocitem.e73_autori = empautitem.e55_autori";
    $sSqlPacto .= "                                             and empautitempcprocitem.e73_sequen = empautitem.e55_sequen";
    $sSqlPacto .= "        inner join pcprocitem                 on pcprocitem.pc81_codprocitem     = empautitempcprocitem.e73_pcprocitem";
    $sSqlPacto .= "        inner join solicitem                  on pc81_solicitem                  = pc11_codigo";
    $sSqlPacto .= "        inner join orctiporecconveniosolicita on pc11_numero                     = o78_solicita";
    $sSqlPacto .= "        inner join pactoplano                 on o78_pactoplano                  = o74_sequencial";
    $sSqlPacto .= "  where e55_autori= {$e54_autori}";
    $rsPacto = db_query($sSqlPacto);
    $o74_descricao = null;
    $o78_pactoplano = null;
    if (pg_num_rows($rsPacto) > 0) {

        //echo " [7] " . db_criatabela($rsPacto). "<br>------------------<br>";

        $oPacto = db_utils::fieldsMemory($rsPacto, 0);
        $o74_descricao = $oPacto->o74_descricao;
        $o78_pactoplano = $oPacto->o74_sequencial;
    }

    /**
     * Busca o processo
     */
    $oDaoEmpAutorizaProcesso = db_utils::getDao("empautorizaprocesso");
    $sWhereBuscaProcessoAdmin = " e150_empautoriza = {$e54_autori}";
    $sSqlBuscaProcessoAdmin = $oDaoEmpAutorizaProcesso->sql_query_file(null, "e150_numeroprocesso", null, $sWhereBuscaProcessoAdmin);
    $rsBuscaProcessoAdmin = $oDaoEmpAutorizaProcesso->sql_record($sSqlBuscaProcessoAdmin);
    $sProcessoAdministrativo = "";

    if ($rsBuscaProcessoAdmin && $oDaoEmpAutorizaProcesso->numrows > 0) {
        $sProcessoAdministrativo = db_utils::fieldsMemory($rsBuscaProcessoAdmin, 0)->e150_numeroprocesso;
    }

    $pdf1->subfuncao = $o53_subfuncao;
    $pdf1->logo = $logo;
    $pdf1->descr_subfuncao = $o53_descr;
    $pdf1->programa = $o54_programa;
    $pdf1->descr_programa = $o54_descr;
    $pdf1->casadec = @$e30_numdec;
    $pdf1->usa_sub = $usa_sub;
    $pdf1->prefeitura = $nomeinst;
    $pdf1->enderpref = trim($ender) . "," . $numero;
    $pdf1->municpref = $munic;
    $pdf1->telefpref = $telef;
    $pdf1->cgcpref = $cgc;
    $pdf1->emailpref = $email;
    $pdf1->numaut = $e54_autori;
    $pdf1->numcgm = $e54_numcgm;
    $pdf1->nome = $z01_nome;
    $pdf1->telefone = $z01_telef;
    $pdf1->ender = $z01_ender . ', ' . $z01_numero;
    $pdf1->munic = $z01_munic;
    $pdf1->ufFornecedor = $z01_uf;
    $pdf1->dotacao = $estrutural;
    $pdf1->recurso = $o15_codigo;
    $pdf1->descr_recurso = $o15_descr;
    $pdf1->projativ = $o55_projativ;
    $pdf1->descr_projativ = $o55_descr;
    $pdf1->descrdotacao = $o56_descr;
    $pdf1->numsol = $e54_numsol;
    $pdf1->coddot = $o58_coddot;
    $pdf1->destino = $e54_destin;
    $pdf1->prazo_ent = $e54_praent;
    $pdf1->obs = $e54_entpar;
    $pdf1->cond_pag = $e54_conpag;
    $pdf1->out_cond = $e54_codout;
    $pdf1->contato = $z01_contato;
    $pdf1->telef_cont = $e54_telef;
    $pdf1->SdescrPacto = $o74_descricao;
    $pdf1->iPlanoPacto = $o78_pactoplano;
    $pdf1->cod_concarpeculiar = $e54_concarpeculiar;
    $pdf1->descr_concarpeculiar = $c58_descr;
    $pdf1->valtotal = $tot_item;
    $pdf1->recorddositens = $resultitem;
    $pdf1->linhasdositens = pg_numrows($resultitem);
    $pdf1->item = 'e55_item';
    $pdf1->quantitem = 'e55_quant';
    $pdf1->valoritem = 'e55_vltot';
    $pdf1->valor = 'e55_vlrun';
    $pdf1->descricaoitem = 'pc01_descrmater';
    $pdf1->unidadeitem = 'm61_descr';
    $pdf1->marca = 'e55_marca';
    $pdf1->processoadministrativo = $sProcessoAdministrativo;
    $pdf1->numero = $z01_numero;
    $pdf1->bairro = $z01_bairro;
    $pdf1->fax = $z01_fax;
    $pdf1->cep = $z01_cep;
    $pdf1->compl = $z01_compl;
    $pdf1->orgao = $o58_orgao;
    $pdf1->descr_orgao = $o40_descr;
    $pdf1->unidade = $o58_unidade;
    $pdf1->descr_unidade = $o41_descr;
    $pdf1->emissao = $e54_emiss;
    $pdf1->emissaoextenso = db_dataextenso(db_strtotime($e54_emiss));
    $pdf1->dataatual = db_dataextenso(db_strtotime(db_getsession("DB_datausu")));
    $pdf1->resumo_item = "e55_descr";

    $result_licita = $clempautitem->sql_record($clempautitem->sql_query_lic(null, null, "distinct l20_edital, l20_numero, l20_anousu, l20_objeto,l03_descr", null, "e55_autori = $e54_autori "));

    if ($clempautitem->numrows > 0) {
        db_fieldsmemory($result_licita, 0);
        $pdf1->edital_licitacao = $l20_edital . '/' . $l20_anousu;
        $pdf1->ano_licitacao = $l20_anousu;
        $pdf1->modalidade = $l20_numero . '/' . $l20_anousu;
        $resumo_lic = $l20_objeto;
        $pdf1->observacaoitem = "pc23_obs";
    }

    /**
     * Crio os campos PROCESSO/ANO,MODALIDADE/ANO e DESCRICAO MODALIDADE de acordo com solicitação
     * @MarioJunior OC 7425
     */

    //tipo Direta
    if($e54_tipoautorizacao == 1) {
        $result_empaut = $clempautitem->sql_record($clempautitem->sql_query_processocompras(null, null, "distinct e54_numerl,e54_nummodalidade,e54_anousu", null, "e55_autori = $e54_autori "));
        if ($clempautitem->numrows > 0) {
            db_fieldsmemory($result_empaut, 0);
            $arr_numerl = split("/", $e54_numerl);
            $pdf1->edital_licitacao = $arr_numerl[0].'/'.$arr_numerl[1];
            $pdf1->modalidade = $e54_nummodalidade.'/'.$arr_numerl[1];
        }
        $pdf1->descr_tipocompra = $pc50_descr;
        $pdf1->descr_modalidade = '';
    }

    //tipo licitacao de outros orgaos

    if($e54_tipoautorizacao == 2){
        $result_empaut = $clempautitem->sql_record($clempautitem->sql_query_processocompras(null, null, "distinct e54_numerl,e54_nummodalidade,e54_anousu", null, "e55_autori = $e54_autori "));
        if ($clempautitem->numrows > 0) {
            db_fieldsmemory($result_empaut, 0);
            $arr_numerl = split("/", $e54_numerl);
            $pdf1->edital_licitacao = $arr_numerl[0].'/'.$arr_numerl[1];
            $pdf1->modalidade = $e54_nummodalidade.'/'.$arr_numerl[1];
        }
        $pdf1->descr_tipocompra = substr($pc50_descr,0,36);
        $pdf1->descr_modalidade = '';
    }

    //tipo licitacao
    if($e54_tipoautorizacao == 3){
        $sqlLic = "select l20_codigo,l20_numero,l20_anousu,l20_edital from empautoriza
				inner join liclicita on l20_codigo = e54_codlicitacao
				where e54_autori = {$e54_autori}";
				$result_empaut = db_query($sqlLic);

        if ($result_empaut != 0) {
            db_fieldsmemory($result_empaut, 0);
            $pdf1->edital_licitacao = $l20_edital.'/'.$l20_anousu;
            $pdf1->modalidade = $l20_numero.'/'.$l20_anousu;
        }
        $pdf1->descr_tipocompra = $pc50_descr;
        $pdf1->descr_modalidade = '';
    }

    //tipo Adesao regpreco
    if($e54_tipoautorizacao == 4){
        $result_empaut = $clempautitem->sql_record($clempautitem->sql_query_processocompras(null, null, "distinct e54_numerl,e54_nummodalidade,e54_anousu", null, "e55_autori = $e54_autori "));
        if ($clempautitem->numrows > 0) {
            db_fieldsmemory($result_empaut, 0);
            $arr_numerl = split("/", $e54_numerl);
            $pdf1->edital_licitacao = $arr_numerl[0].'/'.$arr_numerl[1];
            $pdf1->modalidade = $e54_nummodalidade.'/'.$arr_numerl[1];
        }
        $pdf1->descr_tipocompra = $pc50_descr;
        $pdf1->descr_modalidade = '';
    }

    $sSql = "SELECT ac16_numero, ac16_anousu FROM acordo where ac16_numeroprocesso like '%".$pdf1->edital_licitacao."'";
    $rsSql = db_query($sSql);

    $oAcordo = db_utils::fieldsMemory($rsSql, 0);

    $pdf1->acordo = $oAcordo->ac16_numero;
    $pdf1->anoacordo = $oAcordo->ac16_anousu;

    if (isset($resumo_lic)&&$resumo_lic!=""){
        if (isset($e54_resumo) && trim($e54_resumo) != ""){
            $pdf1->resumo     = trim($e54_resumo);//trim($sResumo);
        } else {
            $pdf1->resumo     = trim($resumo_lic);
        }

    } else {

        if (isset($e54_resumo) && trim($e54_resumo) != "") {
            $pdf1->resumo = trim($e54_resumo);
        } else {
            $pdf1->resumo = trim($sResumo);
        }

        $pdf1->observacaoitem  = 'e55_descr';
    }

    //$pdf1->resumo  = substr(str_replace("\n", " ", $pdf1->resumo), 0, 400);
    $pdf1->resumo  = substr($pdf1->resumo, 0, 400);

        // autorização manual
        // seleciona o tipo de licitação
        $rpc = db_query("select l03_descr from cflicita inner join liclicita on l20_codtipocom=l03_codigo where l03_codcom=$e54_codcom and l03_tipo='$e54_tipol'");
        if (pg_numrows($rpc) > 0 ){
            $result = pg_result($rpc,0,0);

            if($e54_tipoautorizacao == 2 || $e54_tipoautorizacao == 4){
                $pdf1->descr_licitacao = '';
            }else {
                $pdf1->descr_licitacao = pg_result($rpc, 0, 0);
            }
        }

    $pdf1->cnpj            = $z01_cgccpf;
    $pdf1->analitico       = "o56_elemento";
    $pdf1->descr_analitico = "o56_descr";
    $pdf1->Snumeroproc     = "pc81_codproc";
    $pdf1->Snumero         = "pc11_numero";
    if(!empty($e60_numemp))
        $pdf1->Scodemp         = trim($e60_codemp)."/$e60_anousu";
    else
        $pdf1->Scodemp         = "";

    if(!isset($informa_adic) || trim($informa_adic)=="" || $informa_adic == null){
        $informa_adic = "AM";
    }

    $pdf1->informa_adic = $informa_adic;
    $pdf1->imprime();
}

if(isset($argv[1])){
    $pdf1->objpdf->Output("/tmp/teste.pdf");
}else{

    if ($oConfiguracaoGed->utilizaGED()) {

        try {

            if (!empty($oGet->e54_autori)) {
                $e54_autori_ini = $oGet->e54_autori;
            }

            $sTipoDocumento = GerenciadorEletronicoDocumentoConfiguracao::AUTORIZACAO_EMPENHO;
            $oGerenciador   = new GerenciadorEletronicoDocumento();
            $oGerenciador->setLocalizacaoOrigem("tmp/");
            $oGerenciador->setNomeArquivo("{$sTipoDocumento}_{$e54_autori_ini}.pdf");

            $oStdDadosGED        = new stdClass();
            $oStdDadosGED->nome  = $sTipoDocumento;
            $oStdDadosGED->tipo  = "NUMERO";
            $oStdDadosGED->valor = $e54_autori_ini;
            $pdf1->objpdf->Output("tmp/{$sTipoDocumento}_{$e54_autori_ini}.pdf");
            $oGerenciador->moverArquivo(array($oStdDadosGED));

        } catch (Exception $eErro) {
            db_redireciona("db_erros.php?fechar=true&db_erro=".$eErro->getMessage());
        }
    } else {
        $pdf1->objpdf->Output();
    }
}
