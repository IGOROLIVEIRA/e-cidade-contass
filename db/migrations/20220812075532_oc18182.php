<?php

use Phinx\Migration\AbstractMigration;

class oc18182 extends AbstractMigration
{
    public function up()
    {

        foreach ($this->getData() as $item => $descricao) {
            $sql = "update db_estruturavalor set db121_descricao = '{$descricao}' where db121_estrutural = '{$item}';";
            $this->execute($sql);
        }
    }

    private function getData()
    {
        return array(
            '01.03' => 'Processamento, armazenamento ou hospedagem de dados, textos, imagens, vídeos, páginas eletrônicas, aplicativos e sistemas de informação, entre outros formatos, e congêneres.',
            '01.04' => 'Elaboração de programas de computadores, inclusive de jogos eletrônicos, independentemente da arquitetura construtiva da máquina em que o programa será executado, incluindo tablets, smartphones e congêneres.',
            '07.16' => 'Florestamento, reflorestamento, semeadura, adubação, reparação de solo, plantio, silagem, colheita, corte e descascamento de árvores, silvicultura, exploração florestal e dos serviços congêneres indissociáveis da formação, manutenção e colheita de florestas, para quaisquer fins e por quaisquer meios.',
            '11.02' => 'Vigilância, segurança ou monitoramento de bens, pessoas e semoventes.',
            '13.05' => 'Composição gráfica, inclusive confecção de impressos gráficos, fotocomposição, clicheria, zincografia, litografia e fotolitografia, exceto se destinados a posterior operação de comercialização ou industrialização, ainda que incorporados, de qualquer forma, a outra mercadoria que deva ser objeto de posterior circulação, tais como bulas, rótulos, etiquetas, caixas, cartuchos, embalagens e manuais técnicos e de instrução, quando ficarão sujeitos ao ICMS.',
            '14.05' => 'Restauração, recondicionamento, acondicionamento, pintura, beneficiamento, lavagem, secagem, tingimento, galvanoplastia, anodização, corte, recorte, plastificação, costura, acabamento, polimento e congêneres de objetos quaisquer.',
            '16.01' => 'Serviços de transporte coletivo municipal rodoviário, metroviário, ferroviário e aquaviário de passageiros.',
            '25.02' => 'Translado intramunicipal e cremação de corpos e partes de corpos cadavéricos.',
        );
    }
}
