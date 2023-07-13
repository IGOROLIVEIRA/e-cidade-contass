<?
//MODULO: sicom
//CLASSE DA ENTIDADE aop122023
class cl_aop122023
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
  var $si139_sequencial = 0;
  var $si139_tiporegistro = 0;
  var $si139_codreduzido = 0;
  var $si139_tipodocumento = null;
  var $si139_nrodocumento = null;
  var $si139_codctb = 0;
  var $si139_codfontectb = 0;
  var $si139_dtemissao_dia = null;
  var $si139_dtemissao_mes = null;
  var $si139_dtemissao_ano = null;
  var $si139_dtemissao = null;
  var $si139_vldocumento = 0;
  var $si139_desctipodocumentoop;
  var $si139_mes = 0;
  var $si139_reg10 = 0;
  var $si139_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si139_sequencial = int8 = sequencial
                 si139_tiporegistro = int8 = Tipo do  registro
                 si139_codreduzido = int8 = Código  Identificador da  Ordem
                 si139_tipodocumento = varchar(2) = Tipo do Documento
                 si139_nrodocumento = varchar(15) = Número do  documento
                 si139_codctb = int8 = Código Identificador da Conta Bancária
                 si139_codfontectb = int8 = Código da fonte de recursos
                 si139_dtemissao = date = Data de emissão do documento
                 si139_vldocumento = float8 = Valor da OP associado ao documento
                 si139_desctipodocumentoop = varchar(50) = Descrição
                 si139_mes = int8 = Mês
                 si139_reg10 = int8 = reg10
                 si139_instit = int4 = Instituição
                 ";

  //funcao construtor da classe
  function cl_aop122023()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("aop122023");
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
      $this->si139_sequencial = ($this->si139_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si139_sequencial"] : $this->si139_sequencial);
      $this->si139_tiporegistro = ($this->si139_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si139_tiporegistro"] : $this->si139_tiporegistro);
      $this->si139_codreduzido = ($this->si139_codreduzido == "" ? @$GLOBALS["HTTP_POST_VARS"]["si139_codreduzido"] : $this->si139_codreduzido);
      $this->si139_tipodocumento = ($this->si139_tipodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si139_tipodocumento"] : $this->si139_tipodocumento);
      $this->si139_nrodocumento = ($this->si139_nrodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si139_nrodocumento"] : $this->si139_nrodocumento);
      $this->si139_codctb = ($this->si139_codctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si139_codctb"] : $this->si139_codctb);
      $this->si139_codfontectb = ($this->si139_codfontectb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si139_codfontectb"] : $this->si139_codfontectb);
      if ($this->si139_dtemissao == "") {
        $this->si139_dtemissao_dia = ($this->si139_dtemissao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si139_dtemissao_dia"] : $this->si139_dtemissao_dia);
        $this->si139_dtemissao_mes = ($this->si139_dtemissao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si139_dtemissao_mes"] : $this->si139_dtemissao_mes);
        $this->si139_dtemissao_ano = ($this->si139_dtemissao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si139_dtemissao_ano"] : $this->si139_dtemissao_ano);
        if ($this->si139_dtemissao_dia != "") {
          $this->si139_dtemissao = $this->si139_dtemissao_ano . "-" . $this->si139_dtemissao_mes . "-" . $this->si139_dtemissao_dia;
        }
      }
      $this->si139_vldocumento = ($this->si139_vldocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si139_vldocumento"] : $this->si139_vldocumento);
      $this->si139_mes = ($this->si139_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si139_mes"] : $this->si139_mes);
      $this->si139_reg10 = ($this->si139_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si139_reg10"] : $this->si139_reg10);
      $this->si139_instit = ($this->si139_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si139_instit"] : $this->si139_instit);
    } else {
      $this->si139_sequencial = ($this->si139_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si139_sequencial"] : $this->si139_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si139_sequencial)
  {
    $this->atualizacampos();
    if ($this->si139_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si139_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si139_codreduzido == null) {
      $this->si139_codreduzido = "0";
    }
    if ($this->si139_codctb == null) {
      $this->si139_codctb = "0";
    }
    if ($this->si139_codfontectb == null) {
      $this->si139_codfontectb = "0";
    }
    if ($this->si139_dtemissao == null) {
      $this->si139_dtemissao = "null";
    }
    if ($this->si139_vldocumento == null) {
      $this->si139_vldocumento = "0";
    }
    if ($this->si139_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si139_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si139_reg10 == null) {
      $this->si139_reg10 = "0";
    }
    if ($this->si139_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si139_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si139_sequencial == "" || $si139_sequencial == null) {
      $result = db_query("select nextval('aop122023_si139_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: aop122023_si139_sequencial_seq do campo: si139_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si139_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from aop122023_si139_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si139_sequencial)) {
        $this->erro_sql = " Campo si139_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si139_sequencial = $si139_sequencial;
      }
    }
    if (($this->si139_sequencial == null) || ($this->si139_sequencial == "")) {
      $this->erro_sql = " Campo si139_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into aop122023(
                                       si139_sequencial
                                      ,si139_tiporegistro
                                      ,si139_codreduzido
                                      ,si139_tipodocumento
                                      ,si139_nrodocumento
                                      ,si139_codctb
                                      ,si139_codfontectb
                                      ,si139_dtemissao
                                      ,si139_vldocumento
                                      ,si139_desctipodocumentoop
                                      ,si139_mes
                                      ,si139_reg10
                                      ,si139_instit
                       )
                values (
                                $this->si139_sequencial
                               ,$this->si139_tiporegistro
                               ,$this->si139_codreduzido
                               ,'$this->si139_tipodocumento'
                               ,'$this->si139_nrodocumento'
                               ,$this->si139_codctb
                               ,$this->si139_codfontectb
                               ," . ($this->si139_dtemissao == "null" || $this->si139_dtemissao == "" ? "null" : "'" . $this->si139_dtemissao . "'") . "
                               ,$this->si139_vldocumento
                               ,'$this->si139_desctipodocumentoop'
                               ,$this->si139_mes
                               ,$this->si139_reg10
                               ,$this->si139_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "aop122023 ($this->si139_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "aop122023 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "aop122023 ($this->si139_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si139_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si139_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010956,'$this->si139_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010363,2010956,'','" . AddSlashes(pg_result($resaco, 0, 'si139_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010363,2010957,'','" . AddSlashes(pg_result($resaco, 0, 'si139_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010363,2010958,'','" . AddSlashes(pg_result($resaco, 0, 'si139_codreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010363,2010959,'','" . AddSlashes(pg_result($resaco, 0, 'si139_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010363,2010960,'','" . AddSlashes(pg_result($resaco, 0, 'si139_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010363,2010961,'','" . AddSlashes(pg_result($resaco, 0, 'si139_codctb')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010363,2011398,'','" . AddSlashes(pg_result($resaco, 0, 'si139_codfontectb')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010363,2010962,'','" . AddSlashes(pg_result($resaco, 0, 'si139_dtemissao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010363,2010963,'','" . AddSlashes(pg_result($resaco, 0, 'si139_vldocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010363,2010964,'','" . AddSlashes(pg_result($resaco, 0, 'si139_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010363,2010965,'','" . AddSlashes(pg_result($resaco, 0, 'si139_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010363,2011647,'','" . AddSlashes(pg_result($resaco, 0, 'si139_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si139_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update aop122023 set ";
    $virgula = "";
    if (trim($this->si139_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si139_sequencial"])) {
      if (trim($this->si139_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si139_sequencial"])) {
        $this->si139_sequencial = "0";
      }
      $sql .= $virgula . " si139_sequencial = $this->si139_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si139_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si139_tiporegistro"])) {
      $sql .= $virgula . " si139_tiporegistro = $this->si139_tiporegistro ";
      $virgula = ",";
      if (trim($this->si139_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si139_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si139_codreduzido) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si139_codreduzido"])) {
      if (trim($this->si139_codreduzido) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si139_codreduzido"])) {
        $this->si139_codreduzido = "0";
      }
      $sql .= $virgula . " si139_codreduzido = $this->si139_codreduzido ";
      $virgula = ",";
    }
    if (trim($this->si139_tipodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si139_tipodocumento"])) {
      $sql .= $virgula . " si139_tipodocumento = '$this->si139_tipodocumento' ";
      $virgula = ",";
    }
    if (trim($this->si139_nrodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si139_nrodocumento"])) {
      $sql .= $virgula . " si139_nrodocumento = '$this->si139_nrodocumento' ";
      $virgula = ",";
    }
    if (trim($this->si139_codctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si139_codctb"])) {
      if (trim($this->si139_codctb) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si139_codctb"])) {
        $this->si139_codctb = "0";
      }
      $sql .= $virgula . " si139_codctb = $this->si139_codctb ";
      $virgula = ",";
    }
    if (trim($this->si139_codfontectb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si139_codfontectb"])) {
      if (trim($this->si139_codfontectb) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si139_codfontectb"])) {
        $this->si139_codfontectb = "0";
      }
      $sql .= $virgula . " si139_codfontectb = $this->si139_codfontectb ";
      $virgula = ",";
    }
    if (trim($this->si139_dtemissao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si139_dtemissao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si139_dtemissao_dia"] != "")) {
      $sql .= $virgula . " si139_dtemissao = '$this->si139_dtemissao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si139_dtemissao_dia"])) {
        $sql .= $virgula . " si139_dtemissao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si139_vldocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si139_vldocumento"])) {
      if (trim($this->si139_vldocumento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si139_vldocumento"])) {
        $this->si139_vldocumento = "0";
      }
      $sql .= $virgula . " si139_vldocumento = $this->si139_vldocumento ";
      $virgula = ",";
    }
    if (trim($this->si139_desctipodocumentoop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si139_desctipodocumentoop"])) {
      if (trim($this->si139_desctipodocumentoop) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si139_desctipodocumentoop"])) {
        $this->si139_desctipodocumentoop = "0";
      }
      $sql .= $virgula . " si139_desctipodocumentoop = '$this->si139_desctipodocumentoop' ";
      $virgula = ",";
    }
    if (trim($this->si139_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si139_mes"])) {
      $sql .= $virgula . " si139_mes = $this->si139_mes ";
      $virgula = ",";
      if (trim($this->si139_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si139_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si139_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si139_reg10"])) {
      if (trim($this->si139_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si139_reg10"])) {
        $this->si139_reg10 = "0";
      }
      $sql .= $virgula . " si139_reg10 = $this->si139_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si139_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si139_instit"])) {
      $sql .= $virgula . " si139_instit = $this->si139_instit ";
      $virgula = ",";
      if (trim($this->si139_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si139_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si139_sequencial != null) {
      $sql .= " si139_sequencial = $this->si139_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si139_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010956,'$this->si139_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si139_sequencial"]) || $this->si139_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010363,2010956,'" . AddSlashes(pg_result($resaco, $conresaco, 'si139_sequencial')) . "','$this->si139_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si139_tiporegistro"]) || $this->si139_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010363,2010957,'" . AddSlashes(pg_result($resaco, $conresaco, 'si139_tiporegistro')) . "','$this->si139_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si139_codreduzido"]) || $this->si139_codreduzido != "")
          $resac = db_query("insert into db_acount values($acount,2010363,2010958,'" . AddSlashes(pg_result($resaco, $conresaco, 'si139_codreduzido')) . "','$this->si139_codreduzido'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si139_tipodocumento"]) || $this->si139_tipodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010363,2010959,'" . AddSlashes(pg_result($resaco, $conresaco, 'si139_tipodocumento')) . "','$this->si139_tipodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si139_nrodocumento"]) || $this->si139_nrodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010363,2010960,'" . AddSlashes(pg_result($resaco, $conresaco, 'si139_nrodocumento')) . "','$this->si139_nrodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si139_codctb"]) || $this->si139_codctb != "")
          $resac = db_query("insert into db_acount values($acount,2010363,2010961,'" . AddSlashes(pg_result($resaco, $conresaco, 'si139_codctb')) . "','$this->si139_codctb'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si139_codfontectb"]) || $this->si139_codfontectb != "")
          $resac = db_query("insert into db_acount values($acount,2010363,2011398,'" . AddSlashes(pg_result($resaco, $conresaco, 'si139_codfontectb')) . "','$this->si139_codfontectb'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si139_dtemissao"]) || $this->si139_dtemissao != "")
          $resac = db_query("insert into db_acount values($acount,2010363,2010962,'" . AddSlashes(pg_result($resaco, $conresaco, 'si139_dtemissao')) . "','$this->si139_dtemissao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si139_vldocumento"]) || $this->si139_vldocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010363,2010963,'" . AddSlashes(pg_result($resaco, $conresaco, 'si139_vldocumento')) . "','$this->si139_vldocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si139_mes"]) || $this->si139_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010363,2010964,'" . AddSlashes(pg_result($resaco, $conresaco, 'si139_mes')) . "','$this->si139_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si139_reg10"]) || $this->si139_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010363,2010965,'" . AddSlashes(pg_result($resaco, $conresaco, 'si139_reg10')) . "','$this->si139_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si139_instit"]) || $this->si139_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010363,2011647,'" . AddSlashes(pg_result($resaco, $conresaco, 'si139_instit')) . "','$this->si139_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aop122023 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si139_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aop122023 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si139_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si139_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si139_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si139_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010956,'$si139_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010363,2010956,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si139_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010363,2010957,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si139_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010363,2010958,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si139_codreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010363,2010959,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si139_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010363,2010960,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si139_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010363,2010961,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si139_codctb')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010363,2011398,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si139_codfontectb')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010363,2010962,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si139_dtemissao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010363,2010963,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si139_vldocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010363,2010964,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si139_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010363,2010965,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si139_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010363,2011647,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si139_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from aop122023
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si139_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si139_sequencial = $si139_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aop122023 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si139_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aop122023 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si139_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si139_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:aop122023";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si139_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aop122023 ";
    $sql .= "      left  join aop102020  on  aop102020.si132_sequencial = aop122023.si139_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si139_sequencial != null) {
        $sql2 .= " where aop122023.si139_sequencial = $si139_sequencial ";
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
  function sql_query_file($si139_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aop122023 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si139_sequencial != null) {
        $sql2 .= " where aop122023.si139_sequencial = $si139_sequencial ";
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

    public function sqlReg12($oEmpPago, $iAnoUsu)
    {
        $sSql12 = " SELECT
                    12 AS tiporegistro,
                    coremp.k12_codord AS codreduzidoop,
                    CASE
                        WHEN e96_codigo = 4
                        AND c60_codsis = 5 THEN 5
                        WHEN e96_codigo = 1 THEN 5
                        WHEN e96_codigo = 2 THEN 1
                        ELSE 99
                    END AS tipodocumentoop,
                    CASE
                        WHEN e96_codigo = 2 THEN e86_cheque
                        ELSE NULL
                    END AS nrodocumento,
                    c61_reduz AS codctb,
                    o15_codigo AS codfontectb,
                    e50_data AS dtemissao,
                    corrente.k12_valor AS vldocumento,
                    CASE
                        WHEN c60_codsis = 5 THEN ''
                        ELSE e96_descr
                    END desctipodocumentoop,
                    c23_conlancam AS codlan,
                    e81_codmov,
                    e81_numdoc
                FROM corrente
                JOIN coremp ON (coremp.k12_autent, coremp.k12_data, coremp.k12_id) = (corrente.k12_autent, corrente.k12_data, corrente.k12_id)
                JOIN conplanoreduz ON c61_reduz = k12_conta
                JOIN conplano ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu
                LEFT JOIN conplanoconta ON c63_codcon = c60_codcon AND c60_anousu = c63_anousu
                JOIN corgrupocorrente ON corgrupocorrente.k105_autent = corrente.k12_autent AND corgrupocorrente.k105_data = corrente.k12_data
                    AND (corgrupocorrente.k105_data, corgrupocorrente.k105_id) = (corrente.k12_data, corrente.k12_id)
                JOIN conlancamcorgrupocorrente ON c23_corgrupocorrente = corgrupocorrente.k105_sequencial
                JOIN pagordem ON (k12_empen, k12_codord) = (e50_numemp, e50_codord)
                INNER JOIN empempenho ON empempenho.e60_numemp = e50_numemp
                INNER JOIN empagemov ON empempenho.e60_numemp = empagemov.e81_numemp
                INNER JOIN empord ON empord.e82_codmov = empagemov.e81_codmov
                LEFT JOIN empagemovforma ON empagemovforma.e97_codmov = empagemov.e81_codmov
                LEFT JOIN empageforma ON empageforma.e96_codigo = empagemovforma.e97_codforma
                LEFT JOIN empageconf ON empageconf.e86_codmov = empagemov.e81_codmov
                JOIN orcdotacao ON (o58_coddot, o58_anousu) = (e60_coddot, e60_anousu)
                JOIN orctiporec ON o58_codigo = o15_codigo
                WHERE k12_codord = {$oEmpPago->ordem}
                  AND c23_conlancam = {$oEmpPago->lancamento}
                  AND c61_anousu = {$iAnoUsu}
                  AND e81_cancelado IS NULL";

        return db_query ($sSql12);
    }

    public function getUnionPagFont($reg12, $iAno, $sDataFinal, $iInstit, $iAnousu)
    {
        return " SELECT DISTINCT 'ctb10{$iAno}' as ano, si95_codctb  AS contapag, o15_codtri AS fonte from conplanoconta
                JOIN conplanoreduz ON c61_codcon = c63_codcon AND c61_anousu = c63_anousu
                JOIN orctiporec ON c61_codigo = o15_codigo
                JOIN ctb10{$iAno} ON si95_banco = c63_banco
                        AND substring(si95_agencia,'([0-9]{1,99})')::integer = substring(c63_agencia,'([0-9]{1,99})')::integer
                        AND coalesce(si95_digitoverificadoragencia, '') = coalesce(c63_dvagencia, '')
                        AND si95_contabancaria = c63_conta::int8
                        AND si95_digitoverificadorcontabancaria = c63_dvconta
                        AND si95_tipoconta::int8 = (case when c63_tipoconta in (2,3) then 2 else 1 end) join ctb20{$iAno} on si96_codctb = si95_codctb AND si96_mes = si95_mes
                WHERE si95_instit =  {$iInstit} AND c61_reduz = {$reg12->codctb} AND c61_anousu = {$iAnousu}
                  AND si95_mes <='{$sDataFinal}'";
    }
}
