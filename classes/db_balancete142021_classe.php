<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete142021
class cl_balancete142021
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
  var $si181_sequencial = 0;
  var $si181_tiporegistro = 0;
  var $si181_contacontabil = 0;
  var $si181_codfundo = 0;
  var $si181_codorgao = null;
  var $si181_codunidadesub = null;
  var $si181_codunidadesuborig = null;
  var $si181_codfuncao = null;
  var $si181_codsubfuncao = null;
  var $si181_codprograma = null;
  var $si181_idacao = null;
  var $si181_idsubacao = null;
  var $si181_naturezadespesa = 0;
  var $si181_subelemento = null;
  var $si181_codfontrecursos = 0;
  var $si181_nroempenho = 0;
  var $si181_anoinscricao = 0;
  var $si181_saldoinicialrsp = 0;
  var $si181_naturezasaldoinicialrsp = null;
  var $si181_totaldebitosrsp = 0;
  var $si181_totalcreditosrsp = 0;
  var $si181_saldofinalrsp = 0;
  var $si181_naturezasaldofinalrsp = null;
  var $si181_mes = 0;
  var $si181_instit = 0;
  var $si181_reg10 = null;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si181_sequencial = int8 = si181_sequencial 
                 si181_tiporegistro = int8 = si181_tiporegistro 
                 si181_contacontabil = int8 = si181_contacontabil 
                 si181_codfundo = int8 = si181_codfundo 
                 si181_codorgao = varchar(2) = si181_codorgao 
                 si181_codunidadesub = varchar(8) = si181_codunidadesub 
                 si181_codunidadesuborig = varchar(8) = si181_codunidadesuborig 
                 si181_codfuncao = varchar(2) = si181_codfuncao 
                 si181_codsubfuncao = varchar(3) = si181_codsubfuncao 
                 si181_codprograma = varchar(4) = si181_codprograma 
                 si181_idacao = varchar(4) = si181_idacao 
                 si181_idsubacao = varchar(4) = si181_idsubacao 
                 si181_naturezadespesa = int8 = si181_naturezadespesa 
                 si181_subelemento = varchar(2) = si181_subelemento 
                 si181_codfontrecursos = int8 = si181_codfontrecursos 
                 si181_nroempenho = int8 = si181_nroempenho 
                 si181_anoinscricao = int8 = si181_anoinscricao 
                 si181_saldoinicialrsp = float8 = si181_saldoinicialrsp 
                 si181_naturezasaldoinicialrsp = varchar(1) = si181_naturezasaldoinicialrsp 
                 si181_totaldebitosrsp = float8 = si181_totaldebitosrsp 
                 si181_totalcreditosrsp = float8 = si181_totalcreditosrsp 
                 si181_saldofinalrsp = float8 = si181_saldofinalrsp 
                 si181_naturezasaldofinalrsp = varchar(1) = si181_naturezasaldofinalrsp 
                 si181_mes = int8 = si181_mes 
                 si181_instit = int8 = si181_instit
                 si181_reg10 = int8 = s181_reg10
                 ";
  
  //funcao construtor da classe
  function cl_balancete142021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete142021");
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
      $this->si181_sequencial = ($this->si181_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_sequencial"] : $this->si181_sequencial);
      $this->si181_tiporegistro = ($this->si181_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_tiporegistro"] : $this->si181_tiporegistro);
      $this->si181_contacontabil = ($this->si181_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_contacontabil"] : $this->si181_contacontabil);
      $this->si181_codfundo = ($this->si181_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_codfundo"] : $this->si181_codfundo);
      $this->si181_codorgao = ($this->si181_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_codorgao"] : $this->si181_codorgao);
      $this->si181_codunidadesub = ($this->si181_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_codunidadesub"] : $this->si181_codunidadesub);
      $this->si181_codunidadesuborig = ($this->si181_codunidadesuborig == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_codunidadesuborig"] : $this->si181_codunidadesuborig);
      $this->si181_codfuncao = ($this->si181_codfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_codfuncao"] : $this->si181_codfuncao);
      $this->si181_codsubfuncao = ($this->si181_codsubfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_codsubfuncao"] : $this->si181_codsubfuncao);
      $this->si181_codprograma = ($this->si181_codprograma == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_codprograma"] : $this->si181_codprograma);
      $this->si181_idacao = ($this->si181_idacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_idacao"] : $this->si181_idacao);
      $this->si181_idsubacao = ($this->si181_idsubacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_idsubacao"] : $this->si181_idsubacao);
      $this->si181_naturezadespesa = ($this->si181_naturezadespesa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_naturezadespesa"] : $this->si181_naturezadespesa);
      $this->si181_subelemento = ($this->si181_subelemento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_subelemento"] : $this->si181_subelemento);
      $this->si181_codfontrecursos = ($this->si181_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_codfontrecursos"] : $this->si181_codfontrecursos);
      $this->si181_nroempenho = ($this->si181_nroempenho == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_nroempenho"] : $this->si181_nroempenho);
      $this->si181_anoinscricao = ($this->si181_anoinscricao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_anoinscricao"] : $this->si181_anoinscricao);
      $this->si181_saldoinicialrsp = ($this->si181_saldoinicialrsp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_saldoinicialrsp"] : $this->si181_saldoinicialrsp);
      $this->si181_naturezasaldoinicialrsp = ($this->si181_naturezasaldoinicialrsp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_naturezasaldoinicialrsp"] : $this->si181_naturezasaldoinicialrsp);
      $this->si181_totaldebitosrsp = ($this->si181_totaldebitosrsp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_totaldebitosrsp"] : $this->si181_totaldebitosrsp);
      $this->si181_totalcreditosrsp = ($this->si181_totalcreditosrsp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_totalcreditosrsp"] : $this->si181_totalcreditosrsp);
      $this->si181_saldofinalrsp = ($this->si181_saldofinalrsp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_saldofinalrsp"] : $this->si181_saldofinalrsp);
      $this->si181_naturezasaldofinalrsp = ($this->si181_naturezasaldofinalrsp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_naturezasaldofinalrsp"] : $this->si181_naturezasaldofinalrsp);
      $this->si181_mes = ($this->si181_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_mes"] : $this->si181_mes);
      $this->si181_instit = ($this->si181_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_instit"] : $this->si181_instit);
    } else {
      $this->si181_sequencial = ($this->si181_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_sequencial"] : $this->si181_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si181_sequencial)
  {
    $this->atualizacampos();
    if ($this->si181_tiporegistro == null) {
      $this->erro_sql = " Campo si181_tiporegistro não informado.";
      $this->erro_campo = "si181_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_contacontabil == null) {
      $this->erro_sql = " Campo si181_contacontabil não informado.";
      $this->erro_campo = "si181_contacontabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_codorgao == null) {
      $this->erro_sql = " Campo si181_codorgao não informado.";
      $this->erro_campo = "si181_codorgao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_codunidadesub == null) {
      $this->erro_sql = " Campo si181_codunidadesub não informado.";
      $this->erro_campo = "si181_codunidadesub";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_codunidadesuborig == null) {
      $this->erro_sql = " Campo si181_codunidadesuborig não informado.";
      $this->erro_campo = "si181_codunidadesuborig";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_codfuncao == null) {
      $this->erro_sql = " Campo si181_codfuncao não informado.";
      $this->erro_campo = "si181_codfuncao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_codsubfuncao == null) {
      $this->erro_sql = " Campo si181_codsubfuncao não informado.";
      $this->erro_campo = "si181_codsubfuncao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_codprograma == null) {
      $this->erro_sql = " Campo si181_codprograma não informado.";
      $this->erro_campo = "si181_codprograma";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_idacao == null) {
      $this->erro_sql = " Campo si181_idacao não informado.";
      $this->erro_campo = "si181_idacao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_naturezadespesa == null) {
      $this->erro_sql = " Campo si181_naturezadespesa não informado.";
      $this->erro_campo = "si181_naturezadespesa";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_subelemento == null) {
      $this->erro_sql = " Campo si181_subelemento não informado.";
      $this->erro_campo = "si181_subelemento";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_codfontrecursos == null) {
      $this->erro_sql = " Campo si181_codfontrecursos não informado.";
      $this->erro_campo = "si181_codfontrecursos";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_nroempenho == null) {
      $this->erro_sql = " Campo si181_nroempenho não informado.";
      $this->erro_campo = "si181_nroempenho";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_anoinscricao == null) {
      $this->erro_sql = " Campo si181_anoinscricao não informado.";
      $this->erro_campo = "si181_anoinscricao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_saldoinicialrsp == null) {
      $this->erro_sql = " Campo si181_saldoinicialrsp não informado.";
      $this->erro_campo = "si181_saldoinicialrsp";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_naturezasaldoinicialrsp == null) {
      $this->erro_sql = " Campo si181_naturezasaldoinicialrsp não informado.";
      $this->erro_campo = "si181_naturezasaldoinicialrsp";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_totaldebitosrsp == null) {
      $this->erro_sql = " Campo si181_totaldebitosrsp não informado.";
      $this->erro_campo = "si181_totaldebitosrsp";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_totalcreditosrsp == null) {
      $this->erro_sql = " Campo si181_totalcreditosrsp não informado.";
      $this->erro_campo = "si181_totalcreditosrsp";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    if ($this->si181_idsubacao == null) {
      $this->si181_idsubacao = " ";
    }
    
    if ($this->si181_saldofinalrsp == null) {
      $this->erro_sql = " Campo si181_saldofinalrsp não informado.";
      $this->erro_campo = "si181_saldofinalrsp";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_naturezasaldofinalrsp == null) {
      $this->erro_sql = " Campo si181_naturezasaldofinalrsp não informado.";
      $this->erro_campo = "si181_naturezasaldofinalrsp";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_mes == null) {
      $this->erro_sql = " Campo si181_mes não informado.";
      $this->erro_campo = "si181_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si181_instit == null) {
      $this->erro_sql = " Campo si181_instit não informado.";
      $this->erro_campo = "si181_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si181_sequencial == "" || $si181_sequencial == null) {
      $result = db_query("select nextval('balancete142021_si181_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: balancete142021_si181_sequencial_seq do campo: si181_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si181_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from balancete142021_si181_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si181_sequencial)) {
        $this->erro_sql = " Campo si181_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si181_sequencial = $si181_sequencial;
      }
    }
    
    $sql = "insert into balancete142021(
                                       si181_sequencial 
                                      ,si181_tiporegistro 
                                      ,si181_contacontabil 
                                      ,si181_codfundo
                                      ,si181_codorgao 
                                      ,si181_codunidadesub 
                                      ,si181_codunidadesuborig 
                                      ,si181_codfuncao 
                                      ,si181_codsubfuncao 
                                      ,si181_codprograma 
                                      ,si181_idacao 
                                      ,si181_idsubacao 
                                      ,si181_naturezadespesa 
                                      ,si181_subelemento 
                                      ,si181_codfontrecursos 
                                      ,si181_nroempenho 
                                      ,si181_anoinscricao 
                                      ,si181_saldoinicialrsp 
                                      ,si181_naturezasaldoinicialrsp 
                                      ,si181_totaldebitosrsp 
                                      ,si181_totalcreditosrsp 
                                      ,si181_saldofinalrsp 
                                      ,si181_naturezasaldofinalrsp 
                                      ,si181_mes 
                                      ,si181_instit
                                      ,si181_reg10
                       )
                values (
                                $this->si181_sequencial 
                               ,$this->si181_tiporegistro 
                               ,$this->si181_contacontabil 
                               ,'$this->si181_codfundo'
                               ,'$this->si181_codorgao' 
                               ,'$this->si181_codunidadesub' 
                               ,'$this->si181_codunidadesuborig' 
                               ,'$this->si181_codfuncao' 
                               ,'$this->si181_codsubfuncao' 
                               ,'$this->si181_codprograma' 
                               ,'$this->si181_idacao' 
                               ,'$this->si181_idsubacao' 
                               ,$this->si181_naturezadespesa 
                               ,'$this->si181_subelemento' 
                               ,$this->si181_codfontrecursos 
                               ,$this->si181_nroempenho 
                               ,$this->si181_anoinscricao 
                               ,$this->si181_saldoinicialrsp 
                               ,'$this->si181_naturezasaldoinicialrsp' 
                               ,$this->si181_totaldebitosrsp 
                               ,$this->si181_totalcreditosrsp 
                               ,$this->si181_saldofinalrsp 
                               ,'$this->si181_naturezasaldofinalrsp' 
                               ,$this->si181_mes 
                               ,$this->si181_instit
                               ,$this->si181_reg10
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete142021 ($this->si181_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete142021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete142021 ($this->si181_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si181_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si181_sequencial));
      if (($resaco != false) || ($this->numrows != 0)) {
        
        /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011760,'$this->si181_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,1010196,2011760,'','" . AddSlashes(pg_result($resaco, 0, 'si181_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011761,'','" . AddSlashes(pg_result($resaco, 0, 'si181_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011762,'','" . AddSlashes(pg_result($resaco, 0, 'si181_contacontabil')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011763,'','" . AddSlashes(pg_result($resaco, 0, 'si181_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011764,'','" . AddSlashes(pg_result($resaco, 0, 'si181_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011765,'','" . AddSlashes(pg_result($resaco, 0, 'si181_codunidadesuborig')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011766,'','" . AddSlashes(pg_result($resaco, 0, 'si181_codfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011767,'','" . AddSlashes(pg_result($resaco, 0, 'si181_codsubfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011768,'','" . AddSlashes(pg_result($resaco, 0, 'si181_codprograma')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011769,'','" . AddSlashes(pg_result($resaco, 0, 'si181_idacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011770,'','" . AddSlashes(pg_result($resaco, 0, 'si181_idsubacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011771,'','" . AddSlashes(pg_result($resaco, 0, 'si181_naturezadespesa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011772,'','" . AddSlashes(pg_result($resaco, 0, 'si181_subelemento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011773,'','" . AddSlashes(pg_result($resaco, 0, 'si181_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011774,'','" . AddSlashes(pg_result($resaco, 0, 'si181_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011775,'','" . AddSlashes(pg_result($resaco, 0, 'si181_anoinscricao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011776,'','" . AddSlashes(pg_result($resaco, 0, 'si181_saldoinicialrsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011777,'','" . AddSlashes(pg_result($resaco, 0, 'si181_naturezasaldoinicialrsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011778,'','" . AddSlashes(pg_result($resaco, 0, 'si181_totaldebitosrsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011779,'','" . AddSlashes(pg_result($resaco, 0, 'si181_totalcreditosrsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011780,'','" . AddSlashes(pg_result($resaco, 0, 'si181_saldofinalrsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011781,'','" . AddSlashes(pg_result($resaco, 0, 'si181_naturezasaldofinalrsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011782,'','" . AddSlashes(pg_result($resaco, 0, 'si181_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010196,2011783,'','" . AddSlashes(pg_result($resaco, 0, 'si181_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");*/
      }
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si181_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update balancete142021 set ";
    $virgula = "";
    if (trim($this->si181_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_sequencial"])) {
      $sql .= $virgula . " si181_sequencial = $this->si181_sequencial ";
      $virgula = ",";
      if (trim($this->si181_sequencial) == null) {
        $this->erro_sql = " Campo si181_sequencial não informado.";
        $this->erro_campo = "si181_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_tiporegistro"])) {
      $sql .= $virgula . " si181_tiporegistro = $this->si181_tiporegistro ";
      $virgula = ",";
      if (trim($this->si181_tiporegistro) == null) {
        $this->erro_sql = " Campo si181_tiporegistro não informado.";
        $this->erro_campo = "si181_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_contacontabil"])) {
      $sql .= $virgula . " si181_contacontabil = $this->si181_contacontabil ";
      $virgula = ",";
      if (trim($this->si181_contacontabil) == null) {
        $this->erro_sql = " Campo si181_contacontabil não informado.";
        $this->erro_campo = "si181_contacontabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_codfundo"])) {
      $sql .= $virgula . " si181_codfundo = '$this->si181_codfundo' ";
      $virgula = ",";
      if (trim($this->si181_codfundo) == null) {
        $this->erro_sql = " Campo si181_codfundo não informado.";
        $this->erro_campo = "si181_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_codorgao"])) {
      $sql .= $virgula . " si181_codorgao = '$this->si181_codorgao' ";
      $virgula = ",";
      if (trim($this->si181_codorgao) == null) {
        $this->erro_sql = " Campo si181_codorgao não informado.";
        $this->erro_campo = "si181_codorgao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_codunidadesub"])) {
      $sql .= $virgula . " si181_codunidadesub = '$this->si181_codunidadesub' ";
      $virgula = ",";
      if (trim($this->si181_codunidadesub) == null) {
        $this->erro_sql = " Campo si181_codunidadesub não informado.";
        $this->erro_campo = "si181_codunidadesub";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_codunidadesuborig) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_codunidadesuborig"])) {
      $sql .= $virgula . " si181_codunidadesuborig = '$this->si181_codunidadesuborig' ";
      $virgula = ",";
      if (trim($this->si181_codunidadesuborig) == null) {
        $this->erro_sql = " Campo si181_codunidadesuborig não informado.";
        $this->erro_campo = "si181_codunidadesuborig";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_codfuncao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_codfuncao"])) {
      $sql .= $virgula . " si181_codfuncao = '$this->si181_codfuncao' ";
      $virgula = ",";
      if (trim($this->si181_codfuncao) == null) {
        $this->erro_sql = " Campo si181_codfuncao não informado.";
        $this->erro_campo = "si181_codfuncao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_codsubfuncao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_codsubfuncao"])) {
      $sql .= $virgula . " si181_codsubfuncao = '$this->si181_codsubfuncao' ";
      $virgula = ",";
      if (trim($this->si181_codsubfuncao) == null) {
        $this->erro_sql = " Campo si181_codsubfuncao não informado.";
        $this->erro_campo = "si181_codsubfuncao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_codprograma) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_codprograma"])) {
      $sql .= $virgula . " si181_codprograma = '$this->si181_codprograma' ";
      $virgula = ",";
      if (trim($this->si181_codprograma) == null) {
        $this->erro_sql = " Campo si181_codprograma não informado.";
        $this->erro_campo = "si181_codprograma";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_idacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_idacao"])) {
      $sql .= $virgula . " si181_idacao = '$this->si181_idacao' ";
      $virgula = ",";
      if (trim($this->si181_idacao) == null) {
        $this->erro_sql = " Campo si181_idacao não informado.";
        $this->erro_campo = "si181_idacao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_idsubacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_idsubacao"])) {
      $sql .= $virgula . " si181_idsubacao = '$this->si181_idsubacao' ";
      $virgula = ",";
    }
    if (trim($this->si181_naturezadespesa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_naturezadespesa"])) {
      $sql .= $virgula . " si181_naturezadespesa = $this->si181_naturezadespesa ";
      $virgula = ",";
      if (trim($this->si181_naturezadespesa) == null) {
        $this->erro_sql = " Campo si181_naturezadespesa não informado.";
        $this->erro_campo = "si181_naturezadespesa";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_subelemento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_subelemento"])) {
      $sql .= $virgula . " si181_subelemento = '$this->si181_subelemento' ";
      $virgula = ",";
      if (trim($this->si181_subelemento) == null) {
        $this->erro_sql = " Campo si181_subelemento não informado.";
        $this->erro_campo = "si181_subelemento";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_codfontrecursos"])) {
      $sql .= $virgula . " si181_codfontrecursos = $this->si181_codfontrecursos ";
      $virgula = ",";
      if (trim($this->si181_codfontrecursos) == null) {
        $this->erro_sql = " Campo si181_codfontrecursos não informado.";
        $this->erro_campo = "si181_codfontrecursos";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_nroempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_nroempenho"])) {
      $sql .= $virgula . " si181_nroempenho = $this->si181_nroempenho ";
      $virgula = ",";
      if (trim($this->si181_nroempenho) == null) {
        $this->erro_sql = " Campo si181_nroempenho não informado.";
        $this->erro_campo = "si181_nroempenho";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_anoinscricao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_anoinscricao"])) {
      $sql .= $virgula . " si181_anoinscricao = $this->si181_anoinscricao ";
      $virgula = ",";
      if (trim($this->si181_anoinscricao) == null) {
        $this->erro_sql = " Campo si181_anoinscricao não informado.";
        $this->erro_campo = "si181_anoinscricao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_saldoinicialrsp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_saldoinicialrsp"])) {
      $sql .= $virgula . " si181_saldoinicialrsp = $this->si181_saldoinicialrsp ";
      $virgula = ",";
      if (trim($this->si181_saldoinicialrsp) == null) {
        $this->erro_sql = " Campo si181_saldoinicialrsp não informado.";
        $this->erro_campo = "si181_saldoinicialrsp";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_naturezasaldoinicialrsp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_naturezasaldoinicialrsp"])) {
      $sql .= $virgula . " si181_naturezasaldoinicialrsp = '$this->si181_naturezasaldoinicialrsp' ";
      $virgula = ",";
      if (trim($this->si181_naturezasaldoinicialrsp) == null) {
        $this->erro_sql = " Campo si181_naturezasaldoinicialrsp não informado.";
        $this->erro_campo = "si181_naturezasaldoinicialrsp";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_totaldebitosrsp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_totaldebitosrsp"])) {
      $sql .= $virgula . " si181_totaldebitosrsp = $this->si181_totaldebitosrsp ";
      $virgula = ",";
      if (trim($this->si181_totaldebitosrsp) == null) {
        $this->erro_sql = " Campo si181_totaldebitosrsp não informado.";
        $this->erro_campo = "si181_totaldebitosrsp";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_totalcreditosrsp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_totalcreditosrsp"])) {
      $sql .= $virgula . " si181_totalcreditosrsp = $this->si181_totalcreditosrsp ";
      $virgula = ",";
      if (trim($this->si181_totalcreditosrsp) == null) {
        $this->erro_sql = " Campo si181_totalcreditosrsp não informado.";
        $this->erro_campo = "si181_totalcreditosrsp";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_saldofinalrsp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_saldofinalrsp"])) {
      $sql .= $virgula . " si181_saldofinalrsp = $this->si181_saldofinalrsp ";
      $virgula = ",";
      if (trim($this->si181_saldofinalrsp) == null) {
        $this->erro_sql = " Campo si181_saldofinalrsp não informado.";
        $this->erro_campo = "si181_saldofinalrsp";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_naturezasaldofinalrsp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_naturezasaldofinalrsp"])) {
      $sql .= $virgula . " si181_naturezasaldofinalrsp = '$this->si181_naturezasaldofinalrsp' ";
      $virgula = ",";
      if (trim($this->si181_naturezasaldofinalrsp) == null) {
        $this->erro_sql = " Campo si181_naturezasaldofinalrsp não informado.";
        $this->erro_campo = "si181_naturezasaldofinalrsp";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_mes"])) {
      $sql .= $virgula . " si181_mes = $this->si181_mes ";
      $virgula = ",";
      if (trim($this->si181_mes) == null) {
        $this->erro_sql = " Campo si181_mes não informado.";
        $this->erro_campo = "si181_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si181_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_instit"])) {
      $sql .= $virgula . " si181_instit = $this->si181_instit ";
      $virgula = ",";
      if (trim($this->si181_instit) == null) {
        $this->erro_sql = " Campo si181_instit não informado.";
        $this->erro_campo = "si181_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si181_sequencial != null) {
      $sql .= " si181_sequencial = $this->si181_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si181_sequencial));
      if ($this->numrows > 0) {
        
        for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
          
          /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac, 0, 0);
          $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
          $resac = db_query("insert into db_acountkey values($acount,2011760,'$this->si181_sequencial','A')");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_sequencial"]) || $this->si181_sequencial != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011760,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_sequencial')) . "','$this->si181_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_tiporegistro"]) || $this->si181_tiporegistro != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011761,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_tiporegistro')) . "','$this->si181_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_contacontabil"]) || $this->si181_contacontabil != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011762,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_contacontabil')) . "','$this->si181_contacontabil'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_codorgao"]) || $this->si181_codorgao != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011763,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_codorgao')) . "','$this->si181_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_codunidadesub"]) || $this->si181_codunidadesub != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011764,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_codunidadesub')) . "','$this->si181_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_codunidadesuborig"]) || $this->si181_codunidadesuborig != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011765,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_codunidadesuborig')) . "','$this->si181_codunidadesuborig'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_codfuncao"]) || $this->si181_codfuncao != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011766,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_codfuncao')) . "','$this->si181_codfuncao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_codsubfuncao"]) || $this->si181_codsubfuncao != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011767,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_codsubfuncao')) . "','$this->si181_codsubfuncao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_codprograma"]) || $this->si181_codprograma != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011768,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_codprograma')) . "','$this->si181_codprograma'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_idacao"]) || $this->si181_idacao != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011769,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_idacao')) . "','$this->si181_idacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_idsubacao"]) || $this->si181_idsubacao != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011770,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_idsubacao')) . "','$this->si181_idsubacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_naturezadespesa"]) || $this->si181_naturezadespesa != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011771,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_naturezadespesa')) . "','$this->si181_naturezadespesa'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_subelemento"]) || $this->si181_subelemento != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011772,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_subelemento')) . "','$this->si181_subelemento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_codfontrecursos"]) || $this->si181_codfontrecursos != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011773,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_codfontrecursos')) . "','$this->si181_codfontrecursos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_nroempenho"]) || $this->si181_nroempenho != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011774,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_nroempenho')) . "','$this->si181_nroempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_anoinscricao"]) || $this->si181_anoinscricao != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011775,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_anoinscricao')) . "','$this->si181_anoinscricao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_saldoinicialrsp"]) || $this->si181_saldoinicialrsp != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011776,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_saldoinicialrsp')) . "','$this->si181_saldoinicialrsp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_naturezasaldoinicialrsp"]) || $this->si181_naturezasaldoinicialrsp != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011777,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_naturezasaldoinicialrsp')) . "','$this->si181_naturezasaldoinicialrsp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_totaldebitosrsp"]) || $this->si181_totaldebitosrsp != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011778,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_totaldebitosrsp')) . "','$this->si181_totaldebitosrsp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_totalcreditosrsp"]) || $this->si181_totalcreditosrsp != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011779,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_totalcreditosrsp')) . "','$this->si181_totalcreditosrsp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_saldofinalrsp"]) || $this->si181_saldofinalrsp != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011780,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_saldofinalrsp')) . "','$this->si181_saldofinalrsp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_naturezasaldofinalrsp"]) || $this->si181_naturezasaldofinalrsp != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011781,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_naturezasaldofinalrsp')) . "','$this->si181_naturezasaldofinalrsp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_mes"]) || $this->si181_mes != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011782,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_mes')) . "','$this->si181_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si181_instit"]) || $this->si181_instit != "")
              $resac = db_query("insert into db_acount values($acount,1010196,2011783,'" . AddSlashes(pg_result($resaco, $conresaco, 'si181_instit')) . "','$this->si181_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");*/
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete142021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si181_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete142021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si181_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si181_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si181_sequencial = null, $dbwhere = null)
  {
    
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      if ($dbwhere == null || $dbwhere == "") {
        
        $resaco = $this->sql_record($this->sql_query_file($si181_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
      }
      if (($resaco != false) || ($this->numrows != 0)) {
        
        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
          
          /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac, 0, 0);
          $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
          $resac = db_query("insert into db_acountkey values($acount,2011760,'$si181_sequencial','E')");
          $resac = db_query("insert into db_acount values($acount,1010196,2011760,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011761,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011762,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_contacontabil')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011763,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011764,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011765,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_codunidadesuborig')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011766,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_codfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011767,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_codsubfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011768,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_codprograma')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011769,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_idacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011770,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_idsubacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011771,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_naturezadespesa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011772,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_subelemento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011773,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011774,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011775,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_anoinscricao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011776,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_saldoinicialrsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011777,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_naturezasaldoinicialrsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011778,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_totaldebitosrsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011779,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_totalcreditosrsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011780,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_saldofinalrsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011781,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_naturezasaldofinalrsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011782,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010196,2011783,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si181_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");*/
        }
      }
    }
    $sql = " delete from balancete142021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si181_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si181_sequencial = $si181_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete142021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si181_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete142021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si181_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si181_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:balancete142021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si181_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete142021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si181_sequencial != null) {
        $sql2 .= " where balancete142021.si181_sequencial = $si181_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
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
  function sql_query_file($si181_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete142021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si181_sequencial != null) {
        $sql2 .= " where balancete142021.si181_sequencial = $si181_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
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
