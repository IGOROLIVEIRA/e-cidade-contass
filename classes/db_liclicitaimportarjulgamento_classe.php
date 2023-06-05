<?php
class cl_liclicitaimportarjulgamento
{
     // cria variaveis de erro
   public $rotulo     = null;
   public $query_sql  = null;
   public $numrows    = 0;
   public $numrows_incluir = 0;
   public $numrows_alterar = 0;
   public $numrows_excluir = 0;
   public $erro_status= null;
   public $erro_sql   = null;
   public $erro_banco = null;
   public $erro_msg   = null;
   public $erro_campo = null;
   public $pagina_retorno = null;

    public function buscarModalidadeComObjeto($codigo)
    {
        $sql = "select distinct
        l20_codigo as id,
        l20_objeto as objeto,
        l20_numero as numeroprocesso,
        l20_anousu as anoprocesso,
        l20_licsituacao as situacao,
        l03_descr as modalidade
        from liclicita
        join cflicita on l03_codigo=l20_codtipocom
        where
        l20_codigo=".$codigo;
        return $this->sql_record($sql);
    }


    public function sql_record($sql)
    {
        $result = db_query($sql);
        if($result==false || $result == null) {
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
           $this->erro_sql   = "Record Vazio na Tabela:liclicitaproc";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
        return $result;
      }

}