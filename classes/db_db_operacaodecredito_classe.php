<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                          
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */
//MODULO: contabilidade
//CLASSE DA ENTIDADE db_operacaodecredito
class cl_db_operacaodecredito
{
  // cria variaveis de erro 
  var $rotulo     = null;
  var $query_sql  = null;
  var $numrows    = 0;
  var $erro_status = null;
  var $erro_sql   = null;
  var $erro_banco = null;
  var $erro_msg   = null;
  var $erro_campo = null;
  var $pagina_retorno = null;
  // cria variaveis do arquivo 
  var $op01_sequencial = 0;
  var $op01_numerocontratoopc = null;
  var $op01_dataassinaturacop_dia = null;
  var $op01_dataassinaturacop_mes = null;
  var $op01_dataassinaturacop_ano = null;
  var $op01_dataassinaturacop = null;
  // cria propriedade com as variaveis do arquivo 
  var $campos = "
                 op01_sequencial = int4 = Sequencial 
                 op01_numerocontratoopc = varchar(30) =  
                 op01_dataassinaturacop = date =  
                 ";
  //funcao construtor da classe 
  function cl_db_operacaodecredito()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("db_operacaodecredito");
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
      $this->op01_sequencial = ($this->op01_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["op01_sequencial"] : $this->op01_sequencial);
      $this->op01_numerocontratoopc = ($this->op01_numerocontratoopc == "" ? @$GLOBALS["HTTP_POST_VARS"]["op01_numerocontratoopc"] : $this->op01_numerocontratoopc);
      if ($this->op01_dataassinaturacop == "") {
        $this->op01_dataassinaturacop_dia = @$GLOBALS["HTTP_POST_VARS"]["op01_dataassinaturacop_dia"];
        $this->op01_dataassinaturacop_mes = @$GLOBALS["HTTP_POST_VARS"]["op01_dataassinaturacop_mes"];
        $this->op01_dataassinaturacop_ano = @$GLOBALS["HTTP_POST_VARS"]["op01_dataassinaturacop_ano"];
        if ($this->op01_dataassinaturacop_dia != "") {
          $this->op01_dataassinaturacop = $this->op01_dataassinaturacop_ano . "-" . $this->op01_dataassinaturacop_mes . "-" . $this->op01_dataassinaturacop_dia;
        }
      }
    } else {
      $this->op01_sequencial = ($this->op01_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["op01_sequencial"] : $this->op01_sequencial);
    }
  }
  // funcao para inclusao
  function incluir($op01_sequencial)
  {
    $this->atualizacampos();
    if ($this->op01_numerocontratoopc == null) {
      $this->erro_sql = " Campo Nº do Contrato da Operação de Crédito não Informado.";
      $this->erro_campo = "op01_numerocontratoopc";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->op01_dataassinaturacop == null) {
      $this->erro_sql = " Campo Data de Assinatura do Contrato OP não Informado.";
      $this->erro_campo = "op01_dataassinaturacop_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $result = db_query("select max(op01_sequencial) from db_operacaodecredito");
    if (($this->op01_sequencial == null) || ($this->op01_sequencial == "")) {
      $result = db_query("select nextval('db_operacaodecredito_op01_sequencial_seq')");
      if ($result != false) {
        $this->op01_sequencial = pg_result($result, 0, 0);
      }
    } else {
      $result = db_query("select max(op01_sequencial)+1 from db_operacaodecredito");
      $this->op01_sequencial = pg_result($result, 0, 0);
    }
    if (($this->op01_sequencial == null) || ($this->op01_sequencial == "")) {
      $this->erro_sql = " Campo op01_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $result = @pg_query("insert into db_operacaodecredito(
                                       op01_sequencial 
                                      ,op01_numerocontratoopc 
                                      ,op01_dataassinaturacop 
                       )
                values (
                                $this->op01_sequencial 
                               ,'$this->op01_numerocontratoopc' 
                               ," . ($this->op01_dataassinaturacop == "null" || $this->op01_dataassinaturacop == "" ? "null" : "'" . $this->op01_dataassinaturacop . "'") . " 
                      )");
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = " ($this->op01_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = " já Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->op01_sequencial = $op01_sequencial;
      } else {
        $this->erro_sql   = " ($this->op01_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->op01_sequencial = $op01_sequencial;
      }
      $this->erro_status = "0";
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->op01_sequencial;
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    
    return true;
  }
  // funcao para alteracao
  function alterar($op01_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update db_operacaodecredito set ";
    $virgula = "";
    if (trim($this->op01_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["op01_sequencial"])) {
      if (trim($this->op01_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["op01_sequencial"])) {
        $this->op01_sequencial = "0";
      }
      $sql  .= $virgula . " op01_sequencial = $this->op01_sequencial ";
      $virgula = ",";
      if (trim($this->op01_sequencial) == null) {
        $this->erro_sql = " Campo Sequencial não Informado.";
        $this->erro_campo = "op01_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->op01_numerocontratoopc) != "" || isset($GLOBALS["HTTP_POST_VARS"]["op01_numerocontratoopc"])) {
      $sql  .= $virgula . " op01_numerocontratoopc = '$this->op01_numerocontratoopc' ";
      $virgula = ",";
      if (trim($this->op01_numerocontratoopc) == null) {
        $this->erro_sql = " Campo Nº do Contrato da Operação de Crédito não Informado.";
        $this->erro_campo = "op01_numerocontratoopc";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->op01_dataassinaturacop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["op01_dataassinaturacop_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["op01_dataassinaturacop_dia"] != "")) {
      $sql  .= $virgula . " op01_dataassinaturacop = '$this->op01_dataassinaturacop' ";
      $virgula = ",";
      if (trim($this->op01_dataassinaturacop) == null) {
        $this->erro_sql = " Campo Data de Assinatura do Contrato OP não Informado..";
        $this->erro_campo = "op01_dataassinaturacop_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["op01_dataassinaturacop_dia"])) {
        $sql  .= $virgula . " op01_dataassinaturacop = null ";
        $virgula = ",";
        if (trim($this->op01_dataassinaturacop) == null) {
          $this->erro_sql = " Campo  nao Informado.";
          $this->erro_campo = "op01_dataassinaturacop_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
          $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    $sql .= " where  op01_sequencial = $this->op01_sequencial
";
    $result = @pg_exec($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->op01_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->op01_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->op01_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        return true;
      }
    }
  }
  // funcao para exclusao  
  function excluir($op01_sequencial = null)  
  {
    $this->atualizacampos(true);

    $sql = " delete from db_operacaodecredito
                    where ";
    $sql2 = "";
    if ($this->op01_sequencial != "") {  
      if ($sql2 != "") {
        $sql2 .= " and ";
      }
      $sql2 .= " op01_sequencial = $this->op01_sequencial ";
    }
    $result = @pg_exec($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->op01_sequencial;
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $this->op01_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->op01_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        return true;
      }
    }
  }
  // funcao do recordset 
  function sql_record($sql)
  {
    $result = @pg_query($sql);
    if ($result == false) {
      $this->numrows    = 0;
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Erro ao selecionar os registros.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = "";
      $this->erro_sql   = "Dados do Grupo nao Encontrado";
      $this->erro_msg   = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  // funcao do sql 
  function sql_query($op01_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from db_operacaodecredito ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($op01_sequencial != null) {
        $sql2 .= " where db_operacaodecredito.op01_sequencial = $op01_sequencial ";
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
  function sql_query_file($op01_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from db_operacaodecredito ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($op01_sequencial != null) {
        $sql2 .= " where db_operacaodecredito.op01_sequencial = $op01_sequencial ";
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
