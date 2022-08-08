<?
//MODULO: sicom
//CLASSE DA ENTIDADE homolic302019
class cl_homolic302019
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
  var $si65_sequencial = 0;
  var $si65_tiporegistro = 0;
  var $si65_codorgao = null;
  var $si65_codunidadesub = null;
  var $si65_exerciciolicitacao = 0;
  var $si65_nroprocessolicitatorio = null;
  var $si65_tipodocumento = 0;
  var $si65_nrodocumento = null;
  var $si65_nrolote = 0;
  var $si65_coditem = null;
  var $si65_perctaxaadm = 0;
  var $si65_mes = 0;
  var $si65_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si65_sequencial = int8 = sequencial
                 si65_tiporegistro = int8 = Tipo do  registro
                 si65_codorgao = varchar(2) = Código do órgão
                 si65_codunidadesub = varchar(8) = Código da unidade
                 si65_exerciciolicitacao = int8 = Exercício em que foi instaurado
                 si65_nroprocessolicitatorio = varchar(12) = Número sequencial  do processo
                 si65_tipodocumento = int8 = Tipo de documento
                 si65_nrodocumento = varchar(14) = Número do  documento
                 si65_nrolote = int8 = Número do Lote
                 si65_coditem = varchar(15) = Código do item
                 si65_perctaxaadm = float8 = Percentual do  desconto
                 si65_mes = int8 = Mês
                 si65_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function cl_homolic302019()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("homolic302019");
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
      $this->si65_sequencial = ($this->si65_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_sequencial"] : $this->si65_sequencial);
      $this->si65_tiporegistro = ($this->si65_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_tiporegistro"] : $this->si65_tiporegistro);
      $this->si65_codorgao = ($this->si65_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_codorgao"] : $this->si65_codorgao);
      $this->si65_codunidadesub = ($this->si65_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_codunidadesub"] : $this->si65_codunidadesub);
      $this->si65_exerciciolicitacao = ($this->si65_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_exerciciolicitacao"] : $this->si65_exerciciolicitacao);
      $this->si65_nroprocessolicitatorio = ($this->si65_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_nroprocessolicitatorio"] : $this->si65_nroprocessolicitatorio);
      $this->si65_tipodocumento = ($this->si65_tipodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_tipodocumento"] : $this->si65_tipodocumento);
      $this->si65_nrodocumento = ($this->si65_nrodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_nrodocumento"] : $this->si65_nrodocumento);
      $this->si65_nrolote = ($this->si65_nrolote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_nrolote"] : $this->si65_nrolote);
      $this->si65_coditem = ($this->si65_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_coditem"] : $this->si65_coditem);
      $this->si65_perctaxaadm = ($this->si65_perctaxaadm == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_perctaxaadm"] : $this->si65_perctaxaadm);
      $this->si65_mes = ($this->si65_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_mes"] : $this->si65_mes);
      $this->si65_instit = ($this->si65_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_instit"] : $this->si65_instit);
    } else {
      $this->si65_sequencial = ($this->si65_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_sequencial"] : $this->si65_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si65_sequencial)
  {
    $this->atualizacampos();
    if ($this->si65_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si65_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si65_codorgao == null) {
      $this->erro_sql = " Campo Código do Órgão não Informado.";
      $this->erro_campo = "si65_codorgao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si65_exerciciolicitacao == null) {
      $this->si65_exerciciolicitacao = "0";
    }
    if ($this->si65_tipodocumento == null) {
      $this->si65_tipodocumento = "0";
    }
    if ($this->si65_nrolote == null) {
      $this->si65_nrolote = "0";
    }
    if ($this->si65_perctaxaadm == null) {
      $this->si65_perctaxaadm = "0";
    }
    if ($this->si65_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si65_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si65_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si65_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si65_sequencial == "" || $si65_sequencial == null) {
      $result = db_query("select nextval('homolic302019_si65_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: homolic302019_si65_sequencial_seq do campo: si65_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si65_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from homolic302019_si65_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si65_sequencial)) {
        $this->erro_sql = " Campo si65_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si65_sequencial = $si65_sequencial;
      }
    }
    if (($this->si65_sequencial == null) || ($this->si65_sequencial == "")) {
      $this->erro_sql = " Campo si65_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into homolic302019(
                                       si65_sequencial
                                      ,si65_tiporegistro
                                      ,si65_codorgao
                                      ,si65_codunidadesub
                                      ,si65_exerciciolicitacao
                                      ,si65_nroprocessolicitatorio
                                      ,si65_tipodocumento
                                      ,si65_nrodocumento
                                      ,si65_nrolote
                                      ,si65_coditem
                                      ,si65_perctaxaadm
                                      ,si65_mes
                                      ,si65_instit
                       )
                values (
                                $this->si65_sequencial
                               ,$this->si65_tiporegistro
                               ,'$this->si65_codorgao'
                               ,'$this->si65_codunidadesub'
                               ,$this->si65_exerciciolicitacao
                               ,'$this->si65_nroprocessolicitatorio'
                               ,$this->si65_tipodocumento
                               ,'$this->si65_nrodocumento'
                               ,$this->si65_nrolote
                               ,'$this->si65_coditem'
                               ,$this->si65_perctaxaadm
                               ,$this->si65_mes
                               ,$this->si65_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "homolic302019 ($this->si65_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "homolic302019 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "homolic302019 ($this->si65_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si65_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si65_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010132,'$this->si65_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010293,2010132,'','" . AddSlashes(pg_result($resaco, 0, 'si65_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010293,2010133,'','" . AddSlashes(pg_result($resaco, 0, 'si65_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010293,2010134,'','" . AddSlashes(pg_result($resaco, 0, 'si65_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010293,2010135,'','" . AddSlashes(pg_result($resaco, 0, 'si65_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010293,2010136,'','" . AddSlashes(pg_result($resaco, 0, 'si65_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010293,2010137,'','" . AddSlashes(pg_result($resaco, 0, 'si65_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010293,2010138,'','" . AddSlashes(pg_result($resaco, 0, 'si65_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010293,2010139,'','" . AddSlashes(pg_result($resaco, 0, 'si65_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010293,2010140,'','" . AddSlashes(pg_result($resaco, 0, 'si65_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010293,2010141,'','" . AddSlashes(pg_result($resaco, 0, 'si65_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010293,2010142,'','" . AddSlashes(pg_result($resaco, 0, 'si65_perctaxaadm')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010293,2010143,'','" . AddSlashes(pg_result($resaco, 0, 'si65_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010293,2011576,'','" . AddSlashes(pg_result($resaco, 0, 'si65_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si65_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update homolic302019 set ";
    $virgula = "";
    if (trim($this->si65_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_sequencial"])) {
      if (trim($this->si65_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si65_sequencial"])) {
        $this->si65_sequencial = "0";
      }
      $sql .= $virgula . " si65_sequencial = $this->si65_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si65_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_tiporegistro"])) {
      $sql .= $virgula . " si65_tiporegistro = $this->si65_tiporegistro ";
      $virgula = ",";
      if (trim($this->si65_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si65_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si65_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_codorgao"])) {
      $sql .= $virgula . " si65_codorgao = '$this->si65_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si65_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_codunidadesub"])) {
      $sql .= $virgula . " si65_codunidadesub = '$this->si65_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si65_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_exerciciolicitacao"])) {
      if (trim($this->si65_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si65_exerciciolicitacao"])) {
        $this->si65_exerciciolicitacao = "0";
      }
      $sql .= $virgula . " si65_exerciciolicitacao = $this->si65_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si65_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si65_nroprocessolicitatorio = '$this->si65_nroprocessolicitatorio' ";
      $virgula = ",";
    }
    if (trim($this->si65_tipodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_tipodocumento"])) {
      if (trim($this->si65_tipodocumento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si65_tipodocumento"])) {
        $this->si65_tipodocumento = "0";
      }
      $sql .= $virgula . " si65_tipodocumento = $this->si65_tipodocumento ";
      $virgula = ",";
    }
    if (trim($this->si65_nrodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_nrodocumento"])) {
      $sql .= $virgula . " si65_nrodocumento = '$this->si65_nrodocumento' ";
      $virgula = ",";
    }
    if (trim($this->si65_nrolote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_nrolote"])) {
      if (trim($this->si65_nrolote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si65_nrolote"])) {
        $this->si65_nrolote = "0";
      }
      $sql .= $virgula . " si65_nrolote = $this->si65_nrolote ";
      $virgula = ",";
    }
    if (trim($this->si65_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_coditem"])) {
      $sql .= $virgula . " si65_coditem = '$this->si65_coditem' ";
      $virgula = ",";
    }
    if (trim($this->si65_perctaxaadm) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_perctaxaadm"])) {
      if (trim($this->si65_perctaxaadm) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si65_perctaxaadm"])) {
        $this->si65_perctaxaadm = "0";
      }
      $sql .= $virgula . " si65_perctaxaadm = $this->si65_perctaxaadm ";
      $virgula = ",";
    }
    if (trim($this->si65_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_mes"])) {
      $sql .= $virgula . " si65_mes = $this->si65_mes ";
      $virgula = ",";
      if (trim($this->si65_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si65_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si65_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_instit"])) {
      $sql .= $virgula . " si65_instit = $this->si65_instit ";
      $virgula = ",";
      if (trim($this->si65_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si65_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si65_sequencial != null) {
      $sql .= " si65_sequencial = $this->si65_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si65_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010132,'$this->si65_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_sequencial"]) || $this->si65_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010293,2010132,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_sequencial')) . "','$this->si65_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_tiporegistro"]) || $this->si65_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010293,2010133,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_tiporegistro')) . "','$this->si65_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_codorgao"]) || $this->si65_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010293,2010134,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_codorgao')) . "','$this->si65_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_codunidadesub"]) || $this->si65_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010293,2010135,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_codunidadesub')) . "','$this->si65_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_exerciciolicitacao"]) || $this->si65_exerciciolicitacao != "")
          $resac = db_query("insert into db_acount values($acount,2010293,2010136,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_exerciciolicitacao')) . "','$this->si65_exerciciolicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_nroprocessolicitatorio"]) || $this->si65_nroprocessolicitatorio != "")
          $resac = db_query("insert into db_acount values($acount,2010293,2010137,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_nroprocessolicitatorio')) . "','$this->si65_nroprocessolicitatorio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_tipodocumento"]) || $this->si65_tipodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010293,2010138,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_tipodocumento')) . "','$this->si65_tipodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_nrodocumento"]) || $this->si65_nrodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010293,2010139,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_nrodocumento')) . "','$this->si65_nrodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_nrolote"]) || $this->si65_nrolote != "")
          $resac = db_query("insert into db_acount values($acount,2010293,2010140,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_nrolote')) . "','$this->si65_nrolote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_coditem"]) || $this->si65_coditem != "")
          $resac = db_query("insert into db_acount values($acount,2010293,2010141,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_coditem')) . "','$this->si65_coditem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_perctaxaadm"]) || $this->si65_perctaxaadm != "")
          $resac = db_query("insert into db_acount values($acount,2010293,2010142,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_perctaxaadm')) . "','$this->si65_perctaxaadm'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_mes"]) || $this->si65_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010293,2010143,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_mes')) . "','$this->si65_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_instit"]) || $this->si65_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010293,2011576,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_instit')) . "','$this->si65_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "homolic302019 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si65_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "homolic302019 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si65_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si65_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si65_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si65_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010132,'$si65_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010293,2010132,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010293,2010133,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010293,2010134,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010293,2010135,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010293,2010136,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010293,2010137,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010293,2010138,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010293,2010139,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010293,2010140,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010293,2010141,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010293,2010142,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_perctaxaadm')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010293,2010143,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010293,2011576,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from homolic302019
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si65_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si65_sequencial = $si65_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "homolic302019 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si65_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "homolic302019 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si65_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si65_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:homolic302019";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si65_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from homolic302019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si65_sequencial != null) {
        $sql2 .= " where homolic302019.si65_sequencial = $si65_sequencial ";
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
  function sql_query_file($si65_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from homolic302019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si65_sequencial != null) {
        $sql2 .= " where homolic302019.si65_sequencial = $si65_sequencial ";
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
