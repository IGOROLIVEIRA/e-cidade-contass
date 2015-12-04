<?
//MODULO: caixa
//CLASSE DA ENTIDADE ordembancariapagamento
class cl_ordembancariapagamento { 
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
   var $k00_codseqpag = 0; 
   var $k00_codordembancaria = 0; 
   var $k00_codord = 0; 
   var $k00_cgmfornec = 0; 
   var $k00_valorpag = 0; 
   var $k00_contabanco = 0; 
   var $k00_slip = 0; 
   var $k00_formapag = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 k00_codseqpag = int8 = Codigo Sequencial 
                 k00_codordembancaria = int8 = Codigo Ordem 
                 k00_codord = int8 = Codigo Ord 
                 k00_cgmfornec = int8 = Codigo Fornecedor 
                 k00_valorpag = float8 = Valor Pagamento 
                 k00_contabanco = int8 = Conta Banco 
                 k00_slip = int8 = Slip 
                 k00_formapag = varchar(50) = Forma de Pagamento 
                 ";
   //funcao construtor da classe 
   function cl_ordembancariapagamento() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("ordembancariapagamento"); 
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
       $this->k00_codseqpag = ($this->k00_codseqpag == ""?@$GLOBALS["HTTP_POST_VARS"]["k00_codseqpag"]:$this->k00_codseqpag);
       $this->k00_codordembancaria = ($this->k00_codordembancaria == ""?@$GLOBALS["HTTP_POST_VARS"]["k00_codordembancaria"]:$this->k00_codordembancaria);
       $this->k00_codord = ($this->k00_codord == ""?@$GLOBALS["HTTP_POST_VARS"]["k00_codord"]:$this->k00_codord);
       $this->k00_cgmfornec = ($this->k00_cgmfornec == ""?@$GLOBALS["HTTP_POST_VARS"]["k00_cgmfornec"]:$this->k00_cgmfornec);
       $this->k00_valorpag = ($this->k00_valorpag == ""?@$GLOBALS["HTTP_POST_VARS"]["k00_valorpag"]:$this->k00_valorpag);
       $this->k00_contabanco = ($this->k00_contabanco == ""?@$GLOBALS["HTTP_POST_VARS"]["k00_contabanco"]:$this->k00_contabanco);
       $this->k00_slip = ($this->k00_slip == ""?@$GLOBALS["HTTP_POST_VARS"]["k00_slip"]:$this->k00_slip);
       $this->k00_formapag = ($this->k00_formapag == ""?@$GLOBALS["HTTP_POST_VARS"]["k00_formapag"]:$this->k00_formapag);
     }else{
       $this->k00_codseqpag = ($this->k00_codseqpag == ""?@$GLOBALS["HTTP_POST_VARS"]["k00_codseqpag"]:$this->k00_codseqpag);
     }
   }
   // funcao para inclusao
   function incluir ($k00_codseqpag){ 
      $this->atualizacampos();
     if($this->k00_codordembancaria == null ){ 
       $this->erro_sql = " Campo Codigo Ordem nao Informado.";
       $this->erro_campo = "k00_codordembancaria";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k00_codord == null ){ 
       $this->erro_sql = " Campo Codigo Ord nao Informado.";
       $this->erro_campo = "k00_codord";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k00_cgmfornec == null ){ 
       $this->erro_sql = " Campo Codigo Fornecedor nao Informado.";
       $this->erro_campo = "k00_cgmfornec";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k00_valorpag == null ){ 
       $this->erro_sql = " Campo Valor Pagamento nao Informado.";
       $this->erro_campo = "k00_valorpag";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k00_contabanco == null ){ 
       $this->erro_sql = " Campo Conta Banco nao Informado.";
       $this->erro_campo = "k00_contabanco";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k00_slip == null ){ 
       $this->erro_sql = " Campo Slip nao Informado.";
       $this->erro_campo = "k00_slip";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->k00_codseqpag = $k00_codseqpag; 
     if(($this->k00_codseqpag == null) || ($this->k00_codseqpag == "") ){ 
       $this->erro_sql = " Campo k00_codseqpag nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into ordembancariapagamento(
                                       k00_codseqpag 
                                      ,k00_codordembancaria 
                                      ,k00_codord 
                                      ,k00_cgmfornec 
                                      ,k00_valorpag 
                                      ,k00_contabanco 
                                      ,k00_slip 
                                      ,k00_formapag 
                       )
                values (
                                $this->k00_codseqpag 
                               ,$this->k00_codordembancaria 
                               ,$this->k00_codord 
                               ,$this->k00_cgmfornec 
                               ,$this->k00_valorpag 
                               ,$this->k00_contabanco 
                               ,$this->k00_slip 
                               ,'$this->k00_formapag' 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Ordem Bancaria Pagamento ($this->k00_codseqpag) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Ordem Bancaria Pagamento já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Ordem Bancaria Pagamento ($this->k00_codseqpag) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k00_codseqpag;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->k00_codseqpag));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009335,'$this->k00_codseqpag','I')");
       $resac = db_query("insert into db_acount values($acount,2010208,2009335,'','".AddSlashes(pg_result($resaco,0,'k00_codseqpag'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010208,2009328,'','".AddSlashes(pg_result($resaco,0,'k00_codordembancaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010208,2009329,'','".AddSlashes(pg_result($resaco,0,'k00_codord'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010208,2009330,'','".AddSlashes(pg_result($resaco,0,'k00_cgmfornec'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010208,2009336,'','".AddSlashes(pg_result($resaco,0,'k00_valorpag'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010208,2009332,'','".AddSlashes(pg_result($resaco,0,'k00_contabanco'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010208,2009333,'','".AddSlashes(pg_result($resaco,0,'k00_slip'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010208,2009334,'','".AddSlashes(pg_result($resaco,0,'k00_formapag'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($k00_codseqpag=null) { 
      $this->atualizacampos();
     $sql = " update ordembancariapagamento set ";
     $virgula = "";
     if(trim($this->k00_codseqpag)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k00_codseqpag"])){ 
       $sql  .= $virgula." k00_codseqpag = $this->k00_codseqpag ";
       $virgula = ",";
       if(trim($this->k00_codseqpag) == null ){ 
         $this->erro_sql = " Campo Codigo Sequencial nao Informado.";
         $this->erro_campo = "k00_codseqpag";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k00_codordembancaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k00_codordembancaria"])){ 
       $sql  .= $virgula." k00_codordembancaria = $this->k00_codordembancaria ";
       $virgula = ",";
       if(trim($this->k00_codordembancaria) == null ){ 
         $this->erro_sql = " Campo Codigo Ordem nao Informado.";
         $this->erro_campo = "k00_codordembancaria";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k00_codord)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k00_codord"])){ 
       $sql  .= $virgula." k00_codord = $this->k00_codord ";
       $virgula = ",";
       if(trim($this->k00_codord) == null ){ 
         $this->erro_sql = " Campo Codigo Ord nao Informado.";
         $this->erro_campo = "k00_codord";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k00_cgmfornec)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k00_cgmfornec"])){ 
       $sql  .= $virgula." k00_cgmfornec = $this->k00_cgmfornec ";
       $virgula = ",";
       if(trim($this->k00_cgmfornec) == null ){ 
         $this->erro_sql = " Campo Codigo Fornecedor nao Informado.";
         $this->erro_campo = "k00_cgmfornec";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k00_valorpag)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k00_valorpag"])){ 
       $sql  .= $virgula." k00_valorpag = $this->k00_valorpag ";
       $virgula = ",";
       if(trim($this->k00_valorpag) == null ){ 
         $this->erro_sql = " Campo Valor Pagamento nao Informado.";
         $this->erro_campo = "k00_valorpag";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k00_contabanco)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k00_contabanco"])){ 
       $sql  .= $virgula." k00_contabanco = $this->k00_contabanco ";
       $virgula = ",";
       if(trim($this->k00_contabanco) == null ){ 
         $this->erro_sql = " Campo Conta Banco nao Informado.";
         $this->erro_campo = "k00_contabanco";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k00_slip)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k00_slip"])){ 
       $sql  .= $virgula." k00_slip = $this->k00_slip ";
       $virgula = ",";
       if(trim($this->k00_slip) == null ){ 
         $this->erro_sql = " Campo Slip nao Informado.";
         $this->erro_campo = "k00_slip";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k00_formapag)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k00_formapag"])){ 
       $sql  .= $virgula." k00_formapag = '$this->k00_formapag' ";
       $virgula = ",";
     }
     $sql .= " where ";
     if($k00_codseqpag!=null){
       $sql .= " k00_codseqpag = $this->k00_codseqpag";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->k00_codseqpag));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009335,'$this->k00_codseqpag','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k00_codseqpag"]) || $this->k00_codseqpag != "")
           $resac = db_query("insert into db_acount values($acount,2010208,2009335,'".AddSlashes(pg_result($resaco,$conresaco,'k00_codseqpag'))."','$this->k00_codseqpag',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k00_codordembancaria"]) || $this->k00_codordembancaria != "")
           $resac = db_query("insert into db_acount values($acount,2010208,2009328,'".AddSlashes(pg_result($resaco,$conresaco,'k00_codordembancaria'))."','$this->k00_codordembancaria',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k00_codord"]) || $this->k00_codord != "")
           $resac = db_query("insert into db_acount values($acount,2010208,2009329,'".AddSlashes(pg_result($resaco,$conresaco,'k00_codord'))."','$this->k00_codord',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k00_cgmfornec"]) || $this->k00_cgmfornec != "")
           $resac = db_query("insert into db_acount values($acount,2010208,2009330,'".AddSlashes(pg_result($resaco,$conresaco,'k00_cgmfornec'))."','$this->k00_cgmfornec',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k00_valorpag"]) || $this->k00_valorpag != "")
           $resac = db_query("insert into db_acount values($acount,2010208,2009336,'".AddSlashes(pg_result($resaco,$conresaco,'k00_valorpag'))."','$this->k00_valorpag',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k00_contabanco"]) || $this->k00_contabanco != "")
           $resac = db_query("insert into db_acount values($acount,2010208,2009332,'".AddSlashes(pg_result($resaco,$conresaco,'k00_contabanco'))."','$this->k00_contabanco',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k00_slip"]) || $this->k00_slip != "")
           $resac = db_query("insert into db_acount values($acount,2010208,2009333,'".AddSlashes(pg_result($resaco,$conresaco,'k00_slip'))."','$this->k00_slip',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["k00_formapag"]) || $this->k00_formapag != "")
           $resac = db_query("insert into db_acount values($acount,2010208,2009334,'".AddSlashes(pg_result($resaco,$conresaco,'k00_formapag'))."','$this->k00_formapag',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Ordem Bancaria Pagamento nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->k00_codseqpag;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Ordem Bancaria Pagamento nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->k00_codseqpag;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k00_codseqpag;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($k00_codseqpag=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($k00_codseqpag));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009335,'$k00_codseqpag','E')");
         $resac = db_query("insert into db_acount values($acount,2010208,2009335,'','".AddSlashes(pg_result($resaco,$iresaco,'k00_codseqpag'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010208,2009328,'','".AddSlashes(pg_result($resaco,$iresaco,'k00_codordembancaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010208,2009329,'','".AddSlashes(pg_result($resaco,$iresaco,'k00_codord'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010208,2009330,'','".AddSlashes(pg_result($resaco,$iresaco,'k00_cgmfornec'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010208,2009336,'','".AddSlashes(pg_result($resaco,$iresaco,'k00_valorpag'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010208,2009332,'','".AddSlashes(pg_result($resaco,$iresaco,'k00_contabanco'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010208,2009333,'','".AddSlashes(pg_result($resaco,$iresaco,'k00_slip'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010208,2009334,'','".AddSlashes(pg_result($resaco,$iresaco,'k00_formapag'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from ordembancariapagamento
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($k00_codseqpag != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " k00_codseqpag = $k00_codseqpag ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Ordem Bancaria Pagamento nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$k00_codseqpag;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Ordem Bancaria Pagamento nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$k00_codseqpag;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$k00_codseqpag;
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
        $this->erro_sql   = "Record Vazio na Tabela:ordembancariapagamento";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $k00_codseqpag=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from ordembancariapagamento join ordembancaria on k00_codordembancaria = k00_codigo";
     $sql2 = "";
     if($dbwhere==""){
       if($k00_codseqpag!=null ){
         $sql2 .= " where ordembancariapagamento.k00_codseqpag = $k00_codseqpag "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
   // funcao do sql 
   function sql_query_file ( $k00_codseqpag=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from ordembancariapagamento ";
     $sql2 = "";
     if($dbwhere==""){
       if($k00_codseqpag!=null ){
         $sql2 .= " where ordembancariapagamento.k00_codseqpag = $k00_codseqpag "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
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
