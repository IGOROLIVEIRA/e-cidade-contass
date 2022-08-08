<?
//MODULO: sicom
//CLASSE DA ENTIDADE bpdcasp712017
class cl_bpdcasp712017 { 
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
   var $si215_sequencial = 0; 
   var $si215_tiporegistro = 0; 
   var $si215_exercicio = 0; 
   var $si215_codfontrecursos = 0; 
   var $si215_vlsaldofonte = 0; 
   var $si215_ano = 0;
   var $si215_periodo = 0;
   var $si215_institu = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si215_sequencial = int4 = si215_sequencial 
                 si215_tiporegistro = int4 = si215_tiporegistro 
                 si215_exercicio = int4 = si215_exercicio 
                 si215_codfontrecursos = int4 = si215_codfontrecursos 
                 si215_vlsaldofonte = float4 = si215_vlsaldofonte 
                 ";
   //funcao construtor da classe 
   function cl_bpdcasp712017() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("bpdcasp712017"); 
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
       $this->si215_sequencial = ($this->si215_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si215_sequencial"]:$this->si215_sequencial);
       $this->si215_tiporegistro = ($this->si215_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si215_tiporegistro"]:$this->si215_tiporegistro);
       $this->si215_exercicio = ($this->si215_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["si215_exercicio"]:$this->si215_exercicio);
       $this->si215_codfontrecursos = ($this->si215_codfontrecursos == ""?@$GLOBALS["HTTP_POST_VARS"]["si215_codfontrecursos"]:$this->si215_codfontrecursos);
       $this->si215_vlsaldofonte = ($this->si215_vlsaldofonte == ""?@$GLOBALS["HTTP_POST_VARS"]["si215_vlsaldofonte"]:$this->si215_vlsaldofonte);
       $this->si215_ano = ($this->si215_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si215_ano"]:$this->si215_ano);
       $this->si215_periodo = ($this->si215_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["si215_periodo"]:$this->si215_periodo);
       $this->si215_institu = ($this->si215_institu == ""?@$GLOBALS["HTTP_POST_VARS"]["si215_institu"]:$this->si215_institu);
     }else{
       $this->si215_sequencial = ($this->si215_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si215_sequencial"]:$this->si215_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si215_sequencial){ 
      $this->atualizacampos();
     if($this->si215_tiporegistro == null ){
       $this->erro_sql = " Campo si215_tiporegistro não informado.";
       $this->erro_campo = "si215_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si215_exercicio == null ){
       $this->erro_sql = " Campo si215_exercicio não informado.";
       $this->erro_campo = "si215_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si215_codfontrecursos == null ){
       $this->si215_codfontrecursos = 0;
     }
     if($this->si215_vlsaldofonte == null ){
       $this->si215_vlsaldofonte = 0;
     }

     $sql = "insert into bpdcasp712017(
                                       si215_sequencial 
                                      ,si215_tiporegistro 
                                      ,si215_exercicio 
                                      ,si215_codfontrecursos 
                                      ,si215_vlsaldofonte 
                                      ,si215_ano
                                      ,si215_periodo
                                      ,si215_institu
                       )
                values (
                                (select nextval('bpdcasp712017_si215_sequencial_seq'))
                               ,$this->si215_tiporegistro 
                               ,$this->si215_exercicio 
                               ,$this->si215_codfontrecursos 
                               ,$this->si215_vlsaldofonte 
                               ,$this->si215_ano
                               ,$this->si215_periodo
                               ,$this->si215_institu
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "bpdcasp712017 ($this->si215_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "bpdcasp712017 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "bpdcasp712017 ($this->si215_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si215_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     return true;
   } 
   // funcao para alteracao
   function alterar ($si215_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update bpdcasp712017 set ";
     $virgula = "";
     if(trim($this->si215_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si215_sequencial"])){ 
       $sql  .= $virgula." si215_sequencial = $this->si215_sequencial ";
       $virgula = ",";
       if(trim($this->si215_sequencial) == null ){ 
         $this->erro_sql = " Campo si215_sequencial não informado.";
         $this->erro_campo = "si215_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si215_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si215_tiporegistro"])){ 
       $sql  .= $virgula." si215_tiporegistro = $this->si215_tiporegistro ";
       $virgula = ",";
       if(trim($this->si215_tiporegistro) == null ){ 
         $this->erro_sql = " Campo si215_tiporegistro não informado.";
         $this->erro_campo = "si215_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si215_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si215_exercicio"])){ 
       $sql  .= $virgula." si215_exercicio = $this->si215_exercicio ";
       $virgula = ",";
       if(trim($this->si215_exercicio) == null ){ 
         $this->erro_sql = " Campo si215_exercicio não informado.";
         $this->erro_campo = "si215_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si215_codfontrecursos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si215_codfontrecursos"])){ 
       $sql  .= $virgula." si215_codfontrecursos = $this->si215_codfontrecursos ";
       $virgula = ",";
       if(trim($this->si215_codfontrecursos) == null ){ 
         $this->erro_sql = " Campo si215_codfontrecursos não informado.";
         $this->erro_campo = "si215_codfontrecursos";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si215_vlsaldofonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si215_vlsaldofonte"])){ 
       $sql  .= $virgula." si215_vlsaldofonte = $this->si215_vlsaldofonte ";
       $virgula = ",";
       if(trim($this->si215_vlsaldofonte) == null ){ 
         $this->erro_sql = " Campo si215_vlsaldofonte não informado.";
         $this->erro_campo = "si215_vlsaldofonte";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if($si215_sequencial!=null){
       $sql .= " si215_sequencial = $this->si215_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->si215_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009445,'$this->si215_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si215_sequencial"]) || $this->si215_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010209,1009445,'".AddSlashes(pg_result($resaco,$conresaco,'si215_sequencial'))."','$this->si215_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si215_tiporegistro"]) || $this->si215_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010209,1009446,'".AddSlashes(pg_result($resaco,$conresaco,'si215_tiporegistro'))."','$this->si215_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si215_exercicio"]) || $this->si215_exercicio != "")
             $resac = db_query("insert into db_acount values($acount,1010209,1009447,'".AddSlashes(pg_result($resaco,$conresaco,'si215_exercicio'))."','$this->si215_exercicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si215_codfontrecursos"]) || $this->si215_codfontrecursos != "")
             $resac = db_query("insert into db_acount values($acount,1010209,1009448,'".AddSlashes(pg_result($resaco,$conresaco,'si215_codfontrecursos'))."','$this->si215_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si215_vlsaldofonte"]) || $this->si215_vlsaldofonte != "")
             $resac = db_query("insert into db_acount values($acount,1010209,1009449,'".AddSlashes(pg_result($resaco,$conresaco,'si215_vlsaldofonte'))."','$this->si215_vlsaldofonte',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "bpdcasp712017 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si215_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bpdcasp712017 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si215_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si215_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($si215_sequencial=null,$dbwhere=null) { 

     $sql = " delete from bpdcasp712017
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si215_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si215_sequencial = $si215_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "bpdcasp712017 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si215_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "bpdcasp712017 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si215_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si215_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:bpdcasp712017";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $si215_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bpdcasp712017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si215_sequencial!=null ){
         $sql2 .= " where bpdcasp712017.si215_sequencial = $si215_sequencial "; 
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
   function sql_query_file ( $si215_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from bpdcasp712017 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si215_sequencial!=null ){
         $sql2 .= " where bpdcasp712017.si215_sequencial = $si215_sequencial "; 
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

  function sql_query_saldoInicialContaCorrente ($iInstit=false,$iFonte=null){ 

      $sSqlReduzSuperavit = "select c61_reduz from conplano inner join conplanoreduz on c60_codcon=c61_codcon and c61_anousu=c60_anousu 
                             where substr(c60_estrut,1,5)='82111' and c60_anousu=" . db_getsession("DB_anousu") ." and c61_anousu=" . db_getsession("DB_anousu");

      if($iInstit==false){
       $sSqlReduzSuperavit = $sSqlReduzSuperavit." and c61_instit in (".db_getsession('DB_instit').")";
      }
      
      $sSqlSaldos = " SELECT saldoanterior , debito , credito
                                        FROM
                                          (select coalesce((SELECT SUM(saldoanterior) AS saldoanterior FROM
                                                    (SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
                                                     FROM contacorrente
                                                     INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                                     INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                                                     AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = c19_conplanoreduzanousu
                                                     WHERE c19_reduz IN ( $sSqlReduzSuperavit )
                                                       AND c19_conplanoreduzanousu = " . db_getsession("DB_anousu") . "
                                                       AND c17_sequencial = 103
                                                       AND c19_orctiporec = {$iFonte}) as x),0) saldoanterior) AS saldoanteriores,

                                            (select coalesce((SELECT sum(c69_valor) as credito
                                             FROM conlancamval
                                             INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                             AND conlancam.c70_anousu = conlancamval.c69_anousu
                                             INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                             INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                             INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                             INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                             INNER JOIN contacorrente ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                             WHERE c28_tipo = 'C'
                                               AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                               AND c17_sequencial = 103
                                               AND c19_reduz IN (  $sSqlReduzSuperavit  )
                                               AND c19_conplanoreduzanousu = " . db_getsession("DB_anousu") . "
                                               AND c19_orctiporec = {$iFonte}
                                               AND conhistdoc.c53_tipo not in (1000) 
                                             GROUP BY c28_tipo),0) as credito) AS creditos,

                                            (select coalesce((SELECT sum(c69_valor) as debito
                                             FROM conlancamval
                                             INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                                             AND conlancam.c70_anousu = conlancamval.c69_anousu
                                             INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                                             INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                                             INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                                             INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                                             INNER JOIN contacorrente  ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                             WHERE c28_tipo = 'D'
                                               AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                                               AND c17_sequencial = 103
                                               AND c19_reduz IN ( $sSqlReduzSuperavit )
                                               AND c19_conplanoreduzanousu = " . db_getsession("DB_anousu") . "
                                               AND c19_orctiporec = {$iFonte} 
                                               AND conhistdoc.c53_tipo not in (1000)                                               
                                             GROUP BY c28_tipo),0) as debito) AS debitos";          
          return $sSqlSaldos;
      
  }


}
?>
