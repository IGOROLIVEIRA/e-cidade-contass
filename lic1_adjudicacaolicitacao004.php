    <?php
    require_once 'model/relatorios/Relatorio.php';
    include("classes/db_db_docparag_classe.php");
    include("classes/homologacaoadjudica_classe.php");
    include("libs/db_libdocumento.php");
    include("classes/db_liclicita_classe.php");
    include("classes/db_liccomissaocgm_classe.php");
    include("classes/db_db_config_classe.php");
    include("classes/db_db_documento_classe.php");


    $clhomologacaoadjudica = new cl_homologacaoadjudica();
    $clliclicita =  new cl_liclicita();
    $clliccomissaocgm     = new cl_liccomissaocgm();
    $cldb_config          = new cl_db_config();
    $cldb_documento          = new cl_db_documento();

    include("fpdf151/pdf.php");
    require("libs/db_utils.php");
    $oGet = db_utils::postMemory($_GET);
    parse_str($HTTP_SERVER_VARS['QUERY_STRING']);  
    db_postmemory($HTTP_POST_VARS);

    $result = $cldb_documento->sql_record($cldb_documento->sql_query("","*","","db03_descr like 'ADJUDICACAO RELATORIO'"));
    $result1 = db_utils::fieldsMemory($result, 0);

    $oPDF = new PDF();
    $oPDF->Open();
    $oPDF->AliasNbPages();
    $total = 0;
    $oPDF->setfillcolor(235);
    $oPDF->setfont('arial','b',8);
    $oPDF->setfillcolor(235);
    $troca    = 1;
    $alt      = 4;
    $total    = 0;
    $p        = 0;
    $valortot = 0;
    $cor      = 0;
    $dbinstit = db_getsession("DB_instit");

    $oLibDocumento = new libdocumento($result1->db03_tipodoc,null);

    switch ($oGet->tipoprecoreferencia) {
        case '2':
            $tipoReferencia = " MAX(pc23_vlrun) ";
            break;

        case '3':
            $tipoReferencia = " MIN(pc23_vlrun) ";
            break;

        default:
            $tipoReferencia = " (sum(pc23_vlrun)/count(pc23_orcamforne)) ";
            break;
    } 

    $rsLotes = db_query("select distinct  pc68_sequencial,pc68_nome
                        from
                            pcproc
                        join pcprocitem on
                            pc80_codproc = pc81_codproc
                        left join processocompraloteitem on
                            pc69_pcprocitem = pcprocitem.pc81_codprocitem
                        left join processocompralote on
                            pc68_sequencial = pc69_processocompralote
                        where
                            pc80_codproc = {$codigo_preco}
                            and pc68_sequencial is not null
                            order by pc68_sequencial asc");


    $rsResultado = db_query("select pc80_criterioadjudicacao from pcproc where pc80_codproc = {$codigo_preco}");
    $criterio    = db_utils::fieldsMemory($rsResultado, 0)->pc80_criterioadjudicacao;
    $sCondCrit   = ($criterio == 3 || empty($criterio)) ? " AND pc23_valor <> 0 " : "";


    $oLinha = null;

    $sWhere  = " db02_descr like 'ADJUDICACAO RELATORIO' ";
    //$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSÁVEL PELA DECLARAÇÃO DE RECURSOS FINANCEIROS' ";
    $sWhere .= " AND db03_instit = db02_instit ";
    $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

    $cl_docparag = new cl_db_docparag;

    $sAssinatura = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
    $rs = $cl_docparag->sql_record($sAssinatura);
    $oLinha = db_utils::fieldsMemory($rs, 0)->db02_texto;


    $sWhere  = " db02_descr like 'RESPONSÁVEL PELA COTAÇÃO' ";
    //$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSÁVEL PELA DECLARAÇÃO DE RECURSOS FINANCEIROS' ";
    $sWhere .= " AND db03_instit = db02_instit ";
    $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

    $sSqlCotacao = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
    $rsCotacao = $cl_docparag->sql_record($sSqlCotacao);
    $sAssinaturaCotacao = db_utils::fieldsMemory($rsCotacao, 0)->db02_texto;

    if($nome==""){
        
        $comissao = $clliccomissaocgm->sql_record($clliccomissaocgm->sql_query_file(null,'l31_codigo,l31_liccomissao,l31_numcgm, (select cgm.z01_nome from cgm where z01_numcgm = l31_numcgm) as z01_nome, l31_tipo',null,"l31_licitacao=$codigo_preco"));
        for($i=0;$i<$clliccomissaocgm->numrows;$i++){
            $comisaoRes = db_utils::fieldsMemory($comissao, $i);
           if($comisaoRes->l31_tipo==7){
                $nome = $comisaoRes->z01_nome;
            }
        }
    }

    $resultLici = $clliclicita->sql_record($clliclicita->sql_query(null,"*","","l20_codigo = $codigo_preco"));
    $resultLici = db_utils::fieldsMemory($resultLici, 0);
    $tipojulgamento = $resultLici->l20_tipojulg;
    $oLibDocumento->l20_edital = $resultLici->l20_edital;
    $oLibDocumento->l20_anousu = $resultLici->l20_anousu;

    $oLibDocumento->l20_numero = $resultLici->l20_numero;
    $oLibDocumento->z01_nome = $nome;
    
    $aParagrafos = $oLibDocumento->getDocParagrafos();
    

    // echo $sSql;

    // db_criatabela($rsResult);

    $sSql = "select si01_datacotacao FROM pcproc
JOIN pcprocitem ON pc80_codproc = pc81_codproc
JOIN pcorcamitemproc ON pc81_codprocitem = pc31_pcprocitem
JOIN pcorcamitem ON pc31_orcamitem = pc22_orcamitem
JOIN pcorcamval ON pc22_orcamitem = pc23_orcamitem
JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
JOIN solicitem ON pc81_solicitem = pc11_codigo
JOIN solicitempcmater ON pc11_codigo = pc16_solicitem
JOIN pcmater ON pc16_codmater = pc01_codmater
JOIN itemprecoreferencia ON pc23_orcamitem = si02_itemproccompra
JOIN precoreferencia ON itemprecoreferencia.si02_precoreferencia = precoreferencia.si01_sequencial
WHERE pc80_codproc = {$codigo_preco} {$sCondCrit} and pc23_vlrun <> 0";

    $rsResultData = db_query($sSql) or die(pg_last_error());

    $sql1 = "select * from cgm where z01_numcgm = 1119260";
    $rsResul12 = db_query($sql1);
    db_fieldsmemory($rsResul12, 0);

    

    $head3 = "Adjudicação";
    $head5 = "Sequencial: $codigo_preco";
    $head8 = "Data: ".$data;

    $mPDF = new Relatorio('', 'A4', 0, "", 7, 7, 50);

    $mPDF
        ->addInfo($head3, 2)
        ->addInfo($head5, 4)
        ->addInfo($head8, 7);


    ob_start();

    ?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/html">

    <head>
        <title>Relatório</title>
        <!--<link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">-->
        <style type="text/css">
            .content {
                width: 1070px;
            }

            .table {
                font-size: 10px;
                background: url("imagens/px_preto.jpg") repeat center;
                background-repeat: repeat-y;
                background-position: 0 50px;
                height: 30px;
                border: 0px solid black !important;
            }
            .cabecalho1{
                margin-left: 25%;
                margin-top: -100px !important;
            }

            .col-item {
                width: 45px;
            }

            .col-descricao_item {
                width: 245px;
            }

            .col-valor_un {
                width: 80px;
                padding-right: 5px;
            }

            .col-quant {
                width: 60px;
            }

            .col-un {
                width: 45px;
            }

            .col-total {
                width: 90px;
                padding-left: 5px;
            }

            .col-valor_total-text {
                width: 925px;
                padding-left: 5px;
            }

            .col-valor_total-valor {
                width: 120px;
                padding-right: 5px;
            }

            .row .col-un,
            .row .col-total,
            .row .col-quant,
            .row .col-valor_un,
            .row .col-valor_un {}

            .linha-vertical {
                border-top: 2px solid;
                text-align: center;
                margin-top: 80px;
                margin-left: 19%;
                width: 50%;
                line-height: 1.3em;
            }


            .item-menu {
                border: 1px solid #000000;
                text-align: center;
                font-weight: bold;
            }

            .item-text-descricao {
                border: 1px solid #000000;
                text-align: justify;
            }

            .item-text {
                border: 1px solid #000000;
                text-align: center;
            }

            .item-text-total {
                font-weight: bold;
            }

            .item-menu-color {
                background: #f5f5f0;
                font-weight: bold;
            }

            .item-total-color {
                background: #f5f5f0;
                font-weight: bold;
                width: 935px;
            }

            td
        </style>
    </head>

    <body>
    <div>
        <div class="cabecalho1">
            <h1>ADJUDICAÇÃO DE PROCESSO</h1>
        </div>
    </div>
    <br>
    
    <?php

        foreach ($aParagrafos as $oParag) {  
                $texto = $oParag->oParag->db02_texto;
        }

        $textoP = explode("\n",$texto);
        for($i=0;$i<count($textoP);$i++){
            echo "<strong>$textoP[$i]</strong>";
            echo"<br>";
        }
        
    ?>

        <?php     
        $nTotalItens = 0;
   
    
            $campos = "DISTINCT pc01_codmater,pc01_tabela,pc01_taxa,pc01_descrmater,cgmforncedor.z01_nome,cgmforncedor.z01_cgccpf,m61_descr,pc11_quant,pc23_valor,pcorcamval.pc23_vlrun,pcorcamval.pc23_percentualdesconto as mediapercentual,l203_homologaadjudicacao,pc81_codprocitem,l04_descricao,pc11_seq";
    
            $sWhere = " liclicitem.l21_codliclicita = {$codigo_preco} and pc24_pontuacao = 1 AND itenshomologacao.l203_sequencial is null";
            $result = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_itens_semhomologacao(null,$campos,"pc11_seq,z01_nome",$sWhere));
            
            $array1 = array();
            $op = 0;
            for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {
                $oResult = db_utils::fieldsMemory($result, $iCont);
                $verifica = 0;
                if($array1==""){
                    $array1[$op][1] = $oResult->z01_cgccpf;
                    $array1[$op][2] = $oResult->z01_nome;
                    $array1[$op][3] = $oResult->l04_descricao;
                    $op++;
                }else{
                    for($j=0;$j<$op;$j++){
                        if($array1[$j][1]==$oResult->z01_cgccpf){
                            $verifica = 1;
                        }
                    }
                    if($verifica==0){
                        $array1[$op][1] = $oResult->z01_cgccpf;
                        $array1[$op][2] = $oResult->z01_nome;
                        $array1[$op][3] = $oResult->l04_descricao;
                        $op++;
                    }
                }

            }
            
            for($j=0;$j<$op;$j++){
                
                if(strlen($array1[$j][1])==14){
                    $bloco_1 = substr($array1[$j][1],0,2);
                    $bloco_2 = substr($array1[$j][1],2,3);
                    $bloco_3 = substr($array1[$j][1],5,3);
                    $bloco_4 = substr($array1[$j][1],8,4);
                    $digito_verificador = substr($array1[$j][1],-2);
                    $cpf_cnpj_formatado = "CNPJ ".$bloco_1.".".$bloco_2.".".$bloco_3."/".$bloco_4."-".$digito_verificador;

                }else if(strlen($array1[$j][1])==11){
                    $bloco_1 = substr($array1[$j][1],0,3);
                    $bloco_2 = substr($array1[$j][1],3,3);
                    $bloco_3 = substr($array1[$j][1],6,3);
                    $dig_verificador = substr($array1[$j][1],-2);
                    $cpf_cnpj_formatado = "CPF ".$bloco_1.".".$bloco_2.".".$bloco_3."-".$dig_verificador;

                }
                    
                ?>
            <br>
                <div class="table">
                <div class="tr bg_eb">
                <div class="th col-item align-left" style="width:600px"><?echo  $array1[$j][2]." - ".$cpf_cnpj_formatado?></div>
                </div>
                <?php
                if($tipojulgamento!=3){?>
                <div class="tr bg_eb">
                            <div class="th col-item align-center" style="width:49px">Item</div>
                            <div class="th col-descricao_item  align-center">Material/Serviços</div>
                            <div class="th col-valor_un align-center" >Unidade</div>
                            <div class="th col-valor_un align-center">Marca</div>
                            <div class="th col-quant align-center">Quant</div>
                            <div class="th col-valor_un align-right">Uni/taxa</div>
                            <div class="th col-total align-right">Total</div>
                            </div>
            <?php
                }
            
            ?>    
                
            <?php
            $nTotalItens = 0;
            $valor = 0;
            $controle = 0;
            for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {
                $oDadosDaLinha = new stdClass();
                $oResult = db_utils::fieldsMemory($result, $iCont);
                if($array1[$j][1]==$oResult->z01_cgccpf){

                if($tipojulgamento==3){
                    if($array1[$j][3]==$oResult->l04_descricao){
                        if($controle==0){?>
                            <div class="tr bg_eb">
                            <div class="th col-item align-left" style="width:600px"><?echo $oResult->l04_descricao?></div>
                            </div>
                            <div class="tr bg_eb">
                            <div class="th col-item align-center" style="width:49px">Item</div>
                            <div class="th col-descricao_item  align-center">Material/Serviços</div>
                            <div class="th col-valor_un align-center" >Unidade</div>
                            <div class="th col-valor_un align-center">Marca</div>
                            <div class="th col-quant align-center">Quant</div>
                            <div class="th col-valor_un align-right">Uni/taxa</div>
                            <div class="th col-total align-right">Total</div>
                            </div>
                        <?php   
                        $controle = 1;
                        }
                    }else{
                        $array1[$j][3]=$oResult->l04_descricao;?>
                        <div class="tr row">
                            <div class="td item-total-color" style="width: 650px;">
                                VALOR
                                
                            </div>
                            <div class="item-menu-color">
                                <?= "R$" . number_format($valor, 2, ",", ".") ?>
                            </div>
                    </div>
                        <div class="tr bg_eb">
                            <div class="th col-item align-left" style="width:600px"><?echo $oResult->l04_descricao?></div>
                            </div>
                        <div class="tr bg_eb">
                            <div class="th col-item align-center" style="width:49px">Item</div>
                            <div class="th col-descricao_item  align-center">Material/Serviços</div>
                            <div class="th col-valor_un align-center" >Unidade</div>
                            <div class="th col-valor_un align-center">Marca</div>
                            <div class="th col-quant align-center">Quant</div>
                            <div class="th col-valor_un align-right">Uni/taxa</div>
                            <div class="th col-total align-right">Total</div>
                        </div>
                    <?php
                        $valor = 0;
                    }
                }

                
                
                $lTotal = round($oResult->pc23_vlrun, $oGet->quant_casas) * $oResult->pc11_quant;

                $nTotalItens += $lTotal;
                $valor +=$lTotal;
                $oDadosDaLinha = new stdClass();
                $oDadosDaLinha->seq = $iCont + 1;
                $oDadosDaLinha->item = $oResult->pc01_codmater;
                $oDadosDaLinha->descricao = $oResult->pc01_descrmater;
                
                if ($oResult->pc01_tabela == "t" || $oResult->pc01_taxa == "t") {
                    
                    $oDadosDaLinha->quantidade = $oResult->pc11_quant;
                    if ($oResult->mediapercentual == 0) {
                        $oDadosDaLinha->valorUnitario = "-";
                    } else {
                        $oDadosDaLinha->valorUnitario = number_format($oResult->mediapercentual, 2) . "%";
                    }
                    $oDadosDaLinha->unidadeDeMedida = $oResult->m61_descr;
                    $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
                } else {
                    $oDadosDaLinha->valorUnitario = "R$".number_format($oResult->pc23_vlrun, $oGet->quant_casas, ",", ".");
                    $oDadosDaLinha->quantidade = $oResult->pc11_quant;
                    if ($oResult->mediapercentual == 0) {
                        $oDadosDaLinha->mediapercentual = "-";
                    } else {
                        $oDadosDaLinha->mediapercentual = number_format($oResult->mediapercentual, 2) . "%";
                    }
                    $oDadosDaLinha->unidadeDeMedida = $oResult->m61_descr;
                    $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
                }

                
                    echo <<<HTML
         <div class="tr row">
          <div class="td col-item align-center">
            {$oDadosDaLinha->item}
          </div>
          
          <div class="td col-descricao_item align-justify">
            {$oDadosDaLinha->descricao}
          </div>
          <div class="td col-valor_un  align-center">
            {$oDadosDaLinha->unidadeDeMedida}
          </div>
          <div class="td col-valor_un  align-center">
            -
          </div>
          <div class="td col-quant align-center">
            {$oDadosDaLinha->quantidade}
          </div>
          <div class="td col-valor_un align-right">
             {$oDadosDaLinha->valorUnitario}
          </div>
          
          
          <div class="td col-total align-right">
            R$ {$oDadosDaLinha->total}
          </div>
        </div>
HTML;
                
            }
            }?>
            <div class="tr row">
                            <div class="td item-total-color" style="width: 650px;">
                                VALOR
                                
                            </div>
                            <div class="item-menu-color">
                                <?= "R$" . number_format($valor, 2, ",", ".") ?>
                            </div>
            </div>
            <div style="tr row">
            <div class="td item-total-color" style="width: 650px;">
                VALOR TOTAL
            </div>
            <div class=" item-menu-color">
                <?= "R$" . number_format($nTotalItens, 2, ",", ".") ?>
            </div>
        </div>
        <?php
        }
        ?>

        </div>
        <?php
        $data = date('d/m/Y');
        $data = explode("/",$data);

        switch ($data[1]) {
            case 1:
                $mes = "Janeiro";
                break;

            case 2:
                $mes = "Fevereiro";
                break;
            
            case 3:
                $mes = "Março";
                break;

            case 4:
                $mes = "Abril";
                break;
        
            case 5:
                $mes = "Maio";
                break;

            case 6:
                $mes = "Junho";
                break;

            case 7:
                $mes = "Julho";
                break;

            case 8:
                $mes = "Agosto";
                break;

            case 9:
                $mes = "Setembro";
                break;
        
            case 10:
                $mes = "Outubro";
                break;

            case 11:
                $mes = "Novembro";
                break;

            case 12:
                $mes = "Dezembro";
                break;

        }

        $resultado = $cldb_config->sql_record($cldb_config->sql_query_file(db_getsession('DB_instit')));
        $resultado = db_utils::fieldsMemory($resultado, 0);
        
        ?>
        <br>
        <br>
        <div style="text-align: right; margin-right: 5px;">
            <? echo $resultado->munic;?>, <?echo $data[0]?> de <?echo $mes;?> de <?echo $data[2];?>
        </div>
        <?php

        $chars = array('ç', 'ã', 'â', 'à', 'á', 'é', 'è', 'ê', 'ó', 'ò', 'ô', 'ú', 'ù');
        $byChars = array('Ç', 'Ã', 'Â', 'À', 'Á', 'É', 'È', 'Ê', 'Ó', 'Ò', 'Ô', 'Ú', 'Ù');

        $dadosAssinatura = explode('\n', $sAssinaturaCotacao);
        $sCotacao = '';

        //if (count($dadosAssinatura) > 1) {
            $sCotacao = '<div class="linha-vertical">';
            //for ($count = 0; $count < count($dadosAssinatura); $count++) {
                $sCotacao .= "<strong>" . strtoupper($nome) . "</strong>";
                //$sCotacao .= $count ? '' : "<br/>";
            //}
            $sCotacao .= "</div>";
            echo <<<HTML
            $sCotacao
HTML;
    

        ?>   

    </body>

    </html>

    <?php

    $html = ob_get_contents();

    ob_end_clean();
    $mPDF->WriteHTML(utf8_encode($html));
    $mPDF->Output();

    ?>