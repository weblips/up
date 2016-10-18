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

 
$sql= mysql_query("select * from gallery order by ordering;", $link) or die (mysql_error());
$sqlmaxcode= mysql_query("select max(code) from gallery;", $link) or die (mysql_error());
$maxcode= mysql_fetch_array($sqlmaxcode);
$maxcode = $maxcode[0];
if(is_null($maxcode))
	$maxcode = 0;
?>

<!DOCTYPE html>
<html>
<head>
<title>Descriptive multi image uploader</title>
<link rel="stylesheet" href="style.css" />
<link rel="stylesheet" href="js/jquery-ui-1.11.4.custom/jquery-ui.min.css" />
</head>
<body>
<div id="box">
	<h1 style="text-align:center;">Descriptive Multi Image Uploader</h1>
	<div>
		<p>This is an script that consists of a PHP multiple image uploader powered by the jQuery library. You can change the description of the images and its ordering for later use. You can also delete the images and preview them by clicking on the thumbnail. If this wasn't enough, this image uploader is fully responsive!!

		<p>Note: a MySQL table is required to store the details of the images. (The table creation script is included).
	</div>
	<form method="POST" name="form" action="index2.php" ENCTYPE="multipart/form-data">
		<input type="hidden" name="action">
		<table id="images_table">
			<thead>
			<tr>
				<th>
					Preview (click<br/>to enlarge)
				</th>
				<th>
					Name
				</th>
				<th>
					Description
				</th>
				<th>
					Select image
				</th>
				<th>
					Delete			
				</th>
                <th>
                    <a target="_blank" title="Uploader developed by Oligalma" href="http://oligalma.com"><b>?</b></a>
                </th>
			</tr>
			</thead>
			<tbody id="sortable">
			<?php
			$codesarray = array();
			while($info= mysql_fetch_array($sql)):
				$codesarray[] = $info['code'];
			?>
			<tr <?= (count($codesarray) % 2 == 0 ? 'class="even"' : '') ?>>
				<td>
					<a data-overlay-trigger="overlay" href="#" rel="prettyPhoto" ><img src="<?= DIR_IMAGES . $info['file'] ?>" /></a>
				</td>
				<td>
                    <input type="text" name="name<?= $info['code']?>" value="<?= $info['name']?>" />
				</td>
				<td>
					<input type="text" name="description<?= $info['code']?>" value="<?= $info['description']?>" />
				</td>
				<td>
					<input type="file" name="image<?= $info['code']?>" />
				</td>
				<td>
					<input type="checkbox" name="delete<?= $info['code']?>" />
				</td>
                <td>
                    <input class="sortable-item" type="hidden" name="ordering<?= $info['code']?>" value="<?= $info['ordering']  ?>" />
                    <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
                </td>
			</tr>
			<?php
			endwhile;
			?>
			<tr <?= ((count($codesarray) + 1) % 2 == 0 ? 'class="even"' : '') ?>>
				<td>
				</td>
				<td>
				    <input type="text" name="name<?= $maxcode + 1 ?>" />					
				</td>
				<td>
					<input type="text" name="description<?= $maxcode + 1 ?>" />
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
			<input type="submit" value="Update >>">
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
	var codesarray = <?= json_encode($codesarray) ?>;
	var numrows = <?= count($codesarray) ?>;
	
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
