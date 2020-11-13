<?
//MODULO: sicom
//CLASSE DA ENTIDADE itensregpreco
class cl_itensregpreco {
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
   var $si07_sequencial = 0;
   var $si07_numerolote = 0;
   var $si07_numeroitem = 0;
   //var $si07_descricaoitem = null;
   var $si07_item = 0;
   var $si07_precounitario = 0;
   var $si07_quantidadelicitada = 0;
   var $si07_quantidadeaderida = 0;
   //var $si07_unidade = null;
   var $si07_sequencialadesao = 0;
   var $si07_descricaolote = null;
   var $si07_fornecedor = null;
   var $si07_codunidade = null;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 si07_sequencial = int8 = Sequencial
                 si07_numerolote = int8 = Número do Lote
                 si07_numeroitem = int8 = Número do Item
                 si07_descricaoitem = text = Descrição Item
                 si07_item = int8 = Item
                 si07_precounitario = int8 = Preço Unitário
                 si07_quantidadelicitada = int8 = Quantidade Licitada
                 si07_quantidadeaderida = int8 = Quantidade Aderida
                 si07_unidade = text = Unidade
                 si07_sequencialadesao = int8 = Sequencial_adesão
                 si07_descricaolote = text = Descrição lote
                 si07_fornecedor = int8 = Cgm fornecedor
                 si07_codunidade = int8 = código da unidade
                 ";
   //funcao construtor da classe
   function cl_itensregpreco() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("itensregpreco");
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
       $this->si07_sequencial = ($this->si07_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si07_sequencial"]:$this->si07_sequencial);
       $this->si07_numerolote = ($this->si07_numerolote == ""?@$GLOBALS["HTTP_POST_VARS"]["si07_numerolote"]:$this->si07_numerolote);
       $this->si07_numeroitem = ($this->si07_numeroitem == ""?@$GLOBALS["HTTP_POST_VARS"]["si07_numeroitem"]:$this->si07_numeroitem);
       //$this->si07_descricaoitem = ($this->si07_descricaoitem == ""?@$GLOBALS["HTTP_POST_VARS"]["si07_descricaoitem"]:$this->si07_descricaoitem);
       $this->si07_item = ($this->si07_item == ""?@$GLOBALS["HTTP_POST_VARS"]["si07_item"]:$this->si07_item);
       $this->si07_precounitario = ($this->si07_precounitario == ""?@$GLOBALS["HTTP_POST_VARS"]["si07_precounitario"]:$this->si07_precounitario);
       $this->si07_quantidadelicitada = ($this->si07_quantidadelicitada == ""?@$GLOBALS["HTTP_POST_VARS"]["si07_quantidadelicitada"]:$this->si07_quantidadelicitada);
       $this->si07_quantidadeaderida = ($this->si07_quantidadeaderida == ""?@$GLOBALS["HTTP_POST_VARS"]["si07_quantidadeaderida"]:$this->si07_quantidadeaderida);
       //$this->si07_unidade = ($this->si07_unidade == ""?@$GLOBALS["HTTP_POST_VARS"]["si07_unidade"]:$this->si07_unidade);
       $this->si07_sequencialadesao = ($this->si07_sequencialadesao == ""?@$GLOBALS["HTTP_POST_VARS"]["si07_sequencialadesao"]:$this->si07_sequencialadesao);
       $this->si07_descricaolote = ($this->si07_descricaolote == ""?@$GLOBALS["HTTP_POST_VARS"]["si07_descricaolote"]:$this->si07_descricaolote);
       $this->si07_fornecedor = ($this->si07_fornecedor == ""?@$GLOBALS["HTTP_POST_VARS"]["si07_fornecedor"]:$this->si07_fornecedor);
       $this->si07_codunidade = ($this->si07_codunidade == ""?@$GLOBALS["HTTP_POST_VARS"]["si07_codunidade"]:$this->si07_codunidade);
     }else{
       $this->si07_sequencial = ($this->si07_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si07_sequencial"]:$this->si07_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($si07_sequencial){
      $this->atualizacampos();
     /*if($this->si07_numeroitem == null ){
       $this->erro_sql = " Campo Número do Item nao Informado.";
       $this->erro_campo = "si07_numeroitem";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }*/
     /*if($this->si07_descricaoitem == null ){
       $this->erro_sql = " Campo Descrição Item nao Informado.";
       $this->erro_campo = "si07_descricaoitem";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }*/
     if($this->si07_item == null ){
       $this->erro_sql = " Campo Item nao Informado.";
       $this->erro_campo = "si07_item";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si07_precounitario == null ){
       $this->erro_sql = " Campo Preço Unitário nao Informado.";
       $this->erro_campo = "si07_precounitario";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $resultDescTabela = db_query("select si06_descontotabela from adesaoregprecos where si06_sequencial = $this->si07_sequencialadesao");
     if($this->si07_quantidadelicitada == null && pg_result($resultDescTabela,0,0) == 2){
       $this->erro_sql = " Campo Quantidade Licitada nao Informado.";
       $this->erro_campo = "si07_quantidadelicitada";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si07_quantidadeaderida == null && pg_result($resultDescTabela,0,0) == 2){
       $this->erro_sql = " Campo Quantidade Aderida nao Informado.";
       $this->erro_campo = "si07_quantidadeaderida";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     /*if($this->si07_unidade == null ){
       $this->erro_sql = " Campo Unidade nao Informado.";
       $this->erro_campo = "si07_unidade";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }*/
     if($this->si07_sequencialadesao == null ){
       $this->erro_sql = " Campo Sequencial_adesão nao Informado.";
       $this->erro_campo = "si07_sequencialadesao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si07_codunidade == null ){
       $this->erro_sql = " Campo Unidade nao Informado.";
       $this->erro_campo = "si07_codunidade";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->si07_fornecedor == null ){
       $this->erro_sql = " Campo Fornecedor Ganhador nao Informado.";
       $this->erro_campo = "si07_fornecedor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $resultLote = db_query("select si06_processoporlote from adesaoregprecos where si06_sequencial = $this->si07_sequencialadesao");
     if(($this->si07_descricaolote == null || $this->si07_numerolote == null) && pg_result($resultLote,0,0) == 1){
       $this->erro_sql = " Campo Descrição e Número do Lote devem ser Informados.";
       $this->erro_campo = "si07_numerolote";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }

     if($si07_sequencial == "" || $si07_sequencial == null ){
       $result = db_query("select nextval('sic_itensregpreco_si07_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: sic_itensregpreco_si07_sequencial_seq do campo: si07_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->si07_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from sic_itensregpreco_si07_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $si07_sequencial)){
         $this->erro_sql = " Campo si07_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->si07_sequencial = $si07_sequencial;
       }
     }
     if(($this->si07_sequencial == null) || ($this->si07_sequencial == "") ){
       $this->erro_sql = " Campo si07_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $resultItem = db_query("select count(*) as quantidade from itensregpreco where si07_sequencialadesao = $this->si07_sequencialadesao");
       if(pg_result($resultItem,0,0) == 0){
           $this->si07_numeroitem = 1;
       } else {
           $resultItem = db_query("select max(si07_numeroitem)+1 as si07_numeroitem from itensregpreco where si07_sequencialadesao = $this->si07_sequencialadesao");
           $this->si07_numeroitem = pg_result($resultItem,0,0);
       }

     $sql = "insert into itensregpreco(
                                       si07_sequencial
                                      ,si07_numerolote
                                      ,si07_numeroitem
                                      ,si07_item
                                      ,si07_precounitario
                                      ,si07_quantidadelicitada
                                      ,si07_quantidadeaderida
                                      ,si07_sequencialadesao
                                      ,si07_codunidade
                                      ,si07_fornecedor
                                      ,si07_descricaolote
                       )
                values (
                                $this->si07_sequencial
                               ,".($this->si07_numerolote == null ? 'null' : $this->si07_numerolote)."
                               ,$this->si07_numeroitem
                               ,$this->si07_item
                               ,$this->si07_precounitario
                               ,".($this->si07_quantidadelicitada == null ? '0' : $this->si07_quantidadelicitada)."
                               ,".($this->si07_quantidadeaderida == null ? '0' : $this->si07_quantidadeaderida)."
                               ,$this->si07_sequencialadesao
                               ,$this->si07_codunidade
                               ,$this->si07_fornecedor
                               ,'$this->si07_descricaolote'
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "Itens Registro de Preço ($this->si07_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Itens Registro de Preço já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "Itens Registro de Preço ($this->si07_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si07_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->si07_sequencial));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,1009315,'$this->si07_sequencial','I')");
       $resac = db_query("insert into db_acount values($acount,2010206,1009315,'','".AddSlashes(pg_result($resaco,0,'si07_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010206,1009316,'','".AddSlashes(pg_result($resaco,0,'si07_numerolote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010206,1009317,'','".AddSlashes(pg_result($resaco,0,'si07_numeroitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010206,1009318,'','".AddSlashes(pg_result($resaco,0,'si07_descricaoitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010206,1009323,'','".AddSlashes(pg_result($resaco,0,'si07_item'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010206,1009319,'','".AddSlashes(pg_result($resaco,0,'si07_precounitario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010206,1009320,'','".AddSlashes(pg_result($resaco,0,'si07_quantidadelicitada'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010206,1009321,'','".AddSlashes(pg_result($resaco,0,'si07_quantidadeaderida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010206,1009322,'','".AddSlashes(pg_result($resaco,0,'si07_unidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,2010206,2009338,'','".AddSlashes(pg_result($resaco,0,'si07_sequencialadesao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   }
   // funcao para alteracao
   function alterar ($si07_sequencial=null) {
      $this->atualizacampos();
     $sql = " update itensregpreco set ";
     $virgula = "";
     if(trim($this->si07_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si07_sequencial"])){
       $sql  .= $virgula." si07_sequencial = $this->si07_sequencial ";
       $virgula = ",";
       if(trim($this->si07_sequencial) == null ){
         $this->erro_sql = " Campo Sequencial nao Informado.";
         $this->erro_campo = "si07_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     /*if(trim($this->si07_numeroitem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si07_numeroitem"])){
       $sql  .= $virgula." si07_numeroitem = $this->si07_numeroitem ";
       $virgula = ",";
       if(trim($this->si07_numeroitem) == null ){
         $this->erro_sql = " Campo Número do Item nao Informado.";
         $this->erro_campo = "si07_numeroitem";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }*/
     /*if(trim($this->si07_descricaoitem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si07_descricaoitem"])){
       $sql  .= $virgula." si07_descricaoitem = '$this->si07_descricaoitem' ";
       $virgula = ",";
       if(trim($this->si07_descricaoitem) == null ){
         $this->erro_sql = " Campo Descrição Item nao Informado.";
         $this->erro_campo = "si07_descricaoitem";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }*/
     if(trim($this->si07_item)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si07_item"])){
       $sql  .= $virgula." si07_item = $this->si07_item ";
       $virgula = ",";
       if(trim($this->si07_item) == null ){
         $this->erro_sql = " Campo Item nao Informado.";
         $this->erro_campo = "si07_item";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si07_precounitario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si07_precounitario"])){
       $sql  .= $virgula." si07_precounitario = $this->si07_precounitario ";
       $virgula = ",";
       if(trim($this->si07_precounitario) == null ){
         $this->erro_sql = " Campo Preço Unitário nao Informado.";
         $this->erro_campo = "si07_precounitario";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $resultDescTabela = db_query("select si06_descontotabela from adesaoregprecos where si06_sequencial = $this->si07_sequencialadesao");
     if(trim($this->si07_quantidadelicitada)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si07_quantidadelicitada"])){
       $sql  .= $virgula." si07_quantidadelicitada = ".($this->si07_quantidadelicitada == null ? '0' : $this->si07_quantidadelicitada);
       $virgula = ",";
       if(trim($this->si07_quantidadelicitada) == null && pg_result($resultDescTabela,0,0) == 2){
         $this->erro_sql = " Campo Quantidade Licitada nao Informado.";
         $this->erro_campo = "si07_quantidadelicitada";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si07_quantidadeaderida)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si07_quantidadeaderida"])){
       $sql  .= $virgula." si07_quantidadeaderida = ".($this->si07_quantidadeaderida == null ? '0' : $this->si07_quantidadeaderida);
       $virgula = ",";
       if(trim($this->si07_quantidadeaderida) == null && pg_result($resultDescTabela,0,0) == 2){
         $this->erro_sql = " Campo Quantidade Aderida nao Informado.";
         $this->erro_campo = "si07_quantidadeaderida";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     /*if(trim($this->si07_unidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si07_unidade"])){
       $sql  .= $virgula." si07_unidade = '$this->si07_unidade' ";
       $virgula = ",";
       if(trim($this->si07_unidade) == null ){
         $this->erro_sql = " Campo Unidade nao Informado.";
         $this->erro_campo = "si07_unidade";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }*/
     if(trim($this->si07_sequencialadesao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si07_sequencialadesao"])){
       $sql  .= $virgula." si07_sequencialadesao = $this->si07_sequencialadesao ";
       $virgula = ",";
       if(trim($this->si07_sequencialadesao) == null ){
         $this->erro_sql = " Campo Sequencial_adesão nao Informado.";
         $this->erro_campo = "si07_sequencialadesao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }

     if(trim($this->si07_codunidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si07_codunidade"])) {
       $sql .= $virgula . " si07_codunidade = $this->si07_codunidade ";
       $virgula = ",";
       if ($this->si07_codunidade == null) {
         $this->erro_sql = " Campo Unidade nao Informado.";
         $this->erro_campo = "si07_codunidade";
         $this->erro_banco = "";
         $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
         $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->si07_fornecedor)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si07_fornecedor"])) {
       $sql .= $virgula . " si07_fornecedor = $this->si07_fornecedor ";
       $virgula = ",";
       if ($this->si07_fornecedor == null) {
         $this->erro_sql = " Campo Fornecedor Ganhador nao Informado.";
         $this->erro_campo = "si07_fornecedor";
         $this->erro_banco = "";
         $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
         $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $resultLote = db_query("select si06_processoporlote from adesaoregprecos where si06_sequencial = $this->si07_sequencialadesao");
       if (($this->si07_numerolote == null || !$this->si07_numerolote) && pg_result($resultLote, 0, 0) == 1) {
         $this->erro_sql = " Campo Descrição e Número do Lote devem ser Informados.";
         $this->erro_campo = "si07_numerolote";
         $this->erro_banco = "";
         $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
         $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         if(pg_result($resultLote, 0, 0) == 2){
           $sql .= $virgula . " si07_numerolote = null ";
           $virgula = ",";
         }else{
            $sql .= $virgula . " si07_numerolote = $this->si07_numerolote ";
            $virgula = ",";
         }
     }
     if((trim($this->si07_descricaolote) == null || !$this->si07_descricaolote) && pg_result($resultLote, 0, 0) == 1) {
         $this->erro_sql = " Campo Descrição e Número do Lote devem ser Informados.";
         $this->erro_campo = "si07_descricaolote";
         $this->erro_banco = "";
         $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
         $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
         $this->erro_status = "0";
         return false;
     }else{
        if(pg_result($resultLote, 0, 0) == 2){
            $sql .= $virgula . " si07_descricaolote = null ";
        }else{
            $sql .= $virgula . " si07_descricaolote = '$this->si07_descricaolote' ";
        }

     }

     $sql .= " where ";
     if($si07_sequencial!=null){
       $sql .= " si07_sequencial = $si07_sequencial";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->si07_sequencial));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2009315,'$this->si07_sequencial','A')");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si07_sequencial"]) || $this->si07_sequencial != "")
           $resac = db_query("insert into db_acount values($acount,2010206,2009315,'".AddSlashes(pg_result($resaco,$conresaco,'si07_sequencial'))."','$this->si07_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si07_numerolote"]) || $this->si07_numerolote != "")
           $resac = db_query("insert into db_acount values($acount,2010206,2009316,'".AddSlashes(pg_result($resaco,$conresaco,'si07_numerolote'))."','$this->si07_numerolote',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si07_numeroitem"]) || $this->si07_numeroitem != "")
           $resac = db_query("insert into db_acount values($acount,2010206,2009317,'".AddSlashes(pg_result($resaco,$conresaco,'si07_numeroitem'))."','$this->si07_numeroitem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si07_descricaoitem"]) || $this->si07_descricaoitem != "")
           $resac = db_query("insert into db_acount values($acount,2010206,2009318,'".AddSlashes(pg_result($resaco,$conresaco,'si07_descricaoitem'))."','$this->si07_descricaoitem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si07_item"]) || $this->si07_item != "")
           $resac = db_query("insert into db_acount values($acount,2010206,2009323,'".AddSlashes(pg_result($resaco,$conresaco,'si07_item'))."','$this->si07_item',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si07_precounitario"]) || $this->si07_precounitario != "")
           $resac = db_query("insert into db_acount values($acount,2010206,2009319,'".AddSlashes(pg_result($resaco,$conresaco,'si07_precounitario'))."','$this->si07_precounitario',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si07_quantidadelicitada"]) || $this->si07_quantidadelicitada != "")
           $resac = db_query("insert into db_acount values($acount,2010206,2009320,'".AddSlashes(pg_result($resaco,$conresaco,'si07_quantidadelicitada'))."','$this->si07_quantidadelicitada',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si07_quantidadeaderida"]) || $this->si07_quantidadeaderida != "")
           $resac = db_query("insert into db_acount values($acount,2010206,2009321,'".AddSlashes(pg_result($resaco,$conresaco,'si07_quantidadeaderida'))."','$this->si07_quantidadeaderida',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si07_unidade"]) || $this->si07_unidade != "")
           $resac = db_query("insert into db_acount values($acount,2010206,2009322,'".AddSlashes(pg_result($resaco,$conresaco,'si07_unidade'))."','$this->si07_unidade',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         if(isset($GLOBALS["HTTP_POST_VARS"]["si07_sequencialadesao"]) || $this->si07_sequencialadesao != "")
           $resac = db_query("insert into db_acount values($acount,2010206,2009338,'".AddSlashes(pg_result($resaco,$conresaco,'si07_sequencialadesao'))."','$this->si07_sequencialadesao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Itens Registro de Preço nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->si07_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Itens Registro de Preço nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->si07_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->si07_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($si07_sequencial=null,$dbwhere=null) {
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($si07_sequencial));
     }else{
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009315,'$si07_sequencial','E')");
         $resac = db_query("insert into db_acount values($acount,2010206,1009315,'','".AddSlashes(pg_result($resaco,$iresaco,'si07_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010206,1009316,'','".AddSlashes(pg_result($resaco,$iresaco,'si07_numerolote'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010206,1009317,'','".AddSlashes(pg_result($resaco,$iresaco,'si07_numeroitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010206,1009318,'','".AddSlashes(pg_result($resaco,$iresaco,'si07_descricaoitem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010206,1009323,'','".AddSlashes(pg_result($resaco,$iresaco,'si07_item'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010206,1009319,'','".AddSlashes(pg_result($resaco,$iresaco,'si07_precounitario'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010206,1009320,'','".AddSlashes(pg_result($resaco,$iresaco,'si07_quantidadelicitada'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010206,1009321,'','".AddSlashes(pg_result($resaco,$iresaco,'si07_quantidadeaderida'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010206,1009322,'','".AddSlashes(pg_result($resaco,$iresaco,'si07_unidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2010206,2009338,'','".AddSlashes(pg_result($resaco,$iresaco,'si07_sequencialadesao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from itensregpreco
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($si07_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " si07_sequencial = $si07_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Itens Registro de Preço nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$si07_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "Itens Registro de Preço nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$si07_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$si07_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:itensregpreco";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $si07_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from itensregpreco ";
     $sql2 = "";
     if($dbwhere==""){
       if($si07_sequencial!=null ){
         $sql2 .= " where itensregpreco.si07_sequencial = $si07_sequencial ";
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
     //echo $sql;exit;
     return $sql;
  }
   // funcao do sql
   function sql_query_file ( $si07_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from itensregpreco ";
     $sql2 = "";
     if($dbwhere==""){
       if($si07_sequencial!=null ){
         $sql2 .= " where itensregpreco.si07_sequencial = $si07_sequencial ";
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

  /**
   * função adicionada para atender as necesidades da nova tela de itens
   */
  function sql_query_novo ( $si07_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from itensregpreco ";
    $sql .= " inner join pcmater on pcmater.pc01_codmater = itensregpreco.si07_item ";
    $sql .= " inner join db_usuarios on db_usuarios.id_usuario = pcmater.pc01_id_usuario ";
    $sql .= " inner join pcsubgrupo on pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo ";
    $sql .= " left join cgm on si07_fornecedor = z01_numcgm ";
    $sql .= " left join matunid on si07_codunidade = m61_codmatunid ";
    $sql2 = "";
    if($dbwhere==""){
      if($si07_sequencial!=null ){
        $sql2 .= " where itensregpreco.si07_sequencial = $si07_sequencial ";
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
