<?php

namespace Drupal\modal_delete_entity\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\field\EntityLink;
use Drupal\views\ResultRow;

/**
 * Field handler to present a link to delete an entity.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("entity_link_delete")
 */
class EntityDeleteModal extends EntityLink {

  /**
   * {@inheritdoc}
   */
  protected function getEntityLinkTemplate() {
    return 'delete-form';
  }

  /**
   * {@inheritdoc}
   */
  protected function renderLink(ResultRow $row) {
    $this->options['alter']['query'] = $this->getDestinationArray();
    return parent::renderLink($row);
  }

  /**
   * {@inheritdoc}
   */
  protected function getDefaultLabel() {
    return $this->t('deletes');
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {

    parent::buildOptionsForm($form, $form_state);
    // Only show the 'text' field if we don't want to output the raw URL.
    $form['in_modal'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Open in modal'),
      '#default_value' => $this->options['in_modal'],
      '#description' => $this->t('Enable this option to open modal window when click.'),
    ];
  }

}
