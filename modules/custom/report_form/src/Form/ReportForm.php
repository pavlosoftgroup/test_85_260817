<?php
/**
 * @file
 * Contains \Drupal\dummy\Form\FormWithModalButton.
 */

namespace Drupal\report_form\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;
use Drupal\node\Entity\Node;


/**
 * Наследуемся от базового класса Form API
 *
 * @see \Drupal\Core\Form\FormBase
 */
class ReportForm extends FormBase {




  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'report_form_custom_form';
  }
  public function myPage() {
    \Drupal::service('page_cache_kill_switch')->trigger();
    return [
      '#markup' => time(),
    ];}

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
  public function buildForm(array $form, FormStateInterface $form_state) {

    $userList = $this->getUserArray();
    $options = isset($userList) ? $userList['options'] : [];
    $attributes = isset($userList) ? $userList['attributes'] : [];

    $form['lang'] = [
      '#type' => 'language_select',
    ];

    $form['reporter'] = [
      '#type' => 'select',
      '#title' => $this->t('Reporter'),
      '#required' => TRUE,
      '#empty_option' => $this->t('Select Reporter'),
      '#options' => $options,
      '#options_attributes' => $attributes,
      '#attributes' => [
        'class' => [
          'reporter-list',
        ],
      ],
    ];
    $form['date'] = [
      '#type' => 'date',
      '#title' => $this->t('Date'),
      '#date_date_format' => 'm/d/Y',
    ];
    $form['description'] = [
      '#type' => 'text_format',
      '#maxlength' => 255,
      '#title' => $this->t('Description'),
      '#format' => 'report',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Отправить форму'),
      '#ajax' => [
        'callback' => 'Drupal\report_form\Form\ReportForm::reportFormCallback',
        'event' => 'click',
        'progress' => [
          'type' => 'throbber',
          'message' => '',
        ],
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }


  /**
   * {@inheritdoc}.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $date = $form_state->getValue('date');

    $dateTime = \DateTime::createFromFormat('m/d/Y',$date);
    $date = $dateTime->format('Y-m-d\TH:i:s');
    $node = Node::create([
      'type' => 'user_report',
      'title' => $form_state->getValue('reporter'),
      'field_reporter' => $form_state->getValue('reporter'),
      'field_report_date' => $date,
      'body' => $form_state->getValue('description'),

    ]);

    $node->save();
    $title = $form_state->getValue('date');
    drupal_set_message(t('Вы ввели: %title.', ['%title' => $title]));
  }

  /**
   * {@inheritdoc}.
   */
  public function reportFormCallback(array &$form, FormStateInterface $form_state) {


    $description = $form_state->getValue('description');
    $content['#markup'] = $description['value'];
    $content['#attached']['library'][] = 'core/drupal.dialog.ajax';
    $title = 'Description';
    $response = new AjaxResponse();
    $response->addCommand(new OpenModalDialogCommand($title, $description['value'], [
      'width' => '400',
      'height' => '400',
    ]));
    return $response;
  }

}
