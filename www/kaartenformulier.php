<?php

// Simple Form Script
// Copyright (C) 2005  Eric Zhang
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License
// as published by the Free Software Foundation; either version 2
// of the License, or (at your option) any later version.
//
// Please send bugs/questions to erkzh@yahoo.com.

//--------------------------Set these paramaters--------------------------
$bronserver = "http://www.voicesunlimited.nl/";  // Server from where script may be accessed
$subject = 'Bestelling kaarten Voices';          // Subject of email sent to you.
$emailadd = 's.nijhuis@apollon.nl';    // Recipient email address. This is where the form information will be sent.
$emailfrom = 'webmaster@voicesunlimited.nl';     // Your email address. This is the 'from' address
$url = 'http://www.voicesunlimited.nl/dank.htm'; // Where to redirect after form is processed.
$req = '0';                                      // Makes all fields required. If set to '1' no field can not be empty. If
                                                 // set to '0' any or all fields can be empty.

// --------------------------Do not edit below this line--------------------------
$auth = FALSE;
if (substr($HTTP_SERVER_VARS["HTTP_REFERER"], 0, strlen($bronserver)) == $bronserver) $auth = TRUE;
if ($auth) {
  $text = "Resultaten van het kaarten-formulier:\n\n";
  $space = '  ';
  $line = '
  ';
  foreach ($_POST as $key => $value)
  {
    if ($req == '1') {
      if ($value == '') {
        echo "$key is niet ingevuld! Gebruik de back-button van uw browser om het opnieuw te proberen.";die;
      }
    }
    $j = strlen($key);
    if ($j >= 20) {
      echo "Name of form element $key cannot be longer than 20 characters";die;
    }
    $j = 20 - $j;
    for ($i = 1; $i <= $j; $i++) {
      $space .= ' ';
    }
    $value = str_replace('\n', "$line", $value);
    $conc = "{$key}:$space{$value}$line";
    $text .= $conc;
    $space = '  ';
  }
  mail($emailadd, $subject, $text, 'From: '.$emailfrom.'');
  echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
} else die;
?>