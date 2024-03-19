<?
//MODULO: sicom
//CLASSE DA ENTIDADE dispensa402024
class cl_dispensa402024 {
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
   var $si204_sequencial = 0;
   var $si204_tiporegistro = null;
   var $si204_codorgaoresp = null;
   var $si204_codunidadesubresp = null;
   var $si204_exercicioprocesso = null;
   var $si204_nroprocesso = null;
   var $si204_tipoprocesso = null;
   var $si204_tipodocumento = null;
   var $si204_nrodocumento = null;
   var $si204_nrolote = null;
   var $si204_coditem = null;
   var $si204_perctaxaadm = null;
   var $si204_mes = null;
   var $si204_instit = null;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                var si204_sequencial = int = Sequencial;
                var si204_tiporegistro = int = Tipo Registro;
                var si204_codorgaoresp = int = Cod Orgao Resp;
                var si204_codunidadesubresp = varchar (8) = Cod Unidade Sub Resp;
                var si204_exercicioprocesso = int = Exercicio Processo;
                var si204_nroprocesso = varchar(16) = Nro Processo;
                var si204_tipoprocesso = int = Tipo Processo;
                var si204_tipodocumento = int = Tipo Documento;
                var si204_nrodocumento = varchar(14) = Nro Documento;
                var si204_nrolote = int = Nro Lote;
                var si204_coditem = int = Cod Item;
                var si204_perctaxaadm = int = Perc Taxa Adm;
                var si204_mes = int = Mes;
                 ";
   //funcao construtor da classe
   function cl_dispensa402024() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("dispensa402024");
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
       $this->si204_sequencial = ($this->si204_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_sequencial"]:$this->si204_sequencial);
       $this->si204_tiporegistro = ($this->si204_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_tiporegistro"]:$this->si204_tiporegistro);
       $this->si204_codorgaoresp = ($this->si204_codorgaoresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_codorgaoresp"]:$this->si204_codorgaoresp);
       $this->si204_codunidadesubresp = ($this->si204_codunidadesubresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_codunidadesubresp"]:$this->si204_codunidadesubresp);
       $this->si204_exercicioprocesso = ($this->si204_exercicioprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_exercicioprocesso"]:$this->si204_exercicioprocesso);
       $this->si204_nroprocesso = ($this->si204_nroprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_nroprocesso"]:$this->si204_nroprocesso);
       $this->si204_tipoprocesso = ($this->si204_tipoprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_tipoprocesso"]:$this->si204_tipoprocesso);
       $this->si204_tipodocumento = ($this->si204_tipodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_tipodocumento"]:$this->si204_tipodocumento);
       $this->si204_nrodocumento = ($this->si204_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_nrodocumento"]:$this->si204_nrodocumento);
       $this->si204_nrolote = ($this->si204_nrolote == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_nrolote"]:$this->si204_nrolote);
       $this->si204_mes = ($this->si204_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_mes"]:$this->si204_mes);
       $this->si204_instit = ($this->si204_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_instit"]:$this->si204_instit);
     }else{
      $this->si204_sequencial = ($this->si204_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si204_sequencial"]:$this->si204_sequencial);
    }
   }
   // funcao para inclusao
   function incluir ($si204_sequencial){
      $this->atualizacampos();
     if($this->si204_tiporegistro == null ){
       $this->erro_sql = " Campo Tipo do  registro nao Informado.";
       $this->erro_campo = "si204_sequencial";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }

     if($this->si204_codorgaoresp == null ){
      $this->erro_sql = " Campo Orgao Resp nao Informado.";
      $this->erro_campo = "si204_sequencial";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }

     if($this->si204_codunidadesubresp == null ){
       $this->erro_sql = " Campo Cod Unidade Sub Resp nao Informado.";
       $this->erro_campo = "si204_codunidadesubresp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }

     if($this->si204_exercicioprocesso == null ){
       $this->erro_sql = " Campo Exercicio Processo nao Informado.";
       $this->erro_campo = "si204_exercicioprocesso";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }

     if($this->si204_nroprocesso == null ){
      $this->erro_sql = " Campo Nro Processo nao Informado.";
      $this->erro_campo = "si204_nroprocesso";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }

    if($this->si204_tipoprocesso == null ){
      $this->erro_sql = " Campo Tipo Processo nao Informado.";
      $this->erro_campo = "si204_tipoprocesso";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }

    if($this->si204_tipodocumento == null ){
      $this->erro_sql = " Campo Tipo Documento nao Informado.";
      $this->erro_campo = "si204_tipodocumento";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }

    if($this->si204_nrodocumento == null ){
      $this->erro_sql = " Campo Nro Documento nao Informado.";
      $this->erro_campo = "si204_nrodocumento";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }

    if($this->si204_perctaxaadm == null ){
      $this->erro_sql = " Campo Perc Taxa Adm nao Informado.";
      $this->erro_campo = "si204_perctaxaadm";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
      $this->erro_status = "0";
      return false;
    }

     if($si204_sequencial == "" || $si204_sequencial == null ){
       $result = db_query("select nextval('dispensa402024_si204_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("
","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: dispensa402024_si204_sequencial_seq do campo: si204_sequencial";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si204_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from dispensa402024_si204_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si204_sequencial)){
         $this->erro_sql = " Campo si204_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si204_sequencial = $si204_sequencial;
       }
     }
     if(($this->si204_sequencial == null) || ($this->si204_sequencial == "") ){
       $this->erro_sql = " Campo si204_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into dispensa402024(
                                      si204_sequencial
                                      ,si204_tiporegistro
                                      ,si204_codorgaoresp
                                      ,si204_codunidadesubresp
                                      ,si204_exercicioprocesso
                                      ,si204_nroprocesso
                                      ,si204_tipoprocesso
                                      ,si204_tipodocumento
                                      ,si204_nrodocumento
                                      ,si204_nrolote
                                      ,si204_coditem
                                      ,si204_perctaxaadm
                                      ,si204_mes
                                      ,si204_instit
                       )
                values (
                                $this->si204_sequencial
                               ,$this->si204_tiporegistro
                               ,$this->si204_codorgaoresp
                               ,'$this->si204_codunidadesubresp'
                               ,$this->si204_exercicioprocesso
                               ,'$this->si204_nroprocesso'
                               ,$this->si204_tipoprocesso
                               ,$this->si204_tipodocumento
                               ,'$this->si204_nrodocumento'
                               ," . ($this->si204_nrolote == "null" || $this->si204_nrolote == "" ? "null" : "'" . $this->si204_nrolote . "'") . "
                               ," . ($this->si204_coditem == "null" || $this->si204_coditem == "" ? "null" : "'" . $this->si204_coditem . "'") . "
                               ,$this->si204_perctaxaadm
                               ,$this->si204_mes
                               ,$this->si204_instit
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "dispensa402024 ($this->si75_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_banco = "dispensa402024 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }else{
         $this->erro_sql   = "dispensa402024 ($this->si75_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$this->si75_sequencial;
     $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);

     return true;
   }

   // funcao para exclusao
   function excluir ($si204_sequencial=null,$dbwhere=null) {

     $sql = " delete from dispensa402024
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si204_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si204_sequencial = $si204_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "dispensa402024 nao Excluído. Exclusão Abortada.\n";
       $this->erro_sql .= "Valores : ".$si204_sequencial;
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "dispensa402024 nao Encontrado. Exclusão não Efetuada.\n";
         $this->erro_sql .= "Valores : ".$si204_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\n";
         $this->erro_sql .= "Valores : ".$si204_sequencial;
         $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
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
       $this->erro_banco = str_replace("
","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Record Vazio na Tabela:dispensa402024";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }

   // funcao do sql
   function sql_query ( $si204_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dispensa402024 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si204_sequencial!=null ){
         $sql2 .= " where dispensa402024.si204_sequencial = $si204_sequencial ";
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
   function sql_query_file ( $si204_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from dispensa402024 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si204_sequencial!=null ){
         $sql2 .= " where dispensa402024.si204_sequencial = $si204_sequencial ";
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
}
?>
