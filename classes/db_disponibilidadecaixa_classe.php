<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE disponibilidadecaixa
class cl_disponibilidadecaixa {
  // cria variaveis de erro
  public $rotulo     = null;
  public $query_sql  = null;
  public $numrows    = 0;
  public $numrows_incluir = 0;
  public $numrows_alterar = 0;
  public $numrows_excluir = 0;
  public $erro_status= null;
  public $erro_sql   = null;
  public $erro_banco = null;
  public $erro_msg   = null;
  public $erro_campo = null;
  public $pagina_retorno = null;
  // cria variaveis do arquivo
  public $c224_sequencial = 0;
  public $c224_fonte = 0;
  public $c224_vlrcaixabruta = 0;
  public $c224_rpexercicioanterior = 0;
  public $c224_vlrrestoarecolher = 0;
  public $c224_vlrrestoregativofinanceiro = 0;
  public $c224_vlrdisponibilidadecaixa = 0;
  public $c224_anousu = 0;
  public $c224_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 c224_sequencial = int8 = Sequencial
                 c224_fonte = int8 = Fonte
                 c224_vlrcaixabruta = float8 = Valor de Caixa Bruta
                 c224_rpexercicioanterior = float8 = RP de Exercicios Anteriores
                 c224_vlrrestoarecolher = float8 = Valor Resto a Recolher
                 c224_vlrrestoregativofinanceiro = float8 = Valores Rest. Reg. Ativo Financeiro
                 c224_vlrdisponibilidadecaixa = float8 = Valor da Disponibilidade
                 c224_anousu = int4 = Ano
                 c224_instit = int4 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("disponibilidadecaixa");
    $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
  }

  //funcao erro
  function erro($mostra,$retorna) {
    if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )) {
      echo "<script>alert(\"".$this->erro_msg."\");</script>";
      if ($retorna==true) {
        echo "<script>location.href='".$this->pagina_retorno."'</script>";
      }
    }
  }

  // funcao para atualizar campos
  function atualizacampos($exclusao=false) {
    if ($exclusao==false) {
       $this->c224_sequencial = ($this->c224_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c224_sequencial"]:$this->c224_sequencial);
       $this->c224_fonte = ($this->c224_fonte == ""?@$GLOBALS["HTTP_POST_VARS"]["c224_fonte"]:$this->c224_fonte);
       $this->c224_vlrcaixabruta = ($this->c224_vlrcaixabruta == ""?@$GLOBALS["HTTP_POST_VARS"]["c224_vlrcaixabruta"]:$this->c224_vlrcaixabruta);
       $this->c224_rpexercicioanterior = ($this->c224_rpexercicioanterior == ""?@$GLOBALS["HTTP_POST_VARS"]["c224_rpexercicioanterior"]:$this->c224_rpexercicioanterior);
       $this->c224_vlrrestoarecolher = ($this->c224_vlrrestoarecolher == ""?@$GLOBALS["HTTP_POST_VARS"]["c224_vlrrestoarecolher"]:$this->c224_vlrrestoarecolher);
       $this->c224_vlrrestoregativofinanceiro = ($this->c224_vlrrestoregativofinanceiro == ""?@$GLOBALS["HTTP_POST_VARS"]["c224_vlrrestoregativofinanceiro"]:$this->c224_vlrrestoregativofinanceiro);
       $this->c224_vlrdisponibilidadecaixa = ($this->c224_vlrdisponibilidadecaixa == ""?@$GLOBALS["HTTP_POST_VARS"]["c224_vlrdisponibilidadecaixa"]:$this->c224_vlrdisponibilidadecaixa);
       $this->c224_anousu = ($this->c224_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c224_anousu"]:$this->c224_anousu);
       $this->c224_instit = ($this->c224_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["c224_instit"]:$this->c224_instit);
     } else {
     }
   }

  // funcao para inclusao
  function incluir () {
      $this->atualizacampos();
//     if ($this->c224_sequencial == null ) {
//       $this->erro_sql = " Campo Sequencial não informado.";
//       $this->erro_campo = "c224_sequencial";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
     if ($this->c224_fonte == null ) {
       $this->erro_sql = " Campo Fonte não informado.";
       $this->erro_campo = "c224_fonte";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c224_vlrcaixabruta == null ) {
       $this->erro_sql = " Campo Valor de Caixa Bruta não informado.";
       $this->erro_campo = "c224_vlrcaixabruta";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c224_rpexercicioanterior == null ) {
       $this->erro_sql = " Campo RP de Exercicios Anteriores não informado.";
       $this->erro_campo = "c224_rpexercicioanterior";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
//     if ($this->c224_vlrrestoarecolher == null ) {
//       $this->erro_sql = " Campo Valor Resto a Recolher não informado.";
//       $this->erro_campo = "c224_vlrrestoarecolher";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
//     if ($this->c224_vlrrestoregativofinanceiro == null ) {
//       $this->erro_sql = " Campo Valores Rest. Reg. Ativo Financeiro não informado.";
//       $this->erro_campo = "c224_vlrrestoregativofinanceiro";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
     if ($this->c224_vlrdisponibilidadecaixa == null ) {
       $this->erro_sql = " Campo Valor da Disponibilidade não informado.";
       $this->erro_campo = "c224_vlrdisponibilidadecaixa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c224_anousu == null ) {
       $this->erro_sql = " Campo Ano não informado.";
       $this->erro_campo = "c224_anousu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c224_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "c224_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into disponibilidadecaixa(
                                       c224_sequencial
                                      ,c224_fonte
                                      ,c224_vlrcaixabruta
                                      ,c224_rpexercicioanterior
                                      ,c224_vlrrestoarecolher
                                      ,c224_vlrrestoregativofinanceiro
                                      ,c224_vlrdisponibilidadecaixa
                                      ,c224_anousu
                                      ,c224_instit
                       )
                values (
                                nextval('disponibilidadecaixa_c224_sequencial_seq')
                               ,$this->c224_fonte
                               ,$this->c224_vlrcaixabruta
                               ,$this->c224_rpexercicioanterior
                               ,".($this->c224_vlrrestoarecolher == "null" || $this->c224_vlrrestoarecolher == ""?"null":"'".$this->c224_vlrrestoarecolher."'")."
                               ,".($this->c224_vlrrestoregativofinanceiro == "null" || $this->c224_vlrrestoregativofinanceiro == ""?"null":"'".$this->c224_vlrrestoregativofinanceiro."'")."
                               ,$this->c224_vlrdisponibilidadecaixa
                               ,$this->c224_anousu
                               ,$this->c224_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "disponibilidadecaixa () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "disponibilidadecaixa já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "disponibilidadecaixa () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

    }
    return true;
  }

  // funcao para alteracao
  function alterar ( $oid=null ) {
      $this->atualizacampos();
     $sql = " update disponibilidadecaixa set ";
     $virgula = "";
//     if (trim($this->c224_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c224_sequencial"])) {
//       $sql  .= $virgula." c224_sequencial = $this->c224_sequencial ";
//       $virgula = ",";
//       if (trim($this->c224_sequencial) == null ) {
//         $this->erro_sql = " Campo Sequencial não informado.";
//         $this->erro_campo = "c224_sequencial";
//         $this->erro_banco = "";
//         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//         $this->erro_status = "0";
//         return false;
//       }
//     }
     if (trim($this->c224_fonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c224_fonte"])) {
       $sql  .= $virgula." c224_fonte = $this->c224_fonte ";
       $virgula = ",";
       if (trim($this->c224_fonte) == null ) {
         $this->erro_sql = " Campo Fonte não informado.";
         $this->erro_campo = "c224_fonte";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c224_vlrcaixabruta)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c224_vlrcaixabruta"])) {
       $sql  .= $virgula." c224_vlrcaixabruta = $this->c224_vlrcaixabruta ";
       $virgula = ",";
       if (trim($this->c224_vlrcaixabruta) == null ) {
         $this->erro_sql = " Campo Valor de Caixa Bruta não informado.";
         $this->erro_campo = "c224_vlrcaixabruta";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c224_rpexercicioanterior)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c224_rpexercicioanterior"])) {
       $sql  .= $virgula." c224_rpexercicioanterior = $this->c224_rpexercicioanterior ";
       $virgula = ",";
       if (trim($this->c224_rpexercicioanterior) == null ) {
         $this->erro_sql = " Campo RP de Exercicios Anteriores não informado.";
         $this->erro_campo = "c224_rpexercicioanterior";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c224_vlrrestoarecolher)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c224_vlrrestoarecolher"])) {
       $sql  .= $virgula." c224_vlrrestoarecolher = $this->c224_vlrrestoarecolher ";
       $virgula = ",";
       if (trim($this->c224_vlrrestoarecolher) == null ) {
         $this->erro_sql = " Campo Valor Resto a Recolher não informado.";
         $this->erro_campo = "c224_vlrrestoarecolher";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c224_vlrrestoregativofinanceiro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c224_vlrrestoregativofinanceiro"])) {
       $sql  .= $virgula." c224_vlrrestoregativofinanceiro = $this->c224_vlrrestoregativofinanceiro ";
       $virgula = ",";
       if (trim($this->c224_vlrrestoregativofinanceiro) == null ) {
         $this->erro_sql = " Campo Valores Rest. Reg. Ativo Financeiro não informado.";
         $this->erro_campo = "c224_vlrrestoregativofinanceiro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c224_vlrdisponibilidadecaixa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c224_vlrdisponibilidadecaixa"])) {
       $sql  .= $virgula." c224_vlrdisponibilidadecaixa = $this->c224_vlrdisponibilidadecaixa ";
       $virgula = ",";
       if (trim($this->c224_vlrdisponibilidadecaixa) == null ) {
         $this->erro_sql = " Campo Valor da Disponibilidade não informado.";
         $this->erro_campo = "c224_vlrdisponibilidadecaixa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c224_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c224_anousu"])) {
       $sql  .= $virgula." c224_anousu = $this->c224_anousu ";
       $virgula = ",";
       if (trim($this->c224_anousu) == null ) {
         $this->erro_sql = " Campo Ano não informado.";
         $this->erro_campo = "c224_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c224_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c224_instit"])) {
       $sql  .= $virgula." c224_instit = $this->c224_instit ";
       $virgula = ",";
       if (trim($this->c224_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "c224_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
$sql .= "c224_fonte = '$this->c224_fonte'";     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "disponibilidadecaixa nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "disponibilidadecaixa nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ( $oid=null ,$dbwhere=null) {

     $sql = " delete from disponibilidadecaixa
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
       $sql2 = "oid = '$oid'";
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "disponibilidadecaixa nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "disponibilidadecaixa nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = pg_affected_rows($result);
         return true;
      }
    }
  }

  // funcao do recordset
  function sql_record($sql) {
     $result = db_query($sql);
     if ($result==false) {
       $this->numrows    = 0;
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if ($this->numrows==0) {
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:disponibilidadecaixa";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $oid = null,$campos="disponibilidadecaixa.oid,*",$ordem=null,$dbwhere="") {
     $sql = "select ";
     if ($campos != "*" ) {
       $campos_sql = explode("#", $campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     } else {
       $sql .= $campos;
     }
     $sql .= " from disponibilidadecaixa ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $oid != "" && $oid != null) {
          $sql2 = " where disponibilidadecaixa.oid = '$oid'";
       }
     } else if ($dbwhere != "") {
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if ($ordem != null ) {
       $sql .= " order by ";
       $campos_sql = explode("#", $ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
      }
    }
    return $sql;
  }

  // funcao do sql
  function sql_query_file ( $oid = null,$campos="*",$ordem=null,$dbwhere="") {
     $sql = "select ";
     if ($campos != "*" ) {
       $campos_sql = explode("#", $campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     } else {
       $sql .= $campos;
     }
     $sql .= " from disponibilidadecaixa ";
     $sql2 = "";
     if ($dbwhere=="") {
     } else if ($dbwhere != "") {
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if ($ordem != null ) {
       $sql .= " order by ";
       $campos_sql = explode("#", $ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++) {
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
      }
    }
    return $sql;
  }
}
?>
