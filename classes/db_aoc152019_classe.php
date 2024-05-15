<?php
	/**
	 * Created by PhpStorm.
	 * User: contass
	 * Date: 22/01/19
	 * Time: 17:54
	 */

//MODULO: sicom
//CLASSE DA ENTIDADE aoc152019
class cl_aoc152019
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
  var $si194_sequencial = 0;
  var $si194_tiporegistro = 0;
  var $si194_codreduzidodecreto = 0;
  var $si194_origemrecalteracao = "";
  var $si194_codorigem = 0;
  var $si194_codorgao = null;
  var $si194_codunidadesub = null;
  var $si194_codfuncao = null;
  var $si194_codsubfuncao = null;
  var $si194_codprograma = null;
  var $si194_idacao = null;
  var $si194_idsubacao = null;
  var $si194_naturezadespesa = 0;
  var $si194_codfontrecursos = 0;
  var $si194_vlreducao = 0;
  var $si194_mes = 0;
  var $si194_reg10 = 0;
  var $si194_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si194_sequencial = int8 = sequencial 
                 si194_tiporegistro = int8 = Tipo do registro 
                 si194_codreduzidodecreto = int8 = Código do decreto
                 si194_origemrecalteracao = varchar(2) = Origem do recurso  
                 si194_codorigem = int8 = Código da Origem
                 si194_codorgao = varchar(2) = Código do órgão 
                 si194_codunidadesub = varchar(8) = Código da unidade 
                 si194_codfuncao = varchar(2) = Código da função 
                 si194_codsubfuncao = varchar(3) = Código da   Subfunção 
                 si194_codprograma = varchar(4) = Código do   programa 
                 si194_idacao = varchar(4) = Código que  identifica 
                 si194_idsubacao = varchar(4) = Identifica a Sub ação 
                 si194_naturezadespesa = int8 = Natureza de  Despesa 
                 si194_codfontrecursos = int8 = Código da fonte de recursos 
                 si194_vlreducao = float8 = Valor do acréscimo   ou redução 
                 si194_mes = int8 = Mês 
                 si194_reg10 = int8 = reg10 
                 si194_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_aoc152019()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("aoc152019");
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
      $this->si194_sequencial = ($this->si194_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_sequencial"] : $this->si194_sequencial);
      $this->si194_tiporegistro = ($this->si194_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_tiporegistro"] : $this->si194_tiporegistro);
      $this->si194_codreduzidodecreto = ($this->si194_codreduzidodecreto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_codreduzidodecreto"] : $this->si194_codreduzidodecreto);
      $this->si194_codorigem = ($this->si194_codorigem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_codorigem"] : $this->si194_codorigem);
      $this->si194_codorgao = ($this->si194_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_codorgao"] : $this->si194_codorgao);
      $this->si194_codunidadesub = ($this->si194_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_codunidadesub"] : $this->si194_codunidadesub);
      $this->si194_codfuncao = ($this->si194_codfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_codfuncao"] : $this->si194_codfuncao);
      $this->si194_codsubfuncao = ($this->si194_codsubfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_codsubfuncao"] : $this->si194_codsubfuncao);
      $this->si194_codprograma = ($this->si194_codprograma == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_codprograma"] : $this->si194_codprograma);
      $this->si194_idacao = ($this->si194_idacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_idacao"] : $this->si194_idacao);
      $this->si194_idsubacao = ($this->si194_idsubacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_idsubacao"] : $this->si194_idsubacao);
      $this->si194_naturezadespesa = ($this->si194_naturezadespesa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_naturezadespesa"] : $this->si194_naturezadespesa);
      $this->si194_codfontrecursos = ($this->si194_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_codfontrecursos"] : $this->si194_codfontrecursos);
      $this->si194_vlreducao = ($this->si194_vlreducao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_vlreducao"] : $this->si194_vlreducao);
      $this->si194_mes = ($this->si194_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_mes"] : $this->si194_mes);
      $this->si194_reg10 = ($this->si194_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_reg10"] : $this->si194_reg10);
      $this->si194_instit = ($this->si194_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_instit"] : $this->si194_instit);
    } else {
      $this->si194_sequencial = ($this->si194_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si194_sequencial"] : $this->si194_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si194_sequencial)
  {
    $this->atualizacampos();
    if ($this->si194_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si194_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si194_codreduzidodecreto == null) {
      $this->si194_codreduzidodecreto = "0";
    }
    if ($this->si194_origemrecalteracao == null) {
      $this->si194_origemrecalteracao = "0";
    }
    if ($this->si194_codorigem == null) {
      $this->si194_codorigem = "0";
    }
    if ($this->si194_naturezadespesa == null) {
      $this->si194_naturezadespesa = "0";
    }
    if ($this->si194_codfontrecursos == null) {
      $this->si194_codfontrecursos = "0";
    }
    if ($this->si194_vlreducao == null) {
      $this->si194_vlreducao = "0";
    }
    if ($this->si194_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si194_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si194_reg10 == null) {
      $this->si194_reg10 = "0";
    }
    if ($this->si194_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si194_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si194_sequencial == "" || $si194_sequencial == null) {
      $result = db_query("select nextval('aoc152019_si194_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: aoc152019_si194_sequencial_seq do campo: si194_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si194_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from aoc152019_si194_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si194_sequencial)) {
        $this->erro_sql = " Campo si194_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si194_sequencial = $si194_sequencial;
      }
    }
    if (($this->si194_sequencial == null) || ($this->si194_sequencial == "")) {
      $this->erro_sql = " Campo si194_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into aoc152019(
                                       si194_sequencial 
                                      ,si194_tiporegistro 
                                      ,si194_codreduzidodecreto 
                                      ,si194_origemrecalteracao
                                      ,si194_codorigem 
                                      ,si194_codorgao 
                                      ,si194_codunidadesub 
                                      ,si194_codfuncao 
                                      ,si194_codsubfuncao 
                                      ,si194_codprograma 
                                      ,si194_idacao 
                                      ,si194_idsubacao 
                                      ,si194_naturezadespesa 
                                      ,si194_codfontrecursos 
                                      ,si194_vlreducao 
                                      ,si194_mes 
                                      ,si194_reg10 
                                      ,si194_instit 
                       )
                values (
                                $this->si194_sequencial 
                               ,$this->si194_tiporegistro 
                               ,$this->si194_codreduzidodecreto 
                               ,$this->si194_origemrecalteracao
                               ,$this->si194_codorigem 
                               ,'$this->si194_codorgao' 
                               ,'$this->si194_codunidadesub' 
                               ,'$this->si194_codfuncao' 
                               ,'$this->si194_codsubfuncao' 
                               ,'$this->si194_codprograma' 
                               ,'$this->si194_idacao' 
                               ,'$this->si194_idsubacao' 
                               ,$this->si194_naturezadespesa 
                               ,$this->si194_codfontrecursos 
                               ,$this->si194_vlreducao 
                               ,$this->si194_mes 
                               ,$this->si194_reg10 
                               ,$this->si194_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "aoc152019 ($this->si194_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "aoc152019 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "aoc152019 ($this->si194_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si194_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si194_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009807,'$this->si194_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010271,2009807,'','" . AddSlashes(pg_result($resaco, 0, 'si194_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009808,'','" . AddSlashes(pg_result($resaco, 0, 'si194_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009809,'','" . AddSlashes(pg_result($resaco, 0, 'si194_codreduzidodecreto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009810,'','" . AddSlashes(pg_result($resaco, 0, 'si194_codorigem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009811,'','" . AddSlashes(pg_result($resaco, 0, 'si194_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009812,'','" . AddSlashes(pg_result($resaco, 0, 'si194_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009813,'','" . AddSlashes(pg_result($resaco, 0, 'si194_codfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009814,'','" . AddSlashes(pg_result($resaco, 0, 'si194_codsubfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009815,'','" . AddSlashes(pg_result($resaco, 0, 'si194_codprograma')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009816,'','" . AddSlashes(pg_result($resaco, 0, 'si194_idacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009817,'','" . AddSlashes(pg_result($resaco, 0, 'si194_idsubacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009818,'','" . AddSlashes(pg_result($resaco, 0, 'si194_naturezadespesa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009819,'','" . AddSlashes(pg_result($resaco, 0, 'si194_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009820,'','" . AddSlashes(pg_result($resaco, 0, 'si194_vlreducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009821,'','" . AddSlashes(pg_result($resaco, 0, 'si194_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2009831,'','" . AddSlashes(pg_result($resaco, 0, 'si194_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010271,2011556,'','" . AddSlashes(pg_result($resaco, 0, 'si194_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si194_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update aoc152019 set ";
    $virgula = "";
    if (trim($this->si194_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_sequencial"])) {
      if (trim($this->si194_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si194_sequencial"])) {
        $this->si194_sequencial = "0";
      }
      $sql .= $virgula . " si194_sequencial = $this->si194_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si194_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_tiporegistro"])) {
      $sql .= $virgula . " si194_tiporegistro = $this->si194_tiporegistro ";
      $virgula = ",";
      if (trim($this->si194_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si194_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si194_codreduzidodecreto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_codreduzidodecreto"])) {
      if (trim($this->si194_codreduzidodecreto) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si194_codreduzidodecreto"])) {
        $this->si194_codreduzidodecreto = "0";
      }
      $sql .= $virgula . " si194_codreduzidodecreto = $this->si194_codreduzidodecreto ";
      $virgula = ",";
    }
    if (trim($this->si194_codorigem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_codorigem"])) {
      if (trim($this->si194_codorigem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si194_codorigem"])) {
        $this->si194_codorigem = "0";
      }
      $sql .= $virgula . " si194_codorigem = $this->si194_codorigem ";
      $virgula = ",";
    }
    if (trim($this->si194_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_codorgao"])) {
      $sql .= $virgula . " si194_codorgao = '$this->si194_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si194_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_codunidadesub"])) {
      $sql .= $virgula . " si194_codunidadesub = '$this->si194_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si194_codfuncao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_codfuncao"])) {
      $sql .= $virgula . " si194_codfuncao = '$this->si194_codfuncao' ";
      $virgula = ",";
    }
    if (trim($this->si194_codsubfuncao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_codsubfuncao"])) {
      $sql .= $virgula . " si194_codsubfuncao = '$this->si194_codsubfuncao' ";
      $virgula = ",";
    }
    if (trim($this->si194_codprograma) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_codprograma"])) {
      $sql .= $virgula . " si194_codprograma = '$this->si194_codprograma' ";
      $virgula = ",";
    }
    if (trim($this->si194_idacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_idacao"])) {
      $sql .= $virgula . " si194_idacao = '$this->si194_idacao' ";
      $virgula = ",";
    }
    if (trim($this->si194_idsubacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_idsubacao"])) {
      $sql .= $virgula . " si194_idsubacao = '$this->si194_idsubacao' ";
      $virgula = ",";
    }
    if (trim($this->si194_naturezadespesa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_naturezadespesa"])) {
      if (trim($this->si194_naturezadespesa) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si194_naturezadespesa"])) {
        $this->si194_naturezadespesa = "0";
      }
      $sql .= $virgula . " si194_naturezadespesa = $this->si194_naturezadespesa ";
      $virgula = ",";
    }
    if (trim($this->si194_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_codfontrecursos"])) {
      if (trim($this->si194_codfontrecursos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si194_codfontrecursos"])) {
        $this->si194_codfontrecursos = "0";
      }
      $sql .= $virgula . " si194_codfontrecursos = $this->si194_codfontrecursos ";
      $virgula = ",";
    }
    if (trim($this->si194_vlreducao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_vlreducao"])) {
      if (trim($this->si194_vlreducao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si194_vlreducao"])) {
        $this->si194_vlreducao = "0";
      }
      $sql .= $virgula . " si194_vlreducao = $this->si194_vlreducao ";
      $virgula = ",";
    }
    if (trim($this->si194_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_mes"])) {
      $sql .= $virgula . " si194_mes = $this->si194_mes ";
      $virgula = ",";
      if (trim($this->si194_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si194_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si194_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_reg10"])) {
      if (trim($this->si194_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si194_reg10"])) {
        $this->si194_reg10 = "0";
      }
      $sql .= $virgula . " si194_reg10 = $this->si194_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si194_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si194_instit"])) {
      $sql .= $virgula . " si194_instit = $this->si194_instit ";
      $virgula = ",";
      if (trim($this->si194_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si194_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si194_sequencial != null) {
      $sql .= " si194_sequencial = $this->si194_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si194_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009807,'$this->si194_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_sequencial"]) || $this->si194_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009807,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_sequencial')) . "','$this->si194_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_tiporegistro"]) || $this->si194_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009808,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_tiporegistro')) . "','$this->si194_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_codreduzidodecreto"]) || $this->si194_codreduzidodecreto != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009809,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_codreduzidodecreto')) . "','$this->si194_codreduzidodecreto'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_codorigem"]) || $this->si194_codorigem != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009810,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_codorigem')) . "','$this->si194_codorigem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_codorgao"]) || $this->si194_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009811,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_codorgao')) . "','$this->si194_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_codunidadesub"]) || $this->si194_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009812,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_codunidadesub')) . "','$this->si194_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_codfuncao"]) || $this->si194_codfuncao != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009813,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_codfuncao')) . "','$this->si194_codfuncao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_codsubfuncao"]) || $this->si194_codsubfuncao != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009814,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_codsubfuncao')) . "','$this->si194_codsubfuncao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_codprograma"]) || $this->si194_codprograma != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009815,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_codprograma')) . "','$this->si194_codprograma'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_idacao"]) || $this->si194_idacao != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009816,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_idacao')) . "','$this->si194_idacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_idsubacao"]) || $this->si194_idsubacao != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009817,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_idsubacao')) . "','$this->si194_idsubacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_naturezadespesa"]) || $this->si194_naturezadespesa != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009818,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_naturezadespesa')) . "','$this->si194_naturezadespesa'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_codfontrecursos"]) || $this->si194_codfontrecursos != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009819,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_codfontrecursos')) . "','$this->si194_codfontrecursos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_vlreducao"]) || $this->si194_vlreducao != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009820,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_vlreducao')) . "','$this->si194_vlreducao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_mes"]) || $this->si194_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009821,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_mes')) . "','$this->si194_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_reg10"]) || $this->si194_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2009831,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_reg10')) . "','$this->si194_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si194_instit"]) || $this->si194_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010271,2011556,'" . AddSlashes(pg_result($resaco, $conresaco, 'si194_instit')) . "','$this->si194_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aoc152019 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si194_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aoc152019 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si194_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si194_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si194_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si194_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009807,'$si194_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010271,2009807,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009808,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009809,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_codreduzidodecreto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009810,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_codorigem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009811,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009812,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009813,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_codfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009814,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_codsubfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009815,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_codprograma')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009816,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_idacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009817,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_idsubacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009818,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_naturezadespesa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009819,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009820,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_vlreducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009821,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2009831,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010271,2011556,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si194_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from aoc152019
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si194_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si194_sequencial = $si194_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aoc152019 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si194_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aoc152019 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si194_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si194_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:aoc152019";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si194_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aoc152019 ";
    $sql .= "      left  join aoc102019  on  aoc102019.si38_sequencial = aoc152019.si194_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si194_sequencial != null) {
        $sql2 .= " where aoc152019.si194_sequencial = $si194_sequencial ";
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
  function sql_query_file($si194_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aoc152019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si194_sequencial != null) {
        $sql2 .= " where aoc152019.si194_sequencial = $si194_sequencial ";
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
