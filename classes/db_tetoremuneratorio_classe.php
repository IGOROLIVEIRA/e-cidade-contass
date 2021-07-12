<?
//MODULO: pessoal
//CLASSE DA ENTIDADE tetoremuneratorio
class cl_tetoremuneratorio { 
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
   var $te01_sequencial = 0; 
   var $te01_valor = 0; 
   var $te01_tipocadastro = 0; 
   var $te01_dtinicial_dia = null; 
   var $te01_dtinicial_mes = null; 
   var $te01_dtinicial_ano = null; 
   var $te01_dtinicial = null; 
   var $te01_dtfinal_dia = null; 
   var $te01_dtfinal_mes = null; 
   var $te01_dtfinal_ano = null; 
   var $te01_dtfinal = null;
   var $te01_nrleiteto = 0;
   var $te01_dtpublicacaolei_dia = null;
   var $te01_dtpublicacaolei_mes = null;
   var $te01_dtpublicacaolei_ano = null;
   var $te01_dtpublicacaolei = null;
   var $te01_justificativa = null;
   var $te01_codteto = 0;
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 te01_sequencial = int4 = sequencial 
                 te01_valor = float4 = Valor para teto 
                 te01_tipocadastro = int4 = Tipo de cadastro 
                 te01_dtinicial = date = Data Inicial
                 te01_nrleiteto = int4 = Número da lei do teto remuneratório
                 te01_dtpublicacaolei = Data da publicação da lei do teto remuneratório 
                 te01_dtfinal = date = Data Final
                 te01_justificativa = varchar(250) = Justificativa 
                 te01_codteto = int4 = Codigo Teto
                 ";
   //funcao construtor da classe 
   function cl_tetoremuneratorio() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("tetoremuneratorio"); 
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
       $this->te01_sequencial = ($this->te01_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_sequencial"]:$this->te01_sequencial);
       $this->te01_valor = ($this->te01_valor == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_valor"]:$this->te01_valor);
       $this->te01_tipocadastro = ($this->te01_tipocadastro == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_tipocadastro"]:$this->te01_tipocadastro);
       if($this->te01_dtinicial == ""){
         $this->te01_dtinicial_dia = ($this->te01_dtinicial_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtinicial_dia"]:$this->te01_dtinicial_dia);
         $this->te01_dtinicial_mes = ($this->te01_dtinicial_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtinicial_mes"]:$this->te01_dtinicial_mes);
         $this->te01_dtinicial_ano = ($this->te01_dtinicial_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtinicial_ano"]:$this->te01_dtinicial_ano);
         if($this->te01_dtinicial_dia != ""){
            $this->te01_dtinicial = $this->te01_dtinicial_ano."-".$this->te01_dtinicial_mes."-".$this->te01_dtinicial_dia;
         }
       }
       $this->te01_nrleiteto = ($this->te01_nrleiteto == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_nrleiteto"]:$this->te01_nrleiteto);
       if($this->te01_dtpublicacaolei == ""){
           $this->te01_dtpublicacaolei_dia = ($this->te01_dtpublicacaolei_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtpublicacaolei_dia"]:$this->te01_dtpublicacaolei_dia);
           $this->te01_dtpublicacaolei_mes = ($this->te01_dtpublicacaolei_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtpublicacaolei_mes"]:$this->te01_dtpublicacaolei_mes);
           $this->te01_dtpublicacaolei_ano = ($this->te01_dtpublicacaolei_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtpublicacaolei_ano"]:$this->te01_dtpublicacaolei_ano);
           if($this->te01_dtpublicacaolei_dia != ""){
               $this->te01_dtpublicacaolei = $this->te01_dtpublicacaolei_ano."-".$this->te01_dtpublicacaolei_mes."-".$this->te01_dtpublicacaolei_dia;
           }
       }
       if($this->te01_dtfinal == ""){
         $this->te01_dtfinal_dia = ($this->te01_dtfinal_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtfinal_dia"]:$this->te01_dtfinal_dia);
         $this->te01_dtfinal_mes = ($this->te01_dtfinal_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtfinal_mes"]:$this->te01_dtfinal_mes);
         $this->te01_dtfinal_ano = ($this->te01_dtfinal_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_dtfinal_ano"]:$this->te01_dtfinal_ano);
         if($this->te01_dtfinal_dia != ""){
            $this->te01_dtfinal = $this->te01_dtfinal_ano."-".$this->te01_dtfinal_mes."-".$this->te01_dtfinal_dia;
         }
       }
       $this->te01_justificativa = ($this->te01_justificativa == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_justificativa"]:$this->te01_justificativa);
       $this->te01_codteto = ($this->te01_codteto == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_codteto"]:$this->te01_codteto);
     }else{
       $this->te01_sequencial = ($this->te01_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["te01_sequencial"]:$this->te01_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($te01_sequencial){ 
      $this->atualizacampos();
     if($this->te01_valor == null ){ 
       $this->erro_sql = " Campo Valor para teto não informado.";
       $this->erro_campo = "te01_valor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->te01_tipocadastro == null ){ 
       $this->erro_sql = " Campo Tipo de cadastro não informado.";
       $this->erro_campo = "te01_tipocadastro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->te01_dtinicial == null ){ 
       $this->erro_sql = " Campo Data Inicial não informado.";
       $this->erro_campo = "te01_dtinicial_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->te01_nrleiteto == null ){
         $this->erro_sql = " Campo Número da lei do teto remuneratório não informado.";
         $this->erro_campo = "te01_nrleiteto";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
     }
     if($this->te01_dtpublicacaolei == null ){
         $this->erro_sql = " Campo Data da publicação da lei do teto remuneratório não informado.";
         $this->erro_campo = "te01_dtpublicacaolei_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
     }
//     if($this->te01_dtfinal == null ){
//       $this->erro_sql = " Campo Data Final não informado.";
//       $this->erro_campo = "te01_dtfinal_dia";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
     if($te01_sequencial == "" || $te01_sequencial == null ){
       $result = db_query("select nextval('tetoremuneratorio_te01_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: tetoremuneratorio_te01_sequencial_seq do campo: te01_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->te01_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from tetoremuneratorio_te01_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $te01_sequencial)){
         $this->erro_sql = " Campo te01_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->te01_sequencial = $te01_sequencial; 
       }
     }
     if(($this->te01_sequencial == null) || ($this->te01_sequencial == "") ){ 
       $this->erro_sql = " Campo te01_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into tetoremuneratorio(
                                       te01_sequencial 
                                      ,te01_valor 
                                      ,te01_tipocadastro 
                                      ,te01_dtinicial 
                                      ,te01_nrleiteto
                                      ,te01_dtpublicacaolei
                                      ,te01_dtfinal 
                                      ,te01_justificativa 
                                      ,te01_codteto
                       )
                values (
                                $this->te01_sequencial 
                               ,$this->te01_valor 
                               ,$this->te01_tipocadastro 
                               ,".($this->te01_dtinicial == "null" || $this->te01_dtinicial == ""?"null":"'".$this->te01_dtinicial."'")."
                               ,$this->te01_nrleiteto
                               ,".($this->te01_dtpublicacaolei == "null" || $this->te01_dtpublicacaolei == ""?"null":"'".$this->te01_dtpublicacaolei."'")."
                               ,".($this->te01_dtfinal == "null" || $this->te01_dtfinal == ""?"null":"'".$this->te01_dtfinal."'")." 
                               ,'$this->te01_justificativa'
                               ,$this->te01_codteto 
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "tetoremuneratorio ($this->te01_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "tetoremuneratorio já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "tetoremuneratorio ($this->te01_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->te01_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->te01_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->te01_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010193,1009244,'','".AddSlashes(pg_result($resaco,0,'te01_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009245,'','".AddSlashes(pg_result($resaco,0,'te01_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009250,'','".AddSlashes(pg_result($resaco,0,'te01_tipocadastro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009246,'','".AddSlashes(pg_result($resaco,0,'te01_dtinicial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009247,'','".AddSlashes(pg_result($resaco,0,'te01_dtfinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009248,'','".AddSlashes(pg_result($resaco,0,'te01_justificativa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }*/
     return true;
   } 
   // funcao para alteracao
   function alterar ($te01_sequencial=null) {

     $this->atualizacampos();

     $sql = " update tetoremuneratorio set ";
     $virgula = "";
     if(trim($this->te01_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["te01_sequencial"])){ 
       $sql  .= $virgula." te01_sequencial = $this->te01_sequencial ";
       $virgula = ",";
       if(trim($this->te01_sequencial) == null ){ 
         $this->erro_sql = " Campo sequencial não informado.";
         $this->erro_campo = "te01_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }

     if(trim($this->te01_valor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["te01_valor"])){ 
       $sql  .= $virgula." te01_valor = $this->te01_valor ";
       $virgula = ",";
       if(trim($this->te01_valor) == null ){ 
         $this->erro_sql = " Campo Valor para teto não informado.";
         $this->erro_campo = "te01_valor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->te01_tipocadastro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["te01_tipocadastro"])){ 
       $sql  .= $virgula." te01_tipocadastro = $this->te01_tipocadastro ";
       $virgula = ",";
       if(trim($this->te01_tipocadastro) == null ){ 
         $this->erro_sql = " Campo Tipo de cadastro não informado.";
         $this->erro_campo = "te01_tipocadastro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }


     if(trim($this->te01_dtinicial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["te01_dtinicial_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["te01_dtinicial_dia"] !="") ){ 
       $sql  .= $virgula." te01_dtinicial = '$this->te01_dtinicial' ";
       $virgula = ",";
       if(trim($this->te01_dtinicial) == null ){ 
         $this->erro_sql = " Campo Data Inicial não informado.";
         $this->erro_campo = "te01_dtinicial_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if(isset($GLOBALS["HTTP_POST_VARS"]["te01_dtinicial_dia"])){ 
         $sql  .= $virgula." te01_dtinicial = null ";
         $virgula = ",";
         if(trim($this->te01_dtinicial) == null ){ 
           $this->erro_sql = " Campo Data Inicial não informado.";
           $this->erro_campo = "te01_dtinicial_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }

       if(trim($this->te01_dtfinal)!="" || isset($GLOBALS["HTTP_POST_VARS"]["te01_dtfinal_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["te01_dtfinal_dia"] !="") ){
           $sql  .= $virgula." te01_dtfinal = '$this->te01_dtfinal' ";
           $virgula = ",";
       }else{
           if(isset($GLOBALS["HTTP_POST_VARS"]["te01_dtfinal_dia"])){
               $sql  .= $virgula." te01_dtfinal = null ";
               $virgula = ",";
           }
       }

     if(trim($this->te01_nrleiteto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["te01_nrleiteto"])){
         $sql  .= $virgula." te01_nrleiteto = $this->te01_nrleiteto ";
         $virgula = ",";
         if(trim($this->te01_nrleiteto) == null ){
             $this->erro_sql = " Campo Tipo de cadastro não informado.";
             $this->erro_campo = "te01_nrleiteto";
             $this->erro_banco = "";
             $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
             $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
             $this->erro_status = "0";
             return false;
         }
     }

     if(trim($this->te01_dtpublicacaolei)!="" || isset($GLOBALS["HTTP_POST_VARS"]["te01_dtpublicacaolei_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["te01_dtpublicacaolei_dia"] !="") ){
         $sql  .= $virgula." te01_dtpublicacaolei = '$this->te01_dtpublicacaolei' ";
         $virgula = ",";
         if(trim($this->te01_dtpublicacaolei) == null ){
             $this->erro_sql = " Campo Data da Publicação não informado.";
             $this->erro_campo = "te01_dtpublicacaolei_dia";
             $this->erro_banco = "";
             $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
             $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
             $this->erro_status = "0";
             return false;
         }
     }     else{
         if(isset($GLOBALS["HTTP_POST_VARS"]["te01_dtpublicacaolei_dia"])){
             $sql  .= $virgula." te01_dtpublicacaolei = null ";
             $virgula = ",";
             if(trim($this->te01_dtpublicacaolei) == null ){
                 $this->erro_sql = " Campo Data publicação lei não informado.";
                 $this->erro_campo = "te01_dtpublicacaolei_dia";
                 $this->erro_banco = "";
                 $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                 $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                 $this->erro_status = "0";
                 return false;
             }
         }
     }
     if(trim($this->te01_justificativa)!="" || isset($GLOBALS["HTTP_POST_VARS"]["te01_justificativa"])){ 
       $sql  .= $virgula." te01_justificativa = '$this->te01_justificativa' ";
       $virgula = ",";
     }
     if(trim($this->te01_codteto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["te01_codteto"])){
       $sql  .= $virgula." te01_codteto = '$this->te01_codteto' ";
       $virgula = ",";
         if(trim($this->te01_codteto) == null ){
             $this->erro_sql = " Campo cod teto não informado.";
             $this->erro_campo = "te01_codteto";
             $this->erro_banco = "";
             $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
             $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
             $this->erro_status = "0";
             return false;
         }
     }
     $sql .= " where ";
     if($te01_sequencial!=null){
       $sql .= " te01_sequencial = $this->te01_sequencial";
     }
     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->te01_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->te01_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["te01_sequencial"]) || $this->te01_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009244,'".AddSlashes(pg_result($resaco,$conresaco,'te01_sequencial'))."','$this->te01_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["te01_valor"]) || $this->te01_valor != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009245,'".AddSlashes(pg_result($resaco,$conresaco,'te01_valor'))."','$this->te01_valor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["te01_tipocadastro"]) || $this->te01_tipocadastro != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009250,'".AddSlashes(pg_result($resaco,$conresaco,'te01_tipocadastro'))."','$this->te01_tipocadastro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["te01_dtinicial"]) || $this->te01_dtinicial != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009246,'".AddSlashes(pg_result($resaco,$conresaco,'te01_dtinicial'))."','$this->te01_dtinicial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["te01_dtfinal"]) || $this->te01_dtfinal != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009247,'".AddSlashes(pg_result($resaco,$conresaco,'te01_dtfinal'))."','$this->te01_dtfinal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["te01_justificativa"]) || $this->te01_justificativa != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009248,'".AddSlashes(pg_result($resaco,$conresaco,'te01_justificativa'))."','$this->te01_justificativa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/

     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "tetoremuneratorio nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->te01_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "tetoremuneratorio nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->te01_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->te01_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($te01_sequencial=null,$dbwhere=null) { 

     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($te01_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009244,'$te01_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009244,'','".AddSlashes(pg_result($resaco,$iresaco,'te01_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009245,'','".AddSlashes(pg_result($resaco,$iresaco,'te01_valor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009250,'','".AddSlashes(pg_result($resaco,$iresaco,'te01_tipocadastro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009246,'','".AddSlashes(pg_result($resaco,$iresaco,'te01_dtinicial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009247,'','".AddSlashes(pg_result($resaco,$iresaco,'te01_dtfinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009248,'','".AddSlashes(pg_result($resaco,$iresaco,'te01_justificativa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from tetoremuneratorio
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($te01_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " te01_sequencial = $te01_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "tetoremuneratorio nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$te01_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "tetoremuneratorio nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$te01_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$te01_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:tetoremuneratorio";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $te01_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from tetoremuneratorio ";
     $sql2 = "";
     if($dbwhere==""){
       if($te01_sequencial!=null ){
         $sql2 .= " where tetoremuneratorio.te01_sequencial = $te01_sequencial "; 
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
   function sql_query_file ( $te01_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from tetoremuneratorio ";
     $sql2 = "";
     if($dbwhere==""){
       if($te01_sequencial!=null ){
         $sql2 .= " where tetoremuneratorio.te01_sequencial = $te01_sequencial "; 
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
