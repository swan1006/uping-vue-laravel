<?php
/**
 * This file is automatically @generated by {@link BuildMetadataPHPFromXml}.
 * Please don't modify it directly.
 */


return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[1-9]\\d{7,8}',
    'PossibleNumberPattern' => '\\d{6,9}',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            1\\d|
            2(?:
              1\\d|
              [2-9]
            )|
            3[2-7]|
            4[24-9]|
            5[2-79]|
            6[23689]|
            7(?:
              1\\d|
              [2-9]
            )|
            8[2-57-9]|
            9[2-69]
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{6,9}',
    'ExampleNumber' => '12345678',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            [27]0|
            3[01]
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '201234567',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '80\\d{6}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80123456',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '9[01]\\d{6}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '90123456',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '40\\d{6}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '40123456',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
  ),
  'voip' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
  ),
  'pager' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
  ),
  'uan' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
  ),
  'emergency' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
  ),
  'voicemail' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
  ),
  'shortCode' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
  ),
  'standardRate' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
  ),
  'carrierSpecific' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => '[48]0\\d{6}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80123456',
  ),
  'id' => 'HU',
  'countryCode' => 36,
  'internationalPrefix' => '00',
  'nationalPrefix' => '06',
  'nationalPrefixForParsing' => '06',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(1)(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '1',
      ),
      'nationalPrefixFormattingRule' => '($1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(\\d{2})(\\d{3})(\\d{3,4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[2-9]',
      ),
      'nationalPrefixFormattingRule' => '($1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => false,
  'leadingZeroPossible' => false,
  'mobileNumberPortableRegion' => true,
);
