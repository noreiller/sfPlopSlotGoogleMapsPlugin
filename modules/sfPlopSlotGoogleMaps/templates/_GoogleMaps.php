<?php use_stylesheet('/sfPlopSlotGoogleMapsPlugin/css/GoogleMaps.css') ?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=<?php echo $settings['culture'] ?>"></script>
<?php use_javascript('/sfPlopSlotGoogleMapsPlugin/js/GoogleMaps.js') ?>


<div class="GoogleMaps_wrapper">
  <div id="map_canvas_<?php echo $slot->getId() ?>" class="GoogleMaps_map" data-zoom="<?php echo $slot->getOption('zoom', '', $settings['culture']) ?>">
    <?php echo __('Loading') ?>...
  </div>

  <div class="location vcard">
    <span class="tag" rel="tag" data-filter="<?php echo $slot->getOption('filter', '', $settings['culture']) ?>">
      <span class="value-title" title="<?php echo $slot->getOption('filter', '', $settings['culture']) ?>"></span>
    </span>
    <span class="fn n" title="<?php echo $slot->getOption('title', '', $settings['culture']) ?>">
      <span class="value-title" title="<?php echo $slot->getOption('title', '', $settings['culture']) ?>"></span>
    </span>
    <span class="summary" title="<?php echo $slot->getValue($settings['culture']) ?>">
      <span class="value-title" title="<?php echo $slot->getValue($settings['culture']) ?>"></span>
    </span>
    <span class="adr">
      <span class="street-address" title="<?php echo $slot->getOption('address', '', $settings['culture']) ?>">
        <span class="value-title" title="<?php echo $slot->getOption('address', '', $settings['culture']) ?>"></span>
      </span>
      <span class="locality" title="<?php echo $slot->getOption('city', '', $settings['culture']) ?>">
        <span class="value-title" title="<?php echo $slot->getOption('city', '', $settings['culture']) ?>"></span>
      </span>
      <span class="region" title="<?php echo $slot->getOption('country', '', $settings['culture']) ?>">
        <span class="value-title" title="<?php echo $slot->getOption('country', '', $settings['culture']) ?>"></span>
      </span>
    </span>
    <span class="geo">
      <span class="latitude" title="<?php echo $slot->getOption('latitude', '', $settings['culture']) ?>">
        <span class="value-title" title="<?php echo $slot->getOption('latitude', '', $settings['culture']) ?>"></span>
      </span>
      <span class="longitude" title="<?php echo $slot->getOption('longitude', '', $settings['culture']) ?>">
        <span class="value-title" title="<?php echo $slot->getOption('longitude', '', $settings['culture']) ?>"></span>
      </span>
    </span>
  </div>
</div>