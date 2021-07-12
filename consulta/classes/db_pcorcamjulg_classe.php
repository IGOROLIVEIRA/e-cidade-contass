<?
//MODULO: compras
//CLASSE DA ENTIDADE pcorcamjulg
class cl_pcorcamjulg { 
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
   var $pc24_orcamitem = 0; 
   var $pc24_pontuacao = 0; 
   var $pc24_orcamforne = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 pc24_orcamitem = int4 = Código sequencial do item no orçamento 
                 pc24_pontuacao = int4 = Pontuação 
                 pc24_orcamforne = int8 = Código do orcamento deste fornecedor 
                 ";
   //funcao construtor da classe 
   function cl_pcorcamjulg() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("pcorcamjulg"); 
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
       $this->pc24_orcamitem = ($this->pc24_orcamitem == ""?@$GLOBALS["HTTP_POST_VARS"]["pc24_orcamitem"]:$this->pc24_orcamitem);
       $this->pc24_pontuacao = ($this->pc24_pontuacao == ""?@$GLOBALS["HTTP_POST_VARS"]["pc24_pontuacao"]:$this->pc24_pontuacao);
       $this->pc24_orcamforne = ($this->pc24_orcamforne == ""?@$GLOBALS["HTTP_POST_VARS"]["pc24_orcamforne"]:$this->pc24_orcamforne);
     }else{
       $this->pc24_orcamitem = ($this->pc24_orcamitem == ""?@$GLOBALS["HTTP_POST_VARS"]["pc24_orcamitem"]:$this->pc24_orcamitem);
       $this->pc24_orcamforne = ($this->pc24_orcamforne == ""?@$GLOBALS["HTTP_POST_VARS"]["pc24_orcamforne"]:$this->pc24_orcamforne);
     }
   }
   // funcao para inclusao
   function incluir ($pc24_orcamitem,$pc24_orcamforne){ 
      $this->atualizacampos();
     if($this->pc24_pontuacao == null ){ 
       $this->erro_sql = " Campo Pontuação nao Informado.";
       $this->erro_campo = "pc24_pontuacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->pc24_orcamitem = $pc24_orcamitem; 
       $this->pc24_orcamforne = $pc24_orcamforne; 
     if(($this->pc24_orcamitem == null) || ($this->pc24_orcamitem == "") ){ 
       $this->erro_sql = " Campo pc24_orcamitem nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->pc24_orcamforne == null) || ($this->pc24_orcamforne == "") ){ 
       $this->erro_sql = " Campo pc24_orcamforne nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into pcorcamjulg(
                                       pc24_orcamitem 
                                      ,pc24_pontuacao 
                                      ,pc24_orcamforne 
                       )
                values (
                                $this->pc24_orcamitem 
                               ,$this->pc24_pontuacao 
                               ,$this->pc24_orcamforne 
                      )";
     $result = @pg_exec($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Julgamento dos valores dos itens dos orçamentos ($this->pc24_orcamitem."-".$this->pc24_orcamforne) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Julgamento dos valores dos itens dos orçamentos já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Julgamento dos valores dos itens dos orçamentos ($this->pc24_orcamitem."-".$this->pc24_orcamforne) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->pc24_orcamitem."-".$this->pc24_orcamforne;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->pc24_orcamitem,$this->pc24_orcamforne));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = pg_query("insert into db_acountkey values($acount,5519,'$this->pc24_orcamitem','I')");
       $resac = pg_query("insert into db_acountkey values($acount,6496,'$this->pc24_orcamforne','I')");
       $resac = pg_query("insert into db_acount values($acount,860,5519,'','".AddSlashes(pg_result($resaco,0,'pc24_orcamitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,860,5520,'','".AddSlashes(pg_result($resaco,0,'pc24_pontuacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = pg_query("insert into db_acount values($acount,860,6496,'','".AddSlashes(pg_result($resaco,0,'pc24_orcamforne'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($pc24_orcamitem=null,$pc24_orcamforne=null) { 
      $this->atualizacampos();
     $sql = " update pcorcamjulg set ";
     $virgula = "";
     if(trim($this->pc24_orcamitem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc24_orcamitem"])){ 
       $sql  .= $virgula." pc24_orcamitem = $this->pc24_orcamitem ";
       $virgula = ",";
       if(trim($this->pc24_orcamitem) == null ){ 
         $this->erro_sql = " Campo Código sequencial do item no orçamento nao Informado.";
         $this->erro_campo = "pc24_orcamitem";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->pc24_pontuacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc24_pontuacao"])){ 
       $sql  .= $virgula." pc24_pontuacao = $this->pc24_pontuacao ";
       $virgula = ",";
       if(trim($this->pc24_pontuacao) == null ){ 
         $this->erro_sql = " Campo Pontuação nao Informado.";
         $this->erro_campo = "pc24_pontuacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->pc24_orcamforne)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc24_orcamforne"])){ 
       $sql  .= $virgula." pc24_orcamforne = $this->pc24_orcamforne ";
       $virgula = ",";
       if(trim($this->pc24_orcamforne) == null ){ 
         $this->erro_sql = " Campo Código do orcamento deste fornecedor nao Informado.";
         $this->erro_campo = "pc24_orcamforne";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($pc24_orcamitem!=null){
       $sql .= " pc24_orcamitem = $this->pc24_orcamitem";
     }
     if($pc24_orcamforne!=null){
       $sql .= " and  pc24_orcamforne = $this->pc24_orcamforne";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->pc24_orcamitem,$this->pc24_orcamforne));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,5519,'$this->pc24_orcamitem','A')");
         $resac = pg_query("insert into db_acountkey values($acount,6496,'$this->pc24_orcamforne','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["pc24_orcamitem"]))
           $resac = pg_query("insert into db_acount values($acount,860,5519,'".AddSlashes(pg_result($resaco,$conresaco,'pc24_orcamitem'))."','$this->pc24_orcamitem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["pc24_pontuacao"]))
           $resac = pg_query("insert into db_acount values($acount,860,5520,'".AddSlashes(pg_result($resaco,$conresaco,'pc24_pontuacao'))."','$this->pc24_pontuacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["pc24_orcamforne"]))
           $resac = pg_query("insert into db_acount values($acount,860,6496,'".AddSlashes(pg_result($resaco,$conresaco,'pc24_orcamforne'))."','$this->pc24_orcamforne',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Julgamento dos valores dos itens dos orçamentos nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->pc24_orcamitem."-".$this->pc24_orcamforne;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Julgamento dos valores dos itens dos orçamentos nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->pc24_orcamitem."-".$this->pc24_orcamforne;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->pc24_orcamitem."-".$this->pc24_orcamforne;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($pc24_orcamitem=null,$pc24_orcamforne=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($pc24_orcamitem,$pc24_orcamforne));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = pg_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = pg_query("insert into db_acountkey values($acount,5519,'$this->pc24_orcamitem','E')");
         $resac = pg_query("insert into db_acountkey values($acount,6496,'$this->pc24_orcamforne','E')");
         $resac = pg_query("insert into db_acount values($acount,860,5519,'','".AddSlashes(pg_result($resaco,$iresaco,'pc24_orcamitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,860,5520,'','".AddSlashes(pg_result($resaco,$iresaco,'pc24_pontuacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = pg_query("insert into db_acount values($acount,860,6496,'','".AddSlashes(pg_result($resaco,$iresaco,'pc24_orcamforne'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from pcorcamjulg
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($pc24_orcamitem != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " pc24_orcamitem = $pc24_orcamitem ";
        }
        if($pc24_orcamforne != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " pc24_orcamforne = $pc24_orcamforne ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = @pg_exec($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Julgamento dos valores dos itens dos orçamentos nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$pc24_orcamitem."-".$pc24_orcamforne;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Julgamento dos valores dos itens dos orçamentos nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$pc24_orcamitem."-".$pc24_orcamforne;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$pc24_orcamitem."-".$pc24_orcamforne;
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
        $this->erro_sql   = "Record Vazio na Tabela:pcorcamjulg";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query_geraut( $pc24_orcamitem=null,$pc24_orcamforne=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from pcorcamjulg ";
     $sql .= "      inner join pcorcamforne on pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne ";
     $sql .= "      inner join pcorcamitem on pcorcamitem.pc22_orcamitem = pcorcamjulg.pc24_orcamitem ";
     $sql .= "      inner join cgm on cgm.z01_numcgm = pcorcamforne.pc21_numcgm ";
     $sql .= "      inner join pcorcam on pcorcam.pc20_codorc = pcorcamforne.pc21_codorc ";
     $sql .= "      inner join pcorcam a on a.pc20_codorc = pcorcamitem.pc22_codorc ";
     $sql .= "      inner join pcorcamitemproc on pcorcamitemproc.pc31_orcamitem = pcorcamitem.pc22_orcamitem ";
     $sql .= "      inner join pcprocitem on pcprocitem.pc81_codprocitem = pcorcamitemproc.pc31_pcprocitem ";
     $sql .= "      inner join pcproc on pcproc.pc80_codproc=pcprocitem.pc81_codproc ";
     $sql .= "      inner join pcdotac on pc13_codigo=pcprocitem.pc81_solicitem ";
     $sql .= "      inner join pcorcamval on pcorcamval.pc23_orcamforne=pcorcamjulg.pc24_orcamforne 
                           and pcorcamval.pc23_orcamitem=pcorcamitem.pc22_orcamitem ";
     $sql .= "      inner join solicitem on solicitem.pc11_codigo= pcprocitem.pc81_solicitem ";
     $sql .= "      inner join solicitempcmater on solicitempcmater.pc16_solicitem= solicitem.pc11_codigo ";
     $sql .= "      inner join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater ";
     $sql .= "      inner join solicitemele on solicitemele.pc18_solicitem= solicitem.pc11_codigo ";
     $sql2 = "";
     if($dbwhere==""){
       if($pc24_orcamitem!=null ){
         $sql2 .= " where pcorcamjulg.pc24_orcamitem = $pc24_orcamitem "; 
       } 
       if($pc24_orcamforne!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " pcorcamjulg.pc24_orcamforne = $pc24_orcamforne "; 
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
   function sql_query ( $pc24_orcamitem=null,$pc24_orcamforne=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from pcorcamjulg ";
     $sql .= "      inner join pcorcamforne  on  pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne";
     $sql .= "      inner join pcorcamitem  on  pcorcamitem.pc22_orcamitem = pcorcamjulg.pc24_orcamitem";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = pcorcamforne.pc21_numcgm";
     $sql .= "      inner join pcorcam  on  pcorcam.pc20_codorc = pcorcamforne.pc21_codorc";
     $sql .= "      inner join pcorcam a on  a.pc20_codorc = pcorcamitem.pc22_codorc";
     $sql2 = "";
     if($dbwhere==""){
       if($pc24_orcamitem!=null ){
         $sql2 .= " where pcorcamjulg.pc24_orcamitem = $pc24_orcamitem "; 
       } 
       if($pc24_orcamforne!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " pcorcamjulg.pc24_orcamforne = $pc24_orcamforne "; 
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
   function sql_query_file ( $pc24_orcamitem=null,$pc24_orcamforne=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from pcorcamjulg ";
     $sql2 = "";
     if($dbwhere==""){
       if($pc24_orcamitem!=null ){
         $sql2 .= " where pcorcamjulg.pc24_orcamitem = $pc24_orcamitem "; 
       } 
       if($pc24_orcamforne!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " pcorcamjulg.pc24_orcamforne = $pc24_orcamforne "; 
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
