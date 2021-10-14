<?php

$sSQLTomadorDBConfig = "SELECT numcgm FROM db_config WHERE cgc = '{$this->dadosTomador->z01_cgccpf}' and prefeitura is true";
$rsTomadorDBConfig = db_query($sSQLTomadorDBConfig);
$lTomadorEhPrefeitura = !!pg_num_rows($rsTomadorDBConfig);

$oConf = db_utils::fieldsmemory($this->rsConfig, $j);
$xlin = 20;
$xcol = 4;
$this->fTotaliUni = 0;
$this->fTotal = 0;
$this->fvlrIssqn = 0;
$this->fvlrInss = 0;
$this->fvlrIrrf = 0;
$this->objpdf->AliasNbPages();
$this->objpdf->AddPage();
$this->objpdf->settopmargin(1);
$this->objpdf->SetFillColor(192, 192, 192);
$this->objpdf->Setfont('Arial', 'B', 10);
$this->objpdf->rect(10, 2, 29, 28);
$this->objpdf->Image('imagens/files/' . $this->logo, 19, $xlin - 12, 12);
//    $this->objpdf->rect(39,2,121,28);
$this->objpdf->Setfont('Arial', 'B', 9);
//    $this->objpdf->text(69, $xlin -15, $this->prefeitura);
$this->objpdf->sety(2);
$this->objpdf->setx($xlin + 19);
$this->objpdf->cell(121, 5, "$this->prefeitura", "T", 1, "C");
$this->objpdf->Setfont('Arial', '', 8);
$this->objpdf->setx($xlin + 19);
$this->objpdf->cell(121, 5, $this->enderpref . ' - ' . $this->municpref, 0, 1, "C");
$this->objpdf->setx($xlin + 19);
$this->objpdf->cell(121, 5, db_formatar($this->cgcpref, 'cnpj'), 0, 1, "C");
$this->objpdf->setx($xlin + 19);
$this->objpdf->cell(121, 5, $this->telefpref . (empty($this->emailpref) ? "" : " - " . $this->emailpref), 0, 1, "C");

if ($this->notaCancelada) {
    $this->setWaterMark(40, 190, "Cancelada", 45, 130);
    $this->printWaterMark();
}
// Titulo
$this->objpdf->sety($xlin + 3);
$this->objpdf->setx($xlin + 19);
$this->objpdf->Setfont('Arial', 'B', 10);
$this->objpdf->cell(121, 5, "NOTA FISCAL DE SERVIÇOS ELETRÔNICA - AVULSA", 0, 1, "C");

//Numero da nota
$this->objpdf->sety(2);
$this->objpdf->setx(160);
$this->objpdf->cell(40, 28, "Nº " . $this->dadosPrestador->q51_numnota, 1, 1, "C");

//Data / Hora Emissão
$this->objpdf->Setfont('Arial', 'B', 7);
$this->objpdf->sety($xlin + 10);
$this->objpdf->cell(29, 5, "Data / Hora Emissão", 1, 0, "C", true);
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->cell(29, 5, db_formatar($this->dadosPrestador->q51_dtemiss, 'd') . ' - ' . $this->dadosPrestador->q51_hora, "TB", 0, "C");

//Competência
$this->objpdf->Setfont('Arial', 'B', 7);
$this->objpdf->cell(29, 5, "Competência", 1, 0, "C", true);
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->cell(29, 5, substr(db_formatar($this->dadosTomador->q53_dtservico, 'd'), 3), "TB", 0, "C");

//Cód. Verificação
$this->objpdf->Setfont('Arial', 'B', 7);
$this->objpdf->cell(34, 5, "Cód. Verificação", 1, 0, "C", true);
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->cell(40, 5, $this->dadosPrestador->q51_codautent, "BR", 1, "C");

$xlin = 33;
$this->objpdf->sety($xlin + 4);
//Dados do Prestador
$this->objpdf->Setfont('Arial', 'B', 8);
$this->objpdf->cell(0, 6, "PRESTADOR DO SERVIÇO", 1, 0, "C", true);
$this->objpdf->rect(10, $xlin + 10, 190, 20);
//Nome
$this->objpdf->Setfont('Arial', 'B', 5);
$this->objpdf->text(12, $xlin + 12, 'NOME/RAZÃO SOCIAL');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text(14, $xlin + 14.3, $this->dadosPrestador->z01_nome);
$this->objpdf->line(10, $xlin + 15, 200, $xlin + 15);
//Endereco
$this->objpdf->Setfont('Arial', 'B', 5);
$this->objpdf->text(12, $xlin + 17, 'ENDEREÇO');
$this->objpdf->Setfont('Arial', '', 7);
$this->dadosPrestador->z01_ender = trim($this->dadosPrestador->z01_ender);
$this->objpdf->text(14, $xlin + 19.3, "{$this->dadosPrestador->z01_ender}, {$this->dadosPrestador->z01_numero}");
$this->objpdf->line(10, $xlin + 20, 200, $xlin + 20);
//BAIRRO
$this->objpdf->Setfont('Arial', 'B', 5);
$this->objpdf->text($xcol + 132, $xlin + 17, 'BAIRRO');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text($xcol + 134, $xlin + 19.3, $this->dadosPrestador->z01_bairro);
$this->objpdf->line($xcol + 130, $xlin + 15, $xcol + 130, $xlin + 25);
//Municipio
$this->objpdf->Setfont('Arial', 'B', 5);
$this->objpdf->text(12, $xlin + 22, 'MUNICÍPIO');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text(14, $xlin + 24.3, $this->dadosPrestador->z01_munic);
$this->objpdf->line(10, $xlin + 20, 200, $xlin + 20);
//UF
$this->objpdf->Setfont('Arial', 'B', 5);
$this->objpdf->text($xcol + 122, $xlin + 22, 'UF');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text($xcol + 124, $xlin + 24.3, $this->dadosPrestador->z01_uf);
$this->objpdf->line($xcol + 120, $xlin + 20, $xcol + 120, $xlin + 25);
//CEP
$this->objpdf->Setfont('Arial', 'B', 5);
$this->objpdf->text($xcol + 132, $xlin + 22, 'CEP');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text($xcol + 134, $xlin + 24.3, $this->dadosPrestador->z01_cep);
//$this->objpdf->line($xcol + 130, $xlin + 20, $xcol + 130, $xlin + 25);
//Fone
$this->objpdf->Setfont('Arial', 'b', 5);
$this->objpdf->text($xcol + 162, $xlin + 22, 'TELEFONE');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text($xcol + 164, $xlin + 24.3, $this->dadosPrestador->z01_telef);
$this->objpdf->line($xcol + 160, $xlin + 20, $xcol + 160, $xlin + 25);
//CPF/CNPJ
$this->objpdf->Setfont('Arial', 'b', 5);
$this->objpdf->text(12, $xlin + 27, 'CPF/CNPJ');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text(14, $xlin + 29, $this->dadosPrestador->z01_cgccpf);
$this->objpdf->line(10, $xlin + 30, 200, $xlin + 30);
//INSCRICAO
$this->objpdf->Setfont('Arial', 'b', 5);
$this->objpdf->text($xcol + 82, $xlin + 27, 'INSCRIÇÃO MUNICIPAL');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text($xcol + 84, $xlin + 29.3, $this->dadosPrestador->q02_inscr);
$this->objpdf->line($xcol + 80, $xlin + 25, $xcol + 80, $xlin + 30);
//Email
$this->objpdf->Setfont('Arial', 'B', 5);
$this->objpdf->text($xcol + 132, $xlin + 27, 'EMAIL');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text($xcol + 134, $xlin + 29.3, $this->dadosPrestador->z01_email);
$this->objpdf->line($xcol + 130, $xlin + 25, $xcol + 130, $xlin + 30);

$this->objpdf->line(10, $xlin + 25, 200, $xlin + 25);
$xlin = 60;
$this->objpdf->sety($xlin + 5);
//Dados do TOMADOR
$this->objpdf->Setfont('Arial', 'B', 8);
$this->objpdf->cell(0, 5, "TOMADOR DO SERVIÇO", 1, 0, "C", true);
$this->objpdf->rect(10, $xlin + 10, 190, 20);
//Nome
$this->objpdf->Setfont('Arial', 'B', 5);
$this->objpdf->text(12, $xlin + 12, 'NOME/RAZÃO SOCIAL');
$this->objpdf->Setfont('Arial', '', 7);
$this->dadosTomador->z01_nomecomple = trim($this->dadosTomador->z01_nomecomple);
$nometomador = empty($this->dadosTomador->z01_nomecomple) ? $this->dadosTomador->z01_nome : $this->dadosTomador->z01_nomecomple;
$this->objpdf->text(14, $xlin + 14.3, $nometomador);
$this->objpdf->line(10, $xlin + 15, 200, $xlin + 15);
//Endereco
$this->objpdf->Setfont('Arial', 'B', 5);
$this->objpdf->text(12, $xlin + 17, 'ENDEREÇO');
$this->objpdf->Setfont('Arial', '', 7);
$this->dadosTomador->z01_ender = trim($this->dadosTomador->z01_ender);
$this->objpdf->text(14, $xlin + 19.3, "{$this->dadosTomador->z01_ender}, {$this->dadosTomador->z01_numero}");
$this->objpdf->line(10, $xlin + 20, 200, $xlin + 20);
//BAIRRO
$this->objpdf->Setfont('Arial', 'B', 5);
$this->objpdf->text($xcol + 132, $xlin + 17, 'BAIRRO');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text($xcol + 134, $xlin + 19.3, $this->dadosTomador->z01_bairro);
$this->objpdf->line($xcol + 130, $xlin + 15, $xcol + 130, $xlin + 25);
//Municipio
$this->objpdf->Setfont('Arial', 'B', 5);
$this->objpdf->text(12, $xlin + 22, 'MUNICÍPIO');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text(14, $xlin + 24.3, $this->dadosTomador->z01_munic);
$this->objpdf->line(10, $xlin + 25, 200, $xlin + 25);
//UF
$this->objpdf->Setfont('Arial', 'B', 5);
$this->objpdf->text($xcol + 122, $xlin + 22, 'UF');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text($xcol + 124, $xlin + 24.3, $this->dadosTomador->z01_uf);
$this->objpdf->line($xcol + 120, $xlin + 25, $xcol + 120, $xlin + 25);
//CEP
$this->objpdf->Setfont('Arial', 'B', 5);
$this->objpdf->text($xcol + 132, $xlin + 22, 'CEP');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text($xcol + 134, $xlin + 24.3, $this->dadosTomador->z01_cep);
$this->objpdf->line($xcol + 120, $xlin + 20, $xcol + 120, $xlin + 25);
//Fone
$this->objpdf->Setfont('Arial', 'b', 5);
$this->objpdf->text($xcol + 162, $xlin + 22, 'TELEFONE');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text($xcol + 164, $xlin + 24.3, $this->dadosTomador->z01_telef);
$this->objpdf->line($xcol + 160,$xlin + 20,$xcol + 160,$xlin + 25);
//CPF/CNPJ
$this->objpdf->Setfont('Arial', 'b', 5);
$this->objpdf->text(12, $xlin + 27, 'CPF/CNPJ');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text(14, $xlin + 29.3, $this->dadosTomador->z01_cgccpf);
//$this->objpdf->line(10, $xlin + 30, 200, $xlin + 30);
//INSCRICAO
$this->objpdf->Setfont('Arial', 'b', 5);
$this->objpdf->text($xcol + 52, $xlin + 27, 'INSCRIÇÃO MUNICIPAL');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text($xcol + 54, $xlin + 29.3, $this->dadosTomador->q02_inscr);
$this->objpdf->line($xcol + 50, $xlin + 25, $xcol + 50, $xlin + 30);
//INSCRICAO ESTADUAL
$this->objpdf->Setfont('Arial', 'b', 5);
$this->objpdf->text($xcol + 92, $xlin + 27, 'INSCRIÇÃO ESTADUAL');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text($xcol + 94, $xlin + 29.3, $this->dadosTomador->z01_incest);
$this->objpdf->line($xcol + 90, $xlin + 25, $xcol + 90, $xlin + 30);

//Fone
//    $this->objpdf->Setfont('Arial', 'b', 5);
//    $this->objpdf->text($xcol+8,$xlin+27,'DATA DA PRESTACAO DO SERVIÇO');
//    $this->objpdf->Setfont('Arial','',7 );
//    $this->objpdf->text($xcol+10,$xlin+29,db_formatar($this->dadosTomador->q53_dtservico,"d"));
//    $this->objpdf->line($xcol+50,$xlin+25,$xcol+50,$xlin+30);
//Atividade
//    $this->objpdf->Setfont('Arial', 'B', 5);
//    $this->objpdf->text($xcol+52,$xlin+27,'COD. ATIVIDADE');
//    $this->objpdf->Setfont('Arial', '',7 );

//    $this->objpdf->line(10,$xlin+30,200,$xlin+30);
//Email
$this->objpdf->Setfont('Arial', 'B', 5);
$this->objpdf->text($xcol + 132, $xlin + 27, 'EMAIL');
$this->objpdf->Setfont('Arial', '', 7);
$this->objpdf->text($xcol + 134, $xlin + 29.3, $this->dadosTomador->z01_email);
$this->objpdf->line($xcol + 130, $xlin + 25, $xcol + 130, $xlin + 30);

$this->objpdf->sety($xlin + 33);

//$this->objpdf->Setfont('Arial', 'B', 7);
//$this->objpdf->cell(190, 5, "DISCRIMINAÇÃO DOS SERVIÇOS", 1, 1, "C", true);
//$this->objpdf->Setfont('Arial', '', 7);

$this->objpdf->cell(15, 5, "QUANT", 1, 0, "C");
$this->objpdf->cell(100, 5, "DISCRIMINAÇÃO DOS SERVIÇOS", 1, 0, "C");
$this->objpdf->cell(30, 5, "VALOR UNITÁRIO", 1, 0, "C");
$this->objpdf->cell(15, 5, "ALIQ (%)", 1, 0, "C");
$this->objpdf->cell(30, 5, "VALOR TOTAL", 1, 1, "C");

/*
 ** Dados do Servico;
*/
$iYinicio = $this->objpdf->getY();
$cellYnew = $this->objpdf->getY();
$this->objpdf->line(10, $iYinicio, 200, $iYinicio);
$totlinha = 0;
$sDescitemservico = "";
$fAliquota = 0;
for ($i = 0; $i < pg_num_rows($this->rsServico); $i++) {

    $this->objpdf->sety($cellYnew);
    $oItensServico = db_utils::fieldsmemory($this->rsServico, $i);
    $totalLinha = ($oItensServico->q62_qtd * $oItensServico->q62_vlruni);
    $this->fTotaliUni += $totalLinha;
    $this->fTotal += $this->fTotaliUni;
    $this->fvlrIssqn += $oItensServico->q62_vlrissqn;
    $this->fvlrInss += $oItensServico->q62_vlrinss;
    $this->fvlrIrrf += $oItensServico->q62_vlrirrf;
    $sDescitemservico = $oItensServico->db121_estrutural . " - " . $oItensServico->db121_descricao;
    $fAliquota = $oItensServico->q62_aliquota;

    $this->objpdf->cell(15, 3, $oItensServico->q62_qtd, "LR", 0, "R");
    $cellYold = $this->objpdf->getY();
    $this->objpdf->multiCell(100, 3, $oItensServico->q62_discriminacao, "LR", "L");
    $cellYnew = $this->objpdf->getY();
    $this->objpdf->sety($cellYold);
    $this->objpdf->setx(125);
    $vlUniMostra = $oItensServico->q62_vlruni != '' ? number_format($oItensServico->q62_vlruni, 2, ",", ".") : null;
    $this->objpdf->cell(30, 3, $vlUniMostra, "LR", 0, "R");
    $vlAliquota = $oItensServico->q62_aliquota != '' ? number_format($oItensServico->q62_aliquota, 2, ",", ".") : null;
    $this->objpdf->cell(15, 3, $vlAliquota, "LR", 0, "R");
    //$this->objpdf->cell(15, 3, $oItensServico->q62_aliquota, "LR", 0, "R");
    $vlTotalMostra = $totalLinha != null ? number_format($totalLinha, 2, ".", ",") : null;
    $this->objpdf->cell(30, 3, $vlTotalMostra, "LR", 1, "R");    

    //$this->objpdf->multiCell(190, 5, $oItensServico->q62_discriminacao, "", "L");
    //$this->objpdf->rect(10, $iYinicio, 190, 80);

    break;
}

$this->objpdf->sety(220);
$iYFinal = $this->objpdf->getY() - 10;

$this->objpdf->line(10, $iYinicio, 10, $iYFinal);
$this->objpdf->line(25, $iYinicio, 25, $iYFinal);
$this->objpdf->line(125, $iYinicio, 125, $iYFinal);
$this->objpdf->line(155, $iYinicio, 155, $iYFinal);
$this->objpdf->line(170, $iYinicio, 170, $iYFinal);
$this->objpdf->line(200, $iYinicio, 200, $iYFinal);

//Código da Atividade
$this->yOld = $this->objpdf->getY() - 15;
$this->objpdf->rect(10, $this->yOld, 190, 20);
$this->objpdf->Setfont('Arial', 'B', 7);
$this->objpdf->sety($this->yOld);
$this->objpdf->cell(190, 5, "CÓDIGO DO SERVIÇO - ATIVIDADE", 1, 1, "C", true);
$this->objpdf->Setfont('Arial', '', 7);      
$this->objpdf->multiCell(190, 5, $sDescitemservico, "", "J");
$this->objpdf->Setfont('Arial', '', 8);

///box com o total devido de imposto
$this->yOld = $this->objpdf->getY() + 10;
$this->objpdf->rect(10, $this->yOld, 115, 25);
$this->objpdf->Setfont('Arial', '', 10);
$this->objpdf->sety($this->yOld + 2);
$this->objpdf->Setfont('Arial', 'B', 5);
$this->objpdf->text(12, $this->yOld + 2, 'OBSERVAÇÕES');
$this->objpdf->Setfont('Arial', '', 8);
// aqui tem que colocar a obs
$this->objpdf->MultiCell(110, 3, $this->dadosPrestador->q51_obs, 0, "J");
$this->objpdf->Setfont('Arial', '', 10);

//valores totais da nota
$this->objpdf->sety($this->yOld);
$this->objpdf->setX(125);
$this->objpdf->Setfont('Arial', '', 10);
$this->objpdf->cell(40, 5, "Valor dos Serviços", 1, 0);
$this->objpdf->Setfont('Arial', '', 10);
$this->objpdf->cell(35, 5, "R$ " . number_format($this->fTotaliUni, 2, ",", "."), 1, 1, "R");
$this->objpdf->setX(125);
$this->objpdf->cell(40, 5, "Valor ISSQN", 1, 0);
$this->objpdf->cell(35, 5, "R$ " . number_format($this->fvlrIssqn, 2, ",", "."), 1, 1, "R");

$this->objpdf->setX(125);
$this->objpdf->cell(40, 5, "Valor INSS", 1, 0);
$this->objpdf->cell(35, 5, "R$ " . number_format($this->fvlrInss, 2, ",", "."), 1, 1, "R");

$this->objpdf->setX(125);
$this->objpdf->cell(40, 5, "Valor IRRF", 1, 0);
$this->objpdf->cell(35, 5, "R$ " . number_format($this->fvlrIrrf, 2, ",", "."), 1, 1, "R");

$fTotalNota = $this->fTotaliUni;

// valor total da nota
if ($lTomadorEhPrefeitura) {
    $fTotalNota = $this->fTotaliUni - $this->fvlrIssqn - $this->fvlrInss - $this->fvlrIrrf;
}

$this->objpdf->setX(125);
$this->objpdf->cell(40, 5, "Valor Líquido da Nota", 1, 0);
$this->objpdf->Setfont('Arial', '', 10);
$this->objpdf->cell(35, 5, "R$ " . number_format(($fTotalNota), 2, ",", "."), 1, 1, "R");

$this->objpdf->sety(255);
$this->objpdf->Setfont('Arial', 'B', 10);
$this->objpdf->cell(30, 20,"Avisos", "LTB", 0, "C");
$this->objpdf->Setfont('Arial', '', 8);
$this->objpdf->rect(40, $this->yOld + 30, 160, 20);
$this->objpdf->MultiCell(160, 5,$this->texto_aviso, 0, "L");