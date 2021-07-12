<?
//MODULO: sicom
//CLASSE DA ENTIDADE regadesao152019
class cl_regadesao152019
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
  var $si72_sequencial = 0;
  var $si72_tiporegistro = 0;
  var $si72_codorgao = null;
  var $si72_codunidadesub = null;
  var $si72_nroprocadesao = null;
  var $si72_exercicioadesao = 0;
  var $si72_nrolote = 0;
  var $si72_coditem = 0;
  var $si72_precounitario = 0;
  var $si72_quantidadelicitada = 0;
  var $si72_quantidadeaderida = 0;
  var $si72_tipodocumento = 0;
  var $si72_nrodocumento = null;
  var $si72_mes = 0;
  var $si72_reg10 = 0;
  var $si72_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si72_sequencial = int8 = sequencial 
                 si72_tiporegistro = int8 = Tipo do  registro 
                 si72_codorgao = varchar(2) = Código do órgão 
                 si72_codunidadesub = varchar(8) = Código da unidade 
                 si72_nroprocadesao = varchar(12) = Número do  processo de adesão 
                 si72_exercicioadesao = int8 = Exercício do processo de adesão 
                 si72_nrolote = int8 = Número do Lote 
                 si72_coditem = int8 = Código do item 
                 si72_precounitario = float8 = Preço unitário 
                 si72_quantidadelicitada = float8 = Quantidade licitada 
                 si72_quantidadeaderida = float8 = Quantidade estimada do item 
                 si72_tipodocumento = int8 = Tipo do documento 
                 si72_nrodocumento = varchar(14) = Número do  documento 
                 si72_mes = int8 = Mês 
                 si72_reg10 = int8 = reg10 
                 si72_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_regadesao152019()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("regadesao152019");
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
      $this->si72_sequencial = ($this->si72_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_sequencial"] : $this->si72_sequencial);
      $this->si72_tiporegistro = ($this->si72_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_tiporegistro"] : $this->si72_tiporegistro);
      $this->si72_codorgao = ($this->si72_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_codorgao"] : $this->si72_codorgao);
      $this->si72_codunidadesub = ($this->si72_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_codunidadesub"] : $this->si72_codunidadesub);
      $this->si72_nroprocadesao = ($this->si72_nroprocadesao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_nroprocadesao"] : $this->si72_nroprocadesao);
      $this->si72_exercicioadesao = ($this->si72_exercicioadesao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_exercicioadesao"] : $this->si72_exercicioadesao);
      $this->si72_nrolote = ($this->si72_nrolote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_nrolote"] : $this->si72_nrolote);
      $this->si72_coditem = ($this->si72_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_coditem"] : $this->si72_coditem);
      $this->si72_precounitario = ($this->si72_precounitario == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_precounitario"] : $this->si72_precounitario);
      $this->si72_quantidadelicitada = ($this->si72_quantidadelicitada == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_quantidadelicitada"] : $this->si72_quantidadelicitada);
      $this->si72_quantidadeaderida = ($this->si72_quantidadeaderida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_quantidadeaderida"] : $this->si72_quantidadeaderida);
      $this->si72_tipodocumento = ($this->si72_tipodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_tipodocumento"] : $this->si72_tipodocumento);
      $this->si72_nrodocumento = ($this->si72_nrodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_nrodocumento"] : $this->si72_nrodocumento);
      $this->si72_mes = ($this->si72_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_mes"] : $this->si72_mes);
      $this->si72_reg10 = ($this->si72_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_reg10"] : $this->si72_reg10);
      $this->si72_instit = ($this->si72_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_instit"] : $this->si72_instit);
    } else {
      $this->si72_sequencial = ($this->si72_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si72_sequencial"] : $this->si72_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si72_sequencial)
  {
    $this->atualizacampos();
    if ($this->si72_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si72_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si72_exercicioadesao == null) {
      $this->si72_exercicioadesao = "0";
    }
    if ($this->si72_nrolote == null) {
      $this->si72_nrolote = "0";
    }
    if ($this->si72_coditem == null) {
      $this->si72_coditem = "0";
    }
    if ($this->si72_precounitario == null) {
      $this->si72_precounitario = "0";
    }
    if ($this->si72_quantidadelicitada == null) {
      $this->si72_quantidadelicitada = "0";
    }
    if ($this->si72_quantidadeaderida == null) {
      $this->si72_quantidadeaderida = "0";
    }
    if ($this->si72_tipodocumento == null) {
      $this->si72_tipodocumento = "0";
    }
    if ($this->si72_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si72_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si72_reg10 == null) {
      $this->si72_reg10 = "0";
    }
    if ($this->si72_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si72_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($si72_sequencial == "" || $si72_sequencial == null) {
      $result = db_query("select nextval('regadesao152019_si72_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: regadesao152019_si72_sequencial_seq do campo: si72_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si72_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from regadesao152019_si72_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si72_sequencial)) {
        $this->erro_sql = " Campo si72_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->si72_sequencial = $si72_sequencial;
      }
    }
    if (($this->si72_sequencial == null) || ($this->si72_sequencial == "")) {
      $this->erro_sql = " Campo si72_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into regadesao152019(
                                       si72_sequencial 
                                      ,si72_tiporegistro 
                                      ,si72_codorgao 
                                      ,si72_codunidadesub 
                                      ,si72_nroprocadesao 
                                      ,si72_exercicioadesao 
                                      ,si72_nrolote 
                                      ,si72_coditem 
                                      ,si72_precounitario 
                                      ,si72_quantidadelicitada 
                                      ,si72_quantidadeaderida 
                                      ,si72_tipodocumento 
                                      ,si72_nrodocumento 
                                      ,si72_mes 
                                      ,si72_reg10 
                                      ,si72_instit 
                       )
                values (
                                $this->si72_sequencial 
                               ,$this->si72_tiporegistro 
                               ,'$this->si72_codorgao' 
                               ,'$this->si72_codunidadesub' 
                               ,'$this->si72_nroprocadesao' 
                               ,$this->si72_exercicioadesao 
                               ,$this->si72_nrolote 
                               ,$this->si72_coditem 
                               ,$this->si72_precounitario 
                               ,$this->si72_quantidadelicitada 
                               ,$this->si72_quantidadeaderida 
                               ,$this->si72_tipodocumento 
                               ,'$this->si72_nrodocumento' 
                               ,$this->si72_mes 
                               ,$this->si72_reg10 
                               ,$this->si72_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "regadesao152019 ($this->si72_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "regadesao152019 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "regadesao152019 ($this->si72_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si72_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si72_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010228,'$this->si72_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010301,2010228,'','" . AddSlashes(pg_result($resaco, 0, 'si72_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010301,2010229,'','" . AddSlashes(pg_result($resaco, 0, 'si72_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010301,2010230,'','" . AddSlashes(pg_result($resaco, 0, 'si72_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010301,2010231,'','" . AddSlashes(pg_result($resaco, 0, 'si72_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010301,2010232,'','" . AddSlashes(pg_result($resaco, 0, 'si72_nroprocadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010301,2011315,'','" . AddSlashes(pg_result($resaco, 0, 'si72_exercicioadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010301,2010234,'','" . AddSlashes(pg_result($resaco, 0, 'si72_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010301,2010235,'','" . AddSlashes(pg_result($resaco, 0, 'si72_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010301,2010236,'','" . AddSlashes(pg_result($resaco, 0, 'si72_precounitario')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010301,2010237,'','" . AddSlashes(pg_result($resaco, 0, 'si72_quantidadelicitada')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010301,2010238,'','" . AddSlashes(pg_result($resaco, 0, 'si72_quantidadeaderida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010301,2010239,'','" . AddSlashes(pg_result($resaco, 0, 'si72_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010301,2010240,'','" . AddSlashes(pg_result($resaco, 0, 'si72_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010301,2010241,'','" . AddSlashes(pg_result($resaco, 0, 'si72_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010301,2010242,'','" . AddSlashes(pg_result($resaco, 0, 'si72_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010301,2011584,'','" . AddSlashes(pg_result($resaco, 0, 'si72_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    return true;
  }
  
  // funcao para alteracao
  function alterar($si72_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update regadesao152019 set ";
    $virgula = "";
    if (trim($this->si72_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_sequencial"])) {
      if (trim($this->si72_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si72_sequencial"])) {
        $this->si72_sequencial = "0";
      }
      $sql .= $virgula . " si72_sequencial = $this->si72_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si72_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_tiporegistro"])) {
      $sql .= $virgula . " si72_tiporegistro = $this->si72_tiporegistro ";
      $virgula = ",";
      if (trim($this->si72_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si72_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si72_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_codorgao"])) {
      $sql .= $virgula . " si72_codorgao = '$this->si72_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si72_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_codunidadesub"])) {
      $sql .= $virgula . " si72_codunidadesub = '$this->si72_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si72_nroprocadesao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_nroprocadesao"])) {
      $sql .= $virgula . " si72_nroprocadesao = '$this->si72_nroprocadesao' ";
      $virgula = ",";
    }
    if (trim($this->si72_exercicioadesao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_exercicioadesao"])) {
      if (trim($this->si72_exercicioadesao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si72_exercicioadesao"])) {
        $this->si72_exercicioadesao = "0";
      }
      $sql .= $virgula . " si72_exercicioadesao = $this->si72_exercicioadesao ";
      $virgula = ",";
    }
    if (trim($this->si72_nrolote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_nrolote"])) {
      if (trim($this->si72_nrolote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si72_nrolote"])) {
        $this->si72_nrolote = "0";
      }
      $sql .= $virgula . " si72_nrolote = $this->si72_nrolote ";
      $virgula = ",";
    }
    if (trim($this->si72_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_coditem"])) {
      if (trim($this->si72_coditem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si72_coditem"])) {
        $this->si72_coditem = "0";
      }
      $sql .= $virgula . " si72_coditem = $this->si72_coditem ";
      $virgula = ",";
    }
    if (trim($this->si72_precounitario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_precounitario"])) {
      if (trim($this->si72_precounitario) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si72_precounitario"])) {
        $this->si72_precounitario = "0";
      }
      $sql .= $virgula . " si72_precounitario = $this->si72_precounitario ";
      $virgula = ",";
    }
    if (trim($this->si72_quantidadelicitada) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_quantidadelicitada"])) {
      if (trim($this->si72_quantidadelicitada) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si72_quantidadelicitada"])) {
        $this->si72_quantidadelicitada = "0";
      }
      $sql .= $virgula . " si72_quantidadelicitada = $this->si72_quantidadelicitada ";
      $virgula = ",";
    }
    if (trim($this->si72_quantidadeaderida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_quantidadeaderida"])) {
      if (trim($this->si72_quantidadeaderida) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si72_quantidadeaderida"])) {
        $this->si72_quantidadeaderida = "0";
      }
      $sql .= $virgula . " si72_quantidadeaderida = $this->si72_quantidadeaderida ";
      $virgula = ",";
    }
    if (trim($this->si72_tipodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_tipodocumento"])) {
      if (trim($this->si72_tipodocumento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si72_tipodocumento"])) {
        $this->si72_tipodocumento = "0";
      }
      $sql .= $virgula . " si72_tipodocumento = $this->si72_tipodocumento ";
      $virgula = ",";
    }
    if (trim($this->si72_nrodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_nrodocumento"])) {
      $sql .= $virgula . " si72_nrodocumento = '$this->si72_nrodocumento' ";
      $virgula = ",";
    }
    if (trim($this->si72_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_mes"])) {
      $sql .= $virgula . " si72_mes = $this->si72_mes ";
      $virgula = ",";
      if (trim($this->si72_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si72_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si72_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_reg10"])) {
      if (trim($this->si72_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si72_reg10"])) {
        $this->si72_reg10 = "0";
      }
      $sql .= $virgula . " si72_reg10 = $this->si72_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si72_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si72_instit"])) {
      $sql .= $virgula . " si72_instit = $this->si72_instit ";
      $virgula = ",";
      if (trim($this->si72_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si72_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($si72_sequencial != null) {
      $sql .= " si72_sequencial = $this->si72_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si72_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010228,'$this->si72_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_sequencial"]) || $this->si72_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2010228,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_sequencial')) . "','$this->si72_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_tiporegistro"]) || $this->si72_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2010229,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_tiporegistro')) . "','$this->si72_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_codorgao"]) || $this->si72_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2010230,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_codorgao')) . "','$this->si72_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_codunidadesub"]) || $this->si72_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2010231,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_codunidadesub')) . "','$this->si72_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_nroprocadesao"]) || $this->si72_nroprocadesao != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2010232,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_nroprocadesao')) . "','$this->si72_nroprocadesao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_exercicioadesao"]) || $this->si72_exercicioadesao != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2011315,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_exercicioadesao')) . "','$this->si72_exercicioadesao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_nrolote"]) || $this->si72_nrolote != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2010234,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_nrolote')) . "','$this->si72_nrolote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_coditem"]) || $this->si72_coditem != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2010235,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_coditem')) . "','$this->si72_coditem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_precounitario"]) || $this->si72_precounitario != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2010236,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_precounitario')) . "','$this->si72_precounitario'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_quantidadelicitada"]) || $this->si72_quantidadelicitada != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2010237,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_quantidadelicitada')) . "','$this->si72_quantidadelicitada'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_quantidadeaderida"]) || $this->si72_quantidadeaderida != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2010238,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_quantidadeaderida')) . "','$this->si72_quantidadeaderida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_tipodocumento"]) || $this->si72_tipodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2010239,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_tipodocumento')) . "','$this->si72_tipodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_nrodocumento"]) || $this->si72_nrodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2010240,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_nrodocumento')) . "','$this->si72_nrodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_mes"]) || $this->si72_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2010241,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_mes')) . "','$this->si72_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_reg10"]) || $this->si72_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2010242,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_reg10')) . "','$this->si72_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si72_instit"]) || $this->si72_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010301,2011584,'" . AddSlashes(pg_result($resaco, $conresaco, 'si72_instit')) . "','$this->si72_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "regadesao152019 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si72_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "regadesao152019 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si72_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si72_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si72_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si72_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010228,'$si72_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010301,2010228,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010301,2010229,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010301,2010230,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010301,2010231,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010301,2010232,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_nroprocadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010301,2011315,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_exercicioadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010301,2010234,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010301,2010235,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010301,2010236,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_precounitario')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010301,2010237,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_quantidadelicitada')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010301,2010238,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_quantidadeaderida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010301,2010239,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010301,2010240,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010301,2010241,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010301,2010242,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010301,2011584,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si72_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from regadesao152019
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si72_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si72_sequencial = $si72_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "regadesao152019 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si72_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "regadesao152019 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si72_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si72_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:regadesao152019";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  
  // funcao do sql
  function sql_query($si72_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from regadesao152019 ";
    $sql .= "      left  join regadesao102019  on  regadesao102019.si67_sequencial = regadesao152019.si72_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si72_sequencial != null) {
        $sql2 .= " where regadesao152019.si72_sequencial = $si72_sequencial ";
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
  function sql_query_file($si72_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from regadesao152019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si72_sequencial != null) {
        $sql2 .= " where regadesao152019.si72_sequencial = $si72_sequencial ";
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
