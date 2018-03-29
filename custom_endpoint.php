/* create custom endpoint for web server */

Note:- 1. copy this function in theme functions.php
2. create a new file name "my-api.php" in theme

endpoint url look like as

http://example.com/?createUser=1

add_action( 'init', 'wpse9870_init_internal' );
function wpse9870_init_internal()
{
    add_rewrite_rule( 'my-api.php$', 'index.php?createUser=1', 'top' );
}

add_filter( 'query_vars', 'wpse9870_query_vars' );
function wpse9870_query_vars( $query_vars )
{
    $query_vars[] = 'createUser';
    return $query_vars;
}

add_action( 'parse_request', 'wpse9870_parse_request' );
function wpse9870_parse_request( &$wp )
{
    if ( array_key_exists( 'createUser', $wp->query_vars ) ) {
        include 'my-api.php';
        exit();
    }
    return;
}

/* how to set endpoint in curl */

function clubpack_remote_user($data){
   $data['createUser'] = 1;
   $ch = curl_init();
   $endpoint =  'http://example.com/';
  
  curl_setopt($ch, CURLOPT_URL, $endpoint);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
  $response = curl_exec ($ch);
  curl_close ($ch);

  return $response;
}
