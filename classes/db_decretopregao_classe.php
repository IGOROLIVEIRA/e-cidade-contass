<?
//MODULO: licitacao
//CLASSE DA ENTIDADE decretopregao
class cl_decretopregao { 
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
   var $l201_sequencial = 0; 
   var $l201_numdecreto = 0; 
   var $l201_datadecreto_dia = null; 
   var $l201_datadecreto_mes = null; 
   var $l201_datadecreto_ano = null; 
   var $l201_datadecreto = null; 
   var $l201_datapublicacao_dia = null; 
   var $l201_datapublicacao_mes = null; 
   var $l201_datapublicacao_ano = null; 
   var $l201_datapublicacao = null; 
   var $l201_tipodecreto = 0; 
   var $l201_instit = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 l201_sequencial = int8 = Código Sequencial 
                 l201_numdecreto = int8 = Número do Decreto 
                 l201_datadecreto = date = Data do Decreto 
                 l201_datapublicacao = date = Data de Publicação 
                 l201_tipodecreto = int8 = Tipo do Decreto 
                 l201_instit = int4 = Instituição
                 ";
   //funcao construtor da classe 
   function cl_decretopregao() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("decretopregao"); 
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
       $this->l201_sequencial = ($this->l201_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l201_sequencial"]:$this->l201_sequencial);
       $this->l201_numdecreto = ($this->l201_numdecreto == ""?@$GLOBALS["HTTP_POST_VARS"]["l201_numdecreto"]:$this->l201_numdecreto);
       if($this->l201_datadecreto == ""){
         $this->l201_datadecreto_dia = ($this->l201_datadecreto_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l201_datadecreto_dia"]:$this->l201_datadecreto_dia);
         $this->l201_datadecreto_mes = ($this->l201_datadecreto_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l201_datadecreto_mes"]:$this->l201_datadecreto_mes);
         $this->l201_datadecreto_ano = ($this->l201_datadecreto_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l201_datadecreto_ano"]:$this->l201_datadecreto_ano);
         if($this->l201_datadecreto_dia != ""){
            $this->l201_datadecreto = $this->l201_datadecreto_ano."-".$this->l201_datadecreto_mes."-".$this->l201_datadecreto_dia;
         }
       }
       if($this->l201_datapublicacao == ""){
         $this->l201_datapublicacao_dia = ($this->l201_datapublicacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l201_datapublicacao_dia"]:$this->l201_datapublicacao_dia);
         $this->l201_datapublicacao_mes = ($this->l201_datapublicacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l201_datapublicacao_mes"]:$this->l201_datapublicacao_mes);
         $this->l201_datapublicacao_ano = ($this->l201_datapublicacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l201_datapublicacao_ano"]:$this->l201_datapublicacao_ano);
         if($this->l201_datapublicacao_dia != ""){
            $this->l201_datapublicacao = $this->l201_datapublicacao_ano."-".$this->l201_datapublicacao_mes."-".$this->l201_datapublicacao_dia;
         }
       }
       $this->l201_tipodecreto = ($this->l201_tipodecreto == ""?@$GLOBALS["HTTP_POST_VARS"]["l201_tipodecreto"]:$this->l201_tipodecreto);
       $this->l201_instit = ($this->l201_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["l201_instit"]:$this->l201_instit);
     }else{
       $this->l201_sequencial = ($this->l201_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l201_sequencial"]:$this->l201_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($l201_sequencial){ 
      $this->atualizacampos();
     if($this->l201_numdecreto == null ){ 
       $this->erro_sql = " Campo Número do Decreto nao Informado.";
       $this->erro_campo = "l201_numdecreto";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l201_datadecreto == null ){ 
       $this->erro_sql = " Campo Data do Decreto nao Informado.";
       $this->erro_campo = "l201_datadecreto_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l201_datapublicacao == null ){ 
       $this->erro_sql = " Campo Data de Publicação nao Informado.";
       $this->erro_campo = "l201_datapublicacao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l201_tipodecreto == null ){ 
       $this->erro_sql = " Campo Tipo do Decreto nao Informado.";
       $this->erro_campo = "l201_tipodecreto";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l201_instit == null ){
      $this->l201_instit = db_getsession('DB_instit');
    }
   if($l201_sequencial == "" || $l201_sequencial == null ){
       $result = db_query("select nextval('decretopregao_l201_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: decretopregao_l201_sequencial_seq do campo: l201_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->l201_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from decretopregao_l201_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $l201_sequencial)){
         $this->erro_sql = " Campo l201_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->l201_sequencial = $l201_sequencial; 
       }
     } 
     if(($this->l201_sequencial == null) || ($this->l201_sequencial == "") ){ 
       $this->erro_sql = " Campo l201_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into decretopregao(
                                       l201_sequencial 
                                      ,l201_numdecreto 
                                      ,l201_datadecreto 
                                      ,l201_datapublicacao 
                                      ,l201_tipodecreto 
                                      ,l201_instit
                       )
                values (
                                $this->l201_sequencial 
                               ,$this->l201_numdecreto 
                               ,".($this->l201_datadecreto == "null" || $this->l201_datadecreto == ""?"null":"'".$this->l201_datadecreto."'")." 
                               ,".($this->l201_datapublicacao == "null" || $this->l201_datapublicacao == ""?"null":"'".$this->l201_datapublicacao."'")." 
                               ,$this->l201_tipodecreto
                               ,$this->l201_instit
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Decreto Pregão/Registro de Preço ($this->l201_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Decreto Pregão/Registro de Preço já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Decreto Pregão/Registro de Preço ($this->l201_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l201_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->l201_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009395,'$this->l201_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010216,2009395,'','".AddSlashes(pg_result($resaco,0,'l201_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010216,2009396,'','".AddSlashes(pg_result($resaco,0,'l201_numdecreto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010216,2009399,'','".AddSlashes(pg_result($resaco,0,'l201_datadecreto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010216,2009400,'','".AddSlashes(pg_result($resaco,0,'l201_datapublicacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010216,2009445,'','".AddSlashes(pg_result($resaco,0,'l201_tipodecreto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($l201_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update decretopregao set ";
     $virgula = "";
     if(trim($this->l201_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l201_sequencial"])){ 
       $sql  .= $virgula." l201_sequencial = $this->l201_sequencial ";
       $virgula = ",";
       if(trim($this->l201_sequencial) == null ){ 
         $this->erro_sql = " Campo Código Sequencial nao Informado.";
         $this->erro_campo = "l201_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l201_numdecreto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l201_numdecreto"])){ 
       $sql  .= $virgula." l201_numdecreto = $this->l201_numdecreto ";
       $virgula = ",";
       if(trim($this->l201_numdecreto) == null ){ 
         $this->erro_sql = " Campo Número do Decreto nao Informado.";
         $this->erro_campo = "l201_numdecreto";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l201_datadecreto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l201_datadecreto_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l201_datadecreto_dia"] !="") ){ 
       $sql  .= $virgula." l201_datadecreto = '$this->l201_datadecreto' ";
       $virgula = ",";
       if(trim($this->l201_datadecreto) == null ){ 
         $this->erro_sql = " Campo Data do Decreto nao Informado.";
         $this->erro_campo = "l201_datadecreto_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["l201_datadecreto_dia"])){ 
         $sql  .= $virgula." l201_datadecreto = null ";
         $virgula = ",";
         if(trim($this->l201_datadecreto) == null ){ 
           $this->erro_sql = " Campo Data do Decreto nao Informado.";
           $this->erro_campo = "l201_datadecreto_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->l201_datapublicacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l201_datapublicacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l201_datapublicacao_dia"] !="") ){ 
       $sql  .= $virgula." l201_datapublicacao = '$this->l201_datapublicacao' ";
       $virgula = ",";
       if(trim($this->l201_datapublicacao) == null ){ 
         $this->erro_sql = " Campo Data de Publicação nao Informado.";
         $this->erro_campo = "l201_datapublicacao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["l201_datapublicacao_dia"])){ 
         $sql  .= $virgula." l201_datapublicacao = null ";
         $virgula = ",";
         if(trim($this->l201_datapublicacao) == null ){ 
           $this->erro_sql = " Campo Data de Publicação nao Informado.";
           $this->erro_campo = "l201_datapublicacao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->l201_tipodecreto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l201_tipodecreto"])){ 
       $sql  .= $virgula." l201_tipodecreto = $this->l201_tipodecreto ";
       $virgula = ",";
       if(trim($this->l201_tipodecreto) == null ){ 
         $this->erro_sql = " Campo Tipo do Decreto nao Informado.";
         $this->erro_campo = "l201_tipodecreto";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($l201_sequencial!=null){
       $sql .= " l201_sequencial = $this->l201_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->l201_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009395,'$this->l201_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l201_sequencial"]) || $this->l201_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010216,2009395,'".AddSlashes(pg_result($resaco,$conresaco,'l201_sequencial'))."','$this->l201_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l201_numdecreto"]) || $this->l201_numdecreto != "")
           $resac = db_query("insert into db_acount values($acount,2010216,2009396,'".AddSlashes(pg_result($resaco,$conresaco,'l201_numdecreto'))."','$this->l201_numdecreto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l201_datadecreto"]) || $this->l201_datadecreto != "")
           $resac = db_query("insert into db_acount values($acount,2010216,2009399,'".AddSlashes(pg_result($resaco,$conresaco,'l201_datadecreto'))."','$this->l201_datadecreto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l201_datapublicacao"]) || $this->l201_datapublicacao != "")
           $resac = db_query("insert into db_acount values($acount,2010216,2009400,'".AddSlashes(pg_result($resaco,$conresaco,'l201_datapublicacao'))."','$this->l201_datapublicacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l201_tipodecreto"]) || $this->l201_tipodecreto != "")
           $resac = db_query("insert into db_acount values($acount,2010216,2009445,'".AddSlashes(pg_result($resaco,$conresaco,'l201_tipodecreto'))."','$this->l201_tipodecreto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Decreto Pregão/Registro de Preço nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->l201_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Decreto Pregão/Registro de Preço nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->l201_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l201_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($l201_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($l201_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009395,'$l201_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010216,2009395,'','".AddSlashes(pg_result($resaco,$iresaco,'l201_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010216,2009396,'','".AddSlashes(pg_result($resaco,$iresaco,'l201_numdecreto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010216,2009399,'','".AddSlashes(pg_result($resaco,$iresaco,'l201_datadecreto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010216,2009400,'','".AddSlashes(pg_result($resaco,$iresaco,'l201_datapublicacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010216,2009445,'','".AddSlashes(pg_result($resaco,$iresaco,'l201_tipodecreto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from decretopregao
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($l201_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " l201_sequencial = $l201_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Decreto Pregão/Registro de Preço nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$l201_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Decreto Pregão/Registro de Preço nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$l201_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$l201_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:decretopregao";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $l201_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from decretopregao ";
     $sql2 = "";
     if($dbwhere==""){
       if($l201_sequencial!=null ){
         $sql2 .= " where decretopregao.l201_sequencial = $l201_sequencial "; 
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
   function sql_query_file ( $l201_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from decretopregao ";
     $sql2 = "";
     if($dbwhere==""){
       if($l201_sequencial!=null ){
         $sql2 .= " where decretopregao.l201_sequencial = $l201_sequencial "; 
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
  
  function verifica_decreto_unico($numdecreto,$datadecreto,$tipodecreto,$instit) {
  	
  	$sql = "select * from decretopregao where l201_numdecreto = $numdecreto and l201_datadecreto = '$datadecreto' and l201_tipodecreto = $tipodecreto and l201_instit = " .db_getsession("DB_instit");
  	$result = db_query($sql);
  	if (pg_num_rows($result) > 0) {
  		return false;
  	}
  	return true;
  	
  }
}
?>
