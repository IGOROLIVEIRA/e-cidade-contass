<?
//MODULO: orcamento
//CLASSE DA ENTIDADE orcalteracaopercloa
class cl_orcalteracaopercloa { 
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
   var $o201_sequencial = 0; 
   var $o201_orcprojetolei = 0; 
   var $o201_tipoleialteracao = 0; 
   var $o201_artleialteracao = null; 
   var $o201_descrartigo = null; 
   var $o201_percautorizado = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 o201_sequencial = int8 = Código Sequencial 
                 o201_orcprojetolei = float8 = Código do Projeto de Lei 
                 o201_tipoleialteracao = int8 = Tipo de Alteração 
                 o201_artleialteracao = varchar(6) = Artigo da Lei de Alteração 
                 o201_descrartigo = text = Descrição Artigo 
                 o201_percautorizado = float8 = Percentual Autorizado 
                 ";
   //funcao construtor da classe 
   function cl_orcalteracaopercloa() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("orcalteracaopercloa"); 
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
       $this->o201_sequencial = ($this->o201_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["o201_sequencial"]:$this->o201_sequencial);
       $this->o201_orcprojetolei = ($this->o201_orcprojetolei == ""?@$GLOBALS["HTTP_POST_VARS"]["o201_orcprojetolei"]:$this->o201_orcprojetolei);
       $this->o201_tipoleialteracao = ($this->o201_tipoleialteracao == ""?@$GLOBALS["HTTP_POST_VARS"]["o201_tipoleialteracao"]:$this->o201_tipoleialteracao);
       $this->o201_artleialteracao = ($this->o201_artleialteracao == ""?@$GLOBALS["HTTP_POST_VARS"]["o201_artleialteracao"]:$this->o201_artleialteracao);
       $this->o201_descrartigo = ($this->o201_descrartigo == ""?@$GLOBALS["HTTP_POST_VARS"]["o201_descrartigo"]:$this->o201_descrartigo);
       $this->o201_percautorizado = ($this->o201_percautorizado == ""?@$GLOBALS["HTTP_POST_VARS"]["o201_percautorizado"]:$this->o201_percautorizado);
     }else{
       $this->o201_sequencial = ($this->o201_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["o201_sequencial"]:$this->o201_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($o201_sequencial){ 
      $this->atualizacampos();
     if($this->o201_orcprojetolei == null ){ 
       $this->erro_sql = " Campo Código do Projeto de Lei nao Informado.";
       $this->erro_campo = "o201_orcprojetolei";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o201_tipoleialteracao == null ){ 
       $this->erro_sql = " Campo Tipo de Alteração nao Informado.";
       $this->erro_campo = "o201_tipoleialteracao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o201_artleialteracao == null ){ 
       $this->erro_sql = " Campo Artigo da Lei de Alteração nao Informado.";
       $this->erro_campo = "o201_artleialteracao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o201_descrartigo == null ){ 
       $this->erro_sql = " Campo Descrição Artigo nao Informado.";
       $this->erro_campo = "o201_descrartigo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o201_percautorizado == null ){ 
       $this->erro_sql = " Campo Percentual Autorizado nao Informado.";
       $this->erro_campo = "o201_percautorizado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($o201_sequencial == "" || $o201_sequencial == null ){
       $result = db_query("select nextval('orcalteracaopercloa_o201_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: orcalteracaopercloa_o201_sequencial_seq do campo: o201_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->o201_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from orcalteracaopercloa_o201_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $o201_sequencial)){
         $this->erro_sql = " Campo o201_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->o201_sequencial = $o201_sequencial; 
       }
     }
     if(($this->o201_sequencial == null) || ($this->o201_sequencial == "") ){ 
       $this->erro_sql = " Campo o201_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into orcalteracaopercloa(
                                       o201_sequencial 
                                      ,o201_orcprojetolei 
                                      ,o201_tipoleialteracao 
                                      ,o201_artleialteracao 
                                      ,o201_descrartigo 
                                      ,o201_percautorizado 
                       )
                values (
                                $this->o201_sequencial 
                               ,$this->o201_orcprojetolei 
                               ,$this->o201_tipoleialteracao 
                               ,'$this->o201_artleialteracao' 
                               ,'$this->o201_descrartigo' 
                               ,$this->o201_percautorizado 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Alteração de Percentua da LOA ($this->o201_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Alteração de Percentua da LOA já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Alteração de Percentua da LOA ($this->o201_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o201_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->o201_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011297,'$this->o201_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010395,2011297,'','".AddSlashes(pg_result($resaco,0,'o201_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010395,2011293,'','".AddSlashes(pg_result($resaco,0,'o201_orcprojetolei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010395,2011294,'','".AddSlashes(pg_result($resaco,0,'o201_tipoleialteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010395,2011295,'','".AddSlashes(pg_result($resaco,0,'o201_artleialteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010395,2011296,'','".AddSlashes(pg_result($resaco,0,'o201_descrartigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010395,2011292,'','".AddSlashes(pg_result($resaco,0,'o201_percautorizado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($o201_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update orcalteracaopercloa set ";
     $virgula = "";
     if(trim($this->o201_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o201_sequencial"])){ 
       $sql  .= $virgula." o201_sequencial = $this->o201_sequencial ";
       $virgula = ",";
       if(trim($this->o201_sequencial) == null ){ 
         $this->erro_sql = " Campo Código Sequencial nao Informado.";
         $this->erro_campo = "o201_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o201_orcprojetolei)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o201_orcprojetolei"])){ 
       $sql  .= $virgula." o201_orcprojetolei = $this->o201_orcprojetolei ";
       $virgula = ",";
       if(trim($this->o201_orcprojetolei) == null ){ 
         $this->erro_sql = " Campo Código do Projeto de Lei nao Informado.";
         $this->erro_campo = "o201_orcprojetolei";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o201_tipoleialteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o201_tipoleialteracao"])){ 
       $sql  .= $virgula." o201_tipoleialteracao = $this->o201_tipoleialteracao ";
       $virgula = ",";
       if(trim($this->o201_tipoleialteracao) == null ){ 
         $this->erro_sql = " Campo Tipo de Alteração nao Informado.";
         $this->erro_campo = "o201_tipoleialteracao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o201_artleialteracao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o201_artleialteracao"])){ 
       $sql  .= $virgula." o201_artleialteracao = '$this->o201_artleialteracao' ";
       $virgula = ",";
       if(trim($this->o201_artleialteracao) == null ){ 
         $this->erro_sql = " Campo Artigo da Lei de Alteração nao Informado.";
         $this->erro_campo = "o201_artleialteracao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o201_descrartigo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o201_descrartigo"])){ 
       $sql  .= $virgula." o201_descrartigo = '$this->o201_descrartigo' ";
       $virgula = ",";
       if(trim($this->o201_descrartigo) == null ){ 
         $this->erro_sql = " Campo Descrição Artigo nao Informado.";
         $this->erro_campo = "o201_descrartigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o201_percautorizado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o201_percautorizado"])){ 
       $sql  .= $virgula." o201_percautorizado = $this->o201_percautorizado ";
       $virgula = ",";
       if(trim($this->o201_percautorizado) == null ){ 
         $this->erro_sql = " Campo Percentual Autorizado nao Informado.";
         $this->erro_campo = "o201_percautorizado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($o201_sequencial!=null){
       $sql .= " o201_sequencial = $this->o201_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->o201_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011297,'$this->o201_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o201_sequencial"]) || $this->o201_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010395,2011297,'".AddSlashes(pg_result($resaco,$conresaco,'o201_sequencial'))."','$this->o201_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o201_orcprojetolei"]) || $this->o201_orcprojetolei != "")
           $resac = db_query("insert into db_acount values($acount,2010395,2011293,'".AddSlashes(pg_result($resaco,$conresaco,'o201_orcprojetolei'))."','$this->o201_orcprojetolei',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o201_tipoleialteracao"]) || $this->o201_tipoleialteracao != "")
           $resac = db_query("insert into db_acount values($acount,2010395,2011294,'".AddSlashes(pg_result($resaco,$conresaco,'o201_tipoleialteracao'))."','$this->o201_tipoleialteracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o201_artleialteracao"]) || $this->o201_artleialteracao != "")
           $resac = db_query("insert into db_acount values($acount,2010395,2011295,'".AddSlashes(pg_result($resaco,$conresaco,'o201_artleialteracao'))."','$this->o201_artleialteracao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o201_descrartigo"]) || $this->o201_descrartigo != "")
           $resac = db_query("insert into db_acount values($acount,2010395,2011296,'".AddSlashes(pg_result($resaco,$conresaco,'o201_descrartigo'))."','$this->o201_descrartigo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["o201_percautorizado"]) || $this->o201_percautorizado != "")
           $resac = db_query("insert into db_acount values($acount,2010395,2011292,'".AddSlashes(pg_result($resaco,$conresaco,'o201_percautorizado'))."','$this->o201_percautorizado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Alteração de Percentua da LOA nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->o201_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Alteração de Percentua da LOA nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->o201_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o201_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($o201_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($o201_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011297,'$o201_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010395,2011297,'','".AddSlashes(pg_result($resaco,$iresaco,'o201_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010395,2011293,'','".AddSlashes(pg_result($resaco,$iresaco,'o201_orcprojetolei'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010395,2011294,'','".AddSlashes(pg_result($resaco,$iresaco,'o201_tipoleialteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010395,2011295,'','".AddSlashes(pg_result($resaco,$iresaco,'o201_artleialteracao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010395,2011296,'','".AddSlashes(pg_result($resaco,$iresaco,'o201_descrartigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010395,2011292,'','".AddSlashes(pg_result($resaco,$iresaco,'o201_percautorizado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from orcalteracaopercloa
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($o201_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " o201_sequencial = $o201_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Alteração de Percentua da LOA nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$o201_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Alteração de Percentua da LOA nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$o201_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$o201_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:orcalteracaopercloa";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $o201_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcalteracaopercloa ";
     $sql .= "      inner join orcprojetolei  on  orcprojetolei.o138_sequencial = orcalteracaopercloa.o201_orcprojetolei";
     $sql .= "      inner join db_config  on  db_config.codigo = orcprojetolei.o138_instit";
     $sql2 = "";
     if($dbwhere==""){
       if($o201_sequencial!=null ){
         $sql2 .= " where orcalteracaopercloa.o201_sequencial = $o201_sequencial "; 
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
   function sql_query_file ( $o201_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcalteracaopercloa ";
     $sql2 = "";
     if($dbwhere==""){
       if($o201_sequencial!=null ){
         $sql2 .= " where orcalteracaopercloa.o201_sequencial = $o201_sequencial "; 
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
