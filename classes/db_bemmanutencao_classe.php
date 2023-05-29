<?php
//MODULO: patrimonio
//CLASSE DA ENTIDADE bemmanutencao
class cl_bemmanutencao
{
  // cria variaveis de erro 
  public $rotulo     = null;
  public $query_sql  = null;
  public $numrows    = 0;
  public $numrows_incluir = 0;
  public $numrows_alterar = 0;
  public $numrows_excluir = 0;
  public $erro_status = null;
  public $erro_sql   = null;
  public $erro_banco = null;
  public $erro_msg   = null;
  public $erro_campo = null;
  public $pagina_retorno = null;
  // cria variaveis do arquivo 
  public $t98_sequencial = 0;
  public $t98_bem = null;
  public $t98_data = null;
  public $t98_descricao = null;
  public $t98_vlrmanut = null;
  public $t98_idusuario = null;
  public $t98_dataservidor = null;
  public $t98_horaservidor = null;
  public $t98_tipo = null;
  public $t98_manutencaoprocessada = null;


  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 t98_sequencial int8 
                t98_bem = int8 = Sequencial 
                t98_data = data = Data 
                t98_descricao = varchar(500) = Descrição
                t98_vlrmanut = float = Valor da manutenção
                t98_idusuario = int = Id do usuário
                t98_dataservidor = date = Data do Servidor
                t98_horaservidor = time = Horário do Servidor
                t98_tipo = int4 = Tipo da Manutenção
                t98_manutencaoprocessada = boll = Processamento da Manutenção
                 ";

  //funcao construtor da classe 
  function __construct()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("bemmanutencao");
    $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
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
      $this->t98_sequencial = ($this->t98_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_sequencial"] : $this->t98_sequencial);
      $this->t98_bem = ($this->t98_bem == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_bem"] : $this->t98_bem);
      $this->t98_data = ($this->t98_data == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_data"] : $this->t98_data);
      $this->t98_descricao = ($this->t98_descricao == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_descricao"] : $this->t98_descricao);
      $this->t98_vlrmanut = ($this->t98_vlrmanut == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_vlrmanut"] : $this->t98_vlrmanut);
      $this->t98_dataservidor = ($this->t98_dataservidor == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_dataservidor"] : $this->t98_dataservidor);
      $this->t98_horaservidor = ($this->t98_horaservidor == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_horaservidor"] : $this->t98_horaservidor);
      $this->t98_tipo = ($this->t98_tipo == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_tipo"] : $this->t98_tipo);
      $this->t98_manutencaoprocessada = ($this->t98_manutencaoprocessada == "" ? @$GLOBALS["HTTP_POST_VARS"]["t98_manutencaoprocessada"] : $this->t98_manutencaoprocessada);
    }
  }

  // funcao para inclusao
  function incluir()
  {
    $this->atualizacampos();

    $rsManutencao = db_query("select * from bemmanutencao where t98_bem = $this->t98_bem and t98_manutencaoprocessada = 'f';");
    if (pg_num_rows($rsManutencao) > 0) {
      $this->erro_sql = "Existe uma manutenção do bem $this->t98_bem que precisa ser processada para que seja permitido uma nova manutenção desse bem.";
      $this->erro_campo = "";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->t98_sequencial == "" || $this->t98_sequencial == null) {
      $result = db_query("select nextval('bemmanutencao_t98_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: bemmanutencao_t98_sequencial_seq do campo: t98_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->t98_sequencial = pg_result($result, 0, 0);
    }

    $result = db_query("select last_value from bemmanutencao_t98_sequencial_seq");
    if (($result != false) && (pg_result($result, 0, 0) < $this->t98_sequencial)) {
      $this->erro_sql = " Campo t98_sequencial maior que último número da sequencia.";
      $this->erro_banco = "Sequencia menor que este número.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $this->t98_sequencial = $this->t98_sequencial;

    if ($this->t98_bem == null) {
      $this->erro_sql = " Campo Codigo do Bem não informado.";
      $this->erro_campo = "t98_bem";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->t98_data == null) {
      $this->erro_sql = " Campo Data não informado.";
      $this->erro_campo = "t98_data";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->t98_descricao == null) {
      $this->erro_sql = " Campo Descrição não informado.";
      $this->erro_campo = "t98_descricao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->t98_vlrmanut == null) {
      $this->erro_sql = " Campo Valor da Manutenção não informado.";
      $this->erro_campo = "t98_vlrmanut";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->t98_tipo == "0") {
      $this->erro_sql = " Campo Tipo da Manutenção não informado.";
      $this->erro_campo = "t98_tipo";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }


    $sql = "insert into bemmanutencao(
                    t98_sequencial 
                    ,t98_bem 
                    ,t98_data 
                    ,t98_descricao  
                    ,t98_vlrmanut 
                    ,t98_idusuario 
                    ,t98_dataservidor
                    ,t98_horaservidor
                    ,t98_tipo
                    ,t98_manutencaoprocessada)
                values ($this->t98_sequencial,  
                               $this->t98_bem, 
                               '$this->t98_data', 
                               '$this->t98_descricao', 
                               $this->t98_vlrmanut, 
                               $this->t98_idusuario, 
                               '$this->t98_dataservidor',
                               '$this->t98_horaservidor' ,
                               '$this->t98_tipo',
                               'false'
                      )";

    db_inicio_transacao();
    $result = db_query($sql);

    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());

      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = "Manutenção de bem () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "Manutenção de bem já Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        $this->numrows_incluir = 0;
        db_fim_transacao(true);
        return false;
      }

      $this->erro_sql   = "Manutenção de bem () nao Incluído. Inclusao Abortada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      db_fim_transacao(true);
      return false;
    }

    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);

    db_fim_transacao(false);
    return true;
  }


  function alterar($sequencial = null)
  {
    $this->atualizacampos();

    $sql = " update bemmanutencao set ";
    $virgula = "";
    if (trim($this->t98_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t98_sequencial"])) {
      $sql  .= $virgula . " t98_sequencial = $this->t98_sequencial ";
      $virgula = ",";
      if (trim($this->t98_sequencial) == null) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "t98_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->t98_bem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t98_bem"])) {
      $sql  .= $virgula . " t98_bem = $this->t98_bem ";
      $virgula = ",";
      if (trim($this->t98_bem) == null) {
        $this->erro_sql = " Campo Codigo do Bem não informado.";
        $this->erro_campo = "t98_bem";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t98_data) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t98_data"])) {
      $sql  .= $virgula . " t98_data = '$this->t98_data' ";
      $virgula = ",";
      if (trim($this->t98_data) == null) {
        $this->erro_sql = " Campo Data da Manutenção não informado.";
        $this->erro_campo = "t98_data";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t98_descricao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t98_descricao"])) {
      $sql  .= $virgula . " t98_descricao = '$this->t98_descricao' ";
      $virgula = ",";
      if (trim($this->t98_data) == null) {
        $this->erro_sql = " Campo Descrição da Manutenção não informado.";
        $this->erro_campo = "t98_descricao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t98_vlrmanut) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t98_vlrmanut"])) {
      $sql  .= $virgula . " t98_vlrmanut = $this->t98_vlrmanut ";
      $virgula = ",";
      if (trim($this->t98_vlrmanut) == null) {
        $this->erro_sql = " Campo Valor da Manutenção não informado.";
        $this->erro_campo = "t98_vlrmanut";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t98_tipo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t98_tipo"])) {
      $sql  .= $virgula . " t98_tipo = $this->t98_tipo ";
      $virgula = ",";
      if (trim($this->t98_tipo) == null) {
        $this->erro_sql = " Campo Tipo da Manutenção não informado.";
        $this->erro_campo = "t98_tipo";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->t98_manutencaoprocessada) != "" || isset($GLOBALS["HTTP_POST_VARS"]["t98_manutencaoprocessada"])) {
      $sql  .= $virgula . " t98_manutencaoprocessada = $this->t98_manutencaoprocessada ";
      $virgula = ",";
      if (trim($this->t98_manutencaoprocessada) == null) {
        $this->erro_sql = " Campo Processamento da Manutenção não informado.";
        $this->erro_campo = "t98_manutencaoprocessada";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    $sql .= " where ";
    $sql .= "t98_sequencial = $sequencial";

    db_inicio_transacao();
    $result = db_query($sql);

    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Manutenção do bem nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      db_fim_transacao(true);
      return false;
    }

    if (pg_affected_rows($result) == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Manutenção do bem nao foi Alterado. Alteracao Executada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      db_fim_transacao(true);
      return false;
    }

    $this->erro_banco = "";
    $this->erro_sql = "Alteração efetuada com Sucesso\\n";
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_alterar = pg_affected_rows($result);

    db_fim_transacao(false);
    return true;
  }

  function excluir($sequencial = null, $dbwhere = null)
  {

    db_inicio_transacao();

    $rsmanutbensitem = db_query("select * from manutbensitem where t99_codbemmanutencao = $sequencial");
    if (pg_num_rows($rsmanutbensitem) > 0) {

      $oDaomanutbensitem        = db_utils::getDao("manutbensitem");
      $oDaomanutbensitem->excluircomponentes($sequencial);

      if ($oDaomanutbensitem->erro_status == "0") {
        db_fim_transacao(true);
        $this->erro_sql   = "Exclusão Abortada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $oDaomanutbensitem->erro_msg . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $oDaomanutbensitem->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    $sql = " delete from bemmanutencao where ";
    $sql2 = "";

    if ($dbwhere == null || $dbwhere == "") {
      $sql2 = "t98_sequencial = $sequencial";
    } else {
      $sql2 = $dbwhere;
    }



    $result = db_query($sql . $sql2);

    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   =  "select * from manutbensitem where t99_codbemmanutencao = $this->t98_sequencial Bem de Manutencao nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      db_fim_transacao(true);
      return false;
    }

    if (pg_affected_rows($result) == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Bem de Manutencao nao Encontrado. Exclusão não Efetuada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      db_fim_transacao(true);
      return true;
    }

    $this->erro_banco = "";
    $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_excluir = pg_affected_rows($result);

    db_fim_transacao(false);
    return true;
  }

  function calculoValorManutencao($valormanutencao, $tipomanutencao, $valoratual)
  {
    /* Calculo de Manutenção de acréscimo */
    if ($tipomanutencao == 1 || $tipomanutencao == 3 || $tipomanutencao == 5) {
      return $valoratual + $valormanutencao;
    }
    /* Calculo de Manutenção de decréscimo */
    return $valoratual - $valormanutencao;
  }

  function processar($t98_sequencial)
  {


    $oDaoBensDepreciacao         = db_utils::getDao("bensdepreciacao");
    $oDaoBensHistoricoCalculo    = db_utils::getDao("benshistoricocalculo");
    $oDaoBensHistoricoCalculoBem = db_utils::getDao("benshistoricocalculobem");

    db_inicio_transacao();

    $rsBensDepreciacao = $oDaoBensDepreciacao->sql_record($oDaoBensDepreciacao->sql_query(null, "t44_sequencial,t44_valorresidual,t44_vidautil,t44_valoratual", null, "t44_bens = $this->t98_bem"));
    $oDaoBensDepreciacao->t44_sequencial =  db_utils::fieldsMemory($rsBensDepreciacao, 0)->t44_sequencial;
    $oDaoBensDepreciacao->t44_valoratual = $this->calculoValorManutencao($this->t98_vlrmanut, $this->t98_tipo, db_utils::fieldsMemory($rsBensDepreciacao, 0)->t44_valoratual);
    $oDaoBensDepreciacao->t44_ultimaavaliacao = implode('-', array_reverse(explode('/', $this->t98_data)));
    $oDaoBensDepreciacao->alterar($oDaoBensDepreciacao->t44_sequencial);


    if ($oDaoBensDepreciacao->erro_status == "0") {
      db_fim_transacao(true);
      $this->erro_sql   = "Processamento Abortado.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $oDaoBensDepreciacao->erro_msg . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $oDaoBensDepreciacao->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $oDaoBensHistoricoCalculo->t57_mes               = substr($this->t98_data, 5, 2);
    $oDaoBensHistoricoCalculo->t57_ano               = substr($this->t98_data, 0, 4);
    $oDaoBensHistoricoCalculo->t57_datacalculo       = $this->t98_data;
    $oDaoBensHistoricoCalculo->t57_usuario           = db_getsession("DB_id_usuario");
    $oDaoBensHistoricoCalculo->t57_instituicao       = db_getsession("DB_instit");
    $oDaoBensHistoricoCalculo->t57_tipocalculo       = 3;
    $oDaoBensHistoricoCalculo->t57_processado        = "true";
    $oDaoBensHistoricoCalculo->t57_tipoprocessamento = 2;
    $oDaoBensHistoricoCalculo->t57_ativo             = "true";
    $oDaoBensHistoricoCalculo->incluir(null);

    if ($oDaoBensHistoricoCalculo->erro_status == "0") {
      db_fim_transacao(true);
      $this->erro_sql   = "Processamento Abortado.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $oDaoBensHistoricoCalculo->erro_msg . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $oDaoBensHistoricoCalculo->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    /**
     * Calcula percentual a ser depreciado de acordo com o valor atual, valor depreciavel e vida útil
     */
    $oCalculoBem = new CalculoBem();
    $oBemNovo    = new Bem($this->t98_bem);
    $oBemNovo->setValorAtual($this->calculoValorManutencao($this->t98_vlrmanut, $this->t98_tipo, db_utils::fieldsMemory($rsBensDepreciacao, 0)->t44_valoratual));
    $oBemNovo->setValorResidual(db_utils::fieldsMemory($rsBensDepreciacao, 0)->t44_valorresidual);
    $oBemNovo->setVidaUtil(db_utils::fieldsMemory($rsBensDepreciacao, 0)->t44_vidautil);
    $oCalculoBem->setBem($oBemNovo);
    $oCalculoBem->calcular();
    $nPercentualDepreciavel                                = $oCalculoBem->getPercentualDepreciado();

    $valorCalculado = abs(db_utils::fieldsMemory($rsBensDepreciacao, 0)->t44_valoratual - $this->calculoValorManutencao($this->t98_vlrmanut, $this->t98_tipo, db_utils::fieldsMemory($rsBensDepreciacao, 0)->t44_valoratual));


    $oDaoBensHistoricoCalculoBem->t58_percentualdepreciado = "{$nPercentualDepreciavel}";
    $oDaoBensHistoricoCalculoBem->t58_benstipodepreciacao   = 6;
    $oDaoBensHistoricoCalculoBem->t58_benshistoricocalculo  = $oDaoBensHistoricoCalculo->t57_sequencial;
    $oDaoBensHistoricoCalculoBem->t58_bens                  = $this->t98_bem;
    $oDaoBensHistoricoCalculoBem->t58_valorresidual         = db_utils::fieldsMemory($rsBensDepreciacao, 0)->t44_valorresidual;
    $oDaoBensHistoricoCalculoBem->t58_valoratual            = $this->calculoValorManutencao($this->t98_vlrmanut, $this->t98_tipo, db_utils::fieldsMemory($rsBensDepreciacao, 0)->t44_valoratual);
    $oDaoBensHistoricoCalculoBem->t58_valorcalculado        = $valorCalculado;
    $oDaoBensHistoricoCalculoBem->t58_valoranterior         = db_utils::fieldsMemory($rsBensDepreciacao, 0)->t44_valoratual;
    $oDaoBensHistoricoCalculoBem->t58_vidautilanterior      = db_utils::fieldsMemory($rsBensDepreciacao, 0)->t44_vidautil;
    $oDaoBensHistoricoCalculoBem->t58_valorresidualanterior = db_utils::fieldsMemory($rsBensDepreciacao, 0)->t44_valorresidual;


    $oDaoBensHistoricoCalculoBem->incluir(null);

    if ($oDaoBensHistoricoCalculoBem->erro_status == "0") {
      db_fim_transacao(true);
      $this->erro_sql   = "Processamento Abortado.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $oDaoBensHistoricoCalculoBem->erro_msg . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $oDaoBensHistoricoCalculoBem->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    $this->t98_manutencaoprocessada = "'t'";
    $this->alterar($t98_sequencial);

    if ($this->erro_status == "0") {
      db_fim_transacao(true);
      $this->erro_sql   = "Processamento Abortado.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_msg . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $oDaoBensHistoricoCalculoBem->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    db_fim_transacao(false);
    $this->erro_msg   = "Usuário: \\n\\nProcessamento efetuado com sucesso. \\n\\n";
    $this->erro_status = "1";
    return true;
  }

  function desprocessar($t98_sequencial)
  {


    /**
     * atualiza tabela bensdepreciacao de acordo com estado anterior
     * status encontrado na tabela benshistoricocalculobem
     */
    $oDaoBensHistoricoCalculoBem = db_utils::getDao("benshistoricocalculobem");
    $sWhere                      = "t58_bens = $this->t98_bem and t58_benstipodepreciacao = 6";
    $sOrder                      = "t58_sequencial desc";
    $sSqlBensHistoricoCalculoBem = $oDaoBensHistoricoCalculoBem->sql_query_file(null, "*", $sOrder, $sWhere);
    $rsBensHistoricoCalculoBem   = $oDaoBensHistoricoCalculoBem->sql_record($sSqlBensHistoricoCalculoBem);


    $iVidaUtilAterior         = db_utils::fieldsMemory($rsBensHistoricoCalculoBem, 0)->t58_vidautilanterior;
    $nValorAtualAnterior     = db_utils::fieldsMemory($rsBensHistoricoCalculoBem, 0)->t58_valoratual;
    $iCodigoBem              = db_utils::fieldsMemory($rsBensHistoricoCalculoBem, 0)->t58_bens;
    $nValorCalculado         = db_utils::fieldsMemory($rsBensHistoricoCalculoBem, 0)->t58_valorcalculado;
    $nPercentualAnterior     = db_utils::fieldsMemory($rsBensHistoricoCalculoBem, 0)->t58_percentualdepreciado;
    $nValorAnterior          = db_utils::fieldsMemory($rsBensHistoricoCalculoBem, 0)->t58_valoranterior;
    $iTipoDepreciacao        = db_utils::fieldsMemory($rsBensHistoricoCalculoBem, 0)->t58_benstipodepreciacao;
    $nValorResidualAnterior  = db_utils::fieldsMemory($rsBensHistoricoCalculoBem, 0)->t58_valorresidualanterior;


    /**
     *  inclusao dos dados na bensdepreciacao
     */
    $oDaoBensDepreciacao                           = db_utils::getDao("bensdepreciacao");
    $oDaoBensDepreciacao->t44_vidautil             = $iVidaUtilAterior;
    $oDaoBensDepreciacao->t44_valoratual           = $nValorAnterior;
    $oDaoBensDepreciacao->t44_valorresidual        = $nValorResidualAnterior;
    $oDaoBensDepreciacao->t44_ultimaavaliacao      = date("Y-m-d", db_getsession("DB_datausu"));

    db_inicio_transacao();

    $rsBensDepreciacao = $oDaoBensDepreciacao->sql_record($oDaoBensDepreciacao->sql_query(null, "t44_sequencial,t44_valorresidual,t44_vidautil,t44_valoratual", null, "t44_bens = $this->t98_bem"));
    $oDaoBensDepreciacao->t44_sequencial =  db_utils::fieldsMemory($rsBensDepreciacao, 0)->t44_sequencial;
    $oDaoBensDepreciacao->alterar($oDaoBensDepreciacao->t44_sequencial);

    /**
     * Erro de atualização no banco
     */
    if ($oDaoBensDepreciacao->erro_status == "0") {
      db_fim_transacao(true);
      $this->erro_sql   = "Desprocessamento Abortado.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $oDaoBensDepreciacao->erro_msg . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $oDaoBensDepreciacao->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    /**
     *  inclusao dos dados na tabela benshistoricocalculo
     */
    $oDaoBensHistoricoCalculo                         = db_utils::getDao("benshistoricocalculo");
    $oDaoBensHistoricoCalculo->t57_mes               = date("m", db_getsession("DB_datausu"));
    $oDaoBensHistoricoCalculo->t57_ano               = date("Y", db_getsession("DB_datausu"));
    $oDaoBensHistoricoCalculo->t57_datacalculo        = date("Y-m-d", db_getsession("DB_datausu"));
    $oDaoBensHistoricoCalculo->t57_usuario            = db_getsession("DB_id_usuario");
    $oDaoBensHistoricoCalculo->t57_instituicao        = db_getsession("DB_instit");
    $oDaoBensHistoricoCalculo->t57_tipocalculo        = 3;
    $oDaoBensHistoricoCalculo->t57_processado         = "false";
    $oDaoBensHistoricoCalculo->t57_tipoprocessamento  = 2;
    $oDaoBensHistoricoCalculo->t57_ativo              = "true";
    $oDaoBensHistoricoCalculo->incluir(null);

    if ($oDaoBensHistoricoCalculo->erro_status == "0") {
      db_fim_transacao(true);
      $this->erro_sql   = "Desprocessamento Abortado.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $oDaoBensHistoricoCalculo->erro_msg . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $oDaoBensHistoricoCalculo->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    /**
     *  inclusao dos dados na tabela benshistoricocalculobem
     */
    $oDaoBensHistoricoCalculoBem->t58_benstipodepreciacao   = $iTipoDepreciacao;
    $oDaoBensHistoricoCalculoBem->t58_benshistoricocalculo  = $oDaoBensHistoricoCalculo->t57_sequencial;
    $oDaoBensHistoricoCalculoBem->t58_bens                  = $iCodigoBem;
    $oDaoBensHistoricoCalculoBem->t58_valorresidual         = $nValorResidualAnterior;
    $oDaoBensHistoricoCalculoBem->t58_valoratual            = $nValorAtualAnterior;
    $oDaoBensHistoricoCalculoBem->t58_valorcalculado        = $nValorCalculado;
    $oDaoBensHistoricoCalculoBem->t58_valoranterior         = $nValorAnterior;
    $oDaoBensHistoricoCalculoBem->t58_percentualdepreciado  = "{$nPercentualAnterior}";
    $oDaoBensHistoricoCalculoBem->t58_vidautilanterior      = $iVidaUtilAterior;
    $oDaoBensHistoricoCalculoBem->incluir(null);

    if ($oDaoBensHistoricoCalculoBem->erro_status == "0") {
      db_fim_transacao(true);
      $this->erro_sql   = "Desprocessamento Abortado.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $oDaoBensHistoricoCalculoBem->erro_msg . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $oDaoBensHistoricoCalculoBem->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    $this->t98_manutencaoprocessada = "'false'";
    $this->alterar($t98_sequencial);

    if ($this->erro_status == "0") {
      db_fim_transacao(true);
      $this->erro_sql   = "Desprocessamento Abortado.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_msg . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $oDaoBensHistoricoCalculoBem->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    db_fim_transacao(false);
    $this->erro_msg   = "Usuário: \\n\\Desprocessamento efetuado com sucesso. \\n\\n";
    $this->erro_status = "1";
    return true;
  }
}
