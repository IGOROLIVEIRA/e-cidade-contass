<?php
//MODULO: esocial
//CLASSE DA ENTIDADE evt5001consulta
class cl_evt5001consulta { 
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
  public $rh218_sequencial = 0; 
  public $rh218_perapurano = 0; 
  public $rh218_perapurmes = 0; 
  public $rh218_indapuracao = 0; 
  public $rh218_regist = 0; 
  public $rh218_codcateg = 0; 
  public $rh218_nrrecarqbase = null; 
  public $rh218_tpcr = null; 
  public $rh218_vrdescseg = 0; 
  public $rh218_vrcpseg = 0; 
  public $rh218_instit = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 rh218_sequencial = int8 = C�digo Sequencial 
                 rh218_perapurano = int4 = Per�odo Apura��o Ano 
                 rh218_perapurmes = int4 = Per�odo Apura��o M�s 
                 rh218_indapuracao = int4 = Indicativo de Per�odo de Apura��o 
                 rh218_regist = int8 = Matr�cula 
                 rh218_codcateg = int4 = Categoria 
                 rh218_nrrecarqbase = varchar(100) = Recibo 
                 rh218_tpcr = varchar(10) = C�digo de Receita 
                 rh218_vrdescseg = float8 = Desconto Realizado 
                 rh218_vrcpseg = float8 = Valor Devido 
                 rh218_instit = int8 = Institui��o 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("evt5001consulta"); 
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
       $this->rh218_sequencial = ($this->rh218_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh218_sequencial"]:$this->rh218_sequencial);
       $this->rh218_perapurano = ($this->rh218_perapurano == ""?@$GLOBALS["HTTP_POST_VARS"]["rh218_perapurano"]:$this->rh218_perapurano);
       $this->rh218_perapurmes = ($this->rh218_perapurmes == ""?@$GLOBALS["HTTP_POST_VARS"]["rh218_perapurmes"]:$this->rh218_perapurmes);
       $this->rh218_indapuracao = ($this->rh218_indapuracao == ""?@$GLOBALS["HTTP_POST_VARS"]["rh218_indapuracao"]:$this->rh218_indapuracao);
       $this->rh218_regist = ($this->rh218_regist == ""?@$GLOBALS["HTTP_POST_VARS"]["rh218_regist"]:$this->rh218_regist);
       $this->rh218_codcateg = ($this->rh218_codcateg == ""?@$GLOBALS["HTTP_POST_VARS"]["rh218_codcateg"]:$this->rh218_codcateg);
       $this->rh218_nrrecarqbase = ($this->rh218_nrrecarqbase == ""?@$GLOBALS["HTTP_POST_VARS"]["rh218_nrrecarqbase"]:$this->rh218_nrrecarqbase);
       $this->rh218_tpcr = ($this->rh218_tpcr == ""?@$GLOBALS["HTTP_POST_VARS"]["rh218_tpcr"]:$this->rh218_tpcr);
       $this->rh218_vrdescseg = ($this->rh218_vrdescseg == ""?@$GLOBALS["HTTP_POST_VARS"]["rh218_vrdescseg"]:$this->rh218_vrdescseg);
       $this->rh218_vrcpseg = ($this->rh218_vrcpseg == ""?@$GLOBALS["HTTP_POST_VARS"]["rh218_vrcpseg"]:$this->rh218_vrcpseg);
       $this->rh218_instit = ($this->rh218_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["rh218_instit"]:$this->rh218_instit);
     } else {
       $this->rh218_sequencial = ($this->rh218_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh218_sequencial"]:$this->rh218_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($rh218_sequencial) { 
      $this->atualizacampos();
     if ($this->rh218_perapurano == null ) { 
       $this->erro_sql = " Campo Per�odo Apura��o Ano n�o informado.";
       $this->erro_campo = "rh218_perapurano";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh218_indapuracao == null ) { 
       $this->erro_sql = " Campo Indicativo de Per�odo de Apura��o n�o informado.";
       $this->erro_campo = "rh218_indapuracao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh218_regist == null ) { 
       $this->erro_sql = " Campo Matr�cula n�o informado.";
       $this->erro_campo = "rh218_regist";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh218_codcateg == null ) { 
       $this->erro_sql = " Campo Categoria n�o informado.";
       $this->erro_campo = "rh218_codcateg";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh218_nrrecarqbase == null ) { 
       $this->erro_sql = " Campo Recibo n�o informado.";
       $this->erro_campo = "rh218_nrrecarqbase";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh218_tpcr == null ) { 
       $this->erro_sql = " Campo C�digo de Receita n�o informado.";
       $this->erro_campo = "rh218_tpcr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh218_vrdescseg == null ) { 
       $this->erro_sql = " Campo Desconto Realizado n�o informado.";
       $this->erro_campo = "rh218_vrdescseg";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh218_vrcpseg == null ) { 
       $this->erro_sql = " Campo Valor Devido n�o informado.";
       $this->erro_campo = "rh218_vrcpseg";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh218_instit == null ) { 
       $this->erro_sql = " Campo Institui��o n�o informado.";
       $this->erro_campo = "rh218_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($rh218_sequencial == "" || $rh218_sequencial == null ) {
       $result = db_query("select nextval('evt5001consulta_rh218_sequencial_seq')"); 
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: evt5001consulta_rh218_sequencial_seq do campo: rh218_sequencial"; 
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->rh218_sequencial = pg_result($result,0,0); 
     } else {
       $result = db_query("select last_value from evt5001consulta_rh218_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $rh218_sequencial)) {
         $this->erro_sql = " Campo rh218_sequencial maior que �ltimo n�mero da sequencia.";
         $this->erro_banco = "Sequencia menor que este n�mero.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->rh218_sequencial = $rh218_sequencial; 
       }
     }
     if (($this->rh218_sequencial == null) || ($this->rh218_sequencial == "") ) { 
       $this->erro_sql = " Campo rh218_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into evt5001consulta(
                                       rh218_sequencial 
                                      ,rh218_perapurano 
                                      ,rh218_perapurmes 
                                      ,rh218_indapuracao 
                                      ,rh218_regist 
                                      ,rh218_codcateg 
                                      ,rh218_nrrecarqbase 
                                      ,rh218_tpcr 
                                      ,rh218_vrdescseg 
                                      ,rh218_vrcpseg 
                                      ,rh218_instit 
                       )
                values (
                                $this->rh218_sequencial 
                               ,$this->rh218_perapurano 
                               ,".(empty($this->rh218_perapurmes) ? 'NULL' : $this->rh218_perapurmes )." 
                               ,$this->rh218_indapuracao 
                               ,$this->rh218_regist 
                               ,$this->rh218_codcateg 
                               ,'$this->rh218_nrrecarqbase' 
                               ,'$this->rh218_tpcr' 
                               ,$this->rh218_vrdescseg 
                               ,$this->rh218_vrcpseg 
                               ,$this->rh218_instit 
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Consulta do evento 5001 ($this->rh218_sequencial) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Consulta do evento 5001 j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Consulta do evento 5001 ($this->rh218_sequencial) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh218_sequencial;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh218_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009254,'$this->rh218_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010192,1009254,'','".AddSlashes(pg_result($resaco,0,'rh218_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009244,'','".AddSlashes(pg_result($resaco,0,'rh218_perapurano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009245,'','".AddSlashes(pg_result($resaco,0,'rh218_perapurmes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009246,'','".AddSlashes(pg_result($resaco,0,'rh218_indapuracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009247,'','".AddSlashes(pg_result($resaco,0,'rh218_regist'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009248,'','".AddSlashes(pg_result($resaco,0,'rh218_codcateg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009250,'','".AddSlashes(pg_result($resaco,0,'rh218_nrrecarqbase'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009251,'','".AddSlashes(pg_result($resaco,0,'rh218_tpcr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009252,'','".AddSlashes(pg_result($resaco,0,'rh218_vrdescseg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009253,'','".AddSlashes(pg_result($resaco,0,'rh218_vrcpseg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009255,'','".AddSlashes(pg_result($resaco,0,'rh218_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($rh218_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update evt5001consulta set ";
     $virgula = "";
     if (trim($this->rh218_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh218_sequencial"])) { 
       $sql  .= $virgula." rh218_sequencial = $this->rh218_sequencial ";
       $virgula = ",";
       if (trim($this->rh218_sequencial) == null ) { 
         $this->erro_sql = " Campo C�digo Sequencial n�o informado.";
         $this->erro_campo = "rh218_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh218_perapurano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh218_perapurano"])) { 
       $sql  .= $virgula." rh218_perapurano = $this->rh218_perapurano ";
       $virgula = ",";
       if (trim($this->rh218_perapurano) == null ) { 
         $this->erro_sql = " Campo Per�odo Apura��o Ano n�o informado.";
         $this->erro_campo = "rh218_perapurano";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh218_perapurmes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh218_perapurmes"])) { 
       $sql  .= $virgula." rh218_perapurmes = $this->rh218_perapurmes ";
       $virgula = ",";
       if (trim($this->rh218_perapurmes) == null ) { 
         $this->erro_sql = " Campo Per�odo Apura��o M�s n�o informado.";
         $this->erro_campo = "rh218_perapurmes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh218_indapuracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh218_indapuracao"])) { 
       $sql  .= $virgula." rh218_indapuracao = $this->rh218_indapuracao ";
       $virgula = ",";
       if (trim($this->rh218_indapuracao) == null ) { 
         $this->erro_sql = " Campo Indicativo de Per�odo de Apura��o n�o informado.";
         $this->erro_campo = "rh218_indapuracao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh218_regist)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh218_regist"])) { 
       $sql  .= $virgula." rh218_regist = $this->rh218_regist ";
       $virgula = ",";
       if (trim($this->rh218_regist) == null ) { 
         $this->erro_sql = " Campo Matr�cula n�o informado.";
         $this->erro_campo = "rh218_regist";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh218_codcateg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh218_codcateg"])) { 
       $sql  .= $virgula." rh218_codcateg = $this->rh218_codcateg ";
       $virgula = ",";
       if (trim($this->rh218_codcateg) == null ) { 
         $this->erro_sql = " Campo Categoria n�o informado.";
         $this->erro_campo = "rh218_codcateg";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh218_nrrecarqbase)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh218_nrrecarqbase"])) { 
       $sql  .= $virgula." rh218_nrrecarqbase = '$this->rh218_nrrecarqbase' ";
       $virgula = ",";
       if (trim($this->rh218_nrrecarqbase) == null ) { 
         $this->erro_sql = " Campo Recibo n�o informado.";
         $this->erro_campo = "rh218_nrrecarqbase";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh218_tpcr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh218_tpcr"])) { 
       $sql  .= $virgula." rh218_tpcr = '$this->rh218_tpcr' ";
       $virgula = ",";
       if (trim($this->rh218_tpcr) == null ) { 
         $this->erro_sql = " Campo C�digo de Receita n�o informado.";
         $this->erro_campo = "rh218_tpcr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh218_vrdescseg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh218_vrdescseg"])) { 
       $sql  .= $virgula." rh218_vrdescseg = $this->rh218_vrdescseg ";
       $virgula = ",";
       if (trim($this->rh218_vrdescseg) == null ) { 
         $this->erro_sql = " Campo Desconto Realizado n�o informado.";
         $this->erro_campo = "rh218_vrdescseg";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh218_vrcpseg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh218_vrcpseg"])) { 
       $sql  .= $virgula." rh218_vrcpseg = $this->rh218_vrcpseg ";
       $virgula = ",";
       if (trim($this->rh218_vrcpseg) == null ) { 
         $this->erro_sql = " Campo Valor Devido n�o informado.";
         $this->erro_campo = "rh218_vrcpseg";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh218_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh218_instit"])) { 
       $sql  .= $virgula." rh218_instit = $this->rh218_instit ";
       $virgula = ",";
       if (trim($this->rh218_instit) == null ) { 
         $this->erro_sql = " Campo Institui��o n�o informado.";
         $this->erro_campo = "rh218_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($rh218_sequencial!=null) {
       $sql .= " rh218_sequencial = $this->rh218_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh218_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009254,'$this->rh218_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh218_sequencial"]) || $this->rh218_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009254,'".AddSlashes(pg_result($resaco,$conresaco,'rh218_sequencial'))."','$this->rh218_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh218_perapurano"]) || $this->rh218_perapurano != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009244,'".AddSlashes(pg_result($resaco,$conresaco,'rh218_perapurano'))."','$this->rh218_perapurano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh218_perapurmes"]) || $this->rh218_perapurmes != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009245,'".AddSlashes(pg_result($resaco,$conresaco,'rh218_perapurmes'))."','$this->rh218_perapurmes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh218_indapuracao"]) || $this->rh218_indapuracao != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009246,'".AddSlashes(pg_result($resaco,$conresaco,'rh218_indapuracao'))."','$this->rh218_indapuracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh218_regist"]) || $this->rh218_regist != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009247,'".AddSlashes(pg_result($resaco,$conresaco,'rh218_regist'))."','$this->rh218_regist',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh218_codcateg"]) || $this->rh218_codcateg != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009248,'".AddSlashes(pg_result($resaco,$conresaco,'rh218_codcateg'))."','$this->rh218_codcateg',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh218_nrrecarqbase"]) || $this->rh218_nrrecarqbase != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009250,'".AddSlashes(pg_result($resaco,$conresaco,'rh218_nrrecarqbase'))."','$this->rh218_nrrecarqbase',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh218_tpcr"]) || $this->rh218_tpcr != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009251,'".AddSlashes(pg_result($resaco,$conresaco,'rh218_tpcr'))."','$this->rh218_tpcr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh218_vrdescseg"]) || $this->rh218_vrdescseg != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009252,'".AddSlashes(pg_result($resaco,$conresaco,'rh218_vrdescseg'))."','$this->rh218_vrdescseg',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh218_vrcpseg"]) || $this->rh218_vrcpseg != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009253,'".AddSlashes(pg_result($resaco,$conresaco,'rh218_vrcpseg'))."','$this->rh218_vrcpseg',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh218_instit"]) || $this->rh218_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009255,'".AddSlashes(pg_result($resaco,$conresaco,'rh218_instit'))."','$this->rh218_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Consulta do evento 5001 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh218_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Consulta do evento 5001 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh218_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh218_sequencial;
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir ($rh218_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($rh218_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009254,'$rh218_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009254,'','".AddSlashes(pg_result($resaco,$iresaco,'rh218_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009244,'','".AddSlashes(pg_result($resaco,$iresaco,'rh218_perapurano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009245,'','".AddSlashes(pg_result($resaco,$iresaco,'rh218_perapurmes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009246,'','".AddSlashes(pg_result($resaco,$iresaco,'rh218_indapuracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009247,'','".AddSlashes(pg_result($resaco,$iresaco,'rh218_regist'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009248,'','".AddSlashes(pg_result($resaco,$iresaco,'rh218_codcateg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009250,'','".AddSlashes(pg_result($resaco,$iresaco,'rh218_nrrecarqbase'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009251,'','".AddSlashes(pg_result($resaco,$iresaco,'rh218_tpcr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009252,'','".AddSlashes(pg_result($resaco,$iresaco,'rh218_vrdescseg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009253,'','".AddSlashes(pg_result($resaco,$iresaco,'rh218_vrcpseg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009255,'','".AddSlashes(pg_result($resaco,$iresaco,'rh218_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from evt5001consulta
                    where ";
     $sql2 = " 1 = 1 ";
     if (!empty($rh218_sequencial)) {
       $sql2 .= " and rh218_sequencial = $rh218_sequencial ";
     }
     if (!empty($dbwhere)) {
       $sql2 .= " and $dbwhere ";
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Consulta do evento 5001 nao Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$rh218_sequencial;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Consulta do evento 5001 nao Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$rh218_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$rh218_sequencial;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
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
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if ($this->numrows==0) {
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:evt5001consulta";
        $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $rh218_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from evt5001consulta ";
     $sql .= "      inner join rhpessoal  on  rhpessoal.rh01_regist = evt5001consulta.rh218_regist";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = rhpessoal.rh01_numcgm";
     $sql .= "      inner join rhestcivil  on  rhestcivil.rh08_estciv = rhpessoal.rh01_estciv";
     $sql .= "      inner join rhraca  on  rhraca.rh18_raca = rhpessoal.rh01_raca";
     $sql .= "      left  join rhfuncao  on  rhfuncao.rh37_funcao = rhpessoal.rh01_funcao and  rhfuncao.rh37_instit = rhpessoal.rh01_instit";
     $sql .= "      inner join rhinstrucao  on  rhinstrucao.rh21_instru = rhpessoal.rh01_instru";
     $sql .= "      inner join rhnacionalidade  on  rhnacionalidade.rh06_nacionalidade = rhpessoal.rh01_nacion";
     $sql .= "      left  join rhsindicato  on  rhsindicato.rh116_sequencial = rhpessoal.rh01_rhsindicato";
     $sql .= "      inner join rhreajusteparidade  on  rhreajusteparidade.rh148_sequencial = rhpessoal.rh01_reajusteparidade";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh218_sequencial!=null ) {
         $sql2 .= " where evt5001consulta.rh218_sequencial = $rh218_sequencial "; 
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
  function sql_query_file ( $rh218_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from evt5001consulta ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh218_sequencial!=null ) {
         $sql2 .= " where evt5001consulta.rh218_sequencial = $rh218_sequencial "; 
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

  /**
   * Buscar matricula do servidor pelo cpf e matricula
   * @param string $cpf
   * @param string $matricula
   * @return int
   */
  public function sqlMatricula($cpf, $matricula) 
  {
    $sql = "select rh01_regist from rhpessoal
    inner join cgm  on  cgm.z01_numcgm = rhpessoal.rh01_numcgm
    where z01_cgccpf = '{$cpf}' 
    and rh01_regist = {$matricula}
    order by rh01_regist desc limit 1";
    $result = db_query($sql);
    return db_utils::fieldsMemory($result, 0)->rh01_regist;

  }
}
?>
