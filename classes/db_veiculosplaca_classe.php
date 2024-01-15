<?

//MODULO: veiculos
//CLASSE DA ENTIDADE veiculosplaca
class cl_veiculosplaca
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
  var $ve76_sequencial = null;
  var $ve76_veiculo = null;
  var $ve76_placa = null;
  var $ve76_placaanterior = null;
  var $ve76_obs = null;
  var $ve76_data = null;
  var $ve76_usuario = null;
  var $ve76_criadoem = null;

  var $campos = "
    ve76_sequencial = int8 = Sequencial
    ve76_veiculo = int4 = Código Veículo
    ve76_placa = varchar(8) = Placa
    ve76_placaanterior = varchar(8) = Placa Anterior
    ve76_obs = varchar(200) = Observação
    ve76_data = date = Data
    ve76_usuario = int4 = Usuário
    ve76_criadoem = datetime = Criado em
  ";

  // Construtor
  function cl_veiculosplaca()
  {
    $this->rotulo = new rotulo("veiculosplaca");
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
      $this->ve76_sequencial = ($this->ve76_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve76_sequencial"] : $this->ve76_sequencial);
      $this->ve76_placa = ($this->ve76_placa == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve76_placa"] : $this->ve76_placa);
      $this->ve76_placaanterior = ($this->ve76_placaanterior == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve76_placaanterior"] : $this->ve76_placaanterior);
      $this->ve76_data = ($this->ve76_data == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve76_data"] : $this->ve76_data);
      $this->ve76_usuario = ($this->ve76_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve76_usuario"] : $this->ve76_usuario);
    } else {
      $this->ve76_sequencial = ($this->ve76_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["ve76_sequencial"] : $this->ve76_sequencial);
    }
  }

  // Função para inclusão
  function incluir()
  {
    $this->atualizacampos();

    if (empty($this->ve76_placa)) {
      $this->gravaErro("Campo Placa nao Informado.", "ve01_placa", "");
      return false;
    }

    if (empty($this->ve76_veiculo)) {
      $this->gravaErro("Campo Veiculo nao Informado.", "ve76_veiculo", "");
      return false;
    }

    if (empty($this->ve76_placaanterior)) {
      $this->gravaErro("Campo Placa Anterior nao Informado.", "ve76_placaanterior", "");
      return false;
    }

    if (empty($this->ve76_data)) {
      $this->gravaErro("Campo Data nao Informado.", "ve76_data", "");
      return false;
    }

    if (empty($this->ve76_usuario)) {
      $this->gravaErro("Campo Usuário nao Informado.", "ve76_usuario", "");
      return false;
    }

    $sqlInsert = "
      INSERT INTO veiculosplaca 
        (ve76_veiculo, ve76_placa, ve76_placaanterior, ve76_obs, ve76_data, ve76_usuario, ve76_criadoem) 
      VALUES 
        (
          '$this->ve76_veiculo',
          '$this->ve76_placa', 
          '$this->ve76_placaanterior',
          '$this->ve76_obs',
          '$this->ve76_data', 
          '$this->ve76_usuario', 
          '$this->ve76_criadoem'
        );
    ";

    $result = db_query($sqlInsert);
    if ($result == false) {
      $erroBanco = str_replace("\n", "", @pg_last_error());
      $erroSql = "Cadastro de Registro de Alteração de Placa nao Incluída. Inclusão Abortada.";

      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $erroBanco = "Registro de Alteração de Placa já Cadastrado";
      }

      $this->gravaErro($erroSql, "", $erroBanco);
      $this->numrows_incluir = 0;
      return false;
    }

    $this->gravaErro("Inclusao efetuada com Sucesso\\n Valores : $this->ve76_sequencial", "", "", 1);
    $this->numrows_incluir = pg_affected_rows($result);

    return true;
  }

  function excluir($ve76_sequencial = null, $dbwhere = null)
  {
    $sql = " delete from veiculos.veiculosplaca
                    where ";

    $sqlWhere = "";

    if (!empty($dbwhere)) {
      $sqlWhere = $dbwhere;
    } elseif (!empty($ve76_sequencial)) {
      $sqlWhere = " ve76_sequencial = $ve76_sequencial";
    }

    $result = db_query($sql . $sqlWhere);

    if ($result == false) {
      $this->gravaErro("A alteração de placa não foi excluída. \\n Valores : " . $ve76_sequencial, "", str_replace("\n", "", @pg_last_error()));
      return false;
    }

    if (pg_affected_rows($result) == 0) {
      $this->gravaErro("A alteração de placa não foi encontrada. \\n Valores : " . $ve76_sequencial, "", "");
      return false;
    }

    $this->gravaErro("Exclusão efetuada com Sucesso. \\n Valores : " . $ve76_sequencial, "", "", 1);
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
      $this->gravaErro("Record Vazio na Tabela:veiculos", "", "");
      return false;
    }

    return $result;
  }

  function sql_query($ve76_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";

    if ($campos != "*") {
      $campos_sql = explode("#", $campos);
      $sql .= implode(",", $campos_sql);
    } else {
      $sql .= $campos;
    }

    $sql .= " from  veiculos.veiculosplaca ";
    $sql .= " inner join db_usuarios on id_usuario = ve76_usuario ";

    $sqlWhere = "";

    if (empty($dbwhere) && $ve76_sequencial != null) {
      $sqlWhere = " WHERE veiculos.veiculosplaca.ve76_sequencial = $ve76_sequencial";
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

  function sql_query_ultima_alteracao($dbwhere = "")
  {
    $sql = "select DISTINCT ON (ve76_veiculo) ve76_sequencial,ve76_veiculo,ve76_placaanterior,ve76_placa,ve76_data, LEFT(ve76_obs, 50) ve76_obs, '(' || id_usuario || ') ' || nome as ve76_usuario ";

    $sql .= " from  veiculos.veiculosplaca ";
    $sql .= " inner join db_usuarios on id_usuario = ve76_usuario ";

    if (!empty($dbwhere)) {
      $sql .= " WHERE $dbwhere";
    }

    $sql .= " ORDER BY ve76_veiculo, ve76_criadoem DESC";

    return $sql;
  }

  function sql_query_file($ve76_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from veiculosplaca ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($ve76_sequencial != null) {
        $sql2 .= " where veiculosplaca.ve01_codigo = $ve76_sequencial ";
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
