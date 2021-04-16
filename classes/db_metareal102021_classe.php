<?
//MODULO: sicom
//CLASSE DA ENTIDADE metareal102021
class cl_metareal102021
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
  var $si171_sequencial = 0;
  var $si171_tiporegistro = 0;
  var $si171_codorgao = 0;
  var $si171_codunidadesub = null;
  var $si171_codfuncao = 0;
  var $si171_codsubfuncao = 0;
  var $si171_codprograma = null;
  var $si171_idacao = null;
  var $si171_idsubacao = null;
  var $si171_metarealizada = 0;
  var $si171_justificativa = null;
  var $si171_mes = 0;
  var $si171_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si171_sequencial = int8 = sequencial
                 si171_tiporegistro = int8 = Tipo do registro
                 si171_codorgao = varchar(2) = código do órgão
                 si171_codunidadesub = varchar(8) = código da unidade ou subunidade orçamentária
                 si171_codfuncao = int8 = grupo da despesa
                 si171_codsubfuncao = float8 = valor referente a dotação mensal da despesa
                 si171_codprograma = varchar(4) = código do programa
                 si171_idacao = varchar(4) = código que identifica a ação
                 si171_idsubacao = varchar(4) = código que identifica a subação
                 si171_metarealizada = float8 = quantidade realizada da meta física no exercício
                 si171_justificativa = varchar(1000) = justificativa
                 si171_mes = int8 = Mês
                 si171_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function cl_metareal102021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("metareal102021");
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
      $this->si171_sequencial = ($this->si171_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si171_sequencial"] : $this->si171_sequencial);
      $this->si171_tiporegistro = ($this->si171_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si171_tiporegistro"] : $this->si171_tiporegistro);
      $this->si171_codorgao = ($this->si171_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si171_codorgao"] : $this->si171_codorgao);
      $this->si171_codunidadesub = ($this->si171_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si171_codunidadesub"] : $this->si171_codunidadesub);
      $this->si171_codfuncao = ($this->si171_codfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si171_codfuncao"] : $this->si171_codfuncao);
      $this->si171_codsubfuncao = ($this->si171_codsubfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si171_codsubfuncao"] : $this->si171_codsubfuncao);
      $this->si171_codprograma = ($this->si171_codprograma == "" ? @$GLOBALS["HTTP_POST_VARS"]["si171_codprograma"] : $this->si171_codprograma);
      $this->si171_idacao = ($this->si171_idacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si171_idacao"] : $this->si171_idacao);
      $this->si171_idsubacao = ($this->si171_idsubacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si171_idsubacao"] : $this->si171_idsubacao);
      $this->si171_metarealizada = ($this->si171_metarealizada == "" ? @$GLOBALS["HTTP_POST_VARS"]["si171_metarealizada"] : $this->si171_metarealizada);
      $this->si171_justificativa = ($this->si171_justificativa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si171_justificativa"] : $this->si171_justificativa);
      $this->si171_mes = ($this->si171_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si171_mes"] : $this->si171_mes);
      $this->si171_instit = ($this->si171_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si171_instit"] : $this->si171_instit);
    } else {
      $this->si171_sequencial = ($this->si171_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si171_sequencial"] : $this->si171_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si171_sequencial)
  {
    $this->atualizacampos();
    if ($this->si171_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si171_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si171_codorgao == null) {
      $this->si171_codorgao = "0";
    }
    if ($this->si171_codfuncao == null) {
      $this->si171_codfuncao = "0";
    }
    if ($this->si171_codsubfuncao == null) {
      $this->si171_codsubfuncao = "0";
    }
    if ($this->si171_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si171_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si171_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si171_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si171_sequencial == "" || $si171_sequencial == null) {
      $result = db_query("select nextval('metareal102021_si171_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: metareal102021_si171_sequencial_seq do campo: si171_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si171_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from metareal102021_si171_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si171_sequencial)) {
        $this->erro_sql = " Campo si171_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si171_sequencial = $si171_sequencial;
      }
    }
    if (($this->si171_sequencial == null) || ($this->si171_sequencial == "")) {
      $this->erro_sql = " Campo si171_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into metareal102021(
                                       si171_sequencial 
                                      ,si171_tiporegistro 
                                      ,si171_codorgao
                                      ,si171_codunidadesub
                                      ,si171_codfuncao
                                      ,si171_codsubfuncao
                                      ,si171_codprograma
                                      ,si171_idacao
                                      ,si171_idsubacao
                                      ,si171_metarealizada
                                      ,si171_justificativa
                                      ,si171_mes 
                                      ,si171_instit 
                       )
                values (
                                $this->si171_sequencial 
                               ,$this->si171_tiporegistro 
                               ,$this->si171_codorgao
                               ,$this->si171_codunidadesub
                               ,$this->si171_codfuncao
                               ,$this->si171_codsubfuncao
                               ,$this->si171_codprograma
                               ,$this->si171_idacao
                               ,'$this->si171_idsubacao'
                               ,$this->si171_metarealizada
                               ,'$this->si171_justificativa'
                               ,$this->si171_mes 
                               ,$this->si171_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "metareal102021 ($this->si171_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "metareal102021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "metareal102021 ($this->si171_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si171_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si171_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2011199,'$this->si171_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010386,2011199,'','" . AddSlashes(pg_result($resaco, 0, 'si171_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010386,2011375,'','" . AddSlashes(pg_result($resaco, 0, 'si171_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010386,2011200,'','" . AddSlashes(pg_result($resaco, 0, 'si171_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010386,2011201,'','" . AddSlashes(pg_result($resaco, 0, 'si171_codfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010386,2011202,'','" . AddSlashes(pg_result($resaco, 0, 'si171_idacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010386,2011207,'','" . AddSlashes(pg_result($resaco, 0, 'si171_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010386,2011670,'','" . AddSlashes(pg_result($resaco, 0, 'si171_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si171_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update metareal102021 set ";
    $virgula = "";
    if (trim($this->si171_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si171_sequencial"])) {
      if (trim($this->si171_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si171_sequencial"])) {
        $this->si171_sequencial = "0";
      }
      $sql .= $virgula . " si171_sequencial = $this->si171_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si171_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si171_tiporegistro"])) {
      $sql .= $virgula . " si171_tiporegistro = $this->si171_tiporegistro ";
      $virgula = ",";
      if (trim($this->si171_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si171_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si171_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si171_codorgao"])) {
      if (trim($this->si171_codorgao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si171_codorgao"])) {
        $this->si171_codorgao = "0";
      }
      $sql .= $virgula . " si171_codorgao = $this->si171_codorgao ";
      $virgula = ",";
    }
    if (trim($this->si171_codfuncao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si171_codfuncao"])) {
      if (trim($this->si171_codfuncao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si171_codfuncao"])) {
        $this->si171_codfuncao = "0";
      }
      $sql .= $virgula . " si171_codfuncao = $this->si171_codfuncao ";
      $virgula = ",";
    }
    if (trim($this->si171_idacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si171_idacao"])) {
      if (trim($this->si171_idacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si171_idacao"])) {
        $this->si171_idacao = "0";
      }
      $sql .= $virgula . " si171_idacao = $this->si171_idacao ";
      $virgula = ",";
    }
    if (trim($this->si171_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si171_mes"])) {
      $sql .= $virgula . " si171_mes = $this->si171_mes ";
      $virgula = ",";
      if (trim($this->si171_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si171_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si171_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si171_instit"])) {
      $sql .= $virgula . " si171_instit = $this->si171_instit ";
      $virgula = ",";
      if (trim($this->si171_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si171_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si171_sequencial != null) {
      $sql .= " si171_sequencial = $this->si171_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si171_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011199,'$this->si171_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si171_sequencial"]) || $this->si171_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010386,2011199,'" . AddSlashes(pg_result($resaco, $conresaco, 'si171_sequencial')) . "','$this->si171_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si171_tiporegistro"]) || $this->si171_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010386,2011375,'" . AddSlashes(pg_result($resaco, $conresaco, 'si171_tiporegistro')) . "','$this->si171_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si171_codorgao"]) || $this->si171_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010386,2011200,'" . AddSlashes(pg_result($resaco, $conresaco, 'si171_codorgao')) . "','$this->si171_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si171_codfuncao"]) || $this->si171_codfuncao != "")
          $resac = db_query("insert into db_acount values($acount,2010386,2011201,'" . AddSlashes(pg_result($resaco, $conresaco, 'si171_codfuncao')) . "','$this->si171_codfuncao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si171_idacao"]) || $this->si171_idacao != "")
          $resac = db_query("insert into db_acount values($acount,2010386,2011202,'" . AddSlashes(pg_result($resaco, $conresaco, 'si171_idacao')) . "','$this->si171_idacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si171_vlliqincentcontrib"]) || $this->si171_vlliqincentcontrib != "")
          $resac = db_query("insert into db_acount values($acount,2010386,2011203,'" . AddSlashes(pg_result($resaco, $conresaco, 'si171_vlliqincentcontrib')) . "','$this->si171_vlliqincentcontrib'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si171_vlliqincentinstfinanc"]) || $this->si171_vlliqincentinstfinanc != "")
          $resac = db_query("insert into db_acount values($acount,2010386,2011204,'" . AddSlashes(pg_result($resaco, $conresaco, 'si171_vlliqincentinstfinanc')) . "','$this->si171_vlliqincentinstfinanc'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si171_vlirpnpincentcontrib"]) || $this->si171_vlirpnpincentcontrib != "")
          $resac = db_query("insert into db_acount values($acount,2010386,2011205,'" . AddSlashes(pg_result($resaco, $conresaco, 'si171_vlirpnpincentcontrib')) . "','$this->si171_vlirpnpincentcontrib'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si171_vlirpnpincentinstfinanc"]) || $this->si171_vlirpnpincentinstfinanc != "")
          $resac = db_query("insert into db_acount values($acount,2010386,2011206,'" . AddSlashes(pg_result($resaco, $conresaco, 'si171_vlirpnpincentinstfinanc')) . "','$this->si171_vlirpnpincentinstfinanc'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si171_vlcompromissado"]) || $this->si171_vlcompromissado != "")
          $resac = db_query("insert into db_acount values($acount,2010386,2011376,'" . AddSlashes(pg_result($resaco, $conresaco, 'si171_vlcompromissado')) . "','$this->si171_vlcompromissado'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si171_vlrecursosnaoaplicados"]) || $this->si171_vlrecursosnaoaplicados != "")
          $resac = db_query("insert into db_acount values($acount,2010386,2011377,'" . AddSlashes(pg_result($resaco, $conresaco, 'si171_vlrecursosnaoaplicados')) . "','$this->si171_vlrecursosnaoaplicados'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si171_mes"]) || $this->si171_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010386,2011207,'" . AddSlashes(pg_result($resaco, $conresaco, 'si171_mes')) . "','$this->si171_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si171_instit"]) || $this->si171_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010386,2011670,'" . AddSlashes(pg_result($resaco, $conresaco, 'si171_instit')) . "','$this->si171_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "metareal102021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si171_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "metareal102021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si171_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si171_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si171_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si171_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011199,'$si171_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010386,2011199,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si171_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010386,2011375,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si171_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010386,2011200,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si171_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010386,2011201,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si171_codfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010386,2011202,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si171_idacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010386,2011203,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si171_vlliqincentcontrib')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010386,2011204,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si171_vlliqincentinstfinanc')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010386,2011205,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si171_vlirpnpincentcontrib')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010386,2011206,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si171_vlirpnpincentinstfinanc')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010386,2011376,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si171_vlcompromissado')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010386,2011377,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si171_vlrecursosnaoaplicados')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010386,2011207,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si171_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010386,2011670,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si171_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from metareal102021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si171_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si171_sequencial = $si171_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "metareal102021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si171_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "metareal102021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si171_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si171_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:metareal102021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si171_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from metareal102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si171_sequencial != null) {
        $sql2 .= " where metareal102021.si171_sequencial = $si171_sequencial ";
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
  function sql_query_file($si171_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from metareal102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si171_sequencial != null) {
        $sql2 .= " where metareal102021.si171_sequencial = $si171_sequencial ";
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
