<?php
     $tipsiest_url = 'http://blog.gartoo.net/tipsiest/tipsiest-b.php';

     if (strcmp($_GET['postcode'],"") != 0) {
     }
         $tipsiest_url .= '?postcode=' . $_GET['postcode'];
     echo file_get_contents($tipsiest_url);
?>
