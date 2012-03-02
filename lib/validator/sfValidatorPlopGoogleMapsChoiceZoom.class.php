<?php
class sfValidatorPlopGoogleMapsChoiceZoom extends sfValidatorChoice
{
  public function configure($options = array(), $attributes = array()) {
    parent::configure($options, $attributes);

    $array = sfPlop::get('sf_plop_googlemaps_zooms');

    $this->setOption('choices', $array);
  }
}
?>
