<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Test</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<style>
	.preview {
		position:absolute;
		height: 1024px;
		width: 100%;
		overflow: scroll;
	}
</style>
</head>
<body>

	<div id="app">
		<div class="col-md-8" style="height: 100%;">
			<iframe class="preview" src="preview.php"></iframe>
		</div>
		<div class="col-md-4">
			<table class="table">
				<thead>
					<tr>
						<th>ID</th>
						<th>Halaman</th>
						<th>X</th>
						<th>Y</th>
						<th>Orientation</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>


	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js"></script>
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script>
		jQuery(document).ready(function($) {
			$('#preview').attr('src','preview.php');
		});
	</script>
</body>
</html>