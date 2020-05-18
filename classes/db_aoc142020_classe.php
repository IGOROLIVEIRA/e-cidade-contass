<?
//MODULO: sicom
//CLASSE DA ENTIDADE aoc142020
class cl_aoc142020
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
  var $si42_sequencial = 0;
  var $si42_tiporegistro = 0;
  var $si42_codreduzidodecreto = 0;
  var $si42_origemrecalteracao = "";
  var $si42_codorigem = null;
  var $si42_codorgao = null;
  var $si42_codunidadesub = null;
  var $si42_codfuncao = null;
  var $si42_codsubfuncao = null;
  var $si42_codprograma = null;
  var $si42_idacao = null;
  var $si42_idsubacao = null;
  var $si42_naturezadespesa = 0;
  var $si42_codfontrecursos = 0;
  var $si42_vlacrescimo = 0;
  var $si42_mes = 0;
  var $si42_reg10 = 0;
  var $si42_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si42_sequencial = int8 = sequencial 
                 si42_tiporegistro = int8 = Tipo do registro 
                 si42_codreduzidodecreto = int8 = Código do decreto
                 si42_origemrecalteracao = varchar(2) = Origem do recurso  
                 si42_codorigem = int8 = Código da Origem
                 si42_codorgao = varchar(2) = Código do órgão 
                 si42_codunidadesub = varchar(8) = Código da unidade 
                 si42_codfuncao = varchar(2) = Código da função 
                 si42_codsubfuncao = varchar(3) = Código da   Subfunção 
                 si42_codprograma = varchar(4) = Código do   programa 
                 si42_idacao = varchar(4) = Código que  identifica 
                 si42_idsubacao = varchar(4) = Identifica a Sub ação 
                 si42_naturezadespesa = int8 = Natureza de  Despesa 
                 si42_codfontrecursos = int8 = Código da fonte de recursos 
                 si42_vlacrescimo = float8 = Valor do acréscimo   ou redução 
                 si42_mes = int8 = Mês 
                 si42_reg10 = int8 = reg10 
                 si42_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_aoc142020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("aoc142020");
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
      $this->si42_sequencial = ($this->si42_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_sequencial"] : $this->si42_sequencial);
      $this->si42_tiporegistro = ($this->si42_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_tiporegistro"] : $this->si42_tiporegistro);
      $this->si42_codreduzidodecreto = ($this->si42_codreduzidodecreto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_codreduzidodecreto"] : $this->si42_codreduzidodecreto);
      $this->si42_codorigem = ($this->si42_codorigem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_codorigem"] : $this->si42_codorigem);
      $this->si42_codorgao = ($this->si42_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_codorgao"] : $this->si42_codorgao);
      $this->si42_codunidadesub = ($this->si42_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_codunidadesub"] : $this->si42_codunidadesub);
      $this->si42_codfuncao = ($this->si42_codfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_codfuncao"] : $this->si42_codfuncao);
      $this->si42_codsubfuncao = ($this->si42_codsubfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_codsubfuncao"] : $this->si42_codsubfuncao);
      $this->si42_codprograma = ($this->si42_codprograma == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_codprograma"] : $this->si42_codprograma);
      $this->si42_idacao = ($this->si42_idacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_idacao"] : $this->si42_idacao);
      $this->si42_idsubacao = ($this->si42_idsubacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_idsubacao"] : $this->si42_idsubacao);
      $this->si42_naturezadespesa = ($this->si42_naturezadespesa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_naturezadespesa"] : $this->si42_naturezadespesa);
      $this->si42_codfontrecursos = ($this->si42_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_codfontrecursos"] : $this->si42_codfontrecursos);
      $this->si42_vlacrescimo = ($this->si42_vlacrescimo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_vlacrescimo"] : $this->si42_vlacrescimo);
      $this->si42_mes = ($this->si42_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_mes"] : $this->si42_mes);
      $this->si42_reg10 = ($this->si42_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_reg10"] : $this->si42_reg10);
      $this->si42_instit = ($this->si42_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_instit"] : $this->si42_instit);
    } else {
      $this->si42_sequencial = ($this->si42_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si42_sequencial"] : $this->si42_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si42_sequencial)
  {
    $this->atualizacampos();
    if ($this->si42_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si42_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si42_codreduzidodecreto == null) {
      $this->si42_codreduzidodecreto = "0";
    }
    if ($this->si42_origemrecalteracao == null) {
      $this->si42_origemrecalteracao = " ";
    }
    if ($this->si42_codorigem == null) {
      $this->si42_codorigem = "0";
    }
    if ($this->si42_naturezadespesa == null) {
      $this->si42_naturezadespesa = "0";
    }
    if ($this->si42_codfontrecursos == null) {
      $this->si42_codfontrecursos = "0";
    }
    if ($this->si42_vlacrescimo == null) {
      $this->si42_vlacrescimo = "0";
    }
    if ($this->si42_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si42_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si42_reg10 == null) {
      $this->si42_reg10 = "0";
    }
    if ($this->si42_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si42_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si42_sequencial == "" || $si42_sequencial == null) {
      $result = db_query("select nextval('aoc142020_si42_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: aoc142020_si42_sequencial_seq do campo: si42_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si42_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from aoc142020_si42_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si42_sequencial)) {
        $this->erro_sql = " Campo si42_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si42_sequencial = $si42_sequencial;
      }
    }
    if (($this->si42_sequencial == null) || ($this->si42_sequencial == "")) {
      $this->erro_sql = " Campo si42_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into aoc142020(
                                       si42_sequencial 
                                      ,si42_tiporegistro 
                                      ,si42_codreduzidodecreto 
                                      ,si42_origemrecalteracao
                                      ,si42_codorigem 
                                      ,si42_codorgao 
                                      ,si42_codunidadesub 
                                      ,si42_codfuncao 
                                      ,si42_codsubfuncao 
                                      ,si42_codprograma 
                                      ,si42_idacao 
                                      ,si42_idsubacao 
                                      ,si42_naturezadespesa 
                                      ,si42_codfontrecursos 
                                      ,si42_vlacrescimo 
                                      ,si42_mes 
                                      ,si42_reg10 
                                      ,si42_instit 
                       )
                values (
                                $this->si42_sequencial 
                               ,$this->si42_tiporegistro 
                               ,$this->si42_codreduzidodecreto 
                               ,'$this->si42_origemrecalteracao'
                               ,$this->si42_codorigem
                               ,'$this->si42_codorgao' 
                               ,'$this->si42_codunidadesub' 
                               ,'$this->si42_codfuncao' 
                               ,'$this->si42_codsubfuncao' 
                               ,'$this->si42_codprograma' 
                               ,'$this->si42_idacao' 
                               ,'$this->si42_idsubacao' 
                               ,$this->si42_naturezadespesa 
                               ,$this->si42_codfontrecursos 
                               ,$this->si42_vlacrescimo 
                               ,$this->si42_mes 
                               ,$this->si42_reg10 
                               ,$this->si42_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "aoc142020 ($this->si42_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "aoc142020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "aoc142020 ($this->si42_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si42_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si42_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009807,'$this->si42_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010271,2009807,'','" . AddSlashes(pg_result($resaco, 0, 'si42_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009808,'','" . AddSlashes(pg_result($resaco, 0, 'si42_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009809,'','" . AddSlashes(pg_result($resaco, 0, 'si42_codreduzidodecreto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009810,'','" . AddSlashes(pg_result($resaco, 0, 'si42_codorigem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009811,'','" . AddSlashes(pg_result($resaco, 0, 'si42_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009812,'','" . AddSlashes(pg_result($resaco, 0, 'si42_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009813,'','" . AddSlashes(pg_result($resaco, 0, 'si42_codfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009814,'','" . AddSlashes(pg_result($resaco, 0, 'si42_codsubfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009815,'','" . AddSlashes(pg_result($resaco, 0, 'si42_codprograma')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009816,'','" . AddSlashes(pg_result($resaco, 0, 'si42_idacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009817,'','" . AddSlashes(pg_result($resaco, 0, 'si42_idsubacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009818,'','" . AddSlashes(pg_result($resaco, 0, 'si42_naturezadespesa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009819,'','" . AddSlashes(pg_result($resaco, 0, 'si42_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009820,'','" . AddSlashes(pg_result($resaco, 0, 'si42_vlacrescimo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009821,'','" . AddSlashes(pg_result($resaco, 0, 'si42_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009831,'','" . AddSlashes(pg_result($resaco, 0, 'si42_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2011556,'','" . AddSlashes(pg_result($resaco, 0, 'si42_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si42_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update aoc142020 set ";
    $virgula = "";
    if (trim($this->si42_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_sequencial"])) {
      if (trim($this->si42_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si42_sequencial"])) {
        $this->si42_sequencial = "0";
      }
      $sql .= $virgula . " si42_sequencial = $this->si42_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si42_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_tiporegistro"])) {
      $sql .= $virgula . " si42_tiporegistro = $this->si42_tiporegistro ";
      $virgula = ",";
      if (trim($this->si42_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si42_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si42_codreduzidodecreto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_codreduzidodecreto"])) {
      if (trim($this->si42_codreduzidodecreto) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si42_codreduzidodecreto"])) {
        $this->si42_codreduzidodecreto = "0";
      }
      $sql .= $virgula . " si42_codreduzidodecreto = $this->si42_codreduzidodecreto ";
      $virgula = ",";
    }
    if (trim($this->si42_codorigem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_codorigem"])) {
      if (trim($this->si42_codorigem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si42_codorigem"])) {
        $this->si42_codorigem = "0";
      }
      $sql .= $virgula . " si42_codorigem = $this->si42_codorigem ";
      $virgula = ",";
    }
    if (trim($this->si42_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_codorgao"])) {
      $sql .= $virgula . " si42_codorgao = '$this->si42_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si42_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_codunidadesub"])) {
      $sql .= $virgula . " si42_codunidadesub = '$this->si42_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si42_codfuncao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_codfuncao"])) {
      $sql .= $virgula . " si42_codfuncao = '$this->si42_codfuncao' ";
      $virgula = ",";
    }
    if (trim($this->si42_codsubfuncao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_codsubfuncao"])) {
      $sql .= $virgula . " si42_codsubfuncao = '$this->si42_codsubfuncao' ";
      $virgula = ",";
    }
    if (trim($this->si42_codprograma) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_codprograma"])) {
      $sql .= $virgula . " si42_codprograma = '$this->si42_codprograma' ";
      $virgula = ",";
    }
    if (trim($this->si42_idacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_idacao"])) {
      $sql .= $virgula . " si42_idacao = '$this->si42_idacao' ";
      $virgula = ",";
    }
    if (trim($this->si42_idsubacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_idsubacao"])) {
      $sql .= $virgula . " si42_idsubacao = '$this->si42_idsubacao' ";
      $virgula = ",";
    }
    if (trim($this->si42_naturezadespesa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_naturezadespesa"])) {
      if (trim($this->si42_naturezadespesa) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si42_naturezadespesa"])) {
        $this->si42_naturezadespesa = "0";
      }
      $sql .= $virgula . " si42_naturezadespesa = $this->si42_naturezadespesa ";
      $virgula = ",";
    }
    if (trim($this->si42_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_codfontrecursos"])) {
      if (trim($this->si42_codfontrecursos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si42_codfontrecursos"])) {
        $this->si42_codfontrecursos = "0";
      }
      $sql .= $virgula . " si42_codfontrecursos = $this->si42_codfontrecursos ";
      $virgula = ",";
    }
    if (trim($this->si42_vlacrescimo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_vlacrescimo"])) {
      if (trim($this->si42_vlacrescimo) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si42_vlacrescimo"])) {
        $this->si42_vlacrescimo = "0";
      }
      $sql .= $virgula . " si42_vlacrescimo = $this->si42_vlacrescimo ";
      $virgula = ",";
    }
    if (trim($this->si42_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_mes"])) {
      $sql .= $virgula . " si42_mes = $this->si42_mes ";
      $virgula = ",";
      if (trim($this->si42_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si42_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si42_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_reg10"])) {
      if (trim($this->si42_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si42_reg10"])) {
        $this->si42_reg10 = "0";
      }
      $sql .= $virgula . " si42_reg10 = $this->si42_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si42_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si42_instit"])) {
      $sql .= $virgula . " si42_instit = $this->si42_instit ";
      $virgula = ",";
      if (trim($this->si42_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si42_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si42_sequencial != null) {
      $sql .= " si42_sequencial = $this->si42_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si42_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009807,'$this->si42_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_sequencial"]) || $this->si42_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009807,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_sequencial')) . "','$this->si42_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_tiporegistro"]) || $this->si42_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009808,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_tiporegistro')) . "','$this->si42_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_codreduzidodecreto"]) || $this->si42_codreduzidodecreto != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009809,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_codreduzidodecreto')) . "','$this->si42_codreduzidodecreto'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_codorigem"]) || $this->si42_codorigem != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009810,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_codorigem')) . "','$this->si42_codorigem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_codorgao"]) || $this->si42_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009811,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_codorgao')) . "','$this->si42_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_codunidadesub"]) || $this->si42_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009812,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_codunidadesub')) . "','$this->si42_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_codfuncao"]) || $this->si42_codfuncao != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009813,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_codfuncao')) . "','$this->si42_codfuncao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_codsubfuncao"]) || $this->si42_codsubfuncao != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009814,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_codsubfuncao')) . "','$this->si42_codsubfuncao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_codprograma"]) || $this->si42_codprograma != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009815,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_codprograma')) . "','$this->si42_codprograma'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_idacao"]) || $this->si42_idacao != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009816,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_idacao')) . "','$this->si42_idacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_idsubacao"]) || $this->si42_idsubacao != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009817,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_idsubacao')) . "','$this->si42_idsubacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_naturezadespesa"]) || $this->si42_naturezadespesa != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009818,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_naturezadespesa')) . "','$this->si42_naturezadespesa'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_codfontrecursos"]) || $this->si42_codfontrecursos != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009819,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_codfontrecursos')) . "','$this->si42_codfontrecursos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_vlacrescimo"]) || $this->si42_vlacrescimo != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009820,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_vlacrescimo')) . "','$this->si42_vlacrescimo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_mes"]) || $this->si42_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009821,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_mes')) . "','$this->si42_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_reg10"]) || $this->si42_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009831,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_reg10')) . "','$this->si42_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si42_instit"]) || $this->si42_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2011556,'" . AddSlashes(pg_result($resaco, $conresaco, 'si42_instit')) . "','$this->si42_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aoc142020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si42_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aoc142020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si42_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si42_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si42_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si42_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009807,'$si42_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010271,2009807,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009808,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009809,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_codreduzidodecreto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009810,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_codorigem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009811,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009812,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009813,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_codfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009814,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_codsubfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009815,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_codprograma')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009816,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_idacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009817,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_idsubacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009818,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_naturezadespesa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009819,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009820,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_vlacrescimo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009821,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009831,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2011556,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si42_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from aoc142020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si42_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si42_sequencial = $si42_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aoc142020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si42_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aoc142020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si42_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si42_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:aoc142020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si42_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aoc142020 ";
    $sql .= "      left  join aoc102020  on  aoc102020.si38_sequencial = aoc142020.si42_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si42_sequencial != null) {
        $sql2 .= " where aoc142020.si42_sequencial = $si42_sequencial ";
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
  function sql_query_file($si42_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aoc142020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si42_sequencial != null) {
        $sql2 .= " where aoc142020.si42_sequencial = $si42_sequencial ";
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
