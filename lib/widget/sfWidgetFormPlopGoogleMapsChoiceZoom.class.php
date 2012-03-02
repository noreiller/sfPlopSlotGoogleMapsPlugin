<?php
class sfWidgetFormPlopGoogleMapsChoiceZoom extends sfWidgetFormChoice
{
  public function configure($options = array(), $attributes = array()) {
    parent::configure($options, $attributes);

    $array = range(1,10,1);

    $this->setOption('choices', array_combine($array, $array));
  }
}
?>
