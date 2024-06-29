<!DOCTYPE html>
<html lang="en" class="gr__rhapsodyofrealities_org">
<script id="tinyhippos-injected">
	if (window.top.ripple) {
		window.top.ripple("bootstrap").inject(window, document);
	}
</script>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>CELVZ- The Shock Troop </title>
	<script src="./NYM_assets/jquery.js"></script>
	<script src="./NYM_assets/croppie.js"></script>
	<link rel="stylesheet" href="./NYM_assets/bootstrap-3.min.css">
	<link rel="stylesheet" href="./NYM_assets/croppie.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<script>
		.panel.panel - heading {
				color: #333; 
    background-color: #ffffff;
				border - color: #f1c562;
			}

			.cr - slider {
				background: #f73736;
				border: 5 px solid #02a9bc;
		}
	</script>
</head>

<body data-gr-c-s-loaded="true">
	<div class="container">
		<div class="panel panel-default" style="border-color: #fff;">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-3 text-left">
						<br> <strong>STEP 1 : Select Image and adjust to fit</strong>
					</div>
					<div class="col-md-5 text-left">
						<br> <input type="file" id="upload">
					</div>
					<div class="col-md-4">
						<br>
						<button class="vanilla-rotate btn-info" data-deg="-90">Rotate Left</button>
						<button class="vanilla-rotate btn-info" data-deg="90">Rotate Right</button>
						<br><br>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 text-center">
						<div id="upload-demo" style="width:360px; background: #253b80; padding: 5px;" class="croppie-container">
						</div>
						<div class="row">
							<div class="col-md-4">
								<br> <strong>STEP 2 :</strong> <button class="btn btn-info upload-result">Upload Image</button> <br><br>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div id="upload-demo-i" style="background:url('NYM_assets/avater.png'); background-size: 350px 350px; width:350px;height:350px;margin-top:30px"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$uploadCrop = $('#upload-demo').croppie({
			enableExif: true,
			viewport: {
				width: 310,
				height: 310,
				type: 'circle'
				// type: 'square'
			},
			boundary: {
				width: 310,
				height: 310
			},
			enableOrientation: true
		});

		$('.vanilla-rotate').on('click', function(ev) {
			$uploadCrop.croppie('rotate', parseInt($(this).data('deg')));
		});

		$('#upload').on('change', function() {
			var reader = new FileReader();
			reader.onload = function(e) {
				$uploadCrop.croppie('bind', {
					url: e.target.result
				}).then(function() {
					console.log('jQuery bind complete');
				});

			}
			reader.readAsDataURL(this.files[0]);
		});


		$('.upload-result').on('click', function(ev) {
			$uploadCrop.croppie('result', {
				type: 'canvas',
				size: 'viewport'
			}).then(function(resp) {
				$.ajax({
					url: "processupload.php",
					type: "POST",
					data: {
						"image": resp
					},
					dataType: 'JSON',
					success: function(data) {
						console.log('response =' + data.img);
						html = '<img width="450px" src="' + data.img + '" /><a href=" ' + data.img + ' " download><button style="margin-top:20px;  margin-bottom:100px" class="btn btn-info upload-result">Download My Avater</button></a>';
						$("#upload-demo-i").html(html);

						var $el = $('#upload');
						$el.wrap('<form>').closest('form').get(0).reset();
						$el.unwrap();
					},
					error: function(error) {
						console.error('Error occured: ', error);
					}
				});
			});
		});
	</script>

</body>

</html>