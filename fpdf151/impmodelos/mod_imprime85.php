<?
global $db61_texto, $db02_texto;
$nTotalRetencaoRecolhido = 0;
$iInstituicao = db_getsession("DB_instit");
for ($xxx = 0; $xxx < $this->nvias; $xxx++) {

  $this->objpdf->AliasNbPages();
  $this->objpdf->AddPage();
  $this->objpdf->settopmargin(1);
  $pagina = 1;
  $xlin = 20;
  $xcol = 12;
  $ano = $this->ano;

  $this->objpdf->setfillcolor(245);
  $this->objpdf->rect($xcol - 2, $xlin - 18, 198, 292, 2, 'DF', '1234');
  $this->objpdf->setfillcolor(255, 255, 255);
  $this->objpdf->Setfont('Arial', 'B', 10);
  $this->objpdf->text(128, $xlin - 10, 'PAGAMENTO DE DESPESA ORÇAMENTARIA');
  $this->objpdf->Setfont('Arial', 'B', 10);
  $this->objpdf->text(128, $xlin - 6, 'ORDEM DE PAGAMENTO N' . CHR(176) . ': ');
  $this->objpdf->Setfont('Arial', 'B', 11);
  $this->objpdf->text(179, $xlin - 6, $this->ordpag);
  $this->objpdf->Setfont('Arial', 'B', 10);
  $this->objpdf->text(128, $xlin - 2, 'LIQUIDAÇÃO N' . CHR(176) . ': ');
  $this->objpdf->text(179, $xlin - 2, $this->codemp . ' / ' . $this->numliquidacao);
  $this->objpdf->Image('imagens/files/' . $this->logo, 15, $xlin - 17, 12);
  $this->objpdf->Setfont('Arial', 'B', 9);
  $this->objpdf->text(40, $xlin - 15, $this->prefeitura);
  $this->objpdf->Setfont('Arial', '', 9);
  $this->objpdf->text(40, $xlin - 11, $this->enderpref);
  $this->objpdf->text(40, $xlin - 8, $this->municpref);
  $this->objpdf->text(40, $xlin - 5, $this->telefpref);
  $this->objpdf->text(40, $xlin - 2, $this->emailpref);
  $this->objpdf->text(40, $xlin + 1, db_formatar($this->cgcpref, 'cnpj'));

  // retangulo dos dados da dotação
  $this->objpdf->rect($xcol, $xlin + 2, $xcol + 90, 41, 2, 'DF', '1234');
  $this->objpdf->Setfont('Arial', 'B', 8);

  $this->objpdf->text($xcol + 2, $xlin + 5, 'Órgão');
  $this->objpdf->text($xcol + 2, $xlin + 9, 'Unidade');
  $this->objpdf->text($xcol + 2, $xlin + 13, 'Função');
  $this->objpdf->text($xcol + 2, $xlin + 17, 'Subfunção');

  $this->objpdf->text($xcol + 2, $xlin + 21, 'Proj/Ativ');
  $this->objpdf->text($xcol + 2, $xlin + 25, 'Elemento');
  $this->objpdf->text($xcol + 2, $xlin + 32, 'Recurso');
  $this->objpdf->text($xcol + 2, $xlin + 35.7, 'CO');
  $this->objpdf->text($xcol + 2, $xlin + 39, 'Processo');
  $this->objpdf->text($xcol + 2, $xlin + 42, 'Tipo Compra');
  $this->objpdf->text($xcol + 70, $xlin + 39, 'Reduzido:');
  $this->objpdf->Setfont('Arial', '', 8);
  $this->objpdf->text($xcol + 17, $xlin + 5, ' :  ' . db_formatar($this->orgao, 'orgao') . ' - ' . substr($this->descr_orgao, 0, 46));
  $this->objpdf->text($xcol + 17, $xlin + 9, ' :  ' . db_formatar($this->unidade, 'unidade') . ' - ' . $this->descr_unidade);
  $this->objpdf->text($xcol + 17, $xlin + 13, ' :  ' . db_formatar($this->funcao, 'funcao') . ' - ' . $this->descr_funcao);
  $this->objpdf->text($xcol + 17, $xlin + 17, ' :  ' . db_formatar($this->subfuncao, 'funcao') . ' - ' . $this->descr_subfuncao);

  $this->objpdf->text($xcol + 17, $xlin + 21, ' :  ' . db_formatar($this->projativ, 'projativ') . ' - ' . $this->descr_projativ);
  $this->objpdf->text($xcol + 17, $xlin + 25, ' :  ' . db_formatar($this->elemento, 'elemento_alt'));
  $this->objpdf->text($xcol + 17, $xlin + 28, '   ' . mb_strtoupper(substr($this->descr_elemento, 0, 55)));
  $this->objpdf->text($xcol + 17, $xlin + 32, ' :  ' . substr($this->recurso . ' - ' . $this->descr_recurso, 0, 50));
  $this->objpdf->text($xcol + 17, $xlin + 35.7, ' :  ' . $this->codco);
  $this->objpdf->text($xcol + 17, $xlin + 39, ' :  ' . $this->processo);
  $this->objpdf->text($xcol + 21, $xlin + 42, ':  ' . $this->descr_tipocompra);
  $this->objpdf->text($xcol + 85, $xlin + 39, $this->coddot);

  // retangulo dos dados do credor
  $this->objpdf->rect($xcol + 106, $xlin + 2, 88, 32, 2, 'DF', '1234');
  $this->objpdf->Setfont('Arial', '', 6);
  $this->objpdf->text($xcol + 107, $xlin + 4, 'Dados do Credor:');
  $this->objpdf->Setfont('Arial', 'B', 8);
  $this->objpdf->text($xcol + 107, $xlin + 7, 'Nº Credor');
  $this->objpdf->text($xcol + 150, $xlin + 7, (strlen($this->cnpj) == 11 ? 'CPF' : 'CNPJ'));
  $this->objpdf->text($xcol + 107, $xlin + 15, 'Banco/Ag./Conta');
  $this->objpdf->text($xcol + 107, $xlin + 11, 'Nome');
  $this->objpdf->text($xcol + 107, $xlin + 19, 'Município');
  $this->objpdf->text($xcol + 107, $xlin + 23, 'Endereço');
  $this->objpdf->text($xcol + 107, $xlin + 27, 'Bairro');
  $this->objpdf->text($xcol + 150, $xlin + 31, 'Telefone');
  $this->objpdf->text($xcol + 107, $xlin + 31, 'Número');
  $this->objpdf->Setfont('Arial', '', 8);
  $this->objpdf->text($xcol + 122, $xlin + 7, ': ' . $this->numcgm);
  $this->objpdf->text($xcol + 157, $xlin + 7, ' :  ' . (strlen($this->cnpj) == 11 ? db_formatar($this->cnpj, 'cpf') : db_formatar($this->cnpj, 'cnpj')));
  $this->objpdf->text($xcol + 122, $xlin + 11, ': ' . $this->nome);
  $this->objpdf->text($xcol + 122, $xlin + 23, ': ' . $this->ender . ' ' . $this->compl);
  $this->objpdf->text($xcol + 122, $xlin + 27, ': ' . $this->bairro);
  $this->objpdf->text($xcol + 122, $xlin + 19, ': ' . $this->munic . '-' . $this->ufFornecedor . '    CEP : ' . $this->cep);
  if ($this->banco != null) {
    $agenciadv = "";
    $contadv = "";
    if (trim($this->agenciadv) != "") {
      $agenciadv = "-" . $this->agenciadv;
    }
    if (trim($this->contadv) != "") {
      $contadv = "-" . $this->contadv;
    }
    if ($this->tipoconta == 1) {
      $abreviatura = "C/C";
    } else {
      $abreviatura = "C/I";
    }
    $this->objpdf->text($xcol + 131, $xlin + 15, ': ' . $this->banco . ' / ' . $this->agencia . $agenciadv . ' / ' . $this->conta . $contadv . ' - ' . $abreviatura);
  }
  $this->objpdf->text($xcol + 163, $xlin + 31, ': ' . $this->telef);
  $this->objpdf->text($xcol + 122, $xlin + 31, ': ' . $this->fax);

  // retangulo do empenho
  $this->objpdf->rect($xcol + 106, $xlin + 36, 43, 5, 2, 'DF', '1234');
  $this->objpdf->rect($xcol + 151, $xlin + 36, 43, 5, 2, 'DF', '1234');

  // retangulo dos itens
  $this->objpdf->rect($xcol, $xlin + 55, 194, 24, 2, 'DF', '');
  $this->objpdf->rect($xcol, $xlin + 48, 194, 75, 2, 'DF', '12');
  $this->objpdf->rect($xcol + 145, $xlin + 48, 24, 7, 2, 'DF', '12');
  $this->objpdf->rect($xcol + 169, $xlin + 48, 25, 7, 2, 'DF', '12');

  // retangulo das retenções
  $this->objpdf->rect($xcol + 169, $xlin + 176, 25, 8, 2, 'DF', '34');      //retângulo total líquido da ordem
  $this->objpdf->rect($xcol + 169, $xlin + 170, 25, 6, 2, 'DF', '');        //retângulo total retenções
  $this->objpdf->rect($xcol, $xlin + 130, 75, 54, 2, 'DF', '12');      //retângulo repasses
  $this->objpdf->rect($xcol + 75, $xlin + 130, 19, 54, 2, 'DF', '12');      //retângulo valores repasses

  $this->objpdf->rect($xcol + 94, $xlin + 130, 75, 40, 2, 'DF', '12');       //retângulo retenções
  $this->objpdf->rect($xcol + 94, $xlin + 170, 75, 6, 2, 'DF', '');         //retângulo label total retenções
  $this->objpdf->rect($xcol + 94, $xlin + 176, 75, 8, 2, 'DF', '34');       //retângulo label líquido da ordem
  $this->objpdf->rect($xcol + 169, $xlin + 130, 25, 40, 2, 'DF', '12');      //retângulo valores retenções

  $this->objpdf->Setfont('Arial', '', 7);
  $this->objpdf->text($xcol + 108, $xlin + 40, 'Empenho N' . chr(176));
  $this->objpdf->text($xcol + 153, $xlin + 40, 'Valor do Empenho');
  $this->objpdf->Setfont('Arial', '', 8);
  $this->objpdf->text($xcol + 124, $xlin + 40, db_formatar($this->numemp, 's', '0', 6, 'e'));
  $this->objpdf->text($xcol + 174, $xlin + 40, db_formatar($this->empenhado, 'f'));

  $this->objpdf->Setfont('Arial', 'B', 6);

  // monta os dados dos elementos da ordem de compra
  $this->objpdf->SetWidths(array(20, 80, 20, 23, 23, 25));
  $this->objpdf->SetAligns(array('L', 'L', 'R', 'R', 'R', 'R'));
  $this->objpdf->setleftmargin(12);
  $this->objpdf->setxy($xcol + 1, $xlin + 50);
  $this->objpdf->Setfont('Arial', 'B', 10);
  $this->objpdf->multicell(100, 4, 'Dados do Pagamento', 0, 456);
  $this->objpdf->setxy($xcol + 129, $xlin + 48);
  $this->objpdf->Setfont('Arial', 'B', 6);
  $this->objpdf->text($xcol + 150, $xlin + 51, 'VALOR PAGO');
  $this->objpdf->text($xcol + 171, $xlin + 51, 'VALOR ESTORNADO');
  $this->objpdf->setxy($xcol + 145, $xlin + 51.5);
  $this->objpdf->Setfont('Arial', '', 7);

  $this->objpdf->Setfont('Arial', 'B', 7);
  $this->objpdf->text($xcol + 2, $xlin + 58, 'BANCO:');
  $this->objpdf->text($xcol + 2, $xlin + 62, 'AGENCIA: ');
  $this->objpdf->text($xcol + 2, $xlin + 66, 'CONTA: ');
  $this->objpdf->text($xcol + 2, $xlin + 70, 'MOVIMENTO: ');
  $this->objpdf->text($xcol + 2, $xlin + 74, 'TIPO/ N' . CHR(176) . ' DOCUMENTO: ');
  $this->objpdf->text($xcol + 2, $xlin + 78, 'DATA DO PAGAMENTO: ');
  $this->objpdf->Setfont('Arial', '', 7);
  $this->objpdf->text($xcol + 13, $xlin + 58, $this->bancoPagamento);
  $this->objpdf->text($xcol + 15, $xlin + 62, $this->agenciaPagamento);
  $this->objpdf->text($xcol + 12.5, $xlin + 66, $this->contaPagamento);
  $this->objpdf->text($xcol + 19, $xlin + 70, $this->movimento);
  $this->objpdf->text($xcol + 31, $xlin + 74, $this->tipoDocumento);
  $this->objpdf->text($xcol + 32, $xlin + 78, $this->dataPagamento);

  // monta os dados das retenções da ordem de compra
  $this->objpdf->SetWidths(array(12, 58, 23));
  $this->objpdf->SetAligns(array('C', 'L', 'R'));
  $this->objpdf->setxy($xcol + 10, $xlin + 134);
  $this->objpdf->Setfont('Arial', 'B', 10);

  $this->objpdf->text($xcol + 2, $xlin + 128, 'Dados das Retenções');

  $this->objpdf->Setfont('Arial', 'b', 7);
  $this->objpdf->SetX($this->objpdf->GetX() - 8);
  $this->objpdf->cell(10, 0, 'COD.', 0, 0, "L");
  $this->objpdf->cell(55, 0, 'DESCRIÇÃO', 0, 0, "L"); //Cabeçalho da primeira coluna de retenções
  $this->objpdf->cell(26, 0, 'VALOR', 0, 1, "R");

  $this->objpdf->Setfont('Arial', '', 7);
  $total_ret                = 0;
  $total_ret_outras         = 0;
  $iTotalRetencaoRecolhido  = 0;
  $iii = 0;
  if (is_array($this->aRetencoes) && count($this->aRetencoes) > 0) {

    foreach ($this->aRetencoes as $retencao) {
      if ($retencao->e27_empagemov == $this->movimento) {
        if ($iii == 15) {
          $this->objpdf->SetWidths(array(12, 63, 23));
          $this->objpdf->Setfont('Arial', 'b', 7);
          $this->objpdf->setxy($xcol + 97, $xlin + 134);
          $this->objpdf->cell(10, 0, 'COD.', 0, 0, "L");
          $this->objpdf->cell(60, 0, 'DESCRIÇÃO', 0, 0, "L"); //Cabeçalho da segunda coluna de retenções
          $this->objpdf->cell(26, 0, 'VALOR', 0, 1, "R");
          $this->objpdf->sety($xlin + 134);
        }

        if ($iii >= 15) {
          $this->objpdf->setx($xcol + 95);
        }

        if ($iii < 25) {
          $this->objpdf->Setfont('Arial', '', 7);
          $this->objpdf->Row(
            array(
              $retencao->e21_sequencial,
              substr($retencao->e21_descricao, 0, 40),
              db_formatar($retencao->e23_valorretencao, 'f')
            ),
            6,
            false,
            3
          );
        } else {
          $total_ret_outras += $retencao->e23_valorretencao;
        }
        $total_ret += $retencao->e23_valorretencao;
        $iii++;
      }
    }

    if ($iii > 25) {

      $this->objpdf->Setfont('Arial', '', 7);
      $this->objpdf->Row(
        array(
          "",
          substr("OUTRAS RETENÇÕES", 0, 40),
          db_formatar($total_ret_outras, 'f')
        ),
        6,
        false,
        3
      );
    }
  }

  $this->objpdf->Setfont('Arial', '', 7);
  if($this->vlrPago == 0){
    if($this->vlrEstorno > 0){
      $valorPago = $this->vlrEstorno;
    }else if ($total_ret > 0){
      $valorPago = $total_ret;
    }else{
      $valorPago = $this->vlrPago;
    }
  }else{
    $valorPago = $this->vlrPago;
  }

  $this->objpdf->text($xcol + 148, $xlin + 54, db_formatar($valorPago, 'f'));
  $this->objpdf->text($xcol + 172.3, $xlin + 54, db_formatar($this->vlrEstorno, 'f'));

  $this->objpdf->Setfont('Arial', 'B', 7);
  // define propriedades para os totais
  $this->objpdf->setxy($xcol + 100, $xlin + 55);
  $this->objpdf->Setfont('Arial', '', 7);

  $this->objpdf->setxy($xcol + 123, $xlin + 61);
  $this->objpdf->Setfont('Arial', 'b', 8);
  $this->objpdf->text($xcol + 2, $xlin + 84, 'OBSERVAÇÕES :');
  $this->objpdf->Setfont('Arial', '', 7);

  // descrição da observação
  $this->objpdf->setxy($xcol, $xlin + 85);
  $this->objpdf->Setfont('Arial', '', 7);
  $this->objpdf->multicell(190, 4, substr($this->obs, 0, 456));

  // total das retenções
  $this->objpdf->setxy($xcol + 127, $xlin + 172);
  $this->objpdf->Setfont('Arial', 'B', 7);
  $this->objpdf->cell(42, 5, 'VALOR TOTAL DAS RETENÇÕES: ', 0, 0, "R");
  $this->objpdf->cell(23, 5, db_formatar($total_ret, 'f'), 0, 1, "R");

  // total dos repasses
  $this->objpdf->setxy($xcol, $xlin + 181);
  $this->objpdf->Setfont('Arial', 'B', 7);

  // liquido da ordem de pagamento
  $this->objpdf->setxy($xcol + 127, $xlin + 181);
  $this->objpdf->Setfont('Arial', 'B', 7);
  $this->objpdf->cell(43, 1, 'VALOR LÍQUIDO DA DESPESA: ', 0, 0, "R");
  $this->objpdf->Setfont('Arial', 'B', 9);

  if($this->vlrPago == 0){
    $nValorSaldo = 0;
  }else{
    if ($this->vlrEstorno > 0) {
      $nValorSaldo = $this->vlrPago - $this->vlrEstorno;
    } else {
      $nValorSaldo = $this->vlrPago - ($total_ret + $this->vlrEstorno);
    }
  }

  $this->objpdf->cell(23, 1, db_formatar($nValorSaldo, 'f'), 0, 1, "R");
  $this->objpdf->Setfont('Arial', 'B', 7);

  // Assinaturas e Canhoto
  $sqlparag  = "select db02_texto                                             ";
  $sqlparag .= "  from db_documento                                           ";
  $sqlparag .= "       inner join db_docparag  on db03_docum   = db04_docum   ";
  $sqlparag .= "       inner join db_tipodoc   on db08_codigo  = db03_tipodoc ";
  $sqlparag .= "       inner join db_paragrafo on db04_idparag = db02_idparag ";
  $sqlparag .= " where db03_tipodoc = 1509 and db03_instit = " . db_getsession("DB_instit") . " order by db04_ordem ";
  //   die($sqlparag);
  $resparag = @db_query($sqlparag);
  if (@pg_numrows($resparag) > 0) {
    db_fieldsmemory($resparag, 0);
    /**[extensao ordenadordespesa] doc_usuario*/
    eval($db02_texto);
  } else {
    $sqlparagpadrao  = "select db61_texto ";
    $sqlparagpadrao .= "  from db_documentopadrao ";
    $sqlparagpadrao .= "       inner join db_docparagpadrao  on db62_coddoc   = db60_coddoc ";
    $sqlparagpadrao .= "       inner join db_tipodoc         on db08_codigo   = db60_tipodoc ";
    $sqlparagpadrao .= "       inner join db_paragrafopadrao on db61_codparag = db62_codparag ";
    $sqlparagpadrao .= " where db60_tipodoc = 1509 and db60_instit = " . db_getsession("DB_instit") . " order by db62_ordem";

    $resparagpadrao = @db_query($sqlparagpadrao);
    if (@pg_numrows($resparagpadrao) > 0) {
      db_fieldsmemory($resparagpadrao, 0);

      /**[extensao ordenadordespesa] doc_padrao*/
      eval($db61_texto);
    }
  }

  $this->objpdf->SetFont('Arial', '', 4);
  $this->objpdf->Text(2, 296, $this->texto);
  $this->objpdf->SetFont('Arial', '', 6);
  $this->objpdf->Text(200, 296, ($xxx + 1) . 'ª via');
  $this->objpdf->setfont('Arial', '', 11);
  $xlin = 169;
}
