<?php

namespace Drupal\guest_book\Entity;

use Drupal\Core\Entity\Annotation\ContentEntityType;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\user\EntityOwnerInterface;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the GuestBook entity.
 *
 * @ingroup guest_book
 *
 * @ContentEntityType(
 *   id = "guest_book",
 *   label = @Translation ("Guest book"),
 *   base_table = "guest_book",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "label" = "title",
 *     "owner" = "author",
 *     "published" = "published",
 *   },
 *   handlers = {
 *     "access" = "Drupal\guest_book\EntityAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\Core\Entity\ContentEntityForm",
 *       "edit" = "Drupal\Core\Entity\ContentEntityForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "permission_provider" = "Drupal\guest_book\EntityPermissionProvider",
 *     "route_provider" = {
 *       "default" = "Drupal\guest_book\Routing\DefaultHtmlRouterProvider",
 *     },
 *   },
 *   links = {
 *     "cannonical" = "/guest_book/{guest_book}",
 *     "add-form" = "/admin/content/guest_book/add",
 *     "edit-form" = "/admin/content/guest_book/manage/{guest_book}",
 *     "delete-form" = "/admin/content/guest_book/manage/{guest_book}/delete",
 *   },
 *   admin_permission = "administer event"
 * )
 */
class GuestBook extends ContentEntityBase implements EntityOwnerInterface, EntityPublishedInterface {
  use EntityOwnerTrait, EntityPublishedTrait;

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    // Get the field definitions for 'id' and 'uuid' from the parent.
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name_user'] = BaseFieldDefinition::create('string')
      ->setLabel(t('User name'))
      ->setRequired(TRUE);

    $fields['email_user'] = BaseFieldDefinition::create('string')
      ->setLabel(t('User email'))
      ->setRequired(TRUE);

    $fields['phone_user'] = BaseFieldDefinition::create('int')
      ->setLabel(t('User phone'))
      ->setRequired(TRUE);

    $fields['message_user'] = BaseFieldDefinition::create('string')
      ->setLabel(t('User message'))
      ->setRequired(TRUE);

    $fields['fid_avatar'] = BaseFieldDefinition::create('int')
      ->setLabel(t('fid avatar'))
      ->setRequired(FALSE);

    $fields['fid_image'] = BaseFieldDefinition::create('int')
      ->setLabel(t('fid image'))
      ->setRequired(FALSE);

    $fields['time_user'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Time'))
      ->setRequired(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'inline',
        'settings' => [
          'format_type' => 'html_date',
        ],
        'weight' => 0,
      ]);

    // Get the field definitions for 'owner' and 'published' from the traits.
    $fields += static::ownerBaseFieldDefinitions($entity_type);
    $fields += static::publishedBaseFieldDefinitions($entity_type);

    $fields['published']->setDisplayOptions('form', [
      'settings' => [
        'display_label' => TRUE,
      ],
      'weight' => 30,
    ]);

    return $fields;
  }

  /**
   * Get user name.
   */
  public function getUserName() {
    return $this->get('name_user')->value;
  }

  /**
   * Set user name.
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
    return $this->get('fid_avatar')->value;
  }

  /**
   * Set fid avatar.
   *
   * @return $this
   */
  public function setFidAvatar($fid_avatar) {
    return $this->set('fid_avatar', $fid_avatar);
  }

  /**
   * Get fid image.
   */
  public function getFidImage() {
    return $this->get('fid_image')->value;
  }

  /**
   * Set fid image.
   *
   * @return $this
   */
  public function setFidImage($fid_image) {
    return $this->set('fid_image', $fid_image);
  }

  /**
   * Get time created.
   */
  public function getUserTime() {
    return $this->get('time_user')->date;
  }

  /**
   * Set time created.
   *
   * @return $this
   */
  public function setUserTime(DrupalDateTime $time_user) {
    return $this->set('time_user', $time_user->format("d/m/Y H:i:s"));
  }

}
