/**
 * Google Maps map with markers from microformat locations
 */
var GoogleMaps = {

  iw : false,
  geocoder : false,
  defaultLatitude : 48.8566667,
  defaultLongitude : 2.3509871,
  markers: [],
  markersOptions: [],

  /**
   * Init the class
   */
  init: function () {
  },

  /**
   * Init on DOM ready
   */
  initOnDomReady: function () {
    if (window.sfPlop)
      sfPlop.registerTPPlugin(function () {
        GoogleMaps.load();
      });
    GoogleMaps.load();
  },

  /**
   * Load the map
   */
  load : function () {
    if (jQuery('.GoogleMaps_wrapper').length > 0)
      jQuery('.GoogleMaps_wrapper').each(function (i, e) {
        if (jQuery('.GoogleMaps_map', jQuery(e)).length > 0)
          GoogleMaps.newMap(jQuery(e));
      });
  },

  /**
   * Launch a new map on the given jQuery element
   */
  newMap : function (e) {
    var
      mapEl = e.find('.GoogleMaps_map'),
      infosEl = e.find('.location'),
      o = {},
      adr = '',
      lat = this.defaultLatitude,
      lng = this.defaultLongitude
    ;

    o.center = new google.maps.LatLng(lat, lng);
    o.mapTypeId = google.maps.MapTypeId.ROADMAP;
    o.zoom = mapEl.data('zoom') != '' ? mapEl.data('zoom') : 5;

    var map = new google.maps.Map(document.getElementById(mapEl[0].id), o);
    GoogleMaps.findMarkers(map, mapEl, infosEl);
    GoogleMaps.findFilters(map, mapEl);

    this.iw = new google.maps.InfoWindow({
      content: ''
    });
  },

  /**
   * Find and display the markers
   */
  findMarkers : function (map, mapEl, centerEl) {
    var
      mapElW = mapEl.parents('.GoogleMaps_wrapper:first')
    ;
    if (mapElW.find('.GoogleMaps_markers_control').length < 1) {
      jQuery('<ul />')
        .addClass('GoogleMaps_markers_control')
        .attr('id', 'GoogleMaps_markers_control_' + mapEl.attr('id'))
        .prependTo(mapElW)
      ;
    }
    else {
      mapElW.find('.GoogleMaps_markers_control li').remove();
    }

    for (var i = 0; i < GoogleMaps.markers.length; i++) {
      GoogleMaps.markers[i].setMap(null);
      GoogleMaps.makePositionVisible(null, mapEl, i, true);
      delete GoogleMaps.markers[i];
      delete GoogleMaps.markersOptions[i];
    }
    GoogleMaps.markers = new Array();
    GoogleMaps.markersOptions = new Array();

    GoogleMaps.newMarker(map, mapEl, centerEl, true);

    jQuery('.container > .GoogleMapsPosition .location').each(function(i, e) {
      GoogleMaps.newMarker(map, mapEl, jQuery(e));
    });
  },

  /**
   * Set a new marker to the map
   */
  newMarker : function (map, mapEl, markerEl, makeCenter) {
    var o = {
      lat : '',
      lng : '',
      street : '',
      city : '',
      country : '',
      adr : '',
      content : '',
      position : '',
      title: '',
      tag: ''
    };

    o.tag = GoogleMaps.extractData(markerEl, 'tag', '');
    o.street = GoogleMaps.extractData(markerEl, 'street-address', '');
    o.city = GoogleMaps.extractData(markerEl, 'locality', '');
    o.region = GoogleMaps.extractData(markerEl, 'region', '');
    o.adr = o.street + ', ' + o.city + ', ' + o.region;
    o.content = GoogleMaps.extractData(markerEl, 'summary', o.adr);
    o.title = GoogleMaps.extractData(markerEl, 'n', '');
    o.tag = GoogleMaps.extractData(markerEl, 'tag', '');

    if (markerEl.find('.geo').length > 0) {
      o.lat = GoogleMaps.extractData(markerEl, 'latitude', '');
      o.lng = GoogleMaps.extractData(markerEl, 'longitude', '');
    }

    if (o.lat != '' && o.lng != '') {
      GoogleMaps.displayMarker(map, mapEl, o, makeCenter);
    }
    else if (
      (o.lat == '' || o.lng == '')
      && markerEl.find('.adr').length > 0
    ) {
      if (GoogleMaps.geocoder == false)
        GoogleMaps.geocoder = new google.maps.Geocoder();
      GoogleMaps.geocoder.geocode({'address': o.adr},
        function (results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
            o.position = results[0].geometry.location;
            GoogleMaps.displayMarker(map, mapEl, o, makeCenter);
          }
        }
      );
    }
  },

  /**
   * Print the marker on the map
   */
  displayMarker : function (map, mapEl, o, makeCenter) {
    if (o.position == '')
      o.position = new google.maps.LatLng(o.lat, o.lng);

    var marker = new google.maps.Marker({
      map: map,
      position: o.position,
      title: o.title
    });
    GoogleMaps.markers.push(marker);
    GoogleMaps.markersOptions.push(o);

    google.maps.event.addListener(marker, 'click', function () {
      var index = GoogleMaps.markers.indexOf(this);
      GoogleMaps.iw.setContent(GoogleMaps.markersOptions[index].content);
      GoogleMaps.iw.open(map, this);
    });

    if (makeCenter)
      map.setCenter(o.position);

    if (o.title != '')
      jQuery('<li title ="' + o.title + '" rel="tag" data-tags="' + o.tag + '">' + o.title + '</li>')
	.appendTo(mapEl.parents('.GoogleMaps_wrapper:first').find('.GoogleMaps_markers_control'))
	.bind('click', function () {
	  google.maps.event.trigger(GoogleMaps.markers[jQuery(this).index()], 'click');
	})
      ;

    return o.position;
  },

  findFilters : function (map, mapEl) {
    if (jQuery('.container > .GoogleMapsFilter').length > 0) {
      google.maps.event.addListenerOnce(map, 'bounds_changed', function() {

        if (jQuery('#GoogleMaps_filters_control').length < 1)
          jQuery('#GoogleMaps_filters_control_backup')
            .clone()
            .attr('id', 'GoogleMaps_filters_control')
            .show()
            .appendTo(jQuery('.container > .GoogleMapsFilter > .content'))
          ;
        if (jQuery('#GoogleMaps_filters_control_backup').length < 1)
          jQuery('#GoogleMaps_filters_control')
            .clone()
            .attr('id', 'GoogleMaps_filters_control_backup')
            .hide()
            .appendTo(jQuery('.container > .GoogleMapsFilter > .content'))
          ;
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(document.getElementById('GoogleMaps_filters_control'));

        jQuery("#GoogleMaps_filters_control select").change(function() {
          var tag = jQuery(this).val();
          if (tag == 'all') {
            for (var i = 0; i < GoogleMaps.markers.length; i++) {
              GoogleMaps.markers[i].setVisible(true);
              GoogleMaps.makePositionVisible(map, mapEl, i, true);
            }
          }
          else if (tag == 'none') {
            for (var j = 0; j < GoogleMaps.markers.length; j++) {
              GoogleMaps.markers[j].setVisible(false);
              GoogleMaps.makePositionVisible(map, mapEl, j, false);
            }
          }
          else {
            for (var k = 0; k < GoogleMaps.markers.length; k++) {
              var status = true;
              if (GoogleMaps.markersOptions[k].tag.indexOf(tag) == -1)
                status = false;
              GoogleMaps.markers[k].setVisible(status);
              GoogleMaps.makePositionVisible(map, mapEl, k, status);
            }
          }
        });
      });
    }
  },

  /**
   * Show/hide the position of a marker in the list
   */
  makePositionVisible : function (map, mapEl, i, status) {
    if (isNaN(i))
      i = GoogleMaps.markers.indexOf(i);

    if (map === null)
      mapEl.parents('.GoogleMaps_wrapper:first')
        .find('.GoogleMaps_markers_control li:eq(' + i + ')')
        .remove()
      ;
    else if (status == true)
      mapEl.parents('.GoogleMaps_wrapper:first')
        .find('.GoogleMaps_markers_control li:eq(' + i + ')')
        .show()
      ;
    else
      mapEl.parents('.GoogleMaps_wrapper:first')
        .find('.GoogleMaps_markers_control li:eq(' + i + ')')
        .hide()
      ;
  },

  /**
   * Extract the metadata
   */
  extractData : function (el, s, d) {
    var r = d;
    if (el.find('.' + s).val() != '')
      r = el.find('.' + s).val();
    else if (el.find('.' + s + ' .value-title').attr('title') != '')
      r = el.find('.' + s + ' .value-title').attr('title');

    return r;
  }

};

GoogleMaps.init();

jQuery(document).ready(function () {
  GoogleMaps.initOnDomReady();
});
