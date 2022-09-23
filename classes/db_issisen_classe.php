<?php

class cl_issisen {
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
   var $q148_codigo = 0;
   var $q148_inscr = 0;
   var $q148_tipo = 0;
   var $q148_dtini_dia = null;
   var $q148_dtini_mes = null;
   var $q148_dtini_ano = null;
   var $q148_dtini = null;
   var $q148_dtfim_dia = null;
   var $q148_dtfim_mes = null;
   var $q148_dtfim_ano = null;
   var $q148_dtfim = null;
   var $q148_perc = 0;
   var $q148_dtinc_dia = null;
   var $q148_dtinc_mes = null;
   var $q148_dtinc_ano = null;
   var $q148_dtinc = null;
   var $q148_idusu = 0;
   var $q148_hist = null;
   var $q148_receit = 0;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 q148_codigo = int4 = Codigo Isencao
                 q148_inscr = int4 = Inscrição
                 q148_tipo = int4 = Tipo Isencao
                 q148_dtini = date = Data Inicio
                 q148_dtfim = date = Data Final
                 q148_perc = float8 = Percentual
                 q148_dtinc = date = Data inclusao
                 q148_idusu = int4 = Codigo do Usuario
                 q148_hist = text = Historico
                 q148_receit = int4 = Receita
                 ";
   function __construct() {
     $this->rotulo = new rotulo("issisen");
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
       $this->q148_codigo = ($this->q148_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_codigo"]:$this->q148_codigo);
       $this->q148_inscr = ($this->q148_inscr == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_inscr"]:$this->q148_inscr);
       $this->q148_tipo = ($this->q148_tipo == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_tipo"]:$this->q148_tipo);
       if($this->q148_dtini == ""){
         $this->q148_dtini_dia = ($this->q148_dtini_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_dtini_dia"]:$this->q148_dtini_dia);
         $this->q148_dtini_mes = ($this->q148_dtini_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_dtini_mes"]:$this->q148_dtini_mes);
         $this->q148_dtini_ano = ($this->q148_dtini_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_dtini_ano"]:$this->q148_dtini_ano);
         if($this->q148_dtini_dia != ""){
            $this->q148_dtini = $this->q148_dtini_ano."-".$this->q148_dtini_mes."-".$this->q148_dtini_dia;
         }
       }
       if($this->q148_dtfim == ""){
         $this->q148_dtfim_dia = ($this->q148_dtfim_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_dtfim_dia"]:$this->q148_dtfim_dia);
         $this->q148_dtfim_mes = ($this->q148_dtfim_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_dtfim_mes"]:$this->q148_dtfim_mes);
         $this->q148_dtfim_ano = ($this->q148_dtfim_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_dtfim_ano"]:$this->q148_dtfim_ano);
         if($this->q148_dtfim_dia != ""){
            $this->q148_dtfim = $this->q148_dtfim_ano."-".$this->q148_dtfim_mes."-".$this->q148_dtfim_dia;
         }
       }
       $this->q148_perc = ($this->q148_perc == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_perc"]:$this->q148_perc);
       if($this->q148_dtinc == ""){
         $this->q148_dtinc_dia = ($this->q148_dtinc_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_dtinc_dia"]:$this->q148_dtinc_dia);
         $this->q148_dtinc_mes = ($this->q148_dtinc_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_dtinc_mes"]:$this->q148_dtinc_mes);
         $this->q148_dtinc_ano = ($this->q148_dtinc_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_dtinc_ano"]:$this->q148_dtinc_ano);
         if($this->q148_dtinc_dia != ""){
            $this->q148_dtinc = $this->q148_dtinc_ano."-".$this->q148_dtinc_mes."-".$this->q148_dtinc_dia;
         }
       }
       $this->q148_idusu = ($this->q148_idusu == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_idusu"]:$this->q148_idusu);
       $this->q148_hist = ($this->q148_hist == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_hist"]:$this->q148_hist);
       $this->q148_receit = ($this->q148_receit == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_receit"]:$this->q148_receit);
     }else{
       $this->q148_codigo = ($this->q148_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["q148_codigo"]:$this->q148_codigo);
     }
   }
   // funcao para inclusao
   function incluir ($q148_codigo){
      $this->atualizacampos();
     if($this->q148_inscr == null ){
       $this->erro_sql = " Campo Inscrição nao Informado.";
       $this->erro_campo = "q148_inscr";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q148_tipo == null ){
       $this->erro_sql = " Campo Tipo Isencao nao Informado.";
       $this->erro_campo = "q148_tipo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q148_dtini == null ){
       $this->erro_sql = " Campo Data Inicio nao Informado.";
       $this->erro_campo = "q148_dtini_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q148_dtfim == null ){
       $this->q148_dtfim = "null";
     }
     if($this->q148_perc == null ){
       $this->erro_sql = " Campo Percentual nao Informado.";
       $this->erro_campo = "q148_perc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q148_dtinc == null ){
       $this->erro_sql = " Campo Data inclusao nao Informado.";
       $this->erro_campo = "q148_dtinc_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q148_idusu == null ){
       $this->erro_sql = " Campo Codigo do Usuario nao Informado.";
       $this->erro_campo = "q148_idusu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q148_hist == null ){
       $this->erro_sql = " Campo Historico nao Informado.";
       $this->erro_campo = "q148_hist";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->q148_receit == null ){
       $this->q148_receit = "0";
     }
     if($q148_codigo == "" || $q148_codigo == null ){
       $result = db_query("select nextval('issisen_q148_codigo_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: issisen_q148_codigo_seq do campo: q148_codigo";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->q148_codigo = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from issisen_q148_codigo_seq");
       if(($result != false) && (pg_result($result,0,0) < $q148_codigo)){
         $this->erro_sql = " Campo q148_codigo maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->q148_codigo = $q148_codigo;
       }
     }
     if(($this->q148_codigo == null) || ($this->q148_codigo == "") ){
       $this->erro_sql = " Campo q148_codigo nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into issisen(
                                       q148_codigo
                                      ,q148_inscr
                                      ,q148_tipo
                                      ,q148_dtini
                                      ,q148_dtfim
                                      ,q148_perc
                                      ,q148_dtinc
                                      ,q148_idusu
                                      ,q148_hist
                                      ,q148_receit
                       )
                values (
                                $this->q148_codigo
                               ,$this->q148_inscr
                               ,$this->q148_tipo
                               ,".($this->q148_dtini == "null" || $this->q148_dtini == ""?"null":"'".$this->q148_dtini."'")."
                               ,".($this->q148_dtfim == "null" || $this->q148_dtfim == ""?"null":"'".$this->q148_dtfim."'")."
                               ,$this->q148_perc
                               ,".($this->q148_dtinc == "null" || $this->q148_dtinc == ""?"null":"'".$this->q148_dtinc."'")."
                               ,$this->q148_idusu
                               ,'$this->q148_hist'
                               ,$this->q148_receit
                      )";
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = " ($this->q148_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = " já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = " ($this->q148_codigo) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->q148_codigo;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $resaco = $this->sql_record($this->sql_query_file($this->q148_codigo));
     if(($resaco!=false)||($this->numrows!=0)){
       $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
       $acount = pg_result($resac,0,0);
       $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
       $resac = db_query("insert into db_acountkey values($acount,(select codcam from db_syscampo where nomecam = 'q148_inscr'),'$this->q148_codigo','I')");
       $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_codigo'),'','".AddSlashes(pg_result($resaco,0,'q148_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_inscr'),'','".AddSlashes(pg_result($resaco,0,'q148_inscr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_tipo'),'','".AddSlashes(pg_result($resaco,0,'q148_tipo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_dtini'),'','".AddSlashes(pg_result($resaco,0,'q148_dtini'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_dtfim'),'','".AddSlashes(pg_result($resaco,0,'q148_dtfim'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_perc'),'','".AddSlashes(pg_result($resaco,0,'q148_perc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_dtinc'),'','".AddSlashes(pg_result($resaco,0,'q148_dtinc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_idusu'),'','".AddSlashes(pg_result($resaco,0,'q148_idusu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_hist'),'','".AddSlashes(pg_result($resaco,0,'q148_hist'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_receit'),'','".AddSlashes(pg_result($resaco,0,'q148_receit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
     }
     return true;
   }
   // funcao para alteracao
   function alterar ($q148_codigo=null) {
      $this->atualizacampos();
     $sql = " update issisen set ";
     $virgula = "";
     if(trim($this->q148_codigo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q148_codigo"])){
       $sql  .= $virgula." q148_codigo = $this->q148_codigo ";
       $virgula = ",";
       if(trim($this->q148_codigo) == null ){
         $this->erro_sql = " Campo Codigo Isencao nao Informado.";
         $this->erro_campo = "q148_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q148_inscr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q148_inscr"])){
       $sql  .= $virgula." q148_inscr = $this->q148_inscr ";
       $virgula = ",";
       if(trim($this->q148_inscr) == null ){
         $this->erro_sql = " Campo Inscrição nao Informado.";
         $this->erro_campo = "q148_inscr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q148_tipo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q148_tipo"])){
       $sql  .= $virgula." q148_tipo = $this->q148_tipo ";
       $virgula = ",";
       if(trim($this->q148_tipo) == null ){
         $this->erro_sql = " Campo Tipo Isencao nao Informado.";
         $this->erro_campo = "q148_tipo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q148_dtini)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q148_dtini_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["q148_dtini_dia"] !="") ){
       $sql  .= $virgula." q148_dtini = '$this->q148_dtini' ";
       $virgula = ",";
       if(trim($this->q148_dtini) == null ){
         $this->erro_sql = " Campo Data Inicio nao Informado.";
         $this->erro_campo = "q148_dtini_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["q148_dtini_dia"])){
         $sql  .= $virgula." q148_dtini = null ";
         $virgula = ",";
         if(trim($this->q148_dtini) == null ){
           $this->erro_sql = " Campo Data Inicio nao Informado.";
           $this->erro_campo = "q148_dtini_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->q148_dtfim)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q148_dtfim_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["q148_dtfim_dia"] !="") ){
       $sql  .= $virgula." q148_dtfim = '$this->q148_dtfim' ";
       $virgula = ",";
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["q148_dtfim_dia"])){
         $sql  .= $virgula." q148_dtfim = null ";
         $virgula = ",";
       }
     }
     if(trim($this->q148_perc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q148_perc"])){
       $sql  .= $virgula." q148_perc = $this->q148_perc ";
       $virgula = ",";
       if(trim($this->q148_perc) == null ){
         $this->erro_sql = " Campo Percentual nao Informado.";
         $this->erro_campo = "q148_perc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q148_dtinc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q148_dtinc_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["q148_dtinc_dia"] !="") ){
       $sql  .= $virgula." q148_dtinc = '$this->q148_dtinc' ";
       $virgula = ",";
       if(trim($this->q148_dtinc) == null ){
         $this->erro_sql = " Campo Data inclusao nao Informado.";
         $this->erro_campo = "q148_dtinc_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["q148_dtinc_dia"])){
         $sql  .= $virgula." q148_dtinc = null ";
         $virgula = ",";
         if(trim($this->q148_dtinc) == null ){
           $this->erro_sql = " Campo Data inclusao nao Informado.";
           $this->erro_campo = "q148_dtinc_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->q148_idusu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q148_idusu"])){
       $sql  .= $virgula." q148_idusu = $this->q148_idusu ";
       $virgula = ",";
       if(trim($this->q148_idusu) == null ){
         $this->erro_sql = " Campo Codigo do Usuario nao Informado.";
         $this->erro_campo = "q148_idusu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q148_hist)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q148_hist"])){
       $sql  .= $virgula." q148_hist = '$this->q148_hist' ";
       $virgula = ",";
       if(trim($this->q148_hist) == null ){
         $this->erro_sql = " Campo Historico nao Informado.";
         $this->erro_campo = "q148_hist";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->q148_receit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["q148_receit"])){
        if(trim($this->q148_receit)=="" && isset($GLOBALS["HTTP_POST_VARS"]["q148_receit"])){
           $this->q148_receit = "0" ;
        }
       $sql  .= $virgula." q148_receit = $this->q148_receit ";
       $virgula = ",";
     }
     $sql .= " where ";
     if($q148_codigo!=null){
       $sql .= " q148_codigo = $this->q148_codigo";
     }
     $resaco = $this->sql_record($this->sql_query_file($this->q148_codigo));
     if($this->numrows>0){
       for($conresaco=0;$conresaco<$this->numrows;$conresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")") or die(pg_last_error());
         $resac = db_query("insert into db_acountkey values($acount,(select codcam from db_syscampo where nomecam = 'q148_inscr'),'$this->q148_codigo','A')") or die(pg_last_error());
         if(isset($GLOBALS["HTTP_POST_VARS"]["q148_codigo"]))
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_codigo'),'".AddSlashes(pg_result($resaco,$conresaco,'q148_codigo'))."','$this->q148_codigo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")") or die(pg_last_error());
         if(isset($GLOBALS["HTTP_POST_VARS"]["q148_inscr"]))
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_inscr'),'".AddSlashes(pg_result($resaco,$conresaco,'q148_inscr'))."','$this->q148_inscr',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")") or die(pg_last_error());
         if(isset($GLOBALS["HTTP_POST_VARS"]["q148_tipo"]))
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_tipo'),'".AddSlashes(pg_result($resaco,$conresaco,'q148_tipo'))."','$this->q148_tipo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")") or die(pg_last_error());
         if(isset($GLOBALS["HTTP_POST_VARS"]["q148_dtini"]))
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_dtini'),'".AddSlashes(pg_result($resaco,$conresaco,'q148_dtini'))."','$this->q148_dtini',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")") or die(pg_last_error());
         if(isset($GLOBALS["HTTP_POST_VARS"]["q148_dtfim"]))
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_dtfim'),'".AddSlashes(pg_result($resaco,$conresaco,'q148_dtfim'))."','$this->q148_dtfim',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")") or die(pg_last_error());
         if(isset($GLOBALS["HTTP_POST_VARS"]["q148_perc"]))
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_perc'),'".AddSlashes(pg_result($resaco,$conresaco,'q148_perc'))."','$this->q148_perc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")") or die(pg_last_error());
         if(isset($GLOBALS["HTTP_POST_VARS"]["q148_dtinc"]))
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_dtinc'),'".AddSlashes(pg_result($resaco,$conresaco,'q148_dtinc'))."','$this->q148_dtinc',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")") or die(pg_last_error());
         if(isset($GLOBALS["HTTP_POST_VARS"]["q148_idusu"]))
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_idusu'),'".AddSlashes(pg_result($resaco,$conresaco,'q148_idusu'))."','$this->q148_idusu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")") or die(pg_last_error());
         if(isset($GLOBALS["HTTP_POST_VARS"]["q148_hist"]))
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_hist'),'".AddSlashes(pg_result($resaco,$conresaco,'q148_hist'))."','$this->q148_hist',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")") or die(pg_last_error());
         if(isset($GLOBALS["HTTP_POST_VARS"]["q148_receit"]))
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_receit'),'".AddSlashes(pg_result($resaco,$conresaco,'q148_receit'))."','$this->q148_receit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")") or die(pg_last_error());
       }
     }
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->q148_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->q148_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->q148_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }
   // funcao para exclusao
   function excluir ($q148_codigo=null,$dbwhere=null) {
     if($dbwhere==null || $dbwhere==""){
       $resaco = $this->sql_record($this->sql_query_file($q148_codigo));
     }else{
       $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
     }
     if(($resaco!=false)||($this->numrows!=0)){
       for($iresaco=0;$iresaco<$this->numrows;$iresaco++){
         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,(select codcam from db_syscampo where nomecam = 'q148_inscr'),'$q148_codigo','E')");
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_codigo'),'','".AddSlashes(pg_result($resaco,0,'q148_codigo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_inscr'),'','".AddSlashes(pg_result($resaco,0,'q148_inscr'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_tipo'),'','".AddSlashes(pg_result($resaco,0,'q148_tipo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_dtini'),'','".AddSlashes(pg_result($resaco,0,'q148_dtini'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_dtfim'),'','".AddSlashes(pg_result($resaco,0,'q148_dtfim'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_perc'),'','".AddSlashes(pg_result($resaco,0,'q148_perc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_dtinc'),'','".AddSlashes(pg_result($resaco,0,'q148_dtinc'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_idusu'),'','".AddSlashes(pg_result($resaco,0,'q148_idusu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_hist'),'','".AddSlashes(pg_result($resaco,0,'q148_hist'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac = db_query("insert into db_acount values($acount,(select codarq from db_sysarquivo where nomearq = 'issisen'),(select codcam from db_syscampo where nomecam = 'q148_receit'),'','".AddSlashes(pg_result($resaco,0,'q148_receit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     $sql = " delete from issisen
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($q148_codigo != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " q148_codigo = $q148_codigo ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$q148_codigo;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$q148_codigo;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$q148_codigo;
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
        $this->erro_sql   = "Record Vazio na Tabela:issisen";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   function sql_query ( $q148_codigo=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from issisen ";
     $sql .= "      inner join issbase  on  issbase.q02_inscr = issisen.q148_inscr";
     $sql .= "      inner join isstipoisen  on  isstipoisen.q147_tipo = issisen.q148_tipo";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = issbase.q02_numcgm";
     $sql .= "      inner join tabrec  on  tabrec.k02_codigo = issisen.q148_receit";
     $sql2 = "";
     if($dbwhere==""){
       if($q148_codigo!=null ){
         $sql2 .= " where issisen.q148_codigo = $q148_codigo ";
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
   function sql_query_file ( $q148_codigo=null,$campos="*",$ordem=null,$dbwhere=""){
     $sql = "select {$campos} from issisen";
     $sql2 = "";
     if($dbwhere==""){
       if($q148_codigo!=null ){
         $sql2 .= " where issisen.q148_codigo = $q148_codigo ";
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
   function sql_query_isen ( $q148_codigo=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from issisen ";
     $sql .= "      inner join tipoisen           on j45_tipo                = q148_tipo ";
     $sql2 = "";
     if($dbwhere==""){
       if($q148_codigo!=null ){
         $sql2 .= " where issisen.q148_codigo = $q148_codigo ";
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

  public function sql_queryIsencao($date, $iInscricao) {

    $sSql  = "select q148_tipo, q148_descr                      ";
    $sSql .= "  from issisen                                 ";
    $sSql .= " inner join isstipoisen on q148_tipo   = q147_tipo   ";
    $sSql .= " where q148_inscr = {$iInscricao}               ";
    $sSql .= "  and {$date} between q148_dtini and q148_dtfim ";

    return $sSql;

  }
}
