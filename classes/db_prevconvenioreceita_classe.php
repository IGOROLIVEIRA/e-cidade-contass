<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

//MODULO: contabilidade
//CLASSE DA ENTIDADE prevconvenioreceita
class cl_prevconvenioreceita {
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
    var $c229_fonte         = 0;
    var $c229_convenio      = 0;
    var $c229_vlprevisto    = 0;
    var $c229_anousu        = 0;
    // cria propriedade com as variaveis do arquivo
    var $campos = "
                 c229_fonte         = int4      = Receita
                 c229_convenio      = int4      = Convênio 
                 c229_vlprevisto    = float8    = Valor Previsto 
                 c229_anousu        = int4      = Ano 
                 ";
    //funcao construtor da classe
    function cl_prevconvenioreceita() {
        //classes dos rotulos dos campos
        $this->rotulo = new rotulo("prevconvenioreceita");
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
            $this->c229_fonte = ($this->c229_fonte == ""?@$GLOBALS["HTTP_POST_VARS"]["c229_fonte"]:$this->c229_fonte);
            $this->c229_convenio = ($this->c229_convenio == ""?@$GLOBALS["HTTP_POST_VARS"]["c229_convenio"]:$this->c229_convenio);
            $this->c229_vlprevisto = ($this->c229_vlprevisto == ""?@$GLOBALS["HTTP_POST_VARS"]["c229_vlprevisto"]:$this->c229_vlprevisto);
            $this->c229_anousu = ($this->c229_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c229_anousu"]:$this->c229_anousu);
        }else{
            $this->c229_fonte = ($this->c229_fonte == ""?@$GLOBALS["HTTP_POST_VARS"]["c229_fonte"]:$this->c229_fonte);
            $this->c229_convenio = ($this->c229_convenio == ""?@$GLOBALS["HTTP_POST_VARS"]["c229_convenio"]:$this->c229_convenio);
            $this->c229_vlprevisto = ($this->c229_vlprevisto == ""?@$GLOBALS["HTTP_POST_VARS"]["c229_vlprevisto"]:$this->c229_vlprevisto);
            $this->c229_anousu = ($this->c229_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c229_anousu"]:$this->c229_anousu);
        }
    }
    // funcao para inclusao
    function incluir (){
        $this->atualizacampos();
        if($this->c229_fonte == null ){
            $this->erro_sql = " Campo Receita nao Informado.";
            $this->erro_campo = "c229_fonte";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->c229_convenio == null ){
            $this->erro_sql = " Campo Convênio nao Informado.";
            $this->erro_campo = "c229_convenio";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        if($this->c229_vlprevisto == null ){
            $this->erro_sql = " Campo Valor Previsto nao Informado.";
            $this->erro_campo = "c229_vlprevisto";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }

        $sql = "insert into prevconvenioreceita(
                                       c229_fonte 
                                      ,c229_convenio 
                                      ,c229_vlprevisto 
                                      ,c229_anousu 
                       )
                values (
                                $this->c229_fonte 
                               ,$this->c229_convenio 
                               ,$this->c229_vlprevisto 
                               ,$this->c229_anousu 
                      )";
        $result = db_query($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
                $this->erro_sql   = "Tabela com convenios ($this->c229_fonte, $this->c229_convenio, $this->c229_anousu) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_banco = "Tabela com convenios já Cadastrado";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }else{
                $this->erro_sql   = "Tabela com convenios ($this->c229_fonte, $this->c229_convenio, $this->c229_anousu) nao Incluído. Inclusao Abortada.";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            }
            $this->erro_status = "0";
            $this->numrows_incluir= 0;
            return false;
        }
        $this->erro_banco = "";
        $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : $this->c229_fonte, $this->c229_convenio, $this->c229_anousu";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_incluir= pg_affected_rows($result);
        return true;
    }
    // funcao para alteracao
    function alterar ($c229_fonte=null, $c229_convenio=null, $c229_anousu=null) {
        $this->atualizacampos();
        $sql = " update prevconvenioreceita set ";
        $virgula = "";
        if(trim($this->c229_fonte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c229_fonte"])){
            $sql  .= $virgula." c229_fonte = $this->c229_fonte ";
            $virgula = ",";
            if(trim($this->c229_fonte) == null ){
                $this->erro_sql = " Campo Receita nao Informado.";
                $this->erro_campo = "c229_fonte";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->c229_convenio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c229_convenio"])){
            $sql  .= $virgula." c229_convenio = $this->c229_convenio ";
            $virgula = ",";
            if(trim($this->c229_convenio) == null ){
                $this->erro_sql = " Campo Convenio nao Informado.";
                $this->erro_campo = "c229_convenio";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }
        if(trim($this->c229_vlprevisto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c229_vlprevisto"])){
            $sql  .= $virgula." c229_vlprevisto = $this->c229_vlprevisto ";
            $virgula = ",";
            if(trim($this->c229_vlprevisto) == null ){
                $this->erro_sql = " Campo Valor Previsto nao Informado.";
                $this->erro_campo = "c229_vlprevisto";
                $this->erro_banco = "";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "0";
                return false;
            }
        }

        $sql .= " where ";
        if($c229_convenio!=null){
            $sql .= " c229_convenio = $c229_convenio";
        }
        if($c229_fonte!=null){
            $sql .= " and c229_fonte = $c229_fonte";
        }
        if($c229_anousu!=null){
            $sql .= " and c229_anousu = $c229_anousu";
        }

        $result = db_query($sql);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Tabela previsao convenio receita nao Alterado. Alteracao Abortada.\\n";
            $this->erro_sql .= "Valores : ($this->c229_fonte, $this->c229_convenio)";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_alterar = 0;
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "Tabela previsao convenio receita nao foi Alterado. Alteracao Executada.\\n";
                $this->erro_sql .= "Valores : ($this->c229_fonte, $this->c229_convenio)";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = 0;
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Alteração efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ($this->c229_fonte, $this->c229_convenio)";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_alterar = pg_affected_rows($result);
                return true;
            }
        }
    }
    // funcao para exclusao
    function excluir ($c229_convenio=null, $c229_fonte=null,$c229_anousu=null,$dbwhere=null) {
        if($dbwhere==null || $dbwhere==""){
            $resaco = $this->sql_record($this->sql_query_file($c229_convenio, $c229_fonte));
        }else{
            $resaco = $this->sql_record($this->sql_query_file($c229_convenio, $c229_fonte, null,"*",null,$dbwhere));
        }

        $sql = " delete from prevconvenioreceita
                    where ";
        $sql2 = "";
        if($dbwhere==null || $dbwhere ==""){
            if($c229_convenio != ""){
                if($sql2!=""){
                    $sql2 .= " and ";
                }
                $sql2 .= " c229_convenio = $c229_convenio ";
            }
            if($c229_fonte != ""){
                if($sql2!=""){
                    $sql2 .= " and ";
                }
                $sql2 .= " c229_fonte = $c229_fonte ";
            }
            if($c229_anousu != ""){
                if($sql2!=""){
                    $sql2 .= " and ";
                }
                $sql2 .= " c229_anousu = $c229_anousu ";
            }
        }else{
            $sql2 = $dbwhere;
        }
        $result = db_query($sql.$sql2);
        if($result==false){
            $this->erro_banco = str_replace("\n","",@pg_last_error());
            $this->erro_sql   = "Tabela com convenio nao Excluído. Exclusão Abortada.\\n";
            $this->erro_sql .= "Valores : ($this->c229_convenio, $this->c229_fonte)";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            $this->numrows_excluir = 0;
            return false;
        }else{
            if(pg_affected_rows($result)==0){
                $this->erro_banco = "";
                $this->erro_sql = "Tabela com convenio nao Encontrado. Exclusão não Efetuada.\\n";
                $this->erro_sql .= "Valores : ($this->c229_convenio, $this->c229_fonte)";
                $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
                $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
                $this->erro_status = "1";
                $this->numrows_excluir = 0;
                return true;
            }else{
                $this->erro_banco = "";
                $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
                $this->erro_sql .= "Valores : ($this->c229_convenio, $this->c229_fonte)";
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
            $this->erro_sql   = "Record Vazio na Tabela:prevconvenioreceita";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
        return $result;
    }
    function sql_query ( $c229_fonte=null, $c229_convenio=null,$campos="*",$ordem=null,$dbwhere=""){
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
        $sql .= " from prevconvenioreceita ";
        $sql .= "   left join convconvenios on c229_convenio = c206_sequencial ";
        $sql2 = "";
        if($dbwhere==""){
            if($c229_fonte!=null ){
                $sql2 .= " where prevconvenioreceita.c229_fonte = $c229_fonte ";
            }
            if($c229_convenio!=null ){
                $sql2 .= " and prevconvenioreceita.c229_convenio = $c229_convenio ";
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
    function sql_query_file ( $c229_convenio=null, $c229_fonte=null,$campos="*",$ordem=null,$dbwhere=""){
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
        $sql .= " from prevconvenioreceita ";
        $sql2 = "";
        if($dbwhere==""){
            if($c229_convenio!=null ){
                $sql2 .= " where prevconvenioreceita.c229_convenio = $c229_convenio ";
            }
            if($c229_fonte!=null ){
                $sql2 .= " and prevconvenioreceita.c229_fonte = $c229_fonte ";
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