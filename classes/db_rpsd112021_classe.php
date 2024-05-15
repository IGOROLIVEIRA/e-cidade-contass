<?php
//MODULO: sicom
//CLASSE DA ENTIDADE rpsd112021
class cl_rpsd112021 {
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
  public $si190_sequencial = 0;
  public $si190_tiporegistro = 0;
  public $si190_codreduzidorsp = 0;
  public $si190_codfontrecursos = 0;
  public $si190_vlpagofontersp = 0;
  public $si190_reg10 = 0;
  public $si190_mes = 0;
  public $si190_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si190_sequencial = int8 = Sequencial
                 si190_tiporegistro = int8 = Tipo do Registro
                 si190_codreduzidorsp = int8 = Código Identificador do resto a pagar
                 si190_codfontrecursos = int8 = Código da fonte de recursos
                 si190_vlpagofontersp = float8 = Valor pago de Restos a Pagar por fonte
                 si190_reg10 = int8 = Registro 10
                 si190_mes = int8 = Mês
                 si190_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("rpsd112021");
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
       $this->si190_sequencial = ($this->si190_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_sequencial"]:$this->si190_sequencial);
       $this->si190_tiporegistro = ($this->si190_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_tiporegistro"]:$this->si190_tiporegistro);
       $this->si190_codreduzidorsp = ($this->si190_codreduzidorsp == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_codreduzidorsp"]:$this->si190_codreduzidorsp);
       $this->si190_codfontrecursos = ($this->si190_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_codfontrecursos"]:$this->si190_codfontrecursos);
       $this->si190_vlpagofontersp = ($this->si190_vlpagofontersp == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_vlpagofontersp"]:$this->si190_vlpagofontersp);
       $this->si190_reg10 = ($this->si190_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_reg10"]:$this->si190_reg10);
       $this->si190_mes = ($this->si190_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_mes"]:$this->si190_mes);
       $this->si190_instit = ($this->si190_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_instit"]:$this->si190_instit);
     } else {
       $this->si190_sequencial = ($this->si190_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si190_sequencial"]:$this->si190_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si190_sequencial) {
      $this->atualizacampos();
     if ($this->si190_tiporegistro == null ) {
       $this->erro_sql = " Campo Tipo do Registro não informado.";
       $this->erro_campo = "si190_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si190_codreduzidorsp == null ) {
       $this->erro_sql = " Campo Código Identificador do resto a pagar não informado.";
       $this->erro_campo = "si190_codreduzidorsp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si190_codfontrecursos == null ) {
       $this->erro_sql = " Campo Código da fonte de recursos não informado.";
       $this->erro_campo = "si190_codfontrecursos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si190_vlpagofontersp == null ) {
       $this->erro_sql = " Campo Valor pago de Restos a Pagar por fonte não informado.";
       $this->erro_campo = "si190_vlpagofontersp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si190_reg10 == null ) {
       $this->erro_sql = " Campo Registro 10 não informado.";
       $this->erro_campo = "si190_reg10";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si190_mes == null ) {
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "si190_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si190_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "si190_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($si190_sequencial == "" || $si190_sequencial == null ) {
       $result = db_query("select nextval('rpsd112021_si190_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: rpsd112021_si190_sequencial_seq do campo: si190_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si190_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from rpsd112021_si190_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $si190_sequencial)) {
         $this->erro_sql = " Campo si190_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->si190_sequencial = $si190_sequencial;
       }
     }
     if (($this->si190_sequencial == null) || ($this->si190_sequencial == "") ) {
       $this->erro_sql = " Campo si190_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into rpsd112021(
                                       si190_sequencial
                                      ,si190_tiporegistro
                                      ,si190_codreduzidorsp
                                      ,si190_codfontrecursos
                                      ,si190_vlpagofontersp
                                      ,si190_reg10
                                      ,si190_mes
                                      ,si190_instit
                       )
                values (
                                $this->si190_sequencial
                               ,$this->si190_tiporegistro
                               ,$this->si190_codreduzidorsp
                               ,$this->si190_codfontrecursos
                               ,$this->si190_vlpagofontersp
                               ,$this->si190_reg10
                               ,$this->si190_mes
                               ,$this->si190_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Detalhamento dos Pagamentos por Fonte de Recursos ($this->si190_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Detalhamento dos Pagamentos por Fonte de Recursos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Detalhamento dos Pagamentos por Fonte de Recursos ($this->si190_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si190_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    /* if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si190_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2012022,'$this->si190_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010203,2012022,'','".AddSlashes(pg_result($resaco,0,'si190_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2012007,'','".AddSlashes(pg_result($resaco,0,'si190_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2012023,'','".AddSlashes(pg_result($resaco,0,'si190_codreduzidorsp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2012024,'','".AddSlashes(pg_result($resaco,0,'si190_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2012025,'','".AddSlashes(pg_result($resaco,0,'si190_vlpagofontersp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2012028,'','".AddSlashes(pg_result($resaco,0,'si190_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2012026,'','".AddSlashes(pg_result($resaco,0,'si190_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2012027,'','".AddSlashes(pg_result($resaco,0,'si190_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($si190_sequencial=null) {
      $this->atualizacampos();
     $sql = " update rpsd112021 set ";
     $virgula = "";
     if (trim($this->si190_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_sequencial"])) {
       $sql  .= $virgula." si190_sequencial = $this->si190_sequencial ";
       $virgula = ",";
       if (trim($this->si190_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "si190_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si190_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_tiporegistro"])) {
       $sql  .= $virgula." si190_tiporegistro = $this->si190_tiporegistro ";
       $virgula = ",";
       if (trim($this->si190_tiporegistro) == null ) {
         $this->erro_sql = " Campo Tipo do Registro não informado.";
         $this->erro_campo = "si190_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si190_codreduzidorsp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_codreduzidorsp"])) {
       $sql  .= $virgula." si190_codreduzidorsp = $this->si190_codreduzidorsp ";
       $virgula = ",";
       if (trim($this->si190_codreduzidorsp) == null ) {
         $this->erro_sql = " Campo Código Identificador do resto a pagar não informado.";
         $this->erro_campo = "si190_codreduzidorsp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si190_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_codfontrecursos"])) {
       $sql  .= $virgula." si190_codfontrecursos = $this->si190_codfontrecursos ";
       $virgula = ",";
       if (trim($this->si190_codfontrecursos) == null ) {
         $this->erro_sql = " Campo Código da fonte de recursos não informado.";
         $this->erro_campo = "si190_codfontrecursos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si190_vlpagofontersp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_vlpagofontersp"])) {
       $sql  .= $virgula." si190_vlpagofontersp = $this->si190_vlpagofontersp ";
       $virgula = ",";
       if (trim($this->si190_vlpagofontersp) == null ) {
         $this->erro_sql = " Campo Valor pago de Restos a Pagar por fonte não informado.";
         $this->erro_campo = "si190_vlpagofontersp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si190_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_reg10"])) {
       $sql  .= $virgula." si190_reg10 = $this->si190_reg10 ";
       $virgula = ",";
       if (trim($this->si190_reg10) == null ) {
         $this->erro_sql = " Campo Registro 10 não informado.";
         $this->erro_campo = "si190_reg10";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si190_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_mes"])) {
       $sql  .= $virgula." si190_mes = $this->si190_mes ";
       $virgula = ",";
       if (trim($this->si190_mes) == null ) {
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "si190_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si190_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si190_instit"])) {
       $sql  .= $virgula." si190_instit = $this->si190_instit ";
       $virgula = ",";
       if (trim($this->si190_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "si190_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si190_sequencial!=null) {
       $sql .= " si190_sequencial = $this->si190_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si190_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2012022,'$this->si190_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si190_sequencial"]) || $this->si190_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010203,2012022,'".AddSlashes(pg_result($resaco,$conresaco,'si190_sequencial'))."','$this->si190_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si190_tiporegistro"]) || $this->si190_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010203,2012007,'".AddSlashes(pg_result($resaco,$conresaco,'si190_tiporegistro'))."','$this->si190_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si190_codreduzidorsp"]) || $this->si190_codreduzidorsp != "")
             $resac = db_query("insert into db_acount values($acount,1010203,2012023,'".AddSlashes(pg_result($resaco,$conresaco,'si190_codreduzidorsp'))."','$this->si190_codreduzidorsp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si190_codfontrecursos"]) || $this->si190_codfontrecursos != "")
             $resac = db_query("insert into db_acount values($acount,1010203,2012024,'".AddSlashes(pg_result($resaco,$conresaco,'si190_codfontrecursos'))."','$this->si190_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si190_vlpagofontersp"]) || $this->si190_vlpagofontersp != "")
             $resac = db_query("insert into db_acount values($acount,1010203,2012025,'".AddSlashes(pg_result($resaco,$conresaco,'si190_vlpagofontersp'))."','$this->si190_vlpagofontersp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si190_reg10"]) || $this->si190_reg10 != "")
             $resac = db_query("insert into db_acount values($acount,1010203,2012028,'".AddSlashes(pg_result($resaco,$conresaco,'si190_reg10'))."','$this->si190_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si190_mes"]) || $this->si190_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010203,2012026,'".AddSlashes(pg_result($resaco,$conresaco,'si190_mes'))."','$this->si190_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si190_instit"]) || $this->si190_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010203,2012027,'".AddSlashes(pg_result($resaco,$conresaco,'si190_instit'))."','$this->si190_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Detalhamento dos Pagamentos por Fonte de Recursos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si190_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Detalhamento dos Pagamentos por Fonte de Recursos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si190_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si190_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($si190_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si190_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2012022,'$si190_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010203,2012022,'','".AddSlashes(pg_result($resaco,$iresaco,'si190_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010203,2012007,'','".AddSlashes(pg_result($resaco,$iresaco,'si190_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010203,2012023,'','".AddSlashes(pg_result($resaco,$iresaco,'si190_codreduzidorsp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010203,2012024,'','".AddSlashes(pg_result($resaco,$iresaco,'si190_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010203,2012025,'','".AddSlashes(pg_result($resaco,$iresaco,'si190_vlpagofontersp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010203,2012028,'','".AddSlashes(pg_result($resaco,$iresaco,'si190_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010203,2012026,'','".AddSlashes(pg_result($resaco,$iresaco,'si190_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010203,2012027,'','".AddSlashes(pg_result($resaco,$iresaco,'si190_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from rpsd112021
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si190_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si190_sequencial = $si190_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Detalhamento dos Pagamentos por Fonte de Recursos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si190_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Detalhamento dos Pagamentos por Fonte de Recursos nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si190_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si190_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:rpsd112021";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si190_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from rpsd112021 ";
     $sql .= "      inner join rpsd102021  on  rpsd102021.si189_sequencial = rpsd112021.si190_reg10";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si190_sequencial!=null ) {
         $sql2 .= " where rpsd112021.si190_sequencial = $si190_sequencial ";
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
  function sql_query_file ( $si190_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from rpsd112021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si190_sequencial!=null ) {
         $sql2 .= " where rpsd112021.si190_sequencial = $si190_sequencial ";
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
