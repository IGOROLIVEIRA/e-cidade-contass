<?
//MODULO: sicom
//CLASSE DA ENTIDADE ntf112021
class cl_ntf112021
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
  var $si144_sequencial = 0;
  var $si144_tiporegistro = 0;
  var $si144_codnotafiscal = 0;
  var $si144_coditem = 0;
  var $si144_quantidadeitem = 0;
  var $si144_valorunitarioitem = 0;
  var $si144_mes = 0;
  var $si144_reg10 = 0;
  var $si144_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si144_sequencial = int8 = sequencial 
                 si144_tiporegistro = int8 = Tipo do  registro 
                 si144_codnotafiscal = int8 = Código Identificador da Nota Fiscal 
                 si144_coditem = int8 = Código do item 
                 si144_quantidadeitem = float8 = Quantidade do  item 
                 si144_valorunitarioitem = float8 = Valor unitário do  item 
                 si144_mes = int8 = Mês 
                 si144_reg10 = int8 = reg10 
                 si144_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_ntf112021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ntf112021");
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
      $this->si144_sequencial = ($this->si144_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si144_sequencial"] : $this->si144_sequencial);
      $this->si144_tiporegistro = ($this->si144_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si144_tiporegistro"] : $this->si144_tiporegistro);
      $this->si144_codnotafiscal = ($this->si144_codnotafiscal == "" ? @$GLOBALS["HTTP_POST_VARS"]["si144_codnotafiscal"] : $this->si144_codnotafiscal);
      $this->si144_coditem = ($this->si144_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si144_coditem"] : $this->si144_coditem);
      $this->si144_quantidadeitem = ($this->si144_quantidadeitem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si144_quantidadeitem"] : $this->si144_quantidadeitem);
      $this->si144_valorunitarioitem = ($this->si144_valorunitarioitem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si144_valorunitarioitem"] : $this->si144_valorunitarioitem);
      $this->si144_mes = ($this->si144_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si144_mes"] : $this->si144_mes);
      $this->si144_reg10 = ($this->si144_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si144_reg10"] : $this->si144_reg10);
      $this->si144_instit = ($this->si144_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si144_instit"] : $this->si144_instit);
    } else {
      $this->si144_sequencial = ($this->si144_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si144_sequencial"] : $this->si144_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si144_sequencial)
  {
    $this->atualizacampos();
    if ($this->si144_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si144_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si144_codnotafiscal == null) {
      $this->si144_codnotafiscal = "0";
    }
    if ($this->si144_coditem == null) {
      $this->si144_coditem = "0";
    }
    if ($this->si144_quantidadeitem == null) {
      $this->si144_quantidadeitem = "0";
    }
    if ($this->si144_valorunitarioitem == null) {
      $this->si144_valorunitarioitem = "0";
    }
    if ($this->si144_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si144_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si144_reg10 == null) {
      $this->si144_reg10 = "0";
    }
    if ($this->si144_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si144_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si144_sequencial == "" || $si144_sequencial == null) {
      $result = db_query("select nextval('ntf112021_si144_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ntf112021_si144_sequencial_seq do campo: si144_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si144_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from ntf112021_si144_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si144_sequencial)) {
        $this->erro_sql = " Campo si144_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si144_sequencial = $si144_sequencial;
      }
    }
    if (($this->si144_sequencial == null) || ($this->si144_sequencial == "")) {
      $this->erro_sql = " Campo si144_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into ntf112021(
                                       si144_sequencial 
                                      ,si144_tiporegistro 
                                      ,si144_codnotafiscal 
                                      ,si144_coditem 
                                      ,si144_quantidadeitem 
                                      ,si144_valorunitarioitem 
                                      ,si144_mes 
                                      ,si144_reg10 
                                      ,si144_instit 
                       )
                values (
                                $this->si144_sequencial 
                               ,$this->si144_tiporegistro 
                               ,$this->si144_codnotafiscal 
                               ,$this->si144_coditem 
                               ,$this->si144_quantidadeitem 
                               ,$this->si144_valorunitarioitem 
                               ,$this->si144_mes 
                               ,$this->si144_reg10 
                               ,$this->si144_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ntf112021 ($this->si144_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "ntf112021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "ntf112021 ($this->si144_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si144_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si144_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2011071,'$this->si144_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010373,2011071,'','" . AddSlashes(pg_result($resaco, 0, 'si144_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010373,2011072,'','" . AddSlashes(pg_result($resaco, 0, 'si144_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010373,2011073,'','" . AddSlashes(pg_result($resaco, 0, 'si144_codnotafiscal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010373,2011074,'','" . AddSlashes(pg_result($resaco, 0, 'si144_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010373,2011075,'','" . AddSlashes(pg_result($resaco, 0, 'si144_quantidadeitem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010373,2011076,'','" . AddSlashes(pg_result($resaco, 0, 'si144_valorunitarioitem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010373,2011077,'','" . AddSlashes(pg_result($resaco, 0, 'si144_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010373,2011078,'','" . AddSlashes(pg_result($resaco, 0, 'si144_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010373,2011657,'','" . AddSlashes(pg_result($resaco, 0, 'si144_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si144_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ntf112021 set ";
    $virgula = "";
    if (trim($this->si144_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si144_sequencial"])) {
      if (trim($this->si144_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si144_sequencial"])) {
        $this->si144_sequencial = "0";
      }
      $sql .= $virgula . " si144_sequencial = $this->si144_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si144_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si144_tiporegistro"])) {
      $sql .= $virgula . " si144_tiporegistro = $this->si144_tiporegistro ";
      $virgula = ",";
      if (trim($this->si144_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si144_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si144_codnotafiscal) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si144_codnotafiscal"])) {
      if (trim($this->si144_codnotafiscal) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si144_codnotafiscal"])) {
        $this->si144_codnotafiscal = "0";
      }
      $sql .= $virgula . " si144_codnotafiscal = $this->si144_codnotafiscal ";
      $virgula = ",";
    }
    if (trim($this->si144_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si144_coditem"])) {
      if (trim($this->si144_coditem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si144_coditem"])) {
        $this->si144_coditem = "0";
      }
      $sql .= $virgula . " si144_coditem = $this->si144_coditem ";
      $virgula = ",";
    }
    if (trim($this->si144_quantidadeitem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si144_quantidadeitem"])) {
      if (trim($this->si144_quantidadeitem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si144_quantidadeitem"])) {
        $this->si144_quantidadeitem = "0";
      }
      $sql .= $virgula . " si144_quantidadeitem = $this->si144_quantidadeitem ";
      $virgula = ",";
    }
    if (trim($this->si144_valorunitarioitem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si144_valorunitarioitem"])) {
      if (trim($this->si144_valorunitarioitem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si144_valorunitarioitem"])) {
        $this->si144_valorunitarioitem = "0";
      }
      $sql .= $virgula . " si144_valorunitarioitem = $this->si144_valorunitarioitem ";
      $virgula = ",";
    }
    if (trim($this->si144_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si144_mes"])) {
      $sql .= $virgula . " si144_mes = $this->si144_mes ";
      $virgula = ",";
      if (trim($this->si144_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si144_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si144_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si144_reg10"])) {
      if (trim($this->si144_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si144_reg10"])) {
        $this->si144_reg10 = "0";
      }
      $sql .= $virgula . " si144_reg10 = $this->si144_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si144_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si144_instit"])) {
      $sql .= $virgula . " si144_instit = $this->si144_instit ";
      $virgula = ",";
      if (trim($this->si144_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si144_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si144_sequencial != null) {
      $sql .= " si144_sequencial = $this->si144_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si144_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011071,'$this->si144_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si144_sequencial"]) || $this->si144_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010373,2011071,'" . AddSlashes(pg_result($resaco, $conresaco, 'si144_sequencial')) . "','$this->si144_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si144_tiporegistro"]) || $this->si144_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010373,2011072,'" . AddSlashes(pg_result($resaco, $conresaco, 'si144_tiporegistro')) . "','$this->si144_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si144_codnotafiscal"]) || $this->si144_codnotafiscal != "")
          $resac = db_query("insert into db_acount values($acount,2010373,2011073,'" . AddSlashes(pg_result($resaco, $conresaco, 'si144_codnotafiscal')) . "','$this->si144_codnotafiscal'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si144_coditem"]) || $this->si144_coditem != "")
          $resac = db_query("insert into db_acount values($acount,2010373,2011074,'" . AddSlashes(pg_result($resaco, $conresaco, 'si144_coditem')) . "','$this->si144_coditem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si144_quantidadeitem"]) || $this->si144_quantidadeitem != "")
          $resac = db_query("insert into db_acount values($acount,2010373,2011075,'" . AddSlashes(pg_result($resaco, $conresaco, 'si144_quantidadeitem')) . "','$this->si144_quantidadeitem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si144_valorunitarioitem"]) || $this->si144_valorunitarioitem != "")
          $resac = db_query("insert into db_acount values($acount,2010373,2011076,'" . AddSlashes(pg_result($resaco, $conresaco, 'si144_valorunitarioitem')) . "','$this->si144_valorunitarioitem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si144_mes"]) || $this->si144_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010373,2011077,'" . AddSlashes(pg_result($resaco, $conresaco, 'si144_mes')) . "','$this->si144_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si144_reg10"]) || $this->si144_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010373,2011078,'" . AddSlashes(pg_result($resaco, $conresaco, 'si144_reg10')) . "','$this->si144_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si144_instit"]) || $this->si144_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010373,2011657,'" . AddSlashes(pg_result($resaco, $conresaco, 'si144_instit')) . "','$this->si144_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ntf112021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si144_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ntf112021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si144_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si144_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si144_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si144_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011071,'$si144_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010373,2011071,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si144_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010373,2011072,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si144_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010373,2011073,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si144_codnotafiscal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010373,2011074,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si144_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010373,2011075,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si144_quantidadeitem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010373,2011076,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si144_valorunitarioitem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010373,2011077,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si144_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010373,2011078,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si144_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010373,2011657,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si144_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from ntf112021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si144_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si144_sequencial = $si144_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ntf112021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si144_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ntf112021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si144_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si144_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:ntf112021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si144_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ntf112021 ";
    $sql .= "      left  join ntf102020  on  ntf102020.si143_sequencial = ntf112021.si144_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si144_sequencial != null) {
        $sql2 .= " where ntf112021.si144_sequencial = $si144_sequencial ";
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
  function sql_query_file($si144_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ntf112021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si144_sequencial != null) {
        $sql2 .= " where ntf112021.si144_sequencial = $si144_sequencial ";
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
