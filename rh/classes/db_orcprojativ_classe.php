<?
//MODULO: orcamento
//CLASSE DA ENTIDADE orcprojativ
class cl_orcprojativ { 
   // cria variaveis de erro 
   var $rotulo     = null; 
   var $query_sql  = null; 
   var $numrows    = 0; 
   var $erro_status= null; 
   var $erro_sql   = null; 
   var $erro_banco = null;  
   var $erro_msg   = null;  
   var $erro_campo = null;  
   var $pagina_retorno = null; 
   // cria variaveis do arquivo 
   var $o55_anousu = 0; 
   var $o55_tipo = 0; 
   var $o55_projativ = 0; 
   var $o55_descr = null; 
   var $o55_finali = null; 
   var $o55_instit = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 o55_anousu = int4 = Exercício 
                 o55_tipo = int4 = Tipo 
                 o55_projativ = int4 = Projetos / Atividades 
                 o55_descr = varchar(40) = Descrição 
                 o55_finali = text = Finalidade 
                 o55_instit = int4 = Código da instituicao 
                 ";
   //funcao construtor da classe 
   function cl_orcprojativ() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("orcprojativ"); 
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
       $this->o55_anousu = ($this->o55_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["o55_anousu"]:$this->o55_anousu);
       $this->o55_tipo = ($this->o55_tipo == ""?@$GLOBALS["HTTP_POST_VARS"]["o55_tipo"]:$this->o55_tipo);
       $this->o55_projativ = ($this->o55_projativ == ""?@$GLOBALS["HTTP_POST_VARS"]["o55_projativ"]:$this->o55_projativ);
       $this->o55_descr = ($this->o55_descr == ""?@$GLOBALS["HTTP_POST_VARS"]["o55_descr"]:$this->o55_descr);
       $this->o55_finali = ($this->o55_finali == ""?@$GLOBALS["HTTP_POST_VARS"]["o55_finali"]:$this->o55_finali);
       $this->o55_instit = ($this->o55_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["o55_instit"]:$this->o55_instit);
     }else{
       $this->o55_anousu = ($this->o55_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["o55_anousu"]:$this->o55_anousu);
       $this->o55_projativ = ($this->o55_projativ == ""?@$GLOBALS["HTTP_POST_VARS"]["o55_projativ"]:$this->o55_projativ);
     }
   }
   // funcao para inclusao
   function incluir ($o55_anousu,$o55_projativ){ 
      $this->atualizacampos();
     if($this->o55_tipo == null ){ 
       $this->erro_sql = " Campo Tipo nao Informado.";
       $this->erro_campo = "o55_tipo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o55_descr == null ){ 
       $this->erro_sql = " Campo Descrição nao Informado.";
       $this->erro_campo = "o55_descr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->o55_instit == null ){ 
       $this->erro_sql = " Campo Código da instituicao nao Informado.";
       $this->erro_campo = "o55_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->o55_anousu = $o55_anousu; 
       $this->o55_projativ = $o55_projativ; 
     if(($this->o55_anousu == null) || ($this->o55_anousu == "") ){ 
       $this->erro_sql = " Campo o55_anousu nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->o55_projativ == null) || ($this->o55_projativ == "") ){ 
       $this->erro_sql = " Campo o55_projativ nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into orcprojativ(
                                       o55_anousu 
                                      ,o55_tipo 
                                      ,o55_projativ 
                                      ,o55_descr 
                                      ,o55_finali 
                                      ,o55_instit 
                       )
                values (
                                $this->o55_anousu 
                               ,$this->o55_tipo 
                               ,$this->o55_projativ 
                               ,'$this->o55_descr' 
                               ,'$this->o55_finali' 
                               ,$this->o55_instit 
                      )";
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Projetos / Atividades ($this->o55_anousu."-".$this->o55_projativ) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Projetos / Atividades já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Projetos / Atividades ($this->o55_anousu."-".$this->o55_projativ) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o55_anousu."-".$this->o55_projativ;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $resaco = $this->sql_record($this->sql_query_file($this->o55_anousu,$this->o55_projativ));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,5084,'$this->o55_anousu','I')");
       $resac = pg_query("insert into db_acountkey values($acount,5085,'$this->o55_projativ','I')");
       $resac = pg_query("insert into db_acount values($acount,725,5084,'','".pg_result($resaco,0,'o55_anousu')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,725,5086,'','".pg_result($resaco,0,'o55_tipo')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,725,5085,'','".pg_result($resaco,0,'o55_projativ')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,725,5089,'','".pg_result($resaco,0,'o55_descr')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,725,5087,'','".pg_result($resaco,0,'o55_finali')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,725,5088,'','".pg_result($resaco,0,'o55_instit')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($o55_anousu=null,$o55_projativ=null) { 
      $this->atualizacampos();
     $sql = " update orcprojativ set ";
     $virgula = "";
     if(trim($this->o55_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o55_anousu"])){ 
       $sql  .= $virgula." o55_anousu = $this->o55_anousu ";
       $virgula = ",";
       if(trim($this->o55_anousu) == null ){ 
         $this->erro_sql = " Campo Exercício nao Informado.";
         $this->erro_campo = "o55_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o55_tipo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o55_tipo"])){ 
       $sql  .= $virgula." o55_tipo = $this->o55_tipo ";
       $virgula = ",";
       if(trim($this->o55_tipo) == null ){ 
         $this->erro_sql = " Campo Tipo nao Informado.";
         $this->erro_campo = "o55_tipo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o55_projativ)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o55_projativ"])){ 
       $sql  .= $virgula." o55_projativ = $this->o55_projativ ";
       $virgula = ",";
       if(trim($this->o55_projativ) == null ){ 
         $this->erro_sql = " Campo Projetos / Atividades nao Informado.";
         $this->erro_campo = "o55_projativ";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o55_descr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o55_descr"])){ 
       $sql  .= $virgula." o55_descr = '$this->o55_descr' ";
       $virgula = ",";
       if(trim($this->o55_descr) == null ){ 
         $this->erro_sql = " Campo Descrição nao Informado.";
         $this->erro_campo = "o55_descr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o55_finali)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o55_finali"])){ 
       $sql  .= $virgula." o55_finali = '$this->o55_finali' ";
       $virgula = ",";
       if(trim($this->o55_finali) == null ){ 
         $this->erro_sql = " Campo Finalidade nao Informado.";
         $this->erro_campo = "o55_finali";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->o55_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o55_instit"])){ 
       $sql  .= $virgula." o55_instit = $this->o55_instit ";
       $virgula = ",";
       if(trim($this->o55_instit) == null ){ 
         $this->erro_sql = " Campo Código da instituicao nao Informado.";
         $this->erro_campo = "o55_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where  o55_anousu = $this->o55_anousu
 and  o55_projativ = $this->o55_projativ
";
     $resaco = $this->sql_record($this->sql_query_file($this->o55_anousu,$this->o55_projativ));
     if($this->numrows>0){       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,5084,'$this->o55_anousu','A')");
       $resac = pg_query("insert into db_acountkey values($acount,5085,'$this->o55_projativ','A')");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o55_anousu"]))
         $resac = pg_query("insert into db_acount values($acount,725,5084,'".pg_result($resaco,0,'o55_anousu')."','$this->o55_anousu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o55_tipo"]))
         $resac = pg_query("insert into db_acount values($acount,725,5086,'".pg_result($resaco,0,'o55_tipo')."','$this->o55_tipo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o55_projativ"]))
         $resac = pg_query("insert into db_acount values($acount,725,5085,'".pg_result($resaco,0,'o55_projativ')."','$this->o55_projativ',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o55_descr"]))
         $resac = pg_query("insert into db_acount values($acount,725,5089,'".pg_result($resaco,0,'o55_descr')."','$this->o55_descr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o55_finali"]))
         $resac = pg_query("insert into db_acount values($acount,725,5087,'".pg_result($resaco,0,'o55_finali')."','$this->o55_finali',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       if(isset($GLOBALS["HTTP_POST_VARS"]["o55_instit"]))
         $resac = pg_query("insert into db_acount values($acount,725,5088,'".pg_result($resaco,0,'o55_instit')."','$this->o55_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Projetos / Atividades nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->o55_anousu."-".$this->o55_projativ;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Projetos / Atividades nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->o55_anousu."-".$this->o55_projativ;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o55_anousu."-".$this->o55_projativ;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($o55_anousu=null,$o55_projativ=null) { 
     $resaco = $this->sql_record($this->sql_query_file($o55_anousu,$o55_projativ));
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,5084,'$this->o55_anousu','E')");
         $resac = pg_query("insert into db_acountkey values($acount,5085,'$this->o55_projativ','E')");
         $resac = pg_query("insert into db_acount values($acount,725,5084,'','".pg_result($resaco,$iresaco,'o55_anousu')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,725,5086,'','".pg_result($resaco,$iresaco,'o55_tipo')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,725,5085,'','".pg_result($resaco,$iresaco,'o55_projativ')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,725,5089,'','".pg_result($resaco,$iresaco,'o55_descr')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,725,5087,'','".pg_result($resaco,$iresaco,'o55_finali')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,725,5088,'','".pg_result($resaco,$iresaco,'o55_instit')."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from orcprojativ
                    where ";
     $sql2 = "";
      if($o55_anousu != ""){
      if($sql2!=""){
        $sql2 .= " and ";
      }
      $sql2 .= " o55_anousu = $o55_anousu ";
}
      if($o55_projativ != ""){
      if($sql2!=""){
        $sql2 .= " and ";
      }
      $sql2 .= " o55_projativ = $o55_projativ ";
}
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Projetos / Atividades nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$o55_anousu."-".$o55_projativ;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Projetos / Atividades nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$o55_anousu."-".$o55_projativ;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$o55_anousu."-".$o55_projativ;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao do recordset 
   function sql_record($sql) { 
     $result = @pg_query($sql);
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
        $this->erro_sql   = "Dados do Grupo nao Encontrado";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query_rh ( $o55_anousu=null,$o55_projativ=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcprojativ ";
     $sql .= "      inner join db_config  on  db_config.codigo = orcprojativ.o55_instit ";
     $sql .= "      inner join orcdotacao on orcdotacao.o58_projativ = orcprojativ.o55_projativ 
                           and orcdotacao.o58_anousu = orcprojativ.o55_anousu ";
     $sql2 = "";
     if($dbwhere==""){
       if($o55_anousu!=null ){
         $sql2 .= " where orcprojativ.o55_anousu = $o55_anousu "; 
       } 
       if($o55_projativ!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " orcprojativ.o55_projativ = $o55_projativ "; 
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
   function sql_query ( $o55_anousu=null,$o55_projativ=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcprojativ ";
     $sql .= "      inner join db_config  on  db_config.codigo = orcprojativ.o55_instit";
     $sql2 = "";
     if($dbwhere==""){
       if($o55_anousu!=null ){
         $sql2 .= " where orcprojativ.o55_anousu = $o55_anousu "; 
       } 
       if($o55_projativ!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " orcprojativ.o55_projativ = $o55_projativ "; 
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
   function sql_query_file ( $o55_anousu=null,$o55_projativ=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from orcprojativ ";
     $sql2 = "";
     if($dbwhere==""){
       if($o55_anousu!=null ){
         $sql2 .= " where orcprojativ.o55_anousu = $o55_anousu "; 
       } 
       if($o55_projativ!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " orcprojativ.o55_projativ = $o55_projativ "; 
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
