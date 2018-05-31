/*---------------------------------------------------------------
		TERM AND RECEOVERY FEE CHECKBOX CHECKED BY DEFAULT
------------------------------------------------------------------*/
function my_give_focus_custom_amount() { ?>
    <script>
        jQuery('input.give_fee_mode_checkbox').prop('checked', true);
		jQuery('input[name="give_agree_to_terms"]').prop('checked', true);
    </script>
<?php }
add_action( 'give_post_form_output', 'my_give_focus_custom_amount' );
 
/*-------------------------------------------------------------
		ADD AMOUNT AND FEE SHORTCODE FOR PDF RECEIPT
----------------------------------------------------------------*/  
function give_add_amount_support( $template_content, $payment_id ) {
	
	global $wpdb;
	$table_name = $wpdb->prefix . "posts"; 
	$postData = $wpdb->get_row( "SELECT * FROM $table_name WHERE post_type ='give_payment' and post_title='".$payment_id."'");	
	
	$payment = new Give_Payment( $postData->ID );
		
	$amount = $payment->payment_meta['_give_fee_donation_amount'];	
	$amount = give_currency_filter( give_format_amount( $amount, array( 'sanitize' => false ) ), $payment->currency );
	$amount = html_entity_decode( $amount, ENT_COMPAT, 'UTF-8' );
	
	$template_content = str_replace( '{amount1}', $amount, $template_content );
	
	$feeAmount = $payment->payment_meta['_give_fee_amount'];
	$feeAmount = give_currency_filter( give_format_amount( $feeAmount, array( 'sanitize' => false ) ), $payment->currency );
	$feeAmount = html_entity_decode( $feeAmount, ENT_COMPAT, 'UTF-8' );
	
	$template_content = str_replace( '{fee_amount}', $feeAmount, $template_content );	
	return $template_content;
}
add_filter( 'give_pdf_get_template_content', 'give_add_amount_support', 10, 2 );


/*-----------------------------------------------------
			CHANGE RECEIPT FILE NAME
--------------------------------------------------------*/
function give_custom_receipt_name($name,$id) {
	$fileName = explode('_',$name);
	global $wpdb;
	$table_name = $wpdb->prefix . "posts"; 
	$postData = $wpdb->get_row( "SELECT * FROM $table_name WHERE post_type ='give_payment' and post_title='".$id."'");	
	
	$customer_id = give_get_payment_customer_id($postData->ID);
	$customer    = new Give_Customer( $customer_id );	
	$customerName = preg_replace('/\s+/', '_', $customer->name);
	return $customerName."_";	
} 
add_filter( 'give_custom_pdf_receipt_filename_prefix', 'give_custom_receipt_name', 10,2 );