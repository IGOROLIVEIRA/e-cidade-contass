<?
//MODULO: licitacao
//CLASSE DA ENTIDADE dochabilitaforn
class cl_dochabilitaforn { 
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
   var $l208_sequencial = 0; 
   var $l208_habilitacaoforn = 0; 
   var $l208_dochabilitacao = 0; 
   var $l208_numero = 0; 
   var $l208_dataemissao_dia = null; 
   var $l208_dataemissao_mes = null; 
   var $l208_dataemissao_ano = null; 
   var $l208_dataemissao = null; 
   var $l208_datavalidade_dia = null; 
   var $l208_datavalidade_mes = null; 
   var $l208_datavalidade_ano = null; 
   var $l208_datavalidade = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 l208_sequencial = int8 = Código Sequencial 
                 l208_habilitacaoforn = int8 = Código Habilitação 
                 l208_dochabilitacao = int8 = Código Documentos 
                 l208_numero = int8 = Número 
                 l208_dataemissao = date = Data Emissão 
                 l208_datavalidade = date = Validade 
                 ";
   //funcao construtor da classe 
   function cl_dochabilitaforn() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dochabilitaforn"); 
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
       $this->l208_sequencial = ($this->l208_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l208_sequencial"]:$this->l208_sequencial);
       $this->l208_habilitacaoforn = ($this->l208_habilitacaoforn == ""?@$GLOBALS["HTTP_POST_VARS"]["l208_habilitacaoforn"]:$this->l208_habilitacaoforn);
       $this->l208_dochabilitacao = ($this->l208_dochabilitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["l208_dochabilitacao"]:$this->l208_dochabilitacao);
       $this->l208_numero = ($this->l208_numero == ""?@$GLOBALS["HTTP_POST_VARS"]["l208_numero"]:$this->l208_numero);
       if($this->l208_dataemissao == ""){
         $this->l208_dataemissao_dia = ($this->l208_dataemissao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l208_dataemissao_dia"]:$this->l208_dataemissao_dia);
         $this->l208_dataemissao_mes = ($this->l208_dataemissao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l208_dataemissao_mes"]:$this->l208_dataemissao_mes);
         $this->l208_dataemissao_ano = ($this->l208_dataemissao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l208_dataemissao_ano"]:$this->l208_dataemissao_ano);
         if($this->l208_dataemissao_dia != ""){
            $this->l208_dataemissao = $this->l208_dataemissao_ano."-".$this->l208_dataemissao_mes."-".$this->l208_dataemissao_dia;
         }
       }
       if($this->l208_datavalidade == ""){
         $this->l208_datavalidade_dia = ($this->l208_datavalidade_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["l208_datavalidade_dia"]:$this->l208_datavalidade_dia);
         $this->l208_datavalidade_mes = ($this->l208_datavalidade_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["l208_datavalidade_mes"]:$this->l208_datavalidade_mes);
         $this->l208_datavalidade_ano = ($this->l208_datavalidade_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["l208_datavalidade_ano"]:$this->l208_datavalidade_ano);
         if($this->l208_datavalidade_dia != ""){
            $this->l208_datavalidade = $this->l208_datavalidade_ano."-".$this->l208_datavalidade_mes."-".$this->l208_datavalidade_dia;
         }
       }
     }else{
       $this->l208_sequencial = ($this->l208_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l208_sequencial"]:$this->l208_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($l208_sequencial){ 
      $this->atualizacampos();
     if($this->l208_habilitacaoforn == null ){ 
       $this->erro_sql = " Campo Código Habilitação nao Informado.";
       $this->erro_campo = "l208_habilitacaoforn";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l208_dochabilitacao == null ){ 
       $this->erro_sql = " Campo Código Documentos nao Informado.";
       $this->erro_campo = "l208_dochabilitacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l208_numero == null ){ 
       $this->erro_sql = " Campo Número nao Informado.";
       $this->erro_campo = "l208_numero";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l208_dataemissao == null ){ 
       $this->erro_sql = " Campo Data Emissão nao Informado.";
       $this->erro_campo = "l208_dataemissao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l208_datavalidade == null ){ 
       $this->erro_sql = " Campo Validade nao Informado.";
       $this->erro_campo = "l208_datavalidade_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($l208_sequencial == "" || $l208_sequencial == null ){
       $result = db_query("select nextval('dochabilitaforn_l208_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dochabilitaforn_l208_sequencial_seq do campo: l208_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->l208_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from dochabilitaforn_l208_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $l208_sequencial)){
         $this->erro_sql = " Campo l208_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->l208_sequencial = $l208_sequencial; 
       }
     }
     if(($this->l208_sequencial == null) || ($this->l208_sequencial == "") ){ 
       $this->erro_sql = " Campo l208_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dochabilitaforn(
                                       l208_sequencial 
                                      ,l208_habilitacaoforn 
                                      ,l208_dochabilitacao 
                                      ,l208_numero 
                                      ,l208_dataemissao 
                                      ,l208_datavalidade 
                       )
                values (
                                $this->l208_sequencial 
                               ,$this->l208_habilitacaoforn 
                               ,$this->l208_dochabilitacao 
                               ,$this->l208_numero 
                               ,".($this->l208_dataemissao == "null" || $this->l208_dataemissao == ""?"null":"'".$this->l208_dataemissao."'")." 
                               ,".($this->l208_datavalidade == "null" || $this->l208_datavalidade == ""?"null":"'".$this->l208_datavalidade."'")." 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Documentos Habilitação Fornecedor ($this->l208_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Documentos Habilitação Fornecedor já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Documentos Habilitação Fornecedor ($this->l208_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l208_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->l208_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009555,'$this->l208_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010238,2009555,'','".AddSlashes(pg_result($resaco,0,'l208_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010238,2009556,'','".AddSlashes(pg_result($resaco,0,'l208_habilitacaoforn'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010238,2009557,'','".AddSlashes(pg_result($resaco,0,'l208_dochabilitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010238,2009558,'','".AddSlashes(pg_result($resaco,0,'l208_numero'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010238,2009559,'','".AddSlashes(pg_result($resaco,0,'l208_dataemissao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010238,2009560,'','".AddSlashes(pg_result($resaco,0,'l208_datavalidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($l208_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update dochabilitaforn set ";
     $virgula = "";
     if(trim($this->l208_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l208_sequencial"])){ 
       $sql  .= $virgula." l208_sequencial = $this->l208_sequencial ";
       $virgula = ",";
       if(trim($this->l208_sequencial) == null ){ 
         $this->erro_sql = " Campo Código Sequencial nao Informado.";
         $this->erro_campo = "l208_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l208_habilitacaoforn)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l208_habilitacaoforn"])){ 
       $sql  .= $virgula." l208_habilitacaoforn = $this->l208_habilitacaoforn ";
       $virgula = ",";
       if(trim($this->l208_habilitacaoforn) == null ){ 
         $this->erro_sql = " Campo Código Habilitação nao Informado.";
         $this->erro_campo = "l208_habilitacaoforn";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l208_dochabilitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l208_dochabilitacao"])){ 
       $sql  .= $virgula." l208_dochabilitacao = $this->l208_dochabilitacao ";
       $virgula = ",";
       if(trim($this->l208_dochabilitacao) == null ){ 
         $this->erro_sql = " Campo Código Documentos nao Informado.";
         $this->erro_campo = "l208_dochabilitacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l208_numero)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l208_numero"])){ 
       $sql  .= $virgula." l208_numero = $this->l208_numero ";
       $virgula = ",";
       if(trim($this->l208_numero) == null ){ 
         $this->erro_sql = " Campo Número nao Informado.";
         $this->erro_campo = "l208_numero";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l208_dataemissao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l208_dataemissao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l208_dataemissao_dia"] !="") ){ 
       $sql  .= $virgula." l208_dataemissao = '$this->l208_dataemissao' ";
       $virgula = ",";
       if(trim($this->l208_dataemissao) == null ){ 
         $this->erro_sql = " Campo Data Emissão nao Informado.";
         $this->erro_campo = "l208_dataemissao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["l208_dataemissao_dia"])){ 
         $sql  .= $virgula." l208_dataemissao = null ";
         $virgula = ",";
         if(trim($this->l208_dataemissao) == null ){ 
           $this->erro_sql = " Campo Data Emissão nao Informado.";
           $this->erro_campo = "l208_dataemissao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->l208_datavalidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l208_datavalidade_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l208_datavalidade_dia"] !="") ){ 
       $sql  .= $virgula." l208_datavalidade = '$this->l208_datavalidade' ";
       $virgula = ",";
       if(trim($this->l208_datavalidade) == null ){ 
         $this->erro_sql = " Campo Validade nao Informado.";
         $this->erro_campo = "l208_datavalidade_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["l208_datavalidade_dia"])){ 
         $sql  .= $virgula." l208_datavalidade = null ";
         $virgula = ",";
         if(trim($this->l208_datavalidade) == null ){ 
           $this->erro_sql = " Campo Validade nao Informado.";
           $this->erro_campo = "l208_datavalidade_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     $sql .= " where ";
     if($l208_sequencial!=null){
       $sql .= " l208_sequencial = $this->l208_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->l208_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009555,'$this->l208_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l208_sequencial"]) || $this->l208_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010238,2009555,'".AddSlashes(pg_result($resaco,$conresaco,'l208_sequencial'))."','$this->l208_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l208_habilitacaoforn"]) || $this->l208_habilitacaoforn != "")
           $resac = db_query("insert into db_acount values($acount,2010238,2009556,'".AddSlashes(pg_result($resaco,$conresaco,'l208_habilitacaoforn'))."','$this->l208_habilitacaoforn',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l208_dochabilitacao"]) || $this->l208_dochabilitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010238,2009557,'".AddSlashes(pg_result($resaco,$conresaco,'l208_dochabilitacao'))."','$this->l208_dochabilitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l208_numero"]) || $this->l208_numero != "")
           $resac = db_query("insert into db_acount values($acount,2010238,2009558,'".AddSlashes(pg_result($resaco,$conresaco,'l208_numero'))."','$this->l208_numero',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l208_dataemissao"]) || $this->l208_dataemissao != "")
           $resac = db_query("insert into db_acount values($acount,2010238,2009559,'".AddSlashes(pg_result($resaco,$conresaco,'l208_dataemissao'))."','$this->l208_dataemissao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l208_datavalidade"]) || $this->l208_datavalidade != "")
           $resac = db_query("insert into db_acount values($acount,2010238,2009560,'".AddSlashes(pg_result($resaco,$conresaco,'l208_datavalidade'))."','$this->l208_datavalidade',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Documentos Habilitação Fornecedor nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->l208_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Documentos Habilitação Fornecedor nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->l208_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l208_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($l208_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($l208_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009555,'$l208_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010238,2009555,'','".AddSlashes(pg_result($resaco,$iresaco,'l208_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010238,2009556,'','".AddSlashes(pg_result($resaco,$iresaco,'l208_habilitacaoforn'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010238,2009557,'','".AddSlashes(pg_result($resaco,$iresaco,'l208_dochabilitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010238,2009558,'','".AddSlashes(pg_result($resaco,$iresaco,'l208_numero'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010238,2009559,'','".AddSlashes(pg_result($resaco,$iresaco,'l208_dataemissao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010238,2009560,'','".AddSlashes(pg_result($resaco,$iresaco,'l208_datavalidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from dochabilitaforn
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($l208_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " l208_sequencial = $l208_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Documentos Habilitação Fornecedor nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$l208_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Documentos Habilitação Fornecedor nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$l208_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$l208_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:dochabilitaforn";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $l208_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dochabilitaforn ";
     $sql .= "      inner join habilitacaoforn  on  habilitacaoforn.l206_sequencial = dochabilitaforn.l208_habilitacaoforn";
     $sql .= "      inner join dochabilitacao  on  dochabilitacao.l207_sequencial = dochabilitaforn.l208_dochabilitacao";
     $sql .= "      inner join pcforne  on  pcforne.pc60_numcgm = habilitacaoforn.l206_fornecedor";
     $sql .= "      inner join liclicita  on  liclicita.l20_codigo = habilitacaoforn.l206_licitacao";
     $sql2 = "";
     if($dbwhere==""){
       if($l208_sequencial!=null ){
         $sql2 .= " where dochabilitaforn.l208_sequencial = $l208_sequencial "; 
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
   function sql_query_file ( $l208_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from dochabilitaforn ";
     $sql2 = "";
     if($dbwhere==""){
       if($l208_sequencial!=null ){
         $sql2 .= " where dochabilitaforn.l208_sequencial = $l208_sequencial "; 
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
