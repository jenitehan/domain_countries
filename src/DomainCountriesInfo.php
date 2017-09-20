<?php

namespace Drupal\domain_countries;

class DomainCountriesInfo {
  
  /**
   * Country information.
   * @param $country_code
   *    Optional string. Two-letter country code of the country info we want.
   */
  public static function getCountryInfo($country_code = '') {
    $country_info = [
      'gb' => [
        'name' => 'UK',
        'determiner' => 'the',
      ],
      'us' => [
        'name' => 'USA',
        'determiner' => 'the',
      ],
      'au' => [
        'name' => 'Australia',
        'determiner' => '',
      ],
      'nz' => [
        'name' => 'New Zealand',
        'determiner' => '',
      ],
      'za' => [
        'name' => 'South Africa',
        'determiner' => '',
      ],
      'ca' => [
        'name' => 'Canada',
        'determiner' => '',
      ],
      'ie' => [
        'name' => 'Ireland',
        'determiner' => '',
      ],
    ];
    if ($country_code) {
      return $country_info[$country_code];
    }
    return $country_info;
  }
  
  /**
   * Country form options.
   */
  public static function getCountryOptions() {
    $country_info = self::getCountryInfo();
    $options = [];
    foreach ($country_info as $code => $info) {
      $options[$code] = $info['name'];
    }
    
    return $options;
  }
  
}