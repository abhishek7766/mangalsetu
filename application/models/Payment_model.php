<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Payment_Model extends CI_Model
{
    function fetch_products(){

        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->where('status',1);
        $query = $this->db->get();

        $user = $query->result_array();
        
        if(!empty($user)){
            return $user;
        } else {
            return array();
        }
    }

    /*
     * Fetch order data from the database
     * @param id returns a single record
     */
    public function getOrder($id){
        $this->db->select('r.*, p.name as product_name, p.price as product_price, p.currency as product_price_currency');
        $this->db->from('tbl_orders'.' as r');
		$this->db->join('tbl_products'.' as p', 'p.id = r.product_id', 'left');
        $this->db->where('r.id', $id);
        $query  = $this->db->get();
        return ($query->num_rows() > 0)?$query->row_array():false;
    }
    
    /*
     * Insert transaction data in the database
     * @param data array
     */
    public function insertOrder($data){
        $insert = $this->db->insert('tbl_orders',$data);
        return $insert?$this->db->insert_id():false;
    }
}

?>