<?php
class sfValidatorPlopGoogleMapsChoiceFilter extends sfValidatorChoice
{
  public function configure($options = array(), $attributes = array()) {
    parent::configure($options, $attributes);

    $this->addRequiredOption('page_id');
    $this->addRequiredOption('page_culture');

    $this->setOption('choices', array());
  }



  public function getChoices() {
    $page_filters_ids = array();
    
    $page = sfPlopPagePeer::retrieveByPK($this->getOption('page_id)'));
    
    $q = sfPlopPageQuery::create()
      ->filterByTreeLevel($page->getLevel() + 1)
    ;
    $page_filters = $page->getBranch($q);
    foreach ($page_filters as $page_filter)
      $page_filters_ids []= $page_filter->getId();
    
    $filters = sfPlopSlotConfigQuery::create()
      ->innerJoinsfPlopSlot()
      ->filterByPageId($page_filters_ids)
      ->find()
    ;
    
    foreach ($filters as $i => $filter)
      if (
        !$filter->getTemplate() != 'GoogleMapsFilter'
        && !$filter->getSlot()->ispublished()
      )
        unset($filters[$i]);    
    
		$options_for_filter = array('' => '');
		foreach($filters as $filter_object)
			$options_for_filter[$filter_object->getValue($this->getOption('page_culture)'))] 
        = $filter_object->getValue($this->getOption('page_culture)'));

    $this->setOption('choices', array_keys($options_for_filter));

    return parent::getChoices();
  }
}
?>
