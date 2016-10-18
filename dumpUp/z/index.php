<?php
    $path = __DIR__ . DIRECTORY_SEPARATOR ."upload"; // задаем путь до сканируемой папки с изображени€ми
    $iterator = new DirectoryIterator($path);
	echo '<pre>';
	foreach ($iterator as $fileinfo){
		if($fileinfo->isFile())echo 
		$fileinfo->getFilename() . '<br>';
	}
	?>
<!DOCTYPE html>
<html>
<head>
<title>Title of the document</title>
</head>

<body>
<h1>Ѕаннеры</h1>
<h2>”краинские баннеры</h2>
<div class="ua-banner">
<tr>
	<td>
		<img src="<?php file_exists($path) ?>" width="189" height="255" alt="lorem">
	</td>
	<td>
		<img src="images/girl.png" width="189" height="255" alt="lorem">
	</td>
</tr>
</div>
<h2>Pус баннеры</h2>
<div class="ru-banner">
<tr>
	<td>
		<img src="images/girl.png" width="189" height="255" alt="lorem">
	</td>
	<td>
		<img src="images/girl.png" width="189" height="255" alt="lorem">
	</td>
</tr>
</div>
</body>
</html>
<?php
$pathUpload = __DIR__ . DIRECTORY_SEPARATOR . 'upload';

?>