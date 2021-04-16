<?

//MODULO: sicom
//CLASSE DA ENTIDADE projecaoatuarial20
class cl_projecaoatuarial20 {
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
   var $si169_sequencial = 0;
   var $si169_exercicio = 0;
   var $si169_vlreceitaprevidenciaria = 0;
   var $si169_vldespesaprevidenciaria = 0;
   var $si169_projecaoatuarial10 = null;
   var $si169_tipoplano = 0;
   var $si169_dtcadastro_dia = null;
   var $si169_dtcadastro_mes = null;
   var $si169_dtcadastro_ano = null;
   var $si169_dtcadastro = null;

  var $si169_data_dia = null;
  var $si169_data_mes = null;
  var $si169_data_ano = null;
  var $si169_data = null;

   var $si169_instit = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si169_sequencial = int8 = sequencial
                 si169_exercicio = int8 = Exercício
                 si169_vlreceitaprevidenciaria = float8 = Valor projetado das receitas previdênciarias
                 si169_vldespesaprevidenciaria = float8 = Valor projetado  das despesas
                 si169_dtcadastro = date = Data de cadastro
                 si169_instit = int8 = Instituição
                 si169_projecaoatuarial10 = vinculo com a tabela registro 10
                 si169_tipoplano = plano previdenciario
                 si169_data = date = Data
                 ";
   //funcao construtor da classe
   function cl_projecaoatuarial20() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("projecaoatuarial20");
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
       $this->si169_sequencial = ($this->si169_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_sequencial"]:$this->si169_sequencial);
       $this->si169_exercicio = ($this->si169_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_exercicio"]:$this->si169_exercicio);
       $this->si169_vlreceitaprevidenciaria = ($this->si169_vlreceitaprevidenciaria == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_vlreceitaprevidenciaria"]:$this->si169_vlreceitaprevidenciaria);
       $this->si169_vldespesaprevidenciaria = ($this->si169_vldespesaprevidenciaria == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_vldespesaprevidenciaria"]:$this->si169_vldespesaprevidenciaria);
       if($this->si169_dtcadastro == ""){
         $this->si169_dtcadastro_dia = ($this->si169_dtcadastro_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_dtcadastro_dia"]:$this->si169_dtcadastro_dia);
         $this->si169_dtcadastro_mes = ($this->si169_dtcadastro_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_dtcadastro_mes"]:$this->si169_dtcadastro_mes);
         $this->si169_dtcadastro_ano = ($this->si169_dtcadastro_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_dtcadastro_ano"]:$this->si169_dtcadastro_ano);
         if($this->si169_dtcadastro_dia != ""){
            $this->si169_dtcadastro = $this->si169_dtcadastro_ano."-".$this->si169_dtcadastro_mes."-".$this->si169_dtcadastro_dia;
         }
       }
       $this->si169_instit = ($this->si169_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_instit"]:$this->si169_instit);
       $this->si169_projecaoatuarial10 = ($this->si169_projecaoatuarial10 == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_projecaoatuarial10"]:$this->si169_projecaoatuarial10);
       $this->si169_tipoplano = ($this->si169_tipoplano == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_tipoplano"]:$this->si169_tipoplano);
       if($this->si169_data == ""){
         $this->si169_data_dia = ($this->si169_data_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_dtcadastro_dia"]:$this->si169_data_dia);
         $this->si169_data_mes = ($this->si169_data_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_dtcadastro_mes"]:$this->si169_data_mes);
         $this->si169_data_ano = ($this->si169_data_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_dtcadastro_ano"]:$this->si169_data_ano);
         if($this->si169_data_dia != ""){
           $this->si169_data = $this->si169_data_ano."-".$this->si169_data_mes."-".$this->si169_data_dia;
         }
       }
     }else{
       $this->si169_sequencial = ($this->si169_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si169_sequencial"]:$this->si169_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si169_sequencial){
      $this->atualizacampos();
     if($this->si169_exercicio == null ){
         $this->erro_sql = " Campo Exercício nao Informado.";
       $this->erro_campo = "si169_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
//     if($this->si169_vlreceitaprevidenciaria == null ){
//       $this->erro_sql = " Campo Valor projetado das receitas previdênciarias nao Informado.";
//       $this->erro_campo = "si169_vlreceitaprevidenciaria";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
//
//       if($this->si169_vldespesaprevidenciaria == null ){
//       $this->erro_sql = " Campo Valor projetado  das despesas nao Informado.";
//       $this->erro_campo = "si169_vldespesaprevidenciaria";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
//       if($this->si169_tipoplano == null ){
//       $this->erro_sql = " Campo Tipo plano nao informado.";
//       $this->erro_campo = "si169_tipoplano";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
       if($this->si169_instit == null ){
       $this->erro_sql = " Campo Instituição nao Informado.";
       $this->erro_campo = "si169_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if($si169_sequencial == "" || $si169_sequencial == null ){
       $result = db_query("select nextval('projecaoatuarial20_si169_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: projecaoatuarial20_si169_sequencial_seq do campo: si169_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si169_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from projecaoatuarial20_si169_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si169_sequencial)){
         $this->erro_sql = " Campo si169_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si169_sequencial = $si169_sequencial;
       }
     }
     if(($this->si169_sequencial == null) || ($this->si169_sequencial == "") ){
       $this->erro_sql = " Campo si169_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into projecaoatuarial20(
                                       si169_sequencial
                                      ,si169_exercicio
                                      ,si169_vlreceitaprevidenciaria
                                      ,si169_vldespesaprevidenciaria
                                      ,si169_dtcadastro
                                      ,si169_instit
                                      ,si169_projecaoatuarial10
                                      ,si169_tipoplano
                                      ,si169_data
                       )
                values (
                                $this->si169_sequencial
                               ,$this->si169_exercicio
                               ,".($this->si169_vlreceitaprevidenciaria == "null" || $this->si169_vlreceitaprevidenciaria == ""? 0 : $this->si169_vlreceitaprevidenciaria)."
                               ,".($this->si169_vldespesaprevidenciaria == "null" || $this->si169_vldespesaprevidenciaria == ""? 0 :$this->si169_vldespesaprevidenciaria)."
                               ,".($this->si169_dtcadastro == "null" || $this->si169_dtcadastro == ""?"null":"'".$this->si169_dtcadastro."'")."
                               ,$this->si169_instit
                               ,$this->si169_projecaoatuarial10
                               ,$this->si169_tipoplano
                               ,".($this->si169_data == "null" || $this->si169_data == ""?"null":"'".$this->si169_data."'")."
                      )";
     $result = db_query($sql);

     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "projecaoatuarial20 ($this->si169_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "projecaoatuarial20 já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "projecaoatuarial20 ($this->si169_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si169_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si169_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2011435,'$this->si169_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010403,2011435,'','".AddSlashes(pg_result($resaco,0,'si169_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010403,2011436,'','".AddSlashes(pg_result($resaco,0,'si169_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010403,2011437,'','".AddSlashes(pg_result($resaco,0,'si169_vlreceitaprevidenciaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010403,2011439,'','".AddSlashes(pg_result($resaco,0,'si169_vldespesaprevidenciaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010403,2011442,'','".AddSlashes(pg_result($resaco,0,'si169_dtcadastro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010403,2011441,'','".AddSlashes(pg_result($resaco,0,'si169_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   }
   // funcao para alteracao
   function alterar ($si169_sequencial=null) {
      $this->atualizacampos();
     $sql = " update projecaoatuarial20 set ";
     $virgula = "";
     if(trim($this->si169_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si169_sequencial"])){
       $sql  .= $virgula." si169_sequencial = $this->si169_sequencial ";
       $virgula = ",";
       if(trim($this->si169_sequencial) == null ){
         $this->erro_sql = " Campo sequencial nao Informado.";
         $this->erro_campo = "si169_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si169_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si169_exercicio"])){
       $sql  .= $virgula." si169_exercicio = $this->si169_exercicio ";
       $virgula = ",";
       if(trim($this->si169_exercicio) == null ){
         $this->erro_sql = " Campo Exercício nao Informado.";
         $this->erro_campo = "si169_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si169_vlreceitaprevidenciaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si169_vlreceitaprevidenciaria"])){
       $sql  .= $virgula." si169_vlreceitaprevidenciaria = $this->si169_vlreceitaprevidenciaria ";
       $virgula = ",";
       if(trim($this->si169_vlreceitaprevidenciaria) == null ){
         $this->erro_sql = " Campo Valor projetado das receitas previdênciarias nao Informado.";
         $this->erro_campo = "si169_vlreceitaprevidenciaria";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si169_vldespesaprevidenciaria)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si169_vldespesaprevidenciaria"])){
       $sql  .= $virgula." si169_vldespesaprevidenciaria = $this->si169_vldespesaprevidenciaria ";
       $virgula = ",";
       if(trim($this->si169_vldespesaprevidenciaria) == null ){
         $this->erro_sql = " Campo Valor projetado  das despesas nao Informado.";
         $this->erro_campo = "si169_vldespesaprevidenciaria";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si169_dtcadastro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si169_dtcadastro_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si169_dtcadastro_dia"] !="") ){
       $sql  .= $virgula." si169_dtcadastro = '$this->si169_dtcadastro' ";
       $virgula = ",";
       if(trim($this->si169_dtcadastro) == null ){
         $this->erro_sql = " Campo Data de cadastro nao Informado.";
         $this->erro_campo = "si169_dtcadastro_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["si169_dtcadastro_dia"])){
         $sql  .= $virgula." si169_dtcadastro = null ";
         $virgula = ",";
         if(trim($this->si169_dtcadastro) == null ){
           $this->erro_sql = " Campo Data de cadastro nao Informado.";
           $this->erro_campo = "si169_dtcadastro_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->si169_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si169_instit"])){
       $sql  .= $virgula." si169_instit = $this->si169_instit ";
       $virgula = ",";
       if(trim($this->si169_instit) == null ){
         $this->erro_sql = " Campo Instituição nao Informado.";
         $this->erro_campo = "si169_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si169_data) != null) {
       $sql  .= $virgula." si169_projecaoatuarial10 = '$this->si169_projecaoatuarial10' ";
       $virgula = ",";
     }
     if(trim($this->si169_data) != null) {
       $sql  .= $virgula." si169_data = '$this->si169_data' ";
       $virgula = ",";
     }

     $sql .= " where ";
     if($si169_sequencial!=null){
       $sql .= " si169_sequencial = $this->si169_sequencial";
     }
//     $resaco = $this->sql_record($this->sql_query_file($this->si169_sequencial));
//     if($this->numrows>0){
//       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
//         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//         $acount = pg_result($resac,0,0);
//         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
//         $resac = db_query("insert into db_acountkey values($acount,2011435,'$this->si169_sequencial','A')");
//         if(isset($GLOBALS["HTTP_POST_VARS"]["si169_sequencial"]) || $this->si169_sequencial != "")
//           $resac = db_query("insert into db_acount values($acount,2010403,2011435,'".AddSlashes(pg_result($resaco,$conresaco,'si169_sequencial'))."','$this->si169_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         if(isset($GLOBALS["HTTP_POST_VARS"]["si169_exercicio"]) || $this->si169_exercicio != "")
//           $resac = db_query("insert into db_acount values($acount,2010403,2011436,'".AddSlashes(pg_result($resaco,$conresaco,'si169_exercicio'))."','$this->si169_exercicio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         if(isset($GLOBALS["HTTP_POST_VARS"]["si169_vlreceitaprevidenciaria"]) || $this->si169_vlreceitaprevidenciaria != "")
//           $resac = db_query("insert into db_acount values($acount,2010403,2011437,'".AddSlashes(pg_result($resaco,$conresaco,'si169_vlreceitaprevidenciaria'))."','$this->si169_vlreceitaprevidenciaria',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         if(isset($GLOBALS["HTTP_POST_VARS"]["si169_vldespesaprevidenciaria"]) || $this->si169_vldespesaprevidenciaria != "")
//           $resac = db_query("insert into db_acount values($acount,2010403,2011439,'".AddSlashes(pg_result($resaco,$conresaco,'si169_vldespesaprevidenciaria'))."','$this->si169_vldespesaprevidenciaria',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         if(isset($GLOBALS["HTTP_POST_VARS"]["si169_dtcadastro"]) || $this->si169_dtcadastro != "")
//           $resac = db_query("insert into db_acount values($acount,2010403,2011442,'".AddSlashes(pg_result($resaco,$conresaco,'si169_dtcadastro'))."','$this->si169_dtcadastro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//         if(isset($GLOBALS["HTTP_POST_VARS"]["si169_instit"]) || $this->si169_instit != "")
//           $resac = db_query("insert into db_acount values($acount,2010403,2011441,'".AddSlashes(pg_result($resaco,$conresaco,'si169_instit'))."','$this->si169_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
//       }
//     }
     //echo $sql;
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "projecaoatuarial20 nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si169_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "projecaoatuarial20 nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si169_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si169_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si169_sequencial=null,$dbwhere=null) {
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si169_sequencial));
     }else{
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011435,'$si169_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010403,2011435,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010403,2011436,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_exercicio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010403,2011437,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_vlreceitaprevidenciaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010403,2011439,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_vldespesaprevidenciaria'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010403,2011442,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_dtcadastro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010403,2011441,'','".AddSlashes(pg_result($resaco,$iresaco,'si169_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from projecaoatuarial20
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si169_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si169_sequencial = $si169_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "projecaoatuarial20 nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si169_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "projecaoatuarial20 nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si169_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si169_sequencial;
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
//      if($this->numrows==0){
//        $this->erro_banco = "";
//        $this->erro_sql   = "Record Vazio na Tabela:projecaoatuarial20";
//        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//        $this->erro_status = "0";
//        return false;
//      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si169_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from projecaoatuarial20 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si169_sequencial!=null ){
         $sql2 .= " where projecaoatuarial20.si169_sequencial = $si169_sequencial ";
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
   function sql_query_file ( $si169_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from projecaoatuarial20 ";
     $sql2 = "";
     if($dbwhere==""){
       if($si169_sequencial!=null ){
         $sql2 .= " where projecaoatuarial20.si169_sequencial = $si169_sequencial ";
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
