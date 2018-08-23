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
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<style>
	.the-canvas {
		border: 1px solid #000;
		width: 210mm;
		height: 297mm;
		margin-left: auto;
		margin-right: auto;
	}
	.ttd-container {
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
	<div id="app">
		<div class="container">
			<div class="row">
				<form action="process.php" method="post">
					<div class="col-md-12" v-for="(page, key) in pages">
						<div>
							<label>Halaman {{ page.page }}</label>
							<input type="hidden" placeholder="X" name="ttd[]" v-model="pages[key].ttd">
							<input type="text" placeholder="X" name="page[]" v-model="pages[key].page">
							<input type="text" placeholder="X" name="x[]" v-model="pages[key].x">
							<input type="text" placeholder="Y" name="y[]" v-model="pages[key].y">
							<button v-if="!pages[key].ttd" type="button" @click="pages[key].ttd=true">Tambah Tanda Tangan</button>
							<p></p>
							<div v-show="pages[key].ttd" class="ttd-container">
								<div :id="'ttd'+key" style="width: 200px; height: 70px;">
									<a href="javascript:void(0)" @click="pages[key].ttd=null" class="hapus pull-right">Hapus</a>
									<img width="200" height="70" src="download.png" alt="" >
								</div>
								{{ handleTtd('#ttd'+key, key) }}
							</div>
							<canvas :id="'the-canvas'+page.page" class="the-canvas"></canvas>
						</div>
					</div>
					<div class="col-md-12">
						<button type="submit">Generate</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.17/vue.min.js"></script>
	<script src="bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Latest compiled and minified JavaScript -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script src="bower_components/pdfjs-dist/build/pdf.min.js"></script>
	<script src="bower_components/interactjs/dist/interact.min.js"></script>
	
	<script>

		var app = new Vue({
			el: "#app",
			data: {
				pages: []
			},
			mounted () {
				this.renderPdf('pdf.pdf', 'the-canvas');
			},
			methods: {
				renderPdf (url,elemen,pageNumber=null) {
					let vm = this;
					var loadingTask = pdfjsLib.getDocument(url);
					loadingTask.promise.then(function(pdf) {
						console.log('all pages', pdf.numPages);
						// if (!pageNumber) {

							for (var halaman = 1; halaman <= pdf.numPages; halaman++) {
								app.pages.push({
									page: halaman,
									ttd: null,
									x: 0,
									y: 0
								});
								// render page
								vm.renderPage(pdf, elemen, halaman);
							}
						// } else {
						// 	var canvas = document.getElementById(elemen);
						// 	pdf.getPage(pageNumber).then(function(page) { 
						// 		var scale = 1.5;
						// 		var viewport = page.getViewport(scale);
						// 		var context = canvas.getContext('2d');
						// 		canvas.height = viewport.height;
						// 		canvas.width = viewport.width;

						// 		var renderContext = {
						// 			canvasContext: context,
						// 			viewport: viewport
						// 		};
						// 		page.render(renderContext);
						// 	}, function (reason) {
						// 		alert('Halaman '+i+' tidak ditemukan! '+reason);
						// 	});
						// }

					}, function (reason) {
						alert('Gagal memuat file! '+ reason);
						console.error(reason);
					});
				},

				renderPage (pdf, elemen, halaman) {
					pdf.getPage(halaman).then(function(page) {
						var canvas = document.getElementById(elemen+halaman);
						var scale = 1.5;
						var viewport = page.getViewport(scale);
						var context = canvas.getContext('2d');
						canvas.height = viewport.height;
						canvas.width = viewport.width;

						var renderContext = {
							canvasContext: context,
							viewport: viewport
						};
						page.render(renderContext);
					});
				},

				handleTtd (element, key) {
					let vm = this;
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
						vm.pages[key].x = vm.convertToMM(x)
						vm.pages[key].y = vm.convertToMM(y)
					}

					window.dragMoveListener = dragMoveListener;
				},

				convertToMM (val) {
					return val * 0.26458;
				} 
			}
		})

		// jQuery(document).ready(function($) {
		// 	// handleTtd('.ttd');
		// 	// renderPdf('pdf.pdf', 'the-canvas', <?php echo $page ?>);
		// });

		// function handleTtd (element) {
		// 	interact(element)
		// 	.draggable({
		// 		inertia: true,
		// 		restrict: {
		// 			restriction: "parent",
		// 			endOnly: true,
		// 			elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
		// 		},
		// 		autoScroll: true,

		// 		onmove: dragMoveListener,
		// 	});

		// 	function dragMoveListener (event) {
		// 		var target = event.target,
		// 		x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
		// 		y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

		// 		target.style.webkitTransform =
		// 		target.style.transform =
		// 		'translate(' + x + 'px, ' + y + 'px)';

		// 		target.setAttribute('data-x', x);
		// 		target.setAttribute('data-y', y);
		// 		$('input[name=x]').val(convertToMM(x));
		// 		$('input[name=y]').val(convertToMM(y));
		// 	}

		// 	window.dragMoveListener = dragMoveListener;
		// }

		// function convertToMM (val) {
		// 	return val * 0.26458;
		// } 
	</script>
</body>
</html>