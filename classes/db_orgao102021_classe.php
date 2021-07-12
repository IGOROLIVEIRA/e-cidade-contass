<?
//MODULO: sicom
//CLASSE DA ENTIDADE orgao102021
class cl_orgao102021
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
  var $si14_sequencial = 0;
  var $si14_tiporegistro = 0;
  var $si14_codorgao = null;
  var $si14_tipoorgao = null;
  var $si14_cnpjorgao = null;
  var $si14_tipodocumentofornsoftware = 0;
  var $si14_nrodocumentofornsoftware = null;
  var $si14_versaosoftware = null;
  var $si14_assessoriacontabil = null;
  var $si14_tipodocumentoassessoria = null;
  var $si14_nrodocumentoassessoria = null;
  var $si14_mes = 0;
  var $si14_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si14_sequencial = int8 = sequencial
                 si14_tiporegistro = int8 = Tipo do  registro
                 si14_codorgao = varchar(2) = cod Orgão
                 si14_tipoorgao = varchar(2) = Tipo do órgão
                 si14_cnpjorgao = varchar(14) = Número do CNPJ
                 si14_tipodocumentofornsoftware = int8 = Tipo de documento do fornecedor
                 si14_nrodocumentofornsoftware = varchar(14) = Número do documento do fornecedor
                 si14_versaosoftware = varchar(50) = Versão do Software
                 si14_assessoriacontabil = int8 = Assessoria Contabil
                 si14_tipodocumentoassessoria = int8 = Tipo Documento
                 si14_nrodocumentoassessoria = varchar(14) = Numero Documento
                 si14_mes = int8 = Mês
                 si14_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function cl_orgao102021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("orgao102021");
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
      $this->si14_sequencial = ($this->si14_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si14_sequencial"] : $this->si14_sequencial);
      $this->si14_tiporegistro = ($this->si14_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si14_tiporegistro"] : $this->si14_tiporegistro);
      $this->si14_codorgao = ($this->si14_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si14_codorgao"] : $this->si14_codorgao);
      $this->si14_tipoorgao = ($this->si14_tipoorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si14_tipoorgao"] : $this->si14_tipoorgao);
      $this->si14_cnpjorgao = ($this->si14_cnpjorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si14_cnpjorgao"] : $this->si14_cnpjorgao);
      $this->si14_tipodocumentofornsoftware = ($this->si14_tipodocumentofornsoftware == "" ? @$GLOBALS["HTTP_POST_VARS"]["si14_tipodocumentofornsoftware"] : $this->si14_tipodocumentofornsoftware);
      $this->si14_nrodocumentofornsoftware = ($this->si14_nrodocumentofornsoftware == "" ? @$GLOBALS["HTTP_POST_VARS"]["si14_nrodocumentofornsoftware"] : $this->si14_nrodocumentofornsoftware);
      $this->si14_versaosoftware = ($this->si14_versaosoftware == "" ? @$GLOBALS["HTTP_POST_VARS"]["si14_versaosoftware"] : $this->si14_versaosoftware);
      $this->si14_assessoriacontabil = ($this->si14_assessoriacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si14_assessoriacontabil"] : $this->si14_assessoriacontabil);
      $this->si14_tipodocumentoassessoria = ($this->si14_tipodocumentoassessoria == "" ? @$GLOBALS["HTTP_POST_VARS"]["si14_tipodocumentoassessoria"] : $this->si14_tipodocumentoassessoria);
      $this->si14_nrodocumentoassessoria = ($this->si14_nrodocumentoassessoria == "" ? @$GLOBALS["HTTP_POST_VARS"]["si14_nrodocumentoassessoria"] : $this->si14_nrodocumentoassessoria);
      $this->si14_mes = ($this->si14_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si14_mes"] : $this->si14_mes);
      $this->si14_instit = ($this->si14_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si14_instit"] : $this->si14_instit);
    } else {
      $this->si14_sequencial = ($this->si14_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si14_sequencial"] : $this->si14_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si14_sequencial)
  {
    $this->atualizacampos();
    if ($this->si14_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si14_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si14_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si14_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si14_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si14_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si14_assessoriacontabil == 1 && empty($this->si14_nrodocumentoassessoria)) {
      $this->erro_sql = " Campo Numero Documento Assessoria Contabil Nao Informado.";
      $this->erro_campo = "si14_assessoriacontabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si14_assessoriacontabil == 1 && empty($this->si14_tipodocumentoassessoria)) {
      $this->erro_sql = " Campo Tipo Documento Assessoria Contabil Nao Informado.";
      $this->erro_campo = "si14_tipodocumentoassessoria";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si14_sequencial == "" || $si14_sequencial == null) {
      $result = db_query("select nextval('orgao102021_si14_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: orgao102021_si14_sequencial_seq do campo: si14_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si14_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from orgao102021_si14_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si14_sequencial)) {
        $this->erro_sql = " Campo si14_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si14_sequencial = $si14_sequencial;
      }
    }
    if (($this->si14_sequencial == null) || ($this->si14_sequencial == "")) {
      $this->erro_sql = " Campo si14_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    $sql = "insert into orgao102021(
                                       si14_sequencial
                                      ,si14_tiporegistro
                                      ,si14_codorgao
                                      ,si14_tipoorgao
                                      ,si14_cnpjorgao
                                      ,si14_tipodocumentofornsoftware
                                      ,si14_nrodocumentofornsoftware
                                      ,si14_versaosoftware
                                      ,si14_mes
                                      ,si14_instit
                                      ,si14_assessoriacontabil
                                      ,si14_tipodocumentoassessoria
                                      ,si14_nrodocumentoassessoria
                       )
                values (
                                $this->si14_sequencial
                               ,$this->si14_tiporegistro
                               ,'$this->si14_codorgao'
                               ,'$this->si14_tipoorgao'
                               ,'$this->si14_cnpjorgao'
                               ,'$this->si14_tipodocumentofornsoftware'
                               ,'$this->si14_nrodocumentofornsoftware'
                               ,'$this->si14_versaosoftware'
                               ,$this->si14_mes
                               ,$this->si14_instit
                               ,$this->si14_assessoriacontabil
                               ,".($this->si14_tipodocumentoassessoria == '' ? "null": $this->si14_tipodocumentoassessoria)."
                               ,".($this->si14_nrodocumentoassessoria == '' ? "null" : "'" . $this->si14_nrodocumentoassessoria . "'")."
                      )";

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "Orgão ($this->si14_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "Orgão já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "Orgão ($this->si14_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si14_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si14_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009594,'$this->si14_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010242,2009594,'','" . AddSlashes(pg_result($resaco, 0, 'si14_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010242,2009595,'','" . AddSlashes(pg_result($resaco, 0, 'si14_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010242,2009596,'','" . AddSlashes(pg_result($resaco, 0, 'si14_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010242,2009598,'','" . AddSlashes(pg_result($resaco, 0, 'si14_tipoorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010242,2009599,'','" . AddSlashes(pg_result($resaco, 0, 'si14_cnpjorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010242,2009734,'','" . AddSlashes(pg_result($resaco, 0, 'si14_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010242,2011532,'','" . AddSlashes(pg_result($resaco, 0, 'si14_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si14_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update orgao102021 set ";
    $virgula = "";
    if (trim($this->si14_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si14_sequencial"])) {
      if (trim($this->si14_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si14_sequencial"])) {
        $this->si14_sequencial = "0";
      }
      $sql .= $virgula . " si14_sequencial = $this->si14_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si14_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si14_tiporegistro"])) {
      $sql .= $virgula . " si14_tiporegistro = $this->si14_tiporegistro ";
      $virgula = ",";
      if (trim($this->si14_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si14_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si14_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si14_codorgao"])) {
      $sql .= $virgula . " si14_codorgao = '$this->si14_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si14_tipoorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si14_tipoorgao"])) {
      $sql .= $virgula . " si14_tipoorgao = '$this->si14_tipoorgao' ";
      $virgula = ",";
    }
    if (trim($this->si14_cnpjorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si14_cnpjorgao"])) {
      $sql .= $virgula . " si14_cnpjorgao = '$this->si14_cnpjorgao' ";
      $virgula = ",";
    }
    if (trim($this->si14_tipodocumentofornsoftware) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si14_tipodocumentofornsoftware"])) {
      $sql .= $virgula . " si14_tipodocumentofornsoftware = '$this->si14_tipodocumentofornsoftware' ";
      $virgula = ",";
    }
    if (trim($this->si14_nrodocumentofornsoftware) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si14_nrodocumentofornsoftware"])) {
      $sql .= $virgula . " si14_nrodocumentofornsoftware = '$this->si14_nrodocumentofornsoftware' ";
      $virgula = ",";
    }
    if (trim($this->si14_versaosoftware) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si14_versaosoftware"])) {
      $sql .= $virgula . " si14_versaosoftware = '$this->si14_versaosoftware' ";
      $virgula = ",";
    }
    if (trim($this->si14_assessoriacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si14_assessoriacontabil"])) {
      $sql .= $virgula . " si14_assessoriacontabil = '$this->si14_assessoriacontabil' ";
      $virgula = ",";
    }
    if (trim($this->si14_tipodocumentoassessoria) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si14_tipodocumentoassessoria"])) {
      $sql .= $virgula . " si14_tipodocumentoassessoria = '$this->si14_tipodocumentoassessoria' ";
      $virgula = ",";
    }
    if (trim($this->si14_nrodocumentoassessoria) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si14_nrodocumentoassessoria"])) {
      $sql .= $virgula . " si14_nrodocumentoassessoria = '$this->si14_nrodocumentoassessoria' ";
      $virgula = ",";
    }
    if (trim($this->si14_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si14_mes"])) {
      $sql .= $virgula . " si14_mes = $this->si14_mes ";
      $virgula = ",";
      if (trim($this->si14_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si14_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si14_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si14_instit"])) {
      $sql .= $virgula . " si14_instit = $this->si14_instit ";
      $virgula = ",";
      if (trim($this->si14_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si14_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si14_sequencial != null) {
      $sql .= " si14_sequencial = $this->si14_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si14_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009594,'$this->si14_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si14_sequencial"]) || $this->si14_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010242,2009594,'" . AddSlashes(pg_result($resaco, $conresaco, 'si14_sequencial')) . "','$this->si14_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si14_tiporegistro"]) || $this->si14_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010242,2009595,'" . AddSlashes(pg_result($resaco, $conresaco, 'si14_tiporegistro')) . "','$this->si14_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si14_codorgao"]) || $this->si14_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010242,2009596,'" . AddSlashes(pg_result($resaco, $conresaco, 'si14_codorgao')) . "','$this->si14_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si14_tipoorgao"]) || $this->si14_tipoorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010242,2009598,'" . AddSlashes(pg_result($resaco, $conresaco, 'si14_tipoorgao')) . "','$this->si14_tipoorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si14_cnpjorgao"]) || $this->si14_cnpjorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010242,2009599,'" . AddSlashes(pg_result($resaco, $conresaco, 'si14_cnpjorgao')) . "','$this->si14_cnpjorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si14_mes"]) || $this->si14_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010242,2009734,'" . AddSlashes(pg_result($resaco, $conresaco, 'si14_mes')) . "','$this->si14_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si14_instit"]) || $this->si14_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010242,2011532,'" . AddSlashes(pg_result($resaco, $conresaco, 'si14_instit')) . "','$this->si14_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "Orgão nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si14_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "Orgão nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si14_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si14_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si14_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si14_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009594,'$si14_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010242,2009594,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si14_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010242,2009595,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si14_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010242,2009596,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si14_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010242,2009598,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si14_tipoorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010242,2009599,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si14_cnpjorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010242,2009734,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si14_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010242,2011532,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si14_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from orgao102021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si14_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si14_sequencial = $si14_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "Orgão nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si14_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "Orgão nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si14_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si14_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:orgao102021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si14_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from orgao102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si14_sequencial != null) {
        $sql2 .= " where orgao102021.si14_sequencial = $si14_sequencial ";
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
  function sql_query_file($si14_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from orgao102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si14_sequencial != null) {
        $sql2 .= " where orgao102021.si14_sequencial = $si14_sequencial ";
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
