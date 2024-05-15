<?
//MODULO: caixa
//CLASSE DA ENTIDADE controleextvlrtransf
class cl_controleextvlrtransf {
   // cria variaveis de erro
  public $rotulo     = null;
  public $query_sql  = null;
  public $numrows    = 0;
  public $numrows_incluir = 0;
  public $numrows_alterar = 0;
  public $numrows_excluir = 0;
  public $erro_status= null;
  public $erro_sql   = null;
  public $erro_banco = null;
  public $erro_msg   = null;
  public $erro_campo = null;
  public $pagina_retorno = null;
   // cria variaveis do arquivo
  public $k168_codprevisao = 0;
  public $k168_mescompet = 0;
  public $k168_previni_dia = null;
  public $k168_previni_mes = null;
  public $k168_previni_ano = null;
  public $k168_previni = null;
  public $k168_prevfim_dia = null;
  public $k168_prevfim_mes = null;
  public $k168_prevfim_ano = null;
  public $k168_prevfim = null;
  public $k168_vlrprev = 0;
   // cria propriedade com as variaveis do arquivo
  public $campos = "
                 k168_codprevisao = int4 = Código da Previsão Anual
                 k168_mescompet = int4 = Mês de competência
                 k168_previni = date = Data de inicial
                 k168_prevfim = date = Data de final
                 k168_vlrprev = float8 = Valor previsto para período
                 ";
   //funcao construtor da classe
   function __construct() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("controleextvlrtransf");
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
       $this->k168_codprevisao = ($this->k168_codprevisao == ""?@$GLOBALS["HTTP_POST_VARS"]["k168_codprevisao"]:$this->k168_codprevisao);
       $this->k168_mescompet = ($this->k168_mescompet == ""?@$GLOBALS["HTTP_POST_VARS"]["k168_mescompet"]:$this->k168_mescompet);
       if($this->k168_previni == ""){
         $this->k168_previni_dia = ($this->k168_previni_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["k168_previni_dia"]:$this->k168_previni_dia);
         $this->k168_previni_mes = ($this->k168_previni_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["k168_previni_mes"]:$this->k168_previni_mes);
         $this->k168_previni_ano = ($this->k168_previni_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["k168_previni_ano"]:$this->k168_previni_ano);
         if($this->k168_previni_dia != ""){
            $this->k168_previni = $this->k168_previni_ano."-".$this->k168_previni_mes."-".$this->k168_previni_dia;
         }
       }
       if($this->k168_prevfim == ""){
         $this->k168_prevfim_dia = ($this->k168_prevfim_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["k168_prevfim_dia"]:$this->k168_prevfim_dia);
         $this->k168_prevfim_mes = ($this->k168_prevfim_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["k168_prevfim_mes"]:$this->k168_prevfim_mes);
         $this->k168_prevfim_ano = ($this->k168_prevfim_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["k168_prevfim_ano"]:$this->k168_prevfim_ano);
         if($this->k168_prevfim_dia != ""){
            $this->k168_prevfim = $this->k168_prevfim_ano."-".$this->k168_prevfim_mes."-".$this->k168_prevfim_dia;
         }
       }
       $this->k168_vlrprev = ($this->k168_vlrprev == ""?@$GLOBALS["HTTP_POST_VARS"]["k168_vlrprev"]:$this->k168_vlrprev);
     }else{
       $this->k168_codprevisao = ($this->k168_codprevisao == ""?@$GLOBALS["HTTP_POST_VARS"]["k168_codprevisao"]:$this->k168_codprevisao);
       $this->k168_mescompet = ($this->k168_mescompet == ""?@$GLOBALS["HTTP_POST_VARS"]["k168_mescompet"]:$this->k168_mescompet);
     }
   }


  // funcao para inclusao
   function incluir ($k168_codprevisao,$k168_mescompet){
      $this->atualizacampos();
     if($this->k168_vlrprev == null ){
       $this->erro_sql = " Campo Valor previsto para período não informado.";
       $this->erro_campo = "k168_vlrprev";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->k168_codprevisao = $k168_codprevisao;
       $this->k168_mescompet = $k168_mescompet;
     if(($this->k168_codprevisao == null) || ($this->k168_codprevisao == "") ){
       $this->erro_sql = " Campo k168_codprevisao nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->k168_mescompet == null) || ($this->k168_mescompet == "") ){
       $this->erro_sql = " Campo k168_mescompet nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into controleextvlrtransf(
                                       k168_codprevisao
                                      ,k168_mescompet
                                      ,k168_previni
                                      ,k168_prevfim
                                      ,k168_vlrprev
                       )
                values (
                                $this->k168_codprevisao
                               ,$this->k168_mescompet
                               ,".($this->k168_previni == "null" || $this->k168_previni == ""?"null":"'".$this->k168_previni."'")."
                               ,".($this->k168_prevfim == "null" || $this->k168_prevfim == ""?"null":"'".$this->k168_prevfim."'")."
                               ,$this->k168_vlrprev
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "controleextvlrtransf ($this->k168_codprevisao."-".$this->k168_mescompet) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "controleextvlrtransf já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "controleextvlrtransf ($this->k168_codprevisao."-".$this->k168_mescompet) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k168_codprevisao."-".$this->k168_mescompet;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }


  // funcao para alteracao
   function alterar ($k168_codprevisao=null,$k168_mescompet=null) {
      $this->atualizacampos();
     $sql = " update controleextvlrtransf set ";
     $virgula = "";
     if(trim($this->k168_codprevisao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k168_codprevisao"])){
       $sql  .= $virgula." k168_codprevisao = $this->k168_codprevisao ";
       $virgula = ",";
       if(trim($this->k168_codprevisao) == null ){
         $this->erro_sql = " Campo Código da Previsão Anual não informado.";
         $this->erro_campo = "k168_codprevisao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k168_mescompet)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k168_mescompet"])){
        if(trim($this->k168_mescompet)=="" && isset($GLOBALS["HTTP_POST_VARS"]["k168_mescompet"])){
           $this->k168_mescompet = "0" ;
        }
       $sql  .= $virgula." k168_mescompet = $this->k168_mescompet ";
       $virgula = ",";
     }
     if(trim($this->k168_previni)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k168_previni_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k168_previni_dia"] !="") ){
       $sql  .= $virgula." k168_previni = '$this->k168_previni' ";
       $virgula = ",";
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["k168_previni_dia"])){
         $sql  .= $virgula." k168_previni = null ";
         $virgula = ",";
       }
     }
     if(trim($this->k168_prevfim)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k168_prevfim_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k168_prevfim_dia"] !="") ){
       $sql  .= $virgula." k168_prevfim = '$this->k168_prevfim' ";
       $virgula = ",";
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["k168_prevfim_dia"])){
         $sql  .= $virgula." k168_prevfim = null ";
         $virgula = ",";
       }
     }
     if(trim($this->k168_vlrprev)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k168_vlrprev"])){
       $sql  .= $virgula." k168_vlrprev = $this->k168_vlrprev ";
       $virgula = ",";
       if(trim($this->k168_vlrprev) == null ){
         $this->erro_sql = " Campo Valor previsto para período não informado.";
         $this->erro_campo = "k168_vlrprev";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($k168_codprevisao!=null){
       $sql .= " k168_codprevisao = $this->k168_codprevisao";
     }
     if($k168_mescompet!=null){
       $sql .= " and  k168_mescompet = $this->k168_mescompet";
     }

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "controleextvlrtransf nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->k168_codprevisao."-".$this->k168_mescompet;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "controleextvlrtransf nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->k168_codprevisao."-".$this->k168_mescompet;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k168_codprevisao."-".$this->k168_mescompet;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }


  // funcao para exclusao
   function excluir ($k168_codprevisao=null,$k168_mescompet=null,$dbwhere=null) {

     $sql = " delete from controleextvlrtransf
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($k168_codprevisao != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " k168_codprevisao = $k168_codprevisao ";
        }
        if($k168_mescompet != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " k168_mescompet = $k168_mescompet ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "controleextvlrtransf nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$k168_codprevisao."-".$k168_mescompet;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "controleextvlrtransf nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$k168_codprevisao."-".$k168_mescompet;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$k168_codprevisao."-".$k168_mescompet;
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
        $this->erro_sql   = "Record Vazio na Tabela:controleextvlrtransf";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }


  // funcao do sql
   function sql_query ( $k168_codprevisao=null,$k168_mescompet=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from controleextvlrtransf ";
     $sql .= "      inner join controleext  on  controleext.k167_sequencial = controleextvlrtransf.k168_codprevisao";
     $sql .= "      inner join conplano  on  conplano.c60_codcon = controleext.k167_codcon and  conplano.c60_anousu = controleext.k167_anousu";
     $sql2 = "";
     if($dbwhere==""){
       if($k168_codprevisao!=null ){
         $sql2 .= " where controleextvlrtransf.k168_codprevisao = $k168_codprevisao ";
       }
       if($k168_mescompet!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         }
         $sql2 .= " controleextvlrtransf.k168_mescompet = $k168_mescompet ";
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
   function sql_query_file ( $k168_codprevisao=null,$k168_mescompet=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from controleextvlrtransf ";
     $sql2 = "";
     if($dbwhere==""){
       if($k168_codprevisao!=null ){
         $sql2 .= " where controleextvlrtransf.k168_codprevisao = $k168_codprevisao ";
       }
       if($k168_mescompet!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         }
         $sql2 .= " controleextvlrtransf.k168_mescompet = $k168_mescompet ";
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
