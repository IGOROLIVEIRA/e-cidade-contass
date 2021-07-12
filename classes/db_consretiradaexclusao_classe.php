<?
//MODULO: contabilidade
//CLASSE DA ENTIDADE consretiradaexclusao
class cl_consretiradaexclusao { 
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
   var $c204_sequencial = 0; 
   var $c204_consconsorcios = 0; 
   var $c204_tipoencerramento = 0; 
   var $c204_dataencerramento_dia = null; 
   var $c204_dataencerramento_mes = null; 
   var $c204_dataencerramento_ano = null; 
   var $c204_dataencerramento = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 c204_sequencial = int8 = Código Sequencial 
                 c204_consconsorcios = int8 = Código Consórcio 
                 c204_tipoencerramento = int8 = Tipo de Encerramento 
                 c204_dataencerramento = date = Data do Encerramento 
                 ";
   //funcao construtor da classe 
   function cl_consretiradaexclusao() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("consretiradaexclusao"); 
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
       $this->c204_sequencial = ($this->c204_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c204_sequencial"]:$this->c204_sequencial);
       $this->c204_consconsorcios = ($this->c204_consconsorcios == ""?@$GLOBALS["HTTP_POST_VARS"]["c204_consconsorcios"]:$this->c204_consconsorcios);
       $this->c204_tipoencerramento = ($this->c204_tipoencerramento == ""?@$GLOBALS["HTTP_POST_VARS"]["c204_tipoencerramento"]:$this->c204_tipoencerramento);
       if($this->c204_dataencerramento == ""){
         $this->c204_dataencerramento_dia = ($this->c204_dataencerramento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["c204_dataencerramento_dia"]:$this->c204_dataencerramento_dia);
         $this->c204_dataencerramento_mes = ($this->c204_dataencerramento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["c204_dataencerramento_mes"]:$this->c204_dataencerramento_mes);
         $this->c204_dataencerramento_ano = ($this->c204_dataencerramento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["c204_dataencerramento_ano"]:$this->c204_dataencerramento_ano);
         if($this->c204_dataencerramento_dia != ""){
            $this->c204_dataencerramento = $this->c204_dataencerramento_ano."-".$this->c204_dataencerramento_mes."-".$this->c204_dataencerramento_dia;
         }
       }
     }else{
       $this->c204_sequencial = ($this->c204_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c204_sequencial"]:$this->c204_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($c204_sequencial){ 
      $this->atualizacampos();
     if($this->c204_consconsorcios == null ){ 
       $this->erro_sql = " Campo Código Consórcio nao Informado.";
       $this->erro_campo = "c204_consconsorcios";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c204_tipoencerramento == null ){ 
       $this->erro_sql = " Campo Tipo de Encerramento nao Informado.";
       $this->erro_campo = "c204_tipoencerramento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->c204_dataencerramento == null ){ 
       $this->erro_sql = " Campo Data do Encerramento nao Informado.";
       $this->erro_campo = "c204_dataencerramento_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($c204_sequencial == "" || $c204_sequencial == null ){
       $result = db_query("select nextval('consretiradaexclusao_c204_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: consretiradaexclusao_c204_sequencial_seq do campo: c204_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->c204_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from consretiradaexclusao_c204_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $c204_sequencial)){
         $this->erro_sql = " Campo c204_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->c204_sequencial = $c204_sequencial; 
       }
     }
     if(($this->c204_sequencial == null) || ($this->c204_sequencial == "") ){ 
       $this->erro_sql = " Campo c204_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into consretiradaexclusao(
                                       c204_sequencial 
                                      ,c204_consconsorcios 
                                      ,c204_tipoencerramento 
                                      ,c204_dataencerramento 
                       )
                values (
                                $this->c204_sequencial 
                               ,$this->c204_consconsorcios 
                               ,$this->c204_tipoencerramento 
                               ,".($this->c204_dataencerramento == "null" || $this->c204_dataencerramento == ""?"null":"'".$this->c204_dataencerramento."'")." 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Retirada/ Exclusão do Ente Consorciado ou Extinção ($this->c204_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Retirada/ Exclusão do Ente Consorciado ou Extinção já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Retirada/ Exclusão do Ente Consorciado ou Extinção ($this->c204_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c204_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->c204_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009433,'$this->c204_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010221,2009433,'','".AddSlashes(pg_result($resaco,0,'c204_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010221,2009434,'','".AddSlashes(pg_result($resaco,0,'c204_consconsorcios'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010221,2009435,'','".AddSlashes(pg_result($resaco,0,'c204_tipoencerramento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010221,2009436,'','".AddSlashes(pg_result($resaco,0,'c204_dataencerramento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($c204_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update consretiradaexclusao set ";
     $virgula = "";
     if(trim($this->c204_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c204_sequencial"])){ 
       $sql  .= $virgula." c204_sequencial = $this->c204_sequencial ";
       $virgula = ",";
       if(trim($this->c204_sequencial) == null ){ 
         $this->erro_sql = " Campo Código Sequencial nao Informado.";
         $this->erro_campo = "c204_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c204_consconsorcios)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c204_consconsorcios"])){ 
       $sql  .= $virgula." c204_consconsorcios = $this->c204_consconsorcios ";
       $virgula = ",";
       if(trim($this->c204_consconsorcios) == null ){ 
         $this->erro_sql = " Campo Código Consórcio nao Informado.";
         $this->erro_campo = "c204_consconsorcios";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c204_tipoencerramento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c204_tipoencerramento"])){ 
       $sql  .= $virgula." c204_tipoencerramento = $this->c204_tipoencerramento ";
       $virgula = ",";
       if(trim($this->c204_tipoencerramento) == null ){ 
         $this->erro_sql = " Campo Tipo de Encerramento nao Informado.";
         $this->erro_campo = "c204_tipoencerramento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->c204_dataencerramento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c204_dataencerramento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["c204_dataencerramento_dia"] !="") ){ 
       $sql  .= $virgula." c204_dataencerramento = '$this->c204_dataencerramento' ";
       $virgula = ",";
       if(trim($this->c204_dataencerramento) == null ){ 
         $this->erro_sql = " Campo Data do Encerramento nao Informado.";
         $this->erro_campo = "c204_dataencerramento_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["c204_dataencerramento_dia"])){ 
         $sql  .= $virgula." c204_dataencerramento = null ";
         $virgula = ",";
         if(trim($this->c204_dataencerramento) == null ){ 
           $this->erro_sql = " Campo Data do Encerramento nao Informado.";
           $this->erro_campo = "c204_dataencerramento_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     $sql .= " where ";
     if($c204_sequencial!=null){
       $sql .= " c204_sequencial = $this->c204_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->c204_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009433,'$this->c204_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c204_sequencial"]) || $this->c204_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010221,2009433,'".AddSlashes(pg_result($resaco,$conresaco,'c204_sequencial'))."','$this->c204_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c204_consconsorcios"]) || $this->c204_consconsorcios != "")
           $resac = db_query("insert into db_acount values($acount,2010221,2009434,'".AddSlashes(pg_result($resaco,$conresaco,'c204_consconsorcios'))."','$this->c204_consconsorcios',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c204_tipoencerramento"]) || $this->c204_tipoencerramento != "")
           $resac = db_query("insert into db_acount values($acount,2010221,2009435,'".AddSlashes(pg_result($resaco,$conresaco,'c204_tipoencerramento'))."','$this->c204_tipoencerramento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["c204_dataencerramento"]) || $this->c204_dataencerramento != "")
           $resac = db_query("insert into db_acount values($acount,2010221,2009436,'".AddSlashes(pg_result($resaco,$conresaco,'c204_dataencerramento'))."','$this->c204_dataencerramento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Retirada/ Exclusão do Ente Consorciado ou Extinção nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c204_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Retirada/ Exclusão do Ente Consorciado ou Extinção nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c204_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c204_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($c204_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($c204_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009433,'$c204_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010221,2009433,'','".AddSlashes(pg_result($resaco,$iresaco,'c204_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010221,2009434,'','".AddSlashes(pg_result($resaco,$iresaco,'c204_consconsorcios'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010221,2009435,'','".AddSlashes(pg_result($resaco,$iresaco,'c204_tipoencerramento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010221,2009436,'','".AddSlashes(pg_result($resaco,$iresaco,'c204_dataencerramento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from consretiradaexclusao
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($c204_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " c204_sequencial = $c204_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Retirada/ Exclusão do Ente Consorciado ou Extinção nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c204_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Retirada/ Exclusão do Ente Consorciado ou Extinção nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c204_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c204_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:consretiradaexclusao";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $c204_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from consretiradaexclusao ";
     $sql .= "      inner join consconsorcios  on  consconsorcios.c200_sequencial = consretiradaexclusao.c204_consconsorcios";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = consconsorcios.c200_numcgm";
     $sql2 = "";
     if($dbwhere==""){
       if($c204_sequencial!=null ){
         $sql2 .= " where consretiradaexclusao.c204_sequencial = $c204_sequencial "; 
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
   function sql_query_file ( $c204_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from consretiradaexclusao ";
     $sql2 = "";
     if($dbwhere==""){
       if($c204_sequencial!=null ){
         $sql2 .= " where consretiradaexclusao.c204_sequencial = $c204_sequencial "; 
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
