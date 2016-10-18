<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Upload</title>
	<script src="jquery.js"></script>
	<style>
		img{
			width: 100px;
			height: 100px;
		}
	</style>
</head>
<body>
	<div class="container">

		<h1>Загрузка файлов:</h1>

		<input type="file" name="images[]" id="images" multiple>
		<hr>
		<div id="images-to-upload">

		</div><!-- end #images-to-upload -->

		<hr>

		<a href="#" class="btn btn-sm btn-success">Загрузить все файлы</a>

	</div><!-- end .container -->


	<script>

		//indirect ajax
		//file collection array
		var fileCollection = new Array();

		$('#images').on('change',function(e){

			var files = e.target.files;

			$.each(files, function(i, file){

				fileCollection.push(file);

				var reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onload = function(e){

					var template = '<form action="/upload">'+
						'<img src="'+e.target.result+'"> '+
						'<label>Image Title</label> <input type="text" name="title">'+
						' <button class="btn btn-sm btn-info upload">Upload</button>'+
						' <a href="#" class="btn btn-sm btn-danger remove">Remove</a>'+
					'</form>';

					$('#images-to-upload').append(template);
				};

			});

		});

		//form upload ... delegation
		$(document).on('submit','form',function(e){

			e.preventDefault();
			//this form index
			var index = $(this).index();

			var formdata = new FormData($(this)[0]); //direct form not object

			//append the file relation to index
			formdata.append('image',fileCollection[index]);

			var request = new XMLHttpRequest();
			request.open('post', 'server.php', true);

			request.send(formdata);

		});
	</script>
</body>
</html>