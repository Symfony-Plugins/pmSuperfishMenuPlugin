<?php

/**
 * Represents the Composite in the Composite pattern.
 * Represents a menu and all it's children.
 *
 * @author Patricio Mac Adden <pmacadden@cespi.unlp.edu.ar>
 */
class pmSuperfishMenu extends pmSuperfishMenuComponent
{
  /**
   * The composite children.
   * @var array
   */
  protected $children;
  
  /**
   * Indicates if the composite is a root.
   * @var boolean
   */
  protected $is_root;
  
  /**
   * The superfish initialization code.
   * It's used only if the composite is a root.
   * @var string
   */
  protected $superfish_js;
  
  /**
   * Constructor.
   */
  public function __construct()
  {
    parent::__construct();
    
    $this->children = array();
    $this->is_root = false;
    $this->superfish_js = "jQuery(function(){jQuery('ul.sf-menu').superfish();});";
  }
  
  /**
	 * Create an instance of pmSuperfishMenu from a yaml file.
	 * 
	 * @param string $yaml_file The yaml file path
	 * @return pmSuperfishMenu
	 */
  public static function createFromYaml($yaml_file)
  {
    $yaml = sfYaml::load($yaml_file);
    
    $root = new pmSuperfishMenu();
    $root->setRoot();
    
    $yaml = array_pop($yaml);
    
    foreach ($yaml as $name => $arr_menu)
    {
      $item = self::createMenu($arr_menu);
      $root->addChild($name, $item);
    }
    
    return $root;
  }
  
  /**
	 * Create a submenu from an array.
	 * 
	 * @param array $arr The array
	 * @return pmSuperfishMenuComponent
	 */
  protected static function createMenu($arr)
  {
    $item = null;
    if (array_key_exists("menu", $arr))
    {
      $item = new pmSuperfishMenu();
      foreach ($arr["menu"] as $name => $submenu)
      {
        $sitem = self::createMenu($submenu);
        $item->addChild($name, $sitem);
      }
    }
    else
    {
      $item = new pmSuperfishMenuItem();
    }
    if (array_key_exists("credentials", $arr)) $item->setCredentials($arr["credentials"]);
    if (array_key_exists("name", $arr)) $item->setName($arr["name"]);
    if (array_key_exists("url", $arr)) $item->setUrl($arr["url"]);
    
    return $item;
  }
  
  /**
	 * Get the children attribute value.
	 * 
	 * @return array
	 */
  public function getChildren()
  {
    return $this->children;
  }
  
  /**
	 * Get a child.
	 *
	 * @param string $name The child name
	 * @return mixed
	 */
  public function getChild($name)
  {
    $child = null;
    
    if (isset($this->children[$name]))
    {
      $child = $this->children[$name];
    }
    
    return $child;
  }

  /**
	 * Adds a child.
	 *
	 * @param string $name The child name
	 * @param pmSuperfishMenuComponent $component The child
	 * @return pmSuperfishMenu The current object (for fluent API support)
	 */
  public function addChild($name, pmSuperfishMenuComponent $component)
  {
    $this->children[$name] = $component;
    
    return $this;
  }
  
  /**
	 * Removes a child.
	 *
	 * @param string $name The child name
	 * @return pmSuperfishMenu The current object (for fluent API support)
	 */
  public function removeChild($name)
  {
    unset($this->children[$name]);
    
    return $this;
  }

  /**
	 * Set the current object as the root.
	 * 
	 * @return pmSuperfishMenu The current object (for fluent API support)
	 */
  public function setRoot()
  {
    $this->is_root = true;
    
    return $this;
  }
  
  /**
	 * Unset the current object as the root.
	 * 
	 * @return pmSuperfishMenu (for fluent API support)
	 */
  public function unsetRoot()
  {
    $this->is_root = false;
    
    return $this;
  }
  
  /**
	 * Returns if the current object is the root.
	 * 
	 * @return boolean
	 */
  public function isRoot()
  {
    return $this->is_root;
  }
  
  /**
	 * Set the value of superfish_js attribute.
	 * 
	 * @param string $v The new superfish initialization code.
	 * @return pmSuperfishMenu The current object (for fluent API support)
	 */
  public function setSuperfishJS($v)
  {
    $this->superfish_js = $v;
    
    return $this;
  }
  
  /**
	 * Get the superfish_js attribute value.
	 * 
	 * @return string
	 */
  public function getSuperfishJS()
  {
    return $this->superfish_js;
  }
  
  /**
   * Renders the pmSuperfishMenu.
   *
   * @return string
   */
  public function render()
  {
    $context = sfContext::getInstance();
    $context->getConfiguration()->loadHelpers(array("I18N", "Url"));
    
    $url = $this->getUrl() ? url_for($this->getUrl()) : "";
    $name = __($this->getName());
    $has_credentials = $context->getUser()->hasCredential($this->getCredentials());
    
    if ($has_credentials)
    {
      $str = $this->isRoot() ? "<ul class=\"sf-menu\">" : "<li><a href=\"$url\">$name</a><ul>";
    
      foreach ($this->getChildren() as $child)
      {
        $str .= $child->render();
      }
    
      $str .= $this->isRoot() ? "</ul><script>{$this->getSuperfishJS()}</script>" : "</ul></li>";
      
      return $str;
    }
    else
    {
      return "";
    }
  }
}