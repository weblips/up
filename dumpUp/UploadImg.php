<?php

final class UploadRead
{
	protected $data;
        protected $file;
        protected $upload_dir = 'img/';
        private $override_file;
        private $override_data;
        private $override;


        public function __construct(array $data, array $file, $path = FALSE)
	{
            $this->upload_dir = (string)$path;
            $this->file = (!empty($file))? $file: NULL;
            $this->data = (!empty($data))? $data: NULL;
            $this->overrideData();
	}
	
        public function printPost($mas = false)
	{
            return (!$mas) ? print_r($this->data) : print_r($this->file);
            
	}
        
        protected function overrideData()
        {
            $this->override_data = array_diff($this->data, array(''));
            for($i =0; $i<count($this->file); $i++){
                if($this->file['image'.$i]['tmp_name']) 
                    $override_file[$i] =$this->file['image'.$i]['tmp_name'];
            }
            $this->override_file = isset($override_file) ? $override_file : NULL;
        }
        
        public function writeData(array $data)
        {
            foreach($this->override_data as $key => $v){
                if(strstr($key,'url')){
                   $data[(str_replace('url', '', $key))] = $v;
                   
                }
                if(strstr($key,'delete')){
                    switch ($key){
                        case 0 : unlink($this->upload_dir . 'banner_1_1.jpg' );
                            break;
                        case 1 : unlink($this->upload_dir . 'banner_1_2.jpg' );
                            break;
                        case 2 : unlink($this->upload_dir . 'banner_2_1.jpg' );
                            break;
                        case 3 : unlink($this->upload_dir . 'banner_2_2.jpg' );
                            break;
                        default : echo 'Next relize';
                    }
                }
            }
            if(!empty($data))$this->toDoc($data);
        }
        public function toDoc($data)
        {
            unlink($this->upload_dir . 'data.txt');
            $this->override = $data;
            file_put_contents($this->upload_dir . 'data.txt', implode('|', $data));
        }
        public function getOverride(){
            return $this->override; 
        }
        
        public function toImg()
        {
            if(empty($this->override_file)) return;
            foreach($this->override_file as $k => $v){
                switch ($k){
                    case 0 :  move_uploaded_file ( $v , $this->upload_dir . 'banner_1_1.jpg' );
                        break;
                    case 1 :  move_uploaded_file ( $v , $this->upload_dir . 'banner_1_2.jpg' );
                        break;
                    case 2 :  move_uploaded_file ( $v , $this->upload_dir . 'banner_2_1.jpg' );
                        break;
                    case 3 :  move_uploaded_file ( $v , $this->upload_dir . 'banner_2_2.jpg' );
                        break;
                    default : echo 'Next relize';
                }
            }
        }
}