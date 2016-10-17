<?php
header('Content-Type: text/html; charset=cp-1251');
define("DIR_IMAGES", "img/");
$iterator = new DirectoryIterator(DIR_IMAGES);
$link_arr  = trim(file_get_contents(DIR_IMAGES . 'data.txt'));
$arr_link = explode("|", $link_arr);
print_r($arr_link);
foreach($iterator as $fileinfo){
	if($fileinfo->isFile() && $fileinfo->getFilename() !== 'data.txt') 
		$arr_path[$fileinfo->getFilename()] =  $fileinfo->getPathname();
}
$maxcode = count($arr_path);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){
    echo '<pre>';
    print_r($_POST);
    foreach($_POST as $key => $value){
        //echo $key . '<br />';
        if(($pos = strpos($key, 'delete')) !== false ){
           $nameI = str_replace('delete', '', $key);
        
          if(file_exists($far = DIR_IMAGES . str_replace('_', '.', $nameI)))
            unlink($far);
        }
    }
    echo '<hr>';
    print_r($_FILES);
    
    $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);
    foreach($_FILES as $k => $v){
         
    }
}	
?>
<!DOCTYPE html>
<html>
<head>
<title>Баннер</title>
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="js/jquery-ui-1.11.4.custom/jquery-ui.min.css" />
</head>
<body>
<div id="box">
	<h1 style="text-align:center;">Баннер</h1>
	<form method="POST" name="form" action="" ENCTYPE="multipart/form-data">
		<input type="hidden" name="action">
		<table id="images_table">
			<thead>
			<tr>
				<th>
					Превью(нажми<br/>для увеличения)
				</th>
				<th>
					Ссылка
				</th>
				<th>
					Выбрать изображение
				</th>
				<th>
					Удалить			
				</th>
                <th>
                    D
                </th>
			</tr>
			</thead>
			<tbody id="sortable">
                            <?php $i=0;?>
			<?php foreach($arr_path as $image_name => $image_path): ?>
			<tr <?= (count($arr_path) % 2 == 0 ? 'class="even"' : '') ?>>
				<td>
					<a data-overlay-trigger="overlay" href="" rel="prettyPhoto" ><img src="<?= $image_path ?>" /></a>
				</td>
				<td>
                    <input type="text" name="name<?= $image_name ?>" value="<?= $arr_link[$i]?>" />
				</td>
				<td>
					<input type="file" name="image<?= $image_name?>"/>
				</td>
				<td>
					<input type="checkbox" name="delete<?= $image_name?>" />
				</td>
                <td>
                    <input class="sortable-item" type="hidden" name="ordering<?= $image_name?>" value="<?= $image_name ?>" />
                    <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                </td>
			</tr>
                        <?php $i++; ?>
			<?php
			endforeach;
                        $i = 0;
			?>
			<tr <?= ((count($arr_path) + 1) % 2 == 0 ? 'class="even"' : '') ?>>
				<td>
				</td>
				<td>
				    <input type="text" name="name<?= $maxcode + 1 ?>" />					
				</td>
				<td>
					<input type="file" name="image<?= $maxcode + 1 ?>" />
				</td>
				<td>
	
				</td>
                <td>
                    <input class="sortable-item" type="hidden" name="ordering<?= $maxcode + 1 ?>" value="0" />
                    <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                </td>
			</tr>
			</tbody>
		</table>
		<div id="submit-button">
			<input type="submit" value="Обновить >>">
	    </div>
	</form>
</div>
<div class="overlay" id="overlay">
  <div class="modal">
	<img src="" />
  </div>
</div>
<script src="js/jquery-2.1.4.min.js"></script>
<script src="js/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
<script>
	var maxcode = <?= $maxcode + 1 ?>;
	var filename = '';
	var codesarray = <?= json_encode($arr_path) ?>;
	var numrows = <?= count($arr_path) ?>;
	
    $("form").on('focus', 'input[type="file"]', function () {
		filename = $(this).val();
    });
	
	$("form").on('change', 'input[type="file"]', function(){
		var str = $(this).attr('name');
		var res = str.substring(6);
		//if (filename == '' && $.inArray(res,codesarray) == -1) {		
			maxcode++;
          //  alert('bbb');
            $('#images_table').append('<tr ' + (numrows % 2 == 0 ?'class="even"':'') + '><td></td><td><input type="text" name="name' + maxcode + '" /></td><td><input type="text" name="description' + maxcode + '" /></td><td><input type="file" name="image' + maxcode + '" /></td><td></td><td><input class="sortable-item" type="hidden" name="ordering' + maxcode + '" value="0" /><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></td></tr>');
			numrows++;
		//}
		newfile = false;

        reorder();
	});
	
      $(function(){
        $("#sortable").sortable(
            {
                axis: "y",
                stop: function(event, ui) {
                    reorder();
                }
            }
        );
      });
      
      function reorder()
      {
            i = 1;
            $(".sortable-item").each(function(){
                $(this).val(i);
                i++;
            })
      }
</script>
<script src="js/script.js"></script>
</body>
</html> 
