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
  $this->objpdf->text(128, $xlin - 10, 'NOTA DE LIQUIDAÇÃO N' . CHR(176) . ': ');
  $this->objpdf->Setfont('Arial', 'B', 12);
  $this->objpdf->text(179, $xlin - 10, $this->codemp . ' / ' . $this->numliquidacao);
  $this->objpdf->Setfont('Arial', 'B', 10);
  $this->objpdf->text(128, $xlin - 6, 'ORDEM DE PAGAMENTO N' . CHR(176) . ': ');
  $this->objpdf->Setfont('Arial', 'B', 11);
  $this->objpdf->text(179, $xlin - 6, $this->ordpag);
  $this->objpdf->Setfont('Arial', 'B', 10);
  $this->objpdf->text(128, $xlin - 2, 'DATA DE EMISSÃO : ');
  $this->objpdf->text(179, $xlin - 2, $this->emissao);
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
  $this->objpdf->rect($xcol + 145, $xlin + 55,  24,  4, 2, 'DF', '');
  $this->objpdf->rect($xcol + 169, $xlin + 55,  25,  4, 2, 'DF', '');
  $this->objpdf->rect($xcol,     $xlin + 55, 145, 24, 2, 'DF', '');
  $this->objpdf->rect($xcol + 000, $xlin + 48, 194, 75, 2, 'DF', '12');
  $this->objpdf->rect($xcol + 145, $xlin + 48, 24, 31, 2, 'DF', '12');
  $this->objpdf->rect($xcol + 169, $xlin + 48, 25, 31, 2, 'DF', '12');

  // retangulo das retenções
  $this->objpdf->rect($xcol + 169, $xlin + 176, 25, 8, 2, 'DF', '34');      //retângulo total líquido da ordem
  $this->objpdf->rect($xcol + 169, $xlin + 170, 25, 6, 2, 'DF', '');        //retângulo total retenções
  $this->objpdf->rect($xcol + 000, $xlin + 130, 75, 54, 2, 'DF', '12');      //retângulo repasses
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

  $this->objpdf->Setfont('Arial', 'B', 10);
  $this->objpdf->text($xcol + 2, $xlin + 47, 'Especificação da Despesa');
  $this->objpdf->Setfont('Arial', 'B', 6);

  // título do corpo do empenho
  $maiscol = 0;

  // monta os dados dos elementos da ordem de compra
  $this->objpdf->SetWidths(array(20, 80, 20, 23, 23, 25));
  $this->objpdf->SetAligns(array('L', 'L', 'R', 'R', 'R', 'R'));
  $this->objpdf->setleftmargin(12);
  $this->objpdf->sety($xlin + 48);
  $this->objpdf->cell(20, 4, 'ELEMENTO', 0, 0, "L");
  $this->objpdf->cell(80, 4, 'DESCRIÇÃO', 0, 0, "L");
  $this->objpdf->cell(62, 4, 'VALOR', 0, 0, "R");
  $this->objpdf->cell(26, 4, 'ANULADO', 0, 1, "R");
  $this->objpdf->sety($xlin + 51.5);
  $this->objpdf->Setfont('Arial', '', 7);

  $total_pag = 0;
  $total_emp = 0;
  $total_anu = 0;
  $total_sal = 0;
  $total_saldo_final = 0;
  for ($ii = 0; $ii < $this->linhasdositens; $ii++) {
    db_fieldsmemory($this->recorddositens, $ii);

    $this->objpdf->Setfont('Arial', '', 7);
    $this->objpdf->cell(20, 4, (substr(pg_result($this->recorddositens, $ii, $this->elementoitem), 1)), 0, 0, "L");
    $this->objpdf->cell(127.3, 4, (substr(pg_result($this->recorddositens, $ii, $this->descr_elementoitem), 0, 50)), 0, 0, "L");
    $this->objpdf->cell(25.4, 4, db_formatar(pg_result($this->recorddositens, $ii, $this->vlremp), 'f'), 0, 0, "L");
    $this->objpdf->cell(60, 4, db_formatar(pg_result($this->recorddositens, $ii, $this->vlranu), 'f'), 0, 0, "L");


    $total_emp          += pg_result($this->recorddositens, $ii, $this->vlremp);
    $total_anu          += pg_result($this->recorddositens, $ii, $this->vlranu);
    $total_pag          += pg_result($this->recorddositens, $ii, $this->vlrpag);
    $total_sal          += pg_result($this->recorddositens, $ii, $this->vlrsaldo);
    $total_saldo_final  += pg_result($this->recorddositens, $ii, $this->saldo_final);
  }

  $rsNotas = db_query("select e69_numero, e69_nfserie, e69_chaveacesso, e69_dtnota, e50_dtvencimento, e50_naturezabemservico, e101_resumo
  from empnota
  inner join pagordemnota on e71_codnota = e69_codnota and e71_anulado = 'f'
  left  join pagordem    on  e71_codord = e50_codord
  left join naturezabemservico on e50_naturezabemservico = e101_codnaturezarendimento
  where e71_codord = " . $this->ordpag);
  if (pg_numrows($rsNotas) > 0) {
    $this->nota = db_utils::fieldsMemory($rsNotas, 0);
    $this->objpdf->sety($xlin + 55);
    $this->objpdf->Setfont('Arial', 'B', 7);
    $this->objpdf->text($xcol + 1, $xlin + 58, 'NOTA FISCAL Nº: ');
    $this->objpdf->text($xcol + 51, $xlin + 58, 'SÉRIE: ');
    $this->objpdf->text($xcol + 80, $xlin + 58, 'EMITIDA EM: ');
    $this->objpdf->text($xcol + 112, $xlin + 58, 'VENCIMENTO: ');
    $adicionaLinha = 61;
    if ($this->nota->e69_chaveacesso != 'null') {
      $this->objpdf->text($xcol + 1, $xlin + $adicionaLinha, 'CHAVE DE ACESSO: ');
      $this->objpdf->Setfont('Arial', '', 7);
      $this->objpdf->text($xcol + 26, $xlin + $adicionaLinha, $this->nota->e69_chaveacesso);
      $adicionaLinha += 3;
    }
    if ($this->nota->e50_naturezabemservico != null) {
      $this->objpdf->Setfont('Arial', 'B', 7);
      $this->objpdf->text($xcol + 1, $xlin + $adicionaLinha, 'NATUREZA DO RENDIMENTO: ');
      $this->objpdf->Setfont('Arial', '', 7);
      $this->objpdf->text($xcol + 38, $xlin + $adicionaLinha, $this->nota->e50_naturezabemservico . ' - ' . substr($this->nota->e101_resumo, 0, 80) . '...');
    }
    $this->objpdf->Setfont('Arial', '', 7);
    $this->objpdf->text($xcol + 22, $xlin + 58, $this->nota->e69_numero);
    $this->objpdf->text($xcol + 60, $xlin + 58, $this->nota->e69_nfserie);
    $this->objpdf->text($xcol + 96, $xlin + 58, date('d/m/Y', strtotime($this->nota->e69_dtnota)));
    $this->objpdf->text($xcol + 130, $xlin + 58, $this->nota->e50_dtvencimento == null ? '' : date('d/m/Y', strtotime($this->nota->e50_dtvencimento)));
  }

  if (isset($this->conta_pagadora_reduz) && $this->conta_pagadora_reduz != '') {
    $this->objpdf->Setfont('Arial', 'B', 7);
    $this->objpdf->text($xcol + 1, $xlin + 67, 'CONTA PAGADORA');
    $this->objpdf->text($xcol + 1, $xlin + 70, 'Reduzido: ');
    $this->objpdf->text($xcol + 1, $xlin + 74, 'Agência: ');
    $this->objpdf->text($xcol + 1, $xlin + 78, 'Conta: ');
    $this->objpdf->Setfont('Arial', '', 7);
    $this->objpdf->text($xcol + 14, $xlin + 70, $this->conta_pagadora_reduz);
    $this->objpdf->text($xcol + 12, $xlin + 74, $this->conta_pagadora_agencia);
    $this->objpdf->text($xcol + 10, $xlin + 78, substr($this->conta_pagadora_conta, 0, 60));
  }

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

  if (is_array($this->aRetencoes) && count($this->aRetencoes) > 0) {

    for ($ii = 0; $ii < count($this->aRetencoes); $ii++) {

      if ($ii == 15) {

        $this->objpdf->SetWidths(array(12, 63, 23));
        $this->objpdf->Setfont('Arial', 'b', 7);
        $this->objpdf->setxy($xcol + 97, $xlin + 134);
        $this->objpdf->cell(10, 0, 'COD.', 0, 0, "L");
        $this->objpdf->cell(60, 0, 'DESCRIÇÃO', 0, 0, "L"); //Cabeçalho da segunda coluna de retenções
        $this->objpdf->cell(26, 0, 'VALOR', 0, 1, "R");

        $this->objpdf->sety($xlin + 134);
      }

      if ($ii >= 15) {
        $this->objpdf->setx($xcol + 95);
      }


      if ($ii < 25) {

        $this->objpdf->Setfont('Arial', '', 7);
        $this->objpdf->Row(
          array(
            $this->aRetencoes[$ii]->e21_sequencial,
            substr($this->aRetencoes[$ii]->e21_descricao, 0, 40),
            db_formatar($this->aRetencoes[$ii]->e23_valorretencao, 'f')
          ),
          6,
          false,
          3
        );
      } else {
        $total_ret_outras += $this->aRetencoes[$ii]->e23_valorretencao;
      }
      $total_ret += $this->aRetencoes[$ii]->e23_valorretencao;
    }

    if ($ii > 25) {

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

  $this->objpdf->Setfont('Arial', 'B', 7);
  // define propriedades para os totais
  $this->objpdf->setxy($xcol + 100, $xlin + 55);
  $this->objpdf->Setfont('Arial', '', 7);

  $this->objpdf->text($xcol + 148.2, $xlin + 57.7, db_formatar($total_emp, 'f'));
  $this->objpdf->text($xcol + 173.6, $xlin + 57.7, db_formatar($total_anu, 'f'));

  $nTotalOrdem = $total_emp - $total_anu;

  $this->objpdf->setxy($xcol + 123, $xlin + 61);

  $this->objpdf->Setfont('Arial', 'B', 7);
  $this->objpdf->cell(44, 4, 'VALOR TOTAL', 0, 0, "R");
  $this->objpdf->cell(24, 4, db_formatar($nTotalOrdem, 'f'), 0, 1, "R");
  $this->objpdf->setx($xcol + 127);

  $this->objpdf->cell(42, 4, 'SALDO ANTERIOR', 0, 0, "R");
  $this->objpdf->cell(22, 4, db_formatar($this->empenhado - $this->outrasordens, 'f'), 0, 1, "R");
  $this->objpdf->setx($xcol + 127);

  $this->objpdf->cell(42, 4, 'OUTRAS ORDENS', 0, 0, "R");
  $this->objpdf->cell(22, 4, db_formatar($this->outrasordens, 'f'), 0, 1, "R");
  $this->objpdf->setx($xcol + 127);

  $this->objpdf->cell(42, 4, 'VALOR RESTANTE', 0, 0, "R");
  $this->objpdf->cell(22, 4, db_formatar($this->empenhado - $this->outrasordens - $total_emp + ($total_anu - $this->empenho_anulado), 'f'), 0, 1, "R");

  $this->objpdf->Setfont('Arial', 'b', 8);
  $this->objpdf->text($xcol + 2, $xlin + 84, 'OBSERVAÇÕES :');
  $this->objpdf->Setfont('Arial', '', 7);

  // descrição da observação
  $this->objpdf->setxy($xcol, $xlin + 85);
  $this->objpdf->Setfont('Arial', '', 7);
  $this->objpdf->multicell(190, 4, substr($this->obs, 0, 456));
  if (isset($this->diaria) && $this->diaria != null) {
    $contador = 105;

    $this->objpdf->Setfont('Arial', 'B', 6.5);
    $this->objpdf->text($xcol + 1, $xlin + $contador, 'MATRICULA: ');
    $this->objpdf->text($xcol + 25, $xlin + $contador, 'CARGO: ');
    $this->objpdf->text($xcol + 63, $xlin + $contador, 'ORIGEM: ');
    $this->objpdf->text($xcol + 105, $xlin + $contador, 'DESTINO: ');
    $this->objpdf->text($xcol + 148, $xlin + $contador, 'DATA AUTORIZAÇÂO: ');
    $contador += 3;

    $this->objpdf->text($xcol + 1, $xlin + $contador, 'DATA INICIAL DA VIAGEM: ');
    $this->objpdf->text($xcol + 48, $xlin + $contador, 'HORA INICIAL DA VIAGEM: ');
    $this->objpdf->text($xcol + 89, $xlin + $contador, 'DATA FINAL DA VIAGEM: ');
    $this->objpdf->text($xcol + 135, $xlin + $contador, 'HORA FINAL DA VIAGEM: ');
    $contador += 3;

    if ($this->diaria->e140_qtddiarias != 0) {
      $this->objpdf->text($xcol + 1, $xlin + $contador, 'QTD. DIÁRIAS: ');
      $this->objpdf->text($xcol + 26, $xlin + $contador, 'VLR. UNIT. DIÁRIA: ');
      $this->objpdf->text($xcol + 68, $xlin + $contador, 'VLR. TOTAL DIÁRIAS: ');
      $contador += 3;
    }

    if ($this->diaria->e140_qtddiariaspernoite != 0) {
      $this->objpdf->text($xcol + 1, $xlin + $contador, 'QTD. DIÁRIAS PERNOITE: ');
      $this->objpdf->text($xcol + 39, $xlin + $contador, 'VLR. UNIT. DIÁRIA PERNOITE: ');
      $this->objpdf->text($xcol + 93, $xlin + $contador, 'VLR. TOTAL DIÁRIAS PERNOITE: ');
      $contador += 3;
    }

    if ($this->diaria->e140_qtdhospedagens != 0) {
      $this->objpdf->text($xcol + 1, $xlin + $contador, 'QTD. HOSPEDAGENS: ');
      $this->objpdf->text($xcol + 35, $xlin + $contador, 'VLR. UNIT. HOSPEDAGEM: ');
      $this->objpdf->text($xcol + 85, $xlin + $contador, 'VLR. TOTAL HOSPEDAGENS: ');
      $contador += 3;
    }

    if ($this->diaria->e140_transporte != null) {
      $this->objpdf->text($xcol + 1, $xlin + $contador, 'TRANSPORTE: ');
      if ($this->diaria->e140_vlrtransport != 0) {
        $this->objpdf->text($xcol + 50, $xlin + $contador, 'VLR. TRANSPORTE: ');
      }
    } else {
      if ($this->diaria->e140_vlrtransport != 0) {
        $this->objpdf->text($xcol + 1, $xlin + $contador, 'VLR. TRANSPORTE: ');
      }
    }

    $this->objpdf->Setfont('Arial', '', 7);

    $contador = 105;

    $this->objpdf->text($xcol + 16, $xlin + $contador, $this->diaria->matricula);
    $this->objpdf->text($xcol + 35, $xlin + $contador, substr($this->diaria->cargo, 0, 18));
    $this->objpdf->text($xcol + 74, $xlin + $contador, substr($this->diaria->origem[0], 0, 15) . ' - ' . trim($this->diaria->origem[1]));
    $this->objpdf->text($xcol + 117, $xlin + $contador, substr($this->diaria->destino[0], 0, 15) . ' - ' . trim($this->diaria->destino[1]));
    $this->objpdf->text($xcol + 174, $xlin + $contador, $this->diaria->e140_dtautorizacao);
    $contador += 3;

    $this->objpdf->text($xcol + 32, $xlin + $contador, $this->diaria->e140_dtinicial);
    $this->objpdf->text($xcol + 80, $xlin + $contador, $this->diaria->e140_horainicial);
    $this->objpdf->text($xcol + 119, $xlin + $contador, $this->diaria->e140_dtfinal);
    $this->objpdf->text($xcol + 165, $xlin + $contador, $this->diaria->e140_horafinal);
    $contador += 3;

    if ($this->diaria->e140_qtddiarias != 0) {
      $this->objpdf->text($xcol + 19, $xlin + $contador, $this->diaria->e140_qtddiarias);
      $this->objpdf->text($xcol + 50, $xlin + $contador, db_formatar($this->diaria->e140_vrldiariauni, 'f'));
      $this->objpdf->text($xcol + 94, $xlin + $contador, db_formatar($this->diaria->e140_qtddiarias * $this->diaria->e140_vrldiariauni, 'f'));
      $contador += 3;
    }

    if ($this->diaria->e140_qtddiariaspernoite != 0) {
      $this->objpdf->text($xcol + 32, $xlin + $contador, $this->diaria->e140_qtddiariaspernoite);
      $this->objpdf->text($xcol + 75, $xlin + $contador, db_formatar($this->diaria->e140_vrldiariaspernoiteuni, 'f'));
      $this->objpdf->text($xcol + 132, $xlin + $contador, db_formatar($this->diaria->e140_qtddiariaspernoite * $this->diaria->e140_vrldiariaspernoiteuni, 'f'));
      $contador += 3;
    }

    if ($this->diaria->e140_qtdhospedagens != 0) {
      $this->objpdf->text($xcol + 28, $xlin + $contador, $this->diaria->e140_qtdhospedagens);
      $this->objpdf->text($xcol + 67, $xlin + $contador, db_formatar($this->diaria->e140_vrlhospedagemuni, 'f'));
      $this->objpdf->text($xcol + 120, $xlin + $contador, db_formatar($this->diaria->e140_qtdhospedagens * $this->diaria->e140_vrlhospedagemuni, 'f'));
      $contador += 3;
    }

    if ($this->diaria->e140_transporte != null) {
      $this->objpdf->text($xcol + 19, $xlin + $contador, $this->diaria->e140_transporte);
      if ($this->diaria->e140_vlrtransport != 0) {
        $this->objpdf->text($xcol + 74, $xlin + $contador, db_formatar($this->diaria->e140_vlrtransport, 'f'));
      }
    } else {
      if ($this->diaria->e140_vlrtransport != 0) {
        $this->objpdf->text($xcol + 24, $xlin + $contador, db_formatar($this->diaria->e140_vlrtransport, 'f'));
      }
    }
  }
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

  /**
   * Verifica se o valor da Ordem está vazio e faz o cálculo {(Total do Saldo - (Valor da Retenção - Valor Recolhido))}
   */
  if ($total_sal == 0) {
    $nValorSaldo = 0;
  } else {
    $nValorSaldo = ($this->valor_ordem != "") ? $this->valor_ordem : ($total_sal - ($total_ret));
  }
  $this->objpdf->cell(23, 1, db_formatar($nValorSaldo, 'f'), 0, 1, "R"); //total renteções
  $this->objpdf->Setfont('Arial', 'B', 7);

  // Assinaturas e Canhoto
  $sqlparag  = "select db02_texto                                             ";
  $sqlparag .= "  from db_documento                                           ";
  $sqlparag .= "       inner join db_docparag  on db03_docum   = db04_docum   ";
  $sqlparag .= "       inner join db_tipodoc   on db08_codigo  = db03_tipodoc ";
  $sqlparag .= "       inner join db_paragrafo on db04_idparag = db02_idparag ";
  $sqlparag .= " where db03_tipodoc = 1500 and db03_instit = " . db_getsession("DB_instit") . " order by db04_ordem ";
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
    $sqlparagpadrao .= " where db60_tipodoc = 1500 and db60_instit = " . db_getsession("DB_instit") . " order by db62_ordem";

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
