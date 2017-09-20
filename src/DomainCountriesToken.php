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
    if (!empty($domain)) {
      $callbacks = $this->getCallbacks();
      $country_info = DomainCountriesInfo::getCountryInfo();
      foreach ($tokens as $name => $original) {
        if (isset($callbacks[$name])) {
          $code = $domain->getThirdPartySetting('domain_countries', $name);
          $replacements[$original] = $country_info[$code]['name'];
          $bubbleable_metadata->addCacheableDependency($domain);
        }
      }
    }

    return $replacements;
  }

  /**
   * Maps tokens to their entity callbacks.
   *
   * We assume that the token will call an instance of DomainInterface.
   *
   * @return array
   */
  public function getCallbacks() {
    return [
      'country' => 'country',
    ];
  }
  
}
