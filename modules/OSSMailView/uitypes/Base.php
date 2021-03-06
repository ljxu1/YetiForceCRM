<?php

/**
 * UIType Base Field Class
 * @package YetiForce.Fields
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class OSSMailView_Base_UIType extends Vtiger_Base_UIType
{

	/**
	 * Verification of data
	 * @param string $value
	 * @param bool $isUserFormat
	 * @return null
	 * @throws \App\Exceptions\Security
	 */
	public function validate($value, $isUserFormat = false)
	{
		if ($this->validate || empty($value)) {
			return;
		}
		if ($isUserFormat) {
			$value = \App\Purifier::decodeHtml($value);
		}
		$fieldName = $this->get('field')->getFieldName();
		if (!is_numeric($value) && (is_string($value) && $fieldName !== 'uid' && $value !== strip_tags($value))) {
			throw new \App\Exceptions\Security('ERR_ILLEGAL_FIELD_VALUE||' . $fieldName . '||' . $value, 406);
		}
		if (App\Utils::getTextLength($value) > 255) {
			throw new \App\Exceptions\Security('ERR_VALUE_IS_TOO_LONG||' . $fieldName . '||' . $value, 406);
		}
		$this->validate = true;
	}
}
