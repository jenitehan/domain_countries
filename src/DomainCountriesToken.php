<?php

namespace Drupal\domain_countries;

use Drupal\Core\Render\BubbleableMetadata;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\domain\DomainToken;
use Drupal\domain_countries\DomainCountriesInfo;

/**
 * Class DomainCountriesToken.
 */
class DomainCountriesToken extends DomainToken {

  /**
   * Implements hook_token_info().
   */
  public function getTokenInfo() {

    // Domain tokens.
    $info['tokens']['domain']['country'] = array(
      'name' => $this->t('Domain Country'),
      'description' => $this->t('The domain\'s country.'),
    );
    $info['tokens']['domain']['country-determiner'] = array(
      'name' => $this->t('Domain Country with Determiner'),
      'description' => $this->t('The domain\'s country prefixed with a determiner if necessary.'),
    );

    return $info;
  }
  
  /**
   * Implements hook_tokens().
   */
  public function getTokens($type, $tokens, array $data, array $options, BubbleableMetadata $bubbleable_metadata) {
    $replacements = array();

    $domain = NULL;

    // Based on the type, get the proper domain context.
    switch ($type) {
      case 'domain':
        if (!empty($data['domain'])) {
          $domain = $data['domain'];
        }
        else {
          $domain = $this->negotiator->getActiveDomain();
        }
        break;
      case 'current-domain':
        $domain = $this->negotiator->getActiveDomain();
        break;
      case 'default-domain':
        $domain = $this->loader->loadDefaultDomain();
        break;
    }

    // Set the token information.
    if (!empty($domain) && $country_code = $domain->getThirdPartySetting('domain_countries', 'country')) {
      $country_info = DomainCountriesInfo::getCountryInfo($country_code);
      $country_name = $country_info['name'];
      $determiner = $country_info['determiner'];

      foreach ($tokens as $name => $original) {
        if ($name == 'country') {
          $replacements[$original] = $country_name;
        }
        if ($name == 'country-determiner') {
          $replacements[$original] = $determiner ? $determiner . ' ' . $country_name : $country_name;
        }
        $bubbleable_metadata->addCacheableDependency($domain);
      }
    }

    return $replacements;
  }
  
}
