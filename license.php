<?php
/*
Plugin Name: License
Description: Minimal plugin for adding Creative Commons licensing information.
Author: Will Norris
Author URI: http://willnorris.com/
*/


/**
 * Get the license for the current context.
 *
 * @uses apply_filters calls 'cc_license' before returning value.
 */
function cc_license() {
  $license = defined('CC_LICENSE') ? CC_LICENSE : null;
  $license = apply_filters('cc_license', $license);
  return $license;
}


/**
 * Add license to site head.
 */
function cc_license_head() {
  $license = cc_license();
  if ( $license ) {
    echo '<link rel="license" href="' . $license . '" type="text/html" />' . "\n";
    echo '<link rel="license" href="' . trailingslashit($license) . 'rdf" type="application/rdf+xml" />' . "\n";
  }
}
add_action('wp_head', 'cc_license_head');
add_action('atom_head', 'cc_license_head');

/**
 * Add the Creative Commons XML namespace.
 */
function cc_license_xmlns() {
  $license = cc_license();
  if ( $license ) {
    echo 'xmlns:creativeCommons="http://backend.userland.com/creativeCommonsRssModule"' . "\n";
  }
}
add_action('rdf_ns', 'cc_license_xmlns');
add_action('rss2_ns', 'cc_license_xmlns');


/**
 * Add the Creative Commons XML element.
 */
function cc_license_xmlfeed() {
  $license = cc_license();
  if ( $license ) {
    echo '<creativeCommons:license>' . $license . '</creativeCommons:license>' . "\n";
  }
}
add_action('rdf_header', 'cc_license_xmlfeed');
add_action('rss2_head', 'cc_license_xmlfeed');