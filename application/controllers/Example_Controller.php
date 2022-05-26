<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Example_Controller extends CI_Controller {

	
	public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->database();
    }

    public function index($params = FALSE) {
        $data['title'] = "Home";
        $data['page'] = "home";
        $this->load->view("website_layout/index",$data);
        // $this->website_layout($data);
    }

    public function addproducts_fun($params = FALSE) {
        $data['title'] = "Add Product";
        $data['page'] = "addproduct";

        $this->db->select('*');
        $this->db->from("tbl_products");
        $query = $this->db->get();
        $result = $query->result_array();
        $data['productslist'] =  $result;

        $this->load->view("website_layout/index",$data);
        // $this->website_layout($data);
    }

    public function saveProducts_fun($params = FALSE) {
        
        $this->form_validation->set_rules('productname', 'Product Name', 'required');   
        $this->form_validation->set_rules('quantity', 'Product Quantity', 'required');   
        $this->form_validation->set_rules('price', 'Product Price', 'required'); 
        if ($this->form_validation->run() == true) {
            
            $this->load->model('FileUploading_Model');
            $img_name = "productimage";
            $img_path = "productimage";
            $old_img = "" ;
            $uploadimagename = $this->FileUploading_Model->upload_image($img_name,$img_path,$old_img);

            $productname  = $this->input->post('productname');
            $price  = $this->input->post('price');
            $quantity  = $this->input->post('quantity');
            $insertdata = array("productname" => $productname,"price" => $price,"quantity" => $quantity,"imagepath" => $uploadimagename);
            $result = $this->db->insert("tbl_products",$insertdata);
            redirect("addproducts");

        }else{
            $this->addproducts_fun();
        }
    }

    public function deleteRecord_fun(){
       
       $productid  = $this->input->post('pid');
       $this->db->where(array("productid" => $productid));
       $success = $this->db->delete("tbl_products");

       // delete from tbl_products where productid = 6

       if($success){
            $response = array("success" => true,"message" => "deleted.");
            echo json_encode($response, true);
            exit;
        }else{
            $response = array("success" => false ,"message" => "record not deleted.");
            echo json_encode($response, true);
            exit;
        }
    }
    
    public function editProducts_fun($params = FALSE) {
        $data['title'] = "Edit Product";
        $data['page'] = "editproduct";

        if(isset($params['productid'])){
            $productid = $params['productid'];
        }else{
            $productid = $this->uri->segment(2);
        }

        $this->db->select('*');
        $this->db->from("tbl_products");
        $this->db->where(array("productid" => $productid));
        $query = $this->db->get();
        $result = $query->result_array();
        $data['productinfo'] =  $result;
        $this->load->view("website_layout/index",$data);
    }

    public function updateProducts_fun($params = FALSE) {
        
        $this->form_validation->set_rules('productname', 'Product Name', 'required');   
        $this->form_validation->set_rules('quantity', 'Product Quantity', 'required');   
        $this->form_validation->set_rules('price', 'Product Price', 'required');
        
        $productid  = $this->input->post('productid');

        if ($this->form_validation->run() == true) {
            $productname  = $this->input->post('productname');
            $price  = $this->input->post('price');
            $quantity  = $this->input->post('quantity');

            $updatedata = array("productname" => $productname,"price" => $price,"quantity" => $quantity);
            
            $this->db->where(array("productid" => $productid));

            $result = $this->db->update("tbl_products",$updatedata);
            
            if($result){
                $this->session->set_flashdata('Message',"<label class='label label-success'>Record Updated Successfully.</label>");
            }else{
                $this->session->set_flashdata('Message',"<label class='label label-danger'>Record Faild To Update.</label>");
            }

            redirect("addproducts");
        }else{
            $params = array("productid" => $productid);
            $this->editProducts_fun($params);
        }
    }



    // public function single($params = FALSE) {
    //     $data['title'] = "Other Page";
    //     $data['page'] = "single";
    //     $this->website_layout($data);
    // }
}
