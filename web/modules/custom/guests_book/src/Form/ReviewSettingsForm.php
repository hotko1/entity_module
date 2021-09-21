<?php

namespace Drupal\guests_book\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class GuestsBookSettingsForm.
 *
 * @package Drupal\guests_book\Form
 * @ingroup guests_book
 */
class ReviewSettingsForm extends FormBase {

  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'guests_book_settings';
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   An associative array containing the current of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Empty implement of the abstract submit class.
  }

  /**
   * Define the form used for GuestsBook settings.
   *
   * @return array
   *   Form definition array.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   An associative array containing the current of the form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['review_settings']['#markup'] = 'Settings form for GuestsBook. Manage field settings here.';
    return $form;
  }

}
