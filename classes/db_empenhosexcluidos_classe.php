<?php
//MODULO: empenho
//CLASSE DA ENTIDADE empenhosexcluidos
class cl_empenhosexcluidos {
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
  public $e290_sequencial = 0;
  public $e290_e60_numemp = 0;
  public $e290_e60_codemp = null;
  public $e290_e60_anousu = 0;
  public $e290_e60_vlremp = 0;
  public $e290_e60_emiss_dia = null;
  public $e290_e60_emiss_mes = null;
  public $e290_e60_emiss_ano = null;
  public $e290_e60_emiss = null;
  public $e290_z01_numcgm = 0;
  public $e290_z01_nome = null;
  public $e290_id_usuario = 0;
  public $e290_nomeusuario = null;
  public $e290_dtexclusao_dia = null;
  public $e290_dtexclusao_mes = null;
  public $e290_dtexclusao_ano = null;
  public $e290_dtexclusao = null;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 e290_sequencial = int4 = e290_sequencial
                 e290_e60_numemp = int4 = Seq. Empenho
                 e290_e60_codemp = varchar(15) = Código do Empenho
                 e290_e60_anousu = int4 = Exercício
                 e290_e60_vlremp = float8 = Empenho
                 e290_e60_emiss = date = Data Emissão
                 e290_z01_numcgm = int4 = Numcgm
                 e290_z01_nome = varchar(40) = Nome/Razão social
                 e290_id_usuario = int4 = Código do usuario
                 e290_nomeusuario = varchar(40) = Nome do usuário
                 e290_dtexclusao = date = Data Exclusão
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("empenhosexcluidos");
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
       $this->e290_sequencial = ($this->e290_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_sequencial"]:$this->e290_sequencial);
       $this->e290_e60_numemp = ($this->e290_e60_numemp == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_e60_numemp"]:$this->e290_e60_numemp);
       $this->e290_e60_codemp = ($this->e290_e60_codemp == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_e60_codemp"]:$this->e290_e60_codemp);
       $this->e290_e60_anousu = ($this->e290_e60_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_e60_anousu"]:$this->e290_e60_anousu);
       $this->e290_e60_vlremp = ($this->e290_e60_vlremp == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_e60_vlremp"]:$this->e290_e60_vlremp);
       if ($this->e290_e60_emiss == "") {
         $this->e290_e60_emiss_dia = ($this->e290_e60_emiss_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_e60_emiss_dia"]:$this->e290_e60_emiss_dia);
         $this->e290_e60_emiss_mes = ($this->e290_e60_emiss_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_e60_emiss_mes"]:$this->e290_e60_emiss_mes);
         $this->e290_e60_emiss_ano = ($this->e290_e60_emiss_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_e60_emiss_ano"]:$this->e290_e60_emiss_ano);
         if ($this->e290_e60_emiss_dia != "") {
            $this->e290_e60_emiss = $this->e290_e60_emiss_ano."-".$this->e290_e60_emiss_mes."-".$this->e290_e60_emiss_dia;
         }
       }
       $this->e290_z01_numcgm = ($this->e290_z01_numcgm == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_z01_numcgm"]:$this->e290_z01_numcgm);
       $this->e290_z01_nome = ($this->e290_z01_nome == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_z01_nome"]:$this->e290_z01_nome);
       $this->e290_id_usuario = ($this->e290_id_usuario == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_id_usuario"]:$this->e290_id_usuario);
       $this->e290_nomeusuario = ($this->e290_nomeusuario == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_nomeusuario"]:$this->e290_nomeusuario);
       if ($this->e290_dtexclusao == "") {
         $this->e290_dtexclusao_dia = ($this->e290_dtexclusao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_dtexclusao_dia"]:$this->e290_dtexclusao_dia);
         $this->e290_dtexclusao_mes = ($this->e290_dtexclusao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_dtexclusao_mes"]:$this->e290_dtexclusao_mes);
         $this->e290_dtexclusao_ano = ($this->e290_dtexclusao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_dtexclusao_ano"]:$this->e290_dtexclusao_ano);
         if ($this->e290_dtexclusao_dia != "") {
            $this->e290_dtexclusao = $this->e290_dtexclusao_ano."-".$this->e290_dtexclusao_mes."-".$this->e290_dtexclusao_dia;
         }
       }
     } else {
       $this->e290_sequencial = ($this->e290_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["e290_sequencial"]:$this->e290_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($e290_sequencial) {
      $this->atualizacampos();
     if ($this->e290_e60_numemp == null ) {
       $this->erro_sql = " Campo Seq. Empenho não informado.";
       $this->erro_campo = "e290_e60_numemp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->e290_e60_codemp == null ) {
       $this->erro_sql = " Campo Código do Empenho não informado.";
       $this->erro_campo = "e290_e60_codemp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->e290_e60_anousu == null ) {
       $this->erro_sql = " Campo Exercício não informado.";
       $this->erro_campo = "e290_e60_anousu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->e290_e60_vlremp == null ) {
       $this->erro_sql = " Campo Empenho não informado.";
       $this->erro_campo = "e290_e60_vlremp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->e290_e60_emiss == null ) {
       $this->erro_sql = " Campo Data Emissão não informado.";
       $this->erro_campo = "e290_e60_emiss_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->e290_z01_numcgm == null ) {
       $this->erro_sql = " Campo Numcgm não informado.";
       $this->erro_campo = "e290_z01_numcgm";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->e290_z01_nome == null ) {
       $this->erro_sql = " Campo Nome/Razão social não informado.";
       $this->erro_campo = "e290_z01_nome";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->e290_id_usuario == null ) {
       $this->erro_sql = " Campo Código do usuario não informado.";
       $this->erro_campo = "e290_id_usuario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->e290_nomeusuario == null ) {
       $this->erro_sql = " Campo Nome do usuário não informado.";
       $this->erro_campo = "e290_nomeusuario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->e290_dtexclusao == null ) {
       $this->erro_sql = " Campo Data Exclusão não informado.";
       $this->erro_campo = "e290_dtexclusao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($e290_sequencial == "" || $e290_sequencial == null ) {
       $result = db_query("select nextval('empenhosexcluidos_e290_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: empenhosexcluidos_e290_sequencial_seq do campo: e290_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->e290_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from empenhosexcluidos_e290_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $e290_sequencial)) {
         $this->erro_sql = " Campo e290_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->e290_sequencial = $e290_sequencial;
       }
     }
     if (($this->e290_sequencial == null) || ($this->e290_sequencial == "") ) {
       $this->erro_sql = " Campo e290_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into empenhosexcluidos(
                                       e290_sequencial
                                      ,e290_e60_numemp
                                      ,e290_e60_codemp
                                      ,e290_e60_anousu
                                      ,e290_e60_vlremp
                                      ,e290_e60_emiss
                                      ,e290_z01_numcgm
                                      ,e290_z01_nome
                                      ,e290_id_usuario
                                      ,e290_nomeusuario
                                      ,e290_dtexclusao
                       )
                values (
                                $this->e290_sequencial
                               ,$this->e290_e60_numemp
                               ,'$this->e290_e60_codemp'
                               ,$this->e290_e60_anousu
                               ,$this->e290_e60_vlremp
                               ,".($this->e290_e60_emiss == "null" || $this->e290_e60_emiss == ""?"null":"'".$this->e290_e60_emiss."'")."
                               ,$this->e290_z01_numcgm
                               ,'$this->e290_z01_nome'
                               ,$this->e290_id_usuario
                               ,'$this->e290_nomeusuario'
                               ,".($this->e290_dtexclusao == "null" || $this->e290_dtexclusao == ""?"null":"'".$this->e290_dtexclusao."'")."
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "empenhosexcluidos ($this->e290_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "empenhosexcluidos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "empenhosexcluidos ($this->e290_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->e290_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->e290_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009274,'$this->e290_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010197,1009274,'','".AddSlashes(pg_result($resaco,0,'e290_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009275,'','".AddSlashes(pg_result($resaco,0,'e290_e60_numemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009276,'','".AddSlashes(pg_result($resaco,0,'e290_e60_codemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009277,'','".AddSlashes(pg_result($resaco,0,'e290_e60_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009279,'','".AddSlashes(pg_result($resaco,0,'e290_e60_vlremp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009278,'','".AddSlashes(pg_result($resaco,0,'e290_e60_emiss'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009280,'','".AddSlashes(pg_result($resaco,0,'e290_z01_numcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009281,'','".AddSlashes(pg_result($resaco,0,'e290_z01_nome'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009282,'','".AddSlashes(pg_result($resaco,0,'e290_id_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009283,'','".AddSlashes(pg_result($resaco,0,'e290_nomeusuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010197,1009284,'','".AddSlashes(pg_result($resaco,0,'e290_dtexclusao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }
    return true;
  }

  // funcao para alteracao
  function alterar ($e290_sequencial=null) {
      $this->atualizacampos();
     $sql = " update empenhosexcluidos set ";
     $virgula = "";
     if (trim($this->e290_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e290_sequencial"])) {
       $sql  .= $virgula." e290_sequencial = $this->e290_sequencial ";
       $virgula = ",";
       if (trim($this->e290_sequencial) == null ) {
         $this->erro_sql = " Campo e290_sequencial não informado.";
         $this->erro_campo = "e290_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->e290_e60_numemp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e290_e60_numemp"])) {
       $sql  .= $virgula." e290_e60_numemp = $this->e290_e60_numemp ";
       $virgula = ",";
       if (trim($this->e290_e60_numemp) == null ) {
         $this->erro_sql = " Campo Seq. Empenho não informado.";
         $this->erro_campo = "e290_e60_numemp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->e290_e60_codemp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e290_e60_codemp"])) {
       $sql  .= $virgula." e290_e60_codemp = '$this->e290_e60_codemp' ";
       $virgula = ",";
       if (trim($this->e290_e60_codemp) == null ) {
         $this->erro_sql = " Campo Código do Empenho não informado.";
         $this->erro_campo = "e290_e60_codemp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->e290_e60_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e290_e60_anousu"])) {
       $sql  .= $virgula." e290_e60_anousu = $this->e290_e60_anousu ";
       $virgula = ",";
       if (trim($this->e290_e60_anousu) == null ) {
         $this->erro_sql = " Campo Exercício não informado.";
         $this->erro_campo = "e290_e60_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->e290_e60_vlremp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e290_e60_vlremp"])) {
       $sql  .= $virgula." e290_e60_vlremp = $this->e290_e60_vlremp ";
       $virgula = ",";
       if (trim($this->e290_e60_vlremp) == null ) {
         $this->erro_sql = " Campo Empenho não informado.";
         $this->erro_campo = "e290_e60_vlremp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->e290_e60_emiss)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e290_e60_emiss_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["e290_e60_emiss_dia"] !="") ) {
       $sql  .= $virgula." e290_e60_emiss = '$this->e290_e60_emiss' ";
       $virgula = ",";
       if (trim($this->e290_e60_emiss) == null ) {
         $this->erro_sql = " Campo Data Emissão não informado.";
         $this->erro_campo = "e290_e60_emiss_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["e290_e60_emiss_dia"])) {
         $sql  .= $virgula." e290_e60_emiss = null ";
         $virgula = ",";
         if (trim($this->e290_e60_emiss) == null ) {
           $this->erro_sql = " Campo Data Emissão não informado.";
           $this->erro_campo = "e290_e60_emiss_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->e290_z01_numcgm)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e290_z01_numcgm"])) {
       $sql  .= $virgula." e290_z01_numcgm = $this->e290_z01_numcgm ";
       $virgula = ",";
       if (trim($this->e290_z01_numcgm) == null ) {
         $this->erro_sql = " Campo Numcgm não informado.";
         $this->erro_campo = "e290_z01_numcgm";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->e290_z01_nome)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e290_z01_nome"])) {
       $sql  .= $virgula." e290_z01_nome = '$this->e290_z01_nome' ";
       $virgula = ",";
       if (trim($this->e290_z01_nome) == null ) {
         $this->erro_sql = " Campo Nome/Razão social não informado.";
         $this->erro_campo = "e290_z01_nome";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->e290_id_usuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e290_id_usuario"])) {
       $sql  .= $virgula." e290_id_usuario = $this->e290_id_usuario ";
       $virgula = ",";
       if (trim($this->e290_id_usuario) == null ) {
         $this->erro_sql = " Campo Código do usuario não informado.";
         $this->erro_campo = "e290_id_usuario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->e290_nomeusuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e290_nomeusuario"])) {
       $sql  .= $virgula." e290_nomeusuario = '$this->e290_nomeusuario' ";
       $virgula = ",";
       if (trim($this->e290_nomeusuario) == null ) {
         $this->erro_sql = " Campo Nome do usuário não informado.";
         $this->erro_campo = "e290_nomeusuario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->e290_dtexclusao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["e290_dtexclusao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["e290_dtexclusao_dia"] !="") ) {
       $sql  .= $virgula." e290_dtexclusao = '$this->e290_dtexclusao' ";
       $virgula = ",";
       if (trim($this->e290_dtexclusao) == null ) {
         $this->erro_sql = " Campo Data Exclusão não informado.";
         $this->erro_campo = "e290_dtexclusao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["e290_dtexclusao_dia"])) {
         $sql  .= $virgula." e290_dtexclusao = null ";
         $virgula = ",";
         if (trim($this->e290_dtexclusao) == null ) {
           $this->erro_sql = " Campo Data Exclusão não informado.";
           $this->erro_campo = "e290_dtexclusao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     $sql .= " where ";
     if ($e290_sequencial!=null) {
       $sql .= " e290_sequencial = $this->e290_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->e290_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009274,'$this->e290_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["e290_sequencial"]) || $this->e290_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009274,'".AddSlashes(pg_result($resaco,$conresaco,'e290_sequencial'))."','$this->e290_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["e290_e60_numemp"]) || $this->e290_e60_numemp != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009275,'".AddSlashes(pg_result($resaco,$conresaco,'e290_e60_numemp'))."','$this->e290_e60_numemp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["e290_e60_codemp"]) || $this->e290_e60_codemp != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009276,'".AddSlashes(pg_result($resaco,$conresaco,'e290_e60_codemp'))."','$this->e290_e60_codemp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["e290_e60_anousu"]) || $this->e290_e60_anousu != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009277,'".AddSlashes(pg_result($resaco,$conresaco,'e290_e60_anousu'))."','$this->e290_e60_anousu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["e290_e60_vlremp"]) || $this->e290_e60_vlremp != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009279,'".AddSlashes(pg_result($resaco,$conresaco,'e290_e60_vlremp'))."','$this->e290_e60_vlremp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["e290_e60_emiss"]) || $this->e290_e60_emiss != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009278,'".AddSlashes(pg_result($resaco,$conresaco,'e290_e60_emiss'))."','$this->e290_e60_emiss',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["e290_z01_numcgm"]) || $this->e290_z01_numcgm != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009280,'".AddSlashes(pg_result($resaco,$conresaco,'e290_z01_numcgm'))."','$this->e290_z01_numcgm',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["e290_z01_nome"]) || $this->e290_z01_nome != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009281,'".AddSlashes(pg_result($resaco,$conresaco,'e290_z01_nome'))."','$this->e290_z01_nome',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["e290_id_usuario"]) || $this->e290_id_usuario != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009282,'".AddSlashes(pg_result($resaco,$conresaco,'e290_id_usuario'))."','$this->e290_id_usuario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["e290_nomeusuario"]) || $this->e290_nomeusuario != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009283,'".AddSlashes(pg_result($resaco,$conresaco,'e290_nomeusuario'))."','$this->e290_nomeusuario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["e290_dtexclusao"]) || $this->e290_dtexclusao != "")
             $resac = db_query("insert into db_acount values($acount,1010197,1009284,'".AddSlashes(pg_result($resaco,$conresaco,'e290_dtexclusao'))."','$this->e290_dtexclusao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "empenhosexcluidos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->e290_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "empenhosexcluidos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->e290_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->e290_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($e290_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($e290_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009274,'$e290_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009274,'','".AddSlashes(pg_result($resaco,$iresaco,'e290_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009275,'','".AddSlashes(pg_result($resaco,$iresaco,'e290_e60_numemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009276,'','".AddSlashes(pg_result($resaco,$iresaco,'e290_e60_codemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009277,'','".AddSlashes(pg_result($resaco,$iresaco,'e290_e60_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009279,'','".AddSlashes(pg_result($resaco,$iresaco,'e290_e60_vlremp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009278,'','".AddSlashes(pg_result($resaco,$iresaco,'e290_e60_emiss'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009280,'','".AddSlashes(pg_result($resaco,$iresaco,'e290_z01_numcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009281,'','".AddSlashes(pg_result($resaco,$iresaco,'e290_z01_nome'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009282,'','".AddSlashes(pg_result($resaco,$iresaco,'e290_id_usuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009283,'','".AddSlashes(pg_result($resaco,$iresaco,'e290_nomeusuario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010197,1009284,'','".AddSlashes(pg_result($resaco,$iresaco,'e290_dtexclusao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from empenhosexcluidos
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($e290_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " e290_sequencial = $e290_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "empenhosexcluidos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$e290_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "empenhosexcluidos nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$e290_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$e290_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:empenhosexcluidos";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $e290_sequencial=null,$campos="*",$dbwhere="",$ordem=null) {
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
     $sql .= " from empenhosexcluidos ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($e290_sequencial!=null ) {
         $sql2 .= " where empenhosexcluidos.e290_sequencial = $e290_sequencial ";
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
  function sql_query_file ( $e290_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from empenhosexcluidos ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($e290_sequencial!=null ) {
         $sql2 .= " where empenhosexcluidos.e290_sequencial = $e290_sequencial ";
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
