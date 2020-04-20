<?
//CLASSE DA ENTIDADE
class cl_scripts { 

  var $erro_banco = null;
  var $erro_msg   = null;
  var $erro_sql   = null;  

   // funcões
  function excluiEmpenho ($sequencial){ 
    
   $sql = "insert into identificacaoresponsaveis(
   si166_sequencial 
   ,si166_numcgm 
   ,si166_tiporesponsavel 
   ,si166_orgao 
   ,si166_crccontador 
   ,si166_ufcrccontador 
   ,si166_cargoorddespesa 
   ,si166_dataini 
   ,si166_datafim 
   ,si166_instit
   )
   values (
   $this->si166_sequencial 
   ,$this->si166_numcgm 
   ,$this->si166_tiporesponsavel 
   ,$this->si166_orgao 
   ,'$this->si166_crccontador' 
   ,'$this->si166_ufcrccontador' 
   ,'$this->si166_cargoorddespesa' 
   ,".($this->si166_dataini == "null" || $this->si166_dataini == ""?"null":"'".$this->si166_dataini."'")." 
   ,".($this->si166_datafim == "null" || $this->si166_datafim == ""?"null":"'".$this->si166_datafim."'")."
   ,".db_getsession("DB_instit")." 
 )";
 $result = db_query($sql); 
 if($result==false){ 
   $this->erro_banco = str_replace("\n","",@pg_last_error());
   return false;
 }
 $this->erro_banco = "";
 $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
 $this->erro_sql .= "Valores : ".$this->si166_sequencial;
 $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
 $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
 
 $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
 $acount = pg_result($resac,0,0);
 $resac = db_query("insert into db_acount values($acount,2010400,2011405,'','".AddSlashes(pg_result($resaco,0,'si166_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
 
 return true;
} 

}
?>
