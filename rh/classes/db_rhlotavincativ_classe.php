<?
//MODULO: pessoal
//CLASSE DA ENTIDADE rhlotavincativ
class cl_rhlotavincativ { 
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
   var $rh39_codlotavinc = 0; 
   var $rh39_codelenov = 0; 
   var $rh39_anousu = 0; 
   var $rh39_projativ = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 rh39_codlotavinc = int8 = Código 
                 rh39_codelenov = int4 = Código Elemento 
                 rh39_anousu = int4 = Exercício 
                 rh39_projativ = int4 = Projetos / Atividades 
                 ";
   //funcao construtor da classe 
   function cl_rhlotavincativ() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("rhlotavincativ"); 
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
       $this->rh39_codlotavinc = ($this->rh39_codlotavinc == ""?@$GLOBALS["HTTP_POST_VARS"]["rh39_codlotavinc"]:$this->rh39_codlotavinc);
       $this->rh39_codelenov = ($this->rh39_codelenov == ""?@$GLOBALS["HTTP_POST_VARS"]["rh39_codelenov"]:$this->rh39_codelenov);
       $this->rh39_anousu = ($this->rh39_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["rh39_anousu"]:$this->rh39_anousu);
       $this->rh39_projativ = ($this->rh39_projativ == ""?@$GLOBALS["HTTP_POST_VARS"]["rh39_projativ"]:$this->rh39_projativ);
     }else{
       $this->rh39_codlotavinc = ($this->rh39_codlotavinc == ""?@$GLOBALS["HTTP_POST_VARS"]["rh39_codlotavinc"]:$this->rh39_codlotavinc);
       $this->rh39_codelenov = ($this->rh39_codelenov == ""?@$GLOBALS["HTTP_POST_VARS"]["rh39_codelenov"]:$this->rh39_codelenov);
     }
   }
   // funcao para inclusao
   function incluir ($rh39_codlotavinc,$rh39_codelenov){ 
      $this->atualizacampos();
     if($this->rh39_anousu == null ){ 
       $this->erro_sql = " Campo Exercício nao Informado.";
       $this->erro_campo = "rh39_anousu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->rh39_projativ == null ){ 
       $this->erro_sql = " Campo Projetos / Atividades nao Informado.";
       $this->erro_campo = "rh39_projativ";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->rh39_codlotavinc = $rh39_codlotavinc; 
       $this->rh39_codelenov = $rh39_codelenov; 
     if(($this->rh39_codlotavinc == null) || ($this->rh39_codlotavinc == "") ){ 
       $this->erro_sql = " Campo rh39_codlotavinc nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->rh39_codelenov == null) || ($this->rh39_codelenov == "") ){ 
       $this->erro_sql = " Campo rh39_codelenov nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into rhlotavincativ(
                                       rh39_codlotavinc 
                                      ,rh39_codelenov 
                                      ,rh39_anousu 
                                      ,rh39_projativ 
                       )
                values (
                                $this->rh39_codlotavinc 
                               ,$this->rh39_codelenov 
                               ,$this->rh39_anousu 
                               ,$this->rh39_projativ 
                      )";
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Atividade secundária ($this->rh39_codlotavinc."-".$this->rh39_codelenov) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Atividade secundária já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Atividade secundária ($this->rh39_codlotavinc."-".$this->rh39_codelenov) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh39_codlotavinc."-".$this->rh39_codelenov;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->rh39_codlotavinc,$this->rh39_codelenov));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,7241,'$this->rh39_codlotavinc','I')");
       $resac = pg_query("insert into db_acountkey values($acount,7242,'$this->rh39_codelenov','I')");
       $resac = pg_query("insert into db_acount values($acount,1201,7241,'','".AddSlashes(pg_result($resaco,0,'rh39_codlotavinc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,1201,7242,'','".AddSlashes(pg_result($resaco,0,'rh39_codelenov'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,1201,7244,'','".AddSlashes(pg_result($resaco,0,'rh39_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,1201,7243,'','".AddSlashes(pg_result($resaco,0,'rh39_projativ'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($rh39_codlotavinc=null,$rh39_codelenov=null) { 
      $this->atualizacampos();
     $sql = " update rhlotavincativ set ";
     $virgula = "";
     if(trim($this->rh39_codlotavinc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh39_codlotavinc"])){ 
       $sql  .= $virgula." rh39_codlotavinc = $this->rh39_codlotavinc ";
       $virgula = ",";
       if(trim($this->rh39_codlotavinc) == null ){ 
         $this->erro_sql = " Campo Código nao Informado.";
         $this->erro_campo = "rh39_codlotavinc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->rh39_codelenov)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh39_codelenov"])){ 
       $sql  .= $virgula." rh39_codelenov = $this->rh39_codelenov ";
       $virgula = ",";
       if(trim($this->rh39_codelenov) == null ){ 
         $this->erro_sql = " Campo Código Elemento nao Informado.";
         $this->erro_campo = "rh39_codelenov";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->rh39_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh39_anousu"])){ 
       $sql  .= $virgula." rh39_anousu = $this->rh39_anousu ";
       $virgula = ",";
       if(trim($this->rh39_anousu) == null ){ 
         $this->erro_sql = " Campo Exercício nao Informado.";
         $this->erro_campo = "rh39_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->rh39_projativ)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh39_projativ"])){ 
       $sql  .= $virgula." rh39_projativ = $this->rh39_projativ ";
       $virgula = ",";
       if(trim($this->rh39_projativ) == null ){ 
         $this->erro_sql = " Campo Projetos / Atividades nao Informado.";
         $this->erro_campo = "rh39_projativ";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($rh39_codlotavinc!=null){
       $sql .= " rh39_codlotavinc = $this->rh39_codlotavinc";
     }
     if($rh39_codelenov!=null){
       $sql .= " and  rh39_codelenov = $this->rh39_codelenov";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->rh39_codlotavinc,$this->rh39_codelenov));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,7241,'$this->rh39_codlotavinc','A')");
         $resac = pg_query("insert into db_acountkey values($acount,7242,'$this->rh39_codelenov','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["rh39_codlotavinc"]))
           $resac = pg_query("insert into db_acount values($acount,1201,7241,'".AddSlashes(pg_result($resaco,$conresaco,'rh39_codlotavinc'))."','$this->rh39_codlotavinc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["rh39_codelenov"]))
           $resac = pg_query("insert into db_acount values($acount,1201,7242,'".AddSlashes(pg_result($resaco,$conresaco,'rh39_codelenov'))."','$this->rh39_codelenov',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["rh39_anousu"]))
           $resac = pg_query("insert into db_acount values($acount,1201,7244,'".AddSlashes(pg_result($resaco,$conresaco,'rh39_anousu'))."','$this->rh39_anousu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["rh39_projativ"]))
           $resac = pg_query("insert into db_acount values($acount,1201,7243,'".AddSlashes(pg_result($resaco,$conresaco,'rh39_projativ'))."','$this->rh39_projativ',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Atividade secundária nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh39_codlotavinc."-".$this->rh39_codelenov;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Atividade secundária nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh39_codlotavinc."-".$this->rh39_codelenov;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh39_codlotavinc."-".$this->rh39_codelenov;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($rh39_codlotavinc=null,$rh39_codelenov=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($rh39_codlotavinc,$rh39_codelenov));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,7241,'$rh39_codlotavinc','E')");
         $resac = pg_query("insert into db_acountkey values($acount,7242,'$rh39_codelenov','E')");
         $resac = pg_query("insert into db_acount values($acount,1201,7241,'','".AddSlashes(pg_result($resaco,$iresaco,'rh39_codlotavinc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,1201,7242,'','".AddSlashes(pg_result($resaco,$iresaco,'rh39_codelenov'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,1201,7244,'','".AddSlashes(pg_result($resaco,$iresaco,'rh39_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,1201,7243,'','".AddSlashes(pg_result($resaco,$iresaco,'rh39_projativ'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from rhlotavincativ
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($rh39_codlotavinc != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " rh39_codlotavinc = $rh39_codlotavinc ";
        }
        if($rh39_codelenov != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " rh39_codelenov = $rh39_codelenov ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Atividade secundária nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$rh39_codlotavinc."-".$rh39_codelenov;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Atividade secundária nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$rh39_codlotavinc."-".$rh39_codelenov;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$rh39_codlotavinc."-".$rh39_codelenov;
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
        $this->erro_sql   = "Record Vazio na Tabela:rhlotavincativ";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $rh39_codlotavinc=null,$rh39_codelenov=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from rhlotavincativ ";
     $sql .= "      inner join orcprojativ  on  orcprojativ.o55_anousu = rhlotavincativ.rh39_anousu and  orcprojativ.o55_projativ = rhlotavincativ.rh39_projativ";
     $sql .= "      inner join rhlotavinc  on  rhlotavinc.rh25_codlotavinc = rhlotavincativ.rh39_codlotavinc";
     $sql .= "      inner join db_config  on  db_config.codigo = orcprojativ.o55_instit";
     $sql .= "      inner join db_config  as a on   a.codigo = orcprojativ.o55_instit";
     $sql .= "      inner join orctiporec  on  orctiporec.o15_codigo = rhlotavinc.rh25_recurso";
     $sql .= "      inner join orcprojativ  on  orcprojativ.o55_anousu = rhlotavinc.rh25_anousu and  orcprojativ.o55_projativ = rhlotavinc.rh25_projativ";
     $sql .= "      inner join rhlota  as b on   b.r70_codigo = rhlotavinc.rh25_codigo";
     $sql2 = "";
     if($dbwhere==""){
       if($rh39_codlotavinc!=null ){
         $sql2 .= " where rhlotavincativ.rh39_codlotavinc = $rh39_codlotavinc "; 
       } 
       if($rh39_codelenov!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " rhlotavincativ.rh39_codelenov = $rh39_codelenov "; 
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
   function sql_query_file ( $rh39_codlotavinc=null,$rh39_codelenov=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from rhlotavincativ ";
     $sql2 = "";
     if($dbwhere==""){
       if($rh39_codlotavinc!=null ){
         $sql2 .= " where rhlotavincativ.rh39_codlotavinc = $rh39_codlotavinc "; 
       } 
       if($rh39_codelenov!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " rhlotavincativ.rh39_codelenov = $rh39_codelenov "; 
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
