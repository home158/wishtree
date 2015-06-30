<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    }
	//Page header
	public function Header() {
		// Logo
		$image_file = K_PATH_IMAGES.'LOGO-01.png';
		$this->Image($image_file, 3, 3, 25, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		// Set font
		$this->SetY(15);
		$this->SetFont('msjh', 'B', 14);
		// Title
		$this->Cell(0, 50, '小善心農業-出貨明細', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $style = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'phase' => 1, 'color' => array(0, 0, 0));
        $this->Line(5, 30, 205, 30, $style);


        
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('msjh', '', 10);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}    
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */