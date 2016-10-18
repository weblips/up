<?php
header('Content-Type: text/html; charset=cp-1251');
define("DIR_IMAGES", "img/");
// iterator dir not > data.txt
function iteratorFile(){
$iterator = new DirectoryIterator(DIR_IMAGES);
foreach($iterator as $fileinfo){
	if($fileinfo->isFile() && $fileinfo->getFilename() !== 'data.txt') 
		$arr_path[$fileinfo->getFilename()] =  $fileinfo->getPathname();
        }
   return $arr_path;
}
$arr_path = iteratorFile();
$maxcode = count($arr_path);
// readFile
$link_arr  = trim(file_get_contents(DIR_IMAGES . 'data.txt'));
$arr_link = explode("|", $link_arr);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){
    require_once 'UploadImg.php';
    $uploadimg = new UploadRead($_POST, $_FILES, DIR_IMAGES);
    $uploadimg->writeData($arr_link);
    $arr_link = $uploadimg->getOverride();
    $uploadimg->toImg();
    $arr_path = iteratorFile();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Баннер</title>

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
			<th>Превью(нажми<br/>для увеличения)</th>
			<th>Ссылка</th>
			<th>Выбрать изображение</th>
			<th>Удалить</th>
                        <th>D</th>
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
                            <input type="text" name="url<?=$i ?>" value="<?= $arr_link[$i]?>" />
			</td>
			<td>
                            <input type="file" name="image<?=$i ?>"/>
			</td>
			<td>
                            <input type="checkbox" name="delete<?=$i?>" />
			</td>
                        <td>
                            <input class="sortable-item" type="hidden" name="ordering<?=$i?>" value="<?=$i ?>" />
                            <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                        </td>
                    </tr>
                <?php $i++; ?>
		<?php endforeach;?>
                <?php $i = 0;?>
                    <tr <?= ((count($arr_path) + 1) % 2 == 0 ? 'class="even"' : '') ?>>
			<td>
			</td>
			<td>
                            <input type="text" name="url<?= $maxcode + 1 ?>" />					
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
    <style type="text/css">
       #images_table td:first-child,#images_table th:first-child{text-align:left;padding-left:20px}#images_table td,#images_table th{padding:5px;border-bottom:1px solid #e0e0e0}#images_table tr,#submit-button,.center,footer{text-align:center}footer,footer a{color:#000}#images_table a:link{color:#666;font-weight:700;text-decoration:none}#images_table a:visited{color:#999;font-weight:700;text-decoration:none}#images_table a:active,#images_table a:hover{color:#bd5a35;text-decoration:underline}#images_table{font-family:Arial,Helvetica,sans-serif;color:#666;font-size:12px;text-shadow:1px 1px 0 #fff;background:#eaebec;margin:20px;border:1px solid #ccc;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;-moz-box-shadow:0 1px 2px #d1d1d1;-webkit-box-shadow:0 1px 2px #d1d1d1;box-shadow:0 1px 2px #d1d1d1}#images_table th{border-top:1px solid #fafafa;background:#ededed;background:-webkit-gradient(linear,left top,left bottom,from(#ededed),to(#ebebeb));background:-moz-linear-gradient(top,#ededed,#ebebeb)}#images_table tr:first-child th:first-child{-moz-border-radius-topleft:3px;-webkit-border-top-left-radius:3px;border-top-left-radius:3px}#images_table tr:first-child th:last-child{-moz-border-radius-topright:3px;-webkit-border-top-right-radius:3px;border-top-right-radius:3px}#images_table tr{padding-left:20px}#images_table td:first-child{border-left:0}#images_table td{border-top:1px solid #fff;border-left:1px solid #e0e0e0;background:#fafafa;background:-webkit-gradient(linear,left top,left bottom,from(#fbfbfb),to(#fafafa));background:-moz-linear-gradient(top,#fbfbfb,#fafafa)}#images_table tr td:nth-child(6){cursor:move}.overlay,.overlay .modal{cursor:pointer;top:0;bottom:0;right:0;left:0}#images_table tr.even td{background:#f2f2f2;background:-webkit-gradient(linear,left top,left bottom,from(#f4f4f4),to(#f2f2f2));background:-moz-linear-gradient(top,#f4f4f4,#f2f2f2)}#images_table tr:last-child td{border-bottom:0}#images_table tr:last-child td:first-child{-moz-border-radius-bottomleft:3px;-webkit-border-bottom-left-radius:3px;border-bottom-left-radius:3px}#images_table tr:last-child td:last-child{-moz-border-radius-bottomright:3px;-webkit-border-bottom-right-radius:3px;border-bottom-right-radius:3px}#images_table tr:hover td{background:#ededed;background:-webkit-gradient(linear,left top,left bottom,from(#ededed),to(#ededed));background:-moz-linear-gradient(top,#ebebeb,#ebebeb)}#images_table th,#images_table th a{font-weight:700!important;color:#333!important}footer,footer a{font-weight:700}#images_table th:nth-child(6) a{font-size:15px}#images_table a img{width:100px;height:100px;border:1px solid gray}#submit-button input{width:200px;height:50px;font-size:20px;font-weight:700}.overlay,.overlay .modal img{width:100%;height:100%}table td{text-align:left}.overlay{visibility:hidden;opacity:0;position:fixed;z-index:10;background-color:#000;background-color:rgba(0,0,0,.85);-webkit-transition:opacity .3s ease-in-out;-moz-transition:opacity .3s ease-in-out;-ms-transition:opacity .3s ease-in-out;-o-transition:opacity .3s ease-in-out;transition:opacity .3s ease-in-out}.overlay .modal{position:absolute;z-index:11;margin:auto;padding:20px;background-color:#fff;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px}.overlay.shown{opacity:1}footer{margin-top:20px;padding:10px}@media all and (min-width:1024px){#box{width:1024px}}@media all and (max-width:850px){#images_table,#images_table input[type=text]{padding:0;margin:0;width:100%}#images_table td:last-child{padding-bottom:20px}#images_table table,#images_table tbody,#images_table td,#images_table th,#images_table thead,#images_table tr{display:block}#images_table thead tr{position:absolute;top:-9999px;left:-9999px}#images_table tr{border:1px solid #ccc}#images_table td{border:none;border-bottom:1px solid #eee;position:relative;padding-left:35%;padding-bottom:10px;padding-top:10px;word-wrap:break-word}#images_table td:before{position:absolute;top:6px;left:6px;width:45%;padding-right:10px;white-space:nowrap;padding-bottom:10px;padding-top:10px;font-weight:700}#images_table img{margin-left:35%}#submit-button{margin-top:10px}#images_table td:nth-of-type(1):before{content:"Image"}#images_table td:nth-of-type(2):before{content:"Name"}#images_table td:nth-of-type(3):before{content:"Description"}#images_table td:nth-of-type(4):before{content:"Select image"}#images_table td:nth-of-type(5):before{content:"Delete"}}
    </style>
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
		var str = $(this).attr('url');
		var res = str.substring(6);
		//if (filename == '' && $.inArray(res,codesarray) == -1) {		
			maxcode++;
          //  alert('bbb');
            $('#images_table').append('<tr ' + (numrows % 2 == 0 ?'class="even"':'') + '><td></td><td><input type="text" name="url' + maxcode + '" /></td><td><input type="text" name="description' + maxcode + '" /></td><td><input type="file" name="image' + maxcode + '" /></td><td></td><td><input class="sortable-item" type="hidden" name="ordering' + maxcode + '" value="0" /><span class="ui-icon ui-icon-arrowthick-2-n-s"></span></td></tr>');
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