<?php
session_start();
header("Content-Type: text/html");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$text = $_SESSION['exitlinks.net_scriptdorks.com_672_txtad'];
$ad_link = $_GET['l'];
echo <<<EOL
<div style="text-align:center;">
<a href="$ad_link" target="_blank">$text</a>
</div>
EOL;
?>