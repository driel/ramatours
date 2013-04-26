<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$file_name);
header("Pragma: no-cache");
header("Expires: 0");
print $content_sheet;
?>