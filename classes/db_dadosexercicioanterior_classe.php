<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE dadosexercicioanterior
class cl_dadosexercicioanterior {
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
  public $c235_sequencial = 0;
  public $c235_anousu = 0;
  public $c235_naoaplicfundebimposttransf = 0;
  public $c235_superavit_fundeb_permitido = 0;
  public $c235_naoaplicfundebcompl = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 c235_sequencial = int8 = Sequencial
                 c235_anousu = int8 = Ano Referência
                 c235_naoaplicfundebimposttransf = float8 = Valor não Aplic. do Fundeb - Impost. e Transf. Imp
                 c235_superavit_fundeb_permitido = float8 = Valor do superávit do Fundeb permitido
                 c235_naoaplicfundebcompl = float8 = Valor não aplic. Fundeb - Comple VAAT
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("dadosexercicioanterior");
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
       $this->c235_sequencial = ($this->c235_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c235_sequencial"]:$this->c235_sequencial);
       $this->c235_anousu = ($this->c235_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c235_anousu"]:$this->c235_anousu);
       $this->c235_naoaplicfundebimposttransf = ($this->c235_naoaplicfundebimposttransf == ""?@$GLOBALS["HTTP_POST_VARS"]["c235_naoaplicfundebimposttransf"]:$this->c235_naoaplicfundebimposttransf);
       $this->c235_superavit_fundeb_permitido = ($this->c235_superavit_fundeb_permitido == ""?@$GLOBALS["HTTP_POST_VARS"]["c235_superavit_fundeb_permitido"]:$this->c235_superavit_fundeb_permitido);
       $this->c235_naoaplicfundebcompl = ($this->c235_naoaplicfundebcompl == ""?@$GLOBALS["HTTP_POST_VARS"]["c235_naoaplicfundebcompl"]:$this->c235_naoaplicfundebcompl);
     } else {
       $this->c235_sequencial = ($this->c235_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c235_sequencial"]:$this->c235_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($c235_sequencial) {
      $this->atualizacampos();
     if ($this->c235_anousu == null ) {
       $this->erro_sql = " Campo Ano Referência não informado.";
       $this->erro_campo = "c235_anousu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c235_naoaplicfundebimposttransf == null ) {
       $this->erro_sql = " Campo Valor não Aplic. do Fundeb - Impost. e Transf. Imp não informado.";
       $this->erro_campo = "c235_naoaplicfundebimposttransf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c235_superavit_fundeb_permitido == null ) {
       $this->erro_sql = " Campo Valor do superávit do Fundeb permitido não informado.";
       $this->erro_campo = "c235_superavit_fundeb_permitido";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c235_naoaplicfundebcompl == null ) {
       $this->erro_sql = " Campo Valor não aplic. Fundeb - Comple VAAT não informado.";
       $this->erro_campo = "c235_naoaplicfundebcompl";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($c235_sequencial == "" || $c235_sequencial == null ) {
       $result = db_query("select nextval('dadosexercicioanterior_c235_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dadosexercicioanterior_c235_sequencial_seq do campo: c235_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->c235_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from dadosexercicioanterior_c235_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $c235_sequencial)) {
         $this->erro_sql = " Campo c235_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->c235_sequencial = $c235_sequencial;
       }
     }
     if (($this->c235_sequencial == null) || ($this->c235_sequencial == "") ) {
       $this->erro_sql = " Campo c235_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dadosexercicioanterior(
                                       c235_sequencial
                                      ,c235_anousu
                                      ,c235_naoaplicfundebimposttransf
                                      ,c235_superavit_fundeb_permitido
                                      ,c235_naoaplicfundebcompl
                       )
                values (
                                $this->c235_sequencial
                               ,$this->c235_anousu
                               ,$this->c235_naoaplicfundebimposttransf
                               ,$this->c235_superavit_fundeb_permitido
                               ,$this->c235_naoaplicfundebcompl
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Dados Exercicio Anterior ($this->c235_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Dados Exercicio Anterior já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Dados Exercicio Anterior ($this->c235_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c235_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->c235_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009256,'$this->c235_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010193,1009256,'','".AddSlashes(pg_result($resaco,0,'c235_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009257,'','".AddSlashes(pg_result($resaco,0,'c235_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009259,'','".AddSlashes(pg_result($resaco,0,'c235_naoaplicfundebimposttransf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,0,'c235_superavit_fundeb_permitido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009269,'','".AddSlashes(pg_result($resaco,0,'c235_naoaplicfundebcompl'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }
    return true;
  }

  // funcao para alteracao
  function alterar ($c235_sequencial=null) {
      $this->atualizacampos();
     $sql = " update dadosexercicioanterior set ";
     $virgula = "";
     if (trim($this->c235_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c235_sequencial"])) {
       $sql  .= $virgula." c235_sequencial = $this->c235_sequencial ";
       $virgula = ",";
       if (trim($this->c235_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "c235_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c235_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c235_anousu"])) {
       $sql  .= $virgula." c235_anousu = $this->c235_anousu ";
       $virgula = ",";
       if (trim($this->c235_anousu) == null ) {
         $this->erro_sql = " Campo Ano Referência não informado.";
         $this->erro_campo = "c235_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c235_naoaplicfundebimposttransf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c235_naoaplicfundebimposttransf"])) {
       $sql  .= $virgula." c235_naoaplicfundebimposttransf = $this->c235_naoaplicfundebimposttransf ";
       $virgula = ",";
       if (trim($this->c235_naoaplicfundebimposttransf) == null ) {
         $this->erro_sql = " Campo Valor não Aplic. do Fundeb - Impost. e Transf. Imp não informado.";
         $this->erro_campo = "c235_naoaplicfundebimposttransf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c235_superavit_fundeb_permitido)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c235_superavit_fundeb_permitido"])) {
       $sql  .= $virgula." c235_superavit_fundeb_permitido = $this->c235_superavit_fundeb_permitido ";
       $virgula = ",";
       if (trim($this->c235_superavit_fundeb_permitido) == null ) {
         $this->erro_sql = " Campo Valor do superávit do Fundeb permitido não informado.";
         $this->erro_campo = "c235_superavit_fundeb_permitido";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c235_naoaplicfundebcompl)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c235_naoaplicfundebcompl"])) {
       $sql  .= $virgula." c235_naoaplicfundebcompl = $this->c235_naoaplicfundebcompl ";
       $virgula = ",";
       if (trim($this->c235_naoaplicfundebcompl) == null ) {
         $this->erro_sql = " Campo Valor não aplic. Fundeb - Comple VAAT não informado.";
         $this->erro_campo = "c235_naoaplicfundebcompl";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($c235_sequencial!=null) {
       $sql .= " c235_sequencial = $this->c235_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->c235_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009256,'$this->c235_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["c235_sequencial"]) || $this->c235_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009256,'".AddSlashes(pg_result($resaco,$conresaco,'c235_sequencial'))."','$this->c235_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["c235_anousu"]) || $this->c235_anousu != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009257,'".AddSlashes(pg_result($resaco,$conresaco,'c235_anousu'))."','$this->c235_anousu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["c235_naoaplicfundebimposttransf"]) || $this->c235_naoaplicfundebimposttransf != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009259,'".AddSlashes(pg_result($resaco,$conresaco,'c235_naoaplicfundebimposttransf'))."','$this->c235_naoaplicfundebimposttransf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["c235_superavit_fundeb_permitido"]) || $this->c235_superavit_fundeb_permitido != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009258,'".AddSlashes(pg_result($resaco,$conresaco,'c235_superavit_fundeb_permitido'))."','$this->c235_superavit_fundeb_permitido',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["c235_naoaplicfundebcompl"]) || $this->c235_naoaplicfundebcompl != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009269,'".AddSlashes(pg_result($resaco,$conresaco,'c235_naoaplicfundebcompl'))."','$this->c235_naoaplicfundebcompl',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Dados Exercicio Anterior nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c235_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Dados Exercicio Anterior nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c235_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c235_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($c235_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($c235_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009256,'$c235_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009256,'','".AddSlashes(pg_result($resaco,$iresaco,'c235_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009257,'','".AddSlashes(pg_result($resaco,$iresaco,'c235_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009259,'','".AddSlashes(pg_result($resaco,$iresaco,'c235_naoaplicfundebimposttransf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,$iresaco,'c235_superavit_fundeb_permitido'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009269,'','".AddSlashes(pg_result($resaco,$iresaco,'c235_naoaplicfundebcompl'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from dadosexercicioanterior
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($c235_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " c235_sequencial = $c235_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Dados Exercicio Anterior nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c235_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Dados Exercicio Anterior nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c235_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c235_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dadosexercicioanterior";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $c235_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from dadosexercicioanterior ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($c235_sequencial!=null ) {
         $sql2 .= " where dadosexercicioanterior.c235_sequencial = $c235_sequencial ";
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
  function sql_query_file ( $c235_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from dadosexercicioanterior ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($c235_sequencial!=null ) {
         $sql2 .= " where dadosexercicioanterior.c235_sequencial = $c235_sequencial ";
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

  function getDadosExercicioAnterior($iAnoUsu, $sInstituicoes, $sCampos = '*', $sWhere = '', $sOrder = '')
  {

    $sSql  = "select $sCampos                                                                                                                                          ";
    $sSql .= " from dadosexercicioanterior ";
    $sSql .= "      where c235_anousu = $iAnoUsu                                                                                                                         ";
    //$sSql .= "      and e91_anousu = $iAnoUsu                                                                                                                         ";
    if (!empty($sWhere)) {
        $sSql .= " and {$sWhere} ";
      }

      if (!empty($sOrder)) {
        $sSql .= " order by {$sOrder} ";
      }

      return db_utils::fieldsMemory(db_query($sSql), 0);
  }
}
?>
