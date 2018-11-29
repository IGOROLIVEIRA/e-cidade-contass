<?
//MODULO: caixa
//CLASSE DA ENTIDADE controleext
class cl_controleext {
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
  public $k167_sequencial = 0;
  public $k167_codcon = 0;
  public $k167_anousu = 0;
  public $k167_prevanu = 0;
  public $k167_dtcad_dia = null;
  public $k167_dtcad_mes = null;
  public $k167_dtcad_ano = null;
  public $k167_dtcad = null;
  public $k167_anocad = 0;

  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 k167_sequencial = int4 = Sequencial
                 k167_codcon = int4 = Código da Conta
                 k167_anousu = int4 = Exercício
                 k167_prevanu = float8 = Previsão de recebimento anual
                 k167_dtcad = date = Data de cadastro
                 k167_anocad = int4 = Ano de cadastro
                 ";
   //funcao construtor da classe
   function __construct() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("controleext");
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
       $this->k167_sequencial = ($this->k167_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["k167_sequencial"]:$this->k167_sequencial);
       $this->k167_codcon = ($this->k167_codcon == ""?@$GLOBALS["HTTP_POST_VARS"]["k167_codcon"]:$this->k167_codcon);
       $this->k167_anousu = ($this->k167_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["k167_anousu"]:$this->k167_anousu);
       $this->k167_prevanu = ($this->k167_prevanu == ""?@$GLOBALS["HTTP_POST_VARS"]["k167_prevanu"]:$this->k167_prevanu);
       if($this->k167_dtcad == ""){
         $this->k167_dtcad_dia = ($this->k167_dtcad_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["k167_dtcad_dia"]:$this->k167_dtcad_dia);
         $this->k167_dtcad_mes = ($this->k167_dtcad_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["k167_dtcad_mes"]:$this->k167_dtcad_mes);
         $this->k167_dtcad_ano = ($this->k167_dtcad_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["k167_dtcad_ano"]:$this->k167_dtcad_ano);
         if($this->k167_dtcad_dia != ""){
            $this->k167_dtcad = $this->k167_dtcad_ano."-".$this->k167_dtcad_mes."-".$this->k167_dtcad_dia;
         }
       }
       $this->k167_anocad = ($this->k167_anocad == ""?@$GLOBALS["HTTP_POST_VARS"]["k167_anocad"]:$this->k167_anocad);
     }else{
       $this->k167_sequencial = ($this->k167_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["k167_sequencial"]:$this->k167_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($k167_sequencial){

      $this->atualizacampos();
     if($this->k167_codcon == null ){
       $this->erro_sql = " Campo k167_codcon não informado.";
       $this->erro_campo = "k167_codcon";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->k167_anousu == null ){
       $this->k167_anousu = "0";
     }
     if($this->k167_prevanu == null ){
       $this->k167_prevanu = "0";
     }
     if($this->k167_dtcad == null ){
       $this->k167_dtcad = "null";
     }
     if($this->k167_anocad == null ){
       $this->erro_sql = " Campo k167_anocad não informado.";
       $this->erro_campo = "k167_anocad";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

      $oRes = $this->sql_record("select k167_sequencial from controleext where k167_codcon = {$this->k167_codcon} AND k167_anousu = {$this->k167_anousu}");

      if ($oRes != false) {
        $this->erro_sql   = "Conta já cadastrada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_banco = "Conta já cadastrada";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status     = "0";
        return false;
      }

     if($k167_sequencial == "" || $k167_sequencial == null ){
       $result = db_query("select nextval('controleext_k167_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: controleext_k167_sequencial_seq do campo: k167_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->k167_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from controleext_k167_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $k167_sequencial)){
         $this->erro_sql = " Campo k167_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->k167_sequencial = $k167_sequencial;
       }
     }

     $sql = "insert into controleext(
                                       k167_sequencial
                                      ,k167_codcon
                                      ,k167_anousu
                                      ,k167_prevanu
                                      ,k167_dtcad
                                      ,k167_anocad
                       )
                values (
                                $this->k167_sequencial
                               ,$this->k167_codcon
                               ,$this->k167_anousu
                               ,$this->k167_prevanu
                               ,".($this->k167_dtcad == "null" || $this->k167_dtcad == ""?"null":"'".$this->k167_dtcad."'")."
                               ,$this->k167_anocad
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "controleext ($this->k167_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "controleext já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "controleext ($this->k167_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k167_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     return true;
   }
   // funcao para alteracao
   function alterar ($k167_sequencial=null) {
      $this->atualizacampos();
     $sql = " update controleext set ";
     $virgula = "";
     if(trim($this->k167_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k167_sequencial"])){
       $sql  .= $virgula." k167_sequencial = $this->k167_sequencial ";
       $virgula = ",";
       if(trim($this->k167_sequencial) == null ){
         $this->erro_sql = " Campo k167_sequencial não informado.";
         $this->erro_campo = "k167_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k167_codcon)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k167_codcon"])){
       $sql  .= $virgula." k167_codcon = $this->k167_codcon ";
       $virgula = ",";
       if(trim($this->k167_codcon) == null ){
         $this->erro_sql = " Campo k167_codcon não informado.";
         $this->erro_campo = "k167_codcon";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->k167_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k167_anousu"])){
        if(trim($this->k167_anousu)=="" && isset($GLOBALS["HTTP_POST_VARS"]["k167_anousu"])){
           $this->k167_anousu = "0" ;
        }
       $sql  .= $virgula." k167_anousu = $this->k167_anousu ";
       $virgula = ",";
     }
     if(trim($this->k167_prevanu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k167_prevanu"])){
        if(trim($this->k167_prevanu)=="" && isset($GLOBALS["HTTP_POST_VARS"]["k167_prevanu"])){
           $this->k167_prevanu = "0" ;
        }
       $sql  .= $virgula." k167_prevanu = $this->k167_prevanu ";
       $virgula = ",";
     }
     if(trim($this->k167_dtcad)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k167_dtcad_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["k167_dtcad_dia"] !="") ){
       $sql  .= $virgula." k167_dtcad = '$this->k167_dtcad' ";
       $virgula = ",";
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["k167_dtcad_dia"])){
         $sql  .= $virgula." k167_dtcad = null ";
         $virgula = ",";
       }
     }
     if(trim($this->k167_anocad)!="" || isset($GLOBALS["HTTP_POST_VARS"]["k167_anocad"])){
       $sql  .= $virgula." k167_anocad = $this->k167_anocad ";
       $virgula = ",";
       if(trim($this->k167_anocad) == null ){
         $this->erro_sql = " Campo k167_anocad não informado.";
         $this->erro_campo = "k167_anocad";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($k167_sequencial!=null){
       $sql .= " k167_sequencial = $this->k167_sequencial";
     }

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "controleext nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->k167_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "controleext nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->k167_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->k167_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($k167_sequencial=null,$dbwhere=null) {

      $sSQLMensais = "
        SELECT k168_codprevisao, k168_mescompet
        FROM controleextvlrtransf
        WHERE k168_codprevisao = {$k167_sequencial}
      ";

      $rsMensais = db_query($sSQLMensais);

      if ($rsMensais) {

        $aMensais = pg_fetch_all($rsMensais);

        foreach ($aMensais as $aPrevisao) {

          $sSQLApagarPrevisao = "
            DELETE FROM controleextvlrtransf
            WHERE
              k168_codprevisao = {$aPrevisao['k168_codprevisao']}
              AND k168_mescompet = {$aPrevisao['k168_mescompet']}
          ";

          $rsApagou = db_query($sSQLApagarPrevisao);

          if (!$rsApagou) {
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "";
            $this->erro_msg   = pg_last_error();
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
          }

        }

      }

     $sql = " delete from controleext
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($k167_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " k167_sequencial = $k167_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "controleext nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$k167_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "controleext nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$k167_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$k167_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:controleext";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $k167_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from controleext ";
     $sql .= "      inner join conplano  on  conplano.c60_codcon = controleext.k167_codcon and  conplano.c60_anousu = controleext.k167_anousu";
     $sql .= "      inner join conclass  on  conclass.c51_codcla = conplano.c60_codcla";
     $sql .= "      inner join consistema  on  consistema.c52_codsis = conplano.c60_codsis";
     $sql .= "      inner join consistemaconta  on  consistemaconta.c65_sequencial = conplano.c60_consistemaconta";
     $sql2 = "";
     if($dbwhere==""){
       if($k167_sequencial!=null ){
         $sql2 .= " where controleext.k167_sequencial = $k167_sequencial ";
       }
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = explode("#",$ordem);
       $virgula = "";
       $sql .= implode(',', $campos_sql);
     }
     return $sql;
  }
   // funcao do sql
   function sql_query_file ( $k167_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from controleext ";
     $sql2 = "";
     if($dbwhere==""){
       if($k167_sequencial!=null ){
         $sql2 .= " where controleext.k167_sequencial = $k167_sequencial ";
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


  /**
   * retorna os recebimentos mensais baseado em conta e intervalo de datas
   * @param int $iCodConta
   * @param stdClass $oDatas
   * @return array
   */
  public static function getRecebimentosELancamentos($iCodConta = '', stdClass $oDatas)
  {
    $sWhereConta = '';
    $sWhereDatas = '';
    $aDatas = (array) $oDatas;

    if (!empty($iCodConta)) {
      $sWhereConta = "WHERE c61_codcon IN ({$iCodConta})  AND c61_anousu = ".date('Y', strtotime($oDatas->inicio))." ";
    }else{
      $sWhereConta = "WHERE c61_anousu = ".date('Y', strtotime($oDatas->inicio))." ";
    }

      $sWhereDatas = "
        AND slipsNaoEstornados.data_recebimento
        BETWEEN '{$oDatas->inicio}' AND '{$oDatas->final}'
      ";

    $sSQL = "
      SELECT DISTINCT
                        lancamento,
                        cod_slip,
                        data_recebimento,
                        c60_descr,

         (SELECT EXTRACT(MONTH
                         FROM data_recebimento)) AS mes_recebimento,
                        valor_recebido,
                        k167_codcon,
                        k167_prevanu,
                        k168_mescompet,
                        k168_previni,
                        k168_prevfim,
                        k168_vlrprev
      FROM conplanoreduz
      JOIN controleext ON k167_codcon = c61_codcon AND c61_anousu = k167_anousu
      JOIN controleextvlrtransf ON k168_codprevisao = k167_sequencial
      JOIN conplano ON c60_codcon = c61_codcon
      LEFT JOIN
      (SELECT slipsNaoEstornados.lancamento,
                 slipsNaoEstornados.cod_slip,
                 slipsNaoEstornados.data_recebimento,
                 k17_credito AS conta_banc,
                 slipsNaoEstornados.valor_recebido
          FROM
              (SELECT c84_conlancam AS lancamento,
                      k17_codigo AS cod_slip,
                      c70_data AS data_recebimento,
                      c71_coddoc,
                      k17_credito,
                      c70_valor AS valor_recebido
               FROM slip
               JOIN conlancamslip ON c84_slip = k17_codigo
               JOIN conlancam ON c70_codlan = c84_conlancam
               JOIN contabilidade.conlancamdoc ON c71_codlan = c70_codlan
               WHERE c71_coddoc IN (100, 130, 140, 150, 160)
                   AND k17_codigo NOT IN
                       (SELECT k17_codigo FROM slip
                        JOIN conlancamslip ON c84_slip = k17_codigo
                        JOIN conlancam ON c70_codlan = c84_conlancam
                        JOIN contabilidade.conlancamdoc ON c71_codlan = c70_codlan
                        WHERE c71_coddoc IN (101, 131, 141, 151, 161, 162, 163) ) ) slipsNaoEstornados
          WHERE k17_credito IN
                  (SELECT c61_reduz FROM contabilidade.conplanoreduz
                   JOIN conplano ON c60_codcon = c61_codcon
                   {$sWhereConta})
              {$sWhereDatas}
          ORDER BY slipsNaoEstornados.data_recebimento) AS geral
          ON c61_reduz = geral.conta_banc AND geral.data_recebimento >= k167_dtcad
          AND k168_mescompet = EXTRACT (MONTH FROM data_recebimento)
      WHERE 1=1  AND c61_anousu = ".(empty($aDatas)?db_getsession('DB_anousu'):date('Y', strtotime($oDatas->inicio)))." AND c60_anousu = ".(empty($aDatas)?db_getsession('DB_anousu'):date('Y', strtotime($oDatas->inicio)))." AND k168_previni >= '{$oDatas->inicio}' AND k168_prevfim <= '{$oDatas->final}' ORDER BY k168_previni

      ";

//    print_r($sSQL);die();
    $rsContas = db_query($sSQL);
//    db_criatabela($rsContas);die();

    if (pg_num_rows($rsContas) === 0) {
      throw new Exception("Não há dados para os filtros selecionados", 1);
    }

    return pg_fetch_all($rsContas);

  }
}
?>
