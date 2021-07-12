<?
//MODULO: sicom
//CLASSE DA ENTIDADE identificacaoresponsaveis
class cl_identificacaoresponsaveis { 
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
   var $si166_sequencial = 0; 
   var $si166_numcgm = 0; 
   var $si166_tiporesponsavel = 0; 
   var $si166_orgao = null; 
   var $si166_crccontador = null; 
   var $si166_ufcrccontador = null; 
   var $si166_cargoorddespesa = null; 
   var $si166_dataini_dia = null; 
   var $si166_dataini_mes = null; 
   var $si166_dataini_ano = null; 
   var $si166_dataini = null; 
   var $si166_datafim_dia = null; 
   var $si166_datafim_mes = null; 
   var $si166_datafim_ano = null; 
   var $si166_datafim = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si166_sequencial = int8 = Código Sequencial 
                 si166_numcgm = int8 = Número Cgm 
                 si166_tiporesponsavel = int8 = Tipo Responsável 
                 si166_orgao = int8 = Orgão 
                 si166_crccontador = varchar(11) = CRC Contador 
                 si166_ufcrccontador = varchar(2) = UF CRC Contador 
                 si166_cargoorddespesa = varchar(50) = Cargo Ordenador por Despesa 
                 si166_dataini = date = Data Inicial 
                 si166_datafim = date = Data Final 
                 ";
   //funcao construtor da classe 
   function cl_identificacaoresponsaveis() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("identificacaoresponsaveis"); 
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
       $this->si166_sequencial = ($this->si166_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si166_sequencial"]:$this->si166_sequencial);
       $this->si166_numcgm = ($this->si166_numcgm == ""?@$GLOBALS["HTTP_POST_VARS"]["si166_numcgm"]:$this->si166_numcgm);
       $this->si166_tiporesponsavel = ($this->si166_tiporesponsavel == ""?@$GLOBALS["HTTP_POST_VARS"]["si166_tiporesponsavel"]:$this->si166_tiporesponsavel);
       $this->si166_orgao = ($this->si166_orgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si166_orgao"]:$this->si166_orgao);
       $this->si166_crccontador = ($this->si166_crccontador == ""?@$GLOBALS["HTTP_POST_VARS"]["si166_crccontador"]:$this->si166_crccontador);
       $this->si166_ufcrccontador = ($this->si166_ufcrccontador == ""?@$GLOBALS["HTTP_POST_VARS"]["si166_ufcrccontador"]:$this->si166_ufcrccontador);
       $this->si166_cargoorddespesa = ($this->si166_cargoorddespesa == ""?@$GLOBALS["HTTP_POST_VARS"]["si166_cargoorddespesa"]:$this->si166_cargoorddespesa);
       if($this->si166_dataini == ""){
         $this->si166_dataini_dia = ($this->si166_dataini_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si166_dataini_dia"]:$this->si166_dataini_dia);
         $this->si166_dataini_mes = ($this->si166_dataini_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si166_dataini_mes"]:$this->si166_dataini_mes);
         $this->si166_dataini_ano = ($this->si166_dataini_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si166_dataini_ano"]:$this->si166_dataini_ano);
         if($this->si166_dataini_dia != ""){
            $this->si166_dataini = $this->si166_dataini_ano."-".$this->si166_dataini_mes."-".$this->si166_dataini_dia;
         }
       }
       if($this->si166_datafim == ""){
         $this->si166_datafim_dia = ($this->si166_datafim_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si166_datafim_dia"]:$this->si166_datafim_dia);
         $this->si166_datafim_mes = ($this->si166_datafim_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si166_datafim_mes"]:$this->si166_datafim_mes);
         $this->si166_datafim_ano = ($this->si166_datafim_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si166_datafim_ano"]:$this->si166_datafim_ano);
         if($this->si166_datafim_dia != ""){
            $this->si166_datafim = $this->si166_datafim_ano."-".$this->si166_datafim_mes."-".$this->si166_datafim_dia;
         }
       }
     }else{
       $this->si166_sequencial = ($this->si166_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si166_sequencial"]:$this->si166_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si166_sequencial){ 
      $this->atualizacampos();
     if($this->si166_numcgm == null ){ 
       $this->erro_sql = " Campo Número Cgm nao Informado.";
       $this->erro_campo = "si166_numcgm";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si166_tiporesponsavel == null ){ 
       $this->erro_sql = " Campo Tipo Responsável nao Informado.";
       $this->erro_campo = "si166_tiporesponsavel";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si166_orgao == null && $this->si166_tiporesponsavel == 4){ 
       $this->erro_sql = " Campo Orgão nao Informado.";
       $this->erro_campo = "si166_orgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     } else if ($this->si166_orgao == null) {
     	 $this->si166_orgao = 'null';
     }
     if($this->si166_crccontador == null && $this->si166_tiporesponsavel == 2){ 
       $this->erro_sql = " Campo CRC Contador nao Informado.";
       $this->erro_campo = "si166_crccontador";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si166_ufcrccontador == null && $this->si166_tiporesponsavel == 2){ 
       $this->erro_sql = " Campo UF CRC Contador nao Informado.";
       $this->erro_campo = "si166_ufcrccontador";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si166_cargoorddespesa == null && $this->si166_tiporesponsavel == 4){ 
       $this->erro_sql = " Campo Cargo Ordenador por Despesa nao Informado.";
       $this->erro_campo = "si166_cargoorddespesa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si166_dataini == null ){ 
       $this->erro_sql = " Campo Data Inicial nao Informado.";
       $this->erro_campo = "si166_dataini_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si166_datafim == null ){ 
       $this->erro_sql = " Campo Data Final nao Informado.";
       $this->erro_campo = "si166_datafim_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si166_sequencial == "" || $si166_sequencial == null ){
       $result = db_query("select nextval('identificacaoresponsaveis_si166_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: identificacaoresponsaveis_si166_sequencial_seq do campo: si166_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si166_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from identificacaoresponsaveis_si166_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si166_sequencial)){
         $this->erro_sql = " Campo si166_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si166_sequencial = $si166_sequencial; 
       }
     }
     if(($this->si166_sequencial == null) || ($this->si166_sequencial == "") ){ 
       $this->erro_sql = " Campo si166_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into identificacaoresponsaveis(
                                       si166_sequencial 
                                      ,si166_numcgm 
                                      ,si166_tiporesponsavel 
                                      ,si166_orgao 
                                      ,si166_crccontador 
                                      ,si166_ufcrccontador 
                                      ,si166_cargoorddespesa 
                                      ,si166_dataini 
                                      ,si166_datafim 
                                      ,si166_instit
                       )
                values (
                                $this->si166_sequencial 
                               ,$this->si166_numcgm 
                               ,$this->si166_tiporesponsavel 
                               ,$this->si166_orgao 
                               ,'$this->si166_crccontador' 
                               ,'$this->si166_ufcrccontador' 
                               ,'$this->si166_cargoorddespesa' 
                               ,".($this->si166_dataini == "null" || $this->si166_dataini == ""?"null":"'".$this->si166_dataini."'")." 
                               ,".($this->si166_datafim == "null" || $this->si166_datafim == ""?"null":"'".$this->si166_datafim."'")."
                               ,".db_getsession("DB_instit")." 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Identificação dos Responsáveis ($this->si166_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Identificação dos Responsáveis já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Identificação dos Responsáveis ($this->si166_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si166_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si166_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011405,'$this->si166_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010400,2011405,'','".AddSlashes(pg_result($resaco,0,'si166_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010400,2011406,'','".AddSlashes(pg_result($resaco,0,'si166_numcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010400,2011407,'','".AddSlashes(pg_result($resaco,0,'si166_tiporesponsavel'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010400,2011408,'','".AddSlashes(pg_result($resaco,0,'si166_orgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010400,2011409,'','".AddSlashes(pg_result($resaco,0,'si166_crccontador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010400,2011410,'','".AddSlashes(pg_result($resaco,0,'si166_ufcrccontador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010400,2011411,'','".AddSlashes(pg_result($resaco,0,'si166_cargoorddespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010400,2011412,'','".AddSlashes(pg_result($resaco,0,'si166_dataini'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010400,2011413,'','".AddSlashes(pg_result($resaco,0,'si166_datafim'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si166_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update identificacaoresponsaveis set ";
     $virgula = "";
     if(trim($this->si166_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si166_sequencial"])){ 
       $sql  .= $virgula." si166_sequencial = $this->si166_sequencial ";
       $virgula = ",";
       if(trim($this->si166_sequencial) == null ){ 
         $this->erro_sql = " Campo Código Sequencial nao Informado.";
         $this->erro_campo = "si166_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si166_numcgm)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si166_numcgm"])){ 
       $sql  .= $virgula." si166_numcgm = $this->si166_numcgm ";
       $virgula = ",";
       if(trim($this->si166_numcgm) == null ){ 
         $this->erro_sql = " Campo Número Cgm nao Informado.";
         $this->erro_campo = "si166_numcgm";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si166_tiporesponsavel)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si166_tiporesponsavel"])){ 
       $sql  .= $virgula." si166_tiporesponsavel = $this->si166_tiporesponsavel ";
       $virgula = ",";
       if(trim($this->si166_tiporesponsavel) == null ){ 
         $this->erro_sql = " Campo Tipo Responsável nao Informado.";
         $this->erro_campo = "si166_tiporesponsavel";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si166_orgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si166_orgao"])){
     	if ($this->si166_orgao == '') {
     		$this->si166_orgao = 'null';
     	} 
       $sql  .= $virgula." si166_orgao = $this->si166_orgao ";
       $virgula = ",";
       if(trim($this->si166_orgao) == 'null' && $this->si166_tiporesponsavel == 4){ 
         $this->erro_sql = " Campo Orgão nao Informado.";
         $this->erro_campo = "si166_orgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }      
     if(trim($this->si166_crccontador)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si166_crccontador"])){  
     	 $sql  .= $virgula." si166_crccontador = '$this->si166_crccontador' ";
       $virgula = ",";
       if(trim($this->si166_crccontador) == null && $this->si166_tiporesponsavel == 2){ 
         $this->erro_sql = " Campo CRC Contador nao Informado.";
         $this->erro_campo = "si166_crccontador";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si166_ufcrccontador)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si166_ufcrccontador"])){ 
     	 $sql  .= $virgula." si166_ufcrccontador = '$this->si166_ufcrccontador' ";
       $virgula = ",";
       if(trim($this->si166_ufcrccontador) == null && $this->si166_tiporesponsavel == 2){ 
         $this->erro_sql = " Campo UF CRC Contador nao Informado.";
         $this->erro_campo = "si166_ufcrccontador";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si166_cargoorddespesa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si166_cargoorddespesa"])){ 
       $sql  .= $virgula." si166_cargoorddespesa = '$this->si166_cargoorddespesa' ";
       $virgula = ",";
       if(trim($this->si166_cargoorddespesa) == null && $this->si166_tiporesponsavel == 4){ 
         $this->erro_sql = " Campo Cargo Ordenador por Despesa nao Informado.";
         $this->erro_campo = "si166_cargoorddespesa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si166_dataini)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si166_dataini_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si166_dataini_dia"] !="") ){ 
       $sql  .= $virgula." si166_dataini = '$this->si166_dataini' ";
       $virgula = ",";
       if(trim($this->si166_dataini) == null ){ 
         $this->erro_sql = " Campo Data Inicial nao Informado.";
         $this->erro_campo = "si166_dataini_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si166_dataini_dia"])){ 
         $sql  .= $virgula." si166_dataini = null ";
         $virgula = ",";
         if(trim($this->si166_dataini) == null ){ 
           $this->erro_sql = " Campo Data Inicial nao Informado.";
           $this->erro_campo = "si166_dataini_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si166_datafim)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si166_datafim_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si166_datafim_dia"] !="") ){ 
       $sql  .= $virgula." si166_datafim = '$this->si166_datafim' ";
       $virgula = ",";
       if(trim($this->si166_datafim) == null ){ 
         $this->erro_sql = " Campo Data Final nao Informado.";
         $this->erro_campo = "si166_datafim_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si166_datafim_dia"])){ 
         $sql  .= $virgula." si166_datafim = null ";
         $virgula = ",";
         if(trim($this->si166_datafim) == null ){ 
           $this->erro_sql = " Campo Data Final nao Informado.";
           $this->erro_campo = "si166_datafim_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     $sql .= " where ";
     if($si166_sequencial!=null){
       $sql .= " si166_sequencial = $this->si166_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si166_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011405,'$this->si166_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si166_sequencial"]) || $this->si166_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010400,2011405,'".AddSlashes(pg_result($resaco,$conresaco,'si166_sequencial'))."','$this->si166_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si166_numcgm"]) || $this->si166_numcgm != "")
           $resac = db_query("insert into db_acount values($acount,2010400,2011406,'".AddSlashes(pg_result($resaco,$conresaco,'si166_numcgm'))."','$this->si166_numcgm',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si166_tiporesponsavel"]) || $this->si166_tiporesponsavel != "")
           $resac = db_query("insert into db_acount values($acount,2010400,2011407,'".AddSlashes(pg_result($resaco,$conresaco,'si166_tiporesponsavel'))."','$this->si166_tiporesponsavel',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si166_orgao"]) || $this->si166_orgao != "")
           $resac = db_query("insert into db_acount values($acount,2010400,2011408,'".AddSlashes(pg_result($resaco,$conresaco,'si166_orgao'))."','$this->si166_orgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si166_crccontador"]) || $this->si166_crccontador != "")
           $resac = db_query("insert into db_acount values($acount,2010400,2011409,'".AddSlashes(pg_result($resaco,$conresaco,'si166_crccontador'))."','$this->si166_crccontador',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si166_ufcrccontador"]) || $this->si166_ufcrccontador != "")
           $resac = db_query("insert into db_acount values($acount,2010400,2011410,'".AddSlashes(pg_result($resaco,$conresaco,'si166_ufcrccontador'))."','$this->si166_ufcrccontador',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si166_cargoorddespesa"]) || $this->si166_cargoorddespesa != "")
           $resac = db_query("insert into db_acount values($acount,2010400,2011411,'".AddSlashes(pg_result($resaco,$conresaco,'si166_cargoorddespesa'))."','$this->si166_cargoorddespesa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si166_dataini"]) || $this->si166_dataini != "")
           $resac = db_query("insert into db_acount values($acount,2010400,2011412,'".AddSlashes(pg_result($resaco,$conresaco,'si166_dataini'))."','$this->si166_dataini',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si166_datafim"]) || $this->si166_datafim != "")
           $resac = db_query("insert into db_acount values($acount,2010400,2011413,'".AddSlashes(pg_result($resaco,$conresaco,'si166_datafim'))."','$this->si166_datafim',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Identificação dos Responsáveis nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si166_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Identificação dos Responsáveis nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si166_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si166_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si166_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si166_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011405,'$si166_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010400,2011405,'','".AddSlashes(pg_result($resaco,$iresaco,'si166_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010400,2011406,'','".AddSlashes(pg_result($resaco,$iresaco,'si166_numcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010400,2011407,'','".AddSlashes(pg_result($resaco,$iresaco,'si166_tiporesponsavel'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010400,2011408,'','".AddSlashes(pg_result($resaco,$iresaco,'si166_orgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010400,2011409,'','".AddSlashes(pg_result($resaco,$iresaco,'si166_crccontador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010400,2011410,'','".AddSlashes(pg_result($resaco,$iresaco,'si166_ufcrccontador'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010400,2011411,'','".AddSlashes(pg_result($resaco,$iresaco,'si166_cargoorddespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010400,2011412,'','".AddSlashes(pg_result($resaco,$iresaco,'si166_dataini'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010400,2011413,'','".AddSlashes(pg_result($resaco,$iresaco,'si166_datafim'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from identificacaoresponsaveis
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si166_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si166_sequencial = $si166_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Identificação dos Responsáveis nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si166_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Identificação dos Responsáveis nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si166_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si166_sequencial;
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
     if($result==false){
       $this->numrows    = 0;
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:identificacaoresponsaveis";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si166_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from identificacaoresponsaveis ";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = identificacaoresponsaveis.si166_numcgm";
     $sql2 = "";
     if($dbwhere==""){
       if($si166_sequencial!=null ){
         $sql2 .= " where identificacaoresponsaveis.si166_sequencial = $si166_sequencial "; 
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
   function sql_query_file ( $si166_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from identificacaoresponsaveis ";
     $sql2 = "";
     if($dbwhere==""){
       if($si166_sequencial!=null ){
         $sql2 .= " where identificacaoresponsaveis.si166_sequencial = $si166_sequencial "; 
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
