<?php
/**
 * @file
 * Containt Drupal\rsvplist\Controller
 */

 namespace Drupal\rsvplist\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;

/**
 * Controller for RSVP report
 */

class ReportController extends ControllerBase{
  /**
    * Get RSVP for all nodes.
    * @return array
    */
    protected function load(){
      $select = Database::getConnection()->select('rsvplist','r');
        //join the users table, so we can get the entry creators user name
        $select->join('users_field_data', 'u', 'r.uid = u.uid');
        //join the node table, so we can get the event's name
        $select->join('node_field_data', 'n', 'r.nid = n.nid');
        //select these specific fields for the output.
        $select->addField('u','name','username');
        $select->addField('n', 'title');
        $select->addField('r', 'mail');
        $entries = $select->execute()->fetchAll(\PDO::FETCH_ASSOC);
        return $entries;
    }

    /**
     * Create the report page.
     * 
     * @return array
     * Render array for report output
     */
    public function Report(){
      $content = array();
      $content['message'] = array(
        '#markup' => $this->t('Below is the list of all Events RSVPs including username,email address and the name of the event they will be attending'),
      );
      $headers = array(
        t('Name'),
        t('Event'),
        t('Email'),
      );
      $rows = array();
      foreach($entries = $this->load() as $entry){
        //sanitize each entry
        $rows[] = array_map('Drupal\Component\Utility\SafeMarkup::checkPlain', $entry);
      }
      $content['table'] = array(
        '#type' => 'table',
        '#header' => $headers,
        '#rows' => $rows,
        '#empty' => t('no entries available')
      );
      //do not cache this page
      $content['#cache']['max-age'] = 0;
      return $content;
    }
}