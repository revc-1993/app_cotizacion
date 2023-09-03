<?php

return array (
  'default' => 'smtp',
  'mailers' => 
  array (
    'smtp' => 
    array (
      'transport' => 'smtp',
      'host' => 'sandbox.smtp.mailtrap.io',
      'port' => 2525,
      'encryption' => 'tls',
      'username' => '0d4216150dbb76',
      'password' => 'f9502c88ca4e91',
      'timeout' => NULL,
      'auth_mode' => NULL,
      'from_address' => 'jerettearaujo@gmail.com',
      'from_name' => 'ROnny',
    ),
    'ses' => 
    array (
      'transport' => 'ses',
    ),
    'mailgun' => 
    array (
      'transport' => 'mailgun',
    ),
    'postmark' => 
    array (
      'transport' => 'postmark',
    ),
    'sendmail' => 
    array (
      'transport' => 'sendmail',
      'path' => '/usr/sbin/sendmail -t -i',
    ),
    'log' => 
    array (
      'transport' => 'log',
      'channel' => NULL,
    ),
    'array' => 
    array (
      'transport' => 'array',
    ),
    'failover' => 
    array (
      'transport' => 'failover',
      'mailers' => 
      array (
        0 => 'smtp',
        1 => 'log',
      ),
    ),
  ),
  'from' => 
  array (
    'address' => 'desde_env@hotmail.com',
    'name' => 'APP WEB',
  ),
  'markdown' => 
  array (
    'theme' => 'default',
    'paths' => 
    array (
      0 => 'C:\\laragon\\www\\app_cotizacion\\resources\\views/vendor/mail',
    ),
  ),
);