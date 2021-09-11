<?php
//MODULO: orcamento
//CLASSE DA ENTIDADE mtfis_anexo
class cl_mtfis_anexo {
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
  public $mtfisanexo_sequencial = 0;
  public $mtfisanexo_especificacao = null;
  public $mtfisanexo_valorcorrente1 = 0;
  public $mtfisanexo_valorcorrente2 = 0;
  public $mtfisanexo_valorcorrente3 = 0;
  public $mtfisanexo_valorconstante1 = 0;
  public $mtfisanexo_valorconstante2 = 0;
  public $mtfisanexo_valorconstante3 = 0;
  public $mtfisanexo_ldo = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 mtfisanexo_sequencial = int4 = Sequencial
                 mtfisanexo_especificacao = varchar(255) = Especificação
                 mtfisanexo_valorcorrente1 = float4 = Valor Corrente 1
                 mtfisanexo_valorcorrente2 = float4 = Valor Corrente 2
                 mtfisanexo_valorcorrente3 = float4 = Valor Corrente 3
                 mtfisanexo_valorconstante1 = float4 = Valor Constante 1
                 mtfisanexo_valorconstante2 = float4 = Valor Constante 2
                 mtfisanexo_valorconstante3 = float4 = Valor Constante 3
                 mtfisanexo_ldo = int4 = mtfisanexo_ldo
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("mtfis_anexo");
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
       $this->mtfisanexo_sequencial = ($this->mtfisanexo_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfisanexo_sequencial"]:$this->mtfisanexo_sequencial);
       $this->mtfisanexo_especificacao = ($this->mtfisanexo_especificacao == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfisanexo_especificacao"]:$this->mtfisanexo_especificacao);
       $this->mtfisanexo_valorcorrente1 = ($this->mtfisanexo_valorcorrente1 == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorcorrente1"]:$this->mtfisanexo_valorcorrente1);
       $this->mtfisanexo_valorcorrente2 = ($this->mtfisanexo_valorcorrente2 == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorcorrente2"]:$this->mtfisanexo_valorcorrente2);
       $this->mtfisanexo_valorcorrente3 = ($this->mtfisanexo_valorcorrente3 == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorcorrente3"]:$this->mtfisanexo_valorcorrente3);
       $this->mtfisanexo_valorconstante1 = ($this->mtfisanexo_valorconstante1 == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorconstante1"]:$this->mtfisanexo_valorconstante1);
       $this->mtfisanexo_valorconstante2 = ($this->mtfisanexo_valorconstante2 == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorconstante2"]:$this->mtfisanexo_valorconstante2);
       $this->mtfisanexo_valorconstante3 = ($this->mtfisanexo_valorconstante3 == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorconstante3"]:$this->mtfisanexo_valorconstante3);
       $this->mtfisanexo_ldo = ($this->mtfisanexo_ldo == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfisanexo_ldo"]:$this->mtfisanexo_ldo);
     } else {
       $this->mtfisanexo_sequencial = ($this->mtfisanexo_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["mtfisanexo_sequencial"]:$this->mtfisanexo_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($mtfisanexo_sequencial) {

      $this->atualizacampos();

      if ($this->mtfisanexo_especificacao == null ) {
       $this->erro_sql = " Campo Especificação não informado.";
       $this->erro_campo = "mtfisanexo_especificacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->mtfisanexo_valorcorrente1 == null ) {
       $this->erro_sql = " Campo Valor Corrente 1 não informado.";
       $this->erro_campo = "mtfisanexo_valorcorrente1";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->mtfisanexo_valorcorrente2 == null ) {
       $this->erro_sql = " Campo Valor Corrente 2 não informado.";
       $this->erro_campo = "mtfisanexo_valorcorrente2";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->mtfisanexo_valorcorrente3 == null ) {
       $this->erro_sql = " Campo Valor Corrente 3 não informado.";
       $this->erro_campo = "mtfisanexo_valorcorrente3";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->mtfisanexo_valorconstante1 == null ) {
       $this->erro_sql = " Campo Valor Constante 1 não informado.";
       $this->erro_campo = "mtfisanexo_valorconstante1";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->mtfisanexo_valorconstante2 == null ) {
       $this->erro_sql = " Campo Valor Constante 2 não informado.";
       $this->erro_campo = "mtfisanexo_valorconstante2";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->mtfisanexo_valorconstante3 == null ) {
       $this->erro_sql = " Campo Valor Constante 3 não informado.";
       $this->erro_campo = "mtfisanexo_valorconstante3";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->mtfisanexo_ldo == null ) {
       $this->erro_sql = " Campo mtfisanexo_ldo não informado.";
       $this->erro_campo = "mtfisanexo_ldo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if ($mtfisanexo_sequencial == "" || $mtfisanexo_sequencial == null ) {
       $result = db_query("select nextval('mtfis_anexo_mtfisanexo_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: mtfis_anexo_mtfisanexo_sequencial_seq do campo: mtfisanexo_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->mtfisanexo_sequencial = pg_result($result,0,0);
     } else {

       $result = db_query("select last_value from mtfis_anexo_mtfisanexo_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $mtfisanexo_sequencial)) {
         $this->erro_sql = " Campo mtfisanexo_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->mtfisanexo_sequencial = $mtfisanexo_sequencial;
       }
     }
     if (($this->mtfisanexo_sequencial == null) || ($this->mtfisanexo_sequencial == "") ) {
       $this->erro_sql = " Campo mtfisanexo_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into mtfis_anexo(
                                       mtfisanexo_sequencial
                                      ,mtfisanexo_especificacao
                                      ,mtfisanexo_valorcorrente1
                                      ,mtfisanexo_valorcorrente2
                                      ,mtfisanexo_valorcorrente3
                                      ,mtfisanexo_valorconstante1
                                      ,mtfisanexo_valorconstante2
                                      ,mtfisanexo_valorconstante3
                                      ,mtfisanexo_ldo
                       )
                values (
                                $this->mtfisanexo_sequencial
                               ,'$this->mtfisanexo_especificacao'
                               ,$this->mtfisanexo_valorcorrente1
                               ,$this->mtfisanexo_valorcorrente2
                               ,$this->mtfisanexo_valorcorrente3
                               ,$this->mtfisanexo_valorconstante1
                               ,$this->mtfisanexo_valorconstante2
                               ,$this->mtfisanexo_valorconstante3
                               ,$this->mtfisanexo_ldo
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "mtfis ($this->mtfisanexo_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "mtfis já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "mtfis ($this->mtfisanexo_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->mtfisanexo_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
//     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
//       && ($lSessaoDesativarAccount === false))) {
//
//       $resaco = $this->sql_record($this->sql_query_file($this->mtfisanexo_sequencial  ));
//       if (($resaco!=false)||($this->numrows!=0)) {
//
//         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//         $acount = pg_result($resac,0,0);
//         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
//         $resac = db_query("insert into db_acountkey values($acount,2012487,'$this->mtfisanexo_sequencial','I')");
//         $resac = db_query("insert into db_acount values($acount,1010194,2012487,'','".AddSlashes(pg_result($resaco,0,'mtfisanexo_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010194,2012488,'','".AddSlashes(pg_result($resaco,0,'mtfisanexo_especificacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010194,2012489,'','".AddSlashes(pg_result($resaco,0,'mtfisanexo_valorcorrente1'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010194,2012490,'','".AddSlashes(pg_result($resaco,0,'mtfisanexo_valorcorrente2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010194,2012491,'','".AddSlashes(pg_result($resaco,0,'mtfisanexo_valorcorrente3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010194,2012492,'','".AddSlashes(pg_result($resaco,0,'mtfisanexo_valorconstante1'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010194,2012493,'','".AddSlashes(pg_result($resaco,0,'mtfisanexo_valorconstante2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010194,2012494,'','".AddSlashes(pg_result($resaco,0,'mtfisanexo_valorconstante3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         $resac = db_query("insert into db_acount values($acount,1010194,2012495,'','".AddSlashes(pg_result($resaco,0,'mtfisanexo_ldo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//       }
//    }
    return true;
  }

  // funcao para alteracao
  function alterar ($mtfisanexo_sequencial=null) {
      $this->atualizacampos();
     $sql = " update mtfis_anexo set ";
     $virgula = "";
     if (trim($this->mtfisanexo_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_sequencial"])) {
       $sql  .= $virgula." mtfisanexo_sequencial = $this->mtfisanexo_sequencial ";
       $virgula = ",";
       if (trim($this->mtfisanexo_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "mtfisanexo_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfisanexo_especificacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_especificacao"])) {
       $sql  .= $virgula." mtfisanexo_especificacao = '$this->mtfisanexo_especificacao' ";
       $virgula = ",";
       if (trim($this->mtfisanexo_especificacao) == null ) {
         $this->erro_sql = " Campo Especificação não informado.";
         $this->erro_campo = "mtfisanexo_especificacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfisanexo_valorcorrente1)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorcorrente1"])) {
       $sql  .= $virgula." mtfisanexo_valorcorrente1 = $this->mtfisanexo_valorcorrente1 ";
       $virgula = ",";
       if (trim($this->mtfisanexo_valorcorrente1) == null ) {
         $this->erro_sql = " Campo Valor Corrente 1 não informado.";
         $this->erro_campo = "mtfisanexo_valorcorrente1";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfisanexo_valorcorrente2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorcorrente2"])) {
       $sql  .= $virgula." mtfisanexo_valorcorrente2 = $this->mtfisanexo_valorcorrente2 ";
       $virgula = ",";
       if (trim($this->mtfisanexo_valorcorrente2) == null ) {
         $this->erro_sql = " Campo Valor Corrente 2 não informado.";
         $this->erro_campo = "mtfisanexo_valorcorrente2";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfisanexo_valorcorrente3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorcorrente3"])) {
       $sql  .= $virgula." mtfisanexo_valorcorrente3 = $this->mtfisanexo_valorcorrente3 ";
       $virgula = ",";
       if (trim($this->mtfisanexo_valorcorrente3) == null ) {
         $this->erro_sql = " Campo Valor Corrente 3 não informado.";
         $this->erro_campo = "mtfisanexo_valorcorrente3";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfisanexo_valorconstante1)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorconstante1"])) {
       $sql  .= $virgula." mtfisanexo_valorconstante1 = $this->mtfisanexo_valorconstante1 ";
       $virgula = ",";
       if (trim($this->mtfisanexo_valorconstante1) == null ) {
         $this->erro_sql = " Campo Valor Constante 1 não informado.";
         $this->erro_campo = "mtfisanexo_valorconstante1";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfisanexo_valorconstante2)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorconstante2"])) {
       $sql  .= $virgula." mtfisanexo_valorconstante2 = $this->mtfisanexo_valorconstante2 ";
       $virgula = ",";
       if (trim($this->mtfisanexo_valorconstante2) == null ) {
         $this->erro_sql = " Campo Valor Constante 2 não informado.";
         $this->erro_campo = "mtfisanexo_valorconstante2";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfisanexo_valorconstante3)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorconstante3"])) {
       $sql  .= $virgula." mtfisanexo_valorconstante3 = $this->mtfisanexo_valorconstante3 ";
       $virgula = ",";
       if (trim($this->mtfisanexo_valorconstante3) == null ) {
         $this->erro_sql = " Campo Valor Constante 3 não informado.";
         $this->erro_campo = "mtfisanexo_valorconstante3";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->mtfisanexo_ldo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_ldo"])) {
       $sql  .= $virgula." mtfisanexo_ldo = $this->mtfisanexo_ldo ";
       $virgula = ",";
       if (trim($this->mtfisanexo_ldo) == null ) {
         $this->erro_sql = " Campo mtfisanexo_ldo não informado.";
         $this->erro_campo = "mtfisanexo_ldo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($mtfisanexo_sequencial!=null) {
       $sql .= " mtfisanexo_sequencial = $this->mtfisanexo_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->mtfisanexo_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2012487,'$this->mtfisanexo_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_sequencial"]) || $this->mtfisanexo_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2012487,'".AddSlashes(pg_result($resaco,$conresaco,'mtfisanexo_sequencial'))."','$this->mtfisanexo_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_especificacao"]) || $this->mtfisanexo_especificacao != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2012488,'".AddSlashes(pg_result($resaco,$conresaco,'mtfisanexo_especificacao'))."','$this->mtfisanexo_especificacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorcorrente1"]) || $this->mtfisanexo_valorcorrente1 != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2012489,'".AddSlashes(pg_result($resaco,$conresaco,'mtfisanexo_valorcorrente1'))."','$this->mtfisanexo_valorcorrente1',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorcorrente2"]) || $this->mtfisanexo_valorcorrente2 != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2012490,'".AddSlashes(pg_result($resaco,$conresaco,'mtfisanexo_valorcorrente2'))."','$this->mtfisanexo_valorcorrente2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorcorrente3"]) || $this->mtfisanexo_valorcorrente3 != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2012491,'".AddSlashes(pg_result($resaco,$conresaco,'mtfisanexo_valorcorrente3'))."','$this->mtfisanexo_valorcorrente3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorconstante1"]) || $this->mtfisanexo_valorconstante1 != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2012492,'".AddSlashes(pg_result($resaco,$conresaco,'mtfisanexo_valorconstante1'))."','$this->mtfisanexo_valorconstante1',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorconstante2"]) || $this->mtfisanexo_valorconstante2 != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2012493,'".AddSlashes(pg_result($resaco,$conresaco,'mtfisanexo_valorconstante2'))."','$this->mtfisanexo_valorconstante2',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_valorconstante3"]) || $this->mtfisanexo_valorconstante3 != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2012494,'".AddSlashes(pg_result($resaco,$conresaco,'mtfisanexo_valorconstante3'))."','$this->mtfisanexo_valorconstante3',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["mtfisanexo_ldo"]) || $this->mtfisanexo_ldo != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2012495,'".AddSlashes(pg_result($resaco,$conresaco,'mtfisanexo_ldo'))."','$this->mtfisanexo_ldo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "mtfis nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->mtfisanexo_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "mtfis nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->mtfisanexo_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->mtfisanexo_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($mtfisanexo_sequencial=null,$dbwhere=null) {

//     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
//     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
//       && ($lSessaoDesativarAccount === false))) {
//
//       if ($dbwhere==null || $dbwhere=="") {
//
//         $resaco = $this->sql_record($this->sql_query_file($mtfisanexo_sequencial));
//       } else {
//         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
//       }
//       if (($resaco != false) || ($this->numrows!=0)) {
//
//         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
//
//           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
//           $acount = pg_result($resac,0,0);
//           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
//           $resac  = db_query("insert into db_acountkey values($acount,2012487,'$mtfisanexo_sequencial','E')");
//           $resac  = db_query("insert into db_acount values($acount,1010194,2012487,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfisanexo_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           $resac  = db_query("insert into db_acount values($acount,1010194,2012488,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfisanexo_especificacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           $resac  = db_query("insert into db_acount values($acount,1010194,2012489,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfisanexo_valorcorrente1'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           $resac  = db_query("insert into db_acount values($acount,1010194,2012490,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfisanexo_valorcorrente2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           $resac  = db_query("insert into db_acount values($acount,1010194,2012491,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfisanexo_valorcorrente3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           $resac  = db_query("insert into db_acount values($acount,1010194,2012492,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfisanexo_valorconstante1'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           $resac  = db_query("insert into db_acount values($acount,1010194,2012493,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfisanexo_valorconstante2'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           $resac  = db_query("insert into db_acount values($acount,1010194,2012494,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfisanexo_valorconstante3'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//           $resac  = db_query("insert into db_acount values($acount,1010194,2012495,'','".AddSlashes(pg_result($resaco,$iresaco,'mtfisanexo_ldo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         }
//       }
//     }
     $sql = " delete from mtfis_anexo
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($mtfisanexo_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " mtfisanexo_sequencial = $mtfisanexo_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "mtfis nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$mtfisanexo_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "mtfis nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$mtfisanexo_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$mtfisanexo_sequencial;
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
     die('erro');
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
        $this->erro_sql   = "Record Vazio na Tabela:mtfis_anexo";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $mtfisanexo_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from mtfis_anexo ";
     $sql .= "      inner join mtfis_ldo  on  mtfis_ldo.mtfis_sequencial = mtfis_anexo.mtfisanexo_ldo";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($mtfisanexo_sequencial!=null ) {
         $sql2 .= " where mtfis_anexo.mtfisanexo_sequencial = $mtfisanexo_sequencial ";
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
  function sql_query_file ( $mtfisanexo_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from mtfis_anexo ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($mtfisanexo_sequencial!=null ) {
         $sql2 .= " where mtfis_anexo.mtfisanexo_sequencial = $mtfisanexo_sequencial ";
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
}
?>
