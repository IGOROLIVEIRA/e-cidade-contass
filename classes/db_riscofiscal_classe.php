<?
//MODULO: sicom
//CLASSE DA ENTIDADE riscofiscal
class cl_riscofiscal { 
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
   var $si53_sequencial = 0; 
   var $si53_exercicio = null; 
   var $si53_codigoppa = 0; 
   var $si53_dscriscofiscal = null; 
   var $si53_codriscofiscal = 0; 
   var $si53_valorisco = 0;
   var $si53_instit = 0;  
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 si53_sequencial = int8 = Código Sequencial do Risco 
                 si53_exercicio = varchar(10) = Exercicio 
                 si53_codigoppa = int8 = Perspectiva PPA 
                 si53_dscriscofiscal = text = Descrição 
                 si53_codriscofiscal = int8 = Codigo Risco 
                 si53_valorisco = float8 = Valor do Risco 
                 si53_instit  = int8 = Instituição
                 ";
   //funcao construtor da classe 
   function cl_riscofiscal() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("riscofiscal"); 
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
       $this->si53_sequencial = ($this->si53_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si53_sequencial"]:$this->si53_sequencial);
       $this->si53_exercicio = ($this->si53_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["si53_exercicio"]:$this->si53_exercicio);
       $this->si53_codigoppa = ($this->si53_codigoppa == ""?@$GLOBALS["HTTP_POST_VARS"]["si53_codigoppa"]:$this->si53_codigoppa);
       $this->si53_dscriscofiscal = ($this->si53_dscriscofiscal == ""?@$GLOBALS["HTTP_POST_VARS"]["si53_dscriscofiscal"]:$this->si53_dscriscofiscal);
       $this->si53_codriscofiscal = ($this->si53_codriscofiscal == ""?@$GLOBALS["HTTP_POST_VARS"]["si53_codriscofiscal"]:$this->si53_codriscofiscal);
       $this->si53_valorisco = ($this->si53_valorisco == ""?@$GLOBALS["HTTP_POST_VARS"]["si53_valorisco"]:$this->si53_valorisco);
       $this->si53_instit = ($this->si53_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si53_instit"]:$this->si53_instit);
     }else{
       $this->si53_sequencial = ($this->si53_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si53_sequencial"]:$this->si53_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si53_sequencial){ 
      $this->atualizacampos();
     if($this->si53_exercicio == null ){ 
       $this->erro_sql = " Campo Exercicio nao Informado.";
       $this->erro_campo = "si53_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si53_codigoppa == null ){ 
       $this->erro_sql = " Campo Perspectiva PPA nao Informado.";
       $this->erro_campo = "si53_codigoppa";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si53_codriscofiscal == null ){ 
       $this->erro_sql = " Campo Codigo Risco nao Informado.";
       $this->erro_campo = "si53_codriscofiscal";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     
    if($this->si53_instit == null ){ 
       $this->erro_sql = " Campo Codigo Instituicao nao Informado.";
       $this->erro_campo = "si53_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     
     if($this->si53_valorisco == null ){ 
       $this->erro_sql = " Campo Valor do Risco nao Informado.";
       $this->erro_campo = "si53_valorisco";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
      
   if(($this->si53_sequencial == null) || ($this->si53_sequencial == "") ){
			$result = db_query("select nextval('riscofiscal_si53_sequencia_seq')");
			if($result==false){
				$this->erro_banco = str_replace("\n","",@pg_last_error());
				$this->erro_sql   = "Verifique o cadastro da sequencia: riscofiscal_si53_sequencia_seq do campo: si53_sequencial";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}
			$this->si53_sequencial = pg_result($result,0,0);
		}else{
			$result = db_query("select last_value from riscofiscal_si53_sequencia_seq");
			if(($result != false) && (pg_result($result,0,0) < $si53_sequencial)){
				$this->erro_sql = " Campo si53_sequencial maior que último número da sequencia.";
				$this->erro_banco = "Sequencia menor que este número.";
				$this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
				$this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
				$this->erro_status = "0";
				return false;
			}else{
				$this->si53_sequencial = $si53_sequencial;
			}
		}
     
     
     
     
     
     
     $sql = "insert into riscofiscal(
                                       si53_sequencial 
                                      ,si53_exercicio 
                                      ,si53_codigoppa 
                                      ,si53_dscriscofiscal 
                                      ,si53_codriscofiscal 
                                      ,si53_valorisco 
                                      ,si53_instit
                       )
                values (
                                $this->si53_sequencial 
                               ,'$this->si53_exercicio' 
                               ,$this->si53_codigoppa 
                               ,'$this->si53_dscriscofiscal' 
                               ,$this->si53_codriscofiscal 
                               ,$this->si53_valorisco
                               ,$this->si53_instit 
                      )"; //echo $sql;exit;
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "RISCOS FISCAIS ($this->si53_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "RISCOS FISCAIS já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "RISCOS FISCAIS ($this->si53_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si53_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si53_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009973,'$this->si53_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010282,2009973,'','".AddSlashes(pg_result($resaco,0,'si53_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010282,2009976,'','".AddSlashes(pg_result($resaco,0,'si53_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010282,2009974,'','".AddSlashes(pg_result($resaco,0,'si53_codigoppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010282,2009977,'','".AddSlashes(pg_result($resaco,0,'si53_dscriscofiscal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010282,2009979,'','".AddSlashes(pg_result($resaco,0,'si53_codriscofiscal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010282,2009978,'','".AddSlashes(pg_result($resaco,0,'si53_valorisco'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($si53_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update riscofiscal set ";
     $virgula = "";
     if(trim($this->si53_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si53_sequencial"])){ 
       $sql  .= $virgula." si53_sequencial = $this->si53_sequencial ";
       $virgula = ",";
       if(trim($this->si53_sequencial) == null ){ 
         $this->erro_sql = " Campo Código Sequencial do Risco nao Informado.";
         $this->erro_campo = "si53_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si53_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si53_exercicio"])){ 
       $sql  .= $virgula." si53_exercicio = '$this->si53_exercicio' ";
       $virgula = ",";
       if(trim($this->si53_exercicio) == null ){ 
         $this->erro_sql = " Campo Exercicio nao Informado.";
         $this->erro_campo = "si53_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si53_codigoppa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si53_codigoppa"])){ 
       $sql  .= $virgula." si53_codigoppa = $this->si53_codigoppa ";
       $virgula = ",";
       if(trim($this->si53_codigoppa) == null ){ 
         $this->erro_sql = " Campo Perspectiva PPA nao Informado.";
         $this->erro_campo = "si53_codigoppa";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si53_dscriscofiscal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si53_dscriscofiscal"])){ 
       $sql  .= $virgula." si53_dscriscofiscal = '$this->si53_dscriscofiscal' ";
       $virgula = ",";
     }
     if(trim($this->si53_codriscofiscal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si53_codriscofiscal"])){ 
       $sql  .= $virgula." si53_codriscofiscal = $this->si53_codriscofiscal ";
       $virgula = ",";
       if(trim($this->si53_codriscofiscal) == null ){ 
         $this->erro_sql = " Campo Codigo Risco nao Informado.";
         $this->erro_campo = "si53_codriscofiscal";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     
   if(trim($this->si53_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si53_instit"])){ 
       $sql  .= $virgula." si53_instit = $this->si53_instit ";
       $virgula = ",";
       if(trim($this->si53_instit) == null ){ 
         $this->erro_sql = " Campo Codigo Instituicao nao Informado.";
         $this->erro_campo = "si53_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     
     if(trim($this->si53_valorisco)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si53_valorisco"])){ 
       $sql  .= $virgula." si53_valorisco = $this->si53_valorisco ";
       $virgula = ",";
       if(trim($this->si53_valorisco) == null ){ 
         $this->erro_sql = " Campo Valor do Risco nao Informado.";
         $this->erro_campo = "si53_valorisco";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si53_sequencial!=null){
       $sql .= " si53_sequencial = $this->si53_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si53_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009973,'$this->si53_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si53_sequencial"]) || $this->si53_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010282,2009973,'".AddSlashes(pg_result($resaco,$conresaco,'si53_sequencial'))."','$this->si53_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si53_exercicio"]) || $this->si53_exercicio != "")
           $resac = db_query("insert into db_acount values($acount,2010282,2009976,'".AddSlashes(pg_result($resaco,$conresaco,'si53_exercicio'))."','$this->si53_exercicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si53_codigoppa"]) || $this->si53_codigoppa != "")
           $resac = db_query("insert into db_acount values($acount,2010282,2009974,'".AddSlashes(pg_result($resaco,$conresaco,'si53_codigoppa'))."','$this->si53_codigoppa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si53_dscriscofiscal"]) || $this->si53_dscriscofiscal != "")
           $resac = db_query("insert into db_acount values($acount,2010282,2009977,'".AddSlashes(pg_result($resaco,$conresaco,'si53_dscriscofiscal'))."','$this->si53_dscriscofiscal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si53_codriscofiscal"]) || $this->si53_codriscofiscal != "")
           $resac = db_query("insert into db_acount values($acount,2010282,2009979,'".AddSlashes(pg_result($resaco,$conresaco,'si53_codriscofiscal'))."','$this->si53_codriscofiscal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si53_valorisco"]) || $this->si53_valorisco != "")
           $resac = db_query("insert into db_acount values($acount,2010282,2009978,'".AddSlashes(pg_result($resaco,$conresaco,'si53_valorisco'))."','$this->si53_valorisco',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }//echo $sql;exit;
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "RISCOS FISCAIS nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si53_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "RISCOS FISCAIS nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si53_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si53_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si53_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si53_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009973,'$si53_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010282,2009973,'','".AddSlashes(pg_result($resaco,$iresaco,'si53_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010282,2009976,'','".AddSlashes(pg_result($resaco,$iresaco,'si53_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010282,2009974,'','".AddSlashes(pg_result($resaco,$iresaco,'si53_codigoppa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010282,2009977,'','".AddSlashes(pg_result($resaco,$iresaco,'si53_dscriscofiscal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010282,2009979,'','".AddSlashes(pg_result($resaco,$iresaco,'si53_codriscofiscal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010282,2009978,'','".AddSlashes(pg_result($resaco,$iresaco,'si53_valorisco'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from riscofiscal
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si53_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si53_sequencial = $si53_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "RISCOS FISCAIS nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si53_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "RISCOS FISCAIS nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si53_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si53_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:riscofiscal";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si53_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from riscofiscal ";
     $sql .= "      inner join ppaversao  on  ppaversao.o119_sequencial = riscofiscal.si53_codigoppa";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = ppaversao.o119_idusuario";
     $sql .= "      inner join ppalei  on  ppalei.o01_sequencial = ppaversao.o119_ppalei";
     $sql2 = "";
     if($dbwhere==""){
       if($si53_sequencial!=null ){
         $sql2 .= " where riscofiscal.si53_sequencial = $si53_sequencial "; 
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
   function sql_query_file ( $si53_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from riscofiscal ";
     $sql2 = "";
     if($dbwhere==""){
       if($si53_sequencial!=null ){
         $sql2 .= " where riscofiscal.si53_sequencial = $si53_sequencial "; 
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
