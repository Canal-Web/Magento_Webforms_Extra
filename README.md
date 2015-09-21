Magento_Webforms_Extra

Ce module ajoute des fonctionnalités au module Webform (par Vladimir Popov).

* Ajout de variables personnalisées :
  * `{{entity}}` qui permet d'inclure la valeur des attributs de l'entité liée par le champ caché `entity_id`, par exemple `{{entity field="name"}}`
  * `{{webform}}` qui permet d'inclure la valeur des champs du formulaire, par exemple `{{webform field="name"}}`
* Permet d'envoyer l'e-mail de notification Admin à une adresse e-mail renseignée dans le champ "email" du produit lié au formulaire. Le produit est chargé d'après le SKU présent dans le champ `entity_id`. Pour que l'adresse e-mail soit rajoutée, il faut que le champ "Adresse e-mail de notification" commence par "automatique,".

