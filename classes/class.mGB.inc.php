<?php
/**
 * multiGuestbook - mGBAddon Class
 * @author m[dot]lorch[at]it-kult[dot]de Markus Lorch
 * @package redaxo4
 * @version 0.9.2
 */
 
class mGB
{
  var $_sqlSelect = '';
  var $_sqlIndex = '';
  var $SQL;
  
  function mGB()
  {
    $this->SQL = new rex_sql;
  }
  
  /**
   * Reutrns Database Field
   */  
  function getValue($value)
  {
    global $REX;
    
    $this->SQL->setQuery('SELECT * FROM `'.$REX['TABLE_PREFIX'].$this->_sqlTable.'` WHERE ('.$this->_sqlIndex.'='.$this->_id.') LIMIT 1');
    return $this->SQL->getValue($value);
  }
  
  function getEntriesSelect($table, $select = "*")
  {
    global $REX;
  
    $query = 'SELECT '.$select.' FROM `'.$REX['TABLE_PREFIX'].$table.'` WHERE ('.$this->_sqlIndex.'='.$this->_id.') ';
    
    if($this->_clang !== FALSE)
      $query .= 'AND (clang = '.$this->_clang.') ';
      
    if($this->_show_offline === FALSE)
      $query .= 'AND (offline = 0) ';
      
    if($this->_sort_order == 'ASC' || $this->_sort_order == 'DESC')
      $query .= 'ORDER BY createdate '.$this->_sort_order.' ';
      
    return $query;
  }
  
  function getGBooks()
  {
    global $REX;
  
    $this->SQL->setQuery('SELECT bid FROM `'.$REX['TABLE_PREFIX'].'761_mGB_Books`');

    for($i = 0; $i < $this->SQL->getRows(); $i++)
    {
      $books[] = new mGB_Book($this->SQL->getValue('bid'));
      $this->SQL->next();
    }    
  
    return $books;
  }  
}  
?>