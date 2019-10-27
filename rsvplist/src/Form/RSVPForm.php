<?php
/**
  * @file
  * Contains \Drupal\rsvplist\Form\RSVPForm
  */

namespace Drupal\rsvplist\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
  * Provides an RSVP email form
  */

class RSVPForm extends FormBase{
  
  /**
    * (@inheritdoc)
    */
  public function getFormId(){
    //unique id of the form
    return 'rsvplist_email_form';
  }

  /**
    * (@inheritdoc)
    */
  public function buildForm(array $form, FormStateInterface $form_state){
    $node = \Drupal::routeMatch()->getParameter('node');
    $nid = $node->nid->value;
    $form['email'] = array(
      '#title'=> t('Email Address'),
      '#type' => 'textfield',
      '#size' => 25,
      'description' => t('We will send update to the email address you provide'),
      'require' => true,
    ); 
    //submit button
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('RSVP'),
    );
    //node id in hidden field
    $form['nid'] = array(
      '#type' => hidden,
      '#value' => $nid
    );
    return $form;
  }
  /**
    * (@inheritdoc)
    */
  public function validateForm(array &$form, FormStateInterface $form_state){
    $value = $form_state->getValue('email');
    if($value == !\Drupal::service('email.validator')->isValid($value) || $value == ''){
      $form_state->setErrorByName('email', t('Email address %mail is not valid.', array ('%mail'=>$value)));
      return;
    }
    $node = \Drupal::routeMatch()->getParameter('node');
    //check email already set for this node
    $select = Database::getConnection()->selecct('rsvplist','r');
    $select->field('r',array('nid'));
    $select->condition('nid', $node->id());
    $select->condition('mail',$value);
    $results = $select->execute();
    if(!empty($results->fetchCol())){
      //we found the row with node id and email
      $form_state->setErrorByName('email',t('The address %mail is already subscribed to this list.', array('%mail' => value )));
    }
  }
  /**
    * (@inheritdoc)
    */
  public function submitForm(array &$form, FormStateInterface $form_state){
    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    db_insert('rsvplist')->fields(
      array(
        'mail' => $form_state->getValue('email'),
        'nid'  => $form_state->getValue('nid'),
        'uid'  => $user->id(),
        'created' => time(),
      )
    )
    ->execute();
    drupal_set_message(t('Thank you for your RSVP. You are on the list for the event'));
  }

}