<?php
//MODULO: sicom
//CLASSE DA ENTIDADE iderp202020
class cl_iderp202020 {
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
  public $si181_sequencial = 0;
  public $si181_tiporegistro = 0;
  public $si181_codorgao = null;
  public $si181_codfontrecursos = 0;
  public $si181_vlcaixabruta = 0;
  public $si181_vlrspexerciciosanteriores = 0;
  public $si181_vlrestituiveisrecolher = 0;
  public $si181_vlrestituiveisativofinanceiro = 0;
  public $si181_vlsaldodispcaixa = 0;
  public $si181_mes = 0;
  public $si181_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si181_sequencial = int8 = Sequencial
                 si181_tiporegistro = int8 = Tipo do registro
                 si181_codorgao = varchar(2) = Código do órgão
                 si181_codfontrecursos = int8 = Código da fonte de recursos
                 si181_vlcaixabruta = float8 = Valor da disponibilidade de caixa bruta
                 si181_vlrspexerciciosanteriores = float8 = Restos a pagar de exercícios anteriores
                 si181_vlrestituiveisrecolher = float8 = Valores restituíveis a recolher
                 si181_vlrestituiveisativofinanceiro = float8 = Valores restituíveis registrados no Ativ
                 si181_vlsaldodispcaixa = float8 = Saldo da disponibilidade de caixa
                 si181_mes = int8 = Mês
                 si181_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("iderp202020");
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
       $this->si181_sequencial = ($this->si181_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si181_sequencial"]:$this->si181_sequencial);
       $this->si181_tiporegistro = ($this->si181_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si181_tiporegistro"]:$this->si181_tiporegistro);
       $this->si181_codorgao = ($this->si181_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si181_codorgao"]:$this->si181_codorgao);
       $this->si181_codfontrecursos = ($this->si181_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si181_codfontrecursos"]:$this->si181_codfontrecursos);
       $this->si181_vlcaixabruta = ($this->si181_vlcaixabruta == ""?@$GLOBALS["HTTP_POST_VARS"]["si181_vlcaixabruta"]:$this->si181_vlcaixabruta);
       $this->si181_vlrspexerciciosanteriores = ($this->si181_vlrspexerciciosanteriores == ""?@$GLOBALS["HTTP_POST_VARS"]["si181_vlrspexerciciosanteriores"]:$this->si181_vlrspexerciciosanteriores);
       $this->si181_vlrestituiveisrecolher = ($this->si181_vlrestituiveisrecolher == ""?@$GLOBALS["HTTP_POST_VARS"]["si181_vlrestituiveisrecolher"]:$this->si181_vlrestituiveisrecolher);
       $this->si181_vlrestituiveisativofinanceiro = ($this->si181_vlrestituiveisativofinanceiro == ""?@$GLOBALS["HTTP_POST_VARS"]["si181_vlrestituiveisativofinanceiro"]:$this->si181_vlrestituiveisativofinanceiro);
       $this->si181_vlsaldodispcaixa = ($this->si181_vlsaldodispcaixa == ""?@$GLOBALS["HTTP_POST_VARS"]["si181_vlsaldodispcaixa"]:$this->si181_vlsaldodispcaixa);
       $this->si181_mes = ($this->si181_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si181_mes"]:$this->si181_mes);
       $this->si181_instit = ($this->si181_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si181_instit"]:$this->si181_instit);
     } else {
       $this->si181_sequencial = ($this->si181_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si181_sequencial"]:$this->si181_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si181_sequencial) {
      $this->atualizacampos();
     if ($this->si181_tiporegistro == null ) {
       $this->erro_sql = " Campo Tipo do registro não informado.";
       $this->erro_campo = "si181_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si181_codorgao == null ) {
       $this->erro_sql = " Campo Código do órgão não informado.";
       $this->erro_campo = "si181_codorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si181_codfontrecursos == null ) {
       $this->erro_sql = " Campo Código da fonte de recursos não informado.";
       $this->erro_campo = "si181_codfontrecursos";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si181_vlcaixabruta == null ) {
       $this->erro_sql = " Campo Valor da disponibilidade de caixa bruta não informado.";
       $this->erro_campo = "si181_vlcaixabruta";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si181_vlrspexerciciosanteriores == null ) {
       $this->erro_sql = " Campo Restos a pagar de exercícios anteriores não informado.";
       $this->erro_campo = "si181_vlrspexerciciosanteriores";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
//     if ($this->si181_vlrestituiveisrecolher == null ) {
//       $this->erro_sql = " Campo Valores restituíveis a recolher não informado.";
//       $this->erro_campo = "si181_vlrestituiveisrecolher";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
//     if ($this->si181_vlrestituiveisativofinanceiro == null ) {
//       $this->erro_sql = " Campo Valores restituíveis registrados no Ativ não informado.";
//       $this->erro_campo = "si181_vlrestituiveisativofinanceiro";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
     if ($this->si181_vlsaldodispcaixa == null ) {
       $this->erro_sql = " Campo Saldo da disponibilidade de caixa não informado.";
       $this->erro_campo = "si181_vlsaldodispcaixa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si181_mes == null ) {
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "si181_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si181_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "si181_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($si181_sequencial == "" || $si181_sequencial == null ) {
       $result = db_query("select nextval('iderp202020_si181_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: iderp202020_si181_sequencial_seq do campo: si181_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si181_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from iderp202020_si181_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $si181_sequencial)) {
         $this->erro_sql = " Campo si181_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->si181_sequencial = $si181_sequencial;
       }
     }
     if (($this->si181_sequencial == null) || ($this->si181_sequencial == "") ) {
       $this->erro_sql = " Campo si181_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into iderp202020(
                                       si181_sequencial
                                      ,si181_tiporegistro
                                      ,si181_codorgao
                                      ,si181_codfontrecursos
                                      ,si181_vlcaixabruta
                                      ,si181_vlrspexerciciosanteriores
                                      ,si181_vlrestituiveisrecolher
                                      ,si181_vlrestituiveisativofinanceiro
                                      ,si181_vlsaldodispcaixa
                                      ,si181_mes
                                      ,si181_instit
                       )
                values (
                                $this->si181_sequencial
                               ,$this->si181_tiporegistro
                               ,'$this->si181_codorgao'
                               ,$this->si181_codfontrecursos
                               ,$this->si181_vlcaixabruta
                               ,$this->si181_vlrspexerciciosanteriores
                               ,".($this->si181_vlrestituiveisrecolher == "null" || $this->si181_vlrestituiveisrecolher == ""?"null":"'".$this->si181_vlrestituiveisrecolher."'")."
                               ,".($this->si181_vlrestituiveisativofinanceiro == "null" || $this->si181_vlrestituiveisativofinanceiro == ""?"null":"'".$this->si181_vlrestituiveisativofinanceiro."'")."
                               ,$this->si181_vlsaldodispcaixa
                               ,$this->si181_mes
                               ,$this->si181_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Disponibilidade de Caixa ($this->si181_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Disponibilidade de Caixa já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Disponibilidade de Caixa ($this->si181_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si181_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
    //  $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    //  if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
    //    && ($lSessaoDesativarAccount === false))) {

    //    $resaco = $this->sql_record($this->sql_query_file($this->si181_sequencial  ));
    //    if (($resaco!=false)||($this->numrows!=0)) {

    //      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
    //      $acount = pg_result($resac,0,0);
    //      $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
    //      $resac = db_query("insert into db_acountkey values($acount,2011899,'$this->si181_sequencial','I')");
    //      $resac = db_query("insert into db_acount values($acount,1010194,2011899,'','".AddSlashes(pg_result($resaco,0,'si181_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,1010194,2011865,'','".AddSlashes(pg_result($resaco,0,'si181_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,1010194,2011866,'','".AddSlashes(pg_result($resaco,0,'si181_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,1010194,2011867,'','".AddSlashes(pg_result($resaco,0,'si181_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,1010194,2011868,'','".AddSlashes(pg_result($resaco,0,'si181_vlcaixabruta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,1010194,2011869,'','".AddSlashes(pg_result($resaco,0,'si181_vlrspexerciciosanteriores'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,1010194,2011870,'','".AddSlashes(pg_result($resaco,0,'si181_vlrestituiveisrecolher'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,1010194,2011872,'','".AddSlashes(pg_result($resaco,0,'si181_vlrestituiveisativofinanceiro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,1010194,2011910,'','".AddSlashes(pg_result($resaco,0,'si181_vlsaldodispcaixa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,1010194,2011903,'','".AddSlashes(pg_result($resaco,0,'si181_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      $resac = db_query("insert into db_acount values($acount,1010194,2011907,'','".AddSlashes(pg_result($resaco,0,'si181_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //    }
    // }
    return true;
  }

  // funcao para alteracao
  function alterar ($si181_sequencial=null) {
      $this->atualizacampos();
     $sql = " update iderp202020 set ";
     $virgula = "";
     if (trim($this->si181_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si181_sequencial"])) {
       $sql  .= $virgula." si181_sequencial = $this->si181_sequencial ";
       $virgula = ",";
       if (trim($this->si181_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "si181_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si181_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si181_tiporegistro"])) {
       $sql  .= $virgula." si181_tiporegistro = $this->si181_tiporegistro ";
       $virgula = ",";
       if (trim($this->si181_tiporegistro) == null ) {
         $this->erro_sql = " Campo Tipo do registro não informado.";
         $this->erro_campo = "si181_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si181_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si181_codorgao"])) {
       $sql  .= $virgula." si181_codorgao = '$this->si181_codorgao' ";
       $virgula = ",";
       if (trim($this->si181_codorgao) == null ) {
         $this->erro_sql = " Campo Código do órgão não informado.";
         $this->erro_campo = "si181_codorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si181_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si181_codfontrecursos"])) {
       $sql  .= $virgula." si181_codfontrecursos = $this->si181_codfontrecursos ";
       $virgula = ",";
       if (trim($this->si181_codfontrecursos) == null ) {
         $this->erro_sql = " Campo Código da fonte de recursos não informado.";
         $this->erro_campo = "si181_codfontrecursos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si181_vlcaixabruta)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si181_vlcaixabruta"])) {
       $sql  .= $virgula." si181_vlcaixabruta = $this->si181_vlcaixabruta ";
       $virgula = ",";
       if (trim($this->si181_vlcaixabruta) == null ) {
         $this->erro_sql = " Campo Valor da disponibilidade de caixa bruta não informado.";
         $this->erro_campo = "si181_vlcaixabruta";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si181_vlrspexerciciosanteriores)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si181_vlrspexerciciosanteriores"])) {
       $sql  .= $virgula." si181_vlrspexerciciosanteriores = $this->si181_vlrspexerciciosanteriores ";
       $virgula = ",";
       if (trim($this->si181_vlrspexerciciosanteriores) == null ) {
         $this->erro_sql = " Campo Restos a pagar de exercícios anteriores não informado.";
         $this->erro_campo = "si181_vlrspexerciciosanteriores";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si181_vlrestituiveisrecolher)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si181_vlrestituiveisrecolher"])) {
       $sql  .= $virgula." si181_vlrestituiveisrecolher = $this->si181_vlrestituiveisrecolher ";
       $virgula = ",";
       if (trim($this->si181_vlrestituiveisrecolher) == null ) {
         $this->erro_sql = " Campo Valores restituíveis a recolher não informado.";
         $this->erro_campo = "si181_vlrestituiveisrecolher";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si181_vlrestituiveisativofinanceiro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si181_vlrestituiveisativofinanceiro"])) {
       $sql  .= $virgula." si181_vlrestituiveisativofinanceiro = $this->si181_vlrestituiveisativofinanceiro ";
       $virgula = ",";
       if (trim($this->si181_vlrestituiveisativofinanceiro) == null ) {
         $this->erro_sql = " Campo Valores restituíveis registrados no Ativ não informado.";
         $this->erro_campo = "si181_vlrestituiveisativofinanceiro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si181_vlsaldodispcaixa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si181_vlsaldodispcaixa"])) {
       $sql  .= $virgula." si181_vlsaldodispcaixa = $this->si181_vlsaldodispcaixa ";
       $virgula = ",";
       if (trim($this->si181_vlsaldodispcaixa) == null ) {
         $this->erro_sql = " Campo Saldo da disponibilidade de caixa não informado.";
         $this->erro_campo = "si181_vlsaldodispcaixa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si181_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si181_mes"])) {
       $sql  .= $virgula." si181_mes = $this->si181_mes ";
       $virgula = ",";
       if (trim($this->si181_mes) == null ) {
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "si181_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si181_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si181_instit"])) {
       $sql  .= $virgula." si181_instit = $this->si181_instit ";
       $virgula = ",";
       if (trim($this->si181_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "si181_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si181_sequencial!=null) {
       $sql .= " si181_sequencial = $this->si181_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
   /*  if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si181_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2011899,'$this->si181_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si181_sequencial"]) || $this->si181_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2011899,'".AddSlashes(pg_result($resaco,$conresaco,'si181_sequencial'))."','$this->si181_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si181_tiporegistro"]) || $this->si181_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2011865,'".AddSlashes(pg_result($resaco,$conresaco,'si181_tiporegistro'))."','$this->si181_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si181_codorgao"]) || $this->si181_codorgao != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2011866,'".AddSlashes(pg_result($resaco,$conresaco,'si181_codorgao'))."','$this->si181_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si181_codfontrecursos"]) || $this->si181_codfontrecursos != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2011867,'".AddSlashes(pg_result($resaco,$conresaco,'si181_codfontrecursos'))."','$this->si181_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si181_vlcaixabruta"]) || $this->si181_vlcaixabruta != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2011868,'".AddSlashes(pg_result($resaco,$conresaco,'si181_vlcaixabruta'))."','$this->si181_vlcaixabruta',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si181_vlrspexerciciosanteriores"]) || $this->si181_vlrspexerciciosanteriores != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2011869,'".AddSlashes(pg_result($resaco,$conresaco,'si181_vlrspexerciciosanteriores'))."','$this->si181_vlrspexerciciosanteriores',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si181_vlrestituiveisrecolher"]) || $this->si181_vlrestituiveisrecolher != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2011870,'".AddSlashes(pg_result($resaco,$conresaco,'si181_vlrestituiveisrecolher'))."','$this->si181_vlrestituiveisrecolher',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si181_vlrestituiveisativofinanceiro"]) || $this->si181_vlrestituiveisativofinanceiro != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2011872,'".AddSlashes(pg_result($resaco,$conresaco,'si181_vlrestituiveisativofinanceiro'))."','$this->si181_vlrestituiveisativofinanceiro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si181_vlsaldodispcaixa"]) || $this->si181_vlsaldodispcaixa != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2011910,'".AddSlashes(pg_result($resaco,$conresaco,'si181_vlsaldodispcaixa'))."','$this->si181_vlsaldodispcaixa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si181_mes"]) || $this->si181_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2011903,'".AddSlashes(pg_result($resaco,$conresaco,'si181_mes'))."','$this->si181_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si181_instit"]) || $this->si181_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010194,2011907,'".AddSlashes(pg_result($resaco,$conresaco,'si181_instit'))."','$this->si181_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Disponibilidade de Caixa nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si181_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Disponibilidade de Caixa nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si181_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si181_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($si181_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
/*     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si181_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2011899,'$si181_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010194,2011899,'','".AddSlashes(pg_result($resaco,$iresaco,'si181_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,2011865,'','".AddSlashes(pg_result($resaco,$iresaco,'si181_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,2011866,'','".AddSlashes(pg_result($resaco,$iresaco,'si181_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,2011867,'','".AddSlashes(pg_result($resaco,$iresaco,'si181_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,2011868,'','".AddSlashes(pg_result($resaco,$iresaco,'si181_vlcaixabruta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,2011869,'','".AddSlashes(pg_result($resaco,$iresaco,'si181_vlrspexerciciosanteriores'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,2011870,'','".AddSlashes(pg_result($resaco,$iresaco,'si181_vlrestituiveisrecolher'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,2011872,'','".AddSlashes(pg_result($resaco,$iresaco,'si181_vlrestituiveisativofinanceiro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,2011910,'','".AddSlashes(pg_result($resaco,$iresaco,'si181_vlsaldodispcaixa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,2011903,'','".AddSlashes(pg_result($resaco,$iresaco,'si181_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,2011907,'','".AddSlashes(pg_result($resaco,$iresaco,'si181_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from iderp202020
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si181_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si181_sequencial = $si181_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Disponibilidade de Caixa nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si181_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Disponibilidade de Caixa nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si181_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si181_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:iderp202020";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si181_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from iderp202020 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si181_sequencial!=null ) {
         $sql2 .= " where iderp202020.si181_sequencial = $si181_sequencial ";
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
  function sql_query_file ( $si181_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from iderp202020 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si181_sequencial!=null ) {
         $sql2 .= " where iderp202020.si181_sequencial = $si181_sequencial ";
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
