// Common JavaScript Functions

function getSortedCol() {
	var get_col = $('thead tr:first th.sorted').text();
	var sorted_col = 'order_date';

	switch(get_col)
	{
	case 'Order Ref. No':
		sorted_col = 'order_generated_id';
		break;
	case 'Customer Name':
		sorted_col = 'lastname';
		break;
	case 'Email Address':
		sorted_col = 'email_address';
		break;
	case 'Phone':
		sorted_col = 'phone';
		break;
	case 'Total':
		sorted_col = 'total_cost';
		break;
	case 'Date Purchased':
		sorted_col = 'order_date';
		break;
	
	case 'Order Status':
		sorted_col = 'order_status';
		break;
	default:
		sorted_col = 'order_date';
	}
	
	return sorted_col;			

}

function getSortOrder() {
	var get_order = $('thead tr:first th.sorted div').attr('class');			
	var sort_order = 'asc';
	if ( get_order == 'sdesc' ) {
		sort_order = 'desc';
	}
	return sort_order;
}
