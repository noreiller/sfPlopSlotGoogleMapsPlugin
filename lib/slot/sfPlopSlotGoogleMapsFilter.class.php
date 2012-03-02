<?php

class sfPlopSlotGoogleMapsFilter extends sfPlopSlotStandard
{
  public function isContentEditable() {
    return false;
  }

  public function isContentOptionable() {
    return true;
  }
  
  public function getFields($slot) {
    return array(
      'tag1' => new sfWidgetFormInputText(array(
        'label' => 'Filter'
      )),
      'tag2' => new sfWidgetFormInputText(array(
        'label' => 'Filter'
      )),
      'tag3' => new sfWidgetFormInputText(array(
        'label' => 'Filter'
      )),
      'tag4' => new sfWidgetFormInputText(array(
        'label' => 'Filter'
      )),
      'tag5' => new sfWidgetFormInputText(array(
        'label' => 'Filter'
      ))
    );
  }

  public function getValidators($slot) {
    return array(
      'tag1' => new sfValidatorString(array(
        'required' => false
      )),
      'tag2' => new sfValidatorString(array(
        'required' => false
      )),
      'tag3' => new sfValidatorString(array(
        'required' => false
      )),
      'tag4' => new sfValidatorString(array(
        'required' => false
      )),
      'tag5' => new sfValidatorString(array(
        'required' => false
      )),
    );
  }

  public function getSlotValue($slot, $settings){
    sfProjectConfiguration::getActive()->loadHelpers(array('Partial'));
    return include_partial('sfPlopSlotGoogleMaps/'.$slot->getTemplate(), array(
      'slot' => $slot,
      'settings' => $settings,
    ));
	}
}
