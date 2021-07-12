<?
//MODULO: sicom
//CLASSE DA ENTIDADE ext122014
class cl_ext122014 { 
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
   var $si126_sequencial = 0; 
   var $si126_tiporegistro = 0; 
   var $si126_codreduzidoeo = 0; 
   var $si126_codreduzidoop = 0; 
   var $si126_nroop = 0; 
   var $si126_dtpagamento_dia = null; 
   var $si126_dtpagamento_mes = null; 
   var $si126_dtpagamento_ano = null; 
   var $si126_dtpagamento = null; 
   var $si126_tipodocumentocredor = 0; 
   var $si126_nrodocumento = null; 
   var $si126_vlop = 0; 
   var $si126_especificacaoop = null; 
   var $si126_cpfresppgto = null; 
   var $si126_mes = 0; 
   var $si126_reg10 = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si126_sequencial = int8 = sequencial 
                 si126_tiporegistro = int8 = Tipo do  registro 
                 si126_codreduzidoeo = int8 = Código  identificador ExtraOrçamentária 
                 si126_codreduzidoop = int8 = Código  Identificador do  pagamento 
                 si126_nroop = int8 = Número da  Ordem de  Pagamento 
                 si126_dtpagamento = date = Data de  pagamento da  OP 
                 si126_tipodocumentocredor = int8 = Tipo de  Documento do  credor 
                 si126_nrodocumento = varchar(14) = Número do documento do credor 
                 si126_vlop = float8 = Valor da OP 
                 si126_especificacaoop = varchar(200) = Especificação da  OP 
                 si126_cpfresppgto = varchar(11) = CPF do  responsável 
                 si126_mes = int8 = Mês 
                 si126_reg10 = int8 = reg10 
                 ";
   //funcao construtor da classe 
   function cl_ext122014() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ext122014"); 
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
       $this->si126_sequencial = ($this->si126_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_sequencial"]:$this->si126_sequencial);
       $this->si126_tiporegistro = ($this->si126_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_tiporegistro"]:$this->si126_tiporegistro);
       $this->si126_codreduzidoeo = ($this->si126_codreduzidoeo == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_codreduzidoeo"]:$this->si126_codreduzidoeo);
       $this->si126_codreduzidoop = ($this->si126_codreduzidoop == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_codreduzidoop"]:$this->si126_codreduzidoop);
       $this->si126_nroop = ($this->si126_nroop == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_nroop"]:$this->si126_nroop);
       if($this->si126_dtpagamento == ""){
         $this->si126_dtpagamento_dia = ($this->si126_dtpagamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_dtpagamento_dia"]:$this->si126_dtpagamento_dia);
         $this->si126_dtpagamento_mes = ($this->si126_dtpagamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_dtpagamento_mes"]:$this->si126_dtpagamento_mes);
         $this->si126_dtpagamento_ano = ($this->si126_dtpagamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_dtpagamento_ano"]:$this->si126_dtpagamento_ano);
         if($this->si126_dtpagamento_dia != ""){
            $this->si126_dtpagamento = $this->si126_dtpagamento_ano."-".$this->si126_dtpagamento_mes."-".$this->si126_dtpagamento_dia;
         }
       }
       $this->si126_tipodocumentocredor = ($this->si126_tipodocumentocredor == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_tipodocumentocredor"]:$this->si126_tipodocumentocredor);
       $this->si126_nrodocumento = ($this->si126_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_nrodocumento"]:$this->si126_nrodocumento);
       $this->si126_vlop = ($this->si126_vlop == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_vlop"]:$this->si126_vlop);
       $this->si126_especificacaoop = ($this->si126_especificacaoop == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_especificacaoop"]:$this->si126_especificacaoop);
       $this->si126_cpfresppgto = ($this->si126_cpfresppgto == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_cpfresppgto"]:$this->si126_cpfresppgto);
       $this->si126_mes = ($this->si126_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_mes"]:$this->si126_mes);
       $this->si126_reg10 = ($this->si126_reg10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_reg10"]:$this->si126_reg10);
     }else{
       $this->si126_sequencial = ($this->si126_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si126_sequencial"]:$this->si126_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si126_sequencial){ 
      $this->atualizacampos();
     if($this->si126_tiporegistro == null ){ 
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si126_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si126_codreduzidoeo == null ){ 
       $this->erro_sql = " Campo Código  identificador ExtraOrçamentária nao Informado.";
       $this->erro_campo = "si126_codreduzidoeo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si126_codreduzidoop == null ){ 
       $this->erro_sql = " Campo Código  Identificador do  pagamento nao Informado.";
       $this->erro_campo = "si126_codreduzidoop";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si126_nroop == null ){ 
       $this->erro_sql = " Campo Número da  Ordem de  Pagamento nao Informado.";
       $this->erro_campo = "si126_nroop";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si126_dtpagamento == null ){ 
       $this->erro_sql = " Campo Data de  pagamento da  OP nao Informado.";
       $this->erro_campo = "si126_dtpagamento_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si126_tipodocumentocredor == null ){ 
       $this->erro_sql = " Campo Tipo de  Documento do  credor nao Informado.";
       $this->erro_campo = "si126_tipodocumentocredor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si126_nrodocumento == null ){ 
       $this->erro_sql = " Campo Número do documento do credor nao Informado.";
       $this->erro_campo = "si126_nrodocumento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si126_vlop == null ){ 
       $this->erro_sql = " Campo Valor da OP nao Informado.";
       $this->erro_campo = "si126_vlop";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si126_especificacaoop == null ){ 
       $this->erro_sql = " Campo Especificação da  OP nao Informado.";
       $this->erro_campo = "si126_especificacaoop";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si126_cpfresppgto == null ){ 
       $this->erro_sql = " Campo CPF do  responsável nao Informado.";
       $this->erro_campo = "si126_cpfresppgto";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si126_mes == null ){ 
       $this->erro_sql = " Campo Mês nao Informado.";
       $this->erro_campo = "si126_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si126_reg10 == null ){ 
       $this->erro_sql = " Campo reg10 nao Informado.";
       $this->erro_campo = "si126_reg10";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($si126_sequencial == "" || $si126_sequencial == null ){
       $result = db_query("select nextval('ext122014_si126_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: ext122014_si126_sequencial_seq do campo: si126_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->si126_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from ext122014_si126_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si126_sequencial)){
         $this->erro_sql = " Campo si126_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si126_sequencial = $si126_sequencial; 
       }
     }
     if(($this->si126_sequencial == null) || ($this->si126_sequencial == "") ){ 
       $this->erro_sql = " Campo si126_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ext122014(
                                       si126_sequencial 
                                      ,si126_tiporegistro 
                                      ,si126_codreduzidoeo 
                                      ,si126_codreduzidoop 
                                      ,si126_nroop 
                                      ,si126_dtpagamento 
                                      ,si126_tipodocumentocredor 
                                      ,si126_nrodocumento 
                                      ,si126_vlop 
                                      ,si126_especificacaoop 
                                      ,si126_cpfresppgto 
                                      ,si126_mes 
                                      ,si126_reg10 
                       )
                values (
                                $this->si126_sequencial 
                               ,$this->si126_tiporegistro 
                               ,$this->si126_codreduzidoeo 
                               ,$this->si126_codreduzidoop 
                               ,$this->si126_nroop 
                               ,".($this->si126_dtpagamento == "null" || $this->si126_dtpagamento == ""?"null":"'".$this->si126_dtpagamento."'")." 
                               ,$this->si126_tipodocumentocredor 
                               ,'$this->si126_nrodocumento' 
                               ,$this->si126_vlop 
                               ,'$this->si126_especificacaoop' 
                               ,'$this->si126_cpfresppgto' 
                               ,$this->si126_mes 
                               ,$this->si126_reg10 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "ext122014 ($this->si126_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "ext122014 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "ext122014 ($this->si126_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si126_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si126_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2010865,'$this->si126_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010355,2010865,'','".AddSlashes(pg_result($resaco,0,'si126_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010355,2010866,'','".AddSlashes(pg_result($resaco,0,'si126_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010355,2010867,'','".AddSlashes(pg_result($resaco,0,'si126_codreduzidoeo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010355,2010868,'','".AddSlashes(pg_result($resaco,0,'si126_codreduzidoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010355,2010869,'','".AddSlashes(pg_result($resaco,0,'si126_nroop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010355,2010870,'','".AddSlashes(pg_result($resaco,0,'si126_dtpagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010355,2010871,'','".AddSlashes(pg_result($resaco,0,'si126_tipodocumentocredor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010355,2010872,'','".AddSlashes(pg_result($resaco,0,'si126_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010355,2010873,'','".AddSlashes(pg_result($resaco,0,'si126_vlop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010355,2010874,'','".AddSlashes(pg_result($resaco,0,'si126_especificacaoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010355,2010875,'','".AddSlashes(pg_result($resaco,0,'si126_cpfresppgto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010355,2010876,'','".AddSlashes(pg_result($resaco,0,'si126_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010355,2010877,'','".AddSlashes(pg_result($resaco,0,'si126_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si126_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update ext122014 set ";
     $virgula = "";
     if(trim($this->si126_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si126_sequencial"])){ 
       $sql  .= $virgula." si126_sequencial = $this->si126_sequencial ";
       $virgula = ",";
       if(trim($this->si126_sequencial) == null ){ 
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "si126_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si126_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si126_tiporegistro"])){ 
       $sql  .= $virgula." si126_tiporegistro = $this->si126_tiporegistro ";
       $virgula = ",";
       if(trim($this->si126_tiporegistro) == null ){ 
         $this->erro_sql = " Campo Tipo do  registro nao Informado.";
         $this->erro_campo = "si126_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si126_codreduzidoeo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si126_codreduzidoeo"])){ 
       $sql  .= $virgula." si126_codreduzidoeo = $this->si126_codreduzidoeo ";
       $virgula = ",";
       if(trim($this->si126_codreduzidoeo) == null ){ 
         $this->erro_sql = " Campo Código  identificador ExtraOrçamentária nao Informado.";
         $this->erro_campo = "si126_codreduzidoeo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si126_codreduzidoop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si126_codreduzidoop"])){ 
       $sql  .= $virgula." si126_codreduzidoop = $this->si126_codreduzidoop ";
       $virgula = ",";
       if(trim($this->si126_codreduzidoop) == null ){ 
         $this->erro_sql = " Campo Código  Identificador do  pagamento nao Informado.";
         $this->erro_campo = "si126_codreduzidoop";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si126_nroop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si126_nroop"])){ 
       $sql  .= $virgula." si126_nroop = $this->si126_nroop ";
       $virgula = ",";
       if(trim($this->si126_nroop) == null ){ 
         $this->erro_sql = " Campo Número da  Ordem de  Pagamento nao Informado.";
         $this->erro_campo = "si126_nroop";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si126_dtpagamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si126_dtpagamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si126_dtpagamento_dia"] !="") ){ 
       $sql  .= $virgula." si126_dtpagamento = '$this->si126_dtpagamento' ";
       $virgula = ",";
       if(trim($this->si126_dtpagamento) == null ){ 
         $this->erro_sql = " Campo Data de  pagamento da  OP nao Informado.";
         $this->erro_campo = "si126_dtpagamento_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["si126_dtpagamento_dia"])){ 
         $sql  .= $virgula." si126_dtpagamento = null ";
         $virgula = ",";
         if(trim($this->si126_dtpagamento) == null ){ 
           $this->erro_sql = " Campo Data de  pagamento da  OP nao Informado.";
           $this->erro_campo = "si126_dtpagamento_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si126_tipodocumentocredor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si126_tipodocumentocredor"])){ 
       $sql  .= $virgula." si126_tipodocumentocredor = $this->si126_tipodocumentocredor ";
       $virgula = ",";
       if(trim($this->si126_tipodocumentocredor) == null ){ 
         $this->erro_sql = " Campo Tipo de  Documento do  credor nao Informado.";
         $this->erro_campo = "si126_tipodocumentocredor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si126_nrodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si126_nrodocumento"])){ 
       $sql  .= $virgula." si126_nrodocumento = '$this->si126_nrodocumento' ";
       $virgula = ",";
       if(trim($this->si126_nrodocumento) == null ){ 
         $this->erro_sql = " Campo Número do documento do credor nao Informado.";
         $this->erro_campo = "si126_nrodocumento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si126_vlop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si126_vlop"])){ 
       $sql  .= $virgula." si126_vlop = $this->si126_vlop ";
       $virgula = ",";
       if(trim($this->si126_vlop) == null ){ 
         $this->erro_sql = " Campo Valor da OP nao Informado.";
         $this->erro_campo = "si126_vlop";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si126_especificacaoop)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si126_especificacaoop"])){ 
       $sql  .= $virgula." si126_especificacaoop = '$this->si126_especificacaoop' ";
       $virgula = ",";
       if(trim($this->si126_especificacaoop) == null ){ 
         $this->erro_sql = " Campo Especificação da  OP nao Informado.";
         $this->erro_campo = "si126_especificacaoop";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si126_cpfresppgto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si126_cpfresppgto"])){ 
       $sql  .= $virgula." si126_cpfresppgto = '$this->si126_cpfresppgto' ";
       $virgula = ",";
       if(trim($this->si126_cpfresppgto) == null ){ 
         $this->erro_sql = " Campo CPF do  responsável nao Informado.";
         $this->erro_campo = "si126_cpfresppgto";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si126_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si126_mes"])){ 
       $sql  .= $virgula." si126_mes = $this->si126_mes ";
       $virgula = ",";
       if(trim($this->si126_mes) == null ){ 
         $this->erro_sql = " Campo Mês nao Informado.";
         $this->erro_campo = "si126_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si126_reg10)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si126_reg10"])){ 
       $sql  .= $virgula." si126_reg10 = $this->si126_reg10 ";
       $virgula = ",";
       if(trim($this->si126_reg10) == null ){ 
         $this->erro_sql = " Campo reg10 nao Informado.";
         $this->erro_campo = "si126_reg10";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si126_sequencial!=null){
       $sql .= " si126_sequencial = $this->si126_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si126_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010865,'$this->si126_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si126_sequencial"]) || $this->si126_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010355,2010865,'".AddSlashes(pg_result($resaco,$conresaco,'si126_sequencial'))."','$this->si126_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si126_tiporegistro"]) || $this->si126_tiporegistro != "")
           $resac = db_query("insert into db_acount values($acount,2010355,2010866,'".AddSlashes(pg_result($resaco,$conresaco,'si126_tiporegistro'))."','$this->si126_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si126_codreduzidoeo"]) || $this->si126_codreduzidoeo != "")
           $resac = db_query("insert into db_acount values($acount,2010355,2010867,'".AddSlashes(pg_result($resaco,$conresaco,'si126_codreduzidoeo'))."','$this->si126_codreduzidoeo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si126_codreduzidoop"]) || $this->si126_codreduzidoop != "")
           $resac = db_query("insert into db_acount values($acount,2010355,2010868,'".AddSlashes(pg_result($resaco,$conresaco,'si126_codreduzidoop'))."','$this->si126_codreduzidoop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si126_nroop"]) || $this->si126_nroop != "")
           $resac = db_query("insert into db_acount values($acount,2010355,2010869,'".AddSlashes(pg_result($resaco,$conresaco,'si126_nroop'))."','$this->si126_nroop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si126_dtpagamento"]) || $this->si126_dtpagamento != "")
           $resac = db_query("insert into db_acount values($acount,2010355,2010870,'".AddSlashes(pg_result($resaco,$conresaco,'si126_dtpagamento'))."','$this->si126_dtpagamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si126_tipodocumentocredor"]) || $this->si126_tipodocumentocredor != "")
           $resac = db_query("insert into db_acount values($acount,2010355,2010871,'".AddSlashes(pg_result($resaco,$conresaco,'si126_tipodocumentocredor'))."','$this->si126_tipodocumentocredor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si126_nrodocumento"]) || $this->si126_nrodocumento != "")
           $resac = db_query("insert into db_acount values($acount,2010355,2010872,'".AddSlashes(pg_result($resaco,$conresaco,'si126_nrodocumento'))."','$this->si126_nrodocumento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si126_vlop"]) || $this->si126_vlop != "")
           $resac = db_query("insert into db_acount values($acount,2010355,2010873,'".AddSlashes(pg_result($resaco,$conresaco,'si126_vlop'))."','$this->si126_vlop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si126_especificacaoop"]) || $this->si126_especificacaoop != "")
           $resac = db_query("insert into db_acount values($acount,2010355,2010874,'".AddSlashes(pg_result($resaco,$conresaco,'si126_especificacaoop'))."','$this->si126_especificacaoop',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si126_cpfresppgto"]) || $this->si126_cpfresppgto != "")
           $resac = db_query("insert into db_acount values($acount,2010355,2010875,'".AddSlashes(pg_result($resaco,$conresaco,'si126_cpfresppgto'))."','$this->si126_cpfresppgto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si126_mes"]) || $this->si126_mes != "")
           $resac = db_query("insert into db_acount values($acount,2010355,2010876,'".AddSlashes(pg_result($resaco,$conresaco,'si126_mes'))."','$this->si126_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si126_reg10"]) || $this->si126_reg10 != "")
           $resac = db_query("insert into db_acount values($acount,2010355,2010877,'".AddSlashes(pg_result($resaco,$conresaco,'si126_reg10'))."','$this->si126_reg10',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ext122014 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si126_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ext122014 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si126_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si126_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si126_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si126_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2010865,'$si126_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010355,2010865,'','".AddSlashes(pg_result($resaco,$iresaco,'si126_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010355,2010866,'','".AddSlashes(pg_result($resaco,$iresaco,'si126_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010355,2010867,'','".AddSlashes(pg_result($resaco,$iresaco,'si126_codreduzidoeo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010355,2010868,'','".AddSlashes(pg_result($resaco,$iresaco,'si126_codreduzidoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010355,2010869,'','".AddSlashes(pg_result($resaco,$iresaco,'si126_nroop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010355,2010870,'','".AddSlashes(pg_result($resaco,$iresaco,'si126_dtpagamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010355,2010871,'','".AddSlashes(pg_result($resaco,$iresaco,'si126_tipodocumentocredor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010355,2010872,'','".AddSlashes(pg_result($resaco,$iresaco,'si126_nrodocumento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010355,2010873,'','".AddSlashes(pg_result($resaco,$iresaco,'si126_vlop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010355,2010874,'','".AddSlashes(pg_result($resaco,$iresaco,'si126_especificacaoop'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010355,2010875,'','".AddSlashes(pg_result($resaco,$iresaco,'si126_cpfresppgto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010355,2010876,'','".AddSlashes(pg_result($resaco,$iresaco,'si126_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010355,2010877,'','".AddSlashes(pg_result($resaco,$iresaco,'si126_reg10'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ext122014
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si126_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si126_sequencial = $si126_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "ext122014 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si126_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "ext122014 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si126_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si126_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:ext122014";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si126_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ext122014 ";
     $sql .= "      inner join ext102014  on  ext102014.si124_sequencial = ext122014.si126_reg10";
     $sql2 = "";
     if($dbwhere==""){
       if($si126_sequencial!=null ){
         $sql2 .= " where ext122014.si126_sequencial = $si126_sequencial "; 
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
   function sql_query_file ( $si126_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from ext122014 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si126_sequencial!=null ){
         $sql2 .= " where ext122014.si126_sequencial = $si126_sequencial "; 
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
