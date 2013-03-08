<?php

include_once(dirname(__FILE__) . '/tcpdf/tcpdf.php');

/**
 * PwTCPDF.
 * Extend the TCPDF class to provide ProcessWire specific stuff to TCPDF. 
 * Currently this class is used to set a custom header and footer from ProcessWire templates
 *
 * @author Stefan Wanzenried (Wanze)
 * @copyright Stefan Wanzenried
 *
 * @extends TCPDF
 */
class PwTCPDF extends TCPDF {
	
	/**
	 * Header-markup loaded from Pw Template
	 *
	 */	
	protected $pwHeader = '';
	
	/**
	 * Footer-markup loaded from Pw Template
	 *
	 */
	protected $pwFooter = '';


	public function setPwHeader($html) {
		$this->pwHeader = $html;
	}
	
	public function setPwFooter($html) {
		$this->pwFooter = $html;
	}
	
		
	/**
	 * Overwrite the Header method to support adding HTML through Pw-Template
	 * 
	 * @access public
	 * @return void
	 */
	public function Header() {
		$html = str_replace('{page}', $this->getAliasNumPage(), $this->pwHeader);
		$html = str_replace('{totalPages}', $this->getAliasNbPages(), $html);		
		$this->writeHTML($html);
	}
	
	
	/**
	 * Overwrite the Footer method to support adding HTML through Pw-Template
	 * 
	 * @access public
	 * @return void
	 */
	public function Footer() {
		$y = $this->getPageHeight() - $this->footer_margin;
		$html = str_replace('{page}', $this->getAliasNumPage(), $this->pwFooter);
		$html = str_replace('{totalPages}', $this->getAliasNbPages(), $html);
		$this->writeHTMLCell(0, 10, $this->lMargin, $y, $html);
	}
	
	
}