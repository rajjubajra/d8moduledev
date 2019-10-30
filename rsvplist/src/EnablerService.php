<?php
/**
 * @file
 * Contains Drupal\rsvplist\EnablerService
 */

namespace Drupal\rsvplist;

use Drupal\Core\Database\Database;
use Drupal\node\Entity\Node;

/**
  * Defines a services for manaaging RSVP list eabled for nodes;
  */
class EnablerService{
  /**
   * Constructor
   */
  public function __construct()
  {
  
  }
  
  /**
   * set the individual node to be RSVP enabled
   * 
   * @param \Drupal\node\Entity\Node $node
   */ 
  public function setEnabled(Node $node){
    if(!$this->isEnabled($node)){
      $insert = Database::getConnection()->insert('rsvplist_enabled');
      $insert->fields(array('nid'), array($node->id()));
      $insert->execute();
    }
  }
  /**
   * check if an individual node is RSVP enabled
   * 
   * @param \Drupal\node\Entity\Node $node
   * 
   * @return bool
   * Whether node is enabled for the RSVP functionality.
   * 
   */
  public function isEnabled(Node $node){
    if($node->isNew()){
      return FALSE;
    }
    $select = Database::getConnection()->select('rsvplist_enabled', 're');
    $select->fields('re',array('nid'));
    $select->condition('nid', $node->id());
    $results =  $select->execute();
    return !empty($results->fetchCol());
  }
  /**
   * Deletes nabled settings for an individual node
   * 
   * @param \Drupal\node\Entity\Node $node
   */
  public function delEabled(Node $node){
    $delete = Database::getConnection()->delete('rsvplist_enabled');
    $delete->condition('nid', $node->id());
    $delete->exeucte();
  }


}
