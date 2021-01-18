<?
//MODULO: sicom
//CLASSE DA ENTIDADE aex102021
class cl_aex102021
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
  var $si130_sequencial = 0;
  var $si130_tiporegistro = 0;
  var $si130_codext = 0;
  var $si130_codfontrecursos = 0;
  var $si130_nroop = 0;
  var $si130_codunidadesub = null;
  var $si130_dtpagamento_dia = null;
  var $si130_dtpagamento_mes = null;
  var $si130_dtpagamento_ano = null;
  var $si130_dtpagamento = null;
  var $si130_nroanulacaoop = 0;
  var $si130_dtanulacaoop_dia = null;
  var $si130_dtanulacaoop_mes = null;
  var $si130_dtanulacaoop_ano = null;
  var $si130_dtanulacaoop = null;
  var $si130_vlanulacaoop = 0;
  var $si130_mes = 0;
  var $si130_reg10 = 0;
  var $si130_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si130_sequencial = int8 = sequencial 
                 si130_tiporegistro = int8 = Tipo do registro 
                 si130_codext = int8 = Código identificador da anulação
                 si130_codfontrecursos = int8 = Código da fonte de recursos
                 si130_nroop = int8 = Código da fonte de recursos
                 si130_codunidadesub = varchar(8) = Código da unidade ou subunidade orçamentária
                 si130_dtpagamento = date = Data de  pagamento da  OP 
                 si130_nroanulacaoop = int8 = Número da  anulação da OP 
                 si130_dtanulacaoop = date = Data da anulação  da OP 
                 si130_vlanulacaoop = float8 = Valor da  Anulação da OP 
                 si130_mes = int8 = Mês 
                 si130_reg10 = int8 = reg10 
                 si130_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_aex102021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("aex102021");
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
      $this->si130_sequencial = ($this->si130_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_sequencial"] : $this->si130_sequencial);
      $this->si130_tiporegistro = ($this->si130_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_tiporegistro"] : $this->si130_tiporegistro);
      $this->si130_codext = ($this->si130_codext == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_codext"] : $this->si130_codext);
      $this->si130_codfontrecursos = ($this->si130_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_codfontrecursos"] : $this->si130_codfontrecursos);
      $this->si130_nroop = ($this->si130_nroop == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_nroop"] : $this->si130_nroop);
      $this->si130_codunidadesub = ($this->si130_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_codunidadesub"] : $this->si130_codunidadesub);

      if ($this->si130_dtpagamento == "") {
        $this->si130_dtpagamento_dia = ($this->si130_dtpagamento_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_dtpagamento_dia"] : $this->si130_dtpagamento_dia);
        $this->si130_dtpagamento_mes = ($this->si130_dtpagamento_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_dtpagamento_mes"] : $this->si130_dtpagamento_mes);
        $this->si130_dtpagamento_ano = ($this->si130_dtpagamento_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_dtpagamento_ano"] : $this->si130_dtpagamento_ano);
        if ($this->si130_dtpagamento_dia != "") {
          $this->si130_dtpagamento = $this->si130_dtpagamento_ano . "-" . $this->si130_dtpagamento_mes . "-" . $this->si130_dtpagamento_dia;
        }
      }
      $this->si130_nroanulacaoop = ($this->si130_nroanulacaoop == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_nroanulacaoop"] : $this->si130_nroanulacaoop);
      if ($this->si130_dtanulacaoop == "") {
        $this->si130_dtanulacaoop_dia = ($this->si130_dtanulacaoop_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_dtanulacaoop_dia"] : $this->si130_dtanulacaoop_dia);
        $this->si130_dtanulacaoop_mes = ($this->si130_dtanulacaoop_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_dtanulacaoop_mes"] : $this->si130_dtanulacaoop_mes);
        $this->si130_dtanulacaoop_ano = ($this->si130_dtanulacaoop_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_dtanulacaoop_ano"] : $this->si130_dtanulacaoop_ano);
        if ($this->si130_dtanulacaoop_dia != "") {
          $this->si130_dtanulacaoop = $this->si130_dtanulacaoop_ano . "-" . $this->si130_dtanulacaoop_mes . "-" . $this->si130_dtanulacaoop_dia;
        }
      }
      $this->si130_vlanulacaoop = ($this->si130_vlanulacaoop == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_vlanulacaoop"] : $this->si130_vlanulacaoop);
      $this->si130_mes = ($this->si130_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_mes"] : $this->si130_mes);
      $this->si130_instit = ($this->si130_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_instit"] : $this->si130_instit);
    } else {
      $this->si130_sequencial = ($this->si130_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si130_sequencial"] : $this->si130_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si130_sequencial)
  {
    $this->atualizacampos();
    if ($this->si130_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si130_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si130_codext == null) {
      $this->si130_codext = "0";
    }
    if ($this->si130_codfontrecursos == null) {
      $this->si130_codfontrecursos = "0";
    }
    if ($this->si130_nroop == null) {
      $this->si130_nroop = "0";
    }
    if ($this->si130_codunidadesub == null) {
      $this->si130_codunidadesub = "0";
    }
    if ($this->si130_dtpagamento == null) {
      $this->si130_dtpagamento = "null";
    }
    if ($this->si130_nroanulacaoop == null) {
      $this->si130_nroanulacaoop = "0";
    }
    if ($this->si130_dtanulacaoop == null) {
      $this->si130_dtanulacaoop = "null";
    }
    if ($this->si130_vlanulacaoop == null) {
      $this->si130_vlanulacaoop = "0";
    }
    if ($this->si130_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si130_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si130_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si130_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si130_sequencial == "" || $si130_sequencial == null) {
      $result = db_query("select nextval('aex102021_si130_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: aex102021_si130_sequencial_seq do campo: si130_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si130_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from aex102021_si130_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si130_sequencial)) {
        $this->erro_sql = " Campo si130_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si130_sequencial = $si130_sequencial;
      }
    }
    if (($this->si130_sequencial == null) || ($this->si130_sequencial == "")) {
      $this->erro_sql = " Campo si130_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into aex102021(
                                       si130_sequencial 
                                      ,si130_tiporegistro 
                                      ,si130_codext
                                      ,si130_codfontrecursos
                                      ,si130_nroop
                                      ,si130_codunidadesub
                                      ,si130_dtpagamento 
                                      ,si130_nroanulacaoop 
                                      ,si130_dtanulacaoop 
                                      ,si130_vlanulacaoop 
                                      ,si130_mes
                                      ,si130_instit 
                       )
                values (
                                $this->si130_sequencial 
                               ,$this->si130_tiporegistro 
                               ,$this->si130_codext
                               ,$this->si130_codfontrecursos
                               ,$this->si130_nroop
                               ,$this->si130_codunidadesub
                               ," . ($this->si130_dtpagamento == "null" || $this->si130_dtpagamento == "" ? "null" : "'" . $this->si130_dtpagamento . "'") . "
                               ,$this->si130_nroanulacaoop 
                               ," . ($this->si130_dtanulacaoop == "null" || $this->si130_dtanulacaoop == "" ? "null" : "'" . $this->si130_dtanulacaoop . "'") . "
                               ,$this->si130_vlanulacaoop 
                               ,$this->si130_mes
                               ,$this->si130_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "aex102021 ($this->si130_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "aex102021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "aex102021 ($this->si130_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si130_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si130_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010916,'$this->si130_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010359,2010916,'','" . AddSlashes(pg_result($resaco, 0, 'si130_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010359,2010910,'','" . AddSlashes(pg_result($resaco, 0, 'si130_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010359,2010911,'','" . AddSlashes(pg_result($resaco, 0, 'si130_codext')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010359,2010912,'','" . AddSlashes(pg_result($resaco, 0, 'si130_nroop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010359,2010913,'','" . AddSlashes(pg_result($resaco, 0, 'si130_dtpagamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010359,2011303,'','" . AddSlashes(pg_result($resaco, 0, 'si130_nroanulacaoop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010359,2011304,'','" . AddSlashes(pg_result($resaco, 0, 'si130_dtanulacaoop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010359,2011305,'','" . AddSlashes(pg_result($resaco, 0, 'si130_vlanulacaoop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010359,2010914,'','" . AddSlashes(pg_result($resaco, 0, 'si130_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010359,2010915,'','" . AddSlashes(pg_result($resaco, 0, 'si130_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010359,2011643,'','" . AddSlashes(pg_result($resaco, 0, 'si130_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si130_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update aex102021 set ";
    $virgula = "";
    if (trim($this->si130_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si130_sequencial"])) {
      if (trim($this->si130_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si130_sequencial"])) {
        $this->si130_sequencial = "0";
      }
      $sql .= $virgula . " si130_sequencial = $this->si130_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si130_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si130_tiporegistro"])) {
      $sql .= $virgula . " si130_tiporegistro = $this->si130_tiporegistro ";
      $virgula = ",";
      if (trim($this->si130_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si130_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si130_codext) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si130_codext"])) {
      if (trim($this->si130_codext) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si130_codext"])) {
        $this->si130_codext = "0";
      }
      $sql .= $virgula . " si130_codext = $this->si130_codext ";
      $virgula = ",";
    }
    if (trim($this->si130_nroop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si130_nroop"])) {
      if (trim($this->si130_nroop) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si130_nroop"])) {
        $this->si130_nroop = "0";
      }
      $sql .= $virgula . " si130_nroop = $this->si130_nroop ";
      $virgula = ",";
    }
    if (trim($this->si130_dtpagamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si130_dtpagamento_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si130_dtpagamento_dia"] != "")) {
      $sql .= $virgula . " si130_dtpagamento = '$this->si130_dtpagamento' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si130_dtpagamento_dia"])) {
        $sql .= $virgula . " si130_dtpagamento = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si130_nroanulacaoop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si130_nroanulacaoop"])) {
      if (trim($this->si130_nroanulacaoop) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si130_nroanulacaoop"])) {
        $this->si130_nroanulacaoop = "0";
      }
      $sql .= $virgula . " si130_nroanulacaoop = $this->si130_nroanulacaoop ";
      $virgula = ",";
    }
    if (trim($this->si130_dtanulacaoop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si130_dtanulacaoop_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si130_dtanulacaoop_dia"] != "")) {
      $sql .= $virgula . " si130_dtanulacaoop = '$this->si130_dtanulacaoop' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si130_dtanulacaoop_dia"])) {
        $sql .= $virgula . " si130_dtanulacaoop = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si130_vlanulacaoop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si130_vlanulacaoop"])) {
      if (trim($this->si130_vlanulacaoop) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si130_vlanulacaoop"])) {
        $this->si130_vlanulacaoop = "0";
      }
      $sql .= $virgula . " si130_vlanulacaoop = $this->si130_vlanulacaoop ";
      $virgula = ",";
    }
    if (trim($this->si130_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si130_mes"])) {
      $sql .= $virgula . " si130_mes = $this->si130_mes ";
      $virgula = ",";
      if (trim($this->si130_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si130_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si130_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si130_reg10"])) {
      if (trim($this->si130_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si130_reg10"])) {
        $this->si130_reg10 = "0";
      }
      $sql .= $virgula . " si130_reg10 = $this->si130_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si130_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si130_instit"])) {
      $sql .= $virgula . " si130_instit = $this->si130_instit ";
      $virgula = ",";
      if (trim($this->si130_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si130_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si130_sequencial != null) {
      $sql .= " si130_sequencial = $this->si130_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si130_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010916,'$this->si130_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si130_sequencial"]) || $this->si130_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010359,2010916,'" . AddSlashes(pg_result($resaco, $conresaco, 'si130_sequencial')) . "','$this->si130_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si130_tiporegistro"]) || $this->si130_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010359,2010910,'" . AddSlashes(pg_result($resaco, $conresaco, 'si130_tiporegistro')) . "','$this->si130_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si130_codext"]) || $this->si130_codext != "")
          $resac = db_query("insert into db_acount values($acount,2010359,2010911,'" . AddSlashes(pg_result($resaco, $conresaco, 'si130_codext')) . "','$this->si130_codext'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si130_nroop"]) || $this->si130_nroop != "")
          $resac = db_query("insert into db_acount values($acount,2010359,2010912,'" . AddSlashes(pg_result($resaco, $conresaco, 'si130_nroop')) . "','$this->si130_nroop'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si130_dtpagamento"]) || $this->si130_dtpagamento != "")
          $resac = db_query("insert into db_acount values($acount,2010359,2010913,'" . AddSlashes(pg_result($resaco, $conresaco, 'si130_dtpagamento')) . "','$this->si130_dtpagamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si130_nroanulacaoop"]) || $this->si130_nroanulacaoop != "")
          $resac = db_query("insert into db_acount values($acount,2010359,2011303,'" . AddSlashes(pg_result($resaco, $conresaco, 'si130_nroanulacaoop')) . "','$this->si130_nroanulacaoop'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si130_dtanulacaoop"]) || $this->si130_dtanulacaoop != "")
          $resac = db_query("insert into db_acount values($acount,2010359,2011304,'" . AddSlashes(pg_result($resaco, $conresaco, 'si130_dtanulacaoop')) . "','$this->si130_dtanulacaoop'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si130_vlanulacaoop"]) || $this->si130_vlanulacaoop != "")
          $resac = db_query("insert into db_acount values($acount,2010359,2011305,'" . AddSlashes(pg_result($resaco, $conresaco, 'si130_vlanulacaoop')) . "','$this->si130_vlanulacaoop'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si130_mes"]) || $this->si130_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010359,2010914,'" . AddSlashes(pg_result($resaco, $conresaco, 'si130_mes')) . "','$this->si130_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si130_reg10"]) || $this->si130_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010359,2010915,'" . AddSlashes(pg_result($resaco, $conresaco, 'si130_reg10')) . "','$this->si130_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si130_instit"]) || $this->si130_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010359,2011643,'" . AddSlashes(pg_result($resaco, $conresaco, 'si130_instit')) . "','$this->si130_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aex102021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si130_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aex102021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si130_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si130_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si130_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si130_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010916,'$si130_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010359,2010916,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si130_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010359,2010910,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si130_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010359,2010911,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si130_codext')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010359,2010912,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si130_nroop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010359,2010913,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si130_dtpagamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010359,2011303,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si130_nroanulacaoop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010359,2011304,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si130_dtanulacaoop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010359,2011305,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si130_vlanulacaoop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010359,2010914,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si130_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010359,2010915,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si130_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010359,2011643,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si130_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from aex102021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si130_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si130_sequencial = $si130_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aex102021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si130_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aex102021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si130_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si130_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:aex102021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si130_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = split("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from aex102021 ";
    $sql .= "      left  join aex102021  on  aex102021.si129_sequencial = aex102021.si130_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si130_sequencial != null) {
        $sql2 .= " where aex102021.si130_sequencial = $si130_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = split("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }

    return $sql;
  }

  // funcao do sql
  function sql_query_file($si130_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = split("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from aex102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si130_sequencial != null) {
        $sql2 .= " where aex102021.si130_sequencial = $si130_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = split("#", $ordem);
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
