<?php
$page = 1; 
if (isset($_GET['page'])) {
	$page = $_GET['page'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Drag and drop</title>
	<style>
	body {
		margin: 0px !important;
	}
	#the-canvas {
		border: 1px solid #000;
		width: 210mm;
		height: 297mm;
		margin-left: auto;
		margin-right: auto;
	}
	#ttd-container {
		border: 1px solid #000;
		width: 210mm;
		height: 297mm;
		margin-left: auto;
		margin-right: auto;
		display: block;
		position: absolute;
	}
</style>
</head>
<body>
	<form action="process.php" method="post">
		<label>Posisi</label>
		<input type="hidden" name="page" value="<?php echo $page ?>">
		<input type="text" placeholder="X" name="x">
		<input type="text" placeholder="Y" name="y">
		<button type="submit">Generate</button>
	</form>
	<div id="ttd-container">
		<img width="200" height="70" src="download.png" alt="" class="ttd">
	</div>
	<canvas id="the-canvas"></canvas>
	
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<script src="bower_components/pdfjs-dist/build/pdf.min.js"></script>
	<script src="bower_components/interactjs/dist/interact.min.js"></script>

	<script>
		jQuery(document).ready(function($) {
			handleTtd('.ttd');
			renderPdf('pdf.pdf', 'the-canvas', <?php echo $page ?>);
		});

		function handleTtd (element) {
			interact(element)
			.draggable({
				inertia: true,
				restrict: {
					restriction: "parent",
					endOnly: true,
					elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
				},
				autoScroll: true,

				onmove: dragMoveListener,
			});

			function dragMoveListener (event) {
				var target = event.target,
				x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
				y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

				target.style.webkitTransform =
				target.style.transform =
				'translate(' + x + 'px, ' + y + 'px)';

				target.setAttribute('data-x', x);
				target.setAttribute('data-y', y);
				$('input[name=x]').val(convertToMM(x));
				$('input[name=y]').val(convertToMM(y));
			}

			window.dragMoveListener = dragMoveListener;
		}

		function convertToMM (val) {
			return val * 0.26458;
		} 

		function renderPdf (url,elemen,pageNumber) {
			var loadingTask = pdfjsLib.getDocument(url);
			loadingTask.promise.then(function(pdf) {
				pdf.getPage(pageNumber).then(function(page) {
					var scale = 1.5;
					var viewport = page.getViewport(scale);

					var canvas = document.getElementById(elemen);
					var context = canvas.getContext('2d');
					canvas.height = viewport.height;
					canvas.width = viewport.width;

					var renderContext = {
						canvasContext: context,
						viewport: viewport
					};
					page.render(renderContext);
				}, function (reason) {
					alert('Halaman <?php echo $page ?> tidak ditemukan! '+reason);
				});

			}, function (reason) {
				alert('Gagal memuat file! '+ reason);
				console.error(reason);
			});
		}
	</script>
</body>
</html>