<?php
//MODULO: pessoal
//CLASSE DA ENTIDADE cadferiaspremio
class cl_cadferiaspremio { 
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
  public $r95_sequencial = 0; 
  public $r95_anousu = 0; 
  public $r95_mesusu = 0; 
  public $r95_regist = 0; 
  public $r95_perai_dia = null; 
  public $r95_perai_mes = null; 
  public $r95_perai_ano = null; 
  public $r95_perai = null; 
  public $r95_peraf_dia = null; 
  public $r95_peraf_mes = null; 
  public $r95_peraf_ano = null; 
  public $r95_peraf = null; 
  public $r95_ndias = 0; 
  public $r95_per1i_dia = null; 
  public $r95_per1i_mes = null; 
  public $r95_per1i_ano = null; 
  public $r95_per1i = null; 
  public $r95_per1f_dia = null; 
  public $r95_per1f_mes = null; 
  public $r95_per1f_ano = null; 
  public $r95_per1f = null; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 r95_sequencial = int8 = Código Sequencial 
                 r95_anousu = int8 = Ano do Exércicio 
                 r95_mesusu = int8 = Mês do Exercício 
                 r95_regist = int8 = Matrícula do Funcionário 
                 r95_perai = date = Período Aquisitivo 
                 r95_peraf = date = Final Período 
                 r95_ndias = int8 = Total de Dias a Gozar 
                 r95_per1i = date = Início Gozo 
                 r95_per1f = date = Final Gozo 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("cadferiaspremio"); 
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
       $this->r95_sequencial = ($this->r95_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_sequencial"]:$this->r95_sequencial);
       $this->r95_anousu = ($this->r95_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_anousu"]:$this->r95_anousu);
       $this->r95_mesusu = ($this->r95_mesusu == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_mesusu"]:$this->r95_mesusu);
       $this->r95_regist = ($this->r95_regist == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_regist"]:$this->r95_regist);
       if ($this->r95_perai == "") {
         $this->r95_perai_dia = ($this->r95_perai_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_perai_dia"]:$this->r95_perai_dia);
         $this->r95_perai_mes = ($this->r95_perai_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_perai_mes"]:$this->r95_perai_mes);
         $this->r95_perai_ano = ($this->r95_perai_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_perai_ano"]:$this->r95_perai_ano);
         if ($this->r95_perai_dia != "") {
            $this->r95_perai = $this->r95_perai_ano."-".$this->r95_perai_mes."-".$this->r95_perai_dia;
         }
       }
       if ($this->r95_peraf == "") {
         $this->r95_peraf_dia = ($this->r95_peraf_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_peraf_dia"]:$this->r95_peraf_dia);
         $this->r95_peraf_mes = ($this->r95_peraf_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_peraf_mes"]:$this->r95_peraf_mes);
         $this->r95_peraf_ano = ($this->r95_peraf_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_peraf_ano"]:$this->r95_peraf_ano);
         if ($this->r95_peraf_dia != "") {
            $this->r95_peraf = $this->r95_peraf_ano."-".$this->r95_peraf_mes."-".$this->r95_peraf_dia;
         }
       }
       $this->r95_ndias = ($this->r95_ndias == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_ndias"]:$this->r95_ndias);
       if ($this->r95_per1i == "") {
         $this->r95_per1i_dia = ($this->r95_per1i_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_per1i_dia"]:$this->r95_per1i_dia);
         $this->r95_per1i_mes = ($this->r95_per1i_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_per1i_mes"]:$this->r95_per1i_mes);
         $this->r95_per1i_ano = ($this->r95_per1i_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_per1i_ano"]:$this->r95_per1i_ano);
         if ($this->r95_per1i_dia != "") {
            $this->r95_per1i = $this->r95_per1i_ano."-".$this->r95_per1i_mes."-".$this->r95_per1i_dia;
         }
       }
       if ($this->r95_per1f == "") {
         $this->r95_per1f_dia = ($this->r95_per1f_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_per1f_dia"]:$this->r95_per1f_dia);
         $this->r95_per1f_mes = ($this->r95_per1f_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_per1f_mes"]:$this->r95_per1f_mes);
         $this->r95_per1f_ano = ($this->r95_per1f_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_per1f_ano"]:$this->r95_per1f_ano);
         if ($this->r95_per1f_dia != "") {
            $this->r95_per1f = $this->r95_per1f_ano."-".$this->r95_per1f_mes."-".$this->r95_per1f_dia;
         }
       }
     } else {
       $this->r95_sequencial = ($this->r95_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["r95_sequencial"]:$this->r95_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($r95_sequencial) { 
      $this->atualizacampos();
     if ($this->r95_anousu == null ) { 
       $this->erro_sql = " Campo Ano do Exércicio não informado.";
       $this->erro_campo = "r95_anousu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->r95_mesusu == null ) { 
       $this->erro_sql = " Campo Mês do Exercício não informado.";
       $this->erro_campo = "r95_mesusu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->r95_regist == null ) { 
       $this->erro_sql = " Campo Matrícula do Funcionário não informado.";
       $this->erro_campo = "r95_regist";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->r95_perai == null ) { 
       $this->erro_sql = " Campo Período Aquisitivo não informado.";
       $this->erro_campo = "r95_perai_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->r95_peraf == null ) { 
       $this->erro_sql = " Campo Final Período não informado.";
       $this->erro_campo = "r95_peraf_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->r95_ndias == null ) { 
       $this->erro_sql = " Campo Total de Dias a Gozar não informado.";
       $this->erro_campo = "r95_ndias";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->r95_per1i == null ) { 
       $this->erro_sql = " Campo Início Gozo não informado.";
       $this->erro_campo = "r95_per1i_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->r95_per1f == null ) { 
       $this->erro_sql = " Campo Final Gozo não informado.";
       $this->erro_campo = "r95_per1f_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($r95_sequencial == "" || $r95_sequencial == null ) {
       $result = db_query("select nextval('cadferiaspremio_r95_sequencial_seq')"); 
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: cadferiaspremio_r95_sequencial_seq do campo: r95_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->r95_sequencial = pg_result($result,0,0); 
     } else {
       $result = db_query("select last_value from cadferiaspremio_r95_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $r95_sequencial)) {
         $this->erro_sql = " Campo r95_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->r95_sequencial = $r95_sequencial; 
       }
     }
     if (($this->r95_sequencial == null) || ($this->r95_sequencial == "") ) { 
       $this->erro_sql = " Campo r95_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into cadferiaspremio(
                                       r95_sequencial 
                                      ,r95_anousu 
                                      ,r95_mesusu 
                                      ,r95_regist 
                                      ,r95_perai 
                                      ,r95_peraf 
                                      ,r95_ndias 
                                      ,r95_per1i 
                                      ,r95_per1f 
                       )
                values (
                                $this->r95_sequencial 
                               ,$this->r95_anousu 
                               ,$this->r95_mesusu 
                               ,$this->r95_regist 
                               ,".($this->r95_perai == "null" || $this->r95_perai == ""?"null":"'".$this->r95_perai."'")." 
                               ,".($this->r95_peraf == "null" || $this->r95_peraf == ""?"null":"'".$this->r95_peraf."'")." 
                               ,$this->r95_ndias 
                               ,".($this->r95_per1i == "null" || $this->r95_per1i == ""?"null":"'".$this->r95_per1i."'")." 
                               ,".($this->r95_per1f == "null" || $this->r95_per1f == ""?"null":"'".$this->r95_per1f."'")." 
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Cadastro de Férias Prêmio ($this->r95_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Cadastro de Férias Prêmio já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Cadastro de Férias Prêmio ($this->r95_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->r95_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->r95_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009259,'$this->r95_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010194,1009259,'','".AddSlashes(pg_result($resaco,0,'r95_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010194,1009260,'','".AddSlashes(pg_result($resaco,0,'r95_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010194,1009261,'','".AddSlashes(pg_result($resaco,0,'r95_mesusu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010194,1009262,'','".AddSlashes(pg_result($resaco,0,'r95_regist'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010194,1009263,'','".AddSlashes(pg_result($resaco,0,'r95_perai'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010194,1009264,'','".AddSlashes(pg_result($resaco,0,'r95_peraf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010194,1009265,'','".AddSlashes(pg_result($resaco,0,'r95_ndias'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010194,1009266,'','".AddSlashes(pg_result($resaco,0,'r95_per1i'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010194,1009267,'','".AddSlashes(pg_result($resaco,0,'r95_per1f'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($r95_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update cadferiaspremio set ";
     $virgula = "";
     if (trim($this->r95_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["r95_sequencial"])) { 
       $sql  .= $virgula." r95_sequencial = $this->r95_sequencial ";
       $virgula = ",";
       if (trim($this->r95_sequencial) == null ) { 
         $this->erro_sql = " Campo Código Sequencial não informado.";
         $this->erro_campo = "r95_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->r95_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["r95_anousu"])) { 
       $sql  .= $virgula." r95_anousu = $this->r95_anousu ";
       $virgula = ",";
       if (trim($this->r95_anousu) == null ) { 
         $this->erro_sql = " Campo Ano do Exércicio não informado.";
         $this->erro_campo = "r95_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->r95_mesusu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["r95_mesusu"])) { 
       $sql  .= $virgula." r95_mesusu = $this->r95_mesusu ";
       $virgula = ",";
       if (trim($this->r95_mesusu) == null ) { 
         $this->erro_sql = " Campo Mês do Exercício não informado.";
         $this->erro_campo = "r95_mesusu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->r95_regist)!="" || isset($GLOBALS["HTTP_POST_VARS"]["r95_regist"])) { 
       $sql  .= $virgula." r95_regist = $this->r95_regist ";
       $virgula = ",";
       if (trim($this->r95_regist) == null ) { 
         $this->erro_sql = " Campo Matrícula do Funcionário não informado.";
         $this->erro_campo = "r95_regist";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->r95_perai)!="" || isset($GLOBALS["HTTP_POST_VARS"]["r95_perai_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["r95_perai_dia"] !="") ) { 
       $sql  .= $virgula." r95_perai = '$this->r95_perai' ";
       $virgula = ",";
       if (trim($this->r95_perai) == null ) { 
         $this->erro_sql = " Campo Período Aquisitivo não informado.";
         $this->erro_campo = "r95_perai_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["r95_perai_dia"])) { 
         $sql  .= $virgula." r95_perai = null ";
         $virgula = ",";
         if (trim($this->r95_perai) == null ) { 
           $this->erro_sql = " Campo Período Aquisitivo não informado.";
           $this->erro_campo = "r95_perai_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->r95_peraf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["r95_peraf_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["r95_peraf_dia"] !="") ) { 
       $sql  .= $virgula." r95_peraf = '$this->r95_peraf' ";
       $virgula = ",";
       if (trim($this->r95_peraf) == null ) { 
         $this->erro_sql = " Campo Final Período não informado.";
         $this->erro_campo = "r95_peraf_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["r95_peraf_dia"])) { 
         $sql  .= $virgula." r95_peraf = null ";
         $virgula = ",";
         if (trim($this->r95_peraf) == null ) { 
           $this->erro_sql = " Campo Final Período não informado.";
           $this->erro_campo = "r95_peraf_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->r95_ndias)!="" || isset($GLOBALS["HTTP_POST_VARS"]["r95_ndias"])) { 
       $sql  .= $virgula." r95_ndias = $this->r95_ndias ";
       $virgula = ",";
       if (trim($this->r95_ndias) == null ) { 
         $this->erro_sql = " Campo Total de Dias a Gozar não informado.";
         $this->erro_campo = "r95_ndias";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->r95_per1i)!="" || isset($GLOBALS["HTTP_POST_VARS"]["r95_per1i_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["r95_per1i_dia"] !="") ) { 
       $sql  .= $virgula." r95_per1i = '$this->r95_per1i' ";
       $virgula = ",";
       if (trim($this->r95_per1i) == null ) { 
         $this->erro_sql = " Campo Início Gozo não informado.";
         $this->erro_campo = "r95_per1i_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["r95_per1i_dia"])) { 
         $sql  .= $virgula." r95_per1i = null ";
         $virgula = ",";
         if (trim($this->r95_per1i) == null ) { 
           $this->erro_sql = " Campo Início Gozo não informado.";
           $this->erro_campo = "r95_per1i_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->r95_per1f)!="" || isset($GLOBALS["HTTP_POST_VARS"]["r95_per1f_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["r95_per1f_dia"] !="") ) { 
       $sql  .= $virgula." r95_per1f = '$this->r95_per1f' ";
       $virgula = ",";
       if (trim($this->r95_per1f) == null ) { 
         $this->erro_sql = " Campo Final Gozo não informado.";
         $this->erro_campo = "r95_per1f_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["r95_per1f_dia"])) { 
         $sql  .= $virgula." r95_per1f = null ";
         $virgula = ",";
         if (trim($this->r95_per1f) == null ) { 
           $this->erro_sql = " Campo Final Gozo não informado.";
           $this->erro_campo = "r95_per1f_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     $sql .= " where ";
     if ($r95_sequencial!=null) {
       $sql .= " r95_sequencial = $this->r95_sequencial";
     }
     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->r95_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009259,'$this->r95_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["r95_sequencial"]) || $this->r95_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010194,1009259,'".AddSlashes(pg_result($resaco,$conresaco,'r95_sequencial'))."','$this->r95_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["r95_anousu"]) || $this->r95_anousu != "")
             $resac = db_query("insert into db_acount values($acount,1010194,1009260,'".AddSlashes(pg_result($resaco,$conresaco,'r95_anousu'))."','$this->r95_anousu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["r95_mesusu"]) || $this->r95_mesusu != "")
             $resac = db_query("insert into db_acount values($acount,1010194,1009261,'".AddSlashes(pg_result($resaco,$conresaco,'r95_mesusu'))."','$this->r95_mesusu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["r95_regist"]) || $this->r95_regist != "")
             $resac = db_query("insert into db_acount values($acount,1010194,1009262,'".AddSlashes(pg_result($resaco,$conresaco,'r95_regist'))."','$this->r95_regist',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["r95_perai"]) || $this->r95_perai != "")
             $resac = db_query("insert into db_acount values($acount,1010194,1009263,'".AddSlashes(pg_result($resaco,$conresaco,'r95_perai'))."','$this->r95_perai',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["r95_peraf"]) || $this->r95_peraf != "")
             $resac = db_query("insert into db_acount values($acount,1010194,1009264,'".AddSlashes(pg_result($resaco,$conresaco,'r95_peraf'))."','$this->r95_peraf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["r95_ndias"]) || $this->r95_ndias != "")
             $resac = db_query("insert into db_acount values($acount,1010194,1009265,'".AddSlashes(pg_result($resaco,$conresaco,'r95_ndias'))."','$this->r95_ndias',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["r95_per1i"]) || $this->r95_per1i != "")
             $resac = db_query("insert into db_acount values($acount,1010194,1009266,'".AddSlashes(pg_result($resaco,$conresaco,'r95_per1i'))."','$this->r95_per1i',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["r95_per1f"]) || $this->r95_per1f != "")
             $resac = db_query("insert into db_acount values($acount,1010194,1009267,'".AddSlashes(pg_result($resaco,$conresaco,'r95_per1f'))."','$this->r95_per1f',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro de Férias Prêmio nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->r95_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro de Férias Prêmio nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->r95_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->r95_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir ($r95_sequencial=null,$dbwhere=null) { 

     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($r95_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009259,'$r95_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010194,1009259,'','".AddSlashes(pg_result($resaco,$iresaco,'r95_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,1009260,'','".AddSlashes(pg_result($resaco,$iresaco,'r95_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,1009261,'','".AddSlashes(pg_result($resaco,$iresaco,'r95_mesusu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,1009262,'','".AddSlashes(pg_result($resaco,$iresaco,'r95_regist'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,1009263,'','".AddSlashes(pg_result($resaco,$iresaco,'r95_perai'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,1009264,'','".AddSlashes(pg_result($resaco,$iresaco,'r95_peraf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,1009265,'','".AddSlashes(pg_result($resaco,$iresaco,'r95_ndias'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,1009266,'','".AddSlashes(pg_result($resaco,$iresaco,'r95_per1i'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010194,1009267,'','".AddSlashes(pg_result($resaco,$iresaco,'r95_per1f'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from cadferiaspremio
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($r95_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " r95_sequencial = $r95_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cadastro de Férias Prêmio nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$r95_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Cadastro de Férias Prêmio nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$r95_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$r95_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:cadferiaspremio";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $r95_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from cadferiaspremio ";
     $sql .= "      inner join rhpessoal  on  rhpessoal.rh01_regist = cadferiaspremio.r95_regist";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = rhpessoal.rh01_numcgm";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($r95_sequencial!=null ) {
         $sql2 .= " where cadferiaspremio.r95_sequencial = $r95_sequencial "; 
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
  function sql_query_file ( $r95_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from cadferiaspremio ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($r95_sequencial!=null ) {
         $sql2 .= " where cadferiaspremio.r95_sequencial = $r95_sequencial "; 
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

  function sql_query_matricula_cgm($regist, $campos = "*") {
    $sql  = "select ";
    $sql .= "$campos ";
    $sql .= " from rhpessoal ";
    $sql .= "      inner join cgm  on  cgm.z01_numcgm = rhpessoal.rh01_numcgm";
    $sql .= " where rhpessoal.rh01_regist = $regist";
    return $sql;
  }

  function setPeriodoAquisitivo($data) {

    $oPeriodoAquisitivo = new DateTime($data);

    $this->r95_perai = $oPeriodoAquisitivo->format('Y')."-".$oPeriodoAquisitivo->format('m')."-".$oPeriodoAquisitivo->format('d');
    $this->r95_perai_dia = $oPeriodoAquisitivo->format('d');
    $this->r95_perai_mes = $oPeriodoAquisitivo->format('m'); 
    $this->r95_perai_ano = $oPeriodoAquisitivo->format('Y');

    $oPeriodoAquisitivo->add(new DateInterval("P5Y"));
    $this->r95_peraf = $oPeriodoAquisitivo->format('Y')."-".$oPeriodoAquisitivo->format('m')."-".$oPeriodoAquisitivo->format('d');
    $this->r95_peraf_dia = $oPeriodoAquisitivo->format('d');
    $this->r95_peraf_mes = $oPeriodoAquisitivo->format('m');
    $this->r95_peraf_ano = $oPeriodoAquisitivo->format('Y');
  }
}
?>
