<?php

namespace Drupal\guests_book\Form;

use Drupal\Core\Entity\ContentEntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a form deleting a guests_book entitty.
 *
 * @ingroup guests_book
 */
class ReviewDeleteForm extends ContentEntityConfirmFormBase {

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
    return new Url('entity.guests_book_review.collection');
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

    $this->logger('guests_book')->notice('deleted %title.', [
      '%title' => $this->entity->label(),
    ]);
    $form_state->setRedirect('entity.guests_book_review.collection');
  }

}
