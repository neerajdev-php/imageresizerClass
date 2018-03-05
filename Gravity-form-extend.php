// define the fields we'll be populating
$fields = array('first_name', 'last_name','mrn_number'); 
// loop through fields and add the Gravity Forms filters
foreach($fields as $field){
  add_filter('gform_field_value_'.$field, 'my_populate_field');
}
 
 
// the callback that gets called to populate each field
function my_populate_field($value){

  // we have to wrestle the field name out of the filter name,
  // since GF doesn't pass it to us
  $filter = current_filter();


  if(!$filter) return '';
 $field = trim(str_replace('gform_field_value_', '', $filter));
 $return=array('first_name'=>'Neeraj','last_name'=>'Chaturvedi','mrn_number'=>9887113223);
if(!$field) return '';
 
  // get the current logged in user object
  $user = wp_get_current_user();
 
  // We'll just return the user_meta value for the key we're given.
  // In most cases, we'd want to do some checks and/or apply some special
  // case logic before returning.


 //return $return[$field];
$getData= get_user_meta($user->ID, 'consent_data', true);


  return $getData['consent'][$field];
}


add_action('gform_after_submission', 'endo_add_entry_to_db', 10, 2);
function endo_add_entry_to_db($entry, $form) {
  $param=array();
     	$param['consent']['source_url']= $entry['source_url'];  
		$param['consent']['first_name'] = 	$entry[1];
		$param['consent']['last_name'] = 	$entry[2];
		$param['consent']['mrn_number'] = 	$entry[3];
   $user = wp_get_current_user();
  update_user_meta($user->ID, 'consent_data',$param);
}
