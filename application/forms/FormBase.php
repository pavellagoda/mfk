<?php
class forms_FormBase extends Zend_Form
{
	/**
	 * Inits default filters and validators common for elements
	 *
	 * @param Zend_Form_Element $oZendFormElement
	 * @param bool $bIsRequired
	 * @return Zend_Form_Element
	 */
	protected function _initDefaultFiltersAndValidators(Zend_Form_Element $oZendFormElement, $bIsRequired = true)
	{
		$oZendFormElement->setRequired($bIsRequired)
		                 ->addFilter(new Zend_Filter_StringTrim());
		                 
		return $oZendFormElement;
	}
	
	/**
	 * adds element with provided label and wraps label into provided tag
	 * 
	 * @param Zend_Form_Element $element
	 * @param string $label - If null - not adds label
	 * @param string $labelWrapTag - Tag in which label will be wrapped
	 * @return Zend_Form
	 */
	public function addElement( $element, $label = null, $labelWrapTag = 'span' )
	{
		if ( $label )
		{
			$element->setLabel($label)->getDecorator('label')->setOption('tag', $labelWrapTag);
		}
		
		return parent::addElement($element);
	}
}