<?
$classinatura = new cl_assinatura;

$xlin = 20;
$xcol = 12;
// Condição para multiplas SLIPS OC14441
for ($iDados = 0; $iDados < pg_num_rows($this->dados); $iDados++) {

    $this->objpdf->settopmargin(1);
    $xlin = 20;

    if ($iDados > 0) {
        $this->objpdf->addPage();
        $this->objpdf->AliasNbPages();
    }

    $this->objpdf->setfillcolor(245);
    $this->objpdf->rect($xcol -2, $xlin -18, 196, 292, 2, 'DF', '1234');
    $this->objpdf->setfillcolor(255, 255, 255);
    $this->objpdf->Setfont('Arial', 'B', 10);
    $this->objpdf->Image('imagens/files/'.$this->logo, 15, $xlin -17, 12);
    $this->objpdf->Setfont('Arial', 'B', 9);
    $this->objpdf->text(40, $xlin -14, $this->nomeinst);

    $this->objpdf->Setfont('Arial', 'B', 6);
    $this->objpdf->text(40, $xlin -10, $this->ender);
    $this->objpdf->text(40, $xlin -7, $this->munic);
    $this->objpdf->text(40, $xlin -4, $this->telef);
    $this->objpdf->text(40, $xlin -1, $this->email);
    $this->objpdf->Setfont('Arial', 'B', 16);
    $this->objpdf->text(165, $xlin -8, 'SLIP: ' .  db_formatar(pg_result($this->dados, $iDados, "k17_codigo"), 's', '0', 6, 'e'));

    if (USE_PCASP) {
        $k17_tiposelect = pg_result($this->dados, $iDados, "k17_tiposelect");
        $sEvento = '';
        if ($k17_tiposelect){
            if ($k17_tiposelect == '01'){
                $oTipoSelect = "01 - Aplicação Financeira"; 
            }
            if ($k17_tiposelect == '02'){
                $oTipoSelect = '02 - Resgate de Aplicação Financeira';
            }
            if ($k17_tiposelect == '03'){  
                $oTipoSelect = '03 - Transferência entre contas bancárias';
            }
            if ($k17_tiposelect == '04'){ 
                $oTipoSelect = '04 - Transferências de Valores Retidos';
            }
            if ($k17_tiposelect == '05'){  
                $oTipoSelect = '05 - Depósito decendial educação';
            }
            if ($k17_tiposelect == '06'){  
              $oTipoSelect = '06 - Depósito decendial saúde';
            }
            if ($k17_tiposelect == '07'){  
                $oTipoSelect = '07 - Transferência da Contrapartida do Convênio';
            }
            if ($k17_tiposelect == '08'){
                $oTipoSelect = '08 - Transferência entre contas de fontes diferentes'; 
            }
            if ($k17_tiposelect == '09'){
                $oTipoSelect = '09 - Transferência da conta caixa para esta conta';
            }
            if ($k17_tiposelect == '10'){
                $oTipoSelect = '10 - Saques';
            }
        }
        $sEvento = $oTipoSelect;
        if (empty($k17_tiposelect)){
            $sEvento = pg_result($this->dados, $iDados, "k152_sequencial") . " - " . pg_result($this->dados, $iDados, "k152_descricao");
        }
        $this->objpdf->Setfont('Arial', '', 9);
        $this->objpdf->text(115, $xlin -2, substr("Evento: " . $sEvento, 0, 55), 's', '0', 6, 'e');

    }

    /// retângulo dos dados da transferência
    // Correção OC16590
    $comprimento = 79;
    if (!empty($this->oDadosBancarioCredor))
        $comprimento += 10;
    // Final Oc16590
    $this->objpdf->rect($xcol, $xlin + 2, $xcol +180, $comprimento, 10, 'DF', '1234');
    $this->objpdf->Setfont('Arial', 'B', 9);
    $this->objpdf->text($xcol +2, $xlin +7, 'DATA');
    $this->objpdf->text($xcol +6, $xlin +11,  db_formatar(pg_result($this->dados, $iDados, "k17_data"), 'd'));
    if (pg_result($this->dados, $iDados, "k17_numdocumento")){
        $this->objpdf->text($xcol +80, $xlin +7, 'NÚMERO DO DOCUMENTO');
        $this->objpdf->text($xcol +80, $xlin +11,  pg_result($this->dados, $iDados, "k17_numdocumento"), '');
    }

    $this->objpdf->text($xcol +152, $xlin +7, 'VALOR');

    $this->objpdf->Setfont('Arial', 'B', 11);
    $this->objpdf->text($xcol +156, $xlin +11, 'R$');
    $this->objpdf->text($xcol +158, $xlin +11, db_formatar(pg_result($this->dados, $iDados, "k17_valor"), 'f'));

    $this->objpdf->Setfont('Arial', 'B', 9);

    $this->objpdf->text($xcol +2, $xlin + 18, 'FORNECEDOR');
    $this->objpdf->text($xcol +6, $xlin + 22,  pg_result($this->dados, $iDados, "z01_numcgm"). ' - '. pg_result($this->dados, $iDados, "z01_nome"));

    $tamanho = (strlen(pg_result($this->dados, $iDados, "z01_cgccpf")));

    if ($tamanho == 14) {
        $nomenclatura = 'CNPJ';
        $mascara = 'cnpj';
    } else {
        $nomenclatura = 'CPF';
        $mascara = 'cpf';
    }

    $this->objpdf->text($xcol +2, $xlin + 30, $nomenclatura);
    $this->objpdf->text($xcol +6, $xlin + 34,  db_formatar(pg_result($this->dados, $iDados, "z01_cgccpf"), $mascara));

    /**
     * Dados bancarios do credor
     */
    if (!empty($this->oDadosBancarioCredor)) {
        $this->objpdf->text($xcol + 2, $xlin + 42, 'CONTA BANCÁRIA FORNECEDOR');

        $sTextoDadosBancariosCredor  = 'Banco: ' . $this->oDadosBancarioCredor->iBanco;
        $sTextoDadosBancariosCredor .= ' - '         . $this->oDadosBancarioCredor->sBanco;
        $sTextoDadosBancariosCredor .= ' - Agência: ' . $this->oDadosBancarioCredor->iAgencia;
        $sTextoDadosBancariosCredor .= ' - '         . $this->oDadosBancarioCredor->iAgenciaDigito;
        $sTextoDadosBancariosCredor .= ' - Conta: '   . $this->oDadosBancarioCredor->iConta;
        $sTextoDadosBancariosCredor .= ' - '         . $this->oDadosBancarioCredor->iContaDigito;

        $this->objpdf->text($xcol + 6, $xlin + 46,  $sTextoDadosBancariosCredor);
        $xlin += 12;
    }

    // Oc16590
    $sFonteRecurso = pg_result($this->dados, $iDados, "k29_recurso") . " - " . pg_result($this->dados, $iDados, "o15_descr");
    $this->objpdf->text($xcol + 2, $xlin + 41, "Fonte de Recursos");
    $this->objpdf->text($xcol + 6, $xlin + 45, $sFonteRecurso);
    // FIM Oc16590

    $this->objpdf->text($xcol + 2, $xlin + 54, 'DÉBITO');
    $this->objpdf->text($xcol + 6, $xlin + 58, pg_result($this->dados, $iDados, "k17_debito") . '   -   ' . pg_result($this->dados, $iDados, "descr_debito"));
    if (pg_result($this->dados, $iDados, "banco_debito") != "" && pg_result($this->dados, $iDados, "agencia_debito") != "" && pg_result($this->dados, $iDados, "conta_debito") != "") {

    	$sDadosBancariosDeb = 'Banco: '.pg_result($this->dados, $iDados, "banco_debito");
    	$sDadosBancariosDeb .= ' - Agência: '.pg_result($this->dados, $iDados, "agencia_debito");
    	$sDadosBancariosDeb .= ' - Conta: '.pg_result($this->dados, $iDados, "conta_debito");
    	$sDadosBancariosDeb .= ' - Fonte: '.pg_result($this->dados, $iDados, "fonte_debito");
    	$this->objpdf->text($xcol + 6, $xlin + 62, $sDadosBancariosDeb);
    }
    $this->objpdf->text($xcol + 2, $xlin + 70, 'CRÉDITO');
    $this->objpdf->text($xcol + 6, $xlin + 74, pg_result($this->dados, $iDados, "k17_credito").'   -   '.pg_result($this->dados, $iDados, "descr_credito"));
    if (pg_result($this->dados, $iDados, "banco_credito") != "" && pg_result($this->dados, $iDados, "agencia_credito") != "" && pg_result($this->dados, $iDados, "conta_credito") != "") {

    	$sDadosBancariosCred = 'Banco: '.pg_result($this->dados, $iDados, "banco_credito");
    	$sDadosBancariosCred .= ' - Agência: '.pg_result($this->dados, $iDados, "agencia_credito");
    	$sDadosBancariosCred .= ' - Conta: '.pg_result($this->dados, $iDados, "conta_credito");
    	$sDadosBancariosCred .= ' - Fonte: '.pg_result($this->dados, $iDados, "fonte_credito");
    	$this->objpdf->text($xcol + 6, $xlin + 78, $sDadosBancariosCred);

    }

    /// retângulo do histórico

    $this->objpdf->rect($xcol, $xlin +100, $xcol +180, 60, 10, 'DF', '1234');
    $this->objpdf->Setfont('Arial', 'B', 9);
    $this->objpdf->text($xcol +2, $xlin +105, 'HISTÓRICO');
    $this->objpdf->Setfont('Arial', '', 9);

    $this->objpdf->setxy($xcol +2, $xlin +119);
    $this->objpdf->multicell(190, 3, pg_result($this->dados, $iDados, "k17_texto"), 0, "L");
    $this->objpdf->ln(2);

    if (pg_result($this->dados, $iDados, "k17_situacao") == 3) {
        $this->objpdf->Setfont('Arial', 'b', 8);
        $this->objpdf->SetX($this->objpdf->GetX() +5);
        $this->objpdf->cell(190, 3,"Estornado em ". db_formatar(pg_result($this->dados, $iDados, "k17_dtestorno"),'d'), 0, "L");
        $this->objpdf->Setfont('Arial', '', 8);
        $motivo = substr((pg_result($this->dados, $iDados, "k17_motivoestorno")),0,900);
        $this->objpdf->Setfont('Arial', '', 8);
        $this->objpdf->SetX($this->objpdf->GetX() -190);
        $this->objpdf->cell(190, 3,"Motivo : ".$motivo, 0, "L");
    } else if(pg_result($this->dados, $iDados, "k17_situacao") == 4) {
        $this->objpdf->Setfont('Arial', 'b', 8);
        $this->objpdf->SetX($this->objpdf->GetX() +5);
        $this->objpdf->cell(190, 3,"Anulado em ".db_formatar(pg_result($this->dados, $j, "k17_dtanu"), 'd'), 0, "L");
        $this->objpdf->Setfont('Arial', '', 8);
        $this->objpdf->SetX($this->objpdf->GetX() -190);
        $this->objpdf->cell(190, 8,"Motivo : ".substr(pg_result($this->dados, $j, "k18_motivo"),0,900), 0, "L");
    }

    $ass_pref     = str_replace( "_", "" ,$classinatura->assinatura(1000,"","0") );
    $ass_prefFunc = str_replace( "_", "", $classinatura->assinatura(1000,"","1"));
    $ass_sec      = str_replace( "_", "", $classinatura->assinatura(1002,"","0"));
    $ass_secFunc  = str_replace( "_", "", $classinatura->assinatura(1002,"","1"));
    $ass_tes      = str_replace( "_", "", $classinatura->assinatura(1004,"","0"));
    $ass_tesFunc  = str_replace( "_", "", $classinatura->assinatura(1004,"","1"));
    $ass_cont     = str_replace( "_", "", $classinatura->assinatura(1005,"","0"));
    $ass_contFunc = str_replace( "_", "", $classinatura->assinatura(1005,"","1"));

    // retorna a assinatura e o modelo de recibo conforme a configuração do cliente
    require_once("libs/db_utils.php");
    require_once("libs/db_libdocumento.php");

    $sqlDocPadrao = "select db60_coddoc from db_documentopadrao where db60_instit = ".db_getsession('DB_instit')." and db60_tipodoc = 1705";
    $rsSqlDocPadrao = db_query($sqlDocPadrao);
    $docPadrao = db_utils::fieldsMemory($rsSqlDocPadrao, 0);

    $coddoc = $docPadrao->db60_coddoc;

    $sqlDoc  = "select * from db_documento ";
    $sqlDoc .= "    inner join db_config on db_config.codigo = db_documento.db03_instit ";
    $sqlDoc .= "    inner join db_tipodoc on db_tipodoc.db08_codigo = db_documento.db03_tipodoc ";
    $sqlDoc .= " where db03_tipodoc = 1705 and db03_instit = ".db_getsession('DB_instit')." and db_documento.db03_instit = ".db_getsession('DB_instit');
    $rsSqlDoc = db_query($sqlDoc);
    $doc = db_utils::fieldsMemory($rsSqlDoc, 0);

    if(pg_numrows($rsSqlDoc) > 0){
        $coddoc = $doc->db03_docum;
    }

    $oAssinaturas = new libdocumento(1705, $coddoc);

    $aParagrafo = $oAssinaturas->getDocParagrafos();
    //var_dump($aParagrafo);exit;

    foreach ($aParagrafo as $oParag) {
      if ($oParag->oParag->db02_tipo == 3) {
        $texto = $oParag->oParag->db02_texto;
        eval($texto);
      }
    }
}
?>

