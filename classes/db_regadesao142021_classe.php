<?
//MODULO: sicom
//CLASSE DA ENTIDADE regadesao142020
class cl_regadesao142020
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
  var $si71_sequencial = 0;
  var $si71_tiporegistro = 0;
  var $si71_codorgao = null;
  var $si71_codunidadesub = null;
  var $si71_nroprocadesao = null;
  var $si71_exercicioadesao = 0;
  var $si71_nrolote = 0;
  var $si71_coditem = 0;
  var $si71_dtcotacao_dia = null;
  var $si71_dtcotacao_mes = null;
  var $si71_dtcotacao_ano = null;
  var $si71_dtcotacao = null;
  var $si71_vlcotprecosunitario = 0;
  var $si71_quantidade = 0;
  var $si71_mes = 0;
  var $si71_reg10 = 0;
  var $si71_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si71_sequencial = int8 = sequencial 
                 si71_tiporegistro = int8 = Tipo do  registro 
                 si71_codorgao = varchar(2) = Código do órgão 
                 si71_codunidadesub = varchar(8) = Código da unidade 
                 si71_nroprocadesao = varchar(12) = Número do  processo de  adesão 
                 si71_exercicioadesao = int8 = Exercício do  processo de  adesão 
                 si71_nrolote = int8 = Número do Lote 
                 si71_coditem = int8 = Código do Item 
                 si71_dtcotacao = date = Data da cotação 
                 si71_vlcotprecosunitario = float8 = Valor de referência 
                 si71_quantidade = float8 = Quantidade do item 
                 si71_mes = int8 = Mês 
                 si71_reg10 = int8 = reg10 
                 si71_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_regadesao142020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("regadesao142020");
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
      $this->si71_sequencial = ($this->si71_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_sequencial"] : $this->si71_sequencial);
      $this->si71_tiporegistro = ($this->si71_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_tiporegistro"] : $this->si71_tiporegistro);
      $this->si71_codorgao = ($this->si71_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_codorgao"] : $this->si71_codorgao);
      $this->si71_codunidadesub = ($this->si71_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_codunidadesub"] : $this->si71_codunidadesub);
      $this->si71_nroprocadesao = ($this->si71_nroprocadesao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_nroprocadesao"] : $this->si71_nroprocadesao);
      $this->si71_exercicioadesao = ($this->si71_exercicioadesao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_exercicioadesao"] : $this->si71_exercicioadesao);
      $this->si71_nrolote = ($this->si71_nrolote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_nrolote"] : $this->si71_nrolote);
      $this->si71_coditem = ($this->si71_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_coditem"] : $this->si71_coditem);
      if ($this->si71_dtcotacao == "") {
        $this->si71_dtcotacao_dia = ($this->si71_dtcotacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_dtcotacao_dia"] : $this->si71_dtcotacao_dia);
        $this->si71_dtcotacao_mes = ($this->si71_dtcotacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_dtcotacao_mes"] : $this->si71_dtcotacao_mes);
        $this->si71_dtcotacao_ano = ($this->si71_dtcotacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_dtcotacao_ano"] : $this->si71_dtcotacao_ano);
        if ($this->si71_dtcotacao_dia != "") {
          $this->si71_dtcotacao = $this->si71_dtcotacao_ano . "-" . $this->si71_dtcotacao_mes . "-" . $this->si71_dtcotacao_dia;
        }
      }
      $this->si71_vlcotprecosunitario = ($this->si71_vlcotprecosunitario == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_vlcotprecosunitario"] : $this->si71_vlcotprecosunitario);
      $this->si71_quantidade = ($this->si71_quantidade == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_quantidade"] : $this->si71_quantidade);
      $this->si71_mes = ($this->si71_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_mes"] : $this->si71_mes);
      $this->si71_reg10 = ($this->si71_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_reg10"] : $this->si71_reg10);
      $this->si71_instit = ($this->si71_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_instit"] : $this->si71_instit);
    } else {
      $this->si71_sequencial = ($this->si71_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si71_sequencial"] : $this->si71_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si71_sequencial)
  {
    $this->atualizacampos();
    if ($this->si71_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si71_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si71_exercicioadesao == null) {
      $this->si71_exercicioadesao = "0";
    }
    if ($this->si71_nrolote == null) {
      $this->si71_nrolote = "0";
    }
    if ($this->si71_coditem == null) {
      $this->si71_coditem = "0";
    }
    if ($this->si71_dtcotacao == null) {
      $this->si71_dtcotacao = "null";
    }
    if ($this->si71_vlcotprecosunitario == null) {
      $this->si71_vlcotprecosunitario = "0";
    }
    if ($this->si71_quantidade == null) {
      $this->si71_quantidade = "0";
    }
    if ($this->si71_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si71_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si71_reg10 == null) {
      $this->si71_reg10 = "0";
    }
    if ($this->si71_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si71_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($si71_sequencial == "" || $si71_sequencial == null) {
      $result = db_query("select nextval('regadesao142020_si71_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: regadesao142020_si71_sequencial_seq do campo: si71_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si71_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from regadesao142020_si71_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si71_sequencial)) {
        $this->erro_sql = " Campo si71_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->si71_sequencial = $si71_sequencial;
      }
    }
    if (($this->si71_sequencial == null) || ($this->si71_sequencial == "")) {
      $this->erro_sql = " Campo si71_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into regadesao142020(
                                       si71_sequencial 
                                      ,si71_tiporegistro 
                                      ,si71_codorgao 
                                      ,si71_codunidadesub 
                                      ,si71_nroprocadesao 
                                      ,si71_exercicioadesao 
                                      ,si71_nrolote 
                                      ,si71_coditem 
                                      ,si71_dtcotacao 
                                      ,si71_vlcotprecosunitario 
                                      ,si71_quantidade 
                                      ,si71_mes 
                                      ,si71_reg10 
                                      ,si71_instit 
                       )
                values (
                                $this->si71_sequencial 
                               ,$this->si71_tiporegistro 
                               ,'$this->si71_codorgao' 
                               ,'$this->si71_codunidadesub' 
                               ,'$this->si71_nroprocadesao' 
                               ,$this->si71_exercicioadesao 
                               ,$this->si71_nrolote 
                               ,$this->si71_coditem 
                               ," . ($this->si71_dtcotacao == "null" || $this->si71_dtcotacao == "" ? "null" : "'" . $this->si71_dtcotacao . "'") . " 
                               ,$this->si71_vlcotprecosunitario 
                               ,$this->si71_quantidade 
                               ,$this->si71_mes 
                               ,$this->si71_reg10 
                               ,$this->si71_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "regadesao142020 ($this->si71_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "regadesao142020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "regadesao142020 ($this->si71_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si71_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si71_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010214,'$this->si71_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010300,2010214,'','" . AddSlashes(pg_result($resaco, 0, 'si71_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010300,2010215,'','" . AddSlashes(pg_result($resaco, 0, 'si71_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010300,2010216,'','" . AddSlashes(pg_result($resaco, 0, 'si71_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010300,2010217,'','" . AddSlashes(pg_result($resaco, 0, 'si71_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010300,2010218,'','" . AddSlashes(pg_result($resaco, 0, 'si71_nroprocadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010300,2011314,'','" . AddSlashes(pg_result($resaco, 0, 'si71_exercicioadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010300,2010221,'','" . AddSlashes(pg_result($resaco, 0, 'si71_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010300,2010222,'','" . AddSlashes(pg_result($resaco, 0, 'si71_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010300,2010223,'','" . AddSlashes(pg_result($resaco, 0, 'si71_dtcotacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010300,2010224,'','" . AddSlashes(pg_result($resaco, 0, 'si71_vlcotprecosunitario')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010300,2010225,'','" . AddSlashes(pg_result($resaco, 0, 'si71_quantidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010300,2010226,'','" . AddSlashes(pg_result($resaco, 0, 'si71_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010300,2010227,'','" . AddSlashes(pg_result($resaco, 0, 'si71_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010300,2011583,'','" . AddSlashes(pg_result($resaco, 0, 'si71_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    return true;
  }
  
  // funcao para alteracao
  function alterar($si71_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update regadesao142020 set ";
    $virgula = "";
    if (trim($this->si71_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si71_sequencial"])) {
      if (trim($this->si71_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si71_sequencial"])) {
        $this->si71_sequencial = "0";
      }
      $sql .= $virgula . " si71_sequencial = $this->si71_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si71_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si71_tiporegistro"])) {
      $sql .= $virgula . " si71_tiporegistro = $this->si71_tiporegistro ";
      $virgula = ",";
      if (trim($this->si71_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si71_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si71_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si71_codorgao"])) {
      $sql .= $virgula . " si71_codorgao = '$this->si71_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si71_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si71_codunidadesub"])) {
      $sql .= $virgula . " si71_codunidadesub = '$this->si71_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si71_nroprocadesao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si71_nroprocadesao"])) {
      $sql .= $virgula . " si71_nroprocadesao = '$this->si71_nroprocadesao' ";
      $virgula = ",";
    }
    if (trim($this->si71_exercicioadesao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si71_exercicioadesao"])) {
      if (trim($this->si71_exercicioadesao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si71_exercicioadesao"])) {
        $this->si71_exercicioadesao = "0";
      }
      $sql .= $virgula . " si71_exercicioadesao = $this->si71_exercicioadesao ";
      $virgula = ",";
    }
    if (trim($this->si71_nrolote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si71_nrolote"])) {
      if (trim($this->si71_nrolote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si71_nrolote"])) {
        $this->si71_nrolote = "0";
      }
      $sql .= $virgula . " si71_nrolote = $this->si71_nrolote ";
      $virgula = ",";
    }
    if (trim($this->si71_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si71_coditem"])) {
      if (trim($this->si71_coditem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si71_coditem"])) {
        $this->si71_coditem = "0";
      }
      $sql .= $virgula . " si71_coditem = $this->si71_coditem ";
      $virgula = ",";
    }
    if (trim($this->si71_dtcotacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si71_dtcotacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si71_dtcotacao_dia"] != "")) {
      $sql .= $virgula . " si71_dtcotacao = '$this->si71_dtcotacao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si71_dtcotacao_dia"])) {
        $sql .= $virgula . " si71_dtcotacao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si71_vlcotprecosunitario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si71_vlcotprecosunitario"])) {
      if (trim($this->si71_vlcotprecosunitario) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si71_vlcotprecosunitario"])) {
        $this->si71_vlcotprecosunitario = "0";
      }
      $sql .= $virgula . " si71_vlcotprecosunitario = $this->si71_vlcotprecosunitario ";
      $virgula = ",";
    }
    if (trim($this->si71_quantidade) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si71_quantidade"])) {
      if (trim($this->si71_quantidade) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si71_quantidade"])) {
        $this->si71_quantidade = "0";
      }
      $sql .= $virgula . " si71_quantidade = $this->si71_quantidade ";
      $virgula = ",";
    }
    if (trim($this->si71_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si71_mes"])) {
      $sql .= $virgula . " si71_mes = $this->si71_mes ";
      $virgula = ",";
      if (trim($this->si71_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si71_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si71_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si71_reg10"])) {
      if (trim($this->si71_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si71_reg10"])) {
        $this->si71_reg10 = "0";
      }
      $sql .= $virgula . " si71_reg10 = $this->si71_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si71_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si71_instit"])) {
      $sql .= $virgula . " si71_instit = $this->si71_instit ";
      $virgula = ",";
      if (trim($this->si71_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si71_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($si71_sequencial != null) {
      $sql .= " si71_sequencial = $this->si71_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si71_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010214,'$this->si71_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si71_sequencial"]) || $this->si71_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010300,2010214,'" . AddSlashes(pg_result($resaco, $conresaco, 'si71_sequencial')) . "','$this->si71_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si71_tiporegistro"]) || $this->si71_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010300,2010215,'" . AddSlashes(pg_result($resaco, $conresaco, 'si71_tiporegistro')) . "','$this->si71_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si71_codorgao"]) || $this->si71_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010300,2010216,'" . AddSlashes(pg_result($resaco, $conresaco, 'si71_codorgao')) . "','$this->si71_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si71_codunidadesub"]) || $this->si71_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010300,2010217,'" . AddSlashes(pg_result($resaco, $conresaco, 'si71_codunidadesub')) . "','$this->si71_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si71_nroprocadesao"]) || $this->si71_nroprocadesao != "")
          $resac = db_query("insert into db_acount values($acount,2010300,2010218,'" . AddSlashes(pg_result($resaco, $conresaco, 'si71_nroprocadesao')) . "','$this->si71_nroprocadesao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si71_exercicioadesao"]) || $this->si71_exercicioadesao != "")
          $resac = db_query("insert into db_acount values($acount,2010300,2011314,'" . AddSlashes(pg_result($resaco, $conresaco, 'si71_exercicioadesao')) . "','$this->si71_exercicioadesao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si71_nrolote"]) || $this->si71_nrolote != "")
          $resac = db_query("insert into db_acount values($acount,2010300,2010221,'" . AddSlashes(pg_result($resaco, $conresaco, 'si71_nrolote')) . "','$this->si71_nrolote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si71_coditem"]) || $this->si71_coditem != "")
          $resac = db_query("insert into db_acount values($acount,2010300,2010222,'" . AddSlashes(pg_result($resaco, $conresaco, 'si71_coditem')) . "','$this->si71_coditem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si71_dtcotacao"]) || $this->si71_dtcotacao != "")
          $resac = db_query("insert into db_acount values($acount,2010300,2010223,'" . AddSlashes(pg_result($resaco, $conresaco, 'si71_dtcotacao')) . "','$this->si71_dtcotacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si71_vlcotprecosunitario"]) || $this->si71_vlcotprecosunitario != "")
          $resac = db_query("insert into db_acount values($acount,2010300,2010224,'" . AddSlashes(pg_result($resaco, $conresaco, 'si71_vlcotprecosunitario')) . "','$this->si71_vlcotprecosunitario'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si71_quantidade"]) || $this->si71_quantidade != "")
          $resac = db_query("insert into db_acount values($acount,2010300,2010225,'" . AddSlashes(pg_result($resaco, $conresaco, 'si71_quantidade')) . "','$this->si71_quantidade'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si71_mes"]) || $this->si71_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010300,2010226,'" . AddSlashes(pg_result($resaco, $conresaco, 'si71_mes')) . "','$this->si71_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si71_reg10"]) || $this->si71_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010300,2010227,'" . AddSlashes(pg_result($resaco, $conresaco, 'si71_reg10')) . "','$this->si71_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si71_instit"]) || $this->si71_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010300,2011583,'" . AddSlashes(pg_result($resaco, $conresaco, 'si71_instit')) . "','$this->si71_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "regadesao142020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si71_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "regadesao142020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si71_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si71_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si71_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si71_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010214,'$si71_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010300,2010214,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si71_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010300,2010215,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si71_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010300,2010216,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si71_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010300,2010217,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si71_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010300,2010218,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si71_nroprocadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010300,2011314,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si71_exercicioadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010300,2010221,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si71_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010300,2010222,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si71_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010300,2010223,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si71_dtcotacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010300,2010224,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si71_vlcotprecosunitario')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010300,2010225,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si71_quantidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010300,2010226,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si71_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010300,2010227,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si71_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010300,2011583,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si71_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from regadesao142020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si71_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si71_sequencial = $si71_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "regadesao142020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si71_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "regadesao142020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si71_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si71_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:regadesao142020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  
  // funcao do sql
  function sql_query($si71_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from regadesao142020 ";
    $sql .= "      left  join regadesao102020  on  regadesao102020.si67_sequencial = regadesao142020.si71_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si71_sequencial != null) {
        $sql2 .= " where regadesao142020.si71_sequencial = $si71_sequencial ";
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
  function sql_query_file($si71_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from regadesao142020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si71_sequencial != null) {
        $sql2 .= " where regadesao142020.si71_sequencial = $si71_sequencial ";
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
