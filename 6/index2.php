<?php
/**
 * Descriptive multi image uploader
 *
 * @author Marc Oliveras Galvez <oligalma@gmail.com> 
 * @link http://www.oligalma.com
 * @copyright 2015 Oligalma
 * @license GPL
 */
       
include ('includes.inc');

foreach($_POST as $key => $value)
{
    if(substr($key, 0, 6) === 'delete')
    {
        $code = substr($key,6);
        $delete = $_POST['delete' . $code];
 
        $sqlImage = mysql_query("select * from gallery where code= $code;", $link) or die (mysql_error());
        $image = mysql_fetch_array($sqlImage);
        if($image != null)
        {
            if(file_exists(DIR_IMAGES . $image['file']))
                unlink(DIR_IMAGES . $image['file']);
        }
        
        mysql_query("delete from gallery where code=$code", $link) or die (mysql_error());
    }
}

foreach($_POST as $key => $value)
{
    if(substr($key, 0, 8) === 'ordering')
    {
        $code = substr($key,8);
        $ordering = $_POST['ordering' . $code];
        if(!is_numeric($ordering))
        {
            $ordering = 0;
        }
        
        mysql_query("update gallery set ordering=$ordering where code=$code", $link) or die (mysql_error());     
    }
	
    if(substr($key, 0, 4) === 'name')
    {
        $code = substr($key,4);
        $name = $_POST['name' . $code];      
        mysql_query("update gallery set name='" . mysql_real_escape_string($name) .  "' where code=$code", $link) or die (mysql_error());     
    }
    	
    if(substr($key, 0, 11) === 'description')
    {
        $code = substr($key,11);
        $description = $_POST['description' . $code];      
        mysql_query("update gallery set description='" . mysql_real_escape_string($description) .  "' where code=$code", $link) or die (mysql_error());     
    }
}

foreach($_FILES as $key => $value)
{
    if($value['name'] != '' && ($value['type'] == 'image/jpeg' || $value['type'] == 'image/png' || $value['type'] == 'image/gif'))
    {
        $code = substr($key,5);
        $name = $_POST['name' . $code];
        $ordering = $_POST['ordering' . $code];
		$description = $_POST['description' . $code];
		
        if(!is_numeric($ordering))
        {
            $ordering = 0;
        }
     
        $sqlImage = mysql_query("select * from gallery where code= $code;", $link) or die (mysql_error());
        $image = mysql_fetch_array($sqlImage);

        $extension = '';
        switch($value['type'])
        {
            case 'image/jpeg':
                $extension = 'jpg';
                break;
            case 'image/png':
                $extension = 'png';
                break;
            case 'image/gif':
                $extension = 'gif';
                break;
        }
                       
        if($image != null) // update
        {
            if(file_exists(DIR_IMAGES . $image['file']))
                unlink(DIR_IMAGES . $image['file']);
            
            mysql_query("update gallery set name='$name', ordering=$ordering, description='" . mysql_real_escape_string($description) . "', file='" . $code . '.' . $extension . "' where code=$code", $link) or die (mysql_error());
        }
        else // insert
        {
            mysql_query("insert into gallery(code, name, ordering, description,file) values ($code, '$name', $ordering, '" . mysql_real_escape_string($description) . "','" . $code . '.' . $extension .  "')", $link) or die (mysql_error());           
        }
                     
        move_uploaded_file($value['tmp_name'],DIR_IMAGES . $code . '.' . $extension);
        //chmod(DIR_IMAGES . $name, 755);
    }
}
?>
	<script>
		self.location="index.php";
	</script>