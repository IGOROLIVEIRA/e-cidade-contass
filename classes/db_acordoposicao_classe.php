<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

//MODULO: acordos
//CLASSE DA ENTIDADE acordoposicao
class cl_acordoposicao {
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
   var $ac26_sequencial = 0;
   var $ac26_acordo = 0;
   var $ac26_acordoposicaotipo = 0;
   var $ac26_numero = 0;
   var $ac26_situacao = 0;
   var $ac26_data_dia = null;
   var $ac26_data_mes = null;
   var $ac26_data_ano = null;
   var $ac26_data = null;
   var $ac26_emergencial = 'f';
   var $ac26_observacao = null;
   var $ac26_numeroaditamento = null;
   var $ac26_numeroapostilamento = null;
   var $ac26_vigenciaalterada = null;//OC5304
   var $ac26_percentualreajuste = 0;//LeiauteAM2023
   var $ac26_indicereajuste = null;//LeiauteAM2023
   var $ac26_descricaoindice = null;//LeiauteAM2023
   var $ac26_descricaoreajuste = null;
   var $ac26_criterioreajuste = null;
   // cria propriedade com as variaveis do arquivo
   var $campos = "
                 ac26_sequencial = int4 = Código Sequencial
                 ac26_acordo = int4 = Acordo
                 ac26_acordoposicaotipo = int4 = Tipo da Posição
                 ac26_numero = int4 = Número da Posição
                 ac26_situacao = int4 = Situacao
                 ac26_data = date = Data
                 ac26_emergencial = bool = Posição Emergencial
                 ac26_observacao = text = Observação
                 ac26_numeroaditamento = varchar(20) = Número do aditamento
                 ac26_percentualreajuste = varchar(20) = Número do aditamento
                 ac26_descricaoindice = varchar(20) = Número do aditamento
                 ac26_numeroapostilamento = varchar(20) = Número do apostilamento
                 ac26_vigenciaalterada = varchar(1) = Caso vigência alterada
                 ac26_vigenciaalterada = varchar(1) = Caso vigência alterada
                 ac26_descricaoreajuste = varchar(300) = Descrição do critéiro de reajuste
                 ac26_criterioreajuste = int4 = Critério de Reajuste
                 ";
   //funcao construtor da classe
   function cl_acordoposicao() {
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("acordoposicao");
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
       $this->ac26_sequencial = ($this->ac26_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_sequencial"]:$this->ac26_sequencial);
       $this->ac26_acordo = ($this->ac26_acordo == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_acordo"]:$this->ac26_acordo);
       $this->ac26_acordoposicaotipo = ($this->ac26_acordoposicaotipo == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_acordoposicaotipo"]:$this->ac26_acordoposicaotipo);
       $this->ac26_numero = ($this->ac26_numero == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_numero"]:$this->ac26_numero);
       $this->ac26_situacao = ($this->ac26_situacao == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_situacao"]:$this->ac26_situacao);
       if($this->ac26_data == ""){
         $this->ac26_data_dia = ($this->ac26_data_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_data_dia"]:$this->ac26_data_dia);
         $this->ac26_data_mes = ($this->ac26_data_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_data_mes"]:$this->ac26_data_mes);
         $this->ac26_data_ano = ($this->ac26_data_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_data_ano"]:$this->ac26_data_ano);
         if($this->ac26_data_dia != ""){
            $this->ac26_data = $this->ac26_data_ano."-".$this->ac26_data_mes."-".$this->ac26_data_dia;
         }
       }
       $this->ac26_emergencial = ($this->ac26_emergencial == "f"?@$GLOBALS["HTTP_POST_VARS"]["ac26_emergencial"]:$this->ac26_emergencial);
       $this->ac26_observacao = ($this->ac26_observacao == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_observacao"]:$this->ac26_observacao);
       $this->ac26_numeroaditamento = ($this->ac26_numeroaditamento == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_numeroaditamento"]:$this->ac26_numeroaditamento);
       $this->ac26_percentualreajuste = ($this->ac26_percentualreajuste == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_percentualreajuste"]:$this->ac26_percentualreajuste);
       $this->ac26_indicereajuste = ($this->ac26_indicereajuste == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_indicereajuste"]:$this->ac26_indicereajuste);
       $this->ac26_descricaoindice = ($this->ac26_descricaoindice == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_descricaoindice"]:$this->ac26_descricaoindice);
       $this->ac26_descricaoreajuste = ($this->ac26_descricaoreajuste == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_descricaoreajuste"]:$this->ac26_descricaoreajuste);
       $this->ac26_criterioreajuste = ($this->ac26_criterioreajuste == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_criterioreajuste"]:$this->ac26_criterioreajuste);
       $this->ac26_numeroapostilamento = ($this->ac26_numeroapostilamento == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_numeroapostilamento"]:$this->ac26_numeroapostilamento);
     }else{
       $this->ac26_sequencial = ($this->ac26_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["ac26_sequencial"]:$this->ac26_sequencial);
     }
   }
   // funcao para inclusao
   function incluir ($ac26_sequencial){
      $this->atualizacampos();
     if($this->ac26_acordo == null ){
       $this->erro_sql = " Campo Acordo não informado.";
       $this->erro_campo = "ac26_acordo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ac26_acordoposicaotipo == null ){
       $this->erro_sql = " Campo Tipo da Posição não informado.";
       $this->erro_campo = "ac26_acordoposicaotipo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ac26_numero == null ){
       $this->erro_sql = " Campo Número da Posição não informado.";
       $this->erro_campo = "ac26_numero";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ac26_situacao == null ){
       $this->erro_sql = " Campo Situacao não informado.";
       $this->erro_campo = "ac26_situacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ac26_data == null ){
       $this->erro_sql = " Campo Data não informado.";
       $this->erro_campo = "ac26_data_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->ac26_emergencial == null ){
       $this->ac26_emergencial = "false";
     }
     if($ac26_sequencial == "" || $ac26_sequencial == null ){
       $result = db_query("select nextval('acordoposicao_ac26_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: acordoposicao_ac26_sequencial_seq do campo: ac26_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->ac26_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from acordoposicao_ac26_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $ac26_sequencial)){
         $this->erro_sql = " Campo ac26_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->ac26_sequencial = $ac26_sequencial;
       }
     }
     if(($this->ac26_sequencial == null) || ($this->ac26_sequencial == "") ){
       $this->erro_sql = " Campo ac26_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into acordoposicao(
                                       ac26_sequencial
                                      ,ac26_acordo
                                      ,ac26_acordoposicaotipo
                                      ,ac26_numero
                                      ,ac26_situacao
                                      ,ac26_data
                                      ,ac26_emergencial
                                      ,ac26_observacao
                                      ,ac26_numeroaditamento
                                      ,ac26_numeroapostilamento
                                      ,ac26_vigenciaalterada
                                      ,ac26_indicereajuste
                                      ,ac26_percentualreajuste
                                      ,ac26_descricaoindice
                                      ,ac26_descricaoreajuste
                                      ,ac26_criterioreajuste
                       )
                values (
                                $this->ac26_sequencial
                               ,$this->ac26_acordo
                               ,$this->ac26_acordoposicaotipo
                               ,$this->ac26_numero
                               ,$this->ac26_situacao
                               ,".($this->ac26_data == "null" || $this->ac26_data == ""?"null":"'".$this->ac26_data."'")."
                               ,'$this->ac26_emergencial'
                               ,'$this->ac26_observacao'
                               ,'$this->ac26_numeroaditamento'
                               ,'$this->ac26_numeroapostilamento'
                               ,'$this->ac26_vigenciaalterada'
                               ," . ($this->ac26_indicereajuste == "null" || $this->ac26_indicereajuste == "" ? '0' :  $this->ac26_indicereajuste )."
                               ," . ($this->ac26_percentualreajuste == "null" || $this->ac26_percentualreajuste == "" ? 'null' : "'" . $this->ac26_percentualreajuste . "'") . "
                               ," . ($this->ac26_descricaoindice == "null" || $this->ac26_descricaoindice == "" ? 'null' : "'" . $this->ac26_descricaoindice . "'") . "
                               ," . ($this->ac26_descricaoreajuste == "null" || $this->ac26_descricaoreajuste == "" ? 'null' : "'" . $this->ac26_descricaoreajuste . "'") . "
                               ," . ($this->ac26_criterioreajuste == "null" || $this->ac26_criterioreajuste == "" ? '0' :  $this->ac26_criterioreajuste )."
                      )";

     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "posicoes do acordo ($this->ac26_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "posicoes do acordo já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "posicoes do acordo ($this->ac26_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->ac26_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->ac26_sequencial  ));
       if(($resaco!=false)||($this->numrows!=0)){

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,16665,'$this->ac26_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,2930,16665,'','".AddSlashes(pg_result($resaco,0,'ac26_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2930,16666,'','".AddSlashes(pg_result($resaco,0,'ac26_acordo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2930,16668,'','".AddSlashes(pg_result($resaco,0,'ac26_acordoposicaotipo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2930,16667,'','".AddSlashes(pg_result($resaco,0,'ac26_numero'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2930,16669,'','".AddSlashes(pg_result($resaco,0,'ac26_situacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2930,16730,'','".AddSlashes(pg_result($resaco,0,'ac26_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2930,16731,'','".AddSlashes(pg_result($resaco,0,'ac26_emergencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2930,18486,'','".AddSlashes(pg_result($resaco,0,'ac26_observacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,2930,20232,'','".AddSlashes(pg_result($resaco,0,'ac26_numeroaditamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
     }
     return true;
   }
   // funcao para alteracao
   function alterar ($ac26_sequencial=null) {
      $this->atualizacampos();
     $sql = " update acordoposicao set ";
     $virgula = "";
     if(trim($this->ac26_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac26_sequencial"])){
       $sql  .= $virgula." ac26_sequencial = $this->ac26_sequencial ";
       $virgula = ",";
       if(trim($this->ac26_sequencial) == null ){
         $this->erro_sql = " Campo Código Sequencial não informado.";
         $this->erro_campo = "ac26_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ac26_acordo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac26_acordo"])){
       $sql  .= $virgula." ac26_acordo = $this->ac26_acordo ";
       $virgula = ",";
       if(trim($this->ac26_acordo) == null ){
         $this->erro_sql = " Campo Acordo não informado.";
         $this->erro_campo = "ac26_acordo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ac26_acordoposicaotipo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac26_acordoposicaotipo"])){
       $sql  .= $virgula." ac26_acordoposicaotipo = $this->ac26_acordoposicaotipo ";
       $virgula = ",";
       if(trim($this->ac26_acordoposicaotipo) == null ){
         $this->erro_sql = " Campo Tipo da Posição não informado.";
         $this->erro_campo = "ac26_acordoposicaotipo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ac26_numero)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac26_numero"])){
       $sql  .= $virgula." ac26_numero = $this->ac26_numero ";
       $virgula = ",";
       if(trim($this->ac26_numero) == null ){
         $this->erro_sql = " Campo Número da Posição não informado.";
         $this->erro_campo = "ac26_numero";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ac26_situacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac26_situacao"])){
       $sql  .= $virgula." ac26_situacao = $this->ac26_situacao ";
       $virgula = ",";
       if(trim($this->ac26_situacao) == null ){
         $this->erro_sql = " Campo Situacao não informado.";
         $this->erro_campo = "ac26_situacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(trim($this->ac26_data)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac26_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["ac26_data_dia"] !="") ){
       $sql  .= $virgula." ac26_data = '$this->ac26_data' ";
       $virgula = ",";
       if(trim($this->ac26_data) == null ){
         $this->erro_sql = " Campo Data não informado.";
         $this->erro_campo = "ac26_data_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if(isset($GLOBALS["HTTP_POST_VARS"]["ac26_data_dia"])){
         $sql  .= $virgula." ac26_data = null ";
         $virgula = ",";
         if(trim($this->ac26_data) == null ){
           $this->erro_sql = " Campo Data não informado.";
           $this->erro_campo = "ac26_data_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if(trim($this->ac26_emergencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac26_emergencial"])){
       $sql  .= $virgula." ac26_emergencial = '$this->ac26_emergencial' ";
       $virgula = ",";
     }
     if(trim($this->ac26_observacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac26_observacao"])){
       $sql  .= $virgula." ac26_observacao = '$this->ac26_observacao' ";
       $virgula = ",";
     }
     if(trim($this->ac26_numeroaditamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac26_numeroaditamento"])){
       $sql  .= $virgula." ac26_numeroaditamento = '$this->ac26_numeroaditamento' ";
       $virgula = ",";
     }
     if(trim($this->ac26_numeroapostilamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ac26_numeroapostilamento"])){
       $sql  .= $virgula." ac26_numeroapostilamento = '$this->ac26_numeroapostilamento' ";
       $virgula = ",";
     }
     $sql .= " where ";
     if($ac26_sequencial!=null){
       $sql .= " ac26_sequencial = $this->ac26_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->ac26_sequencial));
       if($this->numrows>0){

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,16665,'$this->ac26_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ac26_sequencial"]) || $this->ac26_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,2930,16665,'".AddSlashes(pg_result($resaco,$conresaco,'ac26_sequencial'))."','$this->ac26_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ac26_acordo"]) || $this->ac26_acordo != "")
             $resac = db_query("insert into db_acount values($acount,2930,16666,'".AddSlashes(pg_result($resaco,$conresaco,'ac26_acordo'))."','$this->ac26_acordo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ac26_acordoposicaotipo"]) || $this->ac26_acordoposicaotipo != "")
             $resac = db_query("insert into db_acount values($acount,2930,16668,'".AddSlashes(pg_result($resaco,$conresaco,'ac26_acordoposicaotipo'))."','$this->ac26_acordoposicaotipo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ac26_numero"]) || $this->ac26_numero != "")
             $resac = db_query("insert into db_acount values($acount,2930,16667,'".AddSlashes(pg_result($resaco,$conresaco,'ac26_numero'))."','$this->ac26_numero',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ac26_situacao"]) || $this->ac26_situacao != "")
             $resac = db_query("insert into db_acount values($acount,2930,16669,'".AddSlashes(pg_result($resaco,$conresaco,'ac26_situacao'))."','$this->ac26_situacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ac26_data"]) || $this->ac26_data != "")
             $resac = db_query("insert into db_acount values($acount,2930,16730,'".AddSlashes(pg_result($resaco,$conresaco,'ac26_data'))."','$this->ac26_data',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ac26_emergencial"]) || $this->ac26_emergencial != "")
             $resac = db_query("insert into db_acount values($acount,2930,16731,'".AddSlashes(pg_result($resaco,$conresaco,'ac26_emergencial'))."','$this->ac26_emergencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ac26_observacao"]) || $this->ac26_observacao != "")
             $resac = db_query("insert into db_acount values($acount,2930,18486,'".AddSlashes(pg_result($resaco,$conresaco,'ac26_observacao'))."','$this->ac26_observacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["ac26_numeroaditamento"]) || $this->ac26_numeroaditamento != "")
             $resac = db_query("insert into db_acount values($acount,2930,20232,'".AddSlashes(pg_result($resaco,$conresaco,'ac26_numeroaditamento'))."','$this->ac26_numeroaditamento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "posicoes do acordo nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->ac26_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "posicoes do acordo nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->ac26_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->ac26_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
   }

   function alterar_numaditamento ($ac26_sequencial){
    $sql = "update acordoposicao set ac26_numeroaditamento = '$this->ac26_numeroaditamento' where ac26_sequencial = $ac26_sequencial";
    $result = db_query($sql);
   }

   // funcao para exclusao
   function excluir ($ac26_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($ac26_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,16665,'$ac26_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,2930,16665,'','".AddSlashes(pg_result($resaco,$iresaco,'ac26_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2930,16666,'','".AddSlashes(pg_result($resaco,$iresaco,'ac26_acordo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2930,16668,'','".AddSlashes(pg_result($resaco,$iresaco,'ac26_acordoposicaotipo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2930,16667,'','".AddSlashes(pg_result($resaco,$iresaco,'ac26_numero'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2930,16669,'','".AddSlashes(pg_result($resaco,$iresaco,'ac26_situacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2930,16730,'','".AddSlashes(pg_result($resaco,$iresaco,'ac26_data'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2930,16731,'','".AddSlashes(pg_result($resaco,$iresaco,'ac26_emergencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2930,18486,'','".AddSlashes(pg_result($resaco,$iresaco,'ac26_observacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,2930,20232,'','".AddSlashes(pg_result($resaco,$iresaco,'ac26_numeroaditamento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from acordoposicao
                    where ";
     $sql2 = "";
     if($dbwhere==null || $dbwhere ==""){
        if($ac26_sequencial != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " ac26_sequencial = $ac26_sequencial ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "posicoes do acordo nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$ac26_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "posicoes do acordo nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$ac26_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$ac26_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:acordoposicao";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql
   function sql_query ( $ac26_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from acordoposicao ";
     $sql .= "      inner join acordo  on  acordo.ac16_sequencial = acordoposicao.ac26_acordo";
     $sql .= "      inner join acordoposicaotipo  on  acordoposicaotipo.ac27_sequencial = acordoposicao.ac26_acordoposicaotipo";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = acordo.ac16_contratado";
     $sql .= "      inner join db_depart  on  db_depart.coddepto = acordo.ac16_coddepto and  db_depart.coddepto = acordo.ac16_deptoresponsavel";
     $sql .= "      inner join acordogrupo  on  acordogrupo.ac02_sequencial = acordo.ac16_acordogrupo";
     $sql .= "      inner join acordosituacao  on  acordosituacao.ac17_sequencial = acordo.ac16_acordosituacao";
     $sql .= "      inner join acordocomissao  on  acordocomissao.ac08_sequencial = acordo.ac16_acordocomissao";
     $sql .= "      left  join acordocategoria  on  acordocategoria.ac50_sequencial = acordo.ac16_acordocategoria";
     $sql2 = "";
     if($dbwhere==""){
       if($ac26_sequencial!=null ){
         $sql2 .= " where acordoposicao.ac26_sequencial = $ac26_sequencial ";
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
   function sql_query_file ( $ac26_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
     $sql .= " from acordoposicao ";
     $sql2 = "";
     if($dbwhere==""){
       if($ac26_sequencial!=null ){
         $sql2 .= " where acordoposicao.ac26_sequencial = $ac26_sequencial ";
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
   function sql_query_vigencia ( $ac26_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {

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
     $sql .= " from acordoposicao ";
     $sql .= "      inner join acordo  on  acordo.ac16_sequencial = acordoposicao.ac26_acordo";
     $sql .= "      inner join acordoposicaotipo  on  acordoposicaotipo.ac27_sequencial = acordoposicao.ac26_acordoposicaotipo";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = acordo.ac16_contratado";
     $sql .= "      inner join db_depart  on  db_depart.coddepto = acordo.ac16_coddepto";
     $sql .= "      inner join acordogrupo  on  acordogrupo.ac02_sequencial = acordo.ac16_acordogrupo";
     $sql .= "      inner join acordosituacao  on  acordosituacao.ac17_sequencial = acordo.ac16_acordosituacao";
     $sql .= "      left join acordocomissao  on  acordocomissao.ac08_sequencial = acordo.ac16_acordocomissao";
     $sql .= "      left  join acordovigencia  on  ac26_sequencial                = ac18_acordoposicao";
     $sql .= "      left  join acordoposicaoaditamento  on  ac26_sequencial       = ac35_acordoposicao";
     $sql .= "      left join apostilamento ON si03_acordoposicao                 = ac26_sequencial";
     $sql2 = "";
     if($dbwhere==""){
       if($ac26_sequencial!=null ){
         $sql2 .= " where acordoposicao.ac26_sequencial = $ac26_sequencial ";
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
    * Metodo para buscar periodos com execucao
    */
   public function sql_query_periodo_execucao ( $ac26_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){

     $sql  = "select $campos ";
     $sql .= " from acordoposicao ";
     $sql .= "      inner join acordoitem             on acordoitem.ac20_acordoposicao = acordoposicao.ac26_sequencial ";
     $sql .= "      inner join acordoitemprevisao aip on aip.ac37_acordoitem           = acordoitem.ac20_sequencial ";

     $sql2 = "";

     if($dbwhere==""){

       if($ac26_sequencial!=null ){
         $sql2 .= " where acordoposicao.ac26_sequencial = $ac26_sequencial ";
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
   * Retorna os dados dos aditamentos para o portal da transparencia
   *
   * @param  string $sCampos
   * @param  string $sOrdem
   * @param  string $sWhere
   * @return string
   */
  public function sql_query_transparencia($sCampos = "*", $sOrdem = null, $sWhere = "") {

    $sSql  = "select {$sCampos} \n";
    $sSql .= "  from acordoposicao                                                           \n";
    $sSql .= "       inner join acordo on ac16_sequencial = ac26_acordo                      \n";
    $sSql .= "       left join acordoposicaotipo on ac27_sequencial = ac26_acordoposicaotipo \n";
    $sSql .= "       left join acordosituacao on ac17_sequencial = ac26_situacao             \n";

    if (!empty($sWhere)) {
      $sSql .= " where {$sWhere} \n";
    }

    if (!empty($sOrdem)) {
      $sSql .= " order by {$sOrdem} ";
    }

    return $sSql;
  }

  /**
   * retorna periodos que foram reativados
   * @param string $ac26_sequencial
   * @param string $campos
   * @param string $ordem
   * @param string $dbwhere
   * @return string
   */
  function sql_queryReativados ( $ac26_sequencial=null,$campos="*",$ordem=null,$dbwhere=""){
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
    $sql .= " from acordoposicao ";
    $sql .= "        inner join acordoposicaoperiodo     on acordoposicao.ac26_sequencial         = acordoposicaoperiodo.ac36_acordoposicao";
    $sql .= "        inner join acordoparalisacaoperiodo on acordoposicaoperiodo.ac36_sequencial  = acordoparalisacaoperiodo.ac49_acordoposicaoperiodo";

    $sql2 = "";

    if($dbwhere==""){
      if($ac26_sequencial!=null ){
        $sql2 .= " where acordoposicao.ac26_sequencial = $ac26_sequencial ";
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
  public function sql_valor_total_aditado ($sCampos = "*", $sOrdem = null, $sWhere = ""){
      $sSql  = "select {$sCampos} \n";
      $sSql .= "  from acordoposicao                                                    \n";
      $sSql .= "       inner join acordoitem on ac20_acordoposicao = ac26_sequencial    \n";
      $sSql .= "       inner join acordo on ac16_sequencial = ac26_acordo               \n";
      if (!empty($sWhere)) {
          $sSql .= " where {$sWhere} \n";
      }
      if (!empty($sOrdem)) {
          $sSql .= " order by {$sOrdem} ";
      }
      return $sSql;
  }

  public function getEmpenhosDeUmaPosicao($iCodPosicao,$sDataInicial,$sDataFinal)
  {
    $sSqlDataDeEmissao = '';
    if( empty($sDataInicial) && !empty($sDataFinal) ){
      $sSqlDataDeEmissao = " AND e60_emiss <= '".date("Y-m-d", strtotime(str_replace('/','-',$sDataFinal)))."'";
    }
    if( !empty($sDataInicial) && empty($sDataFinal) ){
      $sSqlDataDeEmissao = " AND e60_emiss >= '".date("Y-m-d", strtotime(str_replace('/','-',$sDataInicial)))."'";
    }
    if( !empty($sDataInicial) && !empty($sDataFinal) ){
      $sSqlDataDeEmissao = " AND (e60_emiss BETWEEN '".date("Y-m-d", strtotime(str_replace('/','-',$sDataInicial)))."'";
      $sSqlDataDeEmissao .= "                   AND '".date("Y-m-d", strtotime(str_replace('/','-',$sDataFinal)))."') ";
    }

    $sSql = "   SELECT  DISTINCT(e61_numemp), e60_emiss, e60_codemp, e60_anousu
                  FROM  empempaut
            INNER JOIN  empempenho
                    ON  e60_numemp = e61_numemp
                 WHERE  e61_autori
                    IN  (SELECT  ac19_autori
                           FROM  acordoitemexecutadoempautitem
                          WHERE  ac19_acordoitemexecutado
                             IN  (SELECT  ac29_sequencial
                                    FROM  acordoitemexecutado
                                   WHERE  ac29_acordoitem
                                      IN  (SELECT  ac20_sequencial
                                             FROM  acordoitem
                                            WHERE  ac20_acordoposicao
                                               IN  ( $iCodPosicao ))))
    $sSqlDataDeEmissao
              ORDER BY  e60_codemp;";

    return $sSql;

  }

  public function sql_query_empenhoautori_acordo($ac16_sequencial){
        $sSql  = "select e54_autori,
        e60_numemp";
        $sSql .= "  from acordoposicao";
        $sSql .= " inner join acordoitem on
        ac20_acordoposicao = ac26_sequencial
      inner join acordoitemexecutado on
        ac20_sequencial = ac29_acordoitem
      inner join acordoitemexecutadoempautitem on
        ac29_sequencial = ac19_acordoitemexecutado
      inner join empautitem on
        e55_sequen = ac19_sequen
        and ac19_autori = e55_autori
      inner join empautoriza on
        e54_autori = e55_autori
      left join empempaut on
        e61_autori = e54_autori
      left join empempenho on
        e61_numemp = e60_numemp
      where
        ac26_acordo = $ac16_sequencial
      group by
        e54_autori,
        e54_emiss,
        e60_codemp,
        e60_anousu,
        e60_numemp,
        e54_anulad
      union
      select
        distinct e54_autori,
        e60_numemp
      from
        acordoposicao
      inner join acordoitem on
        ac20_acordoposicao = ac26_sequencial
      inner join acordoitemexecutado on
        ac20_sequencial = ac29_acordoitem
      inner join acordoitemexecutadoperiodo on
        ac29_sequencial = ac38_acordoitemexecutado
      inner join acordoitemexecutadoempenho on
        ac38_sequencial = ac39_acordoitemexecutadoperiodo
      inner join empempenho on
        ac39_numemp = e60_numemp
      left join empempaut on
        e60_numemp = e61_numemp
      inner join empautoriza on
        e54_autori = e61_autori
      where
        ac26_acordo = $ac16_sequencial
      order by
        e54_autori;";
        return $sSql;
  }


  public function getTermoContrato($iCodigotermo, $iNumeroAditamento)
  {
    $sql = "
            SELECT CASE
                  WHEN ac26_acordoposicaotipo IN (15,16,17) THEN 3
                  ELSE 2
              END AS tipoTermoContratoId,
              CASE
                WHEN ac26_numeroaditamento = '' THEN si03_numapostilamento
                ELSE ac26_numeroaditamento::int
              END AS numeroTermoContrato,
              ac16_objeto AS objetoTermoContrato,
              CASE
                WHEN ac35_dataassinaturatermoaditivo IS NULL THEN si03_dataapostila
                ELSE ac35_dataassinaturatermoaditivo
              END AS dataAssinatura,
              CASE
                  WHEN ac26_acordoposicaotipo IN (6,13) THEN TRUE
                  ELSE FALSE
              END AS qualificacaoVigencia,
              FALSE AS qualificacaoFornecedor,
                        CASE
                            WHEN ac26_acordoposicaotipo IN (2,5,7,14,15,16) THEN TRUE
                            ELSE FALSE
                        END AS qualificacaoReajuste,
                        cgm.z01_cgccpf AS niFornecedor,
                        CASE
                            WHEN length(trim(cgm.z01_cgccpf)) = 14 THEN 'PJ'
                            ELSE 'PF'
                        END AS tipoPessoaFornecedor,
                        cgm.z01_nome AS nomeRazaoSocialFornecedor,
                        ac16_datainicio AS dataVigenciaInicio,
                        ac16_datafim AS dataVigenciaFim
        FROM acordoposicao
        INNER JOIN acordo ON acordo.ac16_sequencial = acordoposicao.ac26_acordo
        INNER JOIN acordoposicaotipo ON acordoposicaotipo.ac27_sequencial = acordoposicao.ac26_acordoposicaotipo
        INNER JOIN cgm ON cgm.z01_numcgm = acordo.ac16_contratado
        INNER JOIN db_depart ON db_depart.coddepto = acordo.ac16_coddepto
        INNER JOIN acordogrupo ON acordogrupo.ac02_sequencial = acordo.ac16_acordogrupo
        INNER JOIN acordosituacao ON acordosituacao.ac17_sequencial = acordo.ac16_acordosituacao
        LEFT JOIN acordocomissao ON acordocomissao.ac08_sequencial = acordo.ac16_acordocomissao
        LEFT JOIN acordovigencia ON ac26_sequencial = ac18_acordoposicao
        LEFT JOIN acordoposicaoaditamento ON ac26_sequencial = ac35_acordoposicao
        LEFT JOIN apostilamento ON si03_acordoposicao = ac26_sequencial
        WHERE acordoposicao.ac26_sequencial = $iCodigotermo
        AND ac26_numeroaditamento::int = $iNumeroAditamento
    ";
    return $sql;
  }

    public function getTermoContratoRecisao($iCodigotermo)
    {
        $sql = "
            SELECT
              1 AS tipoTermoContratoId,
              CASE
                WHEN ac26_numeroaditamento = '' THEN si03_numapostilamento
                ELSE ac26_numeroaditamento::int
              END AS numeroTermoContrato,
              ac16_objeto AS objetoTermoContrato,
              CASE
                WHEN ac35_dataassinaturatermoaditivo IS NULL THEN si03_dataapostila
                ELSE ac35_dataassinaturatermoaditivo
              END AS dataAssinatura,
              CASE
                  WHEN ac26_acordoposicaotipo IN (6,13) THEN TRUE
                  ELSE FALSE
              END AS qualificacaoVigencia,
              FALSE AS qualificacaoFornecedor,
                        CASE
                            WHEN ac26_acordoposicaotipo IN (2,5,7,14,15,16) THEN TRUE
                            ELSE FALSE
                        END AS qualificacaoReajuste,
                        cgm.z01_cgccpf AS niFornecedor,
                        CASE
                            WHEN length(trim(cgm.z01_cgccpf)) = 14 THEN 'PJ'
                            ELSE 'PF'
                        END AS tipoPessoaFornecedor,
                        cgm.z01_nome AS nomeRazaoSocialFornecedor,
                        ac16_datainicio AS dataVigenciaInicio,
                        ac16_datafim AS dataVigenciaFim
        FROM acordoposicao
        INNER JOIN acordo ON acordo.ac16_sequencial = acordoposicao.ac26_acordo
        INNER JOIN acordoposicaotipo ON acordoposicaotipo.ac27_sequencial = acordoposicao.ac26_acordoposicaotipo
        INNER JOIN cgm ON cgm.z01_numcgm = acordo.ac16_contratado
        INNER JOIN db_depart ON db_depart.coddepto = acordo.ac16_coddepto
        INNER JOIN acordogrupo ON acordogrupo.ac02_sequencial = acordo.ac16_acordogrupo
        INNER JOIN acordosituacao ON acordosituacao.ac17_sequencial = acordo.ac16_acordosituacao
        LEFT JOIN acordocomissao ON acordocomissao.ac08_sequencial = acordo.ac16_acordocomissao
        LEFT JOIN acordovigencia ON ac26_sequencial = ac18_acordoposicao
        LEFT JOIN acordoposicaoaditamento ON ac26_sequencial = ac35_acordoposicao
        LEFT JOIN apostilamento ON si03_acordoposicao = ac26_sequencial
        WHERE acordoposicao.ac26_sequencial = $iCodigotermo
    ";
        return $sql;
    }

  public function sqlAPosicaoApostilamentoEmpenho($ac26Acordo)
  {
    $sql = "
        SELECT DISTINCT ac26_numeroapostilamento AS numerodoapostilamento,
                    e54_autori AS codigodaautorizacao,
                    e61_numemp AS codigodoempenho
        FROM acordoposicao
        INNER JOIN acordoitem ON ac20_acordoposicao = ac26_sequencial
        INNER JOIN acordoitemexecutado ON ac29_acordoitem = ac20_sequencial
        INNER JOIN acordoitemexecutadoempautitem ON ac19_acordoitemexecutado = ac29_sequencial
        LEFT  JOIN empautoriza ON e54_autori = ac19_autori
        LEFT  JOIN empautitem ON (ac19_autori,ac19_sequen) = (e55_autori,e55_sequen)
        LEFT  JOIN empempaut ON e61_autori = e54_autori
        WHERE ac26_acordo = $ac26Acordo
            AND ac26_acordoposicaotipo IN (15,16,17)
            AND ac26_numeroapostilamento IN
                (SELECT max(ac26_numeroapostilamento)
                 FROM acordoposicao
                 WHERE ac26_acordo = $ac26Acordo);
    ";
    return $sql;
  }

  public function updateApositilamento($ac26_acordo, $apostilamento)
  {

    $sql = "
    UPDATE
        acordoposicao
    SET
        ac26_numeroapostilamento = $apostilamento->si03_numapostilamento,
        ac26_criterioreajuste = " . ($apostilamento->si03_criterioreajuste == "null" || $apostilamento->si03_criterioreajuste == "" ? 'null' : "'" . $apostilamento->si03_criterioreajuste . "'") . ",
        ac26_descricaoreajuste = " . ($apostilamento->si03_descricaoreajuste == "null" || $apostilamento->si03_descricaoreajuste == "" ? 'null' : "'" . $apostilamento->si03_descricaoreajuste . "'") . ",
        ac26_descricaoindice = " . ($apostilamento->si03_descricaoindice == "null" || $apostilamento->si03_descricaoindice == "" ? 'null' : "'" . $apostilamento->si03_descricaoindice . "'") . ",
        ac26_indicereajuste = " . ($apostilamento->si03_indicereajuste == "null" || $apostilamento->si03_indicereajuste == "" ? '0' :  $apostilamento->si03_indicereajuste ).",
        ac26_percentualreajuste = " . ($apostilamento->si03_percentualreajuste == "null" || $apostilamento->si03_percentualreajuste == "" ? 'null' :  $apostilamento->si03_percentualreajuste )."
    WHERE
        ac26_acordo = $ac26_acordo
        AND ac26_numeroapostilamento IS NOT NULL
        AND ac26_numeroapostilamento IN (
            SELECT max(ac26_numeroapostilamento)
            FROM acordoposicao WHERE ac26_acordo = $ac26_acordo)
    ";

    $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "posicoes do acordo nao Alterado. Alteracao Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->ac26_sequencial;
       $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "posicoes do acordo nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->ac26_sequencial;
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alterao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->ac26_sequencial;
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = pg_affected_rows($result);
         return true;
       }
     }
  }

    public function sqlValidaUpdateNumApostilamento($acordo,  $numApostilamento)
    {
        $sql = "
        SELECT *
        FROM acordoposicao
        WHERE ac26_acordo = $acordo
            AND ac26_numeroapostilamento = '$numApostilamento';
        ";
        return $sql;
    }
}
?>
