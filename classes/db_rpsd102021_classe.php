<?php
//MODULO: sicom
//CLASSE DA ENTIDADE rpsd102021
class cl_rpsd102021 {
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
  public $si189_sequencial = 0;
  public $si189_tiporegistro = 0;
  public $si189_codreduzidorsp = 0;
  public $si189_codorgao = null;
  public $si189_codunidadesub = null;
  public $si189_codunidadesuborig = null;
  public $si189_nroempenho = 0;
  public $si189_exercicioempenho = 0;
  public $si189_dtempenho_dia = null;
  public $si189_dtempenho_mes = null;
  public $si189_dtempenho_ano = null;
  public $si189_dtempenho = null;
  public $si189_tipopagamentorsp = 0;
  public $si189_vlpagorsp = 0;
  public $si189_mes = 0;
  public $si189_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si189_sequencial = int8 = Sequencial
                 si189_tiporegistro = int8 = Tipo do Registro
                 si189_codreduzidorsp = int8 = Código Identificador do resto a pagar
                 si189_codorgao = varchar(2) = Código do órgão
                 si189_codunidadesub = varchar(8) = Código da unidade ou subunidade orçam
                 si189_codunidadesuborig = varchar(8) = Código da unidade ou subunidade orçam
                 si189_nroempenho = int8 = Número do empenho
                 si189_exercicioempenho = int8 = Exercício do empenho
                 si189_dtempenho = date = Data do empenho
                 si189_tipopagamentorsp = int8 = Tipo do Pagamento de Restos a Pagar
                 si189_vlpagorsp = float8 = Valor pago de Restos a Pagar
                 si189_mes = int8 = Mês
                 si189_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("rpsd102021");
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
       $this->si189_sequencial = ($this->si189_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_sequencial"]:$this->si189_sequencial);
       $this->si189_tiporegistro = ($this->si189_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_tiporegistro"]:$this->si189_tiporegistro);
       $this->si189_codreduzidorsp = ($this->si189_codreduzidorsp == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_codreduzidorsp"]:$this->si189_codreduzidorsp);
       $this->si189_codorgao = ($this->si189_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_codorgao"]:$this->si189_codorgao);
       $this->si189_codunidadesub = ($this->si189_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_codunidadesub"]:$this->si189_codunidadesub);
       $this->si189_codunidadesuborig = ($this->si189_codunidadesuborig == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_codunidadesuborig"]:$this->si189_codunidadesuborig);
       $this->si189_nroempenho = ($this->si189_nroempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_nroempenho"]:$this->si189_nroempenho);
       $this->si189_exercicioempenho = ($this->si189_exercicioempenho == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_exercicioempenho"]:$this->si189_exercicioempenho);
       if ($this->si189_dtempenho == "") {
         $this->si189_dtempenho_dia = ($this->si189_dtempenho_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_dtempenho_dia"]:$this->si189_dtempenho_dia);
         $this->si189_dtempenho_mes = ($this->si189_dtempenho_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_dtempenho_mes"]:$this->si189_dtempenho_mes);
         $this->si189_dtempenho_ano = ($this->si189_dtempenho_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_dtempenho_ano"]:$this->si189_dtempenho_ano);
         if ($this->si189_dtempenho_dia != "") {
            $this->si189_dtempenho = $this->si189_dtempenho_ano."-".$this->si189_dtempenho_mes."-".$this->si189_dtempenho_dia;
         }
       }
       $this->si189_tipopagamentorsp = ($this->si189_tipopagamentorsp == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_tipopagamentorsp"]:$this->si189_tipopagamentorsp);
       $this->si189_vlpagorsp = ($this->si189_vlpagorsp == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_vlpagorsp"]:$this->si189_vlpagorsp);
       $this->si189_mes = ($this->si189_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_mes"]:$this->si189_mes);
       $this->si189_instit = ($this->si189_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_instit"]:$this->si189_instit);
     } else {
       $this->si189_sequencial = ($this->si189_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si189_sequencial"]:$this->si189_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($si189_sequencial) {
      $this->atualizacampos();
     if ($this->si189_tiporegistro == null ) {
       $this->erro_sql = " Campo Tipo do Registro não informado.";
       $this->erro_campo = "si189_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si189_codreduzidorsp == null ) {
       $this->erro_sql = " Campo Código Identificador do resto a pagar não informado.";
       $this->erro_campo = "si189_codreduzidorsp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si189_codorgao == null ) {
       $this->erro_sql = " Campo Código do órgão não informado.";
       $this->erro_campo = "si189_codorgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si189_codunidadesub == null ) {
       $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
       $this->erro_campo = "si189_codunidadesub";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si189_codunidadesuborig == null ) {
       $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
       $this->erro_campo = "si189_codunidadesuborig";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si189_nroempenho == null ) {
       $this->erro_sql = " Campo Número do empenho não informado.";
       $this->erro_campo = "si189_nroempenho";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si189_exercicioempenho == null ) {
       $this->erro_sql = " Campo Exercício do empenho não informado.";
       $this->erro_campo = "si189_exercicioempenho";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si189_dtempenho == null ) {
       $this->erro_sql = " Campo Data do empenho não informado.";
       $this->erro_campo = "si189_dtempenho_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si189_tipopagamentorsp == null ) {
       $this->erro_sql = " Campo Tipo do Pagamento de Restos a Pagar não informado.";
       $this->erro_campo = "si189_tipopagamentorsp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si189_vlpagorsp == null ) {
       $this->erro_sql = " Campo Valor pago de Restos a Pagar não informado.";
       $this->erro_campo = "si189_vlpagorsp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si189_mes == null ) {
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "si189_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si189_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "si189_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($si189_sequencial == "" || $si189_sequencial == null ) {
       $result = db_query("select nextval('rpsd102021_si189_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: rpsd102021_si189_sequencial_seq do campo: si189_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si189_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from rpsd102021_si189_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $si189_sequencial)) {
         $this->erro_sql = " Campo si189_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->si189_sequencial = $si189_sequencial;
       }
     }
     if (($this->si189_sequencial == null) || ($this->si189_sequencial == "") ) {
       $this->erro_sql = " Campo si189_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into rpsd102021(
                                       si189_sequencial
                                      ,si189_tiporegistro
                                      ,si189_codreduzidorsp
                                      ,si189_codorgao
                                      ,si189_codunidadesub
                                      ,si189_codunidadesuborig
                                      ,si189_nroempenho
                                      ,si189_exercicioempenho
                                      ,si189_dtempenho
                                      ,si189_tipopagamentorsp
                                      ,si189_vlpagorsp
                                      ,si189_mes
                                      ,si189_instit
                       )
                values (
                                $this->si189_sequencial
                               ,$this->si189_tiporegistro
                               ,$this->si189_codreduzidorsp
                               ,'$this->si189_codorgao'
                               ,'$this->si189_codunidadesub'
                               ,'$this->si189_codunidadesuborig'
                               ,$this->si189_nroempenho
                               ,$this->si189_exercicioempenho
                               ,".($this->si189_dtempenho == "null" || $this->si189_dtempenho == ""?"null":"'".$this->si189_dtempenho."'")."
                               ,$this->si189_tipopagamentorsp
                               ,$this->si189_vlpagorsp
                               ,$this->si189_mes
                               ,$this->si189_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Restos a Pagar do Ensino, Saúde e Fundeb ($this->si189_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Restos a Pagar do Ensino, Saúde e Fundeb já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Restos a Pagar do Ensino, Saúde e Fundeb ($this->si189_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si189_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si189_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2012021,'$this->si189_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010202,2012021,'','".AddSlashes(pg_result($resaco,0,'si189_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2012008,'','".AddSlashes(pg_result($resaco,0,'si189_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2012010,'','".AddSlashes(pg_result($resaco,0,'si189_codreduzidorsp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2012011,'','".AddSlashes(pg_result($resaco,0,'si189_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2012012,'','".AddSlashes(pg_result($resaco,0,'si189_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2012013,'','".AddSlashes(pg_result($resaco,0,'si189_codunidadesuborig'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2012014,'','".AddSlashes(pg_result($resaco,0,'si189_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2012015,'','".AddSlashes(pg_result($resaco,0,'si189_exercicioempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2012016,'','".AddSlashes(pg_result($resaco,0,'si189_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2012017,'','".AddSlashes(pg_result($resaco,0,'si189_tipopagamentorsp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2012021,'','".AddSlashes(pg_result($resaco,0,'si189_vlpagorsp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2012021,'','".AddSlashes(pg_result($resaco,0,'si189_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,2012021,'','".AddSlashes(pg_result($resaco,0,'si189_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($si189_sequencial=null) {
      $this->atualizacampos();
     $sql = " update rpsd102021 set ";
     $virgula = "";
     if (trim($this->si189_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si189_sequencial"])) {
       $sql  .= $virgula." si189_sequencial = $this->si189_sequencial ";
       $virgula = ",";
       if (trim($this->si189_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "si189_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si189_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si189_tiporegistro"])) {
       $sql  .= $virgula." si189_tiporegistro = $this->si189_tiporegistro ";
       $virgula = ",";
       if (trim($this->si189_tiporegistro) == null ) {
         $this->erro_sql = " Campo Tipo do Registro não informado.";
         $this->erro_campo = "si189_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si189_codreduzidorsp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si189_codreduzidorsp"])) {
       $sql  .= $virgula." si189_codreduzidorsp = $this->si189_codreduzidorsp ";
       $virgula = ",";
       if (trim($this->si189_codreduzidorsp) == null ) {
         $this->erro_sql = " Campo Código Identificador do resto a pagar não informado.";
         $this->erro_campo = "si189_codreduzidorsp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si189_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si189_codorgao"])) {
       $sql  .= $virgula." si189_codorgao = '$this->si189_codorgao' ";
       $virgula = ",";
       if (trim($this->si189_codorgao) == null ) {
         $this->erro_sql = " Campo Código do órgão não informado.";
         $this->erro_campo = "si189_codorgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si189_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si189_codunidadesub"])) {
       $sql  .= $virgula." si189_codunidadesub = '$this->si189_codunidadesub' ";
       $virgula = ",";
       if (trim($this->si189_codunidadesub) == null ) {
         $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
         $this->erro_campo = "si189_codunidadesub";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si189_codunidadesuborig)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si189_codunidadesuborig"])) {
       $sql  .= $virgula." si189_codunidadesuborig = '$this->si189_codunidadesuborig' ";
       $virgula = ",";
       if (trim($this->si189_codunidadesuborig) == null ) {
         $this->erro_sql = " Campo Código da unidade ou subunidade orçam não informado.";
         $this->erro_campo = "si189_codunidadesuborig";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si189_nroempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si189_nroempenho"])) {
       $sql  .= $virgula." si189_nroempenho = $this->si189_nroempenho ";
       $virgula = ",";
       if (trim($this->si189_nroempenho) == null ) {
         $this->erro_sql = " Campo Número do empenho não informado.";
         $this->erro_campo = "si189_nroempenho";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si189_exercicioempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si189_exercicioempenho"])) {
       $sql  .= $virgula." si189_exercicioempenho = $this->si189_exercicioempenho ";
       $virgula = ",";
       if (trim($this->si189_exercicioempenho) == null ) {
         $this->erro_sql = " Campo Exercício do empenho não informado.";
         $this->erro_campo = "si189_exercicioempenho";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si189_dtempenho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si189_dtempenho_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si189_dtempenho_dia"] !="") ) {
       $sql  .= $virgula." si189_dtempenho = '$this->si189_dtempenho' ";
       $virgula = ",";
       if (trim($this->si189_dtempenho) == null ) {
         $this->erro_sql = " Campo Data do empenho não informado.";
         $this->erro_campo = "si189_dtempenho_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["si189_dtempenho_dia"])) {
         $sql  .= $virgula." si189_dtempenho = null ";
         $virgula = ",";
         if (trim($this->si189_dtempenho) == null ) {
           $this->erro_sql = " Campo Data do empenho não informado.";
           $this->erro_campo = "si189_dtempenho_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->si189_tipopagamentorsp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si189_tipopagamentorsp"])) {
       $sql  .= $virgula." si189_tipopagamentorsp = $this->si189_tipopagamentorsp ";
       $virgula = ",";
       if (trim($this->si189_tipopagamentorsp) == null ) {
         $this->erro_sql = " Campo Tipo do Pagamento de Restos a Pagar não informado.";
         $this->erro_campo = "si189_tipopagamentorsp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si189_vlpagorsp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si189_vlpagorsp"])) {
       $sql  .= $virgula." si189_vlpagorsp = $this->si189_vlpagorsp ";
       $virgula = ",";
       if (trim($this->si189_vlpagorsp) == null ) {
         $this->erro_sql = " Campo Valor pago de Restos a Pagar não informado.";
         $this->erro_campo = "si189_vlpagorsp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si189_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si189_mes"])) {
       $sql  .= $virgula." si189_mes = $this->si189_mes ";
       $virgula = ",";
       if (trim($this->si189_mes) == null ) {
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "si189_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si189_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si189_instit"])) {
       $sql  .= $virgula." si189_instit = $this->si189_instit ";
       $virgula = ",";
       if (trim($this->si189_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "si189_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($si189_sequencial!=null) {
       $sql .= " si189_sequencial = $this->si189_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si189_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2012021,'$this->si189_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si189_sequencial"]) || $this->si189_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2012021,'".AddSlashes(pg_result($resaco,$conresaco,'si189_sequencial'))."','$this->si189_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si189_tiporegistro"]) || $this->si189_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2012008,'".AddSlashes(pg_result($resaco,$conresaco,'si189_tiporegistro'))."','$this->si189_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si189_codreduzidorsp"]) || $this->si189_codreduzidorsp != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2012010,'".AddSlashes(pg_result($resaco,$conresaco,'si189_codreduzidorsp'))."','$this->si189_codreduzidorsp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si189_codorgao"]) || $this->si189_codorgao != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2012011,'".AddSlashes(pg_result($resaco,$conresaco,'si189_codorgao'))."','$this->si189_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si189_codunidadesub"]) || $this->si189_codunidadesub != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2012012,'".AddSlashes(pg_result($resaco,$conresaco,'si189_codunidadesub'))."','$this->si189_codunidadesub',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si189_codunidadesuborig"]) || $this->si189_codunidadesuborig != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2012013,'".AddSlashes(pg_result($resaco,$conresaco,'si189_codunidadesuborig'))."','$this->si189_codunidadesuborig',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si189_nroempenho"]) || $this->si189_nroempenho != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2012014,'".AddSlashes(pg_result($resaco,$conresaco,'si189_nroempenho'))."','$this->si189_nroempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si189_exercicioempenho"]) || $this->si189_exercicioempenho != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2012015,'".AddSlashes(pg_result($resaco,$conresaco,'si189_exercicioempenho'))."','$this->si189_exercicioempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si189_dtempenho"]) || $this->si189_dtempenho != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2012016,'".AddSlashes(pg_result($resaco,$conresaco,'si189_dtempenho'))."','$this->si189_dtempenho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si189_tipopagamentorsp"]) || $this->si189_tipopagamentorsp != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2012017,'".AddSlashes(pg_result($resaco,$conresaco,'si189_tipopagamentorsp'))."','$this->si189_tipopagamentorsp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si189_vlpagorsp"]) || $this->si189_vlpagorsp != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2012021,'".AddSlashes(pg_result($resaco,$conresaco,'si189_vlpagorsp'))."','$this->si189_vlpagorsp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si189_mes"]) || $this->si189_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2012021,'".AddSlashes(pg_result($resaco,$conresaco,'si189_mes'))."','$this->si189_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["si189_instit"]) || $this->si189_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010202,2012021,'".AddSlashes(pg_result($resaco,$conresaco,'si189_instit'))."','$this->si189_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Restos a Pagar do Ensino, Saúde e Fundeb nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si189_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Restos a Pagar do Ensino, Saúde e Fundeb nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si189_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si189_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($si189_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
/*     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($si189_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2012021,'$si189_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010202,2012021,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2012008,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2012010,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_codreduzidorsp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2012011,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2012012,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_codunidadesub'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2012013,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_codunidadesuborig'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2012014,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_nroempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2012015,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_exercicioempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2012016,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_dtempenho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2012017,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_tipopagamentorsp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2012021,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_vlpagorsp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2012021,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010202,2012021,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from rpsd102021
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($si189_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " si189_sequencial = $si189_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Restos a Pagar do Ensino, Saúde e Fundeb nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si189_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Restos a Pagar do Ensino, Saúde e Fundeb nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si189_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si189_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:rpsd102021";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si189_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from rpsd102021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si189_sequencial!=null ) {
         $sql2 .= " where rpsd102021.si189_sequencial = $si189_sequencial ";
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
  function sql_query_file ( $si189_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from rpsd102021 ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($si189_sequencial!=null ) {
         $sql2 .= " where rpsd102021.si189_sequencial = $si189_sequencial ";
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
