<?php
// autogenerated file 05.05.2008 16:30
// $Id: EbatNsCsSetExt_ValType.php,v 1.2 2013-04-05 11:15:58 thomasbiniasch Exp $
// $Log: EbatNsCsSetExt_ValType.php,v $
// Revision 1.2  2013-04-05 11:15:58  thomasbiniasch
// bugfixes and template updates, first running version milestone!
//
//
//
require_once 'EbatNs_ComplexType.php';
require_once 'EbatNsCsSetExt_AttributeType.php';

/**
 *  
 *
 *
 */
class EbatNsCsSetExt_ValType extends EbatNs_ComplexType
{
	/**
	 * @var string
	 */
	protected $ValueLiteral;
	/**
	 * @var string
	 */
	protected $SuggestedValueLiteral;
	/**
	 * @var int
	 */
	protected $ValueID;
	/**
	 * @var string
	 */
	protected $Name;
	/**
	 * @var string
	 */
	protected $IsDefault;
	/**
	 * @var EbatNsCsSetExt_AttributeType
	 */
	protected $DependencyList;

	/**
	 * @return string
	 */
	function getValueLiteral()
	{
		return $this->ValueLiteral;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setValueLiteral($value)
	{
		$this->ValueLiteral = $value;
	}
	/**
	 * @return string
	 * @param integer $index 
	 */
	function getSuggestedValueLiteral($index = null)
	{
		if ($index !== null) {
			return $this->SuggestedValueLiteral[$index];
		} else {
			return $this->SuggestedValueLiteral;
		}
	}
	/**
	 * @return void
	 * @param string $value 
	 * @param  $index 
	 */
	function setSuggestedValueLiteral($value, $index = null)
	{
		if ($index !== null) {
			$this->SuggestedValueLiteral[$index] = $value;
		} else {
			$this->SuggestedValueLiteral = $value;
		}
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function addSuggestedValueLiteral($value)
	{
		$this->SuggestedValueLiteral[] = $value;
	}
	/**
	 * @return int
	 */
	function getValueID()
	{
		return $this->ValueID;
	}
	/**
	 * @return void
	 * @param int $value 
	 */
	function setValueID($value)
	{
		$this->ValueID = $value;
	}
	/**
	 * @return string
	 */
	function getName()
	{
		return $this->Name;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setName($value)
	{
		$this->Name = $value;
	}
	/**
	 * @return string
	 */
	function getIsDefault()
	{
		return $this->IsDefault;
	}
	/**
	 * @return void
	 * @param string $value 
	 */
	function setIsDefault($value)
	{
		$this->IsDefault = $value;
	}
	/**
	 * @return EbatNsCsSetExt_AttributeType
	 * @param integer $index 
	 */
	function getDependencyList($index = null)
	{
		if ($index !== null) {
			return $this->DependencyList[$index];
		} else {
			return $this->DependencyList;
		}
	}
	/**
	 * @return void
	 * @param EbatNsCsSetExt_AttributeType $value 
	 * @param  $index 
	 */
	function setDependencyList($value, $index = null)
	{
		if ($index !== null) {
			$this->DependencyList[$index] = $value;
		} else {
			$this->DependencyList = $value;
		}
	}
	/**
	 * @return void
	 * @param EbatNsCsSetExt_AttributeType $value 
	 */
	function addDependencyList($value)
	{
		$this->DependencyList[] = $value;
	}
	/**
	 * @return 
	 */
	function __construct()
	{
		parent::__construct('EbatNsCsSetExt_ValType', 'http://www.w3.org/2001/XMLSchema');
		$this->_elements = array_merge($this->_elements,
			array(
				'ValueLiteral' =>
				array(
					'required' => true,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '1..1'
				),
				'SuggestedValueLiteral' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => true,
					'cardinality' => '0..*'
				),
				'ValueID' =>
				array(
					'required' => false,
					'type' => 'int',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'Name' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'IsDefault' =>
				array(
					'required' => false,
					'type' => 'string',
					'nsURI' => 'http://www.w3.org/2001/XMLSchema',
					'array' => false,
					'cardinality' => '0..1'
				),
				'DependencyList' =>
				array(
					'required' => false,
					'type' => 'EbatNsCsSetExt_AttributeType',
					'nsURI' => 'http://www.intradesys.com/Schemas/ebay/AttributeData_Extension.xsd',
					'array' => true,
					'cardinality' => '0..*'
				)
			));
	$this->_attributes = array_merge($this->_attributes,
		array(
			'id' =>
			array(
				'name' => 'id',
				'type' => 'int',
				'use' => 'required'
			)
		));

	}
}
?>