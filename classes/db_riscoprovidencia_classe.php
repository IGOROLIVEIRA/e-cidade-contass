<?
//MODULO: sicom
//CLASSE DA ENTIDADE riscoprovidencia
class cl_riscoprovidencia { 
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
   var $si54_sequencial = 0; 
   var $si54_dscprovidencia = null; 
   var $si54_valorassociado = 0; 
   var $si54_seqriscofiscal = 0;
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si54_sequencial = int8 = Codigo Risco
                 si54_seqriscofiscal = int8 = Codigo Risco  
                 si54_dscprovidencia = text = Descrição 
                 si54_valorassociado = float8 = Valor
                 
                 ";
   //funcao construtor da classe 
   function cl_riscoprovidencia() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("riscoprovidencia"); 
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
       $this->si54_sequencial = ($this->si54_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si54_sequencial"]:$this->si54_sequencial);
        $this->si54_seqriscofiscal = ($this->si54_seqriscofiscal == ""?@$GLOBALS["HTTP_POST_VARS"]["si54_seqriscofiscal"]:$this->si54_seqriscofiscal);
       
       $this->si54_dscprovidencia = ($this->si54_dscprovidencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si54_dscprovidencia"]:$this->si54_dscprovidencia);
       $this->si54_valorassociado = ($this->si54_valorassociado == ""?@$GLOBALS["HTTP_POST_VARS"]["si54_valorassociado"]:$this->si54_valorassociado);
     }else{
       $this->si54_sequencial = ($this->si54_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si54_sequencial"]:$this->si54_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si54_sequencial){ 
      $this->atualizacampos();
    
     if($this->si54_dscprovidencia == null ){ 
       $this->erro_sql = " Campo Descrição nao Informado.";
       $this->erro_campo = "si54_dscprovidencia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     
    if($this->si54_seqriscofiscal == null ){ 
       $this->erro_sql = " Campo sequencial do risco fiscal nao informado.";
       $this->erro_campo = "si54_seqriscofiscal";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     
     
     if($this->si54_valorassociado == null ){ 
       $this->erro_sql = " Campo Valor nao Informado.";
       $this->erro_campo = "si54_valorassociado";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
      
   if(($this->si54_sequencial == null) || ($this->si54_sequencial == "") ){
			$result = db_query("select nextval('riscoprovidencia_si54_sequencial_seq')");
			if($result==false){
				$this->erro_banco = str_replace("\n","",@pg_last_error());
				$this->erro_sql   = "Verifique o cadastro da sequencia: riscoprovidencia_si54_sequencial_seq do campo: si54_sequencial";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}
			$this->si54_sequencial = pg_result($result,0,0);
		}else{
			$result = db_query("select last_value from riscoprovidencia_si54_sequencial_seq");
			if(($result != false) && (pg_result($result,0,0) < $si54_sequencial)){
				$this->erro_sql = " Campo si54_sequencial maior que último número da sequencia.";
				$this->erro_banco = "Sequencia menor que este número.";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}else{
				$this->si54_sequencial = $si54_sequencial;
			}
		}
     
     
     $sql = "insert into riscoprovidencia(
                                        si54_sequencial 
                                       ,si54_seqriscofiscal
                                       ,si54_dscprovidencia 
                                       ,si54_valorassociado 
                       )
                values (
                                $this->si54_sequencial
                                ,$this->si54_seqriscofiscal 
                               ,'$this->si54_dscprovidencia' 
                               ,$this->si54_valorassociado 
                      )";//echo $sql;exit;
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Riscoprovidencia ($this->si54_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Riscoprovidencia já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Riscoprovidencia ($this->si54_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si54_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si54_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009980,'$this->si54_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010283,2009980,'','".AddSlashes(pg_result($resaco,0,'si54_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       
       $resac = db_query("insert into db_acount values($acount,2010283,2009982,'','".AddSlashes(pg_result($resaco,0,'si54_dscprovidencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010283,2009983,'','".AddSlashes(pg_result($resaco,0,'si54_valorassociado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si54_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update riscoprovidencia set ";
     $virgula = "";
     if(trim($this->si54_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si54_sequencial"])){ 
       $sql  .= $virgula." si54_sequencial = $this->si54_sequencial ";
       $virgula = ",";
       if(trim($this->si54_sequencial) == null ){ 
         $this->erro_sql = " Campo Codigo Risco nao Informado.";
         $this->erro_campo = "si54_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     
     if(trim($this->si54_dscprovidencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si54_dscprovidencia"])){ 
       $sql  .= $virgula." si54_dscprovidencia = '$this->si54_dscprovidencia' ";
       $virgula = ",";
       if(trim($this->si54_dscprovidencia) == null ){ 
         $this->erro_sql = " Campo Descrição nao Informado.";
         $this->erro_campo = "si54_dscprovidencia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si54_valorassociado)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si54_valorassociado"])){ 
       $sql  .= $virgula." si54_valorassociado = $this->si54_valorassociado ";
       $virgula = ",";
       if(trim($this->si54_valorassociado) == null ){ 
         $this->erro_sql = " Campo Valor nao Informado.";
         $this->erro_campo = "si54_valorassociado";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si54_sequencial!=null){
       $sql .= " si54_sequencial = $this->si54_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si54_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009980,'$this->si54_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si54_sequencial"]) || $this->si54_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010283,2009980,'".AddSlashes(pg_result($resaco,$conresaco,'si54_sequencial'))."','$this->si54_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         
           
         if(isset($GLOBALS["HTTP_POST_VARS"]["si54_dscprovidencia"]) || $this->si54_dscprovidencia != "")
           $resac = db_query("insert into db_acount values($acount,2010283,2009982,'".AddSlashes(pg_result($resaco,$conresaco,'si54_dscprovidencia'))."','$this->si54_dscprovidencia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si54_valorassociado"]) || $this->si54_valorassociado != "")
           $resac = db_query("insert into db_acount values($acount,2010283,2009983,'".AddSlashes(pg_result($resaco,$conresaco,'si54_valorassociado'))."','$this->si54_valorassociado',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Riscoprovidencia nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si54_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Riscoprovidencia nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si54_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si54_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si54_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si54_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009980,'$si54_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010283,2009980,'','".AddSlashes(pg_result($resaco,$iresaco,'si54_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         
         $resac = db_query("insert into db_acount values($acount,2010283,2009982,'','".AddSlashes(pg_result($resaco,$iresaco,'si54_dscprovidencia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010283,2009983,'','".AddSlashes(pg_result($resaco,$iresaco,'si54_valorassociado'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from riscoprovidencia
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si54_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si54_sequencial = $si54_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Riscoprovidencia nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si54_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Riscoprovidencia nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si54_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si54_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:riscoprovidencia";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si54_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from riscoprovidencia ";
     $sql .= "      inner join riscofiscal  on  riscofiscal.si53_sequencial = riscoprovidencia.si54_sequencial";
     $sql .= "      inner join ppaversao  on  ppaversao.o119_sequencial = riscofiscal.si53_codigoppa";
     $sql2 = "";
     if($dbwhere==""){
       if($si54_sequencial!=null ){
         $sql2 .= " where riscoprovidencia.si54_sequencial = $si54_sequencial "; 
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
   function sql_query_file ( $si54_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from riscoprovidencia ";
     $sql2 = "";
     if($dbwhere==""){
       if($si54_sequencial!=null ){
         $sql2 .= " where riscoprovidencia.si54_sequencial = $si54_sequencial "; 
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
