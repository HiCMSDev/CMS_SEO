<?php
/**
 * SEO for Craft CMS
 *
 * @link      https://ethercreative.co.uk
 * @copyright Copyright (c) 2018 Ether Creative
 */

namespace ether\seo\models\data;

use craft\elements\Asset;

function get_public_properties ($class) {
	return get_object_vars($class);
}

/**
 * Class SocialData
 *
 * @author  Ether Creative
 * @package ether\seo\models\data
 */
class SocialData extends BaseDataModel
{

	// Properties
	// =========================================================================

	// Properties: Public
	// -------------------------------------------------------------------------

	/** @var string */
	public $handle = '';

	/** @var string */
	public $title = '';

	/** @var Asset|array|null */
	public $image = null;

	/** @var string */
	public $description = '';

	// Properties: Private
	// -------------------------------------------------------------------------

	/** @var array */
	private $_fallback;

	// Constructor
	// =========================================================================

	public function __construct (array $fallback = null, array $config = [])
	{
		$this->_fallback = $fallback;

		parent::__construct($config);
	}

	// Init
	// =========================================================================

	public function init ()
	{
		// Fallbacks
		foreach (get_public_properties($this) as $key => $value)
			if (empty($value) && array_key_exists($key, $this->_fallback))
				$this->$key = $this->_fallback[$key];

		// Convert JSON decoded array to an Asset
		$image = $this->image;
		if (is_array($image)) $image = $image['id'];
		if (!($image instanceof Asset))
			$this->image = \Craft::$app->assets->getAssetById((int) $image);
	}

}