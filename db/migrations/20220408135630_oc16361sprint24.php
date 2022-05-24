<?php

use Phinx\Migration\AbstractMigration;

class Oc16361sprint24 extends AbstractMigration
{

  public function up()
  {

    $sql = "begin;

        /*cria campo db150_seqobrascodigos nas tabelas obrasdadoscomplementares*/
        alter table obrasdadoscomplementares 
            add column db150_seqobrascodigos integer;
               
        alter table obrasdadoscomplementareslote 
          add column db150_seqobrascodigos integer;
               
        /*insere valores no novo campo db150_seqobrascodigos com base na tabela obrascodigos*/
        update obrasdadoscomplementares
        set db150_seqobrascodigos =
          (select db151_sequencial
           from obrascodigos
           where obrascodigos.db151_codigoobra = obrasdadoscomplementares.db150_codobra);
        
        update obrasdadoscomplementareslote
        set db150_seqobrascodigos =
          (select db151_sequencial
           from obrascodigos
           where obrascodigos.db151_codigoobra = obrasdadoscomplementareslote.db150_codobra);
        
        /*remove chaves estrangeiras obrasdadoscomplementares e obrasdadoscomplementareslote*/
        alter table obrasdadoscomplementares
          drop constraint fk_codigoobra;
        
        alter table obrasdadoscomplementareslote
          drop constraint db150_codobra_fk;
        
        alter table obrascodigos
          drop constraint obrascodigos_pkey;
        
        /*insere chave primária obrascodigos*/
        alter table obrascodigos
          add constraint db151_sequencial_pk primary key (db151_sequencial);
        
        /*insere chave unique obrascodigos*/
        alter table obrascodigos
          add constraint obrascodigos_uk unique (db151_codigoobra,db151_liclicita);
        
        /*insere chaves estrangeiras obrasdadoscomplementares e obrasdadoscomplementareslote*/
        alter table obrasdadoscomplementares
          add constraint db150_seqobra_fk foreign key (db150_seqobrascodigos)
          references obrascodigos (db151_sequencial);
        
        alter table obrasdadoscomplementareslote
          add constraint db150_seqobralote_fk foreign key (db150_seqobrascodigos)
          references obrascodigos (db151_sequencial);
          
       commit";

    $this->execute($sql);
  }

  public function down()
  {
  }
}
