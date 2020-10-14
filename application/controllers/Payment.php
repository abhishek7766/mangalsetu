<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('stripe_lib');
        $this->load->model('payment_model');
    }

	public function index()
	{
        if($this->input->server('REQUEST_METHOD') == 'POST'){
            
            $postData = $this->input->post();
			// Make payment
			$paymentID = $this->checkout($postData);
			
			// If payment successful
			if($paymentID){
				redirect('payment/payment_status/'.$paymentID);
			}else{
				$apiError = !empty($this->stripe_lib->api_error)?' ('.$this->stripe_lib->api_error.')':'';
				$data['error_msg'] = 'Transaction has been failed!'.$apiError;
			}
        }else{
            
            $data['product_deatil'] = $this->payment_model->fetch_products();
            $this->load->view('page/payment',$data);

        }
    }

    function checkout($postData){
		
		// If post data is not empty
		if(!empty($postData)){
			// Retrieve stripe token, card and user info from the submitted form data
			$token  = $postData['stripeToken'];
			$name = $postData['name'];
			$email = 'a@a.com';
			$card_number = $postData['card_number'];
			$card_number = preg_replace('/\s+/', '', $card_number);
			$card_exp_month = $postData['card_exp_month'];
			$card_exp_year = $postData['card_exp_year'];
			$card_cvc = $postData['card_cvc'];
			
			// Unique order ID
			$orderID = strtoupper(str_replace('.','',uniqid('', true)));
			
            // Add customer to stripe
            $member_data['name']    = $name;
            $member_data['email']   = $email;
			$customer = $this->stripe_lib->addCustomer($member_data, $token);
			
			if($customer){
                
                // Charge a credit or a debit card
				$charge = $this->stripe_lib->createCharge($customer->id, $postData['product_name'], $postData['product_price'], $orderID);
				
				if($charge){
					// Check whether the charge is successful
					if($charge['amount_refunded'] == 0 && empty($charge['failure_code']) && $charge['paid'] == 1 && $charge['captured'] == 1){
						// Transaction details 
						$transactionID = $charge['balance_transaction'];
						$paidAmount = $charge['amount'];
						$paidAmount = ($paidAmount/100);
						$paidCurrency = $charge['currency'];
						$payment_status = $charge['status'];
						
						
						// Insert tansaction data into the database
						$orderData = array(
							'product_id' => $postData['product_id'],
							'name_on_card' => $name,
							'memberId' => "MSM-001",
							'card_number' => $card_number,
							'card_exp_month' => $card_exp_month,
							'card_exp_year' => $card_exp_year,
							'paid_amount' => $paidAmount,
							'paid_amount_currency' => $paidCurrency,
							'txn_id' => $transactionID,
							'payment_status' => $payment_status
						);
						$orderID = $this->payment_model->insertOrder($orderData);
						
						// If the order is successful
						if($payment_status == 'succeeded'){
							return $orderID;
						}
					}
				}
			}
		}
		return false;
    }
	
	function payment_status($id){
		$data = array();
		
		// Get order data from the database
        $order = $this->payment_model->getOrder($id);
		
        // Pass order data to the view
		$data['order'] = $order;
        $this->load->view('page/payment_status', $data);
    }

}
