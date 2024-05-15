<?
//MODULO: sicom
//CLASSE DA ENTIDADE anl112017
class cl_anl112017
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
  var $si111_sequencial = 0;
  var $si111_tiporegistro = 0;
  var $si111_codunidadesub = null;
  var $si111_nroempenho = 0;
  var $si111_nroanulacao = 0;
  var $si111_codfontrecursos = 0;
  var $si111_vlanulacaofonte = 0;
  var $si111_mes = 0;
  var $si111_reg10 = 0;
  var $si111_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si111_sequencial = int8 = sequencial 
                 si111_tiporegistro = int8 = Tipo do registro 
                 si111_codunidadesub = varchar(8) = Código da unidade 
                 si111_nroempenho = int8 = Número do  empenho 
                 si111_nroanulacao = int8 = Número da  Anulação do  empenho 
                 si111_codfontrecursos = int8 = Código da fonte de  recursos 
                 si111_vlanulacaofonte = float8 = Valor anulado do  empenho fonte de recurso 
                 si111_mes = int8 = Mês 
                 si111_reg10 = int8 = reg10 
                 si111_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_anl112017()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("anl112017");
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
      $this->si111_sequencial = ($this->si111_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si111_sequencial"] : $this->si111_sequencial);
      $this->si111_tiporegistro = ($this->si111_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si111_tiporegistro"] : $this->si111_tiporegistro);
      $this->si111_codunidadesub = ($this->si111_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si111_codunidadesub"] : $this->si111_codunidadesub);
      $this->si111_nroempenho = ($this->si111_nroempenho == "" ? @$GLOBALS["HTTP_POST_VARS"]["si111_nroempenho"] : $this->si111_nroempenho);
      $this->si111_nroanulacao = ($this->si111_nroanulacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si111_nroanulacao"] : $this->si111_nroanulacao);
      $this->si111_codfontrecursos = ($this->si111_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si111_codfontrecursos"] : $this->si111_codfontrecursos);
      $this->si111_vlanulacaofonte = ($this->si111_vlanulacaofonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si111_vlanulacaofonte"] : $this->si111_vlanulacaofonte);
      $this->si111_mes = ($this->si111_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si111_mes"] : $this->si111_mes);
      $this->si111_reg10 = ($this->si111_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si111_reg10"] : $this->si111_reg10);
      $this->si111_instit = ($this->si111_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si111_instit"] : $this->si111_instit);
    } else {
      $this->si111_sequencial = ($this->si111_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si111_sequencial"] : $this->si111_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si111_sequencial)
  {
    $this->atualizacampos();
    if ($this->si111_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si111_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si111_nroempenho == null) {
      $this->si111_nroempenho = "0";
    }
    if ($this->si111_nroanulacao == null) {
      $this->si111_nroanulacao = "0";
    }
    if ($this->si111_codfontrecursos == null) {
      $this->si111_codfontrecursos = "0";
    }
    if ($this->si111_vlanulacaofonte == null) {
      $this->si111_vlanulacaofonte = "0";
    }
    if ($this->si111_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si111_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si111_reg10 == null) {
      $this->si111_reg10 = "0";
    }
    if ($this->si111_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si111_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si111_sequencial == "" || $si111_sequencial == null) {
      $result = db_query("select nextval('anl112017_si111_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: anl112017_si111_sequencial_seq do campo: si111_sequencial";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si111_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from anl112017_si111_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si111_sequencial)) {
        $this->erro_sql = " Campo si111_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si111_sequencial = $si111_sequencial;
      }
    }
    if (($this->si111_sequencial == null) || ($this->si111_sequencial == "")) {
      $this->erro_sql = " Campo si111_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into anl112017(
                                       si111_sequencial 
                                      ,si111_tiporegistro 
                                      ,si111_codunidadesub 
                                      ,si111_nroempenho 
                                      ,si111_nroanulacao 
                                      ,si111_codfontrecursos 
                                      ,si111_vlanulacaofonte 
                                      ,si111_mes 
                                      ,si111_reg10 
                                      ,si111_instit 
                       )
                values (
                                $this->si111_sequencial 
                               ,$this->si111_tiporegistro 
                               ,'$this->si111_codunidadesub' 
                               ,$this->si111_nroempenho 
                               ,$this->si111_nroanulacao 
                               ,$this->si111_codfontrecursos 
                               ,$this->si111_vlanulacaofonte 
                               ,$this->si111_mes 
                               ,$this->si111_reg10 
                               ,$this->si111_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "anl112017 ($this->si111_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "anl112017 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql = "anl112017 ($this->si111_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->si111_sequencial;
    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si111_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010713,'$this->si111_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010340,2010713,'','" . AddSlashes(pg_result($resaco, 0, 'si111_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010340,2010714,'','" . AddSlashes(pg_result($resaco, 0, 'si111_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010340,2010715,'','" . AddSlashes(pg_result($resaco, 0, 'si111_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010340,2010716,'','" . AddSlashes(pg_result($resaco, 0, 'si111_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010340,2010717,'','" . AddSlashes(pg_result($resaco, 0, 'si111_nroanulacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010340,2010718,'','" . AddSlashes(pg_result($resaco, 0, 'si111_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010340,2010719,'','" . AddSlashes(pg_result($resaco, 0, 'si111_vlanulacaofonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010340,2010720,'','" . AddSlashes(pg_result($resaco, 0, 'si111_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010340,2010721,'','" . AddSlashes(pg_result($resaco, 0, 'si111_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010340,2011624,'','" . AddSlashes(pg_result($resaco, 0, 'si111_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si111_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update anl112017 set ";
    $virgula = "";
    if (trim($this->si111_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si111_sequencial"])) {
      if (trim($this->si111_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si111_sequencial"])) {
        $this->si111_sequencial = "0";
      }
      $sql .= $virgula . " si111_sequencial = $this->si111_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si111_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si111_tiporegistro"])) {
      $sql .= $virgula . " si111_tiporegistro = $this->si111_tiporegistro ";
      $virgula = ",";
      if (trim($this->si111_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si111_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si111_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si111_codunidadesub"])) {
      $sql .= $virgula . " si111_codunidadesub = '$this->si111_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si111_nroempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si111_nroempenho"])) {
      if (trim($this->si111_nroempenho) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si111_nroempenho"])) {
        $this->si111_nroempenho = "0";
      }
      $sql .= $virgula . " si111_nroempenho = $this->si111_nroempenho ";
      $virgula = ",";
    }
    if (trim($this->si111_nroanulacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si111_nroanulacao"])) {
      if (trim($this->si111_nroanulacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si111_nroanulacao"])) {
        $this->si111_nroanulacao = "0";
      }
      $sql .= $virgula . " si111_nroanulacao = $this->si111_nroanulacao ";
      $virgula = ",";
    }
    if (trim($this->si111_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si111_codfontrecursos"])) {
      if (trim($this->si111_codfontrecursos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si111_codfontrecursos"])) {
        $this->si111_codfontrecursos = "0";
      }
      $sql .= $virgula . " si111_codfontrecursos = $this->si111_codfontrecursos ";
      $virgula = ",";
    }
    if (trim($this->si111_vlanulacaofonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si111_vlanulacaofonte"])) {
      if (trim($this->si111_vlanulacaofonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si111_vlanulacaofonte"])) {
        $this->si111_vlanulacaofonte = "0";
      }
      $sql .= $virgula . " si111_vlanulacaofonte = $this->si111_vlanulacaofonte ";
      $virgula = ",";
    }
    if (trim($this->si111_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si111_mes"])) {
      $sql .= $virgula . " si111_mes = $this->si111_mes ";
      $virgula = ",";
      if (trim($this->si111_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si111_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si111_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si111_reg10"])) {
      if (trim($this->si111_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si111_reg10"])) {
        $this->si111_reg10 = "0";
      }
      $sql .= $virgula . " si111_reg10 = $this->si111_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si111_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si111_instit"])) {
      $sql .= $virgula . " si111_instit = $this->si111_instit ";
      $virgula = ",";
      if (trim($this->si111_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si111_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si111_sequencial != null) {
      $sql .= " si111_sequencial = $this->si111_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si111_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010713,'$this->si111_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si111_sequencial"]) || $this->si111_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010340,2010713,'" . AddSlashes(pg_result($resaco, $conresaco, 'si111_sequencial')) . "','$this->si111_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si111_tiporegistro"]) || $this->si111_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010340,2010714,'" . AddSlashes(pg_result($resaco, $conresaco, 'si111_tiporegistro')) . "','$this->si111_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si111_codunidadesub"]) || $this->si111_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010340,2010715,'" . AddSlashes(pg_result($resaco, $conresaco, 'si111_codunidadesub')) . "','$this->si111_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si111_nroempenho"]) || $this->si111_nroempenho != "")
          $resac = db_query("insert into db_acount values($acount,2010340,2010716,'" . AddSlashes(pg_result($resaco, $conresaco, 'si111_nroempenho')) . "','$this->si111_nroempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si111_nroanulacao"]) || $this->si111_nroanulacao != "")
          $resac = db_query("insert into db_acount values($acount,2010340,2010717,'" . AddSlashes(pg_result($resaco, $conresaco, 'si111_nroanulacao')) . "','$this->si111_nroanulacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si111_codfontrecursos"]) || $this->si111_codfontrecursos != "")
          $resac = db_query("insert into db_acount values($acount,2010340,2010718,'" . AddSlashes(pg_result($resaco, $conresaco, 'si111_codfontrecursos')) . "','$this->si111_codfontrecursos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si111_vlanulacaofonte"]) || $this->si111_vlanulacaofonte != "")
          $resac = db_query("insert into db_acount values($acount,2010340,2010719,'" . AddSlashes(pg_result($resaco, $conresaco, 'si111_vlanulacaofonte')) . "','$this->si111_vlanulacaofonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si111_mes"]) || $this->si111_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010340,2010720,'" . AddSlashes(pg_result($resaco, $conresaco, 'si111_mes')) . "','$this->si111_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si111_reg10"]) || $this->si111_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010340,2010721,'" . AddSlashes(pg_result($resaco, $conresaco, 'si111_reg10')) . "','$this->si111_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si111_instit"]) || $this->si111_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010340,2011624,'" . AddSlashes(pg_result($resaco, $conresaco, 'si111_instit')) . "','$this->si111_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "anl112017 nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->si111_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "anl112017 nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->si111_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->si111_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si111_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si111_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010713,'$si111_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010340,2010713,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si111_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010340,2010714,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si111_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010340,2010715,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si111_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010340,2010716,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si111_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010340,2010717,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si111_nroanulacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010340,2010718,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si111_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010340,2010719,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si111_vlanulacaofonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010340,2010720,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si111_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010340,2010721,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si111_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010340,2011624,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si111_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from anl112017
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si111_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si111_sequencial = $si111_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "anl112017 nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $si111_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "anl112017 nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $si111_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $si111_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:anl112017";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si111_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from anl112017 ";
    $sql .= "      left  join anl102017  on  anl102017.si110_sequencial = anl112017.si111_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si111_sequencial != null) {
        $sql2 .= " where anl112017.si111_sequencial = $si111_sequencial ";
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
  function sql_query_file($si111_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from anl112017 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si111_sequencial != null) {
        $sql2 .= " where anl112017.si111_sequencial = $si111_sequencial ";
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
