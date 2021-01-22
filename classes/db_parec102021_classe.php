<?
//MODULO: sicom
//CLASSE DA ENTIDADE parec102021
class cl_parec102021
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
  var $si22_sequencial = 0;
  var $si22_tiporegistro = 0;
  var $si22_codreduzido = 0;
  var $si22_codorgao = null;
  var $si22_ededucaodereceita = 0;
  var $si22_identificadordeducao = 0;
  var $si22_naturezareceita = 0;
  var $si22_tipoatualizacao = 0;
  var $si22_vlacrescidoreduzido = 0;
  var $si22_mes = 0;
  var $si22_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si22_sequencial = int8 = sequencial 
                 si22_tiporegistro = int8 = Tipo do  registro 
                 si22_codreduzido = int8 = Código  Identificador 
                 si22_codorgao = varchar(2) = Código do órgão 
                 si22_ededucaodereceita = int8 = Identifica 
                 si22_identificadordeducao = int8 = Identificador da  receita 
                 si22_naturezareceita = int8 = Natureza da receita 
                 si22_tipoatualizacao = int8 = Identifica o tipo 
                 si22_vlacrescidoreduzido = float8 = Valor acrescido 
                 si22_mes = int8 = Mês 
                 si22_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_parec102021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("parec102021");
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
      $this->si22_sequencial = ($this->si22_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si22_sequencial"] : $this->si22_sequencial);
      $this->si22_tiporegistro = ($this->si22_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si22_tiporegistro"] : $this->si22_tiporegistro);
      $this->si22_codreduzido = ($this->si22_codreduzido == "" ? @$GLOBALS["HTTP_POST_VARS"]["si22_codreduzido"] : $this->si22_codreduzido);
      $this->si22_codorgao = ($this->si22_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si22_codorgao"] : $this->si22_codorgao);
      $this->si22_ededucaodereceita = ($this->si22_ededucaodereceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si22_ededucaodereceita"] : $this->si22_ededucaodereceita);
      $this->si22_identificadordeducao = ($this->si22_identificadordeducao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si22_identificadordeducao"] : $this->si22_identificadordeducao);
      $this->si22_naturezareceita = ($this->si22_naturezareceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si22_naturezareceita"] : $this->si22_naturezareceita);
      $this->si22_tipoatualizacao = ($this->si22_tipoatualizacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si22_tipoatualizacao"] : $this->si22_tipoatualizacao);
      $this->si22_vlacrescidoreduzido = ($this->si22_vlacrescidoreduzido == "" ? @$GLOBALS["HTTP_POST_VARS"]["si22_vlacrescidoreduzido"] : $this->si22_vlacrescidoreduzido);
      $this->si22_mes = ($this->si22_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si22_mes"] : $this->si22_mes);
      $this->si22_instit = ($this->si22_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si22_instit"] : $this->si22_instit);
    } else {
      $this->si22_sequencial = ($this->si22_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si22_sequencial"] : $this->si22_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si22_sequencial)
  {
    $this->atualizacampos();
    if ($this->si22_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si22_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si22_codreduzido == null) {
      $this->si22_codreduzido = "0";
    }
    if ($this->si22_ededucaodereceita == null) {
      $this->si22_ededucaodereceita = "0";
    }
    if ($this->si22_identificadordeducao == null) {
      $this->si22_identificadordeducao = "0";
    }
    if ($this->si22_naturezareceita == null) {
      $this->si22_naturezareceita = "0";
    }
    if ($this->si22_tipoatualizacao == null) {
      $this->si22_tipoatualizacao = "0";
    }
    if ($this->si22_vlacrescidoreduzido == null) {
      $this->si22_vlacrescidoreduzido = "0";
    }
    if ($this->si22_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si22_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si22_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si22_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si22_sequencial == "" || $si22_sequencial == null) {
      $result = db_query("select nextval('parec102021_si22_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: parec102021_si22_sequencial_seq do campo: si22_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si22_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from parec102021_si22_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si22_sequencial)) {
        $this->erro_sql = " Campo si22_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si22_sequencial = $si22_sequencial;
      }
    }
    if (($this->si22_sequencial == null) || ($this->si22_sequencial == "")) {
      $this->erro_sql = " Campo si22_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into parec102021(
                                       si22_sequencial 
                                      ,si22_tiporegistro 
                                      ,si22_codreduzido 
                                      ,si22_codorgao 
                                      ,si22_ededucaodereceita 
                                      ,si22_identificadordeducao 
                                      ,si22_naturezareceita 
                                      ,si22_tipoatualizacao 
                                      ,si22_vlacrescidoreduzido 
                                      ,si22_mes 
                                      ,si22_instit 
                       )
                values (
                                $this->si22_sequencial 
                               ,$this->si22_tiporegistro 
                               ,$this->si22_codreduzido 
                               ,'$this->si22_codorgao' 
                               ,$this->si22_ededucaodereceita 
                               ,$this->si22_identificadordeducao 
                               ,$this->si22_naturezareceita 
                               ,$this->si22_tipoatualizacao  
                               ,$this->si22_vlacrescidoreduzido 
                               ,$this->si22_mes 
                               ,$this->si22_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "parec102021 ($this->si22_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "parec102021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "parec102021 ($this->si22_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si22_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si22_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009654,'$this->si22_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010250,2009654,'','" . AddSlashes(pg_result($resaco, 0, 'si22_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010250,2009655,'','" . AddSlashes(pg_result($resaco, 0, 'si22_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010250,2009656,'','" . AddSlashes(pg_result($resaco, 0, 'si22_codreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010250,2009657,'','" . AddSlashes(pg_result($resaco, 0, 'si22_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010250,2009658,'','" . AddSlashes(pg_result($resaco, 0, 'si22_ededucaodereceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010250,2009659,'','" . AddSlashes(pg_result($resaco, 0, 'si22_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010250,2009660,'','" . AddSlashes(pg_result($resaco, 0, 'si22_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010250,2009661,'','" . AddSlashes(pg_result($resaco, 0, 'si22_tipoatualizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010250,2009663,'','" . AddSlashes(pg_result($resaco, 0, 'si22_vlacrescidoreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010250,2009741,'','" . AddSlashes(pg_result($resaco, 0, 'si22_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010250,2011539,'','" . AddSlashes(pg_result($resaco, 0, 'si22_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si22_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update parec102021 set ";
    $virgula = "";
    if (trim($this->si22_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si22_sequencial"])) {
      if (trim($this->si22_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si22_sequencial"])) {
        $this->si22_sequencial = "0";
      }
      $sql .= $virgula . " si22_sequencial = $this->si22_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si22_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si22_tiporegistro"])) {
      $sql .= $virgula . " si22_tiporegistro = $this->si22_tiporegistro ";
      $virgula = ",";
      if (trim($this->si22_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si22_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si22_codreduzido) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si22_codreduzido"])) {
      if (trim($this->si22_codreduzido) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si22_codreduzido"])) {
        $this->si22_codreduzido = "0";
      }
      $sql .= $virgula . " si22_codreduzido = $this->si22_codreduzido ";
      $virgula = ",";
    }
    if (trim($this->si22_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si22_codorgao"])) {
      $sql .= $virgula . " si22_codorgao = '$this->si22_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si22_ededucaodereceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si22_ededucaodereceita"])) {
      if (trim($this->si22_ededucaodereceita) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si22_ededucaodereceita"])) {
        $this->si22_ededucaodereceita = "0";
      }
      $sql .= $virgula . " si22_ededucaodereceita = $this->si22_ededucaodereceita ";
      $virgula = ",";
    }
    if (trim($this->si22_identificadordeducao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si22_identificadordeducao"])) {
      if (trim($this->si22_identificadordeducao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si22_identificadordeducao"])) {
        $this->si22_identificadordeducao = "0";
      }
      $sql .= $virgula . " si22_identificadordeducao = $this->si22_identificadordeducao ";
      $virgula = ",";
    }
    if (trim($this->si22_naturezareceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si22_naturezareceita"])) {
      if (trim($this->si22_naturezareceita) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si22_naturezareceita"])) {
        $this->si22_naturezareceita = "0";
      }
      $sql .= $virgula . " si22_naturezareceita = $this->si22_naturezareceita ";
      $virgula = ",";
    }
    if (trim($this->si22_tipoatualizacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si22_tipoatualizacao"])) {
      if (trim($this->si22_tipoatualizacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si22_tipoatualizacao"])) {
        $this->si22_tipoatualizacao = "0";
      }
      $sql .= $virgula . " si22_tipoatualizacao = $this->si22_tipoatualizacao ";
      $virgula = ",";
    }
    if (trim($this->si22_vlacrescidoreduzido) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si22_vlacrescidoreduzido"])) {
      if (trim($this->si22_vlacrescidoreduzido) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si22_vlacrescidoreduzido"])) {
        $this->si22_vlacrescidoreduzido = "0";
      }
      $sql .= $virgula . " si22_vlacrescidoreduzido = $this->si22_vlacrescidoreduzido ";
      $virgula = ",";
    }
    if (trim($this->si22_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si22_mes"])) {
      $sql .= $virgula . " si22_mes = $this->si22_mes ";
      $virgula = ",";
      if (trim($this->si22_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si22_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si22_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si22_instit"])) {
      $sql .= $virgula . " si22_instit = $this->si22_instit ";
      $virgula = ",";
      if (trim($this->si22_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si22_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si22_sequencial != null) {
      $sql .= " si22_sequencial = $this->si22_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si22_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009654,'$this->si22_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si22_sequencial"]) || $this->si22_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010250,2009654,'" . AddSlashes(pg_result($resaco, $conresaco, 'si22_sequencial')) . "','$this->si22_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si22_tiporegistro"]) || $this->si22_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010250,2009655,'" . AddSlashes(pg_result($resaco, $conresaco, 'si22_tiporegistro')) . "','$this->si22_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si22_codreduzido"]) || $this->si22_codreduzido != "")
          $resac = db_query("insert into db_acount values($acount,2010250,2009656,'" . AddSlashes(pg_result($resaco, $conresaco, 'si22_codreduzido')) . "','$this->si22_codreduzido'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si22_codorgao"]) || $this->si22_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010250,2009657,'" . AddSlashes(pg_result($resaco, $conresaco, 'si22_codorgao')) . "','$this->si22_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si22_ededucaodereceita"]) || $this->si22_ededucaodereceita != "")
          $resac = db_query("insert into db_acount values($acount,2010250,2009658,'" . AddSlashes(pg_result($resaco, $conresaco, 'si22_ededucaodereceita')) . "','$this->si22_ededucaodereceita'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si22_identificadordeducao"]) || $this->si22_identificadordeducao != "")
          $resac = db_query("insert into db_acount values($acount,2010250,2009659,'" . AddSlashes(pg_result($resaco, $conresaco, 'si22_identificadordeducao')) . "','$this->si22_identificadordeducao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si22_naturezareceita"]) || $this->si22_naturezareceita != "")
          $resac = db_query("insert into db_acount values($acount,2010250,2009660,'" . AddSlashes(pg_result($resaco, $conresaco, 'si22_naturezareceita')) . "','$this->si22_naturezareceita'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si22_tipoatualizacao"]) || $this->si22_tipoatualizacao != "")
          $resac = db_query("insert into db_acount values($acount,2010250,2009661,'" . AddSlashes(pg_result($resaco, $conresaco, 'si22_tipoatualizacao')) . "','$this->si22_tipoatualizacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si22_vlacrescidoreduzido"]) || $this->si22_vlacrescidoreduzido != "")
          $resac = db_query("insert into db_acount values($acount,2010250,2009663,'" . AddSlashes(pg_result($resaco, $conresaco, 'si22_vlacrescidoreduzido')) . "','$this->si22_vlacrescidoreduzido'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si22_mes"]) || $this->si22_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010250,2009741,'" . AddSlashes(pg_result($resaco, $conresaco, 'si22_mes')) . "','$this->si22_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si22_instit"]) || $this->si22_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010250,2011539,'" . AddSlashes(pg_result($resaco, $conresaco, 'si22_instit')) . "','$this->si22_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "parec102021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si22_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "parec102021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si22_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si22_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si22_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si22_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009654,'$si22_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010250,2009654,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si22_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010250,2009655,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si22_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010250,2009656,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si22_codreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010250,2009657,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si22_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010250,2009658,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si22_ededucaodereceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010250,2009659,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si22_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010250,2009660,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si22_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010250,2009661,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si22_tipoatualizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010250,2009663,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si22_vlacrescidoreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010250,2009741,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si22_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010250,2011539,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si22_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from parec102021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si22_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si22_sequencial = $si22_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "parec102021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si22_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "parec102021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si22_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si22_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:parec102021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si22_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from parec102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si22_sequencial != null) {
        $sql2 .= " where parec102021.si22_sequencial = $si22_sequencial ";
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
  function sql_query_file($si22_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from parec102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si22_sequencial != null) {
        $sql2 .= " where parec102021.si22_sequencial = $si22_sequencial ";
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
