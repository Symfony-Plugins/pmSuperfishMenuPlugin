<?php

/**
 * Represents the Leaf in the Composite pattern.
 * Represents a menu item.
 *
 * @author Patricio Mac Adden <pmacadden@cespi.unlp.edu.ar>
 */
class pmSuperfishMenuItem extends pmSuperfishMenuComponent
{
  /**
   * Renders the pmSuperfishMenuItem.
   *
   * @return string
   */
  public function render()
  {
    $context = sfContext::getInstance();
    $context->getConfiguration()->loadHelpers(array("I18N", "Url"));
    
    $url = url_for($this->getUrl());
    $name = __($this->getName());
    $has_credentials = $context->getUser()->hasCredential($this->getCredentials());
    
    return $has_credentials ? "<li><a href=\"$url\">$name</a></li>" : "";
  }
}