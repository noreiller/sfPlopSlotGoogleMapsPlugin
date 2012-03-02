<?php

class sfPlopSlotGoogleMapsPosition extends sfPlopSlotStandard
{
  public function isContentEditable() {
    return false;
  }

  public function isContentOptionable() {
    return true;
  }
  
  public function getFields($slot) 
  {
    return array(
      'title' => new sfWidgetFormInputText(array(
        'label' => 'Title'
      )),
      'address' => new sfWidgetFormInputText(array(
        'label' => 'Address'
      )),
      'city' => new sfWidgetFormInputText(array(
        'label' => 'City'
      )),
      'country' => new sfWidgetFormInputText(array(
        'label' => 'Country'
      )),
      'latitude' => new sfWidgetFormInputText(array(
        'label' => 'Latitude'
      )),
      'longitude' => new sfWidgetFormInputText(array(
        'label' => 'Longitude'
      )),
      'filter' => new sfWidgetFormInputText(array(
        'label' => 'Filter'
      )),
//      'filter' => new sfWidgetFormPlopGoogleMapsChoiceFilter(array(
//        'label' => 'Filter',
//        'page_id' => $slot->getPage()->getId(),
//        'page_culture' => $slot->getCulture()
//      )),
      'value' => new sfWidgetFormPlopRichText(array(
        'label' => 'Description'
      ))
    );
  }

  public function getValidators($slot) {
    return array(
      'title' => new sfValidatorString(array(
        'required' => false
      )),
      'address' => new sfValidatorString(array(
        'required' => false
      )),
      'city' => new sfValidatorString(array(
        'required' => false
      )),
      'country' => new sfValidatorString(array(
        'required' => false
      )),
      'latitude' => new sfValidatorString(array(
        'required' => false
      )),
      'longitude' => new sfValidatorString(array(
        'required' => false
      )),
      'filter' => new sfValidatorString(array(
        'required' => false
      )),
//      'filter' => new sfValidatorPlopGoogleMapsChoiceFilter(array(
//        'required' => false,
//        'page_id' => $slot->getPage()->getId(),
//        'page_culture' => $slot->getCulture()
//      )),
      'value' => new sfValidatorString(array(
        'required' => false
      ))
    );
  }

  public function getSlotValue($slot, $settings)
  {
    sfProjectConfiguration::getActive()->loadHelpers(array('Partial'));
    
    return include_partial('sfPlopSlotGoogleMaps/' . $slot->getTemplate(), array(
      'slot' => $slot,
      'settings' => $settings,
    ));
	}
}
