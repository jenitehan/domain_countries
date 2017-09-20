<?php

namespace Drupal\domain_countries;

class DomainCountriesInfo {
  
  /**
   * Country information.
   */
  public static function getCountryInfo() {
    return [
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