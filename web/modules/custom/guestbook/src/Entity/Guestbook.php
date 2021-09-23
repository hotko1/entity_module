<?php

namespace Drupal\guestbook\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\guests_book\ReviewInterface;
use Drupal\user\UserInterface;

/**
 * Defines the guestbook entity.
 *
 * @ingroup guestbook
 *
 * @ContentEntityType(
 *   id = "guestbook",
 *   label = @Translation("Guestbook"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\guestbook\GuestbookListBuilders",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\guestbook\Form\GuestbookForm",
 *       "edit" = "Drupal\guestbook\Form\GuestbookForm",
 *       "delete" = "Drupal\guestbook\Form\GuestbookDeleteForm",
 *     },
 *     "access" = "Drupal\guestbook\GuestbookAccessControlHandler",
 *   },
 *   base_table = "guestbook",
 *   admin_permission = "administer review entity",
 *   fieldable = TRUE,
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *   },
 *   links = {
 *     "canonical" = "/guestbook/{guestbook}",
 *     "edit-form" = "/guestbook/{guestbook}/edit",
 *     "delete-form" = "/guestbook/{guestbook}/delete",
 *     "collection" = "/guestbook/list"
 *   },
 *   field_ui_base_route = "guests_book.review_settings",
 * )
 */
class Guestbook extends ContentEntityBase implements ContentEntityInterface {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // Standard field, used as unique if primary index.
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Guestbook entity.'))
      ->setReadOnly(TRUE);

    // Standard field, unique outside of the scope of the current project.
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Guestbook entity.'))
      ->setReadOnly(TRUE);

    $fields['name_user'] = BaseFieldDefinition::create('string')
      ->setLabel(t('User name'))
      ->setDescription(t('The name of the user'))
      ->setSettings([
        'default_value' => '',
        'max_length' => '225',
        'text_processing' => 0,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['email_user'] = BaseFieldDefinition::create('string')
      ->setLabel(t('User email'))
      ->setDescription(t('The email of the user'))
      ->setSettings([
        'default_value' => '',
        'max_length' => '225',
        'text_processing' => 0,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['phone_user'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('User phone'))
      ->setDescription(t('The phone of the user'))
      ->setSettings([
        'default_value' => '0',
        'max_length' => '225',
        'text_processing' => 0,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'int',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['message_user'] = BaseFieldDefinition::create('string')
      ->setLabel(t('User message'))
      ->setDescription(t('The message of the user'))
      ->setSettings([
        'default_value' => '0',
        'max_length' => '5000',
        'text_processing' => 0,
      ])
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -6,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['avatar_user'] = BaseFieldDefinition::create('image')
      ->setLabel(t('User avatar'))
      ->setDescription(t('The avatar of the user'))
      ->setSettings([
        'file_directory' => 'images/avatar/',
        'alt_field_required' => TRUE,
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => 2097152,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'default',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'label' => 'hidden',
        'type' => 'image_image',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['image_user'] = BaseFieldDefinition::create('image')
      ->setLabel(t('User image'))
      ->setDescription(t('The image of the user'))
      ->setSettings([
        'file_directory' => 'images/image/',
        'alt_field_required' => TRUE,
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => 5242880,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'default',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'label' => 'hidden',
        'type' => 'image_image',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

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

}
