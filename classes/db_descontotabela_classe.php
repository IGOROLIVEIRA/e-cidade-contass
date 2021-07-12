<?
//MODULO: licitacao
//CLASSE DA ENTIDADE descontotabela
class cl_descontotabela { 
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
   var $l204_sequencial = 0; 
   var $l204_licitacao = 0; 
   var $l204_fornecedor = 0; 
   var $l204_item = 0; 
   var $l204_valor = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 l204_sequencial = int4 = Sequencial 
                 l204_licitacao = int4 = Licitação 
                 l204_fornecedor = int4 = fornecedor 
                 l204_item = int4 = Item 
                 l204_valor = float8 = Valor 
                 ";
   //funcao construtor da classe 
   function cl_descontotabela() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("descontotabela"); 
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
       $this->l204_sequencial = ($this->l204_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l204_sequencial"]:$this->l204_sequencial);
       $this->l204_licitacao = ($this->l204_licitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["l204_licitacao"]:$this->l204_licitacao);
       $this->l204_fornecedor = ($this->l204_fornecedor == ""?@$GLOBALS["HTTP_POST_VARS"]["l204_fornecedor"]:$this->l204_fornecedor);
       $this->l204_item = ($this->l204_item == ""?@$GLOBALS["HTTP_POST_VARS"]["l204_item"]:$this->l204_item);
       $this->l204_valor = ($this->l204_valor == ""?@$GLOBALS["HTTP_POST_VARS"]["l204_valor"]:$this->l204_valor);
     }else{
       $this->l204_sequencial = ($this->l204_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l204_sequencial"]:$this->l204_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($l204_sequencial){ 
      $this->atualizacampos();
     if($this->l204_licitacao == null ){ 
       $this->erro_sql = " Campo Licitação nao Informado.";
       $this->erro_campo = "l204_licitacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l204_fornecedor == null ){ 
       $this->erro_sql = " Campo fornecedor nao Informado.";
       $this->erro_campo = "l204_fornecedor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->l204_item == null ){ 
       $this->erro_sql = " Campo Item nao Informado.";
       $this->erro_campo = "l204_item";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     /*if($this->l204_valor == null ){ 
       $this->erro_sql = " Campo Valor nao Informado.";
       $this->erro_campo = "l204_valor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }*/

     if($l204_sequencial == "" || $l204_sequencial == null ){
       $result = db_query("select nextval('descontotabela_l204_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: descontotabela_l204_sequencial_seq do campo: l204_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->l204_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from descontotabela_l204_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $l204_sequencial)){
         $this->erro_sql = " Campo l204_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->l204_sequencial = $l204_sequencial; 
       }
     }
     if(($this->l204_sequencial == null) || ($this->l204_sequencial == "") ){ 
       $this->erro_sql = " Campo l204_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     $sql = "insert into descontotabela(
                                       l204_sequencial 
                                      ,l204_licitacao 
                                      ,l204_fornecedor 
                                      ,l204_item 
                                      ,l204_valor 
                       )
                values (
                                $this->l204_sequencial 
                               ,$this->l204_licitacao 
                               ,$this->l204_fornecedor 
                               ,$this->l204_item 
                               ,".($this->l204_valor == "null" || $this->l204_valor == ""?"null":"'".$this->l204_valor."'")."
                      )";
     //echo $sql;exit;
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Desconto Tabela ($this->l204_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Desconto Tabela já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Desconto Tabela ($this->l204_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }

     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l204_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->l204_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009457,'$this->l204_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010226,2009457,'','".AddSlashes(pg_result($resaco,0,'l204_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010226,2009458,'','".AddSlashes(pg_result($resaco,0,'l204_licitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010226,2009459,'','".AddSlashes(pg_result($resaco,0,'l204_fornecedor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010226,2009460,'','".AddSlashes(pg_result($resaco,0,'l204_item'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010226,2009467,'','".AddSlashes(pg_result($resaco,0,'l204_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($l204_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update descontotabela set ";
     $virgula = "";
     if(trim($this->l204_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l204_sequencial"])){ 
       $sql  .= $virgula." l204_sequencial = $this->l204_sequencial ";
       $virgula = ",";
       if(trim($this->l204_sequencial) == null ){ 
         $this->erro_sql = " Campo Sequencial nao Informado.";
         $this->erro_campo = "l204_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l204_licitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l204_licitacao"])){ 
       $sql  .= $virgula." l204_licitacao = $this->l204_licitacao ";
       $virgula = ",";
       if(trim($this->l204_licitacao) == null ){ 
         $this->erro_sql = " Campo Licitação nao Informado.";
         $this->erro_campo = "l204_licitacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l204_fornecedor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l204_fornecedor"])){ 
       $sql  .= $virgula." l204_fornecedor = $this->l204_fornecedor ";
       $virgula = ",";
       if(trim($this->l204_fornecedor) == null ){ 
         $this->erro_sql = " Campo fornecedor nao Informado.";
         $this->erro_campo = "l204_fornecedor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l204_item)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l204_item"])){ 
       $sql  .= $virgula." l204_item = $this->l204_item ";
       $virgula = ",";
       if(trim($this->l204_item) == null ){ 
         $this->erro_sql = " Campo Item nao Informado.";
         $this->erro_campo = "l204_item";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->l204_valor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l204_valor"])){ 
       $sql  .= $virgula." l204_valor = $this->l204_valor ";
       $virgula = ",";
       /*if(trim($this->l204_valor) == null ){ 
         $this->erro_sql = " Campo Valor nao Informado.";
         $this->erro_campo = "l204_valor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }*/
     }
     $sql .= " where ";
     if($l204_sequencial!=null){
       $sql .= " l204_sequencial = $this->l204_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->l204_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009457,'$this->l204_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l204_sequencial"]) || $this->l204_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010226,2009457,'".AddSlashes(pg_result($resaco,$conresaco,'l204_sequencial'))."','$this->l204_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l204_licitacao"]) || $this->l204_licitacao != "")
           $resac = db_query("insert into db_acount values($acount,2010226,2009458,'".AddSlashes(pg_result($resaco,$conresaco,'l204_licitacao'))."','$this->l204_licitacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l204_fornecedor"]) || $this->l204_fornecedor != "")
           $resac = db_query("insert into db_acount values($acount,2010226,2009459,'".AddSlashes(pg_result($resaco,$conresaco,'l204_fornecedor'))."','$this->l204_fornecedor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l204_item"]) || $this->l204_item != "")
           $resac = db_query("insert into db_acount values($acount,2010226,2009460,'".AddSlashes(pg_result($resaco,$conresaco,'l204_item'))."','$this->l204_item',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["l204_valor"]) || $this->l204_valor != "")
           $resac = db_query("insert into db_acount values($acount,2010226,2009467,'".AddSlashes(pg_result($resaco,$conresaco,'l204_valor'))."','$this->l204_valor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Desconto Tabela nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->l204_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Desconto Tabela nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->l204_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->l204_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($l204_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($l204_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009457,'$l204_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010226,2009457,'','".AddSlashes(pg_result($resaco,$iresaco,'l204_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010226,2009458,'','".AddSlashes(pg_result($resaco,$iresaco,'l204_licitacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010226,2009459,'','".AddSlashes(pg_result($resaco,$iresaco,'l204_fornecedor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010226,2009460,'','".AddSlashes(pg_result($resaco,$iresaco,'l204_item'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010226,2009467,'','".AddSlashes(pg_result($resaco,$iresaco,'l204_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from descontotabela
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($l204_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " l204_sequencial = $l204_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);

     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Desconto Tabela nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$l204_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Desconto Tabela nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$l204_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$l204_sequencial;
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
      /*if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:descontotabela";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }*/
     return $result;
   }
   // funcao do sql 
   function sql_query ( $l204_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select distinct ";
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
     $sql .= " from descontotabela ";
     $sql .= "      inner join pcorcamforne  on  pcorcamforne.pc21_orcamforne = descontotabela.l204_fornecedor";
     $sql .= "      inner join liclicita  on  liclicita.l20_codigo = descontotabela.l204_licitacao";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = pcorcamforne.pc21_numcgm";
     $sql .= "      inner join pcorcam  on  pcorcam.pc20_codorc = pcorcamforne.pc21_codorc";
     $sql .= "      inner join db_config  on  db_config.codigo = liclicita.l20_instit";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = liclicita.l20_id_usucria";
     $sql .= "      inner join cflicita  on  cflicita.l03_codigo = liclicita.l20_codtipocom";
     $sql .= "      inner join liclocal  on  liclocal.l26_codigo = liclicita.l20_liclocal";
     $sql .= "      inner join liccomissao  on  liccomissao.l30_codigo = liclicita.l20_liccomissao";
     $sql .= "      inner join licsituacao  on  licsituacao.l08_sequencial = liclicita.l20_licsituacao";
     $sql2 = "";
     if($dbwhere==""){
       if($l204_sequencial!=null ){
         $sql2 .= " where descontotabela.l204_sequencial = $l204_sequencial "; 
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
   function sql_query_file ( $l204_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from descontotabela ";
     $sql2 = "";
     if($dbwhere==""){
       if($l204_sequencial!=null ){
         $sql2 .= " where descontotabela.l204_sequencial = $l204_sequencial "; 
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

  function sql_query_itens ( $l202_licitacao=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select distinct ";
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
     $sql .= " from pcprocitem ";
     $sql .= "      inner join pcproc                 on pcproc.pc80_codproc                 = pcprocitem.pc81_codproc";
     $sql .= "      inner join solicitem              on solicitem.pc11_codigo               = pcprocitem.pc81_solicitem";
     $sql .= "      inner join solicita               on solicita.pc10_numero                = solicitem.pc11_numero";
     $sql .= "      inner join db_depart              on db_depart.coddepto                  = solicita.pc10_depto";
     $sql .= "      left  join solicitemunid          on solicitemunid.pc17_codigo           = solicitem.pc11_codigo";
     $sql .= "      left  join matunid                on matunid.m61_codmatunid              = solicitemunid.pc17_unid";
     $sql .= "      left  join db_usuarios            on pcproc.pc80_usuario                 = db_usuarios.id_usuario";
     $sql .= "      left  join solicitempcmater       on solicitempcmater.pc16_solicitem     = solicitem.pc11_codigo";
     $sql .= "      left  join pcmater                on pcmater.pc01_codmater               = solicitempcmater.pc16_codmater";
     $sql .= "      left  join pcsubgrupo             on pcsubgrupo.pc04_codsubgrupo         = pcmater.pc01_codsubgrupo";
     $sql .= "      left  join pctipo                 on pctipo.pc05_codtipo                 = pcsubgrupo.pc04_codtipo";
     $sql .= "      left  join solicitemele           on solicitemele.pc18_solicitem         = solicitem.pc11_codigo";
     $sql .= "      left  join orcelemento            on orcelemento.o56_codele              = solicitemele.pc18_codele";
     $sql .= "                                       and orcelemento.o56_anousu              = ".db_getsession("DB_anousu");
     $sql .= "      left  join empautitempcprocitem   on empautitempcprocitem.e73_pcprocitem = pcprocitem.pc81_codprocitem";    
     $sql .= "      left  join empautitem             on empautitem.e55_autori               = empautitempcprocitem.e73_autori";
     $sql .= "                                       and empautitem.e55_sequen               = empautitempcprocitem.e73_sequen";
     $sql .= "      left  join empautoriza            on empautoriza.e54_autori              = empautitem.e55_autori ";
     $sql .= "      left  join cgm                    on empautoriza.e54_numcgm              = cgm.z01_numcgm ";
     $sql .= "      left  join empempaut              on empempaut.e61_autori                = empautitem.e55_autori ";     
     $sql .= "      left  join empempenho             on empempenho.e60_numemp               = empempaut.e61_numemp ";
     $sql .= "      left join liclicitem              on liclicitem.l21_codpcprocitem        = pcprocitem.pc81_codprocitem";          
     $sql2 = "";
     if($dbwhere==""){
       if($l202_licitacao!= null && $l202_licitacao!= "" ){
         $sql2 .= " where liclicitem.l21_codliclicita = $l202_licitacao ";
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

  function getCodOrc($l204_licitacao){

    $sSql = "select * from liclicitem 
    join pcorcamitemlic on pc26_liclicitem = l21_codigo 
    join pcorcamitem on pc22_orcamitem = pc26_orcamitem 
    where l21_codliclicita = {$l204_licitacao} limit 1";

    $rsOrcamento = db_query($sSql);
    $oOrcamento = db_utils::fieldsMemory($rsOrcamento, 0);

    return $oOrcamento->pc22_codorc;
  }
  function sql_query_fornec ( $pc21_orcamforne=null,$campos="*",$ordem=null,$dbwhere=""){
     $sql = "select distinct ";
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
     $sql .= " from pcorcamforne ";
     $sql .= "      inner join cgm           on cgm.z01_numcgm                = pcorcamforne.pc21_numcgm";
     $sql2 = "";
     if($dbwhere==""){
       if($pc21_orcamforne!=null ){
         $sql2 .= " where pcorcamforne.pc21_orcamforne = $pc21_orcamforne ";
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
