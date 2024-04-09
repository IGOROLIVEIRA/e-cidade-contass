<?php
//MODULO: protocolo
//CLASSE DA ENTIDADE protocolos
class cl_protocolos {
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
  public $p101_sequencial = 0;
  public $p101_id_usuario = 0;
  public $p101_coddeptoorigem = 0;
  public $p101_coddeptodestino = 0;
  public $p101_observacao = null;
  public $p101_dt_protocolo_dia = null;
  public $p101_dt_protocolo_mes = null;
  public $p101_dt_protocolo_ano = null;
  public $p101_dt_protocolo = null;
  public $p101_hora = null;
  public $p101_dt_anulado_dia = null;
  public $p101_dt_anulado_mes = null;
  public $p101_dt_anulado_ano = null;
  public $p101_dt_anulado = null;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 p101_sequencial = int4 = Protocolo
                 p101_id_usuario = int4 = Usuario
                 p101_coddeptoorigem = int4 = Depart. Origem
                 p101_coddeptodestino = int4 = Depart. Destino
                 p101_observacao = varchar(600) = Observacao
                 p101_dt_protocolo = date = Data
                 p101_hora = varchar(5) = Hora
                 p101_dt_anulado = date = Dt. Anulação
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("protocolos");
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
       $this->p101_sequencial = ($this->p101_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["p101_sequencial"]:$this->p101_sequencial);
       $this->p101_id_usuario = ($this->p101_id_usuario == ""?@$GLOBALS["HTTP_POST_VARS"]["p101_id_usuario"]:$this->p101_id_usuario);
       $this->p101_coddeptoorigem = ($this->p101_coddeptoorigem == ""?@$GLOBALS["HTTP_POST_VARS"]["p101_coddeptoorigem"]:$this->p101_coddeptoorigem);
       $this->p101_coddeptodestino = ($this->p101_coddeptodestino == ""?@$GLOBALS["HTTP_POST_VARS"]["p101_coddeptodestino"]:$this->p101_coddeptodestino);
       $this->p101_observacao = ($this->p101_observacao == ""?@$GLOBALS["HTTP_POST_VARS"]["p101_observacao"]:$this->p101_observacao);
       if ($this->p101_dt_protocolo == "") {
         $this->p101_dt_protocolo_dia = ($this->p101_dt_protocolo_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["p101_dt_protocolo_dia"]:$this->p101_dt_protocolo_dia);
         $this->p101_dt_protocolo_mes = ($this->p101_dt_protocolo_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["p101_dt_protocolo_mes"]:$this->p101_dt_protocolo_mes);
         $this->p101_dt_protocolo_ano = ($this->p101_dt_protocolo_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["p101_dt_protocolo_ano"]:$this->p101_dt_protocolo_ano);
         if ($this->p101_dt_protocolo_dia != "") {
            $this->p101_dt_protocolo = $this->p101_dt_protocolo_ano."-".$this->p101_dt_protocolo_mes."-".$this->p101_dt_protocolo_dia;
         }
       }
       $this->p101_hora = ($this->p101_hora == ""?@$GLOBALS["HTTP_POST_VARS"]["p101_hora"]:$this->p101_hora);
       if ($this->p101_dt_anulado == "") {
         $this->p101_dt_anulado_dia = ($this->p101_dt_anulado_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["p101_dt_anulado_dia"]:$this->p101_dt_anulado_dia);
         $this->p101_dt_anulado_mes = ($this->p101_dt_anulado_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["p101_dt_anulado_mes"]:$this->p101_dt_anulado_mes);
         $this->p101_dt_anulado_ano = ($this->p101_dt_anulado_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["p101_dt_anulado_ano"]:$this->p101_dt_anulado_ano);
         if ($this->p101_dt_anulado_dia != "") {
            $this->p101_dt_anulado = $this->p101_dt_anulado_ano."-".$this->p101_dt_anulado_mes."-".$this->p101_dt_anulado_dia;
         }
       }
     } else {
       $this->p101_sequencial = ($this->p101_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["p101_sequencial"]:$this->p101_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($p101_sequencial) {
      $this->atualizacampos();
     if ($this->p101_id_usuario == null ) {
       $this->erro_sql = " Campo Usuario não informado.";
       $this->erro_campo = "p101_id_usuario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->p101_coddeptoorigem == null ) {
       $this->erro_sql = " Campo Depart. Origem não informado.";
       $this->erro_campo = "p101_coddeptoorigem";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->p101_coddeptodestino == null ) {
       $this->erro_sql = " Campo Depart. Destino não informado.";
       $this->erro_campo = "p101_coddeptodestino";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->p101_dt_protocolo == null ) {
       $this->erro_sql = " Campo Data não informado.";
       $this->erro_campo = "p101_dt_protocolo_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->p101_hora == null ) {
       $this->erro_sql = " Campo Hora não informado.";
       $this->erro_campo = "p101_hora";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->p101_dt_anulado == null ) {
       $this->p101_dt_anulado = "null";
     }
     if ($p101_sequencial == "" || $p101_sequencial == null ) {
       $result = db_query("select nextval('protocolos_p101_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: protocolos_p101_sequencial_seq do campo: p101_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->p101_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from protocolos_p101_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $p101_sequencial)) {
         $this->erro_sql = " Campo p101_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->p101_sequencial = $p101_sequencial;
       }
     }
     if (($this->p101_sequencial == null) || ($this->p101_sequencial == "") ) {
       $this->erro_sql = " Campo p101_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into protocolos(
                                       p101_sequencial
                                      ,p101_id_usuario
                                      ,p101_coddeptoorigem
                                      ,p101_coddeptodestino
                                      ,p101_observacao
                                      ,p101_dt_protocolo
                                      ,p101_hora
                                      ,p101_dt_anulado
                       )
                values (
                                $this->p101_sequencial
                               ,$this->p101_id_usuario
                               ,$this->p101_coddeptoorigem
                               ,$this->p101_coddeptodestino
                               ,'$this->p101_observacao'
                               ,".($this->p101_dt_protocolo == "null" || $this->p101_dt_protocolo == ""?"null":"'".$this->p101_dt_protocolo."'")."
                               ,'$this->p101_hora'
                               ,".($this->p101_dt_anulado == "null" || $this->p101_dt_anulado == ""?"null":"'".$this->p101_dt_anulado."'")."
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "protocolos ($this->p101_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "protocolos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "protocolos ($this->p101_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->p101_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->p101_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009245,'$this->p101_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010192,1009245,'','".AddSlashes(pg_result($resaco,0,'p101_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009251,'','".AddSlashes(pg_result($resaco,0,'p101_id_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009252,'','".AddSlashes(pg_result($resaco,0,'p101_coddeptoorigem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009253,'','".AddSlashes(pg_result($resaco,0,'p101_coddeptodestino'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009254,'','".AddSlashes(pg_result($resaco,0,'p101_observacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009255,'','".AddSlashes(pg_result($resaco,0,'p101_dt_protocolo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009269,'','".AddSlashes(pg_result($resaco,0,'p101_hora'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009271,'','".AddSlashes(pg_result($resaco,0,'p101_dt_anulado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }
    return true;
  }

  // funcao para alteracao
  function alterar ($p101_sequencial=null) {
      $this->atualizacampos();
     $sql = " update protocolos set ";
     $virgula = "";
     if (trim($this->p101_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p101_sequencial"])) {
       $sql  .= $virgula." p101_sequencial = $this->p101_sequencial ";
       $virgula = ",";
       if (trim($this->p101_sequencial) == null ) {
         $this->erro_sql = " Campo Protocolo não informado.";
         $this->erro_campo = "p101_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->p101_id_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p101_id_usuario"])) {
       $sql  .= $virgula." p101_id_usuario = $this->p101_id_usuario ";
       $virgula = ",";
       if (trim($this->p101_id_usuario) == null ) {
         $this->erro_sql = " Campo Usuario não informado.";
         $this->erro_campo = "p101_id_usuario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->p101_coddeptoorigem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p101_coddeptoorigem"])) {
       $sql  .= $virgula." p101_coddeptoorigem = $this->p101_coddeptoorigem ";
       $virgula = ",";
       if (trim($this->p101_coddeptoorigem) == null ) {
         $this->erro_sql = " Campo Depart. Origem não informado.";
         $this->erro_campo = "p101_coddeptoorigem";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->p101_coddeptodestino)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p101_coddeptodestino"])) {
       $sql  .= $virgula." p101_coddeptodestino = $this->p101_coddeptodestino ";
       $virgula = ",";
       if (trim($this->p101_coddeptodestino) == null ) {
         $this->erro_sql = " Campo Depart. Destino não informado.";
         $this->erro_campo = "p101_coddeptodestino";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->p101_observacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p101_observacao"])) {
       $sql  .= $virgula." p101_observacao = '$this->p101_observacao' ";
       $virgula = ",";
     }
     if (trim($this->p101_dt_protocolo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p101_dt_protocolo_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["p101_dt_protocolo_dia"] !="") ) {
       $sql  .= $virgula." p101_dt_protocolo = '$this->p101_dt_protocolo' ";
       $virgula = ",";
       if (trim($this->p101_dt_protocolo) == null ) {
         $this->erro_sql = " Campo Data não informado.";
         $this->erro_campo = "p101_dt_protocolo_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["p101_dt_protocolo_dia"])) {
         $sql  .= $virgula." p101_dt_protocolo = null ";
         $virgula = ",";
         if (trim($this->p101_dt_protocolo) == null ) {
           $this->erro_sql = " Campo Data não informado.";
           $this->erro_campo = "p101_dt_protocolo_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->p101_hora)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p101_hora"])) {
       $sql  .= $virgula." p101_hora = '$this->p101_hora' ";
       $virgula = ",";
       if (trim($this->p101_hora) == null ) {
         $this->erro_sql = " Campo Hora não informado.";
         $this->erro_campo = "p101_hora";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->p101_dt_anulado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p101_dt_anulado_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["p101_dt_anulado_dia"] !="") ) {
       $sql  .= $virgula." p101_dt_anulado = '$this->p101_dt_anulado' ";
       $virgula = ",";
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["p101_dt_anulado_dia"])) {
         $sql  .= $virgula." p101_dt_anulado = null ";
         $virgula = ",";
       }
     }
     $sql .= " where ";
     if ($p101_sequencial!=null) {
       $sql .= " p101_sequencial = $this->p101_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->p101_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009245,'$this->p101_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p101_sequencial"]) || $this->p101_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009245,'".AddSlashes(pg_result($resaco,$conresaco,'p101_sequencial'))."','$this->p101_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p101_id_usuario"]) || $this->p101_id_usuario != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009251,'".AddSlashes(pg_result($resaco,$conresaco,'p101_id_usuario'))."','$this->p101_id_usuario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p101_coddeptoorigem"]) || $this->p101_coddeptoorigem != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009252,'".AddSlashes(pg_result($resaco,$conresaco,'p101_coddeptoorigem'))."','$this->p101_coddeptoorigem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p101_coddeptodestino"]) || $this->p101_coddeptodestino != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009253,'".AddSlashes(pg_result($resaco,$conresaco,'p101_coddeptodestino'))."','$this->p101_coddeptodestino',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p101_observacao"]) || $this->p101_observacao != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009254,'".AddSlashes(pg_result($resaco,$conresaco,'p101_observacao'))."','$this->p101_observacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p101_dt_protocolo"]) || $this->p101_dt_protocolo != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009255,'".AddSlashes(pg_result($resaco,$conresaco,'p101_dt_protocolo'))."','$this->p101_dt_protocolo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p101_hora"]) || $this->p101_hora != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009269,'".AddSlashes(pg_result($resaco,$conresaco,'p101_hora'))."','$this->p101_hora',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p101_dt_anulado"]) || $this->p101_dt_anulado != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009271,'".AddSlashes(pg_result($resaco,$conresaco,'p101_dt_anulado'))."','$this->p101_dt_anulado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "protocolos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->p101_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "protocolos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->p101_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->p101_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($p101_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($p101_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009245,'$p101_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009245,'','".AddSlashes(pg_result($resaco,$iresaco,'p101_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009251,'','".AddSlashes(pg_result($resaco,$iresaco,'p101_id_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009252,'','".AddSlashes(pg_result($resaco,$iresaco,'p101_coddeptoorigem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009253,'','".AddSlashes(pg_result($resaco,$iresaco,'p101_coddeptodestino'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009254,'','".AddSlashes(pg_result($resaco,$iresaco,'p101_observacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009255,'','".AddSlashes(pg_result($resaco,$iresaco,'p101_dt_protocolo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009269,'','".AddSlashes(pg_result($resaco,$iresaco,'p101_hora'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009271,'','".AddSlashes(pg_result($resaco,$iresaco,'p101_dt_anulado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from protocolos
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($p101_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " p101_sequencial = $p101_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "protocolos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$p101_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "protocolos nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$p101_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$p101_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:protocolos";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $p101_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from protocolos ";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = protocolos.p101_id_usuario";
     $sql .= "      inner join db_depart  on  db_depart.coddepto = protocolos.p101_coddeptoorigem and  db_depart.coddepto = protocolos.p101_coddeptodestino";
     $sql .= "      inner join db_config  on  db_config.codigo = db_depart.instit";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($p101_sequencial!=null ) {
         $sql2 .= " where protocolos.p101_sequencial = $p101_sequencial ";
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
  function sql_query_file ( $p101_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from protocolos ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($p101_sequencial!=null ) {
         $sql2 .= " where protocolos.p101_sequencial = $p101_sequencial ";
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

  function sql_consulta_protocolo( $p101_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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

    $sql .= " from protocolos ";
    $sql .= " inner join db_depart a ON a.coddepto = protocolos.p101_coddeptoorigem";
    $sql .= " inner join db_depart b ON b.coddepto = protocolos.p101_coddeptodestino";
    $sql .= " left join protpagordem on p105_protocolo = p101_sequencial";
    $sql .= " left join protempautoriza on p102_protocolo = p101_sequencial";
    $sql .= " left join protmatordem on p104_protocolo = p101_sequencial";
    $sql .= " left join protempenhos on p103_protocolo = p101_sequencial";
    $sql .= " left join protslip     on p106_protocolo = p101_sequencial";

    $sql2 = "";
    if ($dbwhere=="") {
      if ($p101_sequencial!=null ) {
      $sql2 .= " where protocolos.p101_sequencial = $p101_sequencial ";
      }
    }
    else if ($dbwhere != "") {
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
