<?php
// Task number 1: https://docs.google.com/document/d/1bOcamPMlktAIYrQ7iqK8h420wucNwGESGw1dCl2iQIo
//set cookies 
add_action('init','rgb_set_cookies');
 function rgb_set_cookies(){
    setcookie('specific_cookie',1);
 }

// get Cookie 
add_action('template_redirect','rgb_specific_cookie_redirect');
function rgb_specific_cookie_redirect(){
    //$pagename = get_query_var('pagename');
  var_dump( $_COOKIE['specific_cookie']);
     if(isset($_COOKIE['specific_cookie'])){
        if(1 === $_COOKIE['specific_cookie'] ){
            //setcookie('specific_cookie',2);
           // wp_redirect( get_site_url()); exit;
        }
       
    }
}

// Solution here:
// Task number 2: https://docs.google.com/document/d/1XEL1mwly1aZSlEIOUy3c4i9IHKPiMGMf00kIP4tA3FM/edit

// Solution here:
 // random token generator 
// add_action('wp_head',function () {
//     $randNumber = openssl_random_pseudo_bytes(16);
//     $token_value = bin2hex($randNumber);
//     $objects = [];
//         for ($i=0; $i<7; $i++) {
//         $objects[] = (object) [
//             "token" =>$token_value,
//         ];
//         }
//       //   print_r($objects);
//       //echo json_encode($objects);
  
//   }); 