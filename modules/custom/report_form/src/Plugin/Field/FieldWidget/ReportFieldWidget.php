<?php

namespace Drupal\report_form\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;


/**
 * Plugin implementation of the 'report_field_widget' widget.
 *
 * @FieldWidget(
 *   id = "report_field_widget",
 *   label = @Translation("Report field widget"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class ReportFieldWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
        'size' => 60,
        'placeholder' => '',
      ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    $elements['size'] = [
      '#type' => 'number',
      '#title' => t('Size of textfield'),
      '#default_value' => $this->getSetting('size'),
      '#required' => TRUE,
      '#min' => 1,
    ];
    $elements['placeholder'] = [
      '#type' => 'textfield',
      '#title' => t('Placeholder'),
      '#default_value' => $this->getSetting('placeholder'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    //    $summary[] = t('Textfield size: @size', ['@size' => $this->getSetting('size')]);
    //    if (!empty($this->getSetting('placeholder'))) {
    //      $summary[] = t('Placeholder: @placeholder', ['@placeholder' => $this->getSetting('placeholder')]);
    //    }

    return $summary;
  }

  /**
   * {@inheritdoc}.
   */
  public function getUserArray() {


    $ids = \Drupal::entityQuery('user')
      ->condition('status', 1)
      ->execute();

    if (empty($ids)) {
      return FALSE;
    }

    $users = User::loadMultiple($ids);
    $userList = [];
    foreach ($users as $key => $user) {
      if (!empty($user->user_picture) && $user->user_picture->isEmpty() === FALSE) {
        $image = $user->get('user_picture')->entity->url();
        $name = $user->name->value;
        $mail = $user->mail->value;
        $userList['options'][$key] = '<b>' . $name . '</b><div>' . $mail . '</div>';
        $userList['attributes'][$key] = ['data-image' => $image];
      }
    }
    return $userList;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $node = \Drupal::routeMatch()->getParameter('node');
    $target_id = isset($node) ? $node->get('field_reporter')->getValue() : 0;
    kint($target_id);



    $userList = $this->getUserArray();
    $options = isset($userList) ? $userList['options'] : [];
    $attributes = isset($userList) ? $userList['attributes'] : [];

    $element['reporter'] = $element +[
      '#type' => 'select',
      '#title' => t('Reporter'),
      '#empty_option' => $this->t('Select Reporter'),
      '#options' => $options,
      '#options_attributes' => $attributes,
      '#attributes' => [
        'class' => [
          'reporter-list',
        ],
      ],
        '#default_value' => $target_id,


    ];

    return $element;
  }

  /**
   * Form widget process callback.
   */
//  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
//    foreach ($values as $key => $value) {
//      $values[$key]['reporter'] = $value['reporter']['value'];
//    }
//    return $values;
//  }

}
