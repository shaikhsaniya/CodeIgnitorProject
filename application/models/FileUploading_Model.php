<?php

class FileUploading_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // for file uploading 
    public function upload_image($img_name, $img_path, $old_img) {
        
        $filename = $_FILES[$img_name]['name'];   // $_FILES['productimage']['name']
        
        $filename = explode(".", $filename);  // abc.jpeg   [abc,jpeg]
        
        $new_filename = $img_name . "_" . date('Ymd') . time() . "." . end($filename);
        // productimage_20210417151600.jpeg
        

        $thumb2 = $new_filename;
        $_FILES['imag']['name'] = $new_filename;
        $_FILES['imag']['type'] = $_FILES[$img_name]['type'];
        $_FILES['imag']['tmp_name'] = $_FILES[$img_name]['tmp_name'];
        $_FILES['imag']['error'] = $_FILES [$img_name]['error'];
        $_FILES['imag']['size'] = $_FILES [$img_name]['size'];
        
        $config = array();
        $config['upload_path'] = './assets/uploads/' . $img_path; 

                                // ./assets/uploads/productimage

        $config['allowed_types'] = 'docx|doc|txt|pdf|jpg|jpeg|png|gif|webp';
        $config['max_size'] = '0';
        $config['overwrite'] = FALSE;
        $this->upload->initialize($config);
        

        if ($this->upload->do_upload('imag')) {
            $imagedata = $this->upload->data();
            $newimagename = $imagedata["file_name"];
            $newimagename = str_replace(" ", "", $newimagename);
            
            $this->load->library("image_lib");
            $config['image_library'] = 'gd2';
            $config['source_image'] = $imagedata["full_path"];
            $config['create_thumb'] = false;
            $config['maintain_ratio'] = TRUE;
            $config['new_image'] = './assets/uploads/' . $img_path . '/100X100';
            $config['width'] = 180;
            $config['height'] = 200;
            $this->image_lib->initialize($config);
            $this->image_lib->resize();
            
        }
        if ($old_img != "") {
            $filename = 'assets/uploads/' . $img_path . '/' . $old_img;
            if (file_exists($filename)) {
                unlink('assets/uploads/' . $img_path . '/' . $old_img);
                unlink('assets/uploads/' . $img_path . '/100X100/' . $old_img);
            }
        }
        //echo $new_filename;die;        
        return $newimagename;
    }

}
