
<?php
$time = strtotime( date('Y-m-d H:s:i') );
$final = date("d-m-Y H:s:i", strtotime("+1 month", $time));
echo $final;
?>