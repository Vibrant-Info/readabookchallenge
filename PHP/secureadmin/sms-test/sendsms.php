<?php
  require 'textlocal.class.php';
  $textlocal=new textlocal('readabookchallenge@gmail.com','3a3bdd183ec7601ae380c99c4ad01445ebb1c3ea');
  $bal = $textlocal->sendSms('919739965150','Your MOT is now due, please call 01234 567890 to book or text MOT to 60777 for a callback','AndyCars');
  //$bal = $textlocal->getBalance();
  print_r($bal);
?>