<?php
/**
 * multiGuestbook - function.mGB_Form.inc.php
 * @author m[dot]lorch[at]it-kult[dot]de Markus Lorch
 * @package redaxo4
 * @version 0.9.2
 */

	// Function to build the Drop Down to choose current Guestbook
  // onchange="this.form.submit();"
	function mGB_buildGBDropDown($name, $value, $options)
  {
	  $GBooks = new mGB;
    $out = '<p>Bitte erstelle zuerst ein G&auml;stebuch im multiGuestbook Backend! / Pleas install a Guestbook in the multiGuestbook Backend</p>';
    
    if(sizeof($GBooks->getGBooks()) > 0)
    {
      $out = '<select name="'.$name.'" size="1" id="rex-a761-bid" '.$options.'>';

      foreach($GBooks->getGBooks() as $book)
      {
  	    $out .= '<option'.(($book->_id == $value) ? ' selected="selected"' : '').' value="'.$book->_id .'">'.$book->getValue('name').' ['.$book->_id.']</option>';
      }
    
      $out .= '</select>';
    }
    
    return $out;
	}
?>