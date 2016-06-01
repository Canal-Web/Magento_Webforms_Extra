<?php

class Canalweb_Webforms_Model_Rewrite_Email_Template_Filter extends Mage_Core_Model_Email_Template_Filter
{
  public function entityDirective($construction) {
    $params = $this->_getIncludeParameters($construction[2]);
    $fields = $this->_templateVars['data']->getField();
    $webformId = $this->_templateVars['data']->getWebformId();

    if (!isset($params['field'])) {
        return '';
    }

    $collection = Mage::getModel('webforms/fields')
        ->getCollection()
        ->addFilter('webform_id', $webformId);
    
    // Get ID for the "entity_id" field.
    $fieldId = NULL;
    foreach ($collection as $field) {
        // Skip other fields.
        if ($field->getName() == 'entity_id') {
            $fieldId = $field->getId();
            break;
        }
    }

    $sku = $fields[$fieldId];

    $product = Mage::getModel('catalog/product')
        ->getCollection()
        ->addFieldToFilter('sku', $sku)
        ->addAttributeToSelect('*')
        ->getLastItem();

    if ($product) {
        return $product->getData($params['field']);
    }
  }

  public function webformDirective($construction) {
    $params = $this->_getIncludeParameters($construction[2]);
    $fields = $this->_templateVars['data']->getField();
    $webformId = $this->_templateVars['data']->getWebformId();

    if (!isset($params['field'])) {
        return '';
    }

    $collection = Mage::getModel('webforms/fields')
        ->getCollection()
        ->addFilter('webform_id', $webformId);
    
    // Get ID for the "entity_id" field.
    $fieldId = NULL;
    foreach ($collection as $field) {
        // Skip other fields.
        if ($field->getName() == $params['field']) {
            $fieldId = $field->getId();
            break;
        }
    }

    return $fields[$fieldId];
  }
}