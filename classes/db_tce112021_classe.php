<?php
//MODULO: sicom
//CLASSE DA ENTIDADE tce112021
class cl_tce112021 {
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
  public $si188_sequencial = 0;
  public $si188_tiporegistro = 0;
  public $si188_numprocessotce = null;
  public $si188_datainstauracaotce_dia = null;
  public $si188_datainstauracaotce_mes = null;
  public $si188_datainstauracaotce_ano = null;
  public $si188_datainstauracaotce = null;
  public $si188_tipodocumentorespdano = 0;
  public $si188_nrodocumentorespdano = null;
  public $si188_reg10 = 0;
  public $si188_mes = 0;
  public $si188_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si188_sequencial = int8 = Sequencial
                 si188_tiporegistro = int8 = Tipo do Registro
                 si188_numprocessotce = varchar(12) = Número do processo
                 si188_datainstauracaotce = date = Data da instauração
                 si188_tipodocumentorespdano = int8 = Tipo do documento do responsável
                 si188_nrodocumentorespdano = varchar(14) = Número do  documento do responsável
                 si188_reg10 = int8 = Registro 10
                 si188_mes = int8 = Mês
                 si188_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("tce112021");
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
       $this->si188_sequencial = ($this->si188_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_sequencial"]:$this->si188_sequencial);
       $this->si188_tiporegistro = ($this->si188_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_tiporegistro"]:$this->si188_tiporegistro);
       $this->si188_tipodocumentorespdano = ($this->si188_tipodocumentorespdano == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_tipodocumentorespdano"]:$this->si188_tipodocumentorespdano);
       $this->si188_numprocessotce = ($this->si188_numprocessotce == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_numprocessotce"]:$this->si188_numprocessotce);

       if ($this->si188_datainstauracaotce == "") {
         $this->si188_datainstauracaotce_dia = ($this->si188_datainstauracaotce_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_datainstauracaotce_dia"]:$this->si188_datainstauracaotce_dia);
         $this->si188_datainstauracaotce_mes = ($this->si188_datainstauracaotce_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_datainstauracaotce_mes"]:$this->si188_datainstauracaotce_mes);
         $this->si188_datainstauracaotce_ano = ($this->si188_datainstauracaotce_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_datainstauracaotce_ano"]:$this->si188_datainstauracaotce_ano);
         if ($this->si188_datainstauracaotce_dia != "") {
            $this->si188_datainstauracaotce = $this->si188_datainstauracaotce_ano."-".$this->si188_datainstauracaotce_mes."-".$this->si187_dataassinaturaconvoriginalconge_dia;
         }
       }

       $this->si188_nrodocumentorespdano = ($this->si188_nrodocumentorespdano == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_nrodocumentorespdano"]:$this->si188_nrodocumentorespdano);
       $this->si188_reg10 = ($this->si188_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_reg10"]:$this->si188_reg10);
       $this->si188_mes = ($this->si188_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_mes"]:$this->si188_mes);
       $this->si188_instit = ($this->si188_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_instit"]:$this->si188_instit);
     } else {
       $this->si188_sequencial = ($this->si188_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si188_sequencial"]:$this->si188_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si188_sequencial) {
      $this->atualizacampos();
     if ($this->si188_tiporegistro == null ) {
       $this->erro_sql = " Campo Tipo do Registro não informado.";
       $this->erro_campo = "si188_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si188_tipodocumentorespdano == null ) {
       $this->erro_sql = " Campo Tipo do documento do responsável não informado.";
       $this->erro_campo = "si188_tipodocumentorespdano";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si188_nrodocumentorespdano == null ) {
       $this->erro_sql = " Campo Número do  documento do responsável não informado.";
       $this->erro_campo = "si188_nrodocumentorespdano";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si188_reg10 == null ) {
       $this->erro_sql = " Campo Registro 10 não informado.";
       $this->erro_campo = "si188_reg10";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si188_mes == null ) {
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "si188_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si188_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "si188_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->si188_sequencial = $si188_sequencial;
     if (($this->si188_sequencial == null) || ($this->si188_sequencial == "") ) {
       $this->erro_sql = " Campo si188_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into tce112021(
                                       si188_sequencial
                                      ,si188_tiporegistro
                                      ,si188_numprocessotce
                                      ,si188_datainstauracaotce
                                      ,si188_tipodocumentorespdano
                                      ,si188_nrodocumentorespdano
                                      ,si188_reg10
                                      ,si188_mes
                                      ,si188_instit
                       )
                values (
                                $this->si188_sequencial
                               ,$this->si188_tiporegistro
                               ,'$this->si188_numprocessotce'
                               ,".($this->si188_datainstauracaotce == "null" || $this->si188_datainstauracaotce == ""?"null":"'".$this->si188_datainstauracaotce."'")."
                               ,$this->si188_tipodocumentorespdano
                               ,'$this->si188_nrodocumentorespdano'
                               ,$this->si188_reg10
                               ,$this->si188_mes
                               ,$this->si188_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Detalhamento dos Responsáveis pelo Dano  ($this->si188_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Detalhamento dos Responsáveis pelo Dano  já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Detalhamento dos Responsáveis pelo Dano  ($this->si188_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si188_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
/*     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si188_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011997,'$this->si188_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010201,2011997,'','".AddSlashes(pg_result($resaco,0,'si188_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,2011994,'','".AddSlashes(pg_result($resaco,0,'si188_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,2011995,'','".AddSlashes(pg_result($resaco,0,'si188_tipodocumentorespdano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,2011996,'','".AddSlashes(pg_result($resaco,0,'si188_nrodocumentorespdano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,2012000,'','".AddSlashes(pg_result($resaco,0,'si188_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,2011998,'','".AddSlashes(pg_result($resaco,0,'si188_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010201,2011999,'','".AddSlashes(pg_result($resaco,0,'si188_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($si188_sequencial=null) {
      $this->atualizacampos();
     $sql = " update tce112021 set ";
     $virgula = "";
     if (trim($this->si188_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_sequencial"])) {
       $sql  .= $virgula." si188_sequencial = $this->si188_sequencial ";
       $virgula = ",";
       if (trim($this->si188_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "si188_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si188_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_tiporegistro"])) {
       $sql  .= $virgula." si188_tiporegistro = $this->si188_tiporegistro ";
       $virgula = ",";
       if (trim($this->si188_tiporegistro) == null ) {
         $this->erro_sql = " Campo Tipo do Registro não informado.";
         $this->erro_campo = "si188_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si188_tipodocumentorespdano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_tipodocumentorespdano"])) {
       $sql  .= $virgula." si188_tipodocumentorespdano = $this->si188_tipodocumentorespdano ";
       $virgula = ",";
       if (trim($this->si188_tipodocumentorespdano) == null ) {
         $this->erro_sql = " Campo Tipo do documento do responsável não informado.";
         $this->erro_campo = "si188_tipodocumentorespdano";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si188_nrodocumentorespdano)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_nrodocumentorespdano"])) {
       $sql  .= $virgula." si188_nrodocumentorespdano = '$this->si188_nrodocumentorespdano' ";
       $virgula = ",";
       if (trim($this->si188_nrodocumentorespdano) == null ) {
         $this->erro_sql = " Campo Número do  documento do responsável não informado.";
         $this->erro_campo = "si188_nrodocumentorespdano";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si188_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_reg10"])) {
       $sql  .= $virgula." si188_reg10 = $this->si188_reg10 ";
       $virgula = ",";
       if (trim($this->si188_reg10) == null ) {
         $this->erro_sql = " Campo Registro 10 não informado.";
         $this->erro_campo = "si188_reg10";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si188_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_mes"])) {
       $sql  .= $virgula." si188_mes = $this->si188_mes ";
       $virgula = ",";
       if (trim($this->si188_mes) == null ) {
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "si188_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si188_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si188_instit"])) {
       $sql  .= $virgula." si188_instit = $this->si188_instit ";
       $virgula = ",";
       if (trim($this->si188_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "si188_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si188_sequencial!=null) {
       $sql .= " si188_sequencial = $this->si188_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si188_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2011997,'$this->si188_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si188_sequencial"]) || $this->si188_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011997,'".AddSlashes(pg_result($resaco,$conresaco,'si188_sequencial'))."','$this->si188_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si188_tiporegistro"]) || $this->si188_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011994,'".AddSlashes(pg_result($resaco,$conresaco,'si188_tiporegistro'))."','$this->si188_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si188_tipodocumentorespdano"]) || $this->si188_tipodocumentorespdano != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011995,'".AddSlashes(pg_result($resaco,$conresaco,'si188_tipodocumentorespdano'))."','$this->si188_tipodocumentorespdano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si188_nrodocumentorespdano"]) || $this->si188_nrodocumentorespdano != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011996,'".AddSlashes(pg_result($resaco,$conresaco,'si188_nrodocumentorespdano'))."','$this->si188_nrodocumentorespdano',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si188_reg10"]) || $this->si188_reg10 != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2012000,'".AddSlashes(pg_result($resaco,$conresaco,'si188_reg10'))."','$this->si188_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si188_mes"]) || $this->si188_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011998,'".AddSlashes(pg_result($resaco,$conresaco,'si188_mes'))."','$this->si188_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si188_instit"]) || $this->si188_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011999,'".AddSlashes(pg_result($resaco,$conresaco,'si188_instit'))."','$this->si188_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Detalhamento dos Responsáveis pelo Dano  nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si188_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Detalhamento dos Responsáveis pelo Dano  nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si188_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si188_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($si188_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si188_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2011997,'$si188_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010201,2011997,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,2011994,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,2011995,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_tipodocumentorespdano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,2011996,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_nrodocumentorespdano'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,2012000,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,2011998,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010201,2011999,'','".AddSlashes(pg_result($resaco,$iresaco,'si188_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from tce112021
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si188_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si188_sequencial = $si188_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Detalhamento dos Responsáveis pelo Dano  nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si188_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Detalhamento dos Responsáveis pelo Dano  nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si188_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si188_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:tce112021";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si188_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from tce112021 ";
     $sql .= "      inner join tce112021  on  tce112021.si188_sequencial = tce112021.si188_reg10";
     $sql .= "      inner join tce112021  on  tce112021.si188_sequencial = tce112021.si188_reg10";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si188_sequencial!=null ) {
         $sql2 .= " where tce112021.si188_sequencial = $si188_sequencial ";
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
  function sql_query_file ( $si188_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from tce112021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si188_sequencial!=null ) {
         $sql2 .= " where tce112021.si188_sequencial = $si188_sequencial ";
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
