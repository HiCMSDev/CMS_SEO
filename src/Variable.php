<?php

namespace ether\seo;

use craft\elements\Asset;
use craft\helpers\Template;
use craft\helpers\UrlHelper;
use ether\seo\fields\SeoField;
use ether\seo\models\data\SeoData;
use Twig_Template;

class Variable
{

	/**
	 * @param string $title
	 * @param string $description
	 * @param bool   $_ - Deprecated
	 * @param array  $social
	 *
	 * @return SeoData
	 */
	public function custom (
		$title = '',
		$description = '',
		$_ = null,
		$social = []
	) {
		return new SeoData(null, null, [
			'titleRaw'    => $title,
			'description' => $description,
			'social'      => $social,
		]);
	}

	// Social
	// =========================================================================

	// Social: Images
	// -------------------------------------------------------------------------

	/**
	 * @param Asset|null $image
	 *
	 * @return \Twig_Markup|string
	 * @throws \yii\base\Exception
	 */
	public function twitterImage ($image)
	{
		return $this->_socialImage($image, [
			'width'  => 1200,
			'height' => 675,
		]);
	}

	/**
	 * @param Asset|null $image
	 *
	 * @return \Twig_Markup|string
	 * @throws \yii\base\Exception
	 */
	public function facebookImage ($image)
	{
		return $this->_socialImage($image, [
			'width'  => 1200,
			'height' => 600,
		]);
	}

	/**
	 * @param Asset|null $image
	 * @param array      $transform
	 *
	 * @return \Twig_Markup|string
	 * @throws \yii\base\Exception
	 */
	private function _socialImage ($image, array $transform)
	{
		if (!$image) return '';

		$transformUrl = $image->getUrl($transform);

		if ($transformUrl === null)
			return '';

		if ($transformUrl && strpos($transformUrl, 'http') === false)
			$transformUrl = UrlHelper::urlWithScheme($transformUrl, (\Craft::$app->getRequest()->getIsSecureConnection()? 'https': 'http'));

		return Template::raw($transformUrl);
	}

}
