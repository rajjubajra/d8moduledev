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
  public function submitForm(array &$form, FormStateInterface $form_state){
    drupal_set_message(t('The form is working'));
  }
  
}