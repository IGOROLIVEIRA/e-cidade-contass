<?
//MODULO: sicom
//CLASSE DA ENTIDADE ops112017
class cl_ops112017
{
  // cria variaveis de erro
  var $rotulo = null;
  var $query_sql = null;
  var $numrows = 0;
  var $numrows_incluir = 0;
  var $numrows_alterar = 0;
  var $numrows_excluir = 0;
  var $erro_status = null;
  var $erro_sql = null;
  var $erro_banco = null;
  var $erro_msg = null;
  var $erro_campo = null;
  var $pagina_retorno = null;
  // cria variaveis do arquivo
  var $si133_sequencial = 0;
  var $si133_tiporegistro = 0;
  var $si133_codreduzidoop = 0;
  var $si133_codunidadesub = null;
  var $si133_nroop = 0;
  var $si133_dtpagamento_dia = null;
  var $si133_dtpagamento_mes = null;
  var $si133_dtpagamento_ano = null;
  var $si133_dtpagamento = null;
  var $si133_tipopagamento = 0;
  var $si133_nroempenho = 0;
  var $si133_dtempenho_dia = null;
  var $si133_dtempenho_mes = null;
  var $si133_dtempenho_ano = null;
  var $si133_dtempenho = null;
  var $si133_nroliquidacao = 0;
  var $si133_dtliquidacao_dia = null;
  var $si133_dtliquidacao_mes = null;
  var $si133_dtliquidacao_ano = null;
  var $si133_dtliquidacao = null;
  var $si133_codfontrecursos = 0;
  var $si133_valorfonte = 0;
  var $si133_tipodocumentocredor = 0;
  var $si133_nrodocumento = null;
  var $si133_codorgaoempop = null;
  var $si133_codunidadeempop = null;
  var $si133_mes = 0;
  var $si133_reg10 = 0;
  var $si133_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si133_sequencial = int8 = sequencial 
                 si133_tiporegistro = int8 = Tipo do  registro 
                 si133_codreduzidoop = int8 = Código  Identificador da  Ordem 
                 si133_codunidadesub = varchar(8) = Código da unidade 
                 si133_nroop = int8 = Número da  Ordem de  Pagamento 
                 si133_dtpagamento = date = Data de  pagamento da  OP 
                 si133_tipopagamento = int8 = Tipo do  Pagamento 
                 si133_nroempenho = int8 = Número do  empenho 
                 si133_dtempenho = date = Data do empenho 
                 si133_nroliquidacao = int8 = Número da  Liquidação 
                 si133_dtliquidacao = date = Data da  Liquidação do  empenho 
                 si133_codfontrecursos = int8 = Código da fonte de recursos 
                 si133_valorfonte = float8 = Valor bruto do pagamento por fonte 
                 si133_tipodocumentocredor = int8 = Tipo de  Documento do  credor 
                 si133_nrodocumento = varchar(14) = Número do documento do credor 
                 si133_codorgaoempop = varchar(2) = Código do órgão 
                 si133_codunidadeempop = varchar(8) = Código da  unidade 
                 si133_mes = int8 = Mês 
                 si133_reg10 = int8 = reg10 
                 si133_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_ops112017()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ops112017");
    $this->pagina_retorno = basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
  }

  //funcao erro
  function erro($mostra, $retorna)
  {
    if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null)) {
      echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
      if ($retorna == true) {
        echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
      }
    }
  }

  // funcao para atualizar campos
  function atualizacampos($exclusao = false)
  {
    if ($exclusao == false) {
      $this->si133_sequencial = ($this->si133_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_sequencial"] : $this->si133_sequencial);
      $this->si133_tiporegistro = ($this->si133_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_tiporegistro"] : $this->si133_tiporegistro);
      $this->si133_codreduzidoop = ($this->si133_codreduzidoop == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_codreduzidoop"] : $this->si133_codreduzidoop);
      $this->si133_codunidadesub = ($this->si133_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_codunidadesub"] : $this->si133_codunidadesub);
      $this->si133_nroop = ($this->si133_nroop == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_nroop"] : $this->si133_nroop);
      if ($this->si133_dtpagamento == "") {
        $this->si133_dtpagamento_dia = ($this->si133_dtpagamento_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_dtpagamento_dia"] : $this->si133_dtpagamento_dia);
        $this->si133_dtpagamento_mes = ($this->si133_dtpagamento_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_dtpagamento_mes"] : $this->si133_dtpagamento_mes);
        $this->si133_dtpagamento_ano = ($this->si133_dtpagamento_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_dtpagamento_ano"] : $this->si133_dtpagamento_ano);
        if ($this->si133_dtpagamento_dia != "") {
          $this->si133_dtpagamento = $this->si133_dtpagamento_ano . "-" . $this->si133_dtpagamento_mes . "-" . $this->si133_dtpagamento_dia;
        }
      }
      $this->si133_tipopagamento = ($this->si133_tipopagamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_tipopagamento"] : $this->si133_tipopagamento);
      $this->si133_nroempenho = ($this->si133_nroempenho == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_nroempenho"] : $this->si133_nroempenho);
      if ($this->si133_dtempenho == "") {
        $this->si133_dtempenho_dia = ($this->si133_dtempenho_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_dtempenho_dia"] : $this->si133_dtempenho_dia);
        $this->si133_dtempenho_mes = ($this->si133_dtempenho_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_dtempenho_mes"] : $this->si133_dtempenho_mes);
        $this->si133_dtempenho_ano = ($this->si133_dtempenho_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_dtempenho_ano"] : $this->si133_dtempenho_ano);
        if ($this->si133_dtempenho_dia != "") {
          $this->si133_dtempenho = $this->si133_dtempenho_ano . "-" . $this->si133_dtempenho_mes . "-" . $this->si133_dtempenho_dia;
        }
      }
      $this->si133_nroliquidacao = ($this->si133_nroliquidacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_nroliquidacao"] : $this->si133_nroliquidacao);
      if ($this->si133_dtliquidacao == "") {
        $this->si133_dtliquidacao_dia = ($this->si133_dtliquidacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_dtliquidacao_dia"] : $this->si133_dtliquidacao_dia);
        $this->si133_dtliquidacao_mes = ($this->si133_dtliquidacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_dtliquidacao_mes"] : $this->si133_dtliquidacao_mes);
        $this->si133_dtliquidacao_ano = ($this->si133_dtliquidacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_dtliquidacao_ano"] : $this->si133_dtliquidacao_ano);
        if ($this->si133_dtliquidacao_dia != "") {
          $this->si133_dtliquidacao = $this->si133_dtliquidacao_ano . "-" . $this->si133_dtliquidacao_mes . "-" . $this->si133_dtliquidacao_dia;
        }
      }
      $this->si133_codfontrecursos = ($this->si133_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_codfontrecursos"] : $this->si133_codfontrecursos);
      $this->si133_valorfonte = ($this->si133_valorfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_valorfonte"] : $this->si133_valorfonte);
      $this->si133_tipodocumentocredor = ($this->si133_tipodocumentocredor == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_tipodocumentocredor"] : $this->si133_tipodocumentocredor);
      $this->si133_nrodocumento = ($this->si133_nrodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_nrodocumento"] : $this->si133_nrodocumento);
      $this->si133_codorgaoempop = ($this->si133_codorgaoempop == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_codorgaoempop"] : $this->si133_codorgaoempop);
      $this->si133_codunidadeempop = ($this->si133_codunidadeempop == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_codunidadeempop"] : $this->si133_codunidadeempop);
      $this->si133_mes = ($this->si133_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_mes"] : $this->si133_mes);
      $this->si133_reg10 = ($this->si133_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_reg10"] : $this->si133_reg10);
      $this->si133_instit = ($this->si133_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_instit"] : $this->si133_instit);
    } else {
      $this->si133_sequencial = ($this->si133_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si133_sequencial"] : $this->si133_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si133_sequencial)
  {
    $this->atualizacampos();
    if ($this->si133_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si133_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si133_codreduzidoop == null) {
      $this->si133_codreduzidoop = "0";
    }
    if ($this->si133_nroop == null) {
      $this->si133_nroop = "0";
    }
    if ($this->si133_dtpagamento == null) {
      $this->si133_dtpagamento = "null";
    }
    if ($this->si133_tipopagamento == null) {
      $this->si133_tipopagamento = "0";
    }
    if ($this->si133_nroempenho == null) {
      $this->si133_nroempenho = "0";
    }
    if ($this->si133_dtempenho == null) {
      $this->si133_dtempenho = "null";
    }
    if ($this->si133_nroliquidacao == null) {
      $this->si133_nroliquidacao = "0";
    }
    if ($this->si133_dtliquidacao == null) {
      $this->si133_dtliquidacao = "null";
    }
    if ($this->si133_codfontrecursos == null) {
      $this->si133_codfontrecursos = "0";
    }
    if ($this->si133_valorfonte == null) {
      $this->si133_valorfonte = "0";
    }
    if ($this->si133_tipodocumentocredor == null) {
      $this->si133_tipodocumentocredor = "0";
    }
    if ($this->si133_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si133_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si133_reg10 == null) {
      $this->si133_reg10 = "0";
    }
    if ($this->si133_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si133_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si133_sequencial == "" || $si133_sequencial == null) {
      $result = db_query("select nextval('ops112017_si133_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ops112017_si133_sequencial_seq do campo: si133_sequencial";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si133_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from ops112017_si133_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si133_sequencial)) {
        $this->erro_sql = " Campo si133_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si133_sequencial = $si133_sequencial;
      }
    }
    if (($this->si133_sequencial == null) || ($this->si133_sequencial == "")) {
      $this->erro_sql = " Campo si133_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into ops112017(
                                       si133_sequencial 
                                      ,si133_tiporegistro 
                                      ,si133_codreduzidoop 
                                      ,si133_codunidadesub 
                                      ,si133_nroop 
                                      ,si133_dtpagamento 
                                      ,si133_tipopagamento 
                                      ,si133_nroempenho 
                                      ,si133_dtempenho 
                                      ,si133_nroliquidacao 
                                      ,si133_dtliquidacao 
                                      ,si133_codfontrecursos 
                                      ,si133_valorfonte 
                                      ,si133_tipodocumentocredor 
                                      ,si133_nrodocumento 
                                      ,si133_codorgaoempop 
                                      ,si133_codunidadeempop 
                                      ,si133_mes 
                                      ,si133_reg10 
                                      ,si133_instit 
                       )
                values (
                                $this->si133_sequencial 
                               ,$this->si133_tiporegistro 
                               ,$this->si133_codreduzidoop 
                               ,'$this->si133_codunidadesub' 
                               ,$this->si133_nroop 
                               ," . ($this->si133_dtpagamento == "null" || $this->si133_dtpagamento == "" ? "null" : "'" . $this->si133_dtpagamento . "'") . "
                               ,$this->si133_tipopagamento 
                               ,$this->si133_nroempenho 
                               ," . ($this->si133_dtempenho == "null" || $this->si133_dtempenho == "" ? "null" : "'" . $this->si133_dtempenho . "'") . "
                               ,$this->si133_nroliquidacao 
                               ," . ($this->si133_dtliquidacao == "null" || $this->si133_dtliquidacao == "" ? "null" : "'" . $this->si133_dtliquidacao . "'") . "
                               ,$this->si133_codfontrecursos 
                               ,$this->si133_valorfonte 
                               ,$this->si133_tipodocumentocredor 
                               ,'$this->si133_nrodocumento' 
                               ,'$this->si133_codorgaoempop' 
                               ,'$this->si133_codunidadeempop' 
                               ,$this->si133_mes 
                               ,$this->si133_reg10 
                               ,$this->si133_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ops112017 ($this->si133_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "ops112017 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql = "ops112017 ($this->si133_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->si133_sequencial;
    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si133_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010937,'$this->si133_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010362,2010937,'','" . AddSlashes(pg_result($resaco, 0, 'si133_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010938,'','" . AddSlashes(pg_result($resaco, 0, 'si133_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010939,'','" . AddSlashes(pg_result($resaco, 0, 'si133_codreduzidoop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010940,'','" . AddSlashes(pg_result($resaco, 0, 'si133_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010941,'','" . AddSlashes(pg_result($resaco, 0, 'si133_nroop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010942,'','" . AddSlashes(pg_result($resaco, 0, 'si133_dtpagamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010943,'','" . AddSlashes(pg_result($resaco, 0, 'si133_tipopagamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010944,'','" . AddSlashes(pg_result($resaco, 0, 'si133_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010945,'','" . AddSlashes(pg_result($resaco, 0, 'si133_dtempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010946,'','" . AddSlashes(pg_result($resaco, 0, 'si133_nroliquidacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010947,'','" . AddSlashes(pg_result($resaco, 0, 'si133_dtliquidacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010948,'','" . AddSlashes(pg_result($resaco, 0, 'si133_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010949,'','" . AddSlashes(pg_result($resaco, 0, 'si133_valorfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010950,'','" . AddSlashes(pg_result($resaco, 0, 'si133_tipodocumentocredor')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010951,'','" . AddSlashes(pg_result($resaco, 0, 'si133_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010952,'','" . AddSlashes(pg_result($resaco, 0, 'si133_codorgaoempop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010953,'','" . AddSlashes(pg_result($resaco, 0, 'si133_codunidadeempop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010954,'','" . AddSlashes(pg_result($resaco, 0, 'si133_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2010955,'','" . AddSlashes(pg_result($resaco, 0, 'si133_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010362,2011646,'','" . AddSlashes(pg_result($resaco, 0, 'si133_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si133_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ops112017 set ";
    $virgula = "";
    if (trim($this->si133_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_sequencial"])) {
      if (trim($this->si133_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si133_sequencial"])) {
        $this->si133_sequencial = "0";
      }
      $sql .= $virgula . " si133_sequencial = $this->si133_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si133_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_tiporegistro"])) {
      $sql .= $virgula . " si133_tiporegistro = $this->si133_tiporegistro ";
      $virgula = ",";
      if (trim($this->si133_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si133_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si133_codreduzidoop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_codreduzidoop"])) {
      if (trim($this->si133_codreduzidoop) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si133_codreduzidoop"])) {
        $this->si133_codreduzidoop = "0";
      }
      $sql .= $virgula . " si133_codreduzidoop = $this->si133_codreduzidoop ";
      $virgula = ",";
    }
    if (trim($this->si133_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_codunidadesub"])) {
      $sql .= $virgula . " si133_codunidadesub = '$this->si133_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si133_nroop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_nroop"])) {
      if (trim($this->si133_nroop) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si133_nroop"])) {
        $this->si133_nroop = "0";
      }
      $sql .= $virgula . " si133_nroop = $this->si133_nroop ";
      $virgula = ",";
    }
    if (trim($this->si133_dtpagamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_dtpagamento_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si133_dtpagamento_dia"] != "")) {
      $sql .= $virgula . " si133_dtpagamento = '$this->si133_dtpagamento' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si133_dtpagamento_dia"])) {
        $sql .= $virgula . " si133_dtpagamento = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si133_tipopagamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_tipopagamento"])) {
      if (trim($this->si133_tipopagamento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si133_tipopagamento"])) {
        $this->si133_tipopagamento = "0";
      }
      $sql .= $virgula . " si133_tipopagamento = $this->si133_tipopagamento ";
      $virgula = ",";
    }
    if (trim($this->si133_nroempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_nroempenho"])) {
      if (trim($this->si133_nroempenho) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si133_nroempenho"])) {
        $this->si133_nroempenho = "0";
      }
      $sql .= $virgula . " si133_nroempenho = $this->si133_nroempenho ";
      $virgula = ",";
    }
    if (trim($this->si133_dtempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_dtempenho_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si133_dtempenho_dia"] != "")) {
      $sql .= $virgula . " si133_dtempenho = '$this->si133_dtempenho' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si133_dtempenho_dia"])) {
        $sql .= $virgula . " si133_dtempenho = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si133_nroliquidacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_nroliquidacao"])) {
      if (trim($this->si133_nroliquidacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si133_nroliquidacao"])) {
        $this->si133_nroliquidacao = "0";
      }
      $sql .= $virgula . " si133_nroliquidacao = $this->si133_nroliquidacao ";
      $virgula = ",";
    }
    if (trim($this->si133_dtliquidacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_dtliquidacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si133_dtliquidacao_dia"] != "")) {
      $sql .= $virgula . " si133_dtliquidacao = '$this->si133_dtliquidacao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si133_dtliquidacao_dia"])) {
        $sql .= $virgula . " si133_dtliquidacao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si133_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_codfontrecursos"])) {
      if (trim($this->si133_codfontrecursos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si133_codfontrecursos"])) {
        $this->si133_codfontrecursos = "0";
      }
      $sql .= $virgula . " si133_codfontrecursos = $this->si133_codfontrecursos ";
      $virgula = ",";
    }
    if (trim($this->si133_valorfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_valorfonte"])) {
      if (trim($this->si133_valorfonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si133_valorfonte"])) {
        $this->si133_valorfonte = "0";
      }
      $sql .= $virgula . " si133_valorfonte = $this->si133_valorfonte ";
      $virgula = ",";
    }
    if (trim($this->si133_tipodocumentocredor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_tipodocumentocredor"])) {
      if (trim($this->si133_tipodocumentocredor) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si133_tipodocumentocredor"])) {
        $this->si133_tipodocumentocredor = "0";
      }
      $sql .= $virgula . " si133_tipodocumentocredor = $this->si133_tipodocumentocredor ";
      $virgula = ",";
    }
    if (trim($this->si133_nrodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_nrodocumento"])) {
      $sql .= $virgula . " si133_nrodocumento = '$this->si133_nrodocumento' ";
      $virgula = ",";
    }
    if (trim($this->si133_codorgaoempop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_codorgaoempop"])) {
      $sql .= $virgula . " si133_codorgaoempop = '$this->si133_codorgaoempop' ";
      $virgula = ",";
    }
    if (trim($this->si133_codunidadeempop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_codunidadeempop"])) {
      $sql .= $virgula . " si133_codunidadeempop = '$this->si133_codunidadeempop' ";
      $virgula = ",";
    }
    if (trim($this->si133_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_mes"])) {
      $sql .= $virgula . " si133_mes = $this->si133_mes ";
      $virgula = ",";
      if (trim($this->si133_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si133_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si133_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_reg10"])) {
      if (trim($this->si133_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si133_reg10"])) {
        $this->si133_reg10 = "0";
      }
      $sql .= $virgula . " si133_reg10 = $this->si133_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si133_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si133_instit"])) {
      $sql .= $virgula . " si133_instit = $this->si133_instit ";
      $virgula = ",";
      if (trim($this->si133_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si133_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si133_sequencial != null) {
      $sql .= " si133_sequencial = $this->si133_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si133_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010937,'$this->si133_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_sequencial"]) || $this->si133_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010937,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_sequencial')) . "','$this->si133_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_tiporegistro"]) || $this->si133_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010938,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_tiporegistro')) . "','$this->si133_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_codreduzidoop"]) || $this->si133_codreduzidoop != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010939,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_codreduzidoop')) . "','$this->si133_codreduzidoop'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_codunidadesub"]) || $this->si133_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010940,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_codunidadesub')) . "','$this->si133_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_nroop"]) || $this->si133_nroop != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010941,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_nroop')) . "','$this->si133_nroop'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_dtpagamento"]) || $this->si133_dtpagamento != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010942,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_dtpagamento')) . "','$this->si133_dtpagamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_tipopagamento"]) || $this->si133_tipopagamento != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010943,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_tipopagamento')) . "','$this->si133_tipopagamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_nroempenho"]) || $this->si133_nroempenho != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010944,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_nroempenho')) . "','$this->si133_nroempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_dtempenho"]) || $this->si133_dtempenho != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010945,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_dtempenho')) . "','$this->si133_dtempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_nroliquidacao"]) || $this->si133_nroliquidacao != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010946,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_nroliquidacao')) . "','$this->si133_nroliquidacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_dtliquidacao"]) || $this->si133_dtliquidacao != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010947,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_dtliquidacao')) . "','$this->si133_dtliquidacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_codfontrecursos"]) || $this->si133_codfontrecursos != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010948,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_codfontrecursos')) . "','$this->si133_codfontrecursos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_valorfonte"]) || $this->si133_valorfonte != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010949,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_valorfonte')) . "','$this->si133_valorfonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_tipodocumentocredor"]) || $this->si133_tipodocumentocredor != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010950,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_tipodocumentocredor')) . "','$this->si133_tipodocumentocredor'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_nrodocumento"]) || $this->si133_nrodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010951,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_nrodocumento')) . "','$this->si133_nrodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_codorgaoempop"]) || $this->si133_codorgaoempop != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010952,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_codorgaoempop')) . "','$this->si133_codorgaoempop'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_codunidadeempop"]) || $this->si133_codunidadeempop != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010953,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_codunidadeempop')) . "','$this->si133_codunidadeempop'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_mes"]) || $this->si133_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010954,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_mes')) . "','$this->si133_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_reg10"]) || $this->si133_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2010955,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_reg10')) . "','$this->si133_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si133_instit"]) || $this->si133_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010362,2011646,'" . AddSlashes(pg_result($resaco, $conresaco, 'si133_instit')) . "','$this->si133_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "ops112017 nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->si133_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ops112017 nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->si133_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->si133_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si133_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si133_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010937,'$si133_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010362,2010937,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010938,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010939,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_codreduzidoop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010940,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010941,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_nroop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010942,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_dtpagamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010943,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_tipopagamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010944,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010945,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_dtempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010946,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_nroliquidacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010947,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_dtliquidacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010948,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010949,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_valorfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010950,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_tipodocumentocredor')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010951,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010952,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_codorgaoempop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010953,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_codunidadeempop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010954,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2010955,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010362,2011646,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si133_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from ops112017
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si133_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si133_sequencial = $si133_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "ops112017 nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $si133_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ops112017 nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $si133_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $si133_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao do recordset
  function sql_record($sql)
  {
    $result = db_query($sql);
    if ($result == false) {
      $this->numrows = 0;
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "Erro ao selecionar os registros.";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Record Vazio na Tabela:ops112017";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si133_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from ops112017 ";
    $sql .= "      left  join ops102017  on  ops102017.si132_sequencial = ops112017.si133_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si133_sequencial != null) {
        $sql2 .= " where ops112017.si133_sequencial = $si133_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = explode("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }

    return $sql;
  }

  // funcao do sql
  function sql_query_file($si133_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from ops112017 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si133_sequencial != null) {
        $sql2 .= " where ops112017.si133_sequencial = $si133_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = explode("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }

    return $sql;
  }
}

?>
