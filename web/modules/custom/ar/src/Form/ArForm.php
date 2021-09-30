<?php

namespace Drupal\ar\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Language\Language;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\HtmlCommand;

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

    $form['name_message'] = [
      '#markup' => '<div class="result_message name-result_message"></div>',
      '#weight' => '-30',
    ];
    $form['name_user']['widget'][0]['value']['#ajax'] = [
      'callback' => '::nameValidateCallback',
      'disable-refocus' => TRUE,
      'event' => 'change',
      'progress' => [
        'type' => 'none',
      ],
    ];

    $form['email_message'] = [
      '#markup' => '<div class="result_message email-result_message"></div>',
      '#weight' => '-20',
    ];
    $form['email_user']['widget'][0]['value']['#ajax'] = [
      'callback' => '::mailValidateCallback',
      'disable-refocus' => TRUE,
      'event' => 'change',
      'progress' => [
        'type' => 'none',
      ],
    ];

    $form['phone_message'] = [
      '#markup' => '<div class="result_message phone-result_message"></div>',
      '#weight' => '-10',
    ];
    $form['phone_user']['widget'][0]['value']['#ajax'] = [
      'callback' => '::phoneValidateCallback',
      'disable-refocus' => TRUE,
      'event' => 'change',
      'progress' => [
        'type' => 'none',
      ],
    ];

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
   * Ajax name validation.
   */
  public function nameValidateCallback(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    if (!preg_match('/^[a-zA-Z]{2,100}$/', $form_state->getValue('name_user')[0]['value'])) {
      $response->addCommand(
        new HtmlCommand(
          '.name-result_message',
          '<div class="novalid">' . $this->t('Invalid name.')
        )
      );
    }
    else {
      $response->addCommand(
        new HtmlCommand(
          '.name-result_message',
          NULL
        )
      );
    }

    return $response;
  }

  /**
   * Ajax mail validation.
   */
  public function mailValidateCallback(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    if (!preg_match('/^[0-9A-Za-z._-]+@[0-9A-Za-z.-]+\.[A-Za-z]{2,6}$/', $form_state->getValue('email_user')[0]['value'])) {
      $response->addCommand(
        new HtmlCommand(
          '.email-result_message',
          '<div class="novalid">' . $this->t('Invalid mail.')
        )
      );
    }
    else {
      $response->addCommand(
        new HtmlCommand(
          '.email-result_message',
          NULL
        )
      );
    }

    return $response;
  }

  /**
   * Ajax phone validation.
   */
  public function phoneValidateCallback(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    if (!preg_match('/^\+[0-9]{10,14}$/', $form_state->getValue('phone_user')[0]['value'])) {
      $response->addCommand(
        new HtmlCommand(
          '.phone-result_message',
          '<div class="novalid">' . $this->t('Invalid phone.')
        )
      );
    }
    else {
      $response->addCommand(
        new HtmlCommand(
          '.phone-result_message',
          NULL
        )
      );
    }

    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $form = parent::save($form, $form_state);

    $entity = $this->entity;
    if ($form == SAVED_UPDATED) {
      $this->messenger()
        ->addMessage($this->t('The message %feed has been updated.', ['%feed' => $entity->toLink()->toString()]));
    }
    else {
      $this->messenger()
        ->addMessage($this->t('%feed, your message has been added.', ['%feed' => $entity->toLink()->toString()]));
    }

    $form_state->setRedirectUrl($this->entity->toUrl('full'));
    return $form;
  }

}
