<?
//MODULO: sicom
//CLASSE DA ENTIDADE aberlic132021
class cl_aberlic132021
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
  var $si49_sequencial = 0;
  var $si49_tiporegistro = 0;
  var $si49_codorgaoresp = null;
  var $si49_codunidadesubresp = null;
  var $si49_exerciciolicitacao = 0;
  var $si49_nroprocessolicitatorio = null;
  var $si49_nrolote = 0;
  var $si49_coditem = 0;
  var $si49_mes = 0;
  var $si49_reg10 = 0;
  var $si49_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si49_sequencial = int8 = sequencial 
                 si49_tiporegistro = int8 = Tipo do  registro 
                 si49_codorgaoresp = varchar(2) = Código do órgão 
                 si49_codunidadesubresp = varchar(8) = Código da unidade 
                 si49_exerciciolicitacao = int8 = Exercício em que   foi instaurado 
                 si49_nroprocessolicitatorio = varchar(12) = Número sequencial do processo 
                 si49_nrolote = int8 = Número do Lote 
                 si49_coditem = int8 = Código do Item 
                 si49_mes = int8 = Mês 
                 si49_reg10 = int8 = reg10 
                 si49_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_aberlic132021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("aberlic132021");
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
      $this->si49_sequencial = ($this->si49_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si49_sequencial"] : $this->si49_sequencial);
      $this->si49_tiporegistro = ($this->si49_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si49_tiporegistro"] : $this->si49_tiporegistro);
      $this->si49_codorgaoresp = ($this->si49_codorgaoresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si49_codorgaoresp"] : $this->si49_codorgaoresp);
      $this->si49_codunidadesubresp = ($this->si49_codunidadesubresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si49_codunidadesubresp"] : $this->si49_codunidadesubresp);
      $this->si49_exerciciolicitacao = ($this->si49_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si49_exerciciolicitacao"] : $this->si49_exerciciolicitacao);
      $this->si49_nroprocessolicitatorio = ($this->si49_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si49_nroprocessolicitatorio"] : $this->si49_nroprocessolicitatorio);
      $this->si49_nrolote = ($this->si49_nrolote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si49_nrolote"] : $this->si49_nrolote);
      $this->si49_coditem = ($this->si49_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si49_coditem"] : $this->si49_coditem);
      $this->si49_mes = ($this->si49_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si49_mes"] : $this->si49_mes);
      $this->si49_reg10 = ($this->si49_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si49_reg10"] : $this->si49_reg10);
      $this->si49_instit = ($this->si49_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si49_instit"] : $this->si49_instit);
    } else {
      $this->si49_sequencial = ($this->si49_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si49_sequencial"] : $this->si49_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si49_sequencial)
  {
    $this->atualizacampos();
    if ($this->si49_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si49_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si49_exerciciolicitacao == null) {
      $this->si49_exerciciolicitacao = "0";
    }
    if ($this->si49_nrolote == null) {
      $this->si49_nrolote = "0";
    }
    if ($this->si49_coditem == null) {
      $this->si49_coditem = "0";
    }
    if ($this->si49_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si49_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si49_reg10 == null) {
      $this->si49_reg10 = "0";
    }
    if ($this->si49_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si49_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si49_sequencial == "" || $si49_sequencial == null) {
      $result = db_query("select nextval('aberlic132021_si49_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: aberlic132021_si49_sequencial_seq do campo: si49_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si49_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from aberlic132021_si49_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si49_sequencial)) {
        $this->erro_sql = " Campo si49_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si49_sequencial = $si49_sequencial;
      }
    }
    if (($this->si49_sequencial == null) || ($this->si49_sequencial == "")) {
      $this->erro_sql = " Campo si49_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into aberlic132021
                                       si49_sequencial 
                                      ,si49_tiporegistro 
                                      ,si49_codorgaoresp 
                                      ,si49_codunidadesubresp 
                                      ,si49_exerciciolicitacao 
                                      ,si49_nroprocessolicitatorio 
                                      ,si49_nrolote 
                                      ,si49_coditem 
                                      ,si49_mes 
                                      ,si49_reg10 
                                      ,si49_instit 
                       )
                values (
                                $this->si49_sequencial 
                               ,$this->si49_tiporegistro 
                               ,'$this->si49_codorgaoresp' 
                               ,'$this->si49_codunidadesubresp' 
                               ,$this->si49_exerciciolicitacao 
                               ,'$this->si49_nroprocessolicitatorio' 
                               ,$this->si49_nrolote 
                               ,$this->si49_coditem 
                               ,$this->si49_mes 
                               ,$this->si49_reg10 
                               ,$this->si49_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "aberlic132021 ($this->si49_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "aberlic132021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "aberlic132021 ($this->si49_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si49_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si49_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009919,'$this->si49_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010278,2009919,'','" . AddSlashes(pg_result($resaco, 0, 'si49_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010278,2009920,'','" . AddSlashes(pg_result($resaco, 0, 'si49_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010278,2009921,'','" . AddSlashes(pg_result($resaco, 0, 'si49_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010278,2009922,'','" . AddSlashes(pg_result($resaco, 0, 'si49_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010278,2009923,'','" . AddSlashes(pg_result($resaco, 0, 'si49_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010278,2009924,'','" . AddSlashes(pg_result($resaco, 0, 'si49_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010278,2009925,'','" . AddSlashes(pg_result($resaco, 0, 'si49_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010278,2009926,'','" . AddSlashes(pg_result($resaco, 0, 'si49_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010278,2009927,'','" . AddSlashes(pg_result($resaco, 0, 'si49_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010278,2009928,'','" . AddSlashes(pg_result($resaco, 0, 'si49_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010278,2011563,'','" . AddSlashes(pg_result($resaco, 0, 'si49_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si49_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update aberlic132021 set ";
    $virgula = "";
    if (trim($this->si49_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si49_sequencial"])) {
      if (trim($this->si49_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si49_sequencial"])) {
        $this->si49_sequencial = "0";
      }
      $sql .= $virgula . " si49_sequencial = $this->si49_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si49_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si49_tiporegistro"])) {
      $sql .= $virgula . " si49_tiporegistro = $this->si49_tiporegistro ";
      $virgula = ",";
      if (trim($this->si49_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si49_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si49_codorgaoresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si49_codorgaoresp"])) {
      $sql .= $virgula . " si49_codorgaoresp = '$this->si49_codorgaoresp' ";
      $virgula = ",";
    }
    if (trim($this->si49_codunidadesubresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si49_codunidadesubresp"])) {
      $sql .= $virgula . " si49_codunidadesubresp = '$this->si49_codunidadesubresp' ";
      $virgula = ",";
    }
    if (trim($this->si49_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si49_exerciciolicitacao"])) {
      if (trim($this->si49_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si49_exerciciolicitacao"])) {
        $this->si49_exerciciolicitacao = "0";
      }
      $sql .= $virgula . " si49_exerciciolicitacao = $this->si49_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si49_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si49_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si49_nroprocessolicitatorio = '$this->si49_nroprocessolicitatorio' ";
      $virgula = ",";
    }
    if (trim($this->si49_nrolote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si49_nrolote"])) {
      if (trim($this->si49_nrolote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si49_nrolote"])) {
        $this->si49_nrolote = "0";
      }
      $sql .= $virgula . " si49_nrolote = $this->si49_nrolote ";
      $virgula = ",";
    }
    if (trim($this->si49_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si49_coditem"])) {
      if (trim($this->si49_coditem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si49_coditem"])) {
        $this->si49_coditem = "0";
      }
      $sql .= $virgula . " si49_coditem = $this->si49_coditem ";
      $virgula = ",";
    }
    if (trim($this->si49_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si49_mes"])) {
      $sql .= $virgula . " si49_mes = $this->si49_mes ";
      $virgula = ",";
      if (trim($this->si49_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si49_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si49_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si49_reg10"])) {
      if (trim($this->si49_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si49_reg10"])) {
        $this->si49_reg10 = "0";
      }
      $sql .= $virgula . " si49_reg10 = $this->si49_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si49_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si49_instit"])) {
      $sql .= $virgula . " si49_instit = $this->si49_instit ";
      $virgula = ",";
      if (trim($this->si49_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si49_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si49_sequencial != null) {
      $sql .= " si49_sequencial = $this->si49_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si49_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009919,'$this->si49_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si49_sequencial"]) || $this->si49_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010278,2009919,'" . AddSlashes(pg_result($resaco, $conresaco, 'si49_sequencial')) . "','$this->si49_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si49_tiporegistro"]) || $this->si49_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010278,2009920,'" . AddSlashes(pg_result($resaco, $conresaco, 'si49_tiporegistro')) . "','$this->si49_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si49_codorgaoresp"]) || $this->si49_codorgaoresp != "")
          $resac = db_query("insert into db_acount values($acount,2010278,2009921,'" . AddSlashes(pg_result($resaco, $conresaco, 'si49_codorgaoresp')) . "','$this->si49_codorgaoresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si49_codunidadesubresp"]) || $this->si49_codunidadesubresp != "")
          $resac = db_query("insert into db_acount values($acount,2010278,2009922,'" . AddSlashes(pg_result($resaco, $conresaco, 'si49_codunidadesubresp')) . "','$this->si49_codunidadesubresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si49_exerciciolicitacao"]) || $this->si49_exerciciolicitacao != "")
          $resac = db_query("insert into db_acount values($acount,2010278,2009923,'" . AddSlashes(pg_result($resaco, $conresaco, 'si49_exerciciolicitacao')) . "','$this->si49_exerciciolicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si49_nroprocessolicitatorio"]) || $this->si49_nroprocessolicitatorio != "")
          $resac = db_query("insert into db_acount values($acount,2010278,2009924,'" . AddSlashes(pg_result($resaco, $conresaco, 'si49_nroprocessolicitatorio')) . "','$this->si49_nroprocessolicitatorio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si49_nrolote"]) || $this->si49_nrolote != "")
          $resac = db_query("insert into db_acount values($acount,2010278,2009925,'" . AddSlashes(pg_result($resaco, $conresaco, 'si49_nrolote')) . "','$this->si49_nrolote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si49_coditem"]) || $this->si49_coditem != "")
          $resac = db_query("insert into db_acount values($acount,2010278,2009926,'" . AddSlashes(pg_result($resaco, $conresaco, 'si49_coditem')) . "','$this->si49_coditem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si49_mes"]) || $this->si49_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010278,2009927,'" . AddSlashes(pg_result($resaco, $conresaco, 'si49_mes')) . "','$this->si49_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si49_reg10"]) || $this->si49_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010278,2009928,'" . AddSlashes(pg_result($resaco, $conresaco, 'si49_reg10')) . "','$this->si49_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si49_instit"]) || $this->si49_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010278,2011563,'" . AddSlashes(pg_result($resaco, $conresaco, 'si49_instit')) . "','$this->si49_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aberlic132021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si49_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aberlic132021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si49_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si49_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si49_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si49_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009919,'$si49_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010278,2009919,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si49_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010278,2009920,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si49_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010278,2009921,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si49_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010278,2009922,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si49_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010278,2009923,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si49_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010278,2009924,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si49_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010278,2009925,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si49_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010278,2009926,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si49_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010278,2009927,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si49_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010278,2009928,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si49_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010278,2011563,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si49_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from aberlic132021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si49_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si49_sequencial = $si49_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aberlic132021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si49_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aberlic132021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si49_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si49_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:aberlic132021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si49_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aberlic132021 ";
    $sql .= "      left  join aberlic102021  on  aberlic102021.si46_sequencial = aberlic132021.si49_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si49_sequencial != null) {
        $sql2 .= " where aberlic132021.si49_sequencial = $si49_sequencial ";
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
  function sql_query_file($si49_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aberlic132021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si49_sequencial != null) {
        $sql2 .= " where aberlic132021.si49_sequencial = $si49_sequencial ";
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
