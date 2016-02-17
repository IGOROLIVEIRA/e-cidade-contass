<?
//MODULO: licitacao
//CLASSE DA ENTIDADE saldoextfonte
class cl_saldoextfonte {
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
   var $ces01_sequencial = 0; 
   var $ces01_reduz = 0; 

   var $l202_datahomologacao_mes = null; 
   var $l202_datahomologacao_ano = null; 
   var $l202_datahomologacao = null; 
   var $l202_dataadjudicacao_dia = null; 
   var $l202_dataadjudicacao_mes = null; 
   var $l202_dataadjudicacao_ano = null; 
   var $l202_dataadjudicacao = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 ces01_sequencial = int4 = Sequencial 
                 ces01_reduz = int4 = Licitação 
                 l202_datahomologacao = date = Data Homologação 
                 l202_dataadjudicacao = date = Data Adjudicação 
                 ";
   //funcao construtor da classe 
   function cl_saldoextfonte() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("saldoextfonte"); 
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
       $this->ces01_sequencial = ($this->ces01_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["ces01_sequencial"]:$this->ces01_sequencial);
       $this->ces01_reduz = ($this->ces01_reduz == ""?@$GLOBALS["HTTP_POST_VARS"]["ces01_reduz"]:$this->ces01_reduz);
     }else{
       $this->ces01_sequencial = ($this->ces01_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["ces01_sequencial"]:$this->ces01_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($ces01_sequencial){
      $this->atualizacampos();
     if($this->ces01_reduz == null ){ 
       $this->erro_sql = " Campo Licitação nao Informado.";
       $this->erro_campo = "ces01_reduz";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($ces01_sequencial == "" || $ces01_sequencial == null ){
       $result = db_query("select nextval('saldoextfonte_ces01_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: saldoextfonte_ces01_sequencial_seq do campo: ces01_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->ces01_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from saldoextfonte_ces01_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $ces01_sequencial)){
         $this->erro_sql = " Campo ces01_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->ces01_sequencial = $ces01_sequencial; 
       }
     }
     if(($this->ces01_sequencial == null) || ($this->ces01_sequencial == "") ){ 
       $this->erro_sql = " Campo ces01_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into saldoextfonte(
                                       ces01_sequencial 
                                      ,ces01_reduz
                       )
                values (
                                $this->ces01_sequencial 
                               ,$this->ces01_reduz
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Saldo Ext Fonte ($this->ces01_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Saldo Ext Fonte já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Saldo Ext Fonte ($this->ces01_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->ces01_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->ces01_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009446,'$this->ces01_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010223,2009446,'','".AddSlashes(pg_result($resaco,0,'ces01_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010223,2009447,'','".AddSlashes(pg_result($resaco,0,'ces01_reduz'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($ces01_sequencial=null) {
      $this->atualizacampos();
     $sql = " update saldoextfonte set ";
     $virgula = "";
     if(trim($this->ces01_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ces01_sequencial"])){ 
       $sql  .= $virgula." ces01_sequencial = $this->ces01_sequencial ";
       $virgula = ",";
       if(trim($this->ces01_sequencial) == null ){ 
         $this->erro_sql = " Campo Sequencial nao Informado.";
         $this->erro_campo = "ces01_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ces01_reduz)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ces01_reduz"])){ 
       $sql  .= $virgula." ces01_reduz = $this->ces01_reduz ";
       $virgula = ",";
       if(trim($this->ces01_reduz) == null ){ 
         $this->erro_sql = " Campo Licitação nao Informado.";
         $this->erro_campo = "ces01_reduz";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($ces01_sequencial!=null){
       $sql .= " ces01_sequencial = $this->ces01_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->ces01_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009446,'$this->ces01_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["ces01_sequencial"]) || $this->ces01_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010223,2009446,'".AddSlashes(pg_result($resaco,$conresaco,'ces01_sequencial'))."','$this->ces01_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["ces01_reduz"]) || $this->ces01_reduz != "")
           $resac = db_query("insert into db_acount values($acount,2010223,2009447,'".AddSlashes(pg_result($resaco,$conresaco,'ces01_reduz'))."','$this->ces01_reduz',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Saldo Ext Fonte nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->ces01_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Saldo Ext Fonte nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->ces01_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->ces01_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($ces01_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($ces01_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009446,'$ces01_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010223,2009446,'','".AddSlashes(pg_result($resaco,$iresaco,'ces01_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010223,2009447,'','".AddSlashes(pg_result($resaco,$iresaco,'ces01_reduz'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from saldoextfonte
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($ces01_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " ces01_sequencial = $ces01_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Saldo Ext Fonte nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$ces01_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Saldo Ext Fonte nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$ces01_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$ces01_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:saldoextfonte";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $ces01_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from saldoextfonte ";
     $sql .= "      inner join liclicita  on  liclicita.l20_codigo = saldoextfonte.ces01_reduz";
     $sql .= "      inner join db_config  on  db_config.codigo = liclicita.l20_instit";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = liclicita.l20_id_usucria";
     $sql .= "      inner join cflicita  on  cflicita.l03_codigo = liclicita.l20_codtipocom";
     $sql .= "      inner join liclocal  on  liclocal.l26_codigo = liclicita.l20_liclocal";
     $sql .= "      inner join liccomissao  on  liccomissao.l30_codigo = liclicita.l20_liccomissao";
     $sql .= "      inner join licsituacao  on  licsituacao.l08_sequencial = liclicita.l20_licsituacao";
     $sql .= "      inner join pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom";
     $sql2 = "";
     if($dbwhere==""){
       if($ces01_sequencial!=null ){
         $sql2 .= " where saldoextfonte.ces01_sequencial = $ces01_sequencial "; 
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
   function sql_query_file ( $ces01_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from saldoextfonte ";
     $sql2 = "";
     if($dbwhere==""){
       if($ces01_sequencial!=null ){
         $sql2 .= " where saldoextfonte.ces01_sequencial = $ces01_sequencial "; 
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

  function sql_query_itens ( $ces01_reduz=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ) {
       $campos_sql = split("#",$campos);
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
       if($ces01_reduz!= null && $ces01_reduz!= "" ){
         $sql2 .= " where liclicitem.l21_codliclicita = $ces01_reduz ";
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
   function sql_query_ultimo ($campos="*"){ 
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
     $sql .= " from saldoextfonte ";
     $sql .= "      inner join liclicita  on  liclicita.l20_codigo = saldoextfonte.ces01_reduz";
     $sql .= "      inner join db_config  on  db_config.codigo = liclicita.l20_instit";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = liclicita.l20_id_usucria";
     $sql .= "      inner join cflicita  on  cflicita.l03_codigo = liclicita.l20_codtipocom";
     $sql .= "      inner join liclocal  on  liclocal.l26_codigo = liclicita.l20_liclocal";
     $sql .= "      inner join liccomissao  on  liccomissao.l30_codigo = liclicita.l20_liccomissao";
     $sql .= "      inner join licsituacao  on  licsituacao.l08_sequencial = liclicita.l20_licsituacao";
     $sql .= " order by ces01_sequencial desc limit 1";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     return $sql;
  }

  function sql_query_marcados ( $pc81_codprocitem=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= "      left  join liclicitem             on liclicitem.l21_codpcprocitem        = pcprocitem.pc81_codprocitem";          
     $sql2 = "";
     if($dbwhere==""){
       if($pc81_codprocitem!=null ){
         $sql2 .= " where pcprocitem.pc81_codprocitem = $pc81_codprocitem ";
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

  function itensHomologados($ces01_reduz=null) { 

                  $sql = "select * from saldoextfonte 
                  join itenshomologacao on l203_homologaadjudicacao = ces01_sequencial 
                  where ces01_reduz = ". $ces01_reduz;

                  $rsItens = db_query($sql);
                  //db_criatabela($rsItens);
                  for ($iCont = 0;$iCont < pg_num_rows($rsItens); $iCont++) {
                
                    $oItem[$iCont] = db_utils::fieldsMemory($rsItens, $iCont)->l203_item;

                  } 

                  $oItem = implode(',', $oItem);
             
                  return $oItem;
  }

  function excluirItens($ces01_sequencial=null){
                  $sql = "delete  from itenshomologacao
                  where l203_homologaadjudicacao = ". $ces01_sequencial;
                  db_query($sql);
  }

  function verificaPrecoReferencia($ces01_reduz){

      $sql = "select distinct pc80_codproc, pc80_data, pc80_usuario, nome, pc80_depto, descrdepto, pc80_resumo 
      from liclicitem       
      inner join pcprocitem  on  liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem      
      inner join pcproc  on  pcproc.pc80_codproc = pcprocitem.pc81_codproc      
      inner join solicitem  on  solicitem.pc11_codigo = pcprocitem.pc81_solicitem      
      inner join solicita  on  solicita.pc10_numero = solicitem.pc11_numero      
      inner join db_depart  on  db_depart.coddepto = pcproc.pc80_depto      
      inner join db_usuarios  on  pcproc.pc80_usuario = db_usuarios.id_usuario 
      where l21_codliclicita=$ces01_reduz";

      $rsCodProc = db_query($sql);
      $iCodProc  = db_utils::fieldsMemory($rsCodProc, 0)->pc80_codproc;

      $sql       = "select * from precoreferencia where si01_processocompra = $iCodProc";
      $rsPreRef  = db_query($sql);

      return pg_numrows($rsPreRef);

  }

  function alteraLicitacao($iLicitacao, $iSituacao){
    $sql = "update liclicita set l20_licsituacao = $iSituacao where l20_codigo = $iLicitacao";
    db_query($sql);
  }

}
?>
