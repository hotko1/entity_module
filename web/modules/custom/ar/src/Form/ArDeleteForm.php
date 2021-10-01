<?php

namespace Drupal\ar\Form;

use Drupal\Core\Entity\ContentEntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a form deleting a ar entity.
 *
 * @ingroup ar
 */
class ArDeleteForm extends ContentEntityConfirmFormBase {

  /**
   * Returns the question to ask the user.
   *
   * @return string
   *   The form question. The page title will be set to this value.
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete %name?', [
      '%name' => $this->entity->label(),
    ]);
  }

  /**
   * Returns the route to go to if the user cancels the action.
   *
   * @return \Drupal\Core\Url|void
   *   A URL object.
   */
  public function getCancelUrl() {
    return new Url('entity.ar.collection');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   * {@inheritdoc}
   *
   * Delete entity and log the event. logger() the watchdog.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $entity = $this->getEntity();
    $entity->delete();

    $this->logger('guestbook')->notice('deleted %title.', [
      '%title' => $this->entity->label(),
    ]);
    $form_state->setRedirect('entity.ar.full');
  }

}
