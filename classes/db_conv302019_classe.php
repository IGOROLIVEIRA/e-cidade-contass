<?php
/**
* Created by PhpStorm.
* User: contass
* Date: 24/01/19
* Time: 13:40
*/

//MODULO: sicom
//CLASSE DA ENTIDADE conv302019
class cl_conv302019
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
  var $si203_sequencial = 0;
  var $si203_tiporegistro = 0;
  var $si203_codreceita = null;
  var $si203_codorgao = null;
  var $si203_naturezareceita = null;
  var $si203_codfontrecursos = null;
  var $si203_vlprevisao = 0;
  var $si203_mes = 0;
  var $si203_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si203_sequencial = int8 = sequencial 
                 si203_tiporegistro = int8 = Tipo do  registro 
                 si203_codreceita = int8 = Código da receita 
                 si203_codorgao = varchar(2) = Código do órgão
                 si203_naturezareceita = int8 = Naturez da receita 
                 si203_codfontrecursos = int8 = Código da fonte
                 si203_vlprevisao = float8 = Valor da previsão 
                 si203_mes = int8 = Mês 
                 si203_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_conv302019()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("conv302019");
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
      $this->si203_sequencial = ($this->si203_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si203_sequencial"] : $this->si203_sequencial);
      $this->si203_tiporegistro = ($this->si203_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si203_tiporegistro"] : $this->si203_tiporegistro);
      $this->si203_codreceita = ($this->si203_codreceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si203_codreceita"] : $this->si203_codreceita);
      $this->si203_codorgao = ($this->si203_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si203_codorgao"] : $this->si203_codorgao);
      $this->si203_naturezareceita = ($this->si203_naturezareceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si203_naturezareceita"] : $this->si203_naturezareceita);
      $this->si203_codfontrecursos = ($this->si203_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si203_codfontrecursos"] : $this->si203_codfontrecursos);
      $this->si203_vlprevisao = ($this->si203_vlprevisao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si203_vlprevisao"] : $this->si203_vlprevisao);
      $this->si203_mes = ($this->si203_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si203_mes"] : $this->si203_mes);
      $this->si203_instit = ($this->si203_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si203_instit"] : $this->si203_instit);
    } else {
      $this->si203_sequencial = ($this->si203_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si203_sequencial"] : $this->si203_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si203_sequencial)
  {
    $this->atualizacampos();
    if ($this->si203_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si203_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
	if ($this->si203_codreceita == null) {
		$this->si203_codreceita = "null";
	}
	if ($this->si203_codorgao == null) {
		$this->si203_codorgao = "null";
	}
	if ($this->si203_naturezareceita == null) {
    	$this->si203_naturezareceita = "null";
    }
    if ($this->si203_codfontrecursos == null) {
    	$this->si203_codfontrecursos = "0";
    }
    if ($this->si203_vlprevisao == null) {
    	$this->si203_vlprevisao = "0";
    }
    if ($this->si203_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si203_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si203_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si203_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si203_sequencial == "" || $si203_sequencial == null) {
      $result = db_query("select nextval('conv302019_si203_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: conv302019_si203_sequencial_seq do campo: si203_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si203_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from conv302019_si203_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si203_sequencial)) {
        $this->erro_sql = " Campo si203_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si203_sequencial = $si203_sequencial;
      }
    }
    if (($this->si203_sequencial == null) || ($this->si203_sequencial == "")) {
      $this->erro_sql = " Campo si203_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into conv302019(
                               si203_sequencial 
                               ,si203_tiporegistro
                               ,si203_codreceita 
                               ,si203_codorgao
                               ,si203_naturezareceita 
                               ,si203_codfontrecursos 
                               ,si203_vlprevisao 
                               ,si203_mes 
                               ,si203_instit 
                       )
                values (
                                $this->si203_sequencial 
                               ,$this->si203_tiporegistro
                               ,$this->si203_codreceita 
                               ,'$this->si203_codorgao'
                               ,$this->si203_naturezareceita 
                               ,$this->si203_codfontrecursos 
                               ,$this->si203_vlprevisao 
                               ,$this->si203_mes 
                               ,$this->si203_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "conv302019 ($this->si203_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "conv302019 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "conv302019 ($this->si203_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si203_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si203_sequencial));
//    if (($resaco != false) || ($this->numrows != 0)) {
//      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//      $acount = pg_result($resac, 0, 0);
//      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//      $resac = db_query("insert into db_acountkey values($acount,2010533,'$this->si203_sequencial','I')");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010533,'','" . AddSlashes(pg_result($resaco, 0, 'si203_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010534,'','" . AddSlashes(pg_result($resaco, 0, 'si203_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010535,'','" . AddSlashes(pg_result($resaco, 0, 'si203_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010536,'','" . AddSlashes(pg_result($resaco, 0, 'si203_nroconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010537,'','" . AddSlashes(pg_result($resaco, 0, 'si203_dtassinaturaconvoriginal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010538,'','" . AddSlashes(pg_result($resaco, 0, 'si203_nroseqtermoaditivo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010539,'','" . AddSlashes(pg_result($resaco, 0, 'si203_dscalteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010540,'','" . AddSlashes(pg_result($resaco, 0, 'si203_dtassinaturatermoaditivo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010541,'','" . AddSlashes(pg_result($resaco, 0, 'si203_datafinalvigencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010542,'','" . AddSlashes(pg_result($resaco, 0, 'si203_valoratualizadoconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010543,'','" . AddSlashes(pg_result($resaco, 0, 'si203_valoratualizadocontrapartida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2010544,'','" . AddSlashes(pg_result($resaco, 0, 'si203_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010323,2011606,'','" . AddSlashes(pg_result($resaco, 0, 'si203_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//    }

    return true;
  }

  // funcao para alteracao
  function alterar($si203_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update conv302019 set ";
    $virgula = "";
    if (trim($this->si203_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si203_sequencial"])) {
      if (trim($this->si203_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si203_sequencial"])) {
        $this->si203_sequencial = "0";
      }
      $sql .= $virgula . " si203_sequencial = $this->si203_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si203_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si203_tiporegistro"])) {
      $sql .= $virgula . " si203_tiporegistro = $this->si203_tiporegistro ";
      $virgula = ",";
      if (trim($this->si203_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si203_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
	if (trim($this->si203_codreceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si203_codreceita"])) {
		$sql .= $virgula . " si203_codreceita = '$this->si203_codreceita' ";
		$virgula = ",";
	}
	if (trim($this->si203_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si203_codorgao"])) {
		$sql .= $virgula . " si203_codorgao = '$this->si203_codorgao' ";
		$virgula = ",";
	}
	if (trim($this->si203_naturezareceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["$this->si203_naturezareceita"])) {
    	$sql .= $virgula . " $this->si203_naturezareceita = '$this->si203_naturezareceita' ";
    	$virgula = ",";
    }
	if (trim($this->si203_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si203_codfontrecursos"])) {
    	$sql .= $virgula . " si203_codfontrecursos = '$this->si203_codfontrecursos' ";
    	$virgula = ",";
    }
	if (trim($this->si203_vlprevisao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si203_vlprevisao"])) {
    	$sql .= $virgula . " si203_vlprevisao = '$this->si203_vlprevisao' ";
    	$virgula = ",";
    }

    if (trim($this->si203_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si203_mes"])) {
    	$sql .= $virgula . " si203_mes = $this->si203_mes ";
    	$virgula = ",";
      	if (trim($this->si203_mes) == null) {
			$this->erro_sql = " Campo Mês nao Informado.";
			$this->erro_campo = "si203_mes";
			$this->erro_banco = "";
			$this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
			$this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
			$this->erro_status = "0";
	        return false;
    	}
    }
    if (trim($this->si203_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si203_instit"])) {
      $sql .= $virgula . " si203_instit = $this->si203_instit ";
      $virgula = ",";
      if (trim($this->si203_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si203_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si203_sequencial != null) {
      $sql .= " si203_sequencial = $this->si203_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si203_sequencial));
//    if ($this->numrows > 0) {
//      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
//        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//        $acount = pg_result($resac, 0, 0);
//        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//        $resac = db_query("insert into db_acountkey values($acount,2010533,'$this->si203_sequencial','A')");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si203_sequencial"]) || $this->si203_sequencial != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010533,'" . AddSlashes(pg_result($resaco, $conresaco, 'si203_sequencial')) . "','$this->si203_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si203_tiporegistro"]) || $this->si203_tiporegistro != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010534,'" . AddSlashes(pg_result($resaco, $conresaco, 'si203_tiporegistro')) . "','$this->si203_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si203_codorgao"]) || $this->si203_codorgao != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010535,'" . AddSlashes(pg_result($resaco, $conresaco, 'si203_codorgao')) . "','$this->si203_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si203_nroconvenio"]) || $this->si203_nroconvenio != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010536,'" . AddSlashes(pg_result($resaco, $conresaco, 'si203_nroconvenio')) . "','$this->si203_nroconvenio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si203_dtassinaturaconvoriginal"]) || $this->si203_dtassinaturaconvoriginal != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010537,'" . AddSlashes(pg_result($resaco, $conresaco, 'si203_dtassinaturaconvoriginal')) . "','$this->si203_dtassinaturaconvoriginal'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si203_nroseqtermoaditivo"]) || $this->si203_nroseqtermoaditivo != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010538,'" . AddSlashes(pg_result($resaco, $conresaco, 'si203_nroseqtermoaditivo')) . "','$this->si203_nroseqtermoaditivo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si203_dscalteracao"]) || $this->si203_dscalteracao != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010539,'" . AddSlashes(pg_result($resaco, $conresaco, 'si203_dscalteracao')) . "','$this->si203_dscalteracao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si203_dtassinaturatermoaditivo"]) || $this->si203_dtassinaturatermoaditivo != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010540,'" . AddSlashes(pg_result($resaco, $conresaco, 'si203_dtassinaturatermoaditivo')) . "','$this->si203_dtassinaturatermoaditivo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si203_datafinalvigencia"]) || $this->si203_datafinalvigencia != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010541,'" . AddSlashes(pg_result($resaco, $conresaco, 'si203_datafinalvigencia')) . "','$this->si203_datafinalvigencia'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si203_valoratualizadoconvenio"]) || $this->si203_valoratualizadoconvenio != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010542,'" . AddSlashes(pg_result($resaco, $conresaco, 'si203_valoratualizadoconvenio')) . "','$this->si203_valoratualizadoconvenio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si203_valoratualizadocontrapartida"]) || $this->si203_valoratualizadocontrapartida != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010543,'" . AddSlashes(pg_result($resaco, $conresaco, 'si203_valoratualizadocontrapartida')) . "','$this->si203_valoratualizadocontrapartida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si203_mes"]) || $this->si203_mes != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2010544,'" . AddSlashes(pg_result($resaco, $conresaco, 'si203_mes')) . "','$this->si203_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si203_instit"]) || $this->si203_instit != "")
//          $resac = db_query("insert into db_acount values($acount,2010323,2011606,'" . AddSlashes(pg_result($resaco, $conresaco, 'si203_instit')) . "','$this->si203_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      }
//    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("", "", @pg_last_error());
      $this->erro_sql = "conv302019 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si203_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "conv302019 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si203_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si203_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si203_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si203_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
//    if (($resaco != false) || ($this->numrows != 0)) {
//      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
//        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//        $acount = pg_result($resac, 0, 0);
//        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//        $resac = db_query("insert into db_acountkey values($acount,2010533,'$si203_sequencial','E')");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010533,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si203_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010534,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si203_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010535,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si203_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010536,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si203_nroconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010537,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si203_dtassinaturaconvoriginal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010538,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si203_nroseqtermoaditivo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010539,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si203_dscalteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010540,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si203_dtassinaturatermoaditivo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010541,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si203_datafinalvigencia')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010542,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si203_valoratualizadoconvenio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010543,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si203_valoratualizadocontrapartida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2010544,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si203_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010323,2011606,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si203_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      }
//    }
    $sql = " delete from conv302019
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si203_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si203_sequencial = $si203_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("", "", @pg_last_error());
      $this->erro_sql = "conv302019 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si203_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "conv302019 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si203_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si203_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:conv302019";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si203_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from conv302019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si203_sequencial != null) {
        $sql2 .= " where conv302019.si203_sequencial = $si203_sequencial ";
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
  function sql_query_file($si203_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from conv302019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si203_sequencial != null) {
        $sql2 .= " where conv302019.si203_sequencial = $si203_sequencial ";
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
