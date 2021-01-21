<?php
//MODULO: sicom
//CLASSE DA ENTIDADE iderp102021
class cl_iderp102021 {
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
  public $si179_sequencial = 0;
  public $si179_tiporegistro = 0;
  public $si179_codiderp = 0;
  public $si179_codorgao = null;
  public $si179_codunidadesub = null;
  public $si179_nroempenho = 0;
  public $si179_tiporestospagar = 0;
  public $si179_disponibilidadecaixa = 0;
  public $si179_vlinscricao = 0;
  public $si179_mes = 0;
  public $si179_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si179_sequencial = int8 = Sequencial
                 si179_tiporegistro = int8 = Tipo do Registro
                 si179_codiderp = int8 = Código identificador dos  restos a pagar
                 si179_codorgao = varchar(2) = Código do órgão
                 si179_codunidadesub = varchar(8) = Código da unidade ou subunidade orçam
                 si179_nroempenho = int8 = Número do empenho
                 si179_tiporestospagar = int8 = Tipo de restos a pagar
                 si179_disponibilidadecaixa = int8 = Situação dos restos a pagar
                 si179_vlinscricao = float8 = Valor da inscrição de restos a pagar
                 si179_mes = int8 = Mês
                 si179_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("iderp102021");
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
       $this->si179_sequencial = ($this->si179_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si179_sequencial"]:$this->si179_sequencial);
       $this->si179_tiporegistro = ($this->si179_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si179_tiporegistro"]:$this->si179_tiporegistro);
       $this->si179_codiderp = ($this->si179_codiderp == ""?@$GLOBALS["HTTP_POST_VARS"]["si179_codiderp"]:$this->si179_codiderp);
       $this->si179_codorgao = ($this->si179_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si179_codorgao"]:$this->si179_codorgao);
       $this->si179_codunidadesub = ($this->si179_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si179_codunidadesub"]:$this->si179_codunidadesub);
       $this->si179_nroempenho = ($this->si179_nroempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si179_nroempenho"]:$this->si179_nroempenho);
       $this->si179_tiporestospagar = ($this->si179_tiporestospagar == ""?@$GLOBALS["HTTP_POST_VARS"]["si179_tiporestospagar"]:$this->si179_tiporestospagar);
       $this->si179_disponibilidadecaixa = ($this->si179_disponibilidadecaixa == ""?@$GLOBALS["HTTP_POST_VARS"]["si179_disponibilidadecaixa"]:$this->si179_disponibilidadecaixa);
       $this->si179_vlinscricao = ($this->si179_vlinscricao == ""?@$GLOBALS["HTTP_POST_VARS"]["si179_vlinscricao"]:$this->si179_vlinscricao);
       $this->si179_mes = ($this->si179_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si179_mes"]:$this->si179_mes);
       $this->si179_instit = ($this->si179_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si179_instit"]:$this->si179_instit);
     } else {
       $this->si179_sequencial = ($this->si179_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si179_sequencial"]:$this->si179_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si179_sequencial) {
      $this->atualizacampos();
     if ($this->si179_tiporegistro == null ) {
       $this->erro_sql = " Campo Tipo do Registro não informado.";
       $this->erro_campo = "si179_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si179_codiderp == null ) {
       $this->erro_sql = " Campo Código identificador dos  restos a pagar não informado.";
       $this->erro_campo = "si179_codiderp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si179_codorgao == null ) {
       $this->erro_sql = " Campo Código do órgão não informado.";
       $this->erro_campo = "si179_codorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si179_codunidadesub == null ) {
       $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
       $this->erro_campo = "si179_codunidadesub";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si179_nroempenho == null ) {
       $this->erro_sql = " Campo Número do empenho não informado.";
       $this->erro_campo = "si179_nroempenho";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si179_tiporestospagar == null ) {
       $this->erro_sql = " Campo Tipo de restos a pagar não informado.";
       $this->erro_campo = "si179_tiporestospagar";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si179_disponibilidadecaixa == null ) {
       $this->erro_sql = " Campo Situação dos restos a pagar não informado.";
       $this->erro_campo = "si179_disponibilidadecaixa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si179_vlinscricao == null ) {
       $this->erro_sql = " Campo Valor da inscrição de restos a pagar não informado.";
       $this->erro_campo = "si179_vlinscricao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si179_mes == null ) {
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "si179_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si179_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "si179_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($si179_sequencial == "" || $si179_sequencial == null ) {
       $result = db_query("select nextval('iderp102021_si179_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: iderp102021_si179_sequencial_seq do campo: si179_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si179_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from iderp102021_si179_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $si179_sequencial)) {
         $this->erro_sql = " Campo si179_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->si179_sequencial = $si179_sequencial;
       }
     }
     if (($this->si179_sequencial == null) || ($this->si179_sequencial == "") ) {
       $this->erro_sql = " Campo si179_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into iderp102021(
                                       si179_sequencial
                                      ,si179_tiporegistro
                                      ,si179_codiderp
                                      ,si179_codorgao
                                      ,si179_codunidadesub
                                      ,si179_nroempenho
                                      ,si179_tiporestospagar
                                      ,si179_disponibilidadecaixa
                                      ,si179_vlinscricao
                                      ,si179_mes
                                      ,si179_instit
                       )
                values (
                                $this->si179_sequencial
                               ,$this->si179_tiporegistro
                               ,$this->si179_codiderp
                               ,'$this->si179_codorgao'
                               ,'$this->si179_codunidadesub'
                               ,$this->si179_nroempenho
                               ,$this->si179_tiporestospagar
                               ,$this->si179_disponibilidadecaixa
                               ,$this->si179_vlinscricao
                               ,$this->si179_mes
                               ,$this->si179_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Inscrição de Despesas do Exercício em Restos a Pag ($this->si179_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Inscrição de Despesas do Exercício em Restos a Pag já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Inscrição de Despesas do Exercício em Restos a Pag ($this->si179_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si179_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
/*     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si179_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011897,'$this->si179_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010192,2011897,'','".AddSlashes(pg_result($resaco,0,'si179_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009244,'','".AddSlashes(pg_result($resaco,0,'si179_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,2011852,'','".AddSlashes(pg_result($resaco,0,'si179_codiderp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,2011853,'','".AddSlashes(pg_result($resaco,0,'si179_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,2011855,'','".AddSlashes(pg_result($resaco,0,'si179_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,2011856,'','".AddSlashes(pg_result($resaco,0,'si179_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,2011857,'','".AddSlashes(pg_result($resaco,0,'si179_tiporestospagar'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,2011859,'','".AddSlashes(pg_result($resaco,0,'si179_disponibilidadecaixa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,2011860,'','".AddSlashes(pg_result($resaco,0,'si179_vlinscricao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,2011901,'','".AddSlashes(pg_result($resaco,0,'si179_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,2011905,'','".AddSlashes(pg_result($resaco,0,'si179_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($si179_sequencial=null) {
      $this->atualizacampos();
     $sql = " update iderp102021 set ";
     $virgula = "";
     if (trim($this->si179_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si179_sequencial"])) {
       $sql  .= $virgula." si179_sequencial = $this->si179_sequencial ";
       $virgula = ",";
       if (trim($this->si179_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "si179_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si179_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si179_tiporegistro"])) {
       $sql  .= $virgula." si179_tiporegistro = $this->si179_tiporegistro ";
       $virgula = ",";
       if (trim($this->si179_tiporegistro) == null ) {
         $this->erro_sql = " Campo Tipo do Registro não informado.";
         $this->erro_campo = "si179_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si179_codiderp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si179_codiderp"])) {
       $sql  .= $virgula." si179_codiderp = $this->si179_codiderp ";
       $virgula = ",";
       if (trim($this->si179_codiderp) == null ) {
         $this->erro_sql = " Campo Código identificador dos  restos a pagar não informado.";
         $this->erro_campo = "si179_codiderp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si179_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si179_codorgao"])) {
       $sql  .= $virgula." si179_codorgao = '$this->si179_codorgao' ";
       $virgula = ",";
       if (trim($this->si179_codorgao) == null ) {
         $this->erro_sql = " Campo Código do órgão não informado.";
         $this->erro_campo = "si179_codorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si179_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si179_codunidadesub"])) {
       $sql  .= $virgula." si179_codunidadesub = '$this->si179_codunidadesub' ";
       $virgula = ",";
       if (trim($this->si179_codunidadesub) == null ) {
         $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
         $this->erro_campo = "si179_codunidadesub";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si179_nroempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si179_nroempenho"])) {
       $sql  .= $virgula." si179_nroempenho = $this->si179_nroempenho ";
       $virgula = ",";
       if (trim($this->si179_nroempenho) == null ) {
         $this->erro_sql = " Campo Número do empenho não informado.";
         $this->erro_campo = "si179_nroempenho";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si179_tiporestospagar)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si179_tiporestospagar"])) {
       $sql  .= $virgula." si179_tiporestospagar = $this->si179_tiporestospagar ";
       $virgula = ",";
       if (trim($this->si179_tiporestospagar) == null ) {
         $this->erro_sql = " Campo Tipo de restos a pagar não informado.";
         $this->erro_campo = "si179_tiporestospagar";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si179_disponibilidadecaixa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si179_disponibilidadecaixa"])) {
       $sql  .= $virgula." si179_disponibilidadecaixa = $this->si179_disponibilidadecaixa ";
       $virgula = ",";
       if (trim($this->si179_disponibilidadecaixa) == null ) {
         $this->erro_sql = " Campo Situação dos restos a pagar não informado.";
         $this->erro_campo = "si179_disponibilidadecaixa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si179_vlinscricao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si179_vlinscricao"])) {
       $sql  .= $virgula." si179_vlinscricao = $this->si179_vlinscricao ";
       $virgula = ",";
       if (trim($this->si179_vlinscricao) == null ) {
         $this->erro_sql = " Campo Valor da inscrição de restos a pagar não informado.";
         $this->erro_campo = "si179_vlinscricao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si179_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si179_mes"])) {
       $sql  .= $virgula." si179_mes = $this->si179_mes ";
       $virgula = ",";
       if (trim($this->si179_mes) == null ) {
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "si179_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si179_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si179_instit"])) {
       $sql  .= $virgula." si179_instit = $this->si179_instit ";
       $virgula = ",";
       if (trim($this->si179_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "si179_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si179_sequencial!=null) {
       $sql .= " si179_sequencial = $this->si179_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
/*     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si179_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2011897,'$this->si179_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si179_sequencial"]) || $this->si179_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2011897,'".AddSlashes(pg_result($resaco,$conresaco,'si179_sequencial'))."','$this->si179_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si179_tiporegistro"]) || $this->si179_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009244,'".AddSlashes(pg_result($resaco,$conresaco,'si179_tiporegistro'))."','$this->si179_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si179_codiderp"]) || $this->si179_codiderp != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2011852,'".AddSlashes(pg_result($resaco,$conresaco,'si179_codiderp'))."','$this->si179_codiderp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si179_codorgao"]) || $this->si179_codorgao != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2011853,'".AddSlashes(pg_result($resaco,$conresaco,'si179_codorgao'))."','$this->si179_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si179_codunidadesub"]) || $this->si179_codunidadesub != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2011855,'".AddSlashes(pg_result($resaco,$conresaco,'si179_codunidadesub'))."','$this->si179_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si179_nroempenho"]) || $this->si179_nroempenho != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2011856,'".AddSlashes(pg_result($resaco,$conresaco,'si179_nroempenho'))."','$this->si179_nroempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si179_tiporestospagar"]) || $this->si179_tiporestospagar != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2011857,'".AddSlashes(pg_result($resaco,$conresaco,'si179_tiporestospagar'))."','$this->si179_tiporestospagar',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si179_disponibilidadecaixa"]) || $this->si179_disponibilidadecaixa != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2011859,'".AddSlashes(pg_result($resaco,$conresaco,'si179_disponibilidadecaixa'))."','$this->si179_disponibilidadecaixa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si179_vlinscricao"]) || $this->si179_vlinscricao != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2011860,'".AddSlashes(pg_result($resaco,$conresaco,'si179_vlinscricao'))."','$this->si179_vlinscricao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si179_mes"]) || $this->si179_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2011901,'".AddSlashes(pg_result($resaco,$conresaco,'si179_mes'))."','$this->si179_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si179_instit"]) || $this->si179_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2011905,'".AddSlashes(pg_result($resaco,$conresaco,'si179_instit'))."','$this->si179_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Inscrição de Despesas do Exercício em Restos a Pag nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si179_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Inscrição de Despesas do Exercício em Restos a Pag nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si179_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si179_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($si179_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
/*     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si179_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2011897,'$si179_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010192,2011897,'','".AddSlashes(pg_result($resaco,$iresaco,'si179_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009244,'','".AddSlashes(pg_result($resaco,$iresaco,'si179_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,2011852,'','".AddSlashes(pg_result($resaco,$iresaco,'si179_codiderp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,2011853,'','".AddSlashes(pg_result($resaco,$iresaco,'si179_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,2011855,'','".AddSlashes(pg_result($resaco,$iresaco,'si179_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,2011856,'','".AddSlashes(pg_result($resaco,$iresaco,'si179_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,2011857,'','".AddSlashes(pg_result($resaco,$iresaco,'si179_tiporestospagar'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,2011859,'','".AddSlashes(pg_result($resaco,$iresaco,'si179_disponibilidadecaixa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,2011860,'','".AddSlashes(pg_result($resaco,$iresaco,'si179_vlinscricao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,2011901,'','".AddSlashes(pg_result($resaco,$iresaco,'si179_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,2011905,'','".AddSlashes(pg_result($resaco,$iresaco,'si179_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from iderp102021
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si179_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si179_sequencial = $si179_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Inscrição de Despesas do Exercício em Restos a Pag nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si179_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Inscrição de Despesas do Exercício em Restos a Pag nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si179_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si179_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:iderp102021";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si179_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from iderp102021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si179_sequencial!=null ) {
         $sql2 .= " where iderp102021.si179_sequencial = $si179_sequencial ";
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
  function sql_query_file ( $si179_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from iderp102021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si179_sequencial!=null ) {
         $sql2 .= " where iderp102021.si179_sequencial = $si179_sequencial ";
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
