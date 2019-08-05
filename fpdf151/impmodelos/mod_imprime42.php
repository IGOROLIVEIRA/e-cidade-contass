<?
$this->objpdf->AliasNbPages();
$this->objpdf->AddPage();
$this->objpdf->sety(94);

if(strlen(trim($this->telefinstit)) == 10 ){
  $padrao = '(%%) %%%% - %%%%';
  $telefone = vsprintf(str_replace('%', "%s", $padrao), str_split($this->telefinstit));
}

$this->objpdf->sety(20);
$this->objpdf->setx(85);
$this->objpdf->Setfont("times", "", 10);
if($telefone)
  $this->objpdf->cell(40, 5, "Telefone: ".$telefone, 0, 0, 'R');


$this->objpdf->sety(10);
$this->objpdf->setx(170);
$this->objpdf->Setfont("times", "B", 12);
$sNumeroProtocolo = $this->p58_numero."/".$this->p58_ano;
$this->objpdf->cell(20, 5, $sNumeroProtocolo, 0, 0, 'L');
$descrdepto = pg_result($resproc,0,1);

$this->objpdf->sety(15);
$this->objpdf->setx(160);

$sqlproc = "select coddepto,descrdepto,p51_descr
        from andpadrao
        inner join db_depart on coddepto = p53_coddepto
        inner join tipoproc on p51_codigo = p53_codigo where p53_codigo = ".$this->p58_codigo ."";

$resproc = pg_query($sqlproc);
$descrdepto = pg_result($resproc,0,1);

$this->objpdf->sety(40);
$this->objpdf->Setfont("times", "B", 30);
$this->objpdf->cell(0, 0, ' ' , 0, 0, 'L',0,'', '-');
$this->objpdf->setXY(12, $this->objpdf->getY());
$this->objpdf->cell(0, 0, ' ' , 0, 1, 'L',0,'', '-');
$this->objpdf->ln(1);
$this->objpdf->Setfont("times", "B", 12);
$this->objpdf->cell(35, 6, "Protocolo N: ", 0, 0, 'R');
$this->objpdf->Setfont("times", "", 11);
$this->objpdf->cell(30, 6, $sNumeroProtocolo, 0, 1, 'L');
$this->objpdf->Setfont("times", "B", 12);
$this->objpdf->Cell(35, 6, "Assunto: ", 0, 0, "R");
$this->objpdf->Setfont("times", "", 11);
$this->objpdf->multicell(100, 6, $this->p51_descr , 0, 1, 'L');

if ($this->p58_dtproc  != "") {
  $this->objpdf->Setfont("times", "B", 12);
  $this->objpdf->cell(35, 6, ("Data: "), 0, 0, 'R');
  $this->objpdf->Setfont("times", "", 11);
  $this->objpdf->cell(75, 6, db_formatar($this->p58_dtproc , 'd'), 0, 1, 'L');
}

$this->objpdf->Setfont("times", "B", 12);
$this->objpdf->cell(35, 6, "Departamento: ", 0, 0, 'R');
$this->objpdf->Setfont("times", "", 11);
$this->objpdf->cell(75, 6, $descrdepto , 0, 1, 'L');

$this->objpdf->Setfont("times", "B", 12);
$this->objpdf->cell(35, 6, "Titular: ", 0, 0, 'R');
$this->objpdf->Setfont("times", "", 11);
$this->objpdf->cell(75, 6, $this->z01_nome , 0, 1, 'L');

if ($this->z01_cgccpf  != "") {
  $this->objpdf->Setfont("times", "B", 12);
  $this->objpdf->cell(35, 6, (strlen($this->z01_cgccpf ) == 11 ? "CPF: " : "CNPJ: "), 0, 0, 'R');
  $this->objpdf->Setfont("times", "", 11);
  $this->objpdf->cell(40, 6, $this->z01_cgccpf , 0, 1, 'L');
}

if (trim($this->p58_requer ) != trim($this->z01_nome )) {
  $this->objpdf->Setfont("times", "B", 12);
  $this->objpdf->cell(35, 6, "Requerente: ", 0, 0, 'R');
  $this->objpdf->Setfont("times", "", 11);
  $this->objpdf->cell(75, 6, $this->p58_requer , 0, 1, 'L');
}


$this->objpdf->Setfont("times", "B", 12);
$this->objpdf->cell(35, 6, "Endere�o: ", 0, 0, 'R');
$this->objpdf->Setfont("times", "", 11);
$this->objpdf->cell(75, 6, $this->z01_ender . ($this->z01_numero  != "" ? ", " : "").$this->z01_numero .
  ($this->z01_compl  != "" ? " - " : "").$this->z01_compl.($this->z01_bairro != "" ? ", " : "").$this->z01_bairro, 0, 1, 'L');


$this->objpdf->Setfont("times", "B", 12);
$this->objpdf->cell(35, 6, "Munic�pio: ", 0, 0, 'R');
$this->objpdf->Setfont("times", "", 11);
$this->objpdf->cell(75, 6, $this->z01_munic , 0, 1, 'L');
$this->objpdf->Setfont("times", "B", 30);
$this->objpdf->cell(0, 0, ' ' , 0, 0, 'L',0,'', '-');
$this->objpdf->setXY(12, $this->objpdf->getY());
$this->objpdf->cell(0, 0, ' ' , 0, 1, 'L',0,'', '-');

// $this->objpdf->sety(92);
$this->objpdf->Setfont("times", "B", 12);
$this->objpdf->setxy(13, $this->objpdf->gety()+4);
$this->objpdf->cell(50, 6, "Observa��es: ", 0, 1, 'L');
$this->objpdf->Setfont("times", "", 10);

$result_impusu = pg_exec("select p90_impusuproc from protparam where p90_instit=".db_getsession("DB_instit"));
if (pg_numrows($result_impusu) > 0) {
  $p90_impusuproc = pg_result($result_impusu,0,0);
  if ($p90_impusuproc == 't') {
    if ($this->nome  != "") {
      $this->objpdf->Setfont("Times", "B", 12);
      $this->objpdf->cell(90, 5, ("USU�RIO QUE CRIOU O PROCESSO: "), 0, 0, 'L');
      $this->objpdf->Setfont("Times", "", 11);
      $this->objpdf->cell(75, 5, $this->nome , 0, 1, 'L');
    }
  }
}



if (pg_num_rows($resproc)) {
  $coddepto   = pg_result($resproc,0,0);
  $descrdepto = pg_result($resproc,0,1);
  $p51_descr = pg_result($resproc,0,2);
  $this->objpdf->setfillcolor(235);
  $this->objpdf->Setfont("Times", "B", 10);
    $sqldepto = "select p90_impdepto from protparam where p90_instit = ".db_getsession('DB_instit');
  $resultdepto = pg_exec($sqldepto);
  $impdepto = pg_result($resultdepto,0,0);
  if ($impdepto == 't') {
    $this->objpdf->setx(13);
    $this->objpdf->cell(0, 6, "DEPARTAMENTO PADR�O: $coddepto - $descrdepto", 0, 1, 'L', 1);
  }
}


$this->objpdf->Setfont("times", "", 10);
$this->objpdf->setx(13);

$texto = db_formatatexto(strlen($this->p58_obs)*0.03, 0, $this->p58_obs, "t");
$this->objpdf->multicell(185, 5,$texto,0,1,"L");

// Variaveis
if ($this->result_vars != ""){
     $numrows     = pg_numrows($this->result_vars);
     $result_vars = $this->result_vars;
     $imprime_str = "";
     $separador   = " - ";
     for ($i = 0; $i < $numrows; $i++){
     $rotulo   = pg_result($result_vars,$i,0);
     $conteudo = pg_result($result_vars,$i,1);
     if (($i+1) == $numrows){
          $separador = "";
     }
           $imprime_str .= ucfirst($rotulo).": ".$conteudo."\n";
     }
     $this->objpdf->setx(13);

     $this->objpdf->multicell(0, 5, $imprime_str,0,1,"L");
}
$this->objpdf->Setfont("Times", "", 12);

//////////////////////////////////////////////////////////////////////////////////////////////////

//-----------------------------------DOCUMENTOS---------------------------------------------------

if ($numrows_doc > 0) {
  $m = 0;
  $this->objpdf->cell(180, 2, '', 0, 1, "C");
  for ($y = 0; $y < $numrows_doc; $y ++) {
    $x = " ";
    $this->objpdf->Setfont("Times", "", 10);
    $p81_doc=pg_result($result_doc,$y,0);
    $p56_descr=pg_result($result_doc,$y,1);
    if ($p81_doc == 't') {
      $x = "X";
    }
    $this->objpdf->cell(90, 4, "($x)".substr($p56_descr, 0, 35), 0, $m, "L");
    if ($m == 0) {
      $m = 1;
    } else {
      $m = 0;
    }
  }
}
//-------------------------------------------------------------------------------------------------
$this->objpdf->Setfont("Times", "", 12);
$this->objpdf->SetXY(60, 210);
$this->objpdf->cell(60, 8, "Institui��o", 'T', 0, 'C');
$this->objpdf->cell(20);
$this->objpdf->cell(50, 8, "Requerente / Titular", 'T', 1, 'C');
$this->objpdf->SetXY(140, 220);
$this->objpdf->cell(50, 8, "____/____/_______", 0, 1, 'R');

?>
