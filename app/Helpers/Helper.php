<?php
function set_active($uri, $output = 'active')
{
 if( is_array($uri) ) {
   foreach ($uri as $u) {
     if (Request::is($u)) {
       return $output;
     }
   }
 } else {
   if (Request::is($uri)){
     return $output;
   }
 }
}
?>