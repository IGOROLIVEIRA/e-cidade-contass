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
    public $erro_status = null;
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
                l20_codigo=" . $codigo;
        return $this->sql_record($sql);
    }

    public function buscaFornecedor($cnpj)
    {
        $sql = "
            select pc60_cnpjcpf from pcforne where pc60_cnpjcpf ='$cnpj'
        ";
        return $this->sql_record($sql);
    }

    public function buscaNumCgm(string $cnpj)
    {
        $sql = "
            select  z01_numcgm as numcgm from cgm where z01_cgccpf = '$cnpj'
        ";

        return $this->sql_record($sql);
    }

    public function buscaCpfCnpj(string $numcgm)
    {
        $sql = "
            select z01_cpf from protocolo.db_cgmcpf where z01_numcgm = '$numcgm'
        ";

        return $this->sql_record($sql);
    }

    public function buscaL21codigo(int $l21Ordem, int $codigo)
    {
        $sql = "
        select
	        l21_codigo as idliclicitem
        from liclicita
            join cflicita on l03_codigo=l20_codtipocom
            join liclicitem on l21_codliclicita = l20_codigo
            join liclicitemlote on l04_liclicitem=l21_codigo
            join pcprocitem on pc81_codprocitem=l21_codpcprocitem
            join solicitem on pc11_codigo=pc81_solicitem
            join solicita on pc10_numero = pc11_numero
            join solicitempcmater on pc16_solicitem=pc11_codigo
            join pcmater on pc01_codmater=pc16_codmater
            join solicitemunid on pc17_codigo=pc11_codigo
            join matunid on m61_codmatunid=pc17_unid
            left join pcorcamitemproc on pc31_pcprocitem=pc81_codprocitem
            left join pcorcamitem on pc22_orcamitem=pc31_orcamitem
            left join itemprecoreferencia on si02_itemproccompra=pc22_orcamitem
            left join solicitaregistropreco on pc54_solicita=pc10_numero
        where
            l21_ordem = $l21Ordem and l20_codigo = $codigo
       order by l21_ordem;
        ";

        return $this->sql_record($sql);
    }

    public function sql_record($sql)
    {
        $result = db_query($sql);
        if ($result == false || $result == null) {
            $this->numrows    = 0;
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_sql   = "Erro ao selecionar os registros.";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $this->numrows = pg_num_rows($result);

        if ($this->numrows == 0) {
            $this->erro_banco = "";
            $this->erro_sql   = "Registro vazio";
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
            $this->erro_status = "0";
            return false;
        }

        $this->erro_status = "1";
        return $result;
    }

    public function cancelaJulgamentoComum($pc20_codorc, $l20_codigo)
    {
        $sql = "
        begin;
            delete from pcorcamjulg where pc24_orcamforne  in (select pc21_orcamforne from pcorcamforne where pc21_codorc = $pc20_codorc);
            delete from pcorcamval where pc23_orcamforne in (select pc21_orcamforne from pcorcamforne where pc21_codorc = $pc20_codorc);
            delete from pcorcamforne where pc21_codorc = $pc20_codorc;
            delete from pcorcamitemlic where pc26_orcamitem in (select pc22_orcamitem from pcorcamitem where pc22_codorc = $pc20_codorc);
            delete from pcorcamitem where pc22_codorc = $pc20_codorc;
            delete from pcorcam where pc20_codorc = $pc20_codorc;
            delete from  liclicitasituacao where l11_liclicita = $l20_codigo  and l11_licsituacao = 1;
            update liclicita set l20_licsituacao = 0 where l20_codigo = $l20_codigo;
        commit;
        ";

        $result = db_query($sql);


        if ($result == false) {
            $this->erro_status = 0;
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_banco = "Não foi possível ";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        }
    }

    public function cancelaJulgamentoRegistroPreco($pc20_codorc, $l20_codigo)
    {
        $sql = "
        begin;
            delete from pcorcamjulg where pc24_orcamforne  in (select pc21_orcamforne from pcorcamforne where pc21_codorc = $pc20_codorc);
            delete from pcorcamval where pc23_orcamforne in (select pc21_orcamforne from pcorcamforne where pc21_codorc = $pc20_codorc);
            delete from pcorcamjulgamentologitem  where pc93_pcorcamforne in (select pc21_orcamforne from pcorcamforne where pc21_codorc = $pc20_codorc);
            delete from registroprecojulgamento where pc65_orcamforne in (select pc21_orcamforne from pcorcamforne where pc21_codorc = $pc20_codorc);
            delete from registroprecovalores where pc56_orcamforne in (select pc21_orcamforne from pcorcamforne where pc21_codorc = $pc20_codorc);
            delete from pcorcamforne where pc21_codorc = $pc20_codorc;
            delete from pcorcamitemlic where pc26_orcamitem in (select pc22_orcamitem from pcorcamitem where pc22_codorc = $pc20_codorc);
            delete from pcorcamitem where pc22_codorc = $pc20_codorc;
            delete from pcorcam where pc20_codorc = $pc20_codorc;
            delete from  liclicitasituacao where l11_liclicita = $l20_codigo  and l11_licsituacao = 1;
            update liclicita set l20_licsituacao = 0 where l20_codigo = $l20_codigo;
        commit;
        ";

        $result = db_query($sql);


        if ($result == false) {
            $this->erro_status = 0;
            $this->erro_banco = str_replace("\n", "", @pg_last_error());
            $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
            $this->erro_banco = "Não foi possível ";
            $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        }
    }
}
