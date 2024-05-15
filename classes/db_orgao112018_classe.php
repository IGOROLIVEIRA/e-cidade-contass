<?
//MODULO: sicom
//CLASSE DA ENTIDADE orgao112018
class cl_orgao112018 { 
   // cria variaveis de erro 
   var $rotulo     = null; 
   var $query_sql  = null; 
   var $numrows    = 0; 
   var $numrows_incluir = 0; 
   var $numrows_alterar = 0; 
   var $numrows_excluir = 0; 
   var $erro_status= null; 
   var $erro_sql   = null; 
   var $erro_banco = null;  
   var $erro_msg   = null;  
   var $erro_campo = null;  
   var $pagina_retorno = null; 
   // cria variaveis do arquivo 
   var $si15_sequencial = 0; 
   var $si15_tiporegistro = 0; 
   var $si15_tiporesponsavel = null; 
   var $si15_cartident = null; 
   var $si15_orgemissorci = null; 
   var $si15_cpf = null; 
   var $si15_crccontador = null; 
   var $si15_ufcrccontador = null; 
   var $si15_cargoorddespdeleg = null; 
   var $si15_dtinicio_dia = null; 
   var $si15_dtinicio_mes = null; 
   var $si15_dtinicio_ano = null; 
   var $si15_dtinicio = null; 
   var $si15_dtfinal_dia = null; 
   var $si15_dtfinal_mes = null; 
   var $si15_dtfinal_ano = null; 
   var $si15_dtfinal = null; 
   var $si15_email = null; 
   var $si15_reg10 = 0; 
   var $si15_mes = 0; 
   var $si15_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si15_sequencial = int8 = sequencial 
                 si15_tiporegistro = int8 = Tipo do  registro 
                 si15_tiporesponsavel = varchar(2) = Tipo de responsável 
                 si15_cartident = varchar(10) = Identidade do responsável 
                 si15_orgemissorci = varchar(10) = Órgão emissor 
                 si15_cpf = varchar(11) = Número do CPF 
                 si15_crccontador = varchar(11) = Número do CRC 
                 si15_ufcrccontador = varchar(2) = Estado de origem 
                 si15_cargoorddespdeleg = varchar(50) = Cargo do  Ordenador 
                 si15_dtinicio = date = Data inicial 
                 si15_dtfinal = date = Data final 
                 si15_email = varchar(50) = E-mail 
                 si15_reg10 = int8 = reg10 
                 si15_mes = int8 = Mês 
                 si15_instit = int8 = Instituição 
                 ";
   //funcao construtor da classe 
   function cl_orgao112018() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("orgao112018"); 
     $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
   }
   //funcao erro 
   function erro($mostra,$retorna) { 
     if(($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )){
        echo "<script>alert(\"".$this->erro_msg."\");</script>";
        if($retorna==true){
           echo "<script>location.href='".$this->pagina_retorno."'</script>";
        }
     }
   }
   // funcao para atualizar campos
   function atualizacampos($exclusao=false) {
     if($exclusao==false){
       $this->si15_sequencial = ($this->si15_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_sequencial"]:$this->si15_sequencial);
       $this->si15_tiporegistro = ($this->si15_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_tiporegistro"]:$this->si15_tiporegistro);
       $this->si15_tiporesponsavel = ($this->si15_tiporesponsavel == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_tiporesponsavel"]:$this->si15_tiporesponsavel);
       $this->si15_cartident = ($this->si15_cartident == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_cartident"]:$this->si15_cartident);
       $this->si15_orgemissorci = ($this->si15_orgemissorci == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_orgemissorci"]:$this->si15_orgemissorci);
       $this->si15_cpf = ($this->si15_cpf == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_cpf"]:$this->si15_cpf);
       $this->si15_crccontador = ($this->si15_crccontador == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_crccontador"]:$this->si15_crccontador);
       $this->si15_ufcrccontador = ($this->si15_ufcrccontador == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_ufcrccontador"]:$this->si15_ufcrccontador);
       $this->si15_cargoorddespdeleg = ($this->si15_cargoorddespdeleg == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_cargoorddespdeleg"]:$this->si15_cargoorddespdeleg);
       if($this->si15_dtinicio == ""){
         $this->si15_dtinicio_dia = ($this->si15_dtinicio_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_dtinicio_dia"]:$this->si15_dtinicio_dia);
         $this->si15_dtinicio_mes = ($this->si15_dtinicio_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_dtinicio_mes"]:$this->si15_dtinicio_mes);
         $this->si15_dtinicio_ano = ($this->si15_dtinicio_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_dtinicio_ano"]:$this->si15_dtinicio_ano);
         if($this->si15_dtinicio_dia != ""){
            $this->si15_dtinicio = $this->si15_dtinicio_ano."-".$this->si15_dtinicio_mes."-".$this->si15_dtinicio_dia;
         }
       }
       if($this->si15_dtfinal == ""){
         $this->si15_dtfinal_dia = ($this->si15_dtfinal_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_dtfinal_dia"]:$this->si15_dtfinal_dia);
         $this->si15_dtfinal_mes = ($this->si15_dtfinal_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_dtfinal_mes"]:$this->si15_dtfinal_mes);
         $this->si15_dtfinal_ano = ($this->si15_dtfinal_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_dtfinal_ano"]:$this->si15_dtfinal_ano);
         if($this->si15_dtfinal_dia != ""){
            $this->si15_dtfinal = $this->si15_dtfinal_ano."-".$this->si15_dtfinal_mes."-".$this->si15_dtfinal_dia;
         }
       }
       $this->si15_email = ($this->si15_email == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_email"]:$this->si15_email);
       $this->si15_reg10 = ($this->si15_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_reg10"]:$this->si15_reg10);
       $this->si15_mes = ($this->si15_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_mes"]:$this->si15_mes);
       $this->si15_instit = ($this->si15_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_instit"]:$this->si15_instit);
     }else{
       $this->si15_sequencial = ($this->si15_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si15_sequencial"]:$this->si15_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si15_sequencial){ 
      $this->atualizacampos();
     if($this->si15_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si15_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si15_dtinicio == null ){ 
       $this->si15_dtinicio = "null";
     }
     if($this->si15_dtfinal == null ){ 
       $this->si15_dtfinal = "null";
     }
     if($this->si15_reg10 == null ){ 
       $this->si15_reg10 = "0";
     }
     if($this->si15_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si15_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si15_instit == null ){ 
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si15_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     if($si15_sequencial == "" || $si15_sequencial == null ){
       $result = db_query("select nextval('orgao112018_si15_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: orgao112018_si15_sequencial_seq do campo: si15_sequencial"; 
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si15_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from orgao112018_si15_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si15_sequencial)){
         $this->erro_sql = " Campo si15_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si15_sequencial = $si15_sequencial; 
       }
     }
     if(($this->si15_sequencial == null) || ($this->si15_sequencial == "") ){ 
       $this->erro_sql = " Campo si15_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into orgao112018(
                                       si15_sequencial 
                                      ,si15_tiporegistro 
                                      ,si15_tiporesponsavel 
                                      ,si15_cartident 
                                      ,si15_orgemissorci 
                                      ,si15_cpf 
                                      ,si15_crccontador 
                                      ,si15_ufcrccontador 
                                      ,si15_cargoorddespdeleg 
                                      ,si15_dtinicio 
                                      ,si15_dtfinal 
                                      ,si15_email 
                                      ,si15_reg10 
                                      ,si15_mes 
                                      ,si15_instit 
                       )
                values (
                                $this->si15_sequencial 
                               ,$this->si15_tiporegistro 
                               ,'$this->si15_tiporesponsavel' 
                               ,'$this->si15_cartident' 
                               ,'$this->si15_orgemissorci' 
                               ,'$this->si15_cpf' 
                               ,'$this->si15_crccontador' 
                               ,'$this->si15_ufcrccontador' 
                               ,'$this->si15_cargoorddespdeleg' 
                               ,".($this->si15_dtinicio == "null" || $this->si15_dtinicio == ""?"null":"'".$this->si15_dtinicio."'")." 
                               ,".($this->si15_dtfinal == "null" || $this->si15_dtfinal == ""?"null":"'".$this->si15_dtfinal."'")." 
                               ,'$this->si15_email' 
                               ,$this->si15_reg10 
                               ,$this->si15_mes 
                               ,$this->si15_instit 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Orgão ($this->si15_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "Orgão já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "Orgão ($this->si15_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si15_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si15_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009605,'$this->si15_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010243,2009605,'','".AddSlashes(pg_result($resaco,0,'si15_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010243,2009606,'','".AddSlashes(pg_result($resaco,0,'si15_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010243,2009607,'','".AddSlashes(pg_result($resaco,0,'si15_tiporesponsavel'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010243,2009608,'','".AddSlashes(pg_result($resaco,0,'si15_cartident'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010243,2009609,'','".AddSlashes(pg_result($resaco,0,'si15_orgemissorci'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010243,2009610,'','".AddSlashes(pg_result($resaco,0,'si15_cpf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010243,2009611,'','".AddSlashes(pg_result($resaco,0,'si15_crccontador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010243,2009612,'','".AddSlashes(pg_result($resaco,0,'si15_ufcrccontador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010243,2009613,'','".AddSlashes(pg_result($resaco,0,'si15_cargoorddespdeleg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010243,2009614,'','".AddSlashes(pg_result($resaco,0,'si15_dtinicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010243,2009615,'','".AddSlashes(pg_result($resaco,0,'si15_dtfinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010243,2009616,'','".AddSlashes(pg_result($resaco,0,'si15_email'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010243,2009617,'','".AddSlashes(pg_result($resaco,0,'si15_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010243,2009735,'','".AddSlashes(pg_result($resaco,0,'si15_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010243,2011533,'','".AddSlashes(pg_result($resaco,0,'si15_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si15_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update orgao112018 set ";
     $virgula = "";
     if(trim($this->si15_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si15_sequencial"])){ 
        if(trim($this->si15_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si15_sequencial"])){ 
           $this->si15_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si15_sequencial = $this->si15_sequencial ";
       $virgula = ",";
     }
     if(trim($this->si15_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si15_tiporegistro"])){ 
       $sql  .= $virgula." si15_tiporegistro = $this->si15_tiporegistro ";
       $virgula = ",";
       if(trim($this->si15_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si15_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si15_tiporesponsavel)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si15_tiporesponsavel"])){ 
       $sql  .= $virgula." si15_tiporesponsavel = '$this->si15_tiporesponsavel' ";
       $virgula = ",";
     }
     if(trim($this->si15_cartident)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si15_cartident"])){ 
       $sql  .= $virgula." si15_cartident = '$this->si15_cartident' ";
       $virgula = ",";
     }
     if(trim($this->si15_orgemissorci)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si15_orgemissorci"])){ 
       $sql  .= $virgula." si15_orgemissorci = '$this->si15_orgemissorci' ";
       $virgula = ",";
     }
     if(trim($this->si15_cpf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si15_cpf"])){ 
       $sql  .= $virgula." si15_cpf = '$this->si15_cpf' ";
       $virgula = ",";
     }
     if(trim($this->si15_crccontador)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si15_crccontador"])){ 
       $sql  .= $virgula." si15_crccontador = '$this->si15_crccontador' ";
       $virgula = ",";
     }
     if(trim($this->si15_ufcrccontador)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si15_ufcrccontador"])){ 
       $sql  .= $virgula." si15_ufcrccontador = '$this->si15_ufcrccontador' ";
       $virgula = ",";
     }
     if(trim($this->si15_cargoorddespdeleg)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si15_cargoorddespdeleg"])){ 
       $sql  .= $virgula." si15_cargoorddespdeleg = '$this->si15_cargoorddespdeleg' ";
       $virgula = ",";
     }
     if(trim($this->si15_dtinicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si15_dtinicio_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si15_dtinicio_dia"] !="") ){ 
       $sql  .= $virgula." si15_dtinicio = '$this->si15_dtinicio' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si15_dtinicio_dia"])){ 
         $sql  .= $virgula." si15_dtinicio = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si15_dtfinal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si15_dtfinal_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si15_dtfinal_dia"] !="") ){ 
       $sql  .= $virgula." si15_dtfinal = '$this->si15_dtfinal' ";
       $virgula = ",";
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si15_dtfinal_dia"])){ 
         $sql  .= $virgula." si15_dtfinal = null ";
         $virgula = ",";
       }
     }
     if(trim($this->si15_email)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si15_email"])){ 
       $sql  .= $virgula." si15_email = '$this->si15_email' ";
       $virgula = ",";
     }
     if(trim($this->si15_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si15_reg10"])){ 
        if(trim($this->si15_reg10)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si15_reg10"])){ 
           $this->si15_reg10 = "0" ; 
        } 
       $sql  .= $virgula." si15_reg10 = $this->si15_reg10 ";
       $virgula = ",";
     }
     if(trim($this->si15_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si15_mes"])){ 
       $sql  .= $virgula." si15_mes = $this->si15_mes ";
       $virgula = ",";
       if(trim($this->si15_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si15_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si15_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si15_instit"])){ 
       $sql  .= $virgula." si15_instit = $this->si15_instit ";
       $virgula = ",";
       if(trim($this->si15_instit) == null ){ 
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si15_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si15_sequencial!=null){
       $sql .= " si15_sequencial = $this->si15_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si15_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009605,'$this->si15_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si15_sequencial"]) || $this->si15_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010243,2009605,'".AddSlashes(pg_result($resaco,$conresaco,'si15_sequencial'))."','$this->si15_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si15_tiporegistro"]) || $this->si15_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010243,2009606,'".AddSlashes(pg_result($resaco,$conresaco,'si15_tiporegistro'))."','$this->si15_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si15_tiporesponsavel"]) || $this->si15_tiporesponsavel != "")
           $resac = db_query("insert into db_acount values($acount,2010243,2009607,'".AddSlashes(pg_result($resaco,$conresaco,'si15_tiporesponsavel'))."','$this->si15_tiporesponsavel',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si15_cartident"]) || $this->si15_cartident != "")
           $resac = db_query("insert into db_acount values($acount,2010243,2009608,'".AddSlashes(pg_result($resaco,$conresaco,'si15_cartident'))."','$this->si15_cartident',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si15_orgemissorci"]) || $this->si15_orgemissorci != "")
           $resac = db_query("insert into db_acount values($acount,2010243,2009609,'".AddSlashes(pg_result($resaco,$conresaco,'si15_orgemissorci'))."','$this->si15_orgemissorci',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si15_cpf"]) || $this->si15_cpf != "")
           $resac = db_query("insert into db_acount values($acount,2010243,2009610,'".AddSlashes(pg_result($resaco,$conresaco,'si15_cpf'))."','$this->si15_cpf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si15_crccontador"]) || $this->si15_crccontador != "")
           $resac = db_query("insert into db_acount values($acount,2010243,2009611,'".AddSlashes(pg_result($resaco,$conresaco,'si15_crccontador'))."','$this->si15_crccontador',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si15_ufcrccontador"]) || $this->si15_ufcrccontador != "")
           $resac = db_query("insert into db_acount values($acount,2010243,2009612,'".AddSlashes(pg_result($resaco,$conresaco,'si15_ufcrccontador'))."','$this->si15_ufcrccontador',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si15_cargoorddespdeleg"]) || $this->si15_cargoorddespdeleg != "")
           $resac = db_query("insert into db_acount values($acount,2010243,2009613,'".AddSlashes(pg_result($resaco,$conresaco,'si15_cargoorddespdeleg'))."','$this->si15_cargoorddespdeleg',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si15_dtinicio"]) || $this->si15_dtinicio != "")
           $resac = db_query("insert into db_acount values($acount,2010243,2009614,'".AddSlashes(pg_result($resaco,$conresaco,'si15_dtinicio'))."','$this->si15_dtinicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si15_dtfinal"]) || $this->si15_dtfinal != "")
           $resac = db_query("insert into db_acount values($acount,2010243,2009615,'".AddSlashes(pg_result($resaco,$conresaco,'si15_dtfinal'))."','$this->si15_dtfinal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si15_email"]) || $this->si15_email != "")
           $resac = db_query("insert into db_acount values($acount,2010243,2009616,'".AddSlashes(pg_result($resaco,$conresaco,'si15_email'))."','$this->si15_email',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si15_reg10"]) || $this->si15_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010243,2009617,'".AddSlashes(pg_result($resaco,$conresaco,'si15_reg10'))."','$this->si15_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si15_mes"]) || $this->si15_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010243,2009735,'".AddSlashes(pg_result($resaco,$conresaco,'si15_mes'))."','$this->si15_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si15_instit"]) || $this->si15_instit != "")
           $resac = db_query("insert into db_acount values($acount,2010243,2011533,'".AddSlashes(pg_result($resaco,$conresaco,'si15_instit'))."','$this->si15_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "Orgão nao Alterado. Alteracao Abortada.\n";
         $this->erro_sql .= "Valores : ".$this->si15_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Orgão nao foi Alterado. Alteracao Executada.\n";
         $this->erro_sql .= "Valores : ".$this->si15_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si15_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si15_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si15_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009605,'$si15_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010243,2009605,'','".AddSlashes(pg_result($resaco,$iresaco,'si15_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010243,2009606,'','".AddSlashes(pg_result($resaco,$iresaco,'si15_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010243,2009607,'','".AddSlashes(pg_result($resaco,$iresaco,'si15_tiporesponsavel'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010243,2009608,'','".AddSlashes(pg_result($resaco,$iresaco,'si15_cartident'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010243,2009609,'','".AddSlashes(pg_result($resaco,$iresaco,'si15_orgemissorci'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010243,2009610,'','".AddSlashes(pg_result($resaco,$iresaco,'si15_cpf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010243,2009611,'','".AddSlashes(pg_result($resaco,$iresaco,'si15_crccontador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010243,2009612,'','".AddSlashes(pg_result($resaco,$iresaco,'si15_ufcrccontador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010243,2009613,'','".AddSlashes(pg_result($resaco,$iresaco,'si15_cargoorddespdeleg'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010243,2009614,'','".AddSlashes(pg_result($resaco,$iresaco,'si15_dtinicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010243,2009615,'','".AddSlashes(pg_result($resaco,$iresaco,'si15_dtfinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010243,2009616,'','".AddSlashes(pg_result($resaco,$iresaco,'si15_email'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010243,2009617,'','".AddSlashes(pg_result($resaco,$iresaco,'si15_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010243,2009735,'','".AddSlashes(pg_result($resaco,$iresaco,'si15_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010243,2011533,'','".AddSlashes(pg_result($resaco,$iresaco,'si15_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from orgao112018
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si15_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si15_sequencial = $si15_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "Orgão nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si15_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Orgão nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si15_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si15_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao do recordset 
   function sql_record($sql) { 
     $result = db_query($sql);
     if($result==false){
       $this->numrows    = 0;
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:orgao112018";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si15_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = explode("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from orgao112018 ";
     $sql .= "      left  join orgao102018  on  orgao102018.si14_sequencial = orgao112018.si15_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si15_sequencial!=null ){
         $sql2 .= " where orgao112018.si15_sequencial = $si15_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = explode("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
   // funcao do sql 
   function sql_query_file ( $si15_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = explode("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from orgao112018 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si15_sequencial!=null ){
         $sql2 .= " where orgao112018.si15_sequencial = $si15_sequencial "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = explode("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
}
?>
