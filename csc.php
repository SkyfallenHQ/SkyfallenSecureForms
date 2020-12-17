<?php
$f = fopen(".htaccess", "a+");
$f2 = fopen("ApacheHtaccess", "r");
fwrite($f, fread($f2, filesize("ApacheHtaccess")));
fclose($f);
fclose($f2);