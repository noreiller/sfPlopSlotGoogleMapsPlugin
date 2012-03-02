<div id="GoogleMaps_filters_control" class="GoogleMaps_filters_control">
  <label for="GoogleMaps_filters_list"><?php echo __('Filter') ?></label>
  <select>
    <option value="all">[<?php echo __('All') ?>]</option>
    <option value="none">[<?php echo __('None') ?>]</option>
    <?php for ($i = 1; $i <= 5; $i++): ?>
      <?php $tag = null; ?>
      <?php if ($tag = $slot->getOption('tag' . $i, null, $settings['culture'])): ?>
        <li><?php echo $tag; ?></li>
        <option value="<?php echo $tag; ?>"><?php echo $tag; ?></option>
      <?php endif; ?>
    <?php endfor; ?>
  </select>
</div>