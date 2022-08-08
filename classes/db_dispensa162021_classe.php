<?
//MODULO: sicom
//CLASSE DA ENTIDADE dispensa162021
class cl_dispensa162021
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
  var $si80_sequencial = 0;
  var $si80_tiporegistro = 0;
  var $si80_codorgaoresp = null;
  var $si80_codunidadesubresp = null;
  var $si80_exercicioprocesso = 0;
  var $si80_nroprocesso = null;
  var $si80_tipoprocesso = 0;
  var $si80_codorgao = null;
  var $si80_codunidadesub = null;
  var $si80_codfuncao = null;
  var $si80_codsubfuncao = null;
  var $si80_codprograma = null;
  var $si80_idacao = null;
  var $si80_idsubacao = null;
  var $si80_naturezadespesa = 0;
  var $si80_codfontrecursos = 0;
  var $si80_vlrecurso = 0;
  var $si80_mes = 0;
  var $si80_reg10 = 0;
  var $si80_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si80_sequencial = int8 = sequencial 
                 si80_tiporegistro = int8 = Tipo do registro 
                 si80_codorgaoresp = varchar(2) = Código do órgão responsável 
                 si80_codunidadesubresp = varchar(8) = Código da unidade 
                 si80_exercicioprocesso = int8 = Exercício em que foi instaurado 
                 si80_nroprocesso = varchar(12) = Número sequencial   do processo 
                 si80_tipoprocesso = int8 = Tipo de processo 
                 si80_codorgao = varchar(2) = Código do órgão 
                 si80_codunidadesub = varchar(8) = Código da unidade 
                 si80_codfuncao = varchar(2) = Código da função 
                 si80_codsubfuncao = varchar(3) = Código da  Subfunção 
                 si80_codprograma = varchar(4) = Código do   programa 
                 si80_idacao = varchar(4) = Código que  identifica a Ação 
                 si80_idsubacao = varchar(4) = Código que identifica a SubAção 
                 si80_naturezadespesa = int8 = Código da natureza da despesa 
                 si80_codfontrecursos = int8 = Código da fonte   de recursos 
                 si80_vlrecurso = float8 = Valor do recurso  previsto 
                 si80_mes = int8 = Mês 
                 si80_reg10 = int8 = reg10 
                 si80_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_dispensa162021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("dispensa162021");
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
      $this->si80_sequencial = ($this->si80_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_sequencial"] : $this->si80_sequencial);
      $this->si80_tiporegistro = ($this->si80_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_tiporegistro"] : $this->si80_tiporegistro);
      $this->si80_codorgaoresp = ($this->si80_codorgaoresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_codorgaoresp"] : $this->si80_codorgaoresp);
      $this->si80_codunidadesubresp = ($this->si80_codunidadesubresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_codunidadesubresp"] : $this->si80_codunidadesubresp);
      $this->si80_exercicioprocesso = ($this->si80_exercicioprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_exercicioprocesso"] : $this->si80_exercicioprocesso);
      $this->si80_nroprocesso = ($this->si80_nroprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_nroprocesso"] : $this->si80_nroprocesso);
      $this->si80_tipoprocesso = ($this->si80_tipoprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_tipoprocesso"] : $this->si80_tipoprocesso);
      $this->si80_codorgao = ($this->si80_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_codorgao"] : $this->si80_codorgao);
      $this->si80_codunidadesub = ($this->si80_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_codunidadesub"] : $this->si80_codunidadesub);
      $this->si80_codfuncao = ($this->si80_codfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_codfuncao"] : $this->si80_codfuncao);
      $this->si80_codsubfuncao = ($this->si80_codsubfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_codsubfuncao"] : $this->si80_codsubfuncao);
      $this->si80_codprograma = ($this->si80_codprograma == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_codprograma"] : $this->si80_codprograma);
      $this->si80_idacao = ($this->si80_idacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_idacao"] : $this->si80_idacao);
      $this->si80_idsubacao = ($this->si80_idsubacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_idsubacao"] : $this->si80_idsubacao);
      $this->si80_naturezadespesa = ($this->si80_naturezadespesa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_naturezadespesa"] : $this->si80_naturezadespesa);
      $this->si80_codfontrecursos = ($this->si80_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_codfontrecursos"] : $this->si80_codfontrecursos);
      $this->si80_vlrecurso = ($this->si80_vlrecurso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_vlrecurso"] : $this->si80_vlrecurso);
      $this->si80_mes = ($this->si80_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_mes"] : $this->si80_mes);
      $this->si80_reg10 = ($this->si80_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_reg10"] : $this->si80_reg10);
      $this->si80_instit = ($this->si80_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_instit"] : $this->si80_instit);
    } else {
      $this->si80_sequencial = ($this->si80_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si80_sequencial"] : $this->si80_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si80_sequencial)
  {
    $this->atualizacampos();
    if ($this->si80_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si80_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si80_exercicioprocesso == null) {
      $this->si80_exercicioprocesso = "0";
    }
    if ($this->si80_tipoprocesso == null) {
      $this->si80_tipoprocesso = "0";
    }
    if ($this->si80_naturezadespesa == null) {
      $this->si80_naturezadespesa = "0";
    }
    if ($this->si80_codfontrecursos == null) {
      $this->si80_codfontrecursos = "0";
    }
    if ($this->si80_vlrecurso == null) {
      $this->si80_vlrecurso = "0";
    }
    if ($this->si80_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si80_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si80_reg10 == null) {
      $this->si80_reg10 = "0";
    }
    if ($this->si80_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si80_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($si80_sequencial == "" || $si80_sequencial == null) {
      $result = db_query("select nextval('dispensa162021_si80_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: dispensa162021_si80_sequencial_seq do campo: si80_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si80_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from dispensa162021_si80_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si80_sequencial)) {
        $this->erro_sql = " Campo si80_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->si80_sequencial = $si80_sequencial;
      }
    }
    if (($this->si80_sequencial == null) || ($this->si80_sequencial == "")) {
      $this->erro_sql = " Campo si80_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into dispensa162021(
                                       si80_sequencial 
                                      ,si80_tiporegistro 
                                      ,si80_codorgaoresp 
                                      ,si80_codunidadesubresp 
                                      ,si80_exercicioprocesso 
                                      ,si80_nroprocesso 
                                      ,si80_tipoprocesso 
                                      ,si80_codorgao 
                                      ,si80_codunidadesub 
                                      ,si80_codfuncao 
                                      ,si80_codsubfuncao 
                                      ,si80_codprograma 
                                      ,si80_idacao 
                                      ,si80_idsubacao 
                                      ,si80_naturezadespesa 
                                      ,si80_codfontrecursos 
                                      ,si80_vlrecurso 
                                      ,si80_mes 
                                      ,si80_reg10 
                                      ,si80_instit 
                       )
                values (
                                $this->si80_sequencial 
                               ,$this->si80_tiporegistro 
                               ,'$this->si80_codorgaoresp' 
                               ,'$this->si80_codunidadesubresp' 
                               ,$this->si80_exercicioprocesso 
                               ,'$this->si80_nroprocesso' 
                               ,$this->si80_tipoprocesso 
                               ,'$this->si80_codorgao' 
                               ,'$this->si80_codunidadesub' 
                               ,'$this->si80_codfuncao' 
                               ,'$this->si80_codsubfuncao' 
                               ,'$this->si80_codprograma' 
                               ,'$this->si80_idacao' 
                               ,'$this->si80_idsubacao' 
                               ,$this->si80_naturezadespesa 
                               ,$this->si80_codfontrecursos 
                               ,$this->si80_vlrecurso 
                               ,$this->si80_mes 
                               ,$this->si80_reg10 
                               ,$this->si80_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "dispensa162021 ($this->si80_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "dispensa162021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "dispensa162021 ($this->si80_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si80_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si80_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010328,'$this->si80_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010309,2010328,'','" . AddSlashes(pg_result($resaco, 0, 'si80_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010329,'','" . AddSlashes(pg_result($resaco, 0, 'si80_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010330,'','" . AddSlashes(pg_result($resaco, 0, 'si80_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010331,'','" . AddSlashes(pg_result($resaco, 0, 'si80_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010332,'','" . AddSlashes(pg_result($resaco, 0, 'si80_exercicioprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010333,'','" . AddSlashes(pg_result($resaco, 0, 'si80_nroprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010334,'','" . AddSlashes(pg_result($resaco, 0, 'si80_tipoprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010335,'','" . AddSlashes(pg_result($resaco, 0, 'si80_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010336,'','" . AddSlashes(pg_result($resaco, 0, 'si80_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010337,'','" . AddSlashes(pg_result($resaco, 0, 'si80_codfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010338,'','" . AddSlashes(pg_result($resaco, 0, 'si80_codsubfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010339,'','" . AddSlashes(pg_result($resaco, 0, 'si80_codprograma')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010340,'','" . AddSlashes(pg_result($resaco, 0, 'si80_idacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010341,'','" . AddSlashes(pg_result($resaco, 0, 'si80_idsubacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010342,'','" . AddSlashes(pg_result($resaco, 0, 'si80_naturezadespesa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010343,'','" . AddSlashes(pg_result($resaco, 0, 'si80_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010344,'','" . AddSlashes(pg_result($resaco, 0, 'si80_vlrecurso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010345,'','" . AddSlashes(pg_result($resaco, 0, 'si80_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2010346,'','" . AddSlashes(pg_result($resaco, 0, 'si80_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010309,2011593,'','" . AddSlashes(pg_result($resaco, 0, 'si80_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    return true;
  }
  
  // funcao para alteracao
  function alterar($si80_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update dispensa162021 set ";
    $virgula = "";
    if (trim($this->si80_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_sequencial"])) {
      if (trim($this->si80_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si80_sequencial"])) {
        $this->si80_sequencial = "0";
      }
      $sql .= $virgula . " si80_sequencial = $this->si80_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si80_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_tiporegistro"])) {
      $sql .= $virgula . " si80_tiporegistro = $this->si80_tiporegistro ";
      $virgula = ",";
      if (trim($this->si80_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si80_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si80_codorgaoresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_codorgaoresp"])) {
      $sql .= $virgula . " si80_codorgaoresp = '$this->si80_codorgaoresp' ";
      $virgula = ",";
    }
    if (trim($this->si80_codunidadesubresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_codunidadesubresp"])) {
      $sql .= $virgula . " si80_codunidadesubresp = '$this->si80_codunidadesubresp' ";
      $virgula = ",";
    }
    if (trim($this->si80_exercicioprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_exercicioprocesso"])) {
      if (trim($this->si80_exercicioprocesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si80_exercicioprocesso"])) {
        $this->si80_exercicioprocesso = "0";
      }
      $sql .= $virgula . " si80_exercicioprocesso = $this->si80_exercicioprocesso ";
      $virgula = ",";
    }
    if (trim($this->si80_nroprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_nroprocesso"])) {
      $sql .= $virgula . " si80_nroprocesso = '$this->si80_nroprocesso' ";
      $virgula = ",";
    }
    if (trim($this->si80_tipoprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_tipoprocesso"])) {
      if (trim($this->si80_tipoprocesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si80_tipoprocesso"])) {
        $this->si80_tipoprocesso = "0";
      }
      $sql .= $virgula . " si80_tipoprocesso = $this->si80_tipoprocesso ";
      $virgula = ",";
    }
    if (trim($this->si80_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_codorgao"])) {
      $sql .= $virgula . " si80_codorgao = '$this->si80_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si80_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_codunidadesub"])) {
      $sql .= $virgula . " si80_codunidadesub = '$this->si80_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si80_codfuncao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_codfuncao"])) {
      $sql .= $virgula . " si80_codfuncao = '$this->si80_codfuncao' ";
      $virgula = ",";
    }
    if (trim($this->si80_codsubfuncao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_codsubfuncao"])) {
      $sql .= $virgula . " si80_codsubfuncao = '$this->si80_codsubfuncao' ";
      $virgula = ",";
    }
    if (trim($this->si80_codprograma) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_codprograma"])) {
      $sql .= $virgula . " si80_codprograma = '$this->si80_codprograma' ";
      $virgula = ",";
    }
    if (trim($this->si80_idacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_idacao"])) {
      $sql .= $virgula . " si80_idacao = '$this->si80_idacao' ";
      $virgula = ",";
    }
    if (trim($this->si80_idsubacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_idsubacao"])) {
      $sql .= $virgula . " si80_idsubacao = '$this->si80_idsubacao' ";
      $virgula = ",";
    }
    if (trim($this->si80_naturezadespesa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_naturezadespesa"])) {
      if (trim($this->si80_naturezadespesa) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si80_naturezadespesa"])) {
        $this->si80_naturezadespesa = "0";
      }
      $sql .= $virgula . " si80_naturezadespesa = $this->si80_naturezadespesa ";
      $virgula = ",";
    }
    if (trim($this->si80_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_codfontrecursos"])) {
      if (trim($this->si80_codfontrecursos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si80_codfontrecursos"])) {
        $this->si80_codfontrecursos = "0";
      }
      $sql .= $virgula . " si80_codfontrecursos = $this->si80_codfontrecursos ";
      $virgula = ",";
    }
    if (trim($this->si80_vlrecurso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_vlrecurso"])) {
      if (trim($this->si80_vlrecurso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si80_vlrecurso"])) {
        $this->si80_vlrecurso = "0";
      }
      $sql .= $virgula . " si80_vlrecurso = $this->si80_vlrecurso ";
      $virgula = ",";
    }
    if (trim($this->si80_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_mes"])) {
      $sql .= $virgula . " si80_mes = $this->si80_mes ";
      $virgula = ",";
      if (trim($this->si80_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si80_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si80_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_reg10"])) {
      if (trim($this->si80_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si80_reg10"])) {
        $this->si80_reg10 = "0";
      }
      $sql .= $virgula . " si80_reg10 = $this->si80_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si80_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si80_instit"])) {
      $sql .= $virgula . " si80_instit = $this->si80_instit ";
      $virgula = ",";
      if (trim($this->si80_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si80_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($si80_sequencial != null) {
      $sql .= " si80_sequencial = $this->si80_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si80_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010328,'$this->si80_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_sequencial"]) || $this->si80_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010328,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_sequencial')) . "','$this->si80_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_tiporegistro"]) || $this->si80_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010329,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_tiporegistro')) . "','$this->si80_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_codorgaoresp"]) || $this->si80_codorgaoresp != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010330,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_codorgaoresp')) . "','$this->si80_codorgaoresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_codunidadesubresp"]) || $this->si80_codunidadesubresp != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010331,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_codunidadesubresp')) . "','$this->si80_codunidadesubresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_exercicioprocesso"]) || $this->si80_exercicioprocesso != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010332,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_exercicioprocesso')) . "','$this->si80_exercicioprocesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_nroprocesso"]) || $this->si80_nroprocesso != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010333,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_nroprocesso')) . "','$this->si80_nroprocesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_tipoprocesso"]) || $this->si80_tipoprocesso != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010334,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_tipoprocesso')) . "','$this->si80_tipoprocesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_codorgao"]) || $this->si80_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010335,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_codorgao')) . "','$this->si80_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_codunidadesub"]) || $this->si80_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010336,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_codunidadesub')) . "','$this->si80_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_codfuncao"]) || $this->si80_codfuncao != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010337,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_codfuncao')) . "','$this->si80_codfuncao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_codsubfuncao"]) || $this->si80_codsubfuncao != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010338,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_codsubfuncao')) . "','$this->si80_codsubfuncao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_codprograma"]) || $this->si80_codprograma != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010339,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_codprograma')) . "','$this->si80_codprograma'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_idacao"]) || $this->si80_idacao != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010340,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_idacao')) . "','$this->si80_idacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_idsubacao"]) || $this->si80_idsubacao != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010341,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_idsubacao')) . "','$this->si80_idsubacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_naturezadespesa"]) || $this->si80_naturezadespesa != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010342,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_naturezadespesa')) . "','$this->si80_naturezadespesa'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_codfontrecursos"]) || $this->si80_codfontrecursos != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010343,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_codfontrecursos')) . "','$this->si80_codfontrecursos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_vlrecurso"]) || $this->si80_vlrecurso != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010344,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_vlrecurso')) . "','$this->si80_vlrecurso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_mes"]) || $this->si80_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010345,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_mes')) . "','$this->si80_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_reg10"]) || $this->si80_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2010346,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_reg10')) . "','$this->si80_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si80_instit"]) || $this->si80_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010309,2011593,'" . AddSlashes(pg_result($resaco, $conresaco, 'si80_instit')) . "','$this->si80_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "dispensa162021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si80_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "dispensa162021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si80_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si80_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si80_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si80_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010328,'$si80_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010309,2010328,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010329,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010330,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010331,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010332,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_exercicioprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010333,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_nroprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010334,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_tipoprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010335,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010336,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010337,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_codfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010338,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_codsubfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010339,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_codprograma')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010340,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_idacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010341,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_idsubacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010342,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_naturezadespesa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010343,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010344,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_vlrecurso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010345,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2010346,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010309,2011593,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si80_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from dispensa162021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si80_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si80_sequencial = $si80_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "dispensa162021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si80_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "dispensa162021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si80_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si80_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:dispensa162021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  
  // funcao do sql
  function sql_query($si80_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from dispensa162021 ";
    $sql .= "      left  join dispensa102020  on  dispensa102020.si74_sequencial = dispensa162021.si80_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si80_sequencial != null) {
        $sql2 .= " where dispensa162021.si80_sequencial = $si80_sequencial ";
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
  function sql_query_file($si80_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from dispensa162021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si80_sequencial != null) {
        $sql2 .= " where dispensa162021.si80_sequencial = $si80_sequencial ";
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
