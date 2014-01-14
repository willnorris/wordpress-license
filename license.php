<?php
/*
Plugin Name: License
Description: Minimal plugin for adding Creative Commons licensing information.
Version: 1337
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
 * Add license to WebFinger and host-meta.
 */
function cc_license_jrd($data) {
  $license = cc_license();
  if ( $license ) {
    $data['links'][] = array("rel" => "license", "href" => $license, "type" => "text/html");
    $data['links'][] = array("rel" => "license", "href" => trailingslashit($license) . "rdf", "type" => "application/rdf+xml");
  }

  return $data;
}
add_action('host_meta', 'cc_license_jrd', 10, 1);
add_action('webfinger_post_data', 'cc_license_jrd', 10, 1);

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
 * Add the Creative Commons RSS 2.0 element.
 *
 * @link http://wiki.creativecommons.org/RSS_2.0
 */
function cc_license_rssfeed() {
  $license = cc_license();
  if ( $license ) {
    echo '<creativeCommons:license>' . $license . '</creativeCommons:license>' . "\n";
  }
}
add_action('rss2_head', 'cc_license_rssfeed');

/**
 * Add the Creative Commons RDF (RSS 1.0) element.
 *
 * @link http://wiki.creativecommons.org/RSS_1.0
 */
function cc_license_rdffeed() {
  $license = cc_license();
  if ( $license ) {
    echo '<creativeCommons:license rdf:resource="' . $license . '" />' . "\n";
  }
}
add_action('rdf_header', 'cc_license_rdffeed');