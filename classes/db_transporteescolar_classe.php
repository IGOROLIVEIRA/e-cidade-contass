<?
//MODULO: veiculos
//CLASSE DA ENTIDADE transporteescolar
class cl_transporteescolar { 
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
   var $v200_sequencial = 0; 
   var $v200_veiculo = 0; 
   var $v200_escola = null; 
   var $v200_localidade = null; 
   var $v200_numpassageiros = 0; 
   var $v200_distancia = 0; 
   var $v200_turno = 0; 
   var $v200_periodo = 0;
   var $v200_diasrodados = 0; 
   var $v200_anousu = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 v200_sequencial = int4 = Sequencial 
                 v200_veiculo = int4 = Veiculo 
                 v200_escola = varchar(50) = Nome do Estabelecimento de ensino 
                 v200_localidade = varchar(50) = Localidade 
                 v200_numpassageiros = int4 = Número de Passageiros 
                 v200_distancia = float8 = Distância Percorrida 
                 v200_turno = int4 = Turno 
                 v200_periodo = int4 = Período
                 v200_diasrodados = int4 = Quantidade de Dias Rodados
                 v200_anousu = int4 = Ano
                 ";
   //funcao construtor da classe 
   function cl_transporteescolar() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("transporteescolar"); 
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
       $this->v200_sequencial = ($this->v200_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["v200_sequencial"]:$this->v200_sequencial);
       $this->v200_veiculo = ($this->v200_veiculo == ""?@$GLOBALS["HTTP_POST_VARS"]["v200_veiculo"]:$this->v200_veiculo);
       $this->v200_escola = ($this->v200_escola == ""?@$GLOBALS["HTTP_POST_VARS"]["v200_escola"]:$this->v200_escola);
       $this->v200_localidade = ($this->v200_localidade == ""?@$GLOBALS["HTTP_POST_VARS"]["v200_localidade"]:$this->v200_localidade);
       $this->v200_numpassageiros = ($this->v200_numpassageiros == ""?@$GLOBALS["HTTP_POST_VARS"]["v200_numpassageiros"]:$this->v200_numpassageiros);
       $this->v200_distancia = ($this->v200_distancia == ""?@$GLOBALS["HTTP_POST_VARS"]["v200_distancia"]:$this->v200_distancia);
       $this->v200_turno = ($this->v200_turno == ""?@$GLOBALS["HTTP_POST_VARS"]["v200_turno"]:$this->v200_turno);
       $this->v200_periodo = ($this->v200_periodo == ""?@$GLOBALS["HTTP_POST_VARS"]["v200_periodo"]:$this->v200_periodo);
       $this->v200_diasrodados = ($this->v200_diasrodados == ""?@$GLOBALS["HTTP_POST_VARS"]["v200_diasrodados"]:$this->v200_diasrodados);
     }else{
       $this->v200_sequencial = ($this->v200_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["v200_sequencial"]:$this->v200_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($v200_sequencial){ 
      $this->atualizacampos();
     if($this->v200_veiculo == null ){ 
       $this->erro_sql = " Campo Veiculo nao Informado.";
       $this->erro_campo = "v200_veiculo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v200_escola == null ){ 
       $this->erro_sql = " Campo Nome do Estabelecimento de ensino nao Informado.";
       $this->erro_campo = "v200_escola";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v200_localidade == null ){ 
       $this->erro_sql = " Campo Localidade nao Informado.";
       $this->erro_campo = "v200_localidade";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v200_numpassageiros == null ){ 
       $this->erro_sql = " Campo Número de Passageiros nao Informado.";
       $this->erro_campo = "v200_numpassageiros";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v200_distancia == null ){ 
       $this->erro_sql = " Campo Distância Percorrida nao Informado.";
       $this->erro_campo = "v200_distancia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v200_turno == null ){ 
       $this->erro_sql = " Campo Turno nao Informado.";
       $this->erro_campo = "v200_turno";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v200_periodo == null ){ 
       $this->erro_sql = " Campo Período nao Informado.";
       $this->erro_campo = "v200_periodo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->v200_diasrodados == null ){
       $this->erro_sql = " Campo Quantidade de Dias nao Informado.";
       $this->erro_campo = "v200_diasrodados";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuï¿½rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($v200_sequencial == "" || $v200_sequencial == null ){
       $result = db_query("select nextval('transporteescolar_v200_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: transporteescolar_v200_sequencial_seq do campo: v200_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->v200_sequencial = pg_result($result,0,0); 
     }else{
       $result = db_query("select last_value from transporteescolar_v200_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $v200_sequencial)){
         $this->erro_sql = " Campo v200_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->v200_sequencial = $v200_sequencial; 
       }
     }
     if(($this->v200_sequencial == null) || ($this->v200_sequencial == "") ){ 
       $this->erro_sql = " Campo v200_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into transporteescolar(
                                       v200_sequencial 
                                      ,v200_veiculo 
                                      ,v200_escola 
                                      ,v200_localidade 
                                      ,v200_numpassageiros 
                                      ,v200_distancia 
                                      ,v200_turno 
                                      ,v200_periodo
                                      ,v200_diasrodados
                                      ,v200_anousu 
                       )
                values (
                                $this->v200_sequencial 
                               ,$this->v200_veiculo 
                               ,'$this->v200_escola' 
                               ,'$this->v200_localidade' 
                               ,$this->v200_numpassageiros 
                               ,$this->v200_distancia 
                               ,$this->v200_turno 
                               ,$this->v200_periodo
                               ,$this->v200_diasrodados
                               ,".db_getsession('DB_anousu')."
                      )";
     $result = db_query($sql); 
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Trasporte Escolar ($this->v200_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Trasporte Escolar já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Trasporte Escolar ($this->v200_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->v200_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->v200_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,2009437,'$this->v200_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010222,2009437,'','".AddSlashes(pg_result($resaco,0,'v200_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010222,2009438,'','".AddSlashes(pg_result($resaco,0,'v200_veiculo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010222,2009439,'','".AddSlashes(pg_result($resaco,0,'v200_escola'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010222,2009440,'','".AddSlashes(pg_result($resaco,0,'v200_localidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010222,2009441,'','".AddSlashes(pg_result($resaco,0,'v200_numpassageiros'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010222,2009442,'','".AddSlashes(pg_result($resaco,0,'v200_distancia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010222,2009443,'','".AddSlashes(pg_result($resaco,0,'v200_turno'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010222,2009444,'','".AddSlashes(pg_result($resaco,0,'v200_periodo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   } 
   // funcao para alteracao
   function alterar ($v200_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update transporteescolar set ";
     $virgula = "";
     if(trim($this->v200_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["v200_sequencial"])){ 
       $sql  .= $virgula." v200_sequencial = $this->v200_sequencial ";
       $virgula = ",";
       if(trim($this->v200_sequencial) == null ){ 
         $this->erro_sql = " Campo Sequencial nao Informado.";
         $this->erro_campo = "v200_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->v200_veiculo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["v200_veiculo"])){ 
       $sql  .= $virgula." v200_veiculo = $this->v200_veiculo ";
       $virgula = ",";
       if(trim($this->v200_veiculo) == null ){ 
         $this->erro_sql = " Campo Veiculo nao Informado.";
         $this->erro_campo = "v200_veiculo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->v200_escola)!="" || isset($GLOBALS["HTTP_POST_VARS"]["v200_escola"])){ 
       $sql  .= $virgula." v200_escola = '$this->v200_escola' ";
       $virgula = ",";
       if(trim($this->v200_escola) == null ){ 
         $this->erro_sql = " Campo Nome do Estabelecimento de ensino nao Informado.";
         $this->erro_campo = "v200_escola";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->v200_localidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["v200_localidade"])){ 
       $sql  .= $virgula." v200_localidade = '$this->v200_localidade' ";
       $virgula = ",";
       if(trim($this->v200_localidade) == null ){ 
         $this->erro_sql = " Campo Localidade nao Informado.";
         $this->erro_campo = "v200_localidade";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->v200_numpassageiros)!="" || isset($GLOBALS["HTTP_POST_VARS"]["v200_numpassageiros"])){ 
       $sql  .= $virgula." v200_numpassageiros = $this->v200_numpassageiros ";
       $virgula = ",";
       if(trim($this->v200_numpassageiros) == null ){ 
         $this->erro_sql = " Campo Número de Passageiros nao Informado.";
         $this->erro_campo = "v200_numpassageiros";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->v200_distancia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["v200_distancia"])){ 
       $sql  .= $virgula." v200_distancia = $this->v200_distancia ";
       $virgula = ",";
       if(trim($this->v200_distancia) == null ){ 
         $this->erro_sql = " Campo Distância Percorrida nao Informado.";
         $this->erro_campo = "v200_distancia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->v200_turno)!="" || isset($GLOBALS["HTTP_POST_VARS"]["v200_turno"])){ 
       $sql  .= $virgula." v200_turno = $this->v200_turno ";
       $virgula = ",";
       if(trim($this->v200_turno) == null ){ 
         $this->erro_sql = " Campo Turno nao Informado.";
         $this->erro_campo = "v200_turno";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->v200_periodo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["v200_periodo"])){ 
       $sql  .= $virgula." v200_periodo = $this->v200_periodo ";
       $virgula = ",";
       if(trim($this->v200_periodo) == null ){ 
         $this->erro_sql = " Campo Período nao Informado.";
         $this->erro_campo = "v200_periodo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->v200_diasrodados)!="" || isset($GLOBALS["HTTP_POST_VARS"]["v200_diasrodados"])){
       $sql  .= $virgula." v200_diasrodados = $this->v200_diasrodados ";
       $virgula = ",";
       if(trim($this->v200_diasrodados) == null ){
         $this->erro_sql = " Campo Quantidade de Dias nao Informado.";
         $this->erro_campo = "v200_diasrodados";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuï¿½rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     /**
      * @ocorrencia: 1211
      * @Task: Correção da rotina de inclusão/alteração do transporte escolar. Acrescentado o SQL do anousu.
      * @author: Rodrigo@contass
      */
     $sql .= ", v200_anousu = ".db_getsession('DB_anousu');
     $sql .= " where ";
     if($v200_sequencial!=null){
       $sql .= " v200_sequencial = $this->v200_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->v200_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009437,'$this->v200_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["v200_sequencial"]) || $this->v200_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010222,2009437,'".AddSlashes(pg_result($resaco,$conresaco,'v200_sequencial'))."','$this->v200_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["v200_veiculo"]) || $this->v200_veiculo != "")
           $resac = db_query("insert into db_acount values($acount,2010222,2009438,'".AddSlashes(pg_result($resaco,$conresaco,'v200_veiculo'))."','$this->v200_veiculo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["v200_escola"]) || $this->v200_escola != "")
           $resac = db_query("insert into db_acount values($acount,2010222,2009439,'".AddSlashes(pg_result($resaco,$conresaco,'v200_escola'))."','$this->v200_escola',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["v200_localidade"]) || $this->v200_localidade != "")
           $resac = db_query("insert into db_acount values($acount,2010222,2009440,'".AddSlashes(pg_result($resaco,$conresaco,'v200_localidade'))."','$this->v200_localidade',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["v200_numpassageiros"]) || $this->v200_numpassageiros != "")
           $resac = db_query("insert into db_acount values($acount,2010222,2009441,'".AddSlashes(pg_result($resaco,$conresaco,'v200_numpassageiros'))."','$this->v200_numpassageiros',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["v200_distancia"]) || $this->v200_distancia != "")
           $resac = db_query("insert into db_acount values($acount,2010222,2009442,'".AddSlashes(pg_result($resaco,$conresaco,'v200_distancia'))."','$this->v200_distancia',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["v200_turno"]) || $this->v200_turno != "")
           $resac = db_query("insert into db_acount values($acount,2010222,2009443,'".AddSlashes(pg_result($resaco,$conresaco,'v200_turno'))."','$this->v200_turno',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["v200_periodo"]) || $this->v200_periodo != "")
           $resac = db_query("insert into db_acount values($acount,2010222,2009444,'".AddSlashes(pg_result($resaco,$conresaco,'v200_periodo'))."','$this->v200_periodo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Trasporte Escolar nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->v200_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Trasporte Escolar nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->v200_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->v200_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($v200_sequencial=null,$dbwhere=null) { 
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($v200_sequencial));
     }else{ 
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009437,'$v200_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010222,2009437,'','".AddSlashes(pg_result($resaco,$iresaco,'v200_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010222,2009438,'','".AddSlashes(pg_result($resaco,$iresaco,'v200_veiculo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010222,2009439,'','".AddSlashes(pg_result($resaco,$iresaco,'v200_escola'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010222,2009440,'','".AddSlashes(pg_result($resaco,$iresaco,'v200_localidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010222,2009441,'','".AddSlashes(pg_result($resaco,$iresaco,'v200_numpassageiros'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010222,2009442,'','".AddSlashes(pg_result($resaco,$iresaco,'v200_distancia'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010222,2009443,'','".AddSlashes(pg_result($resaco,$iresaco,'v200_turno'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010222,2009444,'','".AddSlashes(pg_result($resaco,$iresaco,'v200_periodo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from transporteescolar
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($v200_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " v200_sequencial = $v200_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Trasporte Escolar nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$v200_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Trasporte Escolar nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$v200_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$v200_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:transporteescolar";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $v200_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from transporteescolar ";
     $sql .= "      inner join veiculos  on  veiculos.ve01_codigo = transporteescolar.v200_veiculo";
     $sql .= "      inner join ceplocalidades  on  ceplocalidades.cp05_codlocalidades = veiculos.ve01_ceplocalidades";
     $sql .= "      inner join veiccadtipo  on  veiccadtipo.ve20_codigo = veiculos.ve01_veiccadtipo";
     $sql .= "      inner join veiccadmarca  on  veiccadmarca.ve21_codigo = veiculos.ve01_veiccadmarca";
     $sql .= "      inner join veiccadmodelo  on  veiccadmodelo.ve22_codigo = veiculos.ve01_veiccadmodelo";
     $sql .= "      inner join veiccadcor  on  veiccadcor.ve23_codigo = veiculos.ve01_veiccadcor";
     $sql .= "      inner join veiccadtipocapacidade  on  veiccadtipocapacidade.ve24_codigo = veiculos.ve01_veiccadtipocapacidade";
     $sql .= "      inner join veiccadcategcnh  on  veiccadcategcnh.ve30_codigo = veiculos.ve01_veiccadcategcnh";
     $sql .= "      inner join veiccadproced  on  veiccadproced.ve25_codigo = veiculos.ve01_veiccadproced";
     $sql .= "      inner join veiccadpotencia  on  veiccadpotencia.ve31_codigo = veiculos.ve01_veiccadpotencia";
     $sql .= "      inner join veiccadcateg  as a on   a.ve32_codigo = veiculos.ve01_veiccadcateg";
     $sql .= "      inner join veictipoabast  on  veictipoabast.ve07_sequencial = veiculos.ve01_veictipoabast";
     $sql2 = "";
     if($dbwhere==""){
       if($v200_sequencial!=null ){
         $sql2 .= " where transporteescolar.v200_sequencial = $v200_sequencial "; 
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
   function sql_query_file ( $v200_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from transporteescolar ";
     $sql2 = "";
     if($dbwhere==""){
       if($v200_sequencial!=null ){
         $sql2 .= " where transporteescolar.v200_sequencial = $v200_sequencial "; 
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
