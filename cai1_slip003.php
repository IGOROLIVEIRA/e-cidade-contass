<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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
require_once("classes/db_saltes_classe.php");
require_once("fpdf151/assinatura.php");


$clsaltes = new cl_saltes;

parse_str(base64_decode($HTTP_SERVER_VARS['QUERY_STRING']));

$motivo = "";
// Dados
$classinatura = new cl_assinatura;

if (USE_PCASP) {

    $sql = "select k152_sequencial,
                 upper(k152_descricao) as k152_descricao,
                 slip.*,
                 cgm.z01_numcgm ,
                 cgm.z01_nome ,
                 cgm.z01_cgccpf,
                 c50_codhist as db_hist,
                 c50_descr   as descr_hist,
                 k18_motivo,
                 coalesce(k18_codigo,0)  as k18_codigo,
                 contador.z01_nome as contador,
                 contad.si166_crccontador as crc,
                 db_usuarios.nome,
                 controleinterno.z01_nome as controleinterno,
                 ordenapagamento.z01_nome as ordenapagamento,
                 case when
                   k153_slipoperacaotipo not in (1, 2, 9, 10, 13, 14)
                     then
                       case when
                         k153_slipoperacaotipo in (5, 6)
                           then saltes_debito.k13_descr
                         else conta_debito.c60_descr end
                   else conta_debito.c60_descr end as descr_debito,
                 case when
                   k153_slipoperacaotipo in (1, 2, 5, 6, 9, 10, 13, 14)
                     then saltes_credito.k13_descr
                   else conta_credito.c60_descr end as descr_credito,
                   conplanoconta_cred.c63_banco as banco_credito,
                   conplanoconta_cred.c63_agencia||'-'||conplanoconta_cred.c63_dvagencia as agencia_credito,
                   conplanoconta_cred.c63_conta||'-'||conplanoconta_cred.c63_dvconta as conta_credito,
                   conplanoconta_deb.c63_banco as banco_debito,
                   conplanoconta_deb.c63_agencia||'-'||conplanoconta_deb.c63_dvagencia as agencia_debito,
                   conplanoconta_deb.c63_conta||'-'||conplanoconta_deb.c63_dvconta as conta_debito,
                   case
                   when conplanoconta_cred.c63_codcon is not null AND recurso.k29_recurso is not null then recurso.k29_recurso:: text
                   when conplanoconta_cred.c63_codcon is not null then reduz_credito.c61_codigo :: text
                   else ''
               end as fonte_credito,
               case
                   when conplanoconta_deb.c63_codcon is not null AND recurso.k29_recurso is not null then recurso.k29_recurso:: text
                   when conplanoconta_deb.c63_codcon is not null then reduz_debito.c61_codigo :: text
                   else ''
               end as fonte_debito
            from slip
                 left join db_usuarios on db_usuarios.id_usuario = slip.k17_id_usuario
                 left join sliptipooperacaovinculo         on sliptipooperacaovinculo.k153_slip = slip.k17_codigo
                 left join sliptipooperacao                on sliptipooperacaovinculo.k153_slipoperacaotipo = sliptipooperacao.k152_sequencial
                 left join slipanul                        on slip.k17_codigo          = slipanul.k18_codigo
                 left join slipnum                         on slip.k17_codigo          = slipnum.k17_codigo
                 left join cgm                             on slipnum.k17_numcgm       = cgm.z01_numcgm
                 left join conhist                         on slip.k17_hist             = conhist.c50_codhist

                 left join conplanoreduz as reduz_debito   on slip.k17_debito          = reduz_debito.c61_reduz
                                                          and reduz_debito.c61_instit  = ".db_getsession('DB_instit')."
                                                          and reduz_debito.c61_anousu  = ".db_getsession("DB_anousu")."
                 left join conplano as conta_debito        on reduz_debito.c61_codcon  = conta_debito.c60_codcon
                                                          and conta_debito.c60_anousu  = ".db_getsession("DB_anousu")."
                 left join saltes saltes_debito            on slip.k17_debito          = saltes_debito.k13_reduz
                 left join conplanoreduz as reduz_credito  on slip.k17_credito           = reduz_credito.c61_reduz
                                                          and reduz_credito.c61_instit  = ".db_getsession('DB_instit')."
                                                          and reduz_credito.c61_anousu  = ".db_getsession("DB_anousu")."
                 left join conplano as conta_credito       on reduz_credito.c61_codcon  = conta_credito.c60_codcon
                                                          and conta_credito.c60_anousu  = ".db_getsession("DB_anousu")."
                 left join conplanoconta as conplanoconta_deb   on conplanoconta_deb.c63_codcon = conta_debito.c60_codcon and conplanoconta_deb.c63_anousu = ".db_getsession("DB_anousu")."
                 left join conplanoconta AS conplanoconta_cred  on conplanoconta_cred.c63_codcon = conta_credito.c60_codcon and conplanoconta_cred.c63_anousu = ".db_getsession("DB_anousu")."
                 left join saltes saltes_credito           on slip.k17_credito          = saltes_credito.k13_reduz
                 left join identificacaoresponsaveis contad on contad.si166_instit= k17_instit and contad.si166_tiporesponsavel=2
                 and ".db_getsession("DB_anousu")." BETWEEN DATE_PART('YEAR',contad.si166_dataini) AND DATE_PART('YEAR',contad.si166_datafim)
                 and contad.si166_dataini <= k17_data
                 and contad.si166_datafim >= k17_data
                 left join cgm as contador on contador.z01_numcgm = contad.si166_numcgm
                 left join identificacaoresponsaveis controle on controle.si166_instit= k17_instit and controle.si166_tiporesponsavel=3
                 and ".db_getsession("DB_anousu")." BETWEEN DATE_PART('YEAR',controle.si166_dataini) AND DATE_PART('YEAR',controle.si166_datafim)
                 and controle.si166_dataini <= k17_data
                 and controle.si166_datafim >= k17_data
                 left join sliprecurso recurso on recurso.k29_slip = slip.k17_codigo AND k29_valor = slip.k17_valor
                 left join cgm as controleinterno on controleinterno.z01_numcgm = controle.si166_numcgm
                 left join identificacaoresponsaveis ordenador on ordenador.si166_instit= k17_instit and ordenador.si166_tiporesponsavel=1
                 and ".db_getsession("DB_anousu")." BETWEEN DATE_PART('YEAR',ordenador.si166_dataini) AND DATE_PART('YEAR',ordenador.si166_datafim)
                 left join cgm as ordenapagamento on ordenapagamento.z01_numcgm = ordenador.si166_numcgm
            WHERE k17_instit = " . db_getsession('DB_instit');
        // Condição da OC14441
        if ($numslip)
            $sql .= " AND slip.k17_codigo = {$numslip} ";
        if ($numslip_de)
            $sql .= " AND slip.k17_codigo BETWEEN {$numslip_de} AND {$numslip_ate} ";
        if ($dtini)
            $sql .= " AND slip.k17_data >= '" . date("Y-m-d", strtotime($dtini)) . "' ";
        if ($dtfim)
            $sql .= " AND slip.k17_data <= '" . date("Y-m-d", strtotime($dtfim)) . "' ";
        if ($listacgm)
            $sql .= " AND cgm.z01_numcgm IN ({$listacgm}) ";
        $sql .= " ORDER BY slip.k17_codigo ";
} else {
    $sql = "select slip.*,
          z01_cgccpf,
          z01_numcgm ,
          z01_nome ,
          c60_descr as descr_debito,
          p2.k13_descr as descr_credito,
          c50_codhist as db_hist,
          c50_descr as descr_hist,
          k18_motivo,
          coalesce(k18_codigo,0) as k18_codigo
          from slip
          left outer join slipanul    on slip.k17_codigo = slipanul.k18_codigo
          left outer join slipnum     on slip.k17_codigo = slipnum.k17_codigo
          left outer join cgm     on slipnum.k17_numcgm = cgm.z01_numcgm
          left outer join conplanoreduz   on slip.k17_debito = c61_reduz and
          c61_instit     = ".db_getsession('DB_instit')." and
          c61_anousu = ".db_getsession("DB_anousu")."
          left outer join conplano  on c61_codcon = c60_codcon and
          c60_anousu = ".db_getsession("DB_anousu")."
          left outer join saltes p2   on slip.k17_credito = p2.k13_reduz
          left outer join conhist     on slip.k17_hist = conhist.c50_codhist
          where k17_instit = ".db_getsession('DB_instit');
    // Condição da OC14441
    if ($numslip)
        $sql .= " AND slip.k17_codigo = {$numslip} ";
    if ($numslip_de)
        $sql .= " AND slip.k17_codigo BETWEEN {$numslip_de} AND {$numslip_ate} ";
    if ($dtini)
        $sql .= " AND slip.k17_data >= '" . date("Y-m-d", strtotime($dtini)) . "' ";
    if ($dtfim)
        $sql .= " AND slip.k17_data <= '" . date("Y-m-d", strtotime($dtfim)) . "' ";
    if ($listacgm)
        $sql .= " AND cgm.z01_numcgm IN ({$listacgm}) ";
    $sql .= " ORDER BY slip.k17_codigo ";
}

try {

    $dados = db_query($sql);
    $sEvento = "";

    if (pg_numrows($dados) > 0){

        $aMotivo = db_fieldsMemory($dados,0);
        $motivo  = $k18_motivo;
        if (USE_PCASP) {
            $sEvento = $k152_sequencial . " - " . $k152_descricao;
        }
    }

    // seleciona os recursos envolvidos, ligados a conta recebedora do slip
    $sql = "select k29_recurso,
                 o15_descr,
                 k29_valor
          from sliprecurso
        inner join orctiporec on o15_codigo = k29_recurso";
    // Condição da OC14441
    if ($numslip)
        $sql .= " where k29_slip = {$numslip} ";
    if ($numslip_de)
        $sql .= " where k29_slip BETWEEN {$numslip_de} AND {$numslip_ate} ";
    $sql .= "order by k29_recurso";

    $recursos  = db_query($sql);
    // se houverem registros, monta um array
    $array_recursos =  array();
    if (pg_numrows($recursos)>0){
        for($x=0;$x < pg_numrows($recursos);$x++){
            db_fieldsmemory($recursos,$x);
            $array_recursos[] = "$k29_recurso#$o15_descr#$k29_valor";
        }

    }
    // print_r($array_recursos); exit;

    if (pg_numrows($dados) == 0) {
        db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado!");
    }
    db_fieldsmemory($dados,0);

    $sqlcai = "select * from caiparametro where k29_instit = ".db_getsession('DB_instit');
    $resultcai = db_query($sqlcai) or die($sqlcai);
    if (pg_numrows($resultcai) == 0) {
        $k29_modslipnormal = 36;
        $k29_modsliptransf = 36;
    } else {
        db_fieldsmemory($resultcai, 0);
        if ($k29_modslipnormal != 36 and $k29_modslipnormal != 37 and $k29_modslipnormal != 381) {
            $k29_modslipnormal = 36;
        }
        if ($k29_modsliptransf != 36 and $k29_modsliptransf != 37 and $k29_modslipnormal != 381) {
            $k29_modsliptransf = 36;
        }
    }

    $quantdeb = 0;
    if ($k17_debito > 0) {
        $clsaltes->sql_record($clsaltes->sql_query_file($k17_debito));
        $quantdeb = $clsaltes->numrows;
    }

    $quantcre = 0;
    if ($k17_credito > 0) {
        $clsaltes->sql_record($clsaltes->sql_query_file($k17_credito));
        $quantcre = $clsaltes->numrows;
    }

    if ($quantdeb > 0 and $quantcre > 0) {
        $codmodelo = $k29_modsliptransf;
    } else {
        $codmodelo = $k29_modslipnormal;
    }

    // Criando o pdf do modelo
    $pdf1 = new scpdf();
    $pdf1->Open();

    $pdf = new db_impcarne($pdf1, $codmodelo);
    $pdf->objpdf->SetTextColor(0, 0, 0);
    $pdf->objpdf->AddPage();

    // trecho para relatorio
    $head1 = "Texto numero 1";
    $head2 = "Texto numero 2";
    $head3 = "Texto numero 3";
    $head4 = "Texto numero 4";
    //$head5 = "Texto numero 5";
    $head6 = "Texto numero 6";
    $head7 = "Texto numero 7";
    $head8 = "Texto numero 8";
    $head9 = "Texto numero 9";
    $head10 = "Texto numero 10";
    // trecho para relatorio

    $sql = "select * from db_config where codigo = ".db_getsession('DB_instit');
    $dadospref = db_query($sql);
    db_fieldsmemory($dadospref, 0);

    $pdf->dados    = $dados;
    $pdf->recursos = $array_recursos;

    /**
     * dados bancarios do credor
     */
    $iCpfCnpjCredor       = $z01_numcgm;
    $oDaoPcfornecon      = db_utils::getDao('pcfornecon');
    $sCamposDadosCredor  = "pc63_banco, pc63_agencia, pc63_agencia_dig, pc63_conta, pc63_conta_dig,";
    $sCamposDadosCredor  .= "(select db90_descr from db_bancos where db90_codban = pc63_banco) as descricrao_banco, ";
    $sCamposDadosCredor  .= "pc64_contabanco";
    $sWhereDadosCredor   = "pc63_numcgm = {$iCpfCnpjCredor} ";
    $sWhereDadosCredor   .= "ORDER BY pc64_contabanco ";
    $sSqlDadosCredor     = $oDaoPcfornecon->sql_query_padrao(null, $sCamposDadosCredor, null, $sWhereDadosCredor);
    $rsDadosCredor       = db_query($sSqlDadosCredor);

    /**
     * Erro no sql
     */
    if (!$rsDadosCredor) {
        $sMensagemErro = "Erro ao buscar dados do credor.\n\n" . pg_last_error();
        throw new Exception($sMensagemErro);
    }

    /**
     * Dados bancarios da conta padrao
     */
    if (pg_num_rows($rsDadosCredor) > 0) {
        $oDadosCredor         = db_utils::fieldsMemory($rsDadosCredor, 0);
        $oDadosBancarioCredor = new StdClass();

        $oDadosBancarioCredor->iBanco         = $oDadosCredor->pc63_banco;
        $oDadosBancarioCredor->sBanco         = $oDadosCredor->descricrao_banco;
        $oDadosBancarioCredor->iAgencia       = $oDadosCredor->pc63_agencia;
        $oDadosBancarioCredor->iAgenciaDigito = $oDadosCredor->pc63_agencia_dig;
        $oDadosBancarioCredor->iConta         = $oDadosCredor->pc63_conta;
        $oDadosBancarioCredor->iContaDigito   = $oDadosCredor->pc63_conta_dig;

        $pdf->oDadosBancarioCredor = $oDadosBancarioCredor;
    }

    /**
     * assinturas
     */
    $tes =  "______________________________"."\n"."Secretário de Fazenda";
    $pdf->tesoureiro      = $classinatura->assinatura(1004,$tes);

    $pdf->ordenapagamento =  $ordenapagamento;
    $pdf->contador        = $contador;
    $pdf->crc             = $crc;
    $pdf->controleinterno = $controleinterno;

    /*OC4401*/
    $pdf->usuario = $nome;
    /*FIM - OC4401*/
    
    $pdf->logo     = $logo;
    $pdf->nomeinst = $nomeinst;
    $pdf->ender    = $ender;
    $pdf->munic    = $munic;
    $pdf->telef    = $telef;
    $pdf->email    = $email;
    $pdf->logo     = $logo;
    $pdf->motivo   = $motivo;
    $pdf->sEvento  = $sEvento;

    $pdf->objpdf->AliasNbPages();
    $pdf->imprime();
    $pdf->objpdf->Output();

} catch (Exception $oErro) {
    $sErro = str_replace("\n", '\n', $oErro->getMessage());

    $sMensagemErro .= "<script>                                 ";
    $sMensagemErro .= "  alert('{$sErro}'); ";
    $sMensagemErro .= "  window.close();                        ";
    $sMensagemErro .= "</script>                                ";

    echo $sMensagemErro;
}
