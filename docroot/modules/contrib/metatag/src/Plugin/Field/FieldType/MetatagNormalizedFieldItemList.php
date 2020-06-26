<?php

namespace Drupal\Metatag\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemList;
use Drupal\Core\TypedData\ComputedItemListTrait;

/**
 * Represents a configurable entity path field.
 */
class MetatagNormalizedFieldItemList extends FieldItemList {

  use ComputedItemListTrait;

  /**
   * {@inheritdoc}
   */
  protected function computeValue() {
    $entity = $this->getEntity();
    if (!$entity->id()) {
      return;
    }
    $metatagManager = \Drupal::service('metatag.manager');
    $metaTagsForEntity = $metatagManager->tagsFromEntityWithDefaults($entity);
    $tags = $metatagManager->generateRawElements($metaTagsForEntity, $entity);

    foreach ($tags as $tag) {
      $item = [
        'tag' => $tag['#tag'],
        'attributes' => $tag['#attributes'],
      ];
      $this->list[] = $this->createItem(0, $item);
    }
  }

}
