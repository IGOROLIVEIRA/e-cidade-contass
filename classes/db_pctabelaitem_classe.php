<?
//MODULO: compras
//CLASSE DA ENTIDADE pctabelaitem
class cl_pctabelaitem {
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
   var $pc95_sequencial = 0;
   var $pc95_codtabela = 0;
   var $pc95_codmater = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 pc95_sequencial = int8 = Sequencial
                 pc95_codtabela = int8 = Codigo Tabela
                 pc95_codmater = int8 = Codigo Material
                 ";
   //funcao construtor da classe
   function cl_pctabelaitem() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("pctabelaitem");
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
       $this->pc95_sequencial = ($this->pc95_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["pc95_sequencial"]:$this->pc95_sequencial);
       $this->pc95_codtabela = ($this->pc95_codtabela == ""?@$GLOBALS["HTTP_POST_VARS"]["pc95_codtabela"]:$this->pc95_codtabela);
       $this->pc95_codmater = ($this->pc95_codmater == ""?@$GLOBALS["HTTP_POST_VARS"]["pc95_codmater"]:$this->pc95_codmater);
     }else{
       $this->pc95_sequencial = ($this->pc95_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["pc95_sequencial"]:$this->pc95_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($pc95_sequencial){
      $this->atualizacampos();
     if($this->pc95_codtabela == null ){
       $this->erro_sql = " Campo Codigo Tabela não informado.";
       $this->erro_campo = "pc95_codtabela";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->pc95_codmater == null ){
       $this->erro_sql = " Campo Codigo Material não informado.";
       $this->erro_campo = "pc95_codmater";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($pc95_sequencial == "" || $pc95_sequencial == null ){
       $result = db_query("select nextval('pctabelaitem_pc95_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: pctabelaitem_pc95_sequencial_seq do campo: pc95_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->pc95_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from pctabelaitem_pc95_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $pc95_sequencial)){
         $this->erro_sql = " Campo pc95_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->pc95_sequencial = $pc95_sequencial;
       }
     }
     if(($this->pc95_sequencial == null) || ($this->pc95_sequencial == "") ){
       $this->erro_sql = " Campo pc95_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into pctabelaitem(
                                       pc95_sequencial
                                      ,pc95_codtabela
                                      ,pc95_codmater
                       )
                values (
                                $this->pc95_sequencial
                               ,$this->pc95_codtabela
                               ,$this->pc95_codmater
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Itens Tabela para desconto tabela ($this->pc95_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Itens Tabela para desconto tabela já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Itens Tabela para desconto tabela ($this->pc95_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->pc95_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->pc95_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009545,'$this->pc95_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010226,1009545,'','".AddSlashes(pg_result($resaco,0,'pc95_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010226,1009546,'','".AddSlashes(pg_result($resaco,0,'pc95_codtabela'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010226,1009547,'','".AddSlashes(pg_result($resaco,0,'pc95_codmater'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }*/
     return true;
   }
   // funcao para alteracao
   function alterar ($pc95_sequencial=null) {
      $this->atualizacampos();
     $sql = " update pctabelaitem set ";
     $virgula = "";
     if(trim($this->pc95_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc95_sequencial"])){
       $sql  .= $virgula." pc95_sequencial = $this->pc95_sequencial ";
       $virgula = ",";
       if(trim($this->pc95_sequencial) == null ){
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "pc95_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->pc95_codtabela)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc95_codtabela"])){
       $sql  .= $virgula." pc95_codtabela = $this->pc95_codtabela ";
       $virgula = ",";
       if(trim($this->pc95_codtabela) == null ){
         $this->erro_sql = " Campo Codigo Tabela não informado.";
         $this->erro_campo = "pc95_codtabela";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->pc95_codmater)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc95_codmater"])){
       $sql  .= $virgula." pc95_codmater = $this->pc95_codmater ";
       $virgula = ",";
       if(trim($this->pc95_codmater) == null ){
         $this->erro_sql = " Campo Codigo Material não informado.";
         $this->erro_campo = "pc95_codmater";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($pc95_sequencial!=null){
       $sql .= " pc95_sequencial = $this->pc95_sequencial";
     }
     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->pc95_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009545,'$this->pc95_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["pc95_sequencial"]) || $this->pc95_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010226,1009545,'".AddSlashes(pg_result($resaco,$conresaco,'pc95_sequencial'))."','$this->pc95_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["pc95_codtabela"]) || $this->pc95_codtabela != "")
             $resac = db_query("insert into db_acount values($acount,1010226,1009546,'".AddSlashes(pg_result($resaco,$conresaco,'pc95_codtabela'))."','$this->pc95_codtabela',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["pc95_codmater"]) || $this->pc95_codmater != "")
             $resac = db_query("insert into db_acount values($acount,1010226,1009547,'".AddSlashes(pg_result($resaco,$conresaco,'pc95_codmater'))."','$this->pc95_codmater',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Itens Tabela para desconto tabela nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->pc95_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Itens Tabela para desconto tabela nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->pc95_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->pc95_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($pc95_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($pc95_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009545,'$pc95_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010226,1009545,'','".AddSlashes(pg_result($resaco,$iresaco,'pc95_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010226,1009546,'','".AddSlashes(pg_result($resaco,$iresaco,'pc95_codtabela'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010226,1009547,'','".AddSlashes(pg_result($resaco,$iresaco,'pc95_codmater'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from pctabelaitem
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($pc95_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " pc95_sequencial = $pc95_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }

     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Itens Tabela para desconto tabela nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$pc95_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Itens Tabela para desconto tabela nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$pc95_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$pc95_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:pctabelaitem";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $pc95_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from pctabelaitem ";
     $sql .= "      inner join pcmater  on  pcmater.pc01_codmater = pctabelaitem.pc95_codmater";
     $sql .= "      inner join pctabela  on  pctabela.pc94_sequencial = pctabelaitem.pc95_codtabela";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = pcmater.pc01_id_usuario";
     $sql .= "      inner join pcsubgrupo  on  pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo";
     $sql2 = "";
     if($dbwhere==""){
       if($pc95_sequencial!=null ){
         $sql2 .= " where pctabelaitem.pc95_sequencial = $pc95_sequencial ";
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
   function sql_query_file ( $pc95_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from pctabelaitem ";
     $sql2 = "";
     if($dbwhere==""){
       if($pc95_sequencial!=null ){
         $sql2 .= " where pctabelaitem.pc95_sequencial = $pc95_sequencial ";
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

  function buscarItensTabela($sWhere) {
    $result = $this->sql_record($this->sql_query(null,"pc95_codmater,pc01_descrmater",null,$sWhere));
    $aItens = array();
    for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

      $oItem = new stdClass;
      $oItem = db_utils::fieldsMemory($result, $iCont);
      $oItem->pc01_descrmater = urlencode($oItem->pc01_descrmater);
      $aItens[] = $oItem;

    }
    return $aItens;
  }

  function buscarTabFonecVencedor($e54_autori, $z01_numcgm) {

    $sSQL = "
      SELECT DISTINCT pctabela.pc94_sequencial,
            pcmater.pc01_descrmater
        FROM liclicitem
        LEFT JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        LEFT JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN db_depart ON db_depart.coddepto = solicita.pc10_depto
        LEFT JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        LEFT JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
        LEFT JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN pcorcamitemlic ON l21_codigo = pc26_liclicitem
        LEFT JOIN pcorcamval ON pc26_orcamitem = pc23_orcamitem
        LEFT JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
        LEFT JOIN cgm ON z01_numcgm = pc21_numcgm
        LEFT JOIN pcorcamjulg ON pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN db_usuarios ON pcproc.pc80_usuario = db_usuarios.id_usuario
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater itemtabela ON itemtabela.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pctabela ON pctabela.pc94_codmater = itemtabela.pc01_codmater
        LEFT JOIN pcmater ON pcmater.pc01_codmater = pctabela.pc94_codmater
        LEFT JOIN pcmaterele ON pcmaterele.pc07_codmater = pctabela.pc94_codmater
        INNER JOIN orcelemento ON orcelemento.o56_codele = pcmaterele.pc07_codele
        AND orcelemento.o56_anousu = ".db_getsession("DB_anousu")."
          WHERE l20_codigo =
            (SELECT e54_codlicitacao
            FROM empautoriza
            WHERE e54_autori = $e54_autori)
            AND pc24_pontuacao = 1
            AND z01_numcgm = $z01_numcgm
              ORDER BY pc94_sequencial
    ";

    $rsResult = db_query($sSQL);

    return db_utils::getCollectionByRecord($rsResult);

  }
}
