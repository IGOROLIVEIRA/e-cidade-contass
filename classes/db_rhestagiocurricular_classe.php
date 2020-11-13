<?php
//MODULO: recursoshumanos
//CLASSE DA ENTIDADE rhestagiocurricular
class cl_rhestagiocurricular { 
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
  public $h83_sequencial = 0; 
  public $h83_regist = 0; 
  public $h83_instensino = null; 
  public $h83_cnpjinstensino = null; 
  public $h83_curso = null; 
  public $h83_matricula = 0; 
  public $h83_dtinicio_dia = null; 
  public $h83_dtinicio_mes = null; 
  public $h83_dtinicio_ano = null; 
  public $h83_dtinicio = null; 
  public $h83_dtfim_dia = null; 
  public $h83_dtfim_mes = null; 
  public $h83_dtfim_ano = null; 
  public $h83_dtfim = null; 
  public $h83_cargahorariatotal = 0; 
  public $h83_supervisor = 0; 
  public $h83_instit = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 h83_sequencial = int8 = Código Sequencial 
                 h83_regist = int8 = Matrícula do Estagiário 
                 h83_instensino = varchar(200) = Instituição de Ensino 
                 h83_cnpjinstensino = varchar(14) = CNPJ Instituição de Ensino 
                 h83_curso = varchar(200) = Curso 
                 h83_matricula = int8 = Matrícula na Instituição de Ensino 
                 h83_dtinicio = date = Data de Início do Estágio 
                 h83_dtfim = date = Data Final do Estágio 
                 h83_cargahorariatotal = int8 = Carga Horária Total do Estagio 
                 h83_supervisor = int8 = Supervisor de Estágio 
                 h83_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("rhestagiocurricular"); 
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
       $this->h83_sequencial = ($this->h83_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_sequencial"]:$this->h83_sequencial);
       $this->h83_regist = ($this->h83_regist == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_regist"]:$this->h83_regist);
       $this->h83_instensino = ($this->h83_instensino == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_instensino"]:$this->h83_instensino);
       $this->h83_cnpjinstensino = ($this->h83_cnpjinstensino == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_cnpjinstensino"]:$this->h83_cnpjinstensino);
       $this->h83_curso = ($this->h83_curso == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_curso"]:$this->h83_curso);
       $this->h83_matricula = ($this->h83_matricula == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_matricula"]:$this->h83_matricula);
       if ($this->h83_dtinicio == "") {
         $this->h83_dtinicio_dia = ($this->h83_dtinicio_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_dtinicio_dia"]:$this->h83_dtinicio_dia);
         $this->h83_dtinicio_mes = ($this->h83_dtinicio_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_dtinicio_mes"]:$this->h83_dtinicio_mes);
         $this->h83_dtinicio_ano = ($this->h83_dtinicio_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_dtinicio_ano"]:$this->h83_dtinicio_ano);
         if ($this->h83_dtinicio_dia != "") {
            $this->h83_dtinicio = $this->h83_dtinicio_ano."-".$this->h83_dtinicio_mes."-".$this->h83_dtinicio_dia;
         }
       }
       if ($this->h83_dtfim == "") {
         $this->h83_dtfim_dia = ($this->h83_dtfim_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_dtfim_dia"]:$this->h83_dtfim_dia);
         $this->h83_dtfim_mes = ($this->h83_dtfim_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_dtfim_mes"]:$this->h83_dtfim_mes);
         $this->h83_dtfim_ano = ($this->h83_dtfim_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_dtfim_ano"]:$this->h83_dtfim_ano);
         if ($this->h83_dtfim_dia != "") {
            $this->h83_dtfim = $this->h83_dtfim_ano."-".$this->h83_dtfim_mes."-".$this->h83_dtfim_dia;
         }
       }
       $this->h83_cargahorariatotal = ($this->h83_cargahorariatotal == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_cargahorariatotal"]:$this->h83_cargahorariatotal);
       $this->h83_supervisor = ($this->h83_supervisor == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_supervisor"]:$this->h83_supervisor);
       $this->h83_instit = ($this->h83_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_instit"]:$this->h83_instit);
     } else {
       $this->h83_sequencial = ($this->h83_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["h83_sequencial"]:$this->h83_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($h83_sequencial) { 
      $this->atualizacampos();
     if ($this->h83_regist == null ) { 
       $this->erro_sql = " Campo Matrícula do Estagiário não informado.";
       $this->erro_campo = "h83_regist";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->h83_instensino == null ) { 
       $this->erro_sql = " Campo Instituição de Ensino não informado.";
       $this->erro_campo = "h83_instensino";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->h83_cnpjinstensino == null ) { 
       $this->erro_sql = " Campo CNPJ Instituição de Ensino não informado.";
       $this->erro_campo = "h83_cnpjinstensino";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->h83_curso == null ) { 
       $this->erro_sql = " Campo Curso não informado.";
       $this->erro_campo = "h83_curso";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->h83_matricula == null ) { 
       $this->erro_sql = " Campo Matrícula na Instituição de Ensino não informado.";
       $this->erro_campo = "h83_matricula";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->h83_dtinicio == null ) { 
       $this->erro_sql = " Campo Data de Início do Estágio não informado.";
       $this->erro_campo = "h83_dtinicio_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->h83_dtfim == null ) { 
       $this->erro_sql = " Campo Data Final do Estágio não informado.";
       $this->erro_campo = "h83_dtfim_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->h83_cargahorariatotal == null ) { 
       $this->erro_sql = " Campo Carga Horária Total do Estagio não informado.";
       $this->erro_campo = "h83_cargahorariatotal";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->h83_supervisor == null ) { 
       $this->erro_sql = " Campo Supervisor de Estágio não informado.";
       $this->erro_campo = "h83_supervisor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->h83_instit == null ) { 
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "h83_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($h83_sequencial == "" || $h83_sequencial == null ) {
       $result = db_query("select nextval('rhestagiocurricular_h83_sequencial_seq')"); 
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: rhestagiocurricular_h83_sequencial_seq do campo: h83_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->h83_sequencial = pg_result($result,0,0); 
     } else {
       $result = db_query("select last_value from rhestagiocurricular_h83_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $h83_sequencial)) {
         $this->erro_sql = " Campo h83_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->h83_sequencial = $h83_sequencial; 
       }
     }
     if (($this->h83_sequencial == null) || ($this->h83_sequencial == "") ) { 
       $this->erro_sql = " Campo h83_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into rhestagiocurricular(
                                       h83_sequencial 
                                      ,h83_regist 
                                      ,h83_instensino 
                                      ,h83_cnpjinstensino 
                                      ,h83_curso 
                                      ,h83_matricula 
                                      ,h83_dtinicio 
                                      ,h83_dtfim 
                                      ,h83_cargahorariatotal 
                                      ,h83_supervisor 
                                      ,h83_instit 
                       )
                values (
                                $this->h83_sequencial 
                               ,$this->h83_regist 
                               ,'$this->h83_instensino' 
                               ,'$this->h83_cnpjinstensino' 
                               ,'$this->h83_curso' 
                               ,$this->h83_matricula 
                               ,".($this->h83_dtinicio == "null" || $this->h83_dtinicio == ""?"null":"'".$this->h83_dtinicio."'")." 
                               ,".($this->h83_dtfim == "null" || $this->h83_dtfim == ""?"null":"'".$this->h83_dtfim."'")." 
                               ,$this->h83_cargahorariatotal 
                               ,$this->h83_supervisor 
                               ,$this->h83_instit 
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Estagios Curriculares ($this->h83_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Estagios Curriculares já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Estagios Curriculares ($this->h83_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->h83_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->h83_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009250,'$this->h83_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010193,1009250,'','".AddSlashes(pg_result($resaco,0,'h83_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009251,'','".AddSlashes(pg_result($resaco,0,'h83_regist'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009252,'','".AddSlashes(pg_result($resaco,0,'h83_cnpjinstensino'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009253,'','".AddSlashes(pg_result($resaco,0,'h83_curso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009254,'','".AddSlashes(pg_result($resaco,0,'h83_matricula'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009255,'','".AddSlashes(pg_result($resaco,0,'h83_dtinicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009256,'','".AddSlashes(pg_result($resaco,0,'h83_dtfim'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009257,'','".AddSlashes(pg_result($resaco,0,'h83_cargahorariatotal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,0,'h83_supervisor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($h83_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update rhestagiocurricular set ";
     $virgula = "";
     if (trim($this->h83_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["h83_sequencial"])) { 
       $sql  .= $virgula." h83_sequencial = $this->h83_sequencial ";
       $virgula = ",";
       if (trim($this->h83_sequencial) == null ) { 
         $this->erro_sql = " Campo Código Sequencial não informado.";
         $this->erro_campo = "h83_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->h83_regist)!="" || isset($GLOBALS["HTTP_POST_VARS"]["h83_regist"])) { 
       $sql  .= $virgula." h83_regist = $this->h83_regist ";
       $virgula = ",";
       if (trim($this->h83_regist) == null ) { 
         $this->erro_sql = " Campo Matrícula do Estagiário não informado.";
         $this->erro_campo = "h83_regist";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->h83_instensino)!="" || isset($GLOBALS["HTTP_POST_VARS"]["h83_instensino"])) { 
       $sql  .= $virgula." h83_instensino = '$this->h83_instensino' ";
       $virgula = ",";
       if (trim($this->h83_instensino) == null ) { 
         $this->erro_sql = " Campo Instituição de Ensino não informado.";
         $this->erro_campo = "h83_instensino";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->h83_cnpjinstensino)!="" || isset($GLOBALS["HTTP_POST_VARS"]["h83_cnpjinstensino"])) { 
       $sql  .= $virgula." h83_cnpjinstensino = '$this->h83_cnpjinstensino' ";
       $virgula = ",";
       if (trim($this->h83_cnpjinstensino) == null ) { 
         $this->erro_sql = " Campo CNPJ Instituição de Ensino não informado.";
         $this->erro_campo = "h83_cnpjinstensino";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->h83_curso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["h83_curso"])) { 
       $sql  .= $virgula." h83_curso = '$this->h83_curso' ";
       $virgula = ",";
       if (trim($this->h83_curso) == null ) { 
         $this->erro_sql = " Campo Curso não informado.";
         $this->erro_campo = "h83_curso";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->h83_matricula)!="" || isset($GLOBALS["HTTP_POST_VARS"]["h83_matricula"])) { 
       $sql  .= $virgula." h83_matricula = $this->h83_matricula ";
       $virgula = ",";
       if (trim($this->h83_matricula) == null ) { 
         $this->erro_sql = " Campo Matrícula na Instituição de Ensino não informado.";
         $this->erro_campo = "h83_matricula";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->h83_dtinicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["h83_dtinicio_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["h83_dtinicio_dia"] !="") ) { 
       $sql  .= $virgula." h83_dtinicio = '$this->h83_dtinicio' ";
       $virgula = ",";
       if (trim($this->h83_dtinicio) == null ) { 
         $this->erro_sql = " Campo Data de Início do Estágio não informado.";
         $this->erro_campo = "h83_dtinicio_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["h83_dtinicio_dia"])) { 
         $sql  .= $virgula." h83_dtinicio = null ";
         $virgula = ",";
         if (trim($this->h83_dtinicio) == null ) { 
           $this->erro_sql = " Campo Data de Início do Estágio não informado.";
           $this->erro_campo = "h83_dtinicio_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->h83_dtfim)!="" || isset($GLOBALS["HTTP_POST_VARS"]["h83_dtfim_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["h83_dtfim_dia"] !="") ) { 
       $sql  .= $virgula." h83_dtfim = '$this->h83_dtfim' ";
       $virgula = ",";
       if (trim($this->h83_dtfim) == null ) { 
         $this->erro_sql = " Campo Data Final do Estágio não informado.";
         $this->erro_campo = "h83_dtfim_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["h83_dtfim_dia"])) { 
         $sql  .= $virgula." h83_dtfim = null ";
         $virgula = ",";
         if (trim($this->h83_dtfim) == null ) { 
           $this->erro_sql = " Campo Data Final do Estágio não informado.";
           $this->erro_campo = "h83_dtfim_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->h83_cargahorariatotal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["h83_cargahorariatotal"])) { 
       $sql  .= $virgula." h83_cargahorariatotal = $this->h83_cargahorariatotal ";
       $virgula = ",";
       if (trim($this->h83_cargahorariatotal) == null ) { 
         $this->erro_sql = " Campo Carga Horária Total do Estagio não informado.";
         $this->erro_campo = "h83_cargahorariatotal";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->h83_supervisor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["h83_supervisor"])) { 
       $sql  .= $virgula." h83_supervisor = $this->h83_supervisor ";
       $virgula = ",";
       if (trim($this->h83_supervisor) == null ) { 
         $this->erro_sql = " Campo Supervisor de Estágio não informado.";
         $this->erro_campo = "h83_supervisor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->h83_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["h83_instit"])) { 
       $sql  .= $virgula." h83_instit = $this->h83_instit ";
       $virgula = ",";
       if (trim($this->h83_instit) == null ) { 
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "h83_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($h83_sequencial!=null) {
       $sql .= " h83_sequencial = $this->h83_sequencial";
     }
     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->h83_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009250,'$this->h83_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["h83_sequencial"]) || $this->h83_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009250,'".AddSlashes(pg_result($resaco,$conresaco,'h83_sequencial'))."','$this->h83_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["h83_regist"]) || $this->h83_regist != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009251,'".AddSlashes(pg_result($resaco,$conresaco,'h83_regist'))."','$this->h83_regist',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["h83_cnpjinstensino"]) || $this->h83_cnpjinstensino != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009252,'".AddSlashes(pg_result($resaco,$conresaco,'h83_cnpjinstensino'))."','$this->h83_cnpjinstensino',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["h83_curso"]) || $this->h83_curso != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009253,'".AddSlashes(pg_result($resaco,$conresaco,'h83_curso'))."','$this->h83_curso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["h83_matricula"]) || $this->h83_matricula != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009254,'".AddSlashes(pg_result($resaco,$conresaco,'h83_matricula'))."','$this->h83_matricula',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["h83_dtinicio"]) || $this->h83_dtinicio != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009255,'".AddSlashes(pg_result($resaco,$conresaco,'h83_dtinicio'))."','$this->h83_dtinicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["h83_dtfim"]) || $this->h83_dtfim != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009256,'".AddSlashes(pg_result($resaco,$conresaco,'h83_dtfim'))."','$this->h83_dtfim',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["h83_cargahorariatotal"]) || $this->h83_cargahorariatotal != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009257,'".AddSlashes(pg_result($resaco,$conresaco,'h83_cargahorariatotal'))."','$this->h83_cargahorariatotal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["h83_supervisor"]) || $this->h83_supervisor != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009258,'".AddSlashes(pg_result($resaco,$conresaco,'h83_supervisor'))."','$this->h83_supervisor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Estagios Curriculares nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->h83_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Estagios Curriculares nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->h83_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->h83_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir ($h83_sequencial=null,$dbwhere=null) { 

     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($h83_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009250,'$h83_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009250,'','".AddSlashes(pg_result($resaco,$iresaco,'h83_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009251,'','".AddSlashes(pg_result($resaco,$iresaco,'h83_regist'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009252,'','".AddSlashes(pg_result($resaco,$iresaco,'h83_cnpjinstensino'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009253,'','".AddSlashes(pg_result($resaco,$iresaco,'h83_curso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009254,'','".AddSlashes(pg_result($resaco,$iresaco,'h83_matricula'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009255,'','".AddSlashes(pg_result($resaco,$iresaco,'h83_dtinicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009256,'','".AddSlashes(pg_result($resaco,$iresaco,'h83_dtfim'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009257,'','".AddSlashes(pg_result($resaco,$iresaco,'h83_cargahorariatotal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,$iresaco,'h83_supervisor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from rhestagiocurricular
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($h83_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " h83_sequencial = $h83_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Estagios Curriculares nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$h83_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Estagios Curriculares nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$h83_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$h83_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:rhestagiocurricular";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $h83_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from rhestagiocurricular ";
     $sql .= "      inner join rhpessoal  on  rhpessoal.rh01_regist = rhestagiocurricular.h83_regist ";
     $sql .= "      inner join rhpessoal supervisor  on  supervisor.rh01_regist = rhestagiocurricular.h83_supervisor";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = rhpessoal.rh01_numcgm";
     $sql .= "      inner join cgm cgmsupervisor  on  cgmsupervisor.z01_numcgm = supervisor.rh01_numcgm";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($h83_sequencial!=null ) {
         $sql2 .= " where rhestagiocurricular.h83_sequencial = $h83_sequencial "; 
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
  function sql_query_file ( $h83_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from rhestagiocurricular ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($h83_sequencial!=null ) {
         $sql2 .= " where rhestagiocurricular.h83_sequencial = $h83_sequencial "; 
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
