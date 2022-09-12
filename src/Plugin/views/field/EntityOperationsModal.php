<?php

namespace Drupal\modal_delete_entity\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\ResultRow;
use Drupal\views\Plugin\views\field\EntityLink;

/**
 * Field handler to present a link to an entity.
 */
class EntityOperationsModal extends EntityLink {

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $row) {
    return $this->getEntity($row) ? parent::render($row) : [];
  }

  /**
   * {@inheritdoc}
   */
  protected function renderLink(ResultRow $row) {
    if ($this->options['output_url_as_text']) {
      return $this->getUrlInfo($row)->toString();
    }
    return parent::renderLink($row);
  }

  /**
   * {@inheritdoc}
   */
  protected function getUrlInfo(ResultRow $row) {
    $template = $this->getEntityLinkTemplate();
    $entity = $this->getEntity($row);
    if ($this->languageManager->isMultilingual()) {
      $entity = $this->getEntityTranslation($entity, $row);
    }
    return $entity->toUrl($template)->setAbsolute($this->options['absolute']);
  }

  /**
   * Returns the entity link template name identifying the link route.
   *
   * @returns string
   *   The link template name.
   */
  protected function getEntityLinkTemplate() {
    return 'canonical';
  }

  /**
   * {@inheritdoc}
   */
  protected function getDefaultLabel() {
    return $this->t('view');
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['output_url_as_text'] = ['default' => FALSE];
    $options['absolute'] = ['default' => FALSE];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
    $form['in_modal'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Open in modal'),
      '#default_value' => $this->options['in_modal'],
      '#description' => $this
        ->t('Enable this option to open modal window when click.'),
    ];

  }

}
