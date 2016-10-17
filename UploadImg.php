<?php

final class UploadRead
{
	protected $data;
        protected $file;
        protected $upload_dir = 'img/';


        public function __construct(array $data, array $file, $path)
	{
            $this->upload_dir = (string)$path;
            $this->file = (!empty($file))? $file: NULL;
            $this->data = (!empty($data))? $data: NULL;
            
	}
	
        public function printPost($mas = false)
	{
            return (!$mas) ? print_r($this->data) : print_r($this->file);
            
	}
}