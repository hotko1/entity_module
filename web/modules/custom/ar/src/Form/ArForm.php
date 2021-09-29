<?php

namespace Drupal\ar\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Language\Language;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the ar entity edit forms.
 */
class ArForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\ar\Entity\Ar $entity */
    $form = parent::buildForm($form, $form_state);
//    $entity = $this->entity;

//    $form['langcode'] = [
//      '#title' => $this->t('langcode'),
//      '#type' => 'language_select',
//      '#default_value' => $entity->getUntranslated()->language()->getId(),
//      '#languages' => Language::STATE_ALL,
//    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $status = parent::save($form, $form_state);

    $entity = $this->entity;
    if ($status == SAVED_UPDATED) {
      $this->messenger()
        ->addMessage($this->t('The message %feed has been updated.', ['%feed' => $entity->toLink()->toString()]));
    }
    else {
      $this->messenger()
        ->addMessage($this->t('%feed, your message has been added.', ['%feed' => $entity->toLink()->toString()]));
    }

    $form_state->setRedirectUrl($this->entity->toUrl('full'));
    return $status;
  }

}
