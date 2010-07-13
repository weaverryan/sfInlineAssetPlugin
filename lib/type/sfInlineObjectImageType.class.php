<?php

/**
 * Inline object type for handling assets
 * 
 * @package     snow
 * @subpackage  
 * @author      Ryan Weaver <ryan.weaver@iostudio.com>
 * @copyright   Iostudio, LLC 2010
 * @since       2010-06-08
 * @version     svn:$Id$ $Author$
 */
class sfInlineObjectImageType extends sfInlineObjectType
{
  /**
   * @see sfInlineObjectType
   * @return string
   */
  public function render($name, $arguments)
  {
    sfApplicationConfiguration::getActive()->loadHelpers(array('Asset', 'Tag', 'Url'));

    $format = isset($arguments['format']) ? $arguments['format'] : null;
    $link = isset($arguments['link']) ? $arguments['link'] : false;
    unset(
      $arguments['format'],
      $arguments['link']
    );

    $attrs = InlineObjectToolkit::arrayToAttributes($arguments);

    /**
     * @todo If sfImageTransformExtraPlugin is present, use the format option
     */
    $img =  image_tag($this->getWebPath($name), $attrs);

    if ($link)
    {
      // render the image with a link around it - the link has a set of attributes
      $linkAttrs = sfConfig::get('app_inline_asset_link_attributes', array());
      $linkAttrs['href'] = public_path($this->getWebPath($name));

      return content_tag('a', $img, $linkAttrs);
    }
    else
    {
      return $img;
    }
  }

  /**
   * Returns the absolute path to the given image
   *
   * @return string
   */
  public function getFilenamePath($name)
  {
    return sfConfig::get('sf_uploads_dir').'/'.$name;
  }

  /**
   * Returns web-path to the given image
   *
   * @return string
   */
  public function getWebPath($name)
  {
    return '/uploads/'.$name;
  }
}