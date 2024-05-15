<?php
/**
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
require_once 'phplot/phplot.php';

/**
 * Class to generate a image with graph to be imported on the pdf report
 * @author Robson de Jesus <robson.silva@contassconsultoria.com.br>
 */
class PHPlotReport extends PHPlot {

    /**
     * Linux path to the TruType font
     * @var string
     */
	protected $sDefaultFont = '/usr/share/fonts/truetype/ttf-dejavu/DejaVuSansCondensed-Bold.ttf';

    /**
     * Image path/file to be saved
     */
	const IMAGE = "tmp/phplotimg.png";

    /**
     * Image type to be saved 
     */
	const IMAGE_TYPE = "png";

    /**
     * Class constructor
     * @param string $title
     */
	public function __construct($title) {

		parent::__construct(1200, 600);

		$this->SetImageBorderType('plain');
		$this->SetPlotType('bars');
		$this->SetDataType('text-data');
		$this->SetDefaultTTFont($this->sDefaultFont);
		$this->SetFont('title', $this->sDefaultFont, 12, NULL);
		$this->SetFont('y_title', $this->sDefaultFont, 12, NULL);
		$this->SetFont('x_label', $this->sDefaultFont, 10, NULL);
		$this->SetFont('y_label', $this->sDefaultFont, 10, NULL);
		$this->SetNumberFormat(',','.');

		$this->SetTitle($title);
		$this->SetYTitle('Valores em Reais R$');

		$this->SetDataColors('grey');

		// Turn off X tick labels and ticks because they don't apply here:
		$this->SetXTickLabelPos('none');
		$this->SetXTickPos('none');

		// Make sure Y=0 is displayed:
		$this->SetPlotAreaWorld(NULL, 0);
		// Y Tick marks are off, but Y Tick Increment also controls the Y grid lines:
		$this->SetYTickIncrement(100000);

		// Turn on Y data labels:
		$this->SetYDataLabelPos('plotin');

		// With Y data labels, we don't need Y ticks or their labels, so turn them off.
		$this->SetYTickLabelPos('plotleft');
		$this->SetYTickPos('plotleft');

		// Format the Y Data Labels as numbers with 2 decimal place.
		// Note that this automatically calls SetYLabelType('data').
		$this->SetPrecisionY(2);

		// Create the image
		$this->SetIsInline(TRUE);
		$this->SetFileFormat(PHPlotReport::IMAGE_TYPE);
		$this->SetOutputFile(PHPlotReport::IMAGE);
	}

    /**
     * Create a image with graph to be used on the pdf report
     * 
     * @param array $data
     */
	public function DrawGraphReport($data = null) {

        $this->removeImage();
		$this->SetDataValues($data);
		$this->SetYTickIncrement($this->calcTickIncrement($data));
		$this->DrawGraph();
	}

	/**
	 * Calculate the SetYTickIncrement
	 * 
	 * This method actually is returning the quantity of zeros according the max 
	 * $data value.
	 * between space
	 * @param array $data
	 */
	protected function calcTickIncrement($data) {

        $iTickIncrement = 0;
		foreach ($data as $aColumnAndNumber) {
			$integerValue = floor($aColumnAndNumber[1]);
			$iTickIncrement = (strlen($integerValue) > $iTickIncrement ? strlen($integerValue) : $iTickIncrement);
		}
		return pow(10, $iTickIncrement-2)*5;
	}

    /**
     * Remove generated
     * 
     * This method is just to ensure old image will not be printed
     */
	protected function removeImage() {
		if (file_exists(PHPlotReport::IMAGE)) {
			system("rm ".PHPlotReport::IMAGE);
		}
	}
}
