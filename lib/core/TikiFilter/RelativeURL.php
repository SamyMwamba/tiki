<?php
// (c) Copyright 2002-2017 by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

/**
 * Class TikiFilter_RelativeURL
 *
 * Filters for valid relative url's, and strips any tags.
 */
class TikiFilter_RelativeURL implements Zend\Filter\FilterInterface
{
	/**
	 *
	 * @param string $input		Absolute or relative url.
	 * @return string			Absolute URL components stripped out.
	 */


	function filter($input)
	{

		$filter = new Zend\Filter\StripTags();
		$url =  $filter->filter($input);

		$url = Zend\Uri\UriFactory::factory($url);

		$query = $url->getQuery();
		$url = $url->getPath();

		if ($query)
			$url .= '?'.$query;

		return $url;

	}
}
