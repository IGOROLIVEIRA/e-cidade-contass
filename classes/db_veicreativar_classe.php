<?

//MODULO: veiculos
//CLASSE DA ENTIDADE veicreativar
class cl_veicreativar
{
  // cria variaveis de erro
  var $rotulo     = null;
  var $query_sql  = null;
  var $numrows    = 0;
  var $numrows_incluir = 0;
  var $numrows_alterar = 0;
  var $numrows_excluir = 0;
  var $erro_status = null;
  var $erro_sql   = null;
  var $erro_banco = null;
  var $erro_msg   = null;
  var $erro_campo = null;
  var $pagina_retorno = null;

  // cria variaveis do arquivo
  var $ve82_sequencial = null;
  var $ve82_veiculo = null;
  var $ve82_datareativacao = null;
  var $ve82_obs = null;
  var $ve82_usuario = null;
  var $ve82_criadoem = null;

  var $campos = "
    ve82_sequencial = int8 = Sequencial
    ve82_veiculo = int4 = Código Veículo
    ve82_datareativacao = date = Data da Reativação
    ve82_obs = varchar(200) = Observação
    ve82_usuario = int4 = Usuário
    ve82_criadoem = datetime = Criado em
  ";

  // Construtor
  function cl_veicreativar()
  {
    $this->rotulo = new rotulo("veicreativar");
    $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
  }

  // Função erro
  function erro($mostra, $retorna)
  {
    if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null)) {
      echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
      if ($retorna == true) {
        echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
      }
    }
  }

  // Função para atualizar campos
  function atualizacampos($exclusao = false)
  {
    if ($exclusao == false) {
      $this->ve82_sequencial = ($this->ve82_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve82_sequencial"] : $this->ve82_sequencial);
      $this->ve82_datareativacao = ($this->ve82_datareativacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve82_datareativacao"] : $this->ve82_datareativacao);
      $this->ve82_usuario = ($this->ve82_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve82_usuario"] : $this->ve82_usuario);
    } else {
      $this->ve82_sequencial = ($this->ve82_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve82_sequencial"] : $this->ve82_sequencial);
    }
  }

  // Função para inclusão
  function incluir()
  {
    $this->atualizacampos();

    if (empty($this->ve82_veiculo)) {
      $this->gravaErro("Campo Placa nao Informado.", "ve82_veiculo", "");
      return false;
    }

    if (empty($this->ve82_datareativacao)) {
      $this->gravaErro("Campo Veiculo nao Informado.", "ve82_datareativacao", "");
      return false;
    }

    if (empty($this->ve82_obs)) {
      $this->gravaErro("Campo Placa Anterior nao Informado.", "ve82_obs", "");
      return false;
    }

    if (empty($this->ve82_usuario)) {
      $this->gravaErro("Campo Usuário nao Informado.", "ve82_usuario", "");
      return false;
    }

    $sqlInsert = "
      INSERT INTO veiculos.veicreativar
        (ve82_veiculo, ve82_datareativacao, ve82_obs, ve82_criadoem, ve82_usuario)
      VALUES
        (
          '$this->ve82_veiculo',
          '$this->ve82_datareativacao',
          '$this->ve82_obs',
          now(),
          '$this->ve82_usuario'
        );
    ";

    $result = db_query($sqlInsert);
    if ($result == false) {
      $erroBanco = str_replace("\n", "", @pg_last_error());
      $erroSql = "Cadastro de Registro de Reativação de Veículo não Incluído. Inclusão Abortada.";

      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $erroBanco = "Registro de Reativação de Veículo já Cadastrado";
      }

      $this->gravaErro($erroSql, "", $erroBanco);
      $this->numrows_incluir = 0;
      return false;
    }

    $this->gravaErro("Inclusao efetuada com Sucesso\\n Valores : $this->ve82_sequencial", "", "", 1);
    $this->numrows_incluir = pg_affected_rows($result);

    return true;
  }

  function excluir($ve82_sequencial = null, $dbwhere = null)
  {
    $sql = " delete from veiculos.veicreativar
                    where ";

    $sqlWhere = "";

    if (!empty($dbwhere)) {
      $sqlWhere = $dbwhere;
    } elseif (!empty($ve82_sequencial)) {
      $sqlWhere = " ve82_sequencial = $ve82_sequencial";
    }

    $result = db_query($sql . $sqlWhere);

    if ($result == false) {
      $this->gravaErro("A alteração de placa não foi excluída. \\n Valores : " . $ve82_sequencial, "", str_replace("\n", "", @pg_last_error()));
      return false;
    }

    if (pg_affected_rows($result) == 0) {
      $this->gravaErro("A alteração de placa não foi encontrada. \\n Valores : " . $ve82_sequencial, "", "");
      return false;
    }

    $this->gravaErro("Exclusão efetuada com Sucesso. \\n Valores : " . $ve82_sequencial, "", "", 1);
    $this->numrows_incluir = pg_affected_rows($result);

    return true;
  }

  // funcao do recordset
  function sql_record($sql)
  {
    $result = db_query($sql);
    if ($result == false) {
      $this->numrows    = 0;
      $this->gravaErro("Erro ao selecionar os registros.", "", str_replace("\n", "", @pg_last_error()));
      return false;
    }

    $this->numrows = pg_num_rows($result);

    if ($this->numrows == 0) {
      $this->gravaErro("Record Vazio na Tabela: veicreativar", "", "");
      return false;
    }

    return $result;
  }

  function sql_query($ve82_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";

    if ($campos != "*") {
      $campos_sql = explode("#", $campos);
      $sql .= implode(",", $campos_sql);
    } else {
      $sql .= $campos;
    }

    $sql .= " from  veiculos.veicreativar ";
    $sql .= " inner join db_usuarios on id_usuario = ve82_usuario ";

    $sqlWhere = "";

    if (empty($dbwhere) && $ve82_sequencial != null) {
      $sqlWhere = " WHERE veiculos.veicreativar.ve82_sequencial = $ve82_sequencial";
    } elseif (!empty($dbwhere)) {
      $sqlWhere = " WHERE $dbwhere";
    }

    $sql .= $sqlWhere;

    if ($ordem != null) {
      $campos_sql = explode("#", $ordem);
      $sql .= " ORDER BY " . implode(",", $campos_sql);
    }

    return $sql;
  }

  function sql_query_file($ve82_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from veiculos.veicreativar ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($ve82_sequencial != null) {
        $sql2 .= " where veiculos.veicreativar.ve82_sequencial = $ve82_sequencial ";
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

  // Busca detalhe da reativação de veículo
  function sql_buscar_detalhes($codigo, $campos = "*")
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
    $sql .= " from veicreativar as ra";
    $sql .= " inner join veiculos as v  on  v.ve01_codigo = ra.ve82_veiculo";
    $sql .= " inner join db_usuarios as u on u.id_usuario = ra.ve82_usuario";
    $sql .= " where ra.ve82_sequencial = $codigo";

    return $sql;
  }

  // Função para gravar o erro
  function gravaErro($erroSql, $erroCampo, $erroBanco, $erroStatus = "0")
  {

    $this->erro_sql = $erroSql;
    $this->erro_campo = $erroCampo;
    $this->erro_banco = $erroBanco;
    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";

    $sanitizedErroBanco = str_replace(['"', "'"], "", $erroBanco);
    $this->erro_msg .= "Administrador: \\n\\n " . $sanitizedErroBanco . " \\n";

    $this->erro_status = $erroStatus;
  }
}
