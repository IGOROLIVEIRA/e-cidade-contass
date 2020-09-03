<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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

require("fpdf151/pdf.php");
include("classes/db_empageordem_classe.php");
include("classes/db_empagenotasordem_classe.php");
include("libs/db_utils.php");
include("fpdf151/assinatura.php");
$classinatura = new cl_assinatura;

$oGet  = db_utils::postMemory($_GET);
if ($oGet->iAgenda == "" && $oGet->dtAutorizacao == "") {
    db_redireciona('db_erros.php?fechar=true&db_erro=Filtros não Informados');
}
$oDaoOrdemAuxiliar = new cl_empageordem();

$sWhere = "";
if ($oGet->iAgenda != "") {
    $sWhere .= " e42_sequencial = {$oGet->iAgenda}";
}
if (isset($oGet->dtAutorizacao) && $oGet->dtAutorizacao != "") {

    $dtAutorizacao = implode("-", array_reverse(explode("/",$oGet->dtAutorizacao)));
    if ($sWhere != "") {
        $sWhere .= " and ";
    }
    $sWhere  .= " e42_dtpagamento = '{$dtAutorizacao}'";
}

$sSqlDadosOrdem    = $oDaoOrdemAuxiliar->sql_query(null,"*","e42_dtpagamento", $sWhere);
$rsDadosOrdem      = $oDaoOrdemAuxiliar->sql_record($sSqlDadosOrdem);
$oDaoOrdem         = new cl_empagenotasordem;
if ($oDaoOrdemAuxiliar->numrows == 0) {
    db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum pagamento autorizado para a Agenda {$oGet->iAgenda}");
}
$oPdf  = new PDF("L","mm","A4");
$oPdf->Open();
$oPdf->SetAutoPageBreak(0,1);


$head2     = "ORDEM AUXILIAR DE PAGAMENTO";
if ($oDaoOrdemAuxiliar->numrows > 0) {

    for ($i = 0; $i < $oDaoOrdemAuxiliar->numrows; $i++) {

        $lNovo           = true;
        $oOrdemAuxiliar  = db_utils::fieldsMemory($rsDadosOrdem, $i);

        $j         = 0;
        $head3     = "Autorização nº:  ".$oOrdemAuxiliar->e42_sequencial;
        $head4     = "Pagamentos autorizados para:  ".db_formatar($oOrdemAuxiliar->e42_dtpagamento, 'd');
        $sWhere    = "e43_ordempagamento = {$oOrdemAuxiliar->e42_sequencial}";
        $sSqlOrdem = $oDaoOrdem->sql_query_empenho(null,
            "
                                       e50_obs, k17_hist,

( e60_vlremp - coalesce((select sum(saldo) as outrasordens from (select *,e53_valor - e53_vlranu as saldo from pagordemele inner join pagordem po on po.e50_codord = pagordemele.e53_codord inner join empempenho on empempenho.e60_numemp = po.e50_numemp inner join orcelemento on orcelemento.o56_codele = pagordemele.e53_codele and orcelemento.o56_anousu = empempenho.e60_anousu inner join empelemento on empelemento.e64_numemp = empempenho.e60_numemp and orcelemento.o56_codele = empelemento.e64_codele where po.e50_codord <> pagordem.e50_codord and po.e50_numemp = pagordem.e50_numemp) as x),0) - e53_valor + (e53_vlranu - e60_vlranu) ) as valorrestante,

                                       e60_codemp||'/'||e60_anousu as e60_codemp,
                                       e69_numero,
                                       e83_conta,
                                       e83_descr,
                                       e50_codord,
                                       e96_descr,
                                       case when e49_numcgm is null then cgmemp.z01_nome else cgmordem.z01_nome end as z01_nome,
                                       case when e49_numcgm is null then cgmemp.z01_cgccpf else cgmordem.z01_cgccpf end as z01_cgccpf,
                                       e50_data,
                                       fc_valorretencaomov(e81_codmov,false) as vlrretencao,
                                       e43_valor,
                                       e53_valor - e53_vlranu as e53_valor,
                                       k17_valor,
                                       slip.k17_codigo,
                                       cgmslip.z01_nome as nomeslip,
                                       slipnum.k17_numcgm,
                                       cgmslip.z01_cgccpf as cgccpfslip,
                                       k17_texto,
                                       k17_data",
            "e50_codord,
                                       slip.k17_codigo",
            $sWhere
        );
        $rsOrdem = $oDaoOrdem->sql_record($sSqlOrdem);
        //echo $sSqlOrdem;exit;

        $sFonte  = "arial";
        if ($oDaoOrdem->numrows > 0) {

            $nValorAutorizado = 0;
            $nValorLiquido    = 0;
            $nValorBruto      = 0;
            $nValorRetido     = 0;
            $aMovimentos      = db_utils::getColectionByRecord($rsOrdem);
            foreach($aMovimentos as $oMovimento) {

                $rsRetencoes = $oDaoOrdem->sql_record("SELECT retencaopagordem.*,
                                                                   e23_valorretencao,
                                                                   e21_receita,
                                                                   e21_descricao
                                                            FROM retencaopagordem
                                                            JOIN retencaoreceitas ON e23_retencaopagordem = e20_sequencial
                                                            JOIN retencaotiporec ON e23_retencaotiporec = e21_sequencial
                                                            WHERE e20_pagordem = $oMovimento->e50_codord and e23_ativo = 't'");

                $aRetencoes  = db_utils::getColectionByRecord($rsRetencoes);

                if ($oPdf->Gety() > $oPdf->h - 25 || $lNovo) {

                    $oPdf->AddPage();
                    $oPdf->SetFont($sFonte, "B",8);
                    $oPdf->SetFillColor("245");
                    $oPdf->cell(15,5,"OP/Slip","TBR",0,"C");
                    $oPdf->cell(23,5,"Emissão da OP","TBR",0,"C");
                    $oPdf->cell(20,5,"Nota Fiscal","TBR",0,"C");
                    $oPdf->cell(23,5,"CNPJ/CPF","TBR",0,"C");
                    $oPdf->cell(75,5,"Nome do Credor","TBR",0,"C");
                    $oPdf->cell(35,5,"Cta. Pag","TBR",0,"C");
                    $oPdf->cell(15,5,"Forma","TBR",0,"C");
                    $oPdf->cell(18,5,"Valor da OP	","TBR",0,"C");
                    $oPdf->cell(18,5,"Retencao","TBR",0,"C");
                    $oPdf->cell(18,5,"Vlr Liquido","TBR",1,"C");
                    //$oPdf->cell(18,5,"Vlr Aut.","TBL",1,"C");
                    $oPdf->cell(20,5,"Empenho","TBR",0,"C");
                    $oPdf->cell(30,5,"Valor Restante","TBR",0,"C");
                    $oPdf->cell(110,5,"Descrição OP/SLIP","TBR",0,"C");
                    $oPdf->cell(100,5,"REC.                                       Dados das Retenções                                Valor","TBR",1,"C");
                    $oPdf->SetFont($sFonte, "",6);
                    $lNovo = false;
                    $j = 0;

                }
                if ($j % 2 == 0) {
                    $iPreencher = 0;
                } else {
                    $iPreencher = 0;
                }
                $sCpfCgc = "";
                if (strlen($oMovimento->z01_cgccpf) == 14) {
                    $sCpfCgc = db_formatar($oMovimento->z01_cgccpf,"cnpj");
                } else if (strlen($oMovimento->z01_cgccpf) == 11) {
                    $sCpfCgc = db_formatar($oMovimento->z01_cgccpf,"cpf");
                }

                if ($oMovimento->e60_codemp == "") {

                    $oMovimento->e53_valor       = $oMovimento->k17_valor;
                    $oMovimento->e50_codord      = $oMovimento->k17_codigo;
                    $oMovimento->z01_nome        = $oMovimento->nomeslip;
                    $oMovimento->e60_codemp      = "slip";
                    $oMovimento->e50_data        = $oMovimento->k17_data;
                    $oMovimento->e50_obs         =  $oMovimento->k17_texto;
                    $sCpfCgc               =  mask($oMovimento->cgccpfslip,'##.###.###/####-##');

                }


                $oPdf->cell(15, 4,$oMovimento->e50_codord  , 0,0,"R", $iPreencher);
                $oPdf->cell(23, 4,db_formatar($oMovimento->e50_data,"d")   , 0, 0, "C", $iPreencher);

                $oPdf->cell(20, 4,$oMovimento->e69_numero, 0,0,"C",$iPreencher);

                $oPdf->cell(23, 4,$sCpfCgc , 0,0,"L",$iPreencher);
                $oPdf->cell(75, 4,substr($oMovimento->z01_nome,0,35)  , 0,0,"L",$iPreencher);
                $oPdf->cell(35, 4,substr($oMovimento->e83_conta." - ".$oMovimento->e83_descr,0,25), 0,0,"L",$iPreencher);
                $oPdf->cell(15, 4,$oMovimento->e96_descr , 0, 0, "C", $iPreencher);
                $oPdf->cell(18, 4,db_formatar($oMovimento->e53_valor,"f"), 0,0,"R",$iPreencher);
                $oPdf->cell(18, 4,db_formatar($oMovimento->vlrretencao,"f"),0,0,"R",$iPreencher);
                $oPdf->cell(18, 4,db_formatar($oMovimento->e43_valor-$oMovimento->vlrretencao,"f"),0,1,"R",$iPreencher);

                $subgrupo = $oMovimento->e50_obs;
                if (strlen($subgrupo) > 112) {
                    $aSubgrupo = quebrar_texto($subgrupo,112);
                    $alt_novo = count($aSubgrupo);
                } else {
                    $alt_novo = 4;
                }

                $oPdf->cell(20, 4, $oMovimento->e60_codemp, 0, 0, "C", $iPreencher);
                if($oMovimento->valorrestante != "") {
                    $oPdf->cell(30, 4, db_formatar($oMovimento->valorrestante, "f"), 0, 0, "C", $iPreencher);
                }else{
                    $oPdf->cell(30, 4, '', 0, 0, "C", $iPreencher);
                }
                if (strlen($subgrupo) > 110) {
                    $pos_x = $oPdf->x;
                    $pos_y = $oPdf->y;
                    foreach ($aSubgrupo as $subgrupo_novo) {
                        $oPdf->cell(110,$alt_novo,substr($subgrupo_novo,0,110),0,1,"L",$iPreencher);
                        $oPdf->x=$pos_x;
                    }
                    $oPdf->x = $pos_x+110;
                } else {
                    $oPdf->cell(110,$alt_novo,substr($subgrupo,0,110),0,0,"L",$iPreencher);
                }

                for ($y = 0; $y <= count($aRetencoes); $y++) {
                    if ($y == 0) {
                        $oPdf->cell(87, 4, $aRetencoes[$y]->e21_receita . '                                        ' . $aRetencoes[$y]->e21_descricao, 0, 0, "L", $iPreencher);
                        if($aRetencoes[$y]->e23_valorretencao != ""){
                            $oPdf->cell(13, 4, db_formatar($aRetencoes[$y]->e23_valorretencao,"f"), 0, 1, "L",$iPreencher);
                        }else{
                            $oPdf->cell(13, 4,$aRetencoes[$y]->e23_valorretencao, 0, 1, "L",$iPreencher);
                        }
                    }else{
                        $oPdf->x = $oPdf->GetX()+160;
                        $oPdf->cell(87, 4, $aRetencoes[$y]->e21_receita . '                                        ' . $aRetencoes[$y]->e21_descricao, 0, 0, "L", $iPreencher);
                        if($aRetencoes[$y]->e23_valorretencao != ""){
                            $oPdf->cell(13, 4, db_formatar($aRetencoes[$y]->e23_valorretencao,"f"), 0, 1, "L",$iPreencher);
                        }else{
                            $oPdf->cell(13, 4,'', 0, 1, "L",$iPreencher);
                        }
                    }
                }


                //$oPdf->cell(18, 4,db_formatar($oMovimento->e43_valor,"f"), 0,1,"R",$iPreencher);
                $nValorAutorizado += $oMovimento->e43_valor;
                $nValorLiquido    += $oMovimento->e43_valor - $oMovimento->vlrretencao;
                $nValorBruto      += $oMovimento->e53_valor;
                $nValorRetido     += $oMovimento->vlrretencao;
                $j++;
            }
            $oPdf->Ln();

            $oPdf->SetFont($sFonte, "B",8);
            $oPdf->cell(55,(4), "Total de Registros: {$oDaoOrdem->numrows}","TBR",0,"L");
            $oPdf->cell(151,(4),"Totais "  , "TBR",0,"R");
            $oPdf->cell(18 ,(4), db_formatar($nValorBruto,"f") , "TBL",0,"R");
            $oPdf->cell(18 ,(4), db_formatar($nValorRetido,"f") , "TBL",0,"R");
            $oPdf->cell(18 ,(4), db_formatar($nValorLiquido,"f") , "TBL",0,"R");
            //$oPdf->cell(18 , 4, db_formatar($nValorAutorizado,"f") , "TBL",0,"R");
        }
    }
}

$oPdf->setfont('arial', '', 7);


if ($oPdf->gety() > ($oPdf->h - 40)) {
    $oPdf->addpage();
}
$oPdf->setfont('arial', '', 8);
$largura = ( $oPdf->w ) / 4;
$oPdf->ln(20);

$pos = $oPdf->gety();


$ass_admin = $classinatura->assinatura_nova(9001,"",'188');
$ass_div   = $classinatura->assinatura_nova(9001,"",'187');
$ass_pres  = $classinatura->assinatura_nova(9001,"",'189');
$ass_sec   = $classinatura->assinatura_nova(9001,"",'1');

$oPdf->setxy(20,$pos);
$oPdf->multicell(50,4,"$ass_sec","T","C",0,0);
$oPdf->setxy($largura+20,$pos);
$oPdf->multicell(50,4,"$ass_pres","T","C",0,0);
$oPdf->setxy($largura+85,$pos);
$oPdf->multicell(50,4,"$ass_div","T","C",0,0);
$oPdf->setxy($largura+150,$pos);
$oPdf->multicell(50,4,"$ass_admin","T","C",0,0);

$oPdf->Output();

function quebrar_texto($texto,$tamanho){

    $aTexto = explode(" ", $texto);
    $string_atual = "";
    foreach ($aTexto as $word) {
        $string_ant = $string_atual;
        $string_atual .= " ".$word;
        if (strlen($string_atual) > $tamanho) {
            $aTextoNovo[] = $string_ant;
            $string_ant   = "";
            $string_atual = $word;
        }
    }
    $aTextoNovo[] = $string_atual;
    return $aTextoNovo;

}

function  mask($val, $mask)
{
    $maskared = '';
    $k = 0;
    for($i = 0; $i<=strlen($mask)-1; $i++)
    {
        if($mask[$i] == '#')
        {
            if(isset($val[$k]))
                $maskared .= $val[$k++];
        }
        else
        {
            if(isset($mask[$i]))
                $maskared .= $mask[$i];
        }
    }
    return $maskared;
}

?>