<?php

use Phinx\Migration\AbstractMigration;

class Oc11148 extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $sql = <<<SQL
        
        BEGIN;

          SELECT fc_startsession();

            INSERT INTO tiposnotificacao
            VALUES (nextval('tiposnotificacao_p110_sequencial_seq'),
                    'Abertura de processo de pagamento',
                    'Senhor fornecedor,<br><br>
            O processo de pagamento ref. a nota fiscal {$nfe} foi aberto e registrado sob o protocolo {$protocolo}.<br>
            Anote este número para realizar eventual pedido de informação a respeito do pagamento.<br>
            A nota fiscal será enviada ao gestor da contratação para conferência e liquidação da despesa.<br>
            Lembramos que o prazo contratual para pagamento de 10 dias úteis conta-se a partir da data da liquidação, pois é este ato que atesta que o faturamento está de acordo com o contrato e a execução.<br>
            Informamos que na data da liquidação, encaminharemos um novo comunicado informando a data prevista para o pagamento.<br>
            Atenciosamente,<br><br>
            <strong>Divisão de Gestão Financeira</strong><br>
            Câmara Municipal de Belo Horizonte<br>
            Atendimento ao fornecedor: Email: <a href="#">divgef.notafiscal@cmbh.mg.gov.br</a> ou telefone: (31)3555-1138<br><br>
            <strong>Atenção:</strong><br>
            As informações contidas neste e-mail, e nos arquivos anexos, são para uso exclusivo do destinatário aqui indicado, não se<br>
            autorizando o acesso por qualquer outra pessoa. Caso não seja o destinatário correto, esteja notificado pelo presente que qualquer<br>
            revisão, leitura, cópia e/ou divulgação do conteúdo deste "e-mail" são estritamente proibidas e não autorizadas. Por favor, apague o<br>
            conteúdo do "e-mail" e notifique a remetente imediatamente. Agradecemos a colaboração.',
                    1);
            
            INSERT INTO tiposnotificacao
            VALUES (nextval('tiposnotificacao_p110_sequencial_seq'),
                    'Realização do pagamento',
                    'Senhor fornecedor,<br><br>
            Informamos a realização do pagamento ref. a nota fiscal {$nfe}, processo de pagamento registrado sob o nº {$numpagamento}.<br>
            Agradecemos a parceria na relação contratual.<br>
            Atenciosamente,<br><br>
            <strong>Divisão de Gestão Financeira</strong><br>
            Câmara Municipal de Belo Horizonte<br>
            Atendimento ao fornecedor: Email: <a href="#">divgef.notafiscal@cmbh.mg.gov.br</a> ou telefone: (31)3555-1138<br><br>
            <strong>Atenção:</strong><br>
            As informações contidas neste e-mail, e nos arquivos anexos, são para uso exclusivo do destinatário aqui indicado, não se<br>
            autorizando o acesso por qualquer outra pessoa. Caso não seja o destinatário correto, esteja notificado pelo presente que qualquer<br>
            revisão, leitura, cópia e/ou divulgação do conteúdo deste "e-mail" são estritamente proibidas e não autorizadas. Por favor, apague o<br>
            conteúdo do "e-mail" e notifique a remetente imediatamente. Agradecemos a colaboração.',
                    3);
            
            INSERT INTO tiposnotificacao
            VALUES (nextval('tiposnotificacao_p110_sequencial_seq'),
                    'Previsão de pagamento',
                    'Senhor fornecedor,<br><br>
            Informamos que a nota fiscal  {$nfe}, ref. ao processo registrado sob o protocolo {$protocolo} foi liquidada pelo gestor do contrato em {$dataliquidacao}.<br>
            O prazo contratual para pagamento é de 10 dias úteis conta-se a partir desta data.
            Dessa forma, a previsão de pagamento é {$dataprevisao}.<br>
            Atenciosamente,<br><br>
            <strong>Divisão de Gestão Financeira</strong><br>
            Câmara Municipal de Belo Horizonte<br>
            Atendimento ao fornecedor: Email: <a href="#">divgef.notafiscal@cmbh.mg.gov.br</a> ou telefone: (31)3555-1138<br><br>
            <strong>Atenção:</strong><br>
            As informações contidas neste e-mail, e nos arquivos anexos, são para uso exclusivo do destinatário aqui indicado, não se<br>
            autorizando o acesso por qualquer outra pessoa. Caso não seja o destinatário correto, esteja notificado pelo presente que qualquer<br>
            revisão, leitura, cópia e/ou divulgação do conteúdo deste "e-mail" são estritamente proibidas e não autorizadas. Por favor, apague o<br>
            conteúdo do "e-mail" e notifique a remetente imediatamente. Agradecemos a colaboração.',
                    2);
            
            INSERT INTO tiposnotificacao
            VALUES (nextval('tiposnotificacao_p110_sequencial_seq'),
                    'Atraso de Pagamento',
                    'Senhor fornecedor, Comunicamos o atraso do pagamento',
                    0);
        COMMIT;            
SQL;
        $this->execute($sql);
    }
}
