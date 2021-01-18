<?php
//MODULO: sicom
//CLASSE DA ENTIDADE iderp112021
class cl_iderp112021 {
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
  public $si180_sequencial = 0;
  public $si180_tiporegistro = 0;
  public $si180_codiderp = 0;
  public $si180_codfontrecursos = 0;
  public $si180_vlinscricaofonte = 0;
  public $si180_reg10 = 0;
  public $si180_mes = 0;
  public $si180_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si180_sequencial = int8 = Sequencial
                 si180_tiporegistro = int8 = Tipo do registro
                 si180_codiderp = int8 = Código identificador dos  restos a pagar
                 si180_codfontrecursos = int8 = Código da fonte de recursos
                 si180_vlinscricaofonte = float8 = Valor da inscrição de restos a pagar
                 si180_reg10 = int8 = Registro 10
                 si180_mes = int8 = Mês
                 si180_instit = float8 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("iderp112021");
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
       $this->si180_sequencial = ($this->si180_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si180_sequencial"]:$this->si180_sequencial);
       $this->si180_tiporegistro = ($this->si180_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si180_tiporegistro"]:$this->si180_tiporegistro);
       $this->si180_codiderp = ($this->si180_codiderp == ""?@$GLOBALS["HTTP_POST_VARS"]["si180_codiderp"]:$this->si180_codiderp);
       $this->si180_codfontrecursos = ($this->si180_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si180_codfontrecursos"]:$this->si180_codfontrecursos);
       $this->si180_vlinscricaofonte = ($this->si180_vlinscricaofonte == ""?@$GLOBALS["HTTP_POST_VARS"]["si180_vlinscricaofonte"]:$this->si180_vlinscricaofonte);
       $this->si180_reg10 = ($this->si180_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si180_reg10"]:$this->si180_reg10);
       $this->si180_mes = ($this->si180_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si180_mes"]:$this->si180_mes);
       $this->si180_instit = ($this->si180_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si180_instit"]:$this->si180_instit);
     } else {
       $this->si180_sequencial = ($this->si180_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si180_sequencial"]:$this->si180_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si180_sequencial) {
      $this->atualizacampos();
     if ($this->si180_tiporegistro == null ) {
       $this->erro_sql = " Campo Tipo do registro não informado.";
       $this->erro_campo = "si180_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si180_codiderp == null ) {
       $this->erro_sql = " Campo Código identificador dos  restos a pagar não informado.";
       $this->erro_campo = "si180_codiderp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si180_codfontrecursos == null ) {
       $this->erro_sql = " Campo Código da fonte de recursos não informado.";
       $this->erro_campo = "si180_codfontrecursos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si180_vlinscricaofonte == null ) {
       $this->erro_sql = " Campo Valor da inscrição de restos a pagar não informado.";
       $this->erro_campo = "si180_vlinscricaofonte";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si180_reg10 == null ) {
       $this->erro_sql = " Campo Registro 10 não informado.";
       $this->erro_campo = "si180_reg10";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si180_mes == null ) {
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "si180_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si180_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "si180_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($si180_sequencial == "" || $si180_sequencial == null ) {
       $result = db_query("select nextval('iderp112021_si180_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: iderp112021_si180_sequencial_seq do campo: si180_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si180_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from iderp112021_si180_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $si180_sequencial)) {
         $this->erro_sql = " Campo si180_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->si180_sequencial = $si180_sequencial;
       }
     }
     if (($this->si180_sequencial == null) || ($this->si180_sequencial == "") ) {
       $this->erro_sql = " Campo si180_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into iderp112021(
                                       si180_sequencial
                                      ,si180_tiporegistro
                                      ,si180_codiderp
                                      ,si180_codfontrecursos
                                      ,si180_vlinscricaofonte
                                      ,si180_reg10
                                      ,si180_mes
                                      ,si180_instit
                       )
                values (
                                $this->si180_sequencial
                               ,$this->si180_tiporegistro
                               ,$this->si180_codiderp
                               ,$this->si180_codfontrecursos
                               ,$this->si180_vlinscricaofonte
                               ,$this->si180_reg10
                               ,$this->si180_mes
                               ,$this->si180_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Detalhamento das Despesas do Exercício Inscritas  ($this->si180_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Detalhamento das Despesas do Exercício Inscritas  já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Detalhamento das Despesas do Exercício Inscritas  ($this->si180_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si180_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
   /*  if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si180_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011898,'$this->si180_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010193,2011898,'','".AddSlashes(pg_result($resaco,0,'si180_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,2011861,'','".AddSlashes(pg_result($resaco,0,'si180_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,2011862,'','".AddSlashes(pg_result($resaco,0,'si180_codiderp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,2011863,'','".AddSlashes(pg_result($resaco,0,'si180_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,2011864,'','".AddSlashes(pg_result($resaco,0,'si180_vlinscricaofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,2011909,'','".AddSlashes(pg_result($resaco,0,'si180_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,2011902,'','".AddSlashes(pg_result($resaco,0,'si180_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,2011906,'','".AddSlashes(pg_result($resaco,0,'si180_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($si180_sequencial=null) {
      $this->atualizacampos();
     $sql = " update iderp112021 set ";
     $virgula = "";
     if (trim($this->si180_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si180_sequencial"])) {
       $sql  .= $virgula." si180_sequencial = $this->si180_sequencial ";
       $virgula = ",";
       if (trim($this->si180_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "si180_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si180_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si180_tiporegistro"])) {
       $sql  .= $virgula." si180_tiporegistro = $this->si180_tiporegistro ";
       $virgula = ",";
       if (trim($this->si180_tiporegistro) == null ) {
         $this->erro_sql = " Campo Tipo do registro não informado.";
         $this->erro_campo = "si180_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si180_codiderp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si180_codiderp"])) {
       $sql  .= $virgula." si180_codiderp = $this->si180_codiderp ";
       $virgula = ",";
       if (trim($this->si180_codiderp) == null ) {
         $this->erro_sql = " Campo Código identificador dos  restos a pagar não informado.";
         $this->erro_campo = "si180_codiderp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si180_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si180_codfontrecursos"])) {
       $sql  .= $virgula." si180_codfontrecursos = $this->si180_codfontrecursos ";
       $virgula = ",";
       if (trim($this->si180_codfontrecursos) == null ) {
         $this->erro_sql = " Campo Código da fonte de recursos não informado.";
         $this->erro_campo = "si180_codfontrecursos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si180_vlinscricaofonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si180_vlinscricaofonte"])) {
       $sql  .= $virgula." si180_vlinscricaofonte = $this->si180_vlinscricaofonte ";
       $virgula = ",";
       if (trim($this->si180_vlinscricaofonte) == null ) {
         $this->erro_sql = " Campo Valor da inscrição de restos a pagar não informado.";
         $this->erro_campo = "si180_vlinscricaofonte";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si180_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si180_reg10"])) {
       $sql  .= $virgula." si180_reg10 = $this->si180_reg10 ";
       $virgula = ",";
       if (trim($this->si180_reg10) == null ) {
         $this->erro_sql = " Campo Registro 10 não informado.";
         $this->erro_campo = "si180_reg10";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si180_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si180_mes"])) {
       $sql  .= $virgula." si180_mes = $this->si180_mes ";
       $virgula = ",";
       if (trim($this->si180_mes) == null ) {
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "si180_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si180_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si180_instit"])) {
       $sql  .= $virgula." si180_instit = $this->si180_instit ";
       $virgula = ",";
       if (trim($this->si180_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "si180_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si180_sequencial!=null) {
       $sql .= " si180_sequencial = $this->si180_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
/*     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si180_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2011898,'$this->si180_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si180_sequencial"]) || $this->si180_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010193,2011898,'".AddSlashes(pg_result($resaco,$conresaco,'si180_sequencial'))."','$this->si180_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si180_tiporegistro"]) || $this->si180_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010193,2011861,'".AddSlashes(pg_result($resaco,$conresaco,'si180_tiporegistro'))."','$this->si180_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si180_codiderp"]) || $this->si180_codiderp != "")
             $resac = db_query("insert into db_acount values($acount,1010193,2011862,'".AddSlashes(pg_result($resaco,$conresaco,'si180_codiderp'))."','$this->si180_codiderp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si180_codfontrecursos"]) || $this->si180_codfontrecursos != "")
             $resac = db_query("insert into db_acount values($acount,1010193,2011863,'".AddSlashes(pg_result($resaco,$conresaco,'si180_codfontrecursos'))."','$this->si180_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si180_vlinscricaofonte"]) || $this->si180_vlinscricaofonte != "")
             $resac = db_query("insert into db_acount values($acount,1010193,2011864,'".AddSlashes(pg_result($resaco,$conresaco,'si180_vlinscricaofonte'))."','$this->si180_vlinscricaofonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si180_reg10"]) || $this->si180_reg10 != "")
             $resac = db_query("insert into db_acount values($acount,1010193,2011909,'".AddSlashes(pg_result($resaco,$conresaco,'si180_reg10'))."','$this->si180_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si180_mes"]) || $this->si180_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010193,2011902,'".AddSlashes(pg_result($resaco,$conresaco,'si180_mes'))."','$this->si180_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si180_instit"]) || $this->si180_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010193,2011906,'".AddSlashes(pg_result($resaco,$conresaco,'si180_instit'))."','$this->si180_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Detalhamento das Despesas do Exercício Inscritas  nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si180_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Detalhamento das Despesas do Exercício Inscritas  nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si180_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si180_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($si180_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si180_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2011898,'$si180_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010193,2011898,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,2011861,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,2011862,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_codiderp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,2011863,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,2011864,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_vlinscricaofonte'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,2011909,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,2011902,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,2011906,'','".AddSlashes(pg_result($resaco,$iresaco,'si180_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from iderp112021
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si180_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si180_sequencial = $si180_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Detalhamento das Despesas do Exercício Inscritas  nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si180_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Detalhamento das Despesas do Exercício Inscritas  nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si180_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si180_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:iderp112021";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si180_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from iderp112021 ";
     $sql .= "      inner join iderp102020  on  iderp102020.si179_sequencial = iderp112021.si180_reg10";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si180_sequencial!=null ) {
         $sql2 .= " where iderp112021.si180_sequencial = $si180_sequencial ";
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
  function sql_query_file ( $si180_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from iderp112021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si180_sequencial!=null ) {
         $sql2 .= " where iderp112021.si180_sequencial = $si180_sequencial ";
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
