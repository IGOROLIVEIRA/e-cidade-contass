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
namespace ECidade\Configuracao\Formulario\Processamento;
use ECidade\Configuracao\Formulario\Model\Formulario as FormularioModel;


/**
 * Class RemoveCarga
 * @package ECidade\Configuracao\Formulario\Processamento
 */
class RemoveCarga {

  /**
   * @var \ECidade\Configuracao\Formulario\Model\Formulario
   */
  private $formulario;

  /**
   * Carga constructor.
   * @param \ECidade\Configuracao\Formulario\Model\Formulario $formulario
   */
  public function __construct(FormularioModel $formulario) {
    $this->formulario = $formulario;
  }

  /**
   * executa o processamento da Carga
   */
  public function executar() {

    $this->formulario->deleteRespostas();
  }
}
