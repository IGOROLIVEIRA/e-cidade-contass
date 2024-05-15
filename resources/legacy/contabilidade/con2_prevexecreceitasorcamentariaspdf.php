<?php

require_once("fpdf151/pdf.php");
require_once ("fpdf151/PDFDocument.php");

class PDFPrevExecReceitasOrcamentarias extends PDF {

  function Header() {

    global $conn;
    global $result;
    global $url;
    global $aUnidades;
    $iOrgao   = null;
    $iUnidade = null;

    $sSqlInstit  =  "select nomeinst,";
    $sSqlInstit .=  "       trim(ender)||','||trim(numero::VARCHAR) as ender,";
    $sSqlInstit .=  "       munic, ";
    $sSqlInstit .=  "       uf,";
    $sSqlInstit .=  "       telef,";
    $sSqlInstit .=  "       email,";
    $sSqlInstit .=  "       url,";
    $sSqlInstit .=  "       cgc,";
    $sSqlInstit .=  "       logo ";
    $sSqlInstit .=  "  from db_config ";
    $sSqlInstit .=  " where codigo = ".db_getsession("DB_instit");
    $dados = db_query($conn, $sSqlInstit);
    $url = @pg_result($dados,0,"url");
    $this->SetXY(1,1);
    $this->Image('imagens/files/'.pg_result($dados,0,"logo"),7,3,20);

    //$this->Cell(100,32,"",1);
    $nome = pg_result($dados,0,"nomeinst");
    global $nomeinst;

    $nomeinst = pg_result($dados,0,"nomeinst");

    if(strlen($nome) > 42)
      $TamFonteNome = 8;
    else
      $TamFonteNome = 9;

    $this->SetFont('Arial','BI',$TamFonteNome);
    $sCnpj = pg_result($dados,0,"cgc");
    if (isset($oDadosUnidade) && $oDadosUnidade->o41_descr != "") {

      $nome  = $oDadosUnidade->o41_descr;
      $sCnpj =  $oDadosUnidade->o41_cnpj;
    }
    $this->Text(33,9, $nome);
    $this->SetFont('Arial','I',8);
    $this->Text(33,12,trim(pg_result($dados,0,"ender")));
    $this->Text(33,16,"CNPJ: ".trim(db_formatar($sCnpj,"cnpj")));
    $this->Text(33,20,trim(pg_result($dados,0,"munic"))." - ".pg_result($dados,0,"uf"));
    $this->Text(33,24,trim(pg_result($dados,0,"telef")));
    $this->Text(33,28,trim(pg_result($dados,0,"email")));
    $comprim = ($this->w - $this->rMargin - $this->lMargin);
    $this->Text(33,32,$url);
    $Espaco = $this->w - 80 ;
    $this->SetFont('Arial','',7);
    $margemesquerda = $this->lMargin;
    $this->setleftmargin($Espaco);
    $this->sety(6);
    $this->setfillcolor(235);
    $this->roundedrect($Espaco - 3,5,75,28,2,'DF','123');
    $this->line(10,33,$comprim,33);
    $this->setfillcolor(255);
    $this->multicell(0,3,@$GLOBALS["head1"],0,1,"J",0);
    $this->multicell(0,3,@$GLOBALS["head2"],0,1,"J",0);
    $this->multicell(0,3,@$GLOBALS["head3"],0,1,"J",0);
    $this->multicell(0,3,@$GLOBALS["head4"],0,1,"J",0);
    $this->multicell(0,3,@$GLOBALS["head5"],0,1,"J",0);
    $this->multicell(0,3,@$GLOBALS["head6"],0,1,"J",0);
    $this->multicell(0,3,@$GLOBALS["head7"],0,1,"J",0);
    $this->multicell(0,3,@$GLOBALS["head8"],0,1,"J",0);
    $this->multicell(0,3,@$GLOBALS["head9"],0,1,"J",0);
    $this->setleftmargin($margemesquerda);
    $this->SetY(35);

  }

  /**
   * Imprime o cabeçalho do relatório
   * @return void
   */
  public function imprimirCabecalhoDoRelatorio($oPdf,$tm_concarpeculiar) {

    $alt = 4;
    $tm_valor =17;
    $tm_estrut = 24;
    $tm_reduz = 10;
    $pagina = 0;

//    $oPdf->addpage('L');

    $oPdf->setfont('arial','b',7);
    $oPdf->cell($tm_estrut,$alt,"Códigos",0,0,"L",0);
//    $oPdf->cell($tm_descr,$alt,"Descrição das Contas de Receitas Orçamentárias",0,0,"L",0);
    $oPdf->MultiCell(35, 5, "Descrição das Contas de Receitas Orçamentárias", 1, PDFDocument::ALIGN_CENTER);

    $oPdf->cell(60,$alt,"Receitas Orçamentárias",0,0,"L",0);
    $oPdf->cell($tm_concarpeculiar,$alt,"Previsão Inicial das Receitas Brutas (a)",0,0,"L",0);
    $oPdf->cell($tm_reduz,$alt,"Previsão Atualizada das Receitas Brutas (b)",0,0,"L",0);
    $oPdf->cell($tm_reduz,$alt,"Receitas Realizadas Brutas (c)",0,0,"L",0);
    $oPdf->cell($tm_valor,$alt,"PREVISTO",0,0,"R",0);
    $oPdf->cell($tm_valor,$alt,"PREV.ADIC.",0,0,"R",0);
    $oPdf->cell($tm_valor,$alt,"ARRECADADO",0,0,"R",0);
    $oPdf->cell($tm_valor,$alt,"ARREC. ANO",0,0,"R",0);
    $oPdf->cell($tm_valor,$alt,"DIFERENÇA",0,0,"R",0);

    $oPdf->cell(10,$alt,"Perc",0,1,"R",0);
    $oPdf->ln(3);

    return $oPdf;

  }

  /*
   * Retorna uma descrição dentro do limite de caracteres informado
   */
  public function limitarTexto($sTexto, $iLimite){
    if( strlen($sTexto) > (int)$iLimite ){
      $sTextoLimitado = mb_substr($sTexto, 0, $iLimite-3);
      return $this->limitarTexto($sTextoLimitado, $iLimite)."...";
    }else if(strlen(preg_replace('![^A-Z]+!', '', $sTexto)) >= 35){
      return trim(mb_substr($sTexto, 0, 45))."...";
    }
    return $sTexto;

  }

}