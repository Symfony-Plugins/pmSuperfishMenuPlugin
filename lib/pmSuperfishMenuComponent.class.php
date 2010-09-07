<?php

/**
 * Abstract class that represents the Component in the Composite pattern.
 * Provides the basic functionality of Composite and Leaf objects.
 *
 * @author Patricio Mac Adden <pmacadden@cespi.unlp.edu.ar>
 */
abstract class pmSuperfishMenuComponent
{
  /**
   * The credentials.
   * Just authenticated users that has these credentials should
   * be able to use this component.
   * @var array
   */
  protected $credentials;
  
  /**
   * The component name.
   * If the component is a leaf (pmSuperfishMenuItem), the name represents
   * the link label.
   * If the component is a composite (pmSuperfishMenu), the name represents
   * the group label.
   * @var string
   */
  protected $name;
  
  /**
   * The component link.
   * If the component is a leaf (pmSuperfishMenuItem), the name represents
   * the link href.
   * If the component is a composite (pmSuperfishMenu), the name represents
   * the group href.
   * @var string
   */
  protected $url;
  
  /**
   * Constructor.
   */
  public function __construct()
  {
    $this->credentials = array();
    $this->name = "";
    $this->url = "";
  }
  
  /**
   * Renders the component.
   *
   * @return string
   */
  abstract public function render();
  
  /**
	 * Set the value of credentials attribute.
	 * 
	 * @param array $v The credentials array
	 * @return pmSuperfishMenuComponent The current object (for fluent API support)
	 */
  public function setCredentials($v)
  {
    $this->credentials = $v;
    
    return $this;
  }

  /**
	 * Get the credentials attribute value.
	 * 
	 * @return string
	 */
  public function getCredentials()
  {
    return $this->credentials;
  }
  
  /**
	 * Set the value of name attribute.
	 * 
	 * @param string $v The new name
	 * @return pmSuperfishMenuComponent The current object (for fluent API support)
	 */
  public function setName($v)
  {
    $this->name = $v;
    
    return $this;
  }

  /**
	 * Get the name attribute value.
	 * 
	 * @return string
	 */
  public function getName()
  {
    return $this->name;
  }
  
  /**
	 * Set the value of url attribute.
	 * 
	 * @param string $v The new url
	 * @return pmSuperfishMenuComponent The current object (for fluent API support)
	 */
  public function setUrl($v)
  {
    $this->url = $v;
    
    return $this;
  }
  
  /**
	 * Get the url attribute value.
	 * 
	 * @return string
	 */
  public function getUrl()
  {
    return $this->url;
  }
}