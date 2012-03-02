<?php
class sfWidgetFormPlopGoogleMapsChoiceFilter extends sfWidgetFormChoice
{
  public function configure($options = array(), $attributes = array()) {
    parent::configure($options, $attributes);

    $this->addRequiredOption('page_id');
    $this->addRequiredOption('page_culture');

    $this->setOption('choices', array());
  }

  public function getChoices() {
    $filters = sfPlopSlotPeer::retrieveAllByTemplate('GoogleMapsFilter', $this->getOption('page_id'), $this->getOption('page_culture'));
		$options_for_filter = array('' => '');
		foreach($filters as $filter_object)
			$options_for_filter[$filter_object->getValue()] = $filter_object->getValue();

    $this->setOption('choices', $options_for_filter);

    return parent::getChoices();
  }
}
?>
