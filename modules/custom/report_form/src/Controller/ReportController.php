<?php

namespace Drupal\report_form\Controller;


use Drupal\Core\Controller\ControllerBase;
use  Drupal\user\Entity\User;

/**
 * An example controller.
 */
class ReportController extends ControllerBase {

  public function getUser(){
    $ids = \Drupal::entityQuery('user')
      //  ->condition('roles', 'anonymous')
      //  ->condition('roles', 'authenticated')
      ->condition('status', 1)
      ->execute();

    $users = User::loadMultiple($ids);
    $userArray = [];
    foreach ($users as  $key=> $user) {
      //  kint($user);
      $userArray[$key]['mail']= $user->mail->value;
      $userArray[$key]['name']= $user->name->value;
      if (!empty($user->user_picture) && $user->user_picture->isEmpty() === FALSE) {
        $image = $user->get('user_picture')->entity->url();
        //    $rendered = \Drupal::service('renderer')->renderPlain($image);
        $userArray[$key]['pictire']= $image;
      }
    }
    kint($userArray);
    return $userArray;
  }

  /**
   * {@inheritdoc}
   */
  public function content() {
    $build = array(
      '#type' => 'markup',
      '#markup' => t('Hello World!'),
    );
    return $build;
  }

}

