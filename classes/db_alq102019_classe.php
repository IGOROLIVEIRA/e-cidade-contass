<?
//MODULO: sicom
//CLASSE DA ENTIDADE alq102019
class cl_alq102019
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
  var $si121_sequencial = 0;
  var $si121_tiporegistro = 0;
  var $si121_codreduzido = 0;
  var $si121_codorgao = null;
  var $si121_codunidadesub = null;
  var $si121_nroempenho = 0;
  var $si121_dtempenho_dia = null;
  var $si121_dtempenho_mes = null;
  var $si121_dtempenho_ano = null;
  var $si121_dtempenho = null;
  var $si121_dtliquidacao_dia = null;
  var $si121_dtliquidacao_mes = null;
  var $si121_dtliquidacao_ano = null;
  var $si121_dtliquidacao = null;
  var $si121_nroliquidacao = 0;
  var $si121_dtanulacaoliq_dia = null;
  var $si121_dtanulacaoliq_mes = null;
  var $si121_dtanulacaoliq_ano = null;
  var $si121_dtanulacaoliq = null;
  var $si121_nroliquidacaoanl = 0;
  var $si121_tpliquidacao = 0;
  var $si121_justificativaanulacao = null;
  var $si121_vlanulado = 0;
  var $si121_mes = 0;
  var $si121_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si121_sequencial = int8 = sequencial 
                 si121_tiporegistro = int8 = Tipo do  registro 
                 si121_codreduzido = int8 = Código Identificador do registro 
                 si121_codorgao = varchar(2) = Código do órgão 
                 si121_codunidadesub = varchar(8) = Código da unidade 
                 si121_nroempenho = int8 = Número do  empenho 
                 si121_dtempenho = date = Data do empenho 
                 si121_dtliquidacao = date = Data da  liquidação 
                 si121_nroliquidacao = int8 = Número da  Liquidação 
                 si121_dtanulacaoliq = date = Data da anulação  da liquidação 
                 si121_nroliquidacaoanl = int8 = Número da  anulação da  liquidação 
                 si121_tpliquidacao = int8 = Tipo de  liquidação 
                 si121_justificativaanulacao = varchar(500) = Justificativa para  a anulação 
                 si121_vlanulado = float8 = Valor anulado da  liquidação 
                 si121_mes = int8 = Mês 
                 si121_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_alq102019()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("alq102019");
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
      $this->si121_sequencial = ($this->si121_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_sequencial"] : $this->si121_sequencial);
      $this->si121_tiporegistro = ($this->si121_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_tiporegistro"] : $this->si121_tiporegistro);
      $this->si121_codreduzido = ($this->si121_codreduzido == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_codreduzido"] : $this->si121_codreduzido);
      $this->si121_codorgao = ($this->si121_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_codorgao"] : $this->si121_codorgao);
      $this->si121_codunidadesub = ($this->si121_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_codunidadesub"] : $this->si121_codunidadesub);
      $this->si121_nroempenho = ($this->si121_nroempenho == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_nroempenho"] : $this->si121_nroempenho);
      if ($this->si121_dtempenho == "") {
        $this->si121_dtempenho_dia = ($this->si121_dtempenho_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_dtempenho_dia"] : $this->si121_dtempenho_dia);
        $this->si121_dtempenho_mes = ($this->si121_dtempenho_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_dtempenho_mes"] : $this->si121_dtempenho_mes);
        $this->si121_dtempenho_ano = ($this->si121_dtempenho_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_dtempenho_ano"] : $this->si121_dtempenho_ano);
        if ($this->si121_dtempenho_dia != "") {
          $this->si121_dtempenho = $this->si121_dtempenho_ano . "-" . $this->si121_dtempenho_mes . "-" . $this->si121_dtempenho_dia;
        }
      }
      if ($this->si121_dtliquidacao == "") {
        $this->si121_dtliquidacao_dia = ($this->si121_dtliquidacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_dtliquidacao_dia"] : $this->si121_dtliquidacao_dia);
        $this->si121_dtliquidacao_mes = ($this->si121_dtliquidacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_dtliquidacao_mes"] : $this->si121_dtliquidacao_mes);
        $this->si121_dtliquidacao_ano = ($this->si121_dtliquidacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_dtliquidacao_ano"] : $this->si121_dtliquidacao_ano);
        if ($this->si121_dtliquidacao_dia != "") {
          $this->si121_dtliquidacao = $this->si121_dtliquidacao_ano . "-" . $this->si121_dtliquidacao_mes . "-" . $this->si121_dtliquidacao_dia;
        }
      }
      $this->si121_nroliquidacao = ($this->si121_nroliquidacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_nroliquidacao"] : $this->si121_nroliquidacao);
      if ($this->si121_dtanulacaoliq == "") {
        $this->si121_dtanulacaoliq_dia = ($this->si121_dtanulacaoliq_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_dtanulacaoliq_dia"] : $this->si121_dtanulacaoliq_dia);
        $this->si121_dtanulacaoliq_mes = ($this->si121_dtanulacaoliq_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_dtanulacaoliq_mes"] : $this->si121_dtanulacaoliq_mes);
        $this->si121_dtanulacaoliq_ano = ($this->si121_dtanulacaoliq_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_dtanulacaoliq_ano"] : $this->si121_dtanulacaoliq_ano);
        if ($this->si121_dtanulacaoliq_dia != "") {
          $this->si121_dtanulacaoliq = $this->si121_dtanulacaoliq_ano . "-" . $this->si121_dtanulacaoliq_mes . "-" . $this->si121_dtanulacaoliq_dia;
        }
      }
      $this->si121_nroliquidacaoanl = ($this->si121_nroliquidacaoanl == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_nroliquidacaoanl"] : $this->si121_nroliquidacaoanl);
      $this->si121_tpliquidacao = ($this->si121_tpliquidacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_tpliquidacao"] : $this->si121_tpliquidacao);
      $this->si121_justificativaanulacao = ($this->si121_justificativaanulacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_justificativaanulacao"] : $this->si121_justificativaanulacao);
      $this->si121_vlanulado = ($this->si121_vlanulado == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_vlanulado"] : $this->si121_vlanulado);
      $this->si121_mes = ($this->si121_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_mes"] : $this->si121_mes);
      $this->si121_instit = ($this->si121_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_instit"] : $this->si121_instit);
    } else {
      $this->si121_sequencial = ($this->si121_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si121_sequencial"] : $this->si121_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si121_sequencial)
  {
    $this->atualizacampos();
    if ($this->si121_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si121_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si121_codreduzido == null) {
      $this->si121_codreduzido = "0";
    }
    if ($this->si121_nroempenho == null) {
      $this->si121_nroempenho = "0";
    }
    if ($this->si121_dtempenho == null) {
      $this->si121_dtempenho = "null";
    }
    if ($this->si121_dtliquidacao == null) {
      $this->si121_dtliquidacao = "null";
    }
    if ($this->si121_nroliquidacao == null) {
      $this->si121_nroliquidacao = "0";
    }
    if ($this->si121_dtanulacaoliq == null) {
      $this->si121_dtanulacaoliq = "null";
    }
    if ($this->si121_nroliquidacaoanl == null) {
      $this->si121_nroliquidacaoanl = "0";
    }
    if ($this->si121_tpliquidacao == null) {
      $this->si121_tpliquidacao = "0";
    }
    if ($this->si121_vlanulado == null) {
      $this->si121_vlanulado = "0";
    }
    if ($this->si121_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si121_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si121_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si121_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si121_sequencial == "" || $si121_sequencial == null) {
      $result = db_query("select nextval('alq102019_si121_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: alq102019_si121_sequencial_seq do campo: si121_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si121_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from alq102019_si121_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si121_sequencial)) {
        $this->erro_sql = " Campo si121_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si121_sequencial = $si121_sequencial;
      }
    }
    if (($this->si121_sequencial == null) || ($this->si121_sequencial == "")) {
      $this->erro_sql = " Campo si121_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into alq102019(
                                       si121_sequencial 
                                      ,si121_tiporegistro 
                                      ,si121_codreduzido 
                                      ,si121_codorgao 
                                      ,si121_codunidadesub 
                                      ,si121_nroempenho 
                                      ,si121_dtempenho 
                                      ,si121_dtliquidacao 
                                      ,si121_nroliquidacao 
                                      ,si121_dtanulacaoliq 
                                      ,si121_nroliquidacaoanl 
                                      ,si121_tpliquidacao 
                                      ,si121_justificativaanulacao 
                                      ,si121_vlanulado 
                                      ,si121_mes 
                                      ,si121_instit 
                       )
                values (
                                $this->si121_sequencial 
                               ,$this->si121_tiporegistro 
                               ,$this->si121_codreduzido 
                               ,'$this->si121_codorgao' 
                               ,'$this->si121_codunidadesub' 
                               ,$this->si121_nroempenho 
                               ," . ($this->si121_dtempenho == "null" || $this->si121_dtempenho == "" ? "null" : "'" . $this->si121_dtempenho . "'") . "
                               ," . ($this->si121_dtliquidacao == "null" || $this->si121_dtliquidacao == "" ? "null" : "'" . $this->si121_dtliquidacao . "'") . "
                               ,$this->si121_nroliquidacao 
                               ," . ($this->si121_dtanulacaoliq == "null" || $this->si121_dtanulacaoliq == "" ? "null" : "'" . $this->si121_dtanulacaoliq . "'") . "
                               ,$this->si121_nroliquidacaoanl 
                               ,$this->si121_tpliquidacao 
                               ,'$this->si121_justificativaanulacao' 
                               ,$this->si121_vlanulado 
                               ,$this->si121_mes 
                               ,$this->si121_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "alq102019 ($this->si121_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "alq102019 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "alq102019 ($this->si121_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si121_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si121_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010814,'$this->si121_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010350,2010814,'','" . AddSlashes(pg_result($resaco, 0, 'si121_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010350,2010815,'','" . AddSlashes(pg_result($resaco, 0, 'si121_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010350,2010816,'','" . AddSlashes(pg_result($resaco, 0, 'si121_codreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010350,2010817,'','" . AddSlashes(pg_result($resaco, 0, 'si121_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010350,2010818,'','" . AddSlashes(pg_result($resaco, 0, 'si121_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010350,2010819,'','" . AddSlashes(pg_result($resaco, 0, 'si121_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010350,2010820,'','" . AddSlashes(pg_result($resaco, 0, 'si121_dtempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010350,2010821,'','" . AddSlashes(pg_result($resaco, 0, 'si121_dtliquidacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010350,2010822,'','" . AddSlashes(pg_result($resaco, 0, 'si121_nroliquidacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010350,2010823,'','" . AddSlashes(pg_result($resaco, 0, 'si121_dtanulacaoliq')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010350,2010824,'','" . AddSlashes(pg_result($resaco, 0, 'si121_nroliquidacaoanl')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010350,2010825,'','" . AddSlashes(pg_result($resaco, 0, 'si121_tpliquidacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010350,2010827,'','" . AddSlashes(pg_result($resaco, 0, 'si121_justificativaanulacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010350,2010828,'','" . AddSlashes(pg_result($resaco, 0, 'si121_vlanulado')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010350,2010829,'','" . AddSlashes(pg_result($resaco, 0, 'si121_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010350,2011634,'','" . AddSlashes(pg_result($resaco, 0, 'si121_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si121_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update alq102019 set ";
    $virgula = "";
    if (trim($this->si121_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_sequencial"])) {
      if (trim($this->si121_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si121_sequencial"])) {
        $this->si121_sequencial = "0";
      }
      $sql .= $virgula . " si121_sequencial = $this->si121_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si121_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_tiporegistro"])) {
      $sql .= $virgula . " si121_tiporegistro = $this->si121_tiporegistro ";
      $virgula = ",";
      if (trim($this->si121_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si121_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si121_codreduzido) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_codreduzido"])) {
      if (trim($this->si121_codreduzido) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si121_codreduzido"])) {
        $this->si121_codreduzido = "0";
      }
      $sql .= $virgula . " si121_codreduzido = $this->si121_codreduzido ";
      $virgula = ",";
    }
    if (trim($this->si121_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_codorgao"])) {
      $sql .= $virgula . " si121_codorgao = '$this->si121_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si121_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_codunidadesub"])) {
      $sql .= $virgula . " si121_codunidadesub = '$this->si121_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si121_nroempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_nroempenho"])) {
      if (trim($this->si121_nroempenho) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si121_nroempenho"])) {
        $this->si121_nroempenho = "0";
      }
      $sql .= $virgula . " si121_nroempenho = $this->si121_nroempenho ";
      $virgula = ",";
    }
    if (trim($this->si121_dtempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_dtempenho_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si121_dtempenho_dia"] != "")) {
      $sql .= $virgula . " si121_dtempenho = '$this->si121_dtempenho' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si121_dtempenho_dia"])) {
        $sql .= $virgula . " si121_dtempenho = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si121_dtliquidacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_dtliquidacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si121_dtliquidacao_dia"] != "")) {
      $sql .= $virgula . " si121_dtliquidacao = '$this->si121_dtliquidacao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si121_dtliquidacao_dia"])) {
        $sql .= $virgula . " si121_dtliquidacao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si121_nroliquidacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_nroliquidacao"])) {
      if (trim($this->si121_nroliquidacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si121_nroliquidacao"])) {
        $this->si121_nroliquidacao = "0";
      }
      $sql .= $virgula . " si121_nroliquidacao = $this->si121_nroliquidacao ";
      $virgula = ",";
    }
    if (trim($this->si121_dtanulacaoliq) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_dtanulacaoliq_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si121_dtanulacaoliq_dia"] != "")) {
      $sql .= $virgula . " si121_dtanulacaoliq = '$this->si121_dtanulacaoliq' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si121_dtanulacaoliq_dia"])) {
        $sql .= $virgula . " si121_dtanulacaoliq = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si121_nroliquidacaoanl) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_nroliquidacaoanl"])) {
      if (trim($this->si121_nroliquidacaoanl) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si121_nroliquidacaoanl"])) {
        $this->si121_nroliquidacaoanl = "0";
      }
      $sql .= $virgula . " si121_nroliquidacaoanl = $this->si121_nroliquidacaoanl ";
      $virgula = ",";
    }
    if (trim($this->si121_tpliquidacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_tpliquidacao"])) {
      if (trim($this->si121_tpliquidacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si121_tpliquidacao"])) {
        $this->si121_tpliquidacao = "0";
      }
      $sql .= $virgula . " si121_tpliquidacao = $this->si121_tpliquidacao ";
      $virgula = ",";
    }
    if (trim($this->si121_justificativaanulacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_justificativaanulacao"])) {
      $sql .= $virgula . " si121_justificativaanulacao = '$this->si121_justificativaanulacao' ";
      $virgula = ",";
    }
    if (trim($this->si121_vlanulado) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_vlanulado"])) {
      if (trim($this->si121_vlanulado) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si121_vlanulado"])) {
        $this->si121_vlanulado = "0";
      }
      $sql .= $virgula . " si121_vlanulado = $this->si121_vlanulado ";
      $virgula = ",";
    }
    if (trim($this->si121_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_mes"])) {
      $sql .= $virgula . " si121_mes = $this->si121_mes ";
      $virgula = ",";
      if (trim($this->si121_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si121_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si121_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si121_instit"])) {
      $sql .= $virgula . " si121_instit = $this->si121_instit ";
      $virgula = ",";
      if (trim($this->si121_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si121_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si121_sequencial != null) {
      $sql .= " si121_sequencial = $this->si121_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si121_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010814,'$this->si121_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_sequencial"]) || $this->si121_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2010814,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_sequencial')) . "','$this->si121_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_tiporegistro"]) || $this->si121_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2010815,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_tiporegistro')) . "','$this->si121_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_codreduzido"]) || $this->si121_codreduzido != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2010816,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_codreduzido')) . "','$this->si121_codreduzido'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_codorgao"]) || $this->si121_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2010817,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_codorgao')) . "','$this->si121_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_codunidadesub"]) || $this->si121_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2010818,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_codunidadesub')) . "','$this->si121_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_nroempenho"]) || $this->si121_nroempenho != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2010819,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_nroempenho')) . "','$this->si121_nroempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_dtempenho"]) || $this->si121_dtempenho != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2010820,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_dtempenho')) . "','$this->si121_dtempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_dtliquidacao"]) || $this->si121_dtliquidacao != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2010821,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_dtliquidacao')) . "','$this->si121_dtliquidacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_nroliquidacao"]) || $this->si121_nroliquidacao != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2010822,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_nroliquidacao')) . "','$this->si121_nroliquidacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_dtanulacaoliq"]) || $this->si121_dtanulacaoliq != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2010823,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_dtanulacaoliq')) . "','$this->si121_dtanulacaoliq'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_nroliquidacaoanl"]) || $this->si121_nroliquidacaoanl != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2010824,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_nroliquidacaoanl')) . "','$this->si121_nroliquidacaoanl'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_tpliquidacao"]) || $this->si121_tpliquidacao != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2010825,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_tpliquidacao')) . "','$this->si121_tpliquidacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_justificativaanulacao"]) || $this->si121_justificativaanulacao != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2010827,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_justificativaanulacao')) . "','$this->si121_justificativaanulacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_vlanulado"]) || $this->si121_vlanulado != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2010828,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_vlanulado')) . "','$this->si121_vlanulado'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_mes"]) || $this->si121_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2010829,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_mes')) . "','$this->si121_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si121_instit"]) || $this->si121_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010350,2011634,'" . AddSlashes(pg_result($resaco, $conresaco, 'si121_instit')) . "','$this->si121_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "alq102019 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si121_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "alq102019 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si121_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si121_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si121_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si121_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010814,'$si121_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010350,2010814,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010350,2010815,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010350,2010816,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_codreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010350,2010817,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010350,2010818,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010350,2010819,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010350,2010820,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_dtempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010350,2010821,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_dtliquidacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010350,2010822,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_nroliquidacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010350,2010823,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_dtanulacaoliq')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010350,2010824,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_nroliquidacaoanl')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010350,2010825,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_tpliquidacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010350,2010827,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_justificativaanulacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010350,2010828,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_vlanulado')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010350,2010829,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010350,2011634,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si121_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from alq102019
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si121_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si121_sequencial = $si121_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "alq102019 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si121_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "alq102019 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si121_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si121_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
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
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "Erro ao selecionar os registros.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Record Vazio na Tabela:alq102019";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si121_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from alq102019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si121_sequencial != null) {
        $sql2 .= " where alq102019.si121_sequencial = $si121_sequencial ";
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
  function sql_query_file($si121_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from alq102019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si121_sequencial != null) {
        $sql2 .= " where alq102019.si121_sequencial = $si121_sequencial ";
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
