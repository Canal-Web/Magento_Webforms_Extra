<?php

class Canalweb_Webforms_Model_Rewrite_Webforms extends VladimirPopov_WebForms_Model_Webforms
{
    public function getEmailSettings()
    {
        $settings["email_enable"] = $this->getSendEmail();
        $settings["email"] = Mage::getStoreConfig('webforms/email/email');

        if ($this->getEmail())
            $settings["email"] = $this->getEmail();


        /**
         * Get the e-mail from the product.
         */
        if (strpos($settings['email'], 'automatique') !== FALSE) {
            // Get it from cache if set.
            if (Mage::registry('webform_entity_email')) {
                $settings["email"] = Mage::registry('webform_entity_email');
            }
            else {
                $collection = Mage::getModel('webforms/fields')
                    ->getCollection()
                    ->addFilter('webform_id', $this->getId());

                // Get ID for the "entity_id" field.
                $fieldId = NULL;
                foreach ($collection as $field) {
                    // Skip other fields.
                    if ($field->getName() == 'entity_id') {
                        $fieldId = $field->getId();
                        break;
                    }
                }

                $post = $this->getPostData();

                if ($fieldId AND isset($post[$fieldId])) {
                    $product = Mage::getModel('catalog/product')
                        ->getCollection()
                        ->addFieldToFilter('sku', $post[$fieldId])
                        ->addAttributeToSelect('*')
                        ->getLastItem();

                    if ($product) {
                        if (strpos($settings['email'], ',') !== FALSE) {
                            $settings['email'] = str_replace('automatique,', '', $settings['email']);
                        }

                        if ($product->getEmail())
                            $settings['email'] .= ', ' . $product->getEmail();

                        // Cache the value since the function will be called
                        // multiple times but only once with postData. We need
                        // the function to be able to return the right e-mail
                        // address each time.
                        Mage::register('webform_entity_email', $settings['email']);
                    }
                }
            }
        }
        elseif(strpos($settings['email'], 'customer_rattachement') !== FALSE) {
          if (Mage::registry('customer_contact_rattachement')) {
                $settings["email"] = Mage::registry('customer_contact_rattachement');
            }
            else {
                $customerRattachement = Mage::helper('canalweb_contactrattachement/contactrattachement')->getCustomerContactRattachement();
                $settings["email"] = $customerRattachement->getEmail();
            }
        }
        return $settings;
    }
}
