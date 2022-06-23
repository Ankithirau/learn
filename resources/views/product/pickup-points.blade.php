<?php

$option='<option value="">Select Pickup Points</option>';
if(!empty($result)):
foreach($result as $res):
foreach ($res as $k => $val):
$option .='<option value="'.$val->id.'">'.$val->name.'</option>';
endforeach;
endforeach;
endif;
echo $option;
?>