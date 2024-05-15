<?
//MODULO: licitacao
//CLASSE DA ENTIDADE licpregaocgm
class cl_licpregaocgm { 
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
   var $l46_sequencial = 0; 
   var $l46_tipo = 0; 
   var $l46_numcgm = 0;  
   var $l46_licpregao = 0;
   var $l46_naturezacargo = 0;
   var $l46_cargo  = 0;
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 l46_sequencial = int8 = Sequencial 
                 l46_tipo = int8 = Tipo 
                 l46_numcgm = int8 = Nº Cgm Participante da Comissão 
                 l46_licpregao = int8 = Código Licitação
                 l46_naturezacargo	= int8 = Natureza Cargo
				 l46_cargo = varchar(50) = Cargo
                 ";
   //funcao construtor da classe 
   function cl_licpregaocgm() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("licpregaocgm"); 
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
       $this->l46_sequencial = ($this->l46_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l46_sequencial"]:$this->l46_sequencial);
       $this->l46_tipo = ($this->l46_tipo == ""?@$GLOBALS["HTTP_POST_VARS"]["l46_tipo"]:$this->l46_tipo);
       $this->l46_numcgm = ($this->l46_numcgm == ""?@$GLOBALS["HTTP_POST_VARS"]["l46_numcgm"]:$this->l46_numcgm);
       $this->l46_licpregao = ($this->l46_licpregao == ""?@$GLOBALS["HTTP_POST_VARS"]["l46_licpregao"]:$this->l46_licpregao);
       $this->l46_cargo  = ($this->l46_cargo  == ""?@$GLOBALS["HTTP_POST_VARS"]["l46_cargo"]:$this->l46_cargo );
       $this->l46_naturezacargo  = ($this->l46_naturezacargo  == ""?@$GLOBALS["HTTP_POST_VARS"]["l46_naturezacargo"]:$this->l46_naturezacargo );
     }else{
       $this->l46_sequencial = ($this->l46_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l46_sequencial"]:$this->l46_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($l46_sequencial){ //l45_sequencial
      $this->atualizacampos();
     if($this->l46_tipo == null ){ 
       $this->erro_sql = " Campo Tipo nao Informado.";
       $this->erro_campo = "l46_tipo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l46_numcgm == null ){ 
       $this->erro_sql = " Campo Nº Cgm Participante da Comissão nao Informado.";
       $this->erro_campo = "l46_numcgm";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     /*if($this->l46_licpregao == null ){ 
       $this->erro_sql = " Campo Código Licitação nao Informado.";
       $this->erro_campo = "l46_licpregao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }*/
      
    if($this->l46_cargo  == null ){ 
       $this->erro_sql = " Campo Cargo  nao Informado.";
       $this->erro_campo = "l46_cargo ";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
    if($this->l46_naturezacargo == null ){ 
       $this->erro_sql = " Campo Natureza Cargo nao Informado.";
       $this->erro_campo = "l46_naturezacargo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     
     
    if($l46_sequencial == "" || $l46_sequencial == null ){
       $result = db_query("select nextval('licpregaocgm_l46_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: licpregaocgm_l46_sequencial_seq do campo:l46_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       } 
       $this->l46_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from licpregaocgm_l46_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $l46_sequencial)){
         $this->erro_sql = " Campo l46_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->l46_sequencial = $l46_sequencial; 
       }
     }
     if(($this->l46_sequencial == null) || ($this->l46_sequencial == "") ){ 
       $this->erro_sql = " Campo l46_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
    
     $sql = "insert into licpregaocgm(
                                       l46_sequencial 
                                      ,l46_tipo 
                                      ,l46_numcgm 
                                      ,l46_licpregao 
                                      ,l46_naturezacargo	
                                      ,l46_cargo 
                       )
                values (
                                $this->l46_sequencial 
                               ,$this->l46_tipo 
                               ,$this->l46_numcgm 
                               ,$this->l46_licpregao 
                               ,$this->l46_naturezacargo	
                               ,'$this->l46_cargo' 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "licpregaocgm ($this->l46_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "licpregaocgm já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "licpregaocgm ($this->l46_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l46_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->l46_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009534,'$this->l46_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010236,2009534,'','".AddSlashes(pg_result($resaco,0,'l46_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010236,2009537,'','".AddSlashes(pg_result($resaco,0,'l46_tipo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010236,2009536,'','".AddSlashes(pg_result($resaco,0,'l46_numcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010236,2009538,'','".AddSlashes(pg_result($resaco,0,'l46_licpregao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($l46_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update licpregaocgm set ";
     $virgula = "";
     if(trim($this->l46_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l46_sequencial"])){ 
       $sql  .= $virgula." l46_sequencial = $this->l46_sequencial ";
       $virgula = ",";
       if(trim($this->l46_sequencial) == null ){ 
         $this->erro_sql = " Campo Sequencial nao Informado.";
         $this->erro_campo = "l46_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l46_tipo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l46_tipo"])){ 
       $sql  .= $virgula." l46_tipo = $this->l46_tipo ";
       $virgula = ",";
       if(trim($this->l46_tipo) == null ){ 
         $this->erro_sql = " Campo Tipo nao Informado.";
         $this->erro_campo = "l46_tipo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l46_numcgm)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l46_numcgm"])){ 
       $sql  .= $virgula." l46_numcgm = $this->l46_numcgm ";
       $virgula = ",";
       if(trim($this->l46_numcgm) == null ){ 
         $this->erro_sql = " Campo Nº Cgm Participante da Comissão nao Informado.";
         $this->erro_campo = "l46_numcgm";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     
     if(trim($this->l46_licpregao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l46_licpregao"])){ 
       $sql  .= $virgula." l46_licpregao = $this->l46_licpregao ";
       $virgula = ",";
       if(trim($this->l46_licpregao) == null ){ 
         $this->erro_sql = " Campo Código Licitação nao Informado.";
         $this->erro_campo = "l46_licpregao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     
   if(trim($this->l46_naturezacargo	)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l46_naturezacargo	"])){ 
       $sql  .= $virgula." l46_naturezacargo	 = $this->l46_naturezacargo	 ";
       $virgula = ",";
       if(trim($this->l46_naturezacargo	) == null ){ 
         $this->erro_sql = " Campo Natureza Cargo	 nao Informado.";
         $this->erro_campo = "l46_naturezacargo	";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     
   if(trim($this->l46_cargo )!="" || isset($GLOBALS["HTTP_POST_VARS"]["l46_cargo "])){ 
       $sql  .= $virgula." l46_cargo  = '$this->l46_cargo'  ";
       $virgula = ",";
       if(trim($this->l46_cargo ) == null ){ 
         $this->erro_sql = " Campo Cargo  nao Informado.";
         $this->erro_campo = "l46_cargo ";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     
     
     
     
     $sql .= " where ";
     if($l46_sequencial!=null){
       $sql .= " l46_sequencial = $this->l46_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->l46_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009534,'$this->l46_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l46_sequencial"]) || $this->l46_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010236,2009534,'".AddSlashes(pg_result($resaco,$conresaco,'l46_sequencial'))."','$this->l46_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l46_tipo"]) || $this->l46_tipo != "")
           $resac = db_query("insert into db_acount values($acount,2010236,2009537,'".AddSlashes(pg_result($resaco,$conresaco,'l46_tipo'))."','$this->l46_tipo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l46_numcgm"]) || $this->l46_numcgm != "")
           $resac = db_query("insert into db_acount values($acount,2010236,2009536,'".AddSlashes(pg_result($resaco,$conresaco,'l46_numcgm'))."','$this->l46_numcgm',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l46_licpregao"]) || $this->l46_licpregao != "")
           $resac = db_query("insert into db_acount values($acount,2010236,2009538,'".AddSlashes(pg_result($resaco,$conresaco,'l46_licpregao'))."','$this->l46_licpregao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "licpregaocgm nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->l46_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "licpregaocgm nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->l46_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l46_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($l46_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($l46_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009534,'$l46_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010236,2009534,'','".AddSlashes(pg_result($resaco,$iresaco,'l46_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010236,2009537,'','".AddSlashes(pg_result($resaco,$iresaco,'l46_tipo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010236,2009536,'','".AddSlashes(pg_result($resaco,$iresaco,'l46_numcgm'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010236,2009538,'','".AddSlashes(pg_result($resaco,$iresaco,'l46_licpregao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from licpregaocgm
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($l46_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " l46_sequencial = $l46_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "licpregaocgm nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$l46_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "licpregaocgm nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$l46_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$l46_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:licpregaocgm";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $l46_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from licpregaocgm ";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = licpregaocgm.l46_numcgm";
     $sql .= "      inner join licpregao  on  licpregao.l45_sequencial = licpregaocgm.l46_licpregao";
     $sql2 = "";
     if($dbwhere==""){
       if($l46_sequencial!=null ){
         $sql2 .= " where licpregaocgm.l46_sequencial = $l46_sequencial "; 
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
   function sql_query_file ( $l46_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){  
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
     $sql .= " from licpregaocgm ";
     $sql2 = "";
     if($dbwhere==""){
       if($l46_sequencial!=null ){
         $sql2 .= " where licpregaocgm.l46_sequencial = $l46_sequencial "; 
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
     }//echo $sql;exit; //select * from licpregaocgm where l46_licpregao=2
     return $sql;
  }
}
?>
