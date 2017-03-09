<?php
  /**
   * @file config.php
   * @Author Michal Mareš
   * @date March, 2017
   * @brief This script contains all the user-configurable variables.
   */

  // global variables
  $domain = 'ardularm.forgotitsmonday.com';

  // variables for connect.php
  $dsn = '*****:dbname=*****;host=domain.tld:port';
  $user = 'login';                                                // login to the database
  $password = 'pass';                                             // password for the database

  // variables for authenticate.php
  $key = 'key';                                                   // has to be the same as the kye in Ardunio code

  // variables for PHPMailer
  $mailHost = '*****.***;';                                       // mailbox host
  $mailUsername = 'usr@domain.tld';                               // mailbox name
  $mailPassword = 'pass';                                         // password for mailbox
  $mailSetFromAddress = $mailUsername;                            // should be the same
  $mailSetFromName = 'Ardularm';                                  // can be changed, doesn't have to be
  $mailaddAddressAddress = 'to@domain.tld';                       // whom to send the message to
  $mailaddAddressName = 'name';                                   // name of the owner of the address above
?>
