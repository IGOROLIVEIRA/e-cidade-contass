<?
//MODULO: contabilidade
//CLASSE DA ENTIDADE lancamentospcasp
class cl_lancamentospcasp { 
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
   var $c205_sequencial = 0; 
   var $c205_tipolancamento = 0; 
   var $c205_subtipolancamento = 0; 
   var $c205_codconta = 0; 
   var $c205_anouso = 0; 
   var $c205_desdobramneto = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 c205_sequencial = int8 = Código  sequencial 
                 c205_tipolancamento = int8 = Tipo Lançamento 
                 c205_subtipolancamento = int8 = Subtipo Lancamento 
                 c205_codconta = int8 = Codigo da conta 
                 c205_anouso = int8 = Ano Uso 
                 c205_desdobramneto = int8 = Desdobramento 
                 ";
   //funcao construtor da classe 
   function cl_lancamentospcasp() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("lancamentospcasp"); 
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
       $this->c205_sequencial = ($this->c205_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c205_sequencial"]:$this->c205_sequencial);
       $this->c205_tipolancamento = ($this->c205_tipolancamento == ""?@$GLOBALS["HTTP_POST_VARS"]["c205_tipolancamento"]:$this->c205_tipolancamento);
       $this->c205_subtipolancamento = ($this->c205_subtipolancamento == ""?@$GLOBALS["HTTP_POST_VARS"]["c205_subtipolancamento"]:$this->c205_subtipolancamento);
       $this->c205_codconta = ($this->c205_codconta == ""?@$GLOBALS["HTTP_POST_VARS"]["c205_codconta"]:$this->c205_codconta);
       $this->c205_anouso = ($this->c205_anouso == ""?@$GLOBALS["HTTP_POST_VARS"]["c205_anouso"]:$this->c205_anouso);
       $this->c205_desdobramneto = ($this->c205_desdobramneto == ""?@$GLOBALS["HTTP_POST_VARS"]["c205_desdobramneto"]:$this->c205_desdobramneto);
     }else{
       $this->c205_sequencial = ($this->c205_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c205_sequencial"]:$this->c205_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($c205_sequencial,$c205_codconta,$c205_anouso){
      $this->atualizacampos(); 
     if($this->c205_tipolancamento == null ){ 
       $this->erro_sql = " Campo Tipo Lançamento nao Informado.";
       $this->erro_campo = "c205_tipolancamento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     
     if($this->c205_subtipolancamento == null ){ 
       $this->c205_subtipolancamento=null;
     }
     
     if($c205_codconta == null ){ 
       $this->erro_sql = " Campo Codigo da conta nao Informado.";
       $this->erro_campo = "c205_codconta";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($c205_anouso == null ){ 
       $this->erro_sql = " Campo Ano Uso nao Informado.";
       $this->erro_campo = "c205_anouso";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c205_desdobramneto == null ){ 
     	$this->c205_desdobramneto=null;
     } 
     if($c205_sequencial == "" || $c205_sequencial == null ){
       $result = db_query("select nextval('lancamentospcasp_c205_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: lancamentospcasp_c205_sequencial_seq do campo: c205_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->c205_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from lancamentospcasp_c205_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $c205_sequencial)){
         $this->erro_sql = " Campo c205_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->c205_sequencial = $c205_sequencial; 
       }
     }
     if(($this->c205_sequencial == null) || ($this->c205_sequencial == "") ){ 
       $this->erro_sql = " Campo c205_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into lancamentospcasp(
                                       c205_sequencial 
                                      ,c205_tipolancamento 
                                      ,c205_subtipolancamento 
                                      ,c205_codconta 
                                      ,c205_anouso 
                                      ,c205_desdobramneto 
                       )
                values (
                                $this->c205_sequencial 
                               ,$this->c205_tipolancamento 
                               ,$this->c205_subtipolancamento 
                               ,$c205_codconta 
                               ,$c205_anouso 
                               ,$this->c205_desdobramneto 
                      )"; echo $sql;exit;
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Lançamentos so PCASP ($this->c205_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Lançamentos so PCASP já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Lançamentos so PCASP ($this->c205_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c205_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->c205_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009453,'$this->c205_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010225,2009453,'','".AddSlashes(pg_result($resaco,0,'c205_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010225,2009454,'','".AddSlashes(pg_result($resaco,0,'c205_tipolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010225,2009455,'','".AddSlashes(pg_result($resaco,0,'c205_subtipolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010225,2011283,'','".AddSlashes(pg_result($resaco,0,'c205_codconta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010225,2011282,'','".AddSlashes(pg_result($resaco,0,'c205_anouso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010225,2011281,'','".AddSlashes(pg_result($resaco,0,'c205_desdobramneto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao  $oDaoTipoLancamento->alterar(null,$this->getCodigoConta(), $this->getAno());
   function alterar ($c205_sequencial=null,$c205_codconta,$c205_anouso){ 
      $this->atualizacampos();
     $sql = " update lancamentospcasp set ";
     $virgula = "";
     if(trim($this->c205_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c205_sequencial"])){ 
       $sql  .= $virgula." c205_sequencial = $this->c205_sequencial ";
       $virgula = ",";
       if(trim($this->c205_sequencial) == null ){ 
         $this->erro_sql = " Campo Código  sequencial nao Informado.";
         $this->erro_campo = "c205_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c205_tipolancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c205_tipolancamento"])){ 
       $sql  .= $virgula." c205_tipolancamento = $this->c205_tipolancamento ";
       $virgula = ",";
       if(trim($this->c205_tipolancamento) == null ){ 
         $this->erro_sql = " Campo Tipo Lançamento nao Informado.";
         $this->erro_campo = "c205_tipolancamento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c205_subtipolancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c205_subtipolancamento"])){ 
       if(trim($this->c205_subtipolancamento) == null ){ 
         $sql  .= $virgula." c205_subtipolancamento = $c205_subtipolancamento ";
         $virgula = ",";
       }else{
       	 $sql  .= $virgula." c205_subtipolancamento = $c205_subtipolancamento ";
         $virgula = ",";
       }
     }
     if(trim($this->c205_codconta)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c205_codconta"])){ 
       if(trim($this->c205_codconta) == null ){ 
         $sql  .= $virgula." c205_codconta = $c205_codconta ";
       	 $virgula = ",";
       }else{
       	 $sql  .= $virgula." c205_codconta = $c205_codconta ";
       	 $virgula = ",";
       }
     }
     if(trim($c205_anouso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c205_anouso"])){ 
       if(trim($this->c205_anouso) == null ){ 
         $sql  .= $virgula." c205_anouso = $c205_anouso ";
         $virgula = ",";
       }else{
       	 $sql  .= $virgula." c205_anouso = $c205_anouso ";
         $virgula = ",";
       }
     }
     if(trim($c205_desdobramneto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c205_desdobramneto"])){ 
       if(trim($this->c205_desdobramneto) == null ){ 
         $sql  .= $virgula." c205_desdobramneto = $c205_desdobramneto ";
       	 $virgula = ",";
       }else{
       	 $sql  .= $virgula." c205_desdobramneto = $c205_desdobramneto ";
       	 $virgula = ",";
       }
     }
     
     $sql .= " where ";
     if($c205_sequencial!=null){
       $sql .= " c205_sequencial = $this->c205_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->c205_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009453,'$this->c205_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c205_sequencial"]) || $this->c205_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010225,2009453,'".AddSlashes(pg_result($resaco,$conresaco,'c205_sequencial'))."','$this->c205_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c205_tipolancamento"]) || $this->c205_tipolancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010225,2009454,'".AddSlashes(pg_result($resaco,$conresaco,'c205_tipolancamento'))."','$this->c205_tipolancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c205_subtipolancamento"]) || $this->c205_subtipolancamento != "")
           $resac = db_query("insert into db_acount values($acount,2010225,2009455,'".AddSlashes(pg_result($resaco,$conresaco,'c205_subtipolancamento'))."','$this->c205_subtipolancamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c205_codconta"]) || $this->c205_codconta != "")
           $resac = db_query("insert into db_acount values($acount,2010225,2011283,'".AddSlashes(pg_result($resaco,$conresaco,'c205_codconta'))."','$this->c205_codconta',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c205_anouso"]) || $this->c205_anouso != "")
           $resac = db_query("insert into db_acount values($acount,2010225,2011282,'".AddSlashes(pg_result($resaco,$conresaco,'c205_anouso'))."','$this->c205_anouso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c205_desdobramneto"]) || $this->c205_desdobramneto != "")
           $resac = db_query("insert into db_acount values($acount,2010225,2011281,'".AddSlashes(pg_result($resaco,$conresaco,'c205_desdobramneto'))."','$this->c205_desdobramneto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Lançamentos so PCASP nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c205_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Lançamentos so PCASP nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c205_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c205_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($c205_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($c205_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009453,'$c205_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010225,2009453,'','".AddSlashes(pg_result($resaco,$iresaco,'c205_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010225,2009454,'','".AddSlashes(pg_result($resaco,$iresaco,'c205_tipolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010225,2009455,'','".AddSlashes(pg_result($resaco,$iresaco,'c205_subtipolancamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010225,2011283,'','".AddSlashes(pg_result($resaco,$iresaco,'c205_codconta'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010225,2011282,'','".AddSlashes(pg_result($resaco,$iresaco,'c205_anouso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010225,2011281,'','".AddSlashes(pg_result($resaco,$iresaco,'c205_desdobramneto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from lancamentospcasp
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($c205_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " c205_sequencial = $c205_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Lançamentos so PCASP nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c205_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Lançamentos so PCASP nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c205_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c205_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:lancamentospcasp";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $c205_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from lancamentospcasp ";
     $sql .= "      inner join conplano  on  conplano.c60_codcon = lancamentospcasp.c205_anouso and  conplano.c60_anousu = lancamentospcasp.c205_codconta";
     $sql .= "      inner join conclass  on  conclass.c51_codcla = conplano.c60_codcla";
     $sql .= "      inner join consistema  on  consistema.c52_codsis = conplano.c60_codsis";
     $sql .= "      inner join consistemaconta  on  consistemaconta.c65_sequencial = conplano.c60_consistemaconta";
     $sql2 = "";
     if($dbwhere==""){
       if($c205_sequencial!=null ){
         $sql2 .= " where lancamentospcasp.c205_sequencial = $c205_sequencial "; 
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
   function sql_query_file ( $c205_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from lancamentospcasp ";
     $sql2 = "";
     if($dbwhere==""){
       if($c205_sequencial!=null ){
         $sql2 .= " where lancamentospcasp.c205_sequencial = $c205_sequencial "; 
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
