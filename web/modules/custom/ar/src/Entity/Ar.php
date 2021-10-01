<?php

namespace Drupal\ar\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;

/**
 * Defines the ar entity.
 *
 * @ingroup ar
 *
 * @ContentEntityType(
 *   id = "ar",
 *   label = @Translation("Ar"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ar\ArListBuilders",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\ar\Form\ArForm",
 *       "edit" = "Drupal\ar\Form\ArForm",
 *       "delete" = "Drupal\ar\Form\ArDeleteForm",
 *     },
 *     "access" = "Drupal\ar\ArAccessControlHandler",
 *   },
 *   base_table = "ar",
 *   admin_permission = "administer review entity",
 *   fieldable = TRUE,
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "label" = "name_user",
 *   },
 *   links = {
 *     "full" = "/ar",
 *     "canonical" = "/ar/{ar}",
 *     "edit-form" = "/ar/{ar}/edit",
 *     "delete-form" = "/ar/{ar}/delete",
 *     "collection" = "/ar/list"
 *   },
 *   field_ui_base_route = "ar.review_settings",
 * )
 */
class Ar extends ContentEntityBase implements ContentEntityInterface {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Ar entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Ar entity.'))
      ->setReadOnly(TRUE);

    $fields['name_user'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Your name'))
      ->setDescription(t('The length of the name is 2-100 letters'))
      ->setSettings([
        'default_value' => '',
        'max_length' => '100',
        'text_processing' => 0,
      ])
      ->setPropertyConstraints('value', [
        'Length' => [
          'min' => 2,
          'minMessage' => t('Your name is too short. Please enter a full name'),
        ],
      ])
      ->setRequired(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => '-25',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['email_user'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Your email'))
      ->setDescription(t('Email should look like this: example@mail.com'))
      ->setSettings([
        'default_value' => '',
        'max_length' => '225',
        'text_processing' => 0,
      ])
      ->setPropertyConstraints('value', [
        'Regex' => [
          'pattern' => '/^[0-9A-Za-z._-]+@[0-9A-Za-z.-]+\.[A-Za-z]{2,6}$/',
          'message' => t('Email should look like this: example@mail.com'),
        ],
      ])
      ->setRequired(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'email_mailto',
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => '-15',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['phone_user'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Your phone'))
      ->setDescription(t('Phone should look like this: +380(99)9999999'))
      ->setSettings([
        'default_value' => '0',
        'max_length' => '15',
        'text_processing' => 0,
      ])
      ->setPropertyConstraints('value', [
        'Regex' => [
          'pattern' => '/^\+[0-9]{10,14}$/',
          'message' => t('Phone should look like this: +380(99)9999999'),
        ],
      ])
      ->setRequired(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'telephone_link',
      ])
      ->setDisplayOptions('form', [
        'type' => 'telephone_default',
        'weight' => '-5',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['message_user'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Your message'))
      ->setDescription(t('The message of the user'))
      ->setSettings([
        'default_value' => '0',
        'text_processing' => 0,
      ])
      ->setPropertyConstraints('value', [
        'Length' => [
          'max' => '5000',
        ],
      ])
      ->setRequired(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string_textarea',
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['avatar_user'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Your avatar'))
      ->setDescription(t('Avatar should be less than 2 MB and in JPEG, JPG or PNG format.'))
      ->setSettings([
        'file_directory' => 'images/avatar/',
        'alt_field_required' => FALSE,
        'alt_field' => FALSE,
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => 2097152,
        'default_value' => NULL,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'default',
      ])
      ->setDisplayOptions('form', [
        'label' => 'hidden',
        'type' => 'image_image',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['image_user'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Your image'))
      ->setDescription(t('Image should be less than 5 MB and in JPEG, JPG or PNG format.'))
      ->setSettings([
        'file_directory' => 'images/image/',
        'alt_field_required' => FALSE,
        'alt_field' => FALSE,
        'alt_default' => t('User avatar'),
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => 5242880,
        'default_value' => NULL,
        'default_alt' => t('User avatar'),
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'default',
      ])
      ->setDisplayOptions('form', [
        'label' => 'hidden',
        'type' => 'image_image',
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'))
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'datetime_custom',
        'settings' => [
          'data_format' => 'm/j/Y H:i:s',
        ],
      ]);

    return $fields;
  }

  /**
   * Get username.
   */
  public function getUserName() {
    return $this->get('name_user')->value;
  }

  /**
   * Set username.
   *
   * @return $this
   */
  public function setUserName($name_user) {
    return $this->set('name_user', $name_user);
  }

  /**
   * Get user email.
   */
  public function getUserEmail() {
    return $this->get('email_user')->value;
  }

  /**
   * Set user email.
   *
   * @return $this
   */
  public function setUserEmail($email_user) {
    return $this->set('email_user', $email_user);
  }

  /**
   * Get user phone.
   */
  public function getUserPhone() {
    return $this->get('phone_user')->value;
  }

  /**
   * Set user phone.
   *
   * @return $this
   */
  public function setUserPhone($phone_user) {
    return $this->set('phone_user', $phone_user);
  }

  /**
   * Get user message.
   */
  public function getUserMessage() {
    return $this->get('message_user')->value;
  }

  /**
   * Set user message.
   *
   * @return $this
   */
  public function setUserMessage($message_user) {
    return $this->set('message_user', $message_user);
  }

  /**
   * Get fid avatar.
   */
  public function getFidAvatar() {
    return $this->get('avatar_user')->value;
  }

  /**
   * Set fid avatar.
   *
   * @return $this
   */
  public function setFidAvatar($avatar_user) {
    return $this->set('avatar_user', $avatar_user);
  }

  /**
   * Get fid image.
   */
  public function getFidImage() {
    return $this->get('image_user')->value;
  }

  /**
   * Set fid image.
   *
   * @return $this
   */
  public function setFidImage($image_user) {
    return $this->set('image_user', $image_user);
  }

  /**
   * Get creation time.
   */
  public function getCreationTime() {
    return $this->get('created')->value;
  }

  /**
   * Set creation time.
   *
   * @return $this
   */
  public function setCreationTime($phone_user) {
    return $this->set('created', $phone_user);
  }

  /**
   * Get default avatar.
   */
  public function getDefaultAvatar() {
    return [
      '#theme' => 'image',
      '#uri' => '/modules/custom/ar/files/default_ava.png',
      '#alt' => t('Default user avatar'),
      '#attributes' => [
        'styles' => 'width: 150px',
      ],
    ];
  }

}
