<?php

class sfPlopSlotGoogleMapsPluginConfiguration extends sfPluginConfiguration
{
  public function initialize()
  {
    if (class_exists('sfPlop'))
      sfPlop::loadPlugin(array(
        'slots' => array(
          'GoogleMaps' => 'GoogleMaps map',
          'GoogleMapsFilter' => 'GoogleMaps filter',
          'GoogleMapsPosition' => 'GoogleMaps position',
      )));

    sfConfig::set('sf_plop_googlemaps_zooms', array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15));
  }
}

?>
