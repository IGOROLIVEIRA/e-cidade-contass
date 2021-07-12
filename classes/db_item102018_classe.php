<?
//MODULO: sicom
//CLASSE DA ENTIDADE item102018
class cl_item102018
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
  var $si43_sequencial = 0;
  var $si43_tiporegistro = 0;
  var $si43_coditem = 0;
  var $si43_dscItem = null;
  var $si43_unidademedida = null;
  var $si43_tipocadastro = 0;
  var $si43_justificativaalteracao = null;
  var $si43_mes = 0;
  var $si43_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si43_sequencial = int8 = sequencial 
                 si43_tiporegistro = int8 = Tipo do registro 
                 si43_coditem = int8 = Código do Item 
                 si43_dscItem = varchar(250) = Descrição do Item 
                 si43_unidademedida = varchar(50) = Descrição da unidade de medida 
                 si43_tipocadastro = int8 = Tipo de  Cadastro 
                 si43_justificativaalteracao = varchar(100) = Justificativa  para a  alteração 
                 si43_mes = int8 = Mês 
                 si43_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_item102018()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("item102018");
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
      $this->si43_sequencial = ($this->si43_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si43_sequencial"] : $this->si43_sequencial);
      $this->si43_tiporegistro = ($this->si43_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si43_tiporegistro"] : $this->si43_tiporegistro);
      $this->si43_coditem = ($this->si43_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si43_coditem"] : $this->si43_coditem);
      $this->si43_dscItem = ($this->si43_dscItem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si43_dscItem"] : $this->si43_dscItem);
      $this->si43_unidademedida = ($this->si43_unidademedida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si43_unidademedida"] : $this->si43_unidademedida);
      $this->si43_tipocadastro = ($this->si43_tipocadastro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si43_tipocadastro"] : $this->si43_tipocadastro);
      $this->si43_justificativaalteracao = ($this->si43_justificativaalteracao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si43_justificativaalteracao"] : $this->si43_justificativaalteracao);
      $this->si43_mes = ($this->si43_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si43_mes"] : $this->si43_mes);
      $this->si43_instit = ($this->si43_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si43_instit"] : $this->si43_instit);
    } else {
      $this->si43_sequencial = ($this->si43_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si43_sequencial"] : $this->si43_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si43_sequencial)
  {
    $this->atualizacampos();
    if ($this->si43_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si43_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si43_coditem == null) {
      $this->si43_coditem = "0";
    }
    if ($this->si43_tipocadastro == null) {
      $this->si43_tipocadastro = "0";
    }
    if ($this->si43_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si43_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si43_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si43_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si43_sequencial == "" || $si43_sequencial == null) {
      $result = db_query("select nextval('item102018_si43_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: item102018_si43_sequencial_seq do campo: si43_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si43_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from item102018_si43_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si43_sequencial)) {
        $this->erro_sql = " Campo si43_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si43_sequencial = $si43_sequencial;
      }
    }
    if (($this->si43_sequencial == null) || ($this->si43_sequencial == "")) {
      $this->erro_sql = " Campo si43_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into item102018(
                                       si43_sequencial 
                                      ,si43_tiporegistro 
                                      ,si43_coditem 
                                      ,si43_dscItem 
                                      ,si43_unidademedida 
                                      ,si43_tipocadastro 
                                      ,si43_justificativaalteracao 
                                      ,si43_mes 
                                      ,si43_instit 
                       )
                values (
                                $this->si43_sequencial 
                               ,$this->si43_tiporegistro 
                               ,$this->si43_coditem 
                               ,'$this->si43_dscItem' 
                               ,'$this->si43_unidademedida' 
                               ,$this->si43_tipocadastro 
                               ,'$this->si43_justificativaalteracao' 
                               ,$this->si43_mes 
                               ,$this->si43_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "item102018 ($this->si43_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "item102018 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "item102018 ($this->si43_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si43_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si43_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009822,'$this->si43_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010272,2009822,'','" . AddSlashes(pg_result($resaco, 0, 'si43_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010272,2009823,'','" . AddSlashes(pg_result($resaco, 0, 'si43_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010272,2009825,'','" . AddSlashes(pg_result($resaco, 0, 'si43_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010272,2009826,'','" . AddSlashes(pg_result($resaco, 0, 'si43_dscItem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010272,2009827,'','" . AddSlashes(pg_result($resaco, 0, 'si43_unidademedida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010272,2011308,'','" . AddSlashes(pg_result($resaco, 0, 'si43_tipocadastro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010272,2011309,'','" . AddSlashes(pg_result($resaco, 0, 'si43_justificativaalteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010272,2009828,'','" . AddSlashes(pg_result($resaco, 0, 'si43_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010272,2011557,'','" . AddSlashes(pg_result($resaco, 0, 'si43_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si43_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update item102018 set ";
    $virgula = "";
    if (trim($this->si43_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si43_sequencial"])) {
      if (trim($this->si43_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si43_sequencial"])) {
        $this->si43_sequencial = "0";
      }
      $sql .= $virgula . " si43_sequencial = $this->si43_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si43_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si43_tiporegistro"])) {
      $sql .= $virgula . " si43_tiporegistro = $this->si43_tiporegistro ";
      $virgula = ",";
      if (trim($this->si43_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si43_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si43_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si43_coditem"])) {
      if (trim($this->si43_coditem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si43_coditem"])) {
        $this->si43_coditem = "0";
      }
      $sql .= $virgula . " si43_coditem = $this->si43_coditem ";
      $virgula = ",";
    }
    if (trim($this->si43_dscItem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si43_dscItem"])) {
      $sql .= $virgula . " si43_dscItem = '$this->si43_dscItem' ";
      $virgula = ",";
    }
    if (trim($this->si43_unidademedida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si43_unidademedida"])) {
      $sql .= $virgula . " si43_unidademedida = '$this->si43_unidademedida' ";
      $virgula = ",";
    }
    if (trim($this->si43_tipocadastro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si43_tipocadastro"])) {
      if (trim($this->si43_tipocadastro) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si43_tipocadastro"])) {
        $this->si43_tipocadastro = "0";
      }
      $sql .= $virgula . " si43_tipocadastro = $this->si43_tipocadastro ";
      $virgula = ",";
    }
    if (trim($this->si43_justificativaalteracao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si43_justificativaalteracao"])) {
      $sql .= $virgula . " si43_justificativaalteracao = '$this->si43_justificativaalteracao' ";
      $virgula = ",";
    }
    if (trim($this->si43_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si43_mes"])) {
      $sql .= $virgula . " si43_mes = $this->si43_mes ";
      $virgula = ",";
      if (trim($this->si43_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si43_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si43_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si43_instit"])) {
      $sql .= $virgula . " si43_instit = $this->si43_instit ";
      $virgula = ",";
      if (trim($this->si43_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si43_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si43_sequencial != null) {
      $sql .= " si43_sequencial = $this->si43_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si43_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009822,'$this->si43_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si43_sequencial"]) || $this->si43_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010272,2009822,'" . AddSlashes(pg_result($resaco, $conresaco, 'si43_sequencial')) . "','$this->si43_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si43_tiporegistro"]) || $this->si43_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010272,2009823,'" . AddSlashes(pg_result($resaco, $conresaco, 'si43_tiporegistro')) . "','$this->si43_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si43_coditem"]) || $this->si43_coditem != "")
          $resac = db_query("insert into db_acount values($acount,2010272,2009825,'" . AddSlashes(pg_result($resaco, $conresaco, 'si43_coditem')) . "','$this->si43_coditem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si43_dscItem"]) || $this->si43_dscItem != "")
          $resac = db_query("insert into db_acount values($acount,2010272,2009826,'" . AddSlashes(pg_result($resaco, $conresaco, 'si43_dscItem')) . "','$this->si43_dscItem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si43_unidademedida"]) || $this->si43_unidademedida != "")
          $resac = db_query("insert into db_acount values($acount,2010272,2009827,'" . AddSlashes(pg_result($resaco, $conresaco, 'si43_unidademedida')) . "','$this->si43_unidademedida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si43_tipocadastro"]) || $this->si43_tipocadastro != "")
          $resac = db_query("insert into db_acount values($acount,2010272,2011308,'" . AddSlashes(pg_result($resaco, $conresaco, 'si43_tipocadastro')) . "','$this->si43_tipocadastro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si43_justificativaalteracao"]) || $this->si43_justificativaalteracao != "")
          $resac = db_query("insert into db_acount values($acount,2010272,2011309,'" . AddSlashes(pg_result($resaco, $conresaco, 'si43_justificativaalteracao')) . "','$this->si43_justificativaalteracao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si43_mes"]) || $this->si43_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010272,2009828,'" . AddSlashes(pg_result($resaco, $conresaco, 'si43_mes')) . "','$this->si43_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si43_instit"]) || $this->si43_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010272,2011557,'" . AddSlashes(pg_result($resaco, $conresaco, 'si43_instit')) . "','$this->si43_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "item102018 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si43_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "item102018 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si43_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si43_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si43_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si43_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009822,'$si43_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010272,2009822,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si43_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010272,2009823,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si43_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010272,2009825,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si43_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010272,2009826,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si43_dscItem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010272,2009827,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si43_unidademedida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010272,2011308,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si43_tipocadastro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010272,2011309,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si43_justificativaalteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010272,2009828,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si43_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010272,2011557,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si43_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from item102018
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si43_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si43_sequencial = $si43_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "item102018 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si43_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "item102018 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si43_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si43_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:item102018";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si43_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from item102018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si43_sequencial != null) {
        $sql2 .= " where item102018.si43_sequencial = $si43_sequencial ";
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
  function sql_query_file($si43_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from item102018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si43_sequencial != null) {
        $sql2 .= " where item102018.si43_sequencial = $si43_sequencial ";
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
