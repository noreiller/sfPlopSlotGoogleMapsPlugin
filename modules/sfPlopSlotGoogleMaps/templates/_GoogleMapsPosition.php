<div class="location vcard">
  <span class="tag" rel="tag" data-filter="<?php echo $slot->getOption('filter', '', $settings['culture']) ?>">
    <span class="value-title" title="<?php echo $slot->getOption('filter', '', $settings['culture']) ?>"></span>
  </span>
  <span class="fn n">
    <span class="value-title" title="<?php echo $slot->getOption('title', '', $settings['culture']) ?>"></span>
  </span>
  <span class="summary">
    <span class="value-title" title="<?php echo $slot->getValue($settings['culture']) ?>"></span>
  </span>
  <span class="adr">
    <span class="street-address">
      <span class="value-title" title="<?php echo $slot->getOption('address', '', $settings['culture']) ?>"></span>
    </span>
    <span class="locality">
      <span class="value-title" title="<?php echo $slot->getOption('city', '', $settings['culture']) ?>"></span>
    </span>
    <span class="region">
      <span class="value-title" title="<?php echo $slot->getOption('country', '', $settings['culture']) ?>"></span>
    </span>
  </span>
  <span class="geo">
    <span class="latitude">
      <span class="value-title" title="<?php echo $slot->getOption('latitude', '', $settings['culture']) ?>"></span>
    </span>
    <span class="longitude">
      <span class="value-title" title="<?php echo $slot->getOption('longitude', '', $settings['culture']) ?>"></span>
    </span>
  </span>
</div>