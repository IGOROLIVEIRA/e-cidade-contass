<?php
global $resparag, $resparagpadrao, $db61_texto, $db02_texto;

$dist = 4;

$this->objpdf->SetAutoPageBreak(false);
$this->objpdf->AliasNbPages();
$this->objpdf->AddPage();
$this->objpdf->settopmargin(1);
$this->objpdf->setleftmargin(4);
$pagina = 1;
$xlin = 20;
$xcol = 4;

$this->objpdf->setfillcolor(245);
$this->objpdf->rect($xcol - 2, $xlin - 18, 206, 292, 2, 'DF', '1234');
$this->objpdf->setfillcolor(255, 255, 255);
$this->objpdf->Setfont('Arial', 'B', 9);
$this->objpdf->text(130, $xlin - 13, 'ORDEM DE COMPRA N' . CHR(176));
$this->objpdf->text(185, $xlin - 13, db_formatar($this->numordem, 's', '0', 6, 'e'));
$this->objpdf->text(130, $xlin - 10, 'DATA :');
$this->objpdf->text(185, $xlin - 10, db_formatar($this->dataordem, 'd'));
$this->objpdf->Setfont('Arial', 'B', 7);

$tamdepto = strlen(trim($this->descrdepto));

$linpc = $tamdepto > 20 ? 1 : 4;

$this->objpdf->text(130, $xlin - 7, 'DEPTO. ORIGEM :');
$this->objpdf->text(155, $xlin - 7, substr($this->sOrigem, 0, 35));

$this->objpdf->text(130, $xlin - 4, 'DEPTO. DESTINO :');
$this->objpdf->text(155, $xlin - 4, substr($this->coddepto . " - " . $this->descrdepto, 0, 35));

$this->objpdf->text(130, ($xlin + 2.5) - $linpc, 'PROCESSO DE COMPRA N ' . CHR(176));
$this->objpdf->text(165, ($xlin + 2.5) - $linpc, db_formatar(pg_result($this->recorddositens, 0, $this->numeroproc), 's', '0', 6, 'e'));
$autori = pg_result($this->recorddositens, 0, $this->autori);

$sqlLicitacao = "SELECT e54_numerl,
                                e54_nummodalidade
								FROM empautoriza
								LEFT JOIN liclicita ON l20_codigo = e54_codlicitacao
								WHERE e54_autori = " . $autori;
$rsLicitacao = db_query($sqlLicitacao);
db_fieldsmemory($rsLicitacao, 0, true);

global $e54_numerl;
global $e54_nummodalidade;

$this->objpdf->text(130, ($xlin + 6.5), 'PROCESSO LICITÓRIO:' . CHR(176));
$this->objpdf->text(160, ($xlin + 6.5), $e54_numerl . " MODALIDADE: " . $e54_nummodalidade);
$this->objpdf->text(130, ($xlin + $linpc - 2.25), 'TIPO DA COMPRA: ');
$this->objpdf->Setfont('Arial', 'B', 7);
$this->objpdf->text(153, ($xlin + $linpc - 2.5), db_formatar(pg_result($this->recorddositens,0,$this->sTipoCompra), 's', '0', 6, 'e'));

$this->objpdf->Setfont('Arial', 'B', 9);
$this->objpdf->Image('imagens/files/' . $this->logo, 13, $xlin - 17, 18);
$this->objpdf->Setfont('Arial', 'B', 9);
$this->objpdf->text(40, $xlin - 15, $this->prefeitura);
$this->objpdf->Setfont('Arial', '', 9);
$this->objpdf->text(40, $xlin - 11.5, $this->enderpref);
$this->objpdf->text(40, $xlin - 8, "CNPJ:" . db_formatar($this->cgc, 'cnpj'));
$this->objpdf->text(40, $xlin - 4.5, "FONE: " . $this->telefpref);
$this->objpdf->text(40, $xlin - 1.5, $this->emailpref);
$this->objpdf->text(40, $xlin + 2, $this->url);
$this->objpdf->text(40, $xlin + 6, $this->inscricaoestadualinstituicao);

$xlin = $xlin + 5;
$this->objpdf->rect($xcol, $xlin + 2, $xcol + 198, 20, 2, 'DF', '1234');
$this->objpdf->Setfont('Arial', '', 6);
$this->objpdf->text($xcol + 2, $xlin + 4.5, 'Dados do Fornecedor');
$this->objpdf->Setfont('Arial', 'B', 8);
$this->objpdf->text($xcol + 110, $xlin + 5, 'E-mail');
$this->objpdf->text($xcol + 110, $xlin + 8.5, 'Numcgm');
$this->objpdf->text($xcol + 158, $xlin + 8.5, (strlen($this->cnpj) == 11 ? 'CPF' : 'CNPJ'));
$this->objpdf->text($xcol +  2, $xlin + 8.5, 'Nome');
$this->objpdf->text($xcol +  2, $xlin + 12.5, 'Endereço');
$this->objpdf->text($xcol + 110, $xlin + 12.5, 'Número');
$this->objpdf->text($xcol + 158, $xlin + 12.5, 'Complemento');
$this->objpdf->text($xcol +  2, $xlin + 16, 'Município');
$this->objpdf->text($xcol + 110, $xlin + 16, 'Bairro');
$this->objpdf->text($xcol + 158, $xlin + 16, 'CEP');
$this->objpdf->text($xcol +  2, $xlin + 20, 'Contato');
$this->objpdf->text($xcol + 110, $xlin + 20, 'Telefone');
$this->objpdf->text($xcol + 158, $xlin + 20, 'FAX');
$this->objpdf->Setfont('Arial', '', 8);
$this->objpdf->text($xcol + 122, $xlin + 5, ':  ' . $this->email);
$this->objpdf->text($xcol + 177, $xlin + 8.5, ':  ' . $this->cnpj);
$this->objpdf->text($xcol + 122, $xlin + 8.5, ':  ' . $this->numcgm);
$this->objpdf->text($xcol + 18, $xlin + 8.5, ':  ' . $this->nome);
$this->objpdf->text($xcol + 18, $xlin + 12.5, ':  ' . $this->ender);
$this->objpdf->text($xcol + 122, $xlin + 12.5, ':  ' . $this->numero);
$this->objpdf->text($xcol + 177, $xlin + 12.5, ':  ' . $this->compl);
$this->objpdf->text($xcol + 18, $xlin + 16, ':  ' . $this->munic . '-' . $this->ufFornecedor);
$this->objpdf->text($xcol + 122, $xlin + 16, ':  ' . $this->bairro);
$this->objpdf->text($xcol + 177, $xlin + 16, ':  ' . $this->cep);
$this->objpdf->text($xcol + 18, $xlin + 20, ':  ' . $this->contato);
$this->objpdf->text($xcol + 122, $xlin + 20, ':  ' . $this->telef_cont);
$this->objpdf->text($xcol + 177, $xlin + 20, ':  ' . $this->telef_fax);

global $ordemdecompra1;
global $ordemdecompra2;
global $descrtexto;
global $conteudotexto;

$sqltexto = "select * from db_config where codigo = " . db_getsession("DB_instit");
$resulttexto = db_query($sqltexto);
db_fieldsmemory($resulttexto, 0, true);

$sqltexto = "select * from db_usuarios where id_usuario = " . db_getsession("DB_id_usuario");
$resulttexto = db_query($sqltexto);
db_fieldsmemory($resulttexto, 0, true);

$sqltexto = "select * from db_textos where id_instit = " . db_getsession("DB_instit") . " and ( descrtexto like 'ordemdecompra%')";
$resulttexto = db_query($sqltexto);
for ($xx = 0; $xx < pg_numrows($resulttexto); $xx++) {
    db_fieldsmemory($resulttexto, $xx, true);
    $text  = $descrtexto;
    $$text = db_geratexto($conteudotexto);
}

$texto1 = @$ordemdecompra1;
$texto2 = @$ordemdecompra2;

$result_endent = db_query("select j14_nome as j14_nome_almox, numero as numero_almox, compl as compl_almox,
        				   j13_descr as j13_descr_almox, fonedepto as fone_almox, ramaldepto as ramal_almox,
        				   faxdepto as fax_almox
                           from db_departender
						   inner join db_depart on db_depart.coddepto = db_departender.coddepto
						   inner join ruas on j14_codigo = codlograd
						   inner join bairro on j13_codi = codbairro where db_departender.coddepto = " . $this->depto);
if (pg_numrows($result_endent) > 0) {

    db_fieldsmemory($result_endent, 0, true);
    global $j14_nome_almox;
    global $numero_almox;
    global $compl_almox;
    global $j13_descr_almox;
    global $fone_almox;
    global $ramal_almox;
    global $fax_almox;

    $this->objpdf->sety($xlin + 24);
    $posicao_atual = $this->objpdf->gety();
    $this->objpdf->Setfont('Arial', 'B', 8);
    $this->objpdf->multicell(202, 4, "$texto1", 1);
    $this->objpdf->multicell(202, 4, "ENDERECO DE ENTREGA: $j14_nome_almox, $numero_almox - $compl_almox\nBAIRRO: $j13_descr_almox\n" . ($fone_almox != "" ? "FONE: $fone_almox - " : "") . ($ramal_almox != "" ? "RAMAL: $ramal_almox - " : "") . ($fax_almox != "" ? "FAX: $fax_almox" : ""), 1);
    $posicao_depois = $this->objpdf->gety();
    $xlin += $posicao_depois - $posicao_atual + 2;
}

$this->objpdf->sety($xlin + 24);
$posicao_atual = $this->objpdf->gety();
$this->objpdf->multicell(202, 4, "PRAZO DE ENTREGA: " . $this->prazoent . " DIAS A CONTAR DA DATA DO RECEBIMENTO DESTA ORDEM DE COMPRA", 1);
$this->objpdf->multicell(202, 4, "CONDICOES DE PAGAMENTO: " . pg_result($this->recorddositens, 0, $this->condpag), 1);
$this->objpdf->multicell(202, 4, "DESTINO: " . pg_result($this->recorddositens, 0, $this->destino), 1);
$posicao_depois = $this->objpdf->gety();
$xlin += $posicao_depois - $posicao_atual + 2;

if ($this->obs != "") {
    $this->objpdf->sety($xlin + 24);
    $posicao_atual = $this->objpdf->gety();
    $this->objpdf->multicell(202, 4, "OBSERVAÇÕES:  " . $this->obs, 1);
    $posicao_depois = $this->objpdf->gety();
    $xlin += $posicao_depois - $posicao_atual + 2;
}

$this->objpdf->sety($xlin + 22);
$this->objpdf->Setfont('Arial', 'B', 8);

$this->objpdf->Cell(60, 5, 'Empenho: ' . pg_result($this->recorddositens, $ii, $this->empempenho) . "/" . pg_result($this->recorddositens, $ii, $this->anousuemp), 1, 0, 'L');
$this->objpdf->Cell(142, 5, 'Data da Emissão do Empenho: ' . db_formatar($this->e60_emiss, 'd'), 1, 1, 'L');
$this->objpdf->Cell(20, 5, 'Item', 1, 0, 'C');
$this->objpdf->Cell(20, 5, 'Quant.', 1, 0, 'C');
$this->objpdf->Cell(20, 5, 'Unid.', 1, 0, 'C');
$this->objpdf->Cell(102, 5, 'Material/Serviço', 1, 0, 'C');
$this->objpdf->Cell(20, 5, 'Unitário', 1, 0, 'C');
$this->objpdf->Cell(20, 5, 'Total', 1, 1, 'C');
$this->objpdf->Setfont('Arial', '', 8);

$this->objpdf->SetWidths(array(20, 20, 20, 102, 20, 20));
$this->objpdf->SetAligns(array('C', 'C', 'C', 'L', 'C', 'C'));

for ($ii = 0; $ii < $this->linhasdositens; $ii++) {
    db_fieldsmemory($this->recorddositens, $ii);

    /* Realizar a consulta de item anulado */
    $sql = " SELECT m52_valor,
        m36_vrlanu,
        m36_qtd
        FROM matordemitem
        INNER JOIN empempitem ON empempitem.e62_numemp = matordemitem.m52_numemp
        INNER JOIN matordemitemanu ON m36_matordemitem = m52_codlanc
        AND empempitem.e62_sequen = matordemitem.m52_sequen
        INNER JOIN empempenho ON empempenho.e60_numemp = empempitem.e62_numemp
        INNER JOIN matordem ON matordem.m51_codordem = matordemitem.m52_codordem
        INNER JOIN cgm ON cgm.z01_numcgm = matordem.m51_numcgm
        INNER JOIN db_depart ON db_depart.coddepto = matordem.m51_depto
        INNER JOIN orcelemento ON orcelemento.o56_codele = empempitem.e62_codele
        AND orcelemento.o56_anousu = empempenho.e60_anousu
        INNER JOIN pcmater ON pcmater.pc01_codmater = empempitem.e62_item
        WHERE m52_codordem =  " . $this->numordem . " and e62_item = " . pg_result($this->recorddositens, $ii, $this->codmater);

    $resItens = @db_query($sql);
    $valorItemAnulado = db_utils::fieldsMemory($resItens, 0)->m36_vrlanu;
    $valorItem = db_utils::fieldsMemory($resItens, 0)->m52_valor;
    $qtdAnulada = db_utils::fieldsMemory($resItens, 0)->m36_qtd;



    //valorAnulado
    if ($valorItemAnulado) {
        $valorItemTotal = pg_result($this->recorddositens, $ii, $this->valoritem) - $valorItemAnulado;
    } else $valorItemTotal = pg_result($this->recorddositens, $ii, $this->valoritem);
    //QtdAnulada
    if ($qtdAnulada > 0) {
        $qtdItem = pg_result($this->recorddositens, $ii, $this->quantitem) - $qtdAnulada;
    } else {
        $qtdItem = pg_result($this->recorddositens, $ii, $this->quantitem);
    }
    $valorItem = pg_result($this->recorddositens, $ii, $this->vlrunitem);

    if(pg_result($this->recorddositens, $ii, $this->servico) == 't'
       && pg_result($this->recorddositens, $ii, $this->servicoquantidade) == 'f'){
        $valorItem = $valorItemTotal;
    }
    $complemento ='';
    /*Realiza a consulta se o item é tabela e tem itens associados*/

	$sqlItemTabela = "SELECT * FROM empordemtabela where l223_pcmaterordem = ". pg_result($this->recorddositens, $ii, $this->codmater) ." and l223_codordem = ".$this->numordem."order by l223_pcmatertabela";
	$resItemTabela = @db_query($sqlItemTabela);
    $oldy = $this->objpdf->gety();
    $linhaitem = $this->objpdf->NbLines(102, pg_result($this->recorddositens, $ii, $this->descricaoitem) . pg_result($this->recorddositens, $ii, $this->pc01_complmater) . "\n" . 'Marca: ' . pg_result($this->recorddositens, $ii, $this->obs_ordcom_orcamval))*5;
    $oldy += $linhaitem;
    $contalinha = 0;
    $tamanhopag = $oldy;
    if(@pg_numrows($resItemTabela) > 0){
        $complemento ="DETALHAMENTO: \n";
        for($contitem=0;$contitem < @pg_numrows($resItemTabela);$contitem++){
            $oDadosItemTabela = db_utils::fieldsMemory($resItemTabela, $contitem);        
            $complemento .= ($contitem+1)." - ".$oDadosItemTabela->l223_descr . "\n Quantidade: ".$oDadosItemTabela->l223_quant." - Unitário:".db_formatar($oDadosItemTabela->l223_vlrn,'f')." - Total: ".db_formatar($oDadosItemTabela->l223_total,'f')."\n";;
            $contalinha++;
            if ((($tamanhopag > $this->objpdf->h - 30) && $pagina == 1) || (($tamanhopag > $this->objpdf->h - 50) && $pagina != 1)) {
                break;
            }
            $tamanhopag = $oldy + ($contalinha*5)+(($contalinha+1)*5);
        }
    }
    
    $this->objpdf->Row(
        array(
            pg_result($this->recorddositens, $ii, $this->codmater),
            $qtdItem,
            pg_result($this->recorddositens, $ii, $this->unid),
            pg_result($this->recorddositens, $ii, $this->descricaoitem) . pg_result($this->recorddositens, $ii, $this->pc01_complmater) . "\n" . 'Marca: ' . pg_result($this->recorddositens, $ii, $this->obs_ordcom_orcamval). "\n"  . $complemento,
            db_formatar($valorItem, 'v', " ", $this->numdec),
            db_formatar($valorItemTotal, 'f')
        ),
        5,
        true,
        5,
        0,
        true
    );
    
    
	if($contitem < @pg_numrows($resItemTabela))
    {
        $this->objpdf->sety($xlin + 22);
        $this->objpdf->Setfont('Arial', 'B', 8);
        $this->objpdf->AddPage();
        $this->objpdf->Cell(20, 5, 'Item', 1, 0, 'C');
        $this->objpdf->Cell(20, 5, 'Quant.', 1, 0, 'C');
        $this->objpdf->Cell(20, 5, 'Unid.', 1, 0, 'C');
        $this->objpdf->Cell(102, 5, 'Material/Serviço', 1, 0, 'C');
        $this->objpdf->Cell(20, 5, 'Unitário', 1, 0, 'C');
        $this->objpdf->Cell(20, 5, 'Total', 1, 1, 'C');
        $this->objpdf->Setfont('Arial', '', 8);
        $complemento ='';
        $contalinha = 0;
        $oldy = $this->objpdf->gety() + 5;    
        for($contitem=$contitem+1;$contitem < @pg_numrows($resItemTabela);$contitem++)
        {
            $oDadosItemTabela = db_utils::fieldsMemory($resItemTabela, $contitem);
            $this->objpdf->Setfont('Arial', '', 8);
            //$this->objpdf->text($this->objpdf->getx() + 61, $oldy + (($contalinha*5)*2),($contitem+1)." - ".$oDadosItemTabela->l223_descr);
            //$this->objpdf->text($this->objpdf->getx() + 61, $oldy+ ($contalinha*5)+(($contalinha+1)*5)," Quantidade: ".$oDadosItemTabela->l223_quant." - Unitário:".db_formatar($oDadosItemTabela->l223_vlrn,'f')." - Total: ".db_formatar($oDadosItemTabela->l223_total,'f'));
            $complemento .= ($contitem+1)." - ".$oDadosItemTabela->l223_descr . "\n Quantidade: ".$oDadosItemTabela->l223_quant." - Unitário:".db_formatar($oDadosItemTabela->l223_vlrn,'f')." - Total: ".db_formatar($oDadosItemTabela->l223_total,'f')."\n";;
            $contalinha++;
            if ((($oldy+ ($contalinha*5)+(($contalinha+1)*5)) > $this->objpdf->h - 30 && $pagina == 1) || (($oldy+ ($contalinha*5)+(($contalinha+1)*5)) > $this->objpdf->h - 50 && $pagina != 1) || ($contitem + 1 == @pg_numrows($resItemTabela)))
            {  
                $this->objpdf->Row(
                    array("","","",$complemento,
                        "",
                        ""
                        ),
                        5,
                        true,
                        5,
                        0,
                        true
                );
                $complemento ='';
                $contalinha = 0;
            }
        }
       
    }
   
    if ($valorItemAnulado > 0) {
        $this->objpdf->Setfont('Arial', 'B', 8);
        $this->objpdf->text($this->objpdf->getx() + 61, $this->objpdf->gety() - 3, "(ANULADO)");
        $this->objpdf->Setfont('Arial', '', 8);
    } else if ($valorItemAnulado > 0 && $valorItemAnulado < pg_result($this->recorddositens, $ii, $this->vlrunitem)) {
        $this->objpdf->Setfont('Arial', 'B', 8);
        $this->objpdf->text($this->objpdf->getx() + 61, $this->objpdf->gety() - 3, "(ANULADO PARCIALMENTE)");
        $this->objpdf->Setfont('Arial', '', 8);
    }
    $totalgeral +=  $valorItemTotal;

    if (($this->objpdf->gety() > $this->objpdf->h - 30 && $pagina == 1) || ($this->objpdf->gety() > $this->objpdf->h - 50 && $pagina != 1)) {
        $this->objpdf->sety($xlin + 22);
        $this->objpdf->Setfont('Arial', 'B', 8);
        $this->objpdf->AddPage();
        $this->objpdf->Cell(20, 5, 'Item', 1, 0, 'C');
        $this->objpdf->Cell(20, 5, 'Quant.', 1, 0, 'C');
        $this->objpdf->Cell(20, 5, 'Unid.', 1, 0, 'C');
        $this->objpdf->Cell(102, 5, 'Material/Serviço', 1, 0, 'C');
        $this->objpdf->Cell(20, 5, 'Unitário', 1, 0, 'C');
        $this->objpdf->Cell(20, 5, 'Total', 1, 1, 'C');
        $this->objpdf->Setfont('Arial', '', 8);
    }
}
$this->objpdf->Setfont('Arial', 'B', 8);
$this->objpdf->Cell(162, 5, 'Total Geral: ', 1, 0, 'R');
$this->objpdf->Cell(40, 5, db_formatar($totalgeral, 'f'), 1, 0, 'R');

$sqlparagpadrao  = "select db61_texto ";
$sqlparagpadrao .= "  from db_documentopadrao ";
$sqlparagpadrao .= "       inner join db_docparagpadrao  on db62_coddoc   = db60_coddoc ";
$sqlparagpadrao .= "       inner join db_tipodoc         on db08_codigo   = db60_tipodoc ";
$sqlparagpadrao .= "       inner join db_paragrafopadrao on db61_codparag = db62_codparag ";
$sqlparagpadrao .= " where db60_tipodoc = 1502 and db60_instit = " . db_getsession('DB_instit') . "order by db62_ordem";

$resparagpadrao = @pg_query($sqlparagpadrao);
if (@pg_numrows($resparagpadrao) > 0) {
    db_fieldsmemory($resparagpadrao, 0);

    eval($db61_texto);
}
