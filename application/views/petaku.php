<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<title><?= $this->session->userdata("username"); ?> | Sistem Manajemen Aset</title>

	<link rel="icon" href="<?= base_url("assets/"); ?>files/364.jpg" type="image/jpg">
	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/fontawesome-free/css/all.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url("assets"); ?>/dist/css/adminlte.min.css">
	<!-- Tempusdominus Bbootstrap 4 -->
	<link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

	<!-- Toastr -->
	<link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.css">
	<!-- Daterangepicker -->
	<link rel="stylesheet" href="<?= base_url("assets"); ?>/plugins/daterangepicker/daterangepicker.css">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<?php
	// Set a same-site cookie for first-party contexts
	// setcookie('cookie1', 'value1', ['samesite' => 'Lax']);
	// Set a cross-site cookie for third-party contexts
	// setcookie('cookie2', 'value2', ['samesite' => 'None', 'secure' => true]);
	?>
	<style>
		#map {
			height: 1000px;
			width: 100%;
		}

		#wrapper {
			position: relative;
		}

		#over_map {
			position: absolute;
			top: 80px;
			left: 10px;
			z-index: 9999;
			display: none;
		}

		#floating-panel {
			position: absolute;
			top: 30px;
			left: 25%;
			z-index: 5;
			background-color: #fff;
			padding: 5px;
			border: 1px solid #999;
			text-align: center;
			font-family: 'Roboto', 'sans-serif';
			line-height: 30px;
			padding-left: 10px;
		}

		.ui-autocomplete {
			position: absolute;
			cursor: default;
			z-index: 9999 !important;
		}
	</style>


	<!-- Leaflet -->
	<!-- <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" /> -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.0/leaflet.css" integrity="sha512-kJ6ziQLUtmzCmfxjM5bdvDWvAjSqKp+wPsQAGdc6zb6h/7zqn+RnZ9T7lEzj/TeSu8iK5lcxsQdDIhz4wLDKzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
	<link rel="stylesheet" href="https://www.liedman.net/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">

<body class="hold-transition sidebar-mini sidebar-collapse layout-fixed">
	<input type="hidden" id="base_link" value="<?= base_url(); ?>">
	<!-- jQuery -->
	<script src="<?= base_url("assets"); ?>/plugins/jquery/jquery.min.js"></script>

	<!-- Bootstrap 4 -->
	<script src="<?= base_url("assets"); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url("assets"); ?>/dist/js/adminlte.min.js"></script>
	<!-- Main content -->
	<nav class="navbar navbar-expand-lg navbar-light bg-light">

		<img src="<?= base_url("assets"); ?>/files/364.jpg" style="width:5%" alt="Logo" class="brand-image img-circle mr-2"><a class="navbar-brand mr-4" href="<?= base_url("Petaku/tampil"); ?>">Sistem Informasi Pencarian Rute Objek Wisata</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-3">
			</ul>
			<form method="post" class="form-inline">
				<input type="text" autocomplete="off" name="obj_wisata" style="width: 500px;" id="obj_wisata" placeholder="Cari objek wisata....." class="form-control mr-sm-2">
				<button class="btn btn-outline-success my-2 my-sm-0 mr-sm-2" style="width: 100px;" name="obj_simpan" id="obj_simpan" type="button">Cari</button>
				<button class="btn btn-outline-danger my-2 my-sm-0" type="submit" style="width: 100px;" type="submit" name="obj_reset" id="obj_reset">Reset</button>

			</form>

		</div>

	</nav>
	<!-- 
	<div id="floatingPanel">
		<h2>Hello</h2>
	</div>
	<div id="map" class="mb-5 mt-1"></div> -->
	<div id="wrapper">
		<div id="map">

		</div>

		<div id="over_map">
			<div class="card">
				<div class="card-header">
					<h6>Rekomendasi Rute</h6>
				</div>
				<div class="card-body">
					<div id="tabel-rute" style="display:none; max-height: 300px; overflow-y: auto;">
						<!-- <button type="button" onClick="javascript:ahp()" class="btn btn-success mt-1 mb-4">Hitung AHP</button> -->
						<ul id="rute-terbaik" class="list-group">

						</ul>
					</div>
				</div>
				<div class="card-footer">

				</div>
			</div>
		</div>
	</div>
	<!-- Bootstrap modal -->
	<div class="modal fade" id="modal_kriteria" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Kriteria</h3>
				</div>
				<form role="form col-lg" name="Kriteria" id="frm_kriteria">
					<div class="modal-body form">
						<div class="row">
							<input type="hidden" id="frml_id" name="frml_id" value="">
							<div class="col-lg-12">
								<div class="form-group">
									<label>Nama Kriteria</label>
									<input type="text" class="form-control" name="frml_nama" id="frml_nama" required>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" id="frml_simpan" class="btn btn-info">Simpan</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="reset_form()">Batal</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<!-- Bootstrap modal -->
	<div class="modal fade" id="modal_destination" role="dialog">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Detail Objek Wisata</h3>
				</div>
				<!-- <form role="form col-lg" name="Kriteria" id="frm_kriteria"> -->
				<div class="modal-body form">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Nama Objek Wisata</label>
								<input type="text" class="form-control inputan" name="objWis_nama" id="objWis_nama" required>
							</div>
							<div class="form-group">
								<label>Alamat</label>
								<textarea type="text" class="form-control inputan" name="objWis_alamat" id="objWis_alamat" required></textarea>
							</div>
							<div class="form-group">
								<label>Fasilitas</label>
								<textarea type="text" class="form-control inputan" name="objWis_fasilitas" id="objWis_fasilitas" required></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<!-- <button type="submit" id="frml_simpan" class="btn btn-info">Simpan</button> -->
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="reset_form()">Tutup</button>
				</div>
				<!-- </form> -->
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->



	<!-- DataTables -->
	<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="<?= base_url("assets"); ?>/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url("assets"); ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url("assets"); ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url("assets"); ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.flash.min.js"></script>
	<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.colVis.js"></script>
	<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/pdfmake.min.js"></script>
	<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/vfs_fonts.js"></script>
	<script src="<?= base_url("assets"); ?>/plugins/datatables-buttons/js/jszip.min.js"></script>
	<!-- date-range-picker -->
	<script src="<?= base_url("assets"); ?>/plugins/moment/moment.min.js"></script>
	<script src="<?= base_url("assets"); ?>/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
	<script src="<?= base_url("assets"); ?>/plugins/daterangepicker/daterangepicker.js"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="<?= base_url("assets"); ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
	<!-- Select 2 -->
	<script src="<?= base_url("assets"); ?>/plugins/select2/select2.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<!-- Toastr -->
	<script src="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.js"></script>

	<!-- Leaflet -->

	<!-- <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script> -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.0/leaflet.js" integrity="sha512-9Jj1iUqPY4FOO7kscpmGhDcw+18GDn9i/wrGf8JBZ45ALMO07aFTRGpmmtiwMxnXdfvni/p/HIZfiKibMEryqA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://npmcdn.com/leaflet-geometryutil"></script>
	<script src="https://www.mapquestapi.com/sdk/leaflet/v2.2/mq-map.js?key=ck2OXUAJsF0iz999XGQ62jyXo8AXOVp7"></script>
	<script src="https://www.mapquestapi.com/sdk/leaflet/v2.2/mq-routing.js?key=ck2OXUAJsF0iz999XGQ62jyXo8AXOVp7"></script>
	<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
	<script src="https://www.liedman.net/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
	<!-- <script data-require="leaflet@0.7.7" data-semver="0.7.7" src="//cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/leaflet.js"></script> -->
	<script>
		var save_method; //for save method string
		var table;

		function drawTable() {
			$('#tabel-kriteria').DataTable({
				"destroy": true,
				dom: 'Bfrtip',
				lengthMenu: [
					[10, 25, 50, -1],
					['10 rows', '25 rows', '50 rows', 'Show all']
				],
				buttons: [
					'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
				],
				// "oLanguage": {
				// "sProcessing": '<center><img src="<?= base_url("assets/"); ?>assets/img/fb.gif" style="width:2%;"> Loading Data</center>',
				// },
				"responsive": true,
				"sort": true,
				"processing": true, //Feature control the processing indicator.
				"serverSide": true, //Feature control DataTables' server-side processing mode.
				"order": [], //Initial no order.
				// Load data for the table's content from an Ajax source
				"ajax": {
					"url": "ajax_list_kriteria/",
					"type": "POST"
				},
				//Set column definition initialisation properties.
				"columnDefs": [{
					"targets": [-1], //last column
					"orderable": false, //set not orderable
				}, ],
				"initComplete": function(settings, json) {
					$("#process").html("<i class='glyphicon glyphicon-search'></i> Process")
					$(".btn").attr("disabled", false);
					$("#isidata").fadeIn();
				}
			});
		}

		function tambah() {
			$("#frml_id").val(0);
			$("#frm_kriteria").trigger("reset");
			$('#modal_kriteria').modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
		}

		function ahp() {
			$("#frml_id").val(0);
			$("#frm_ahp").trigger("reset");
			$('#modal_ahp').modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
		}


		$("#frm_kriteria").submit(function(e) {
			e.preventDefault();
			$("#frml_simpan").html("Menyimpan...");
			$(".btn").attr("disabled", true);
			$.ajax({
				type: "POST",
				url: "simpan",
				data: new FormData(this),
				processData: false,
				contentType: false,
				success: function(d) {
					var res = JSON.parse(d);
					var msg = "";
					if (res.status == 1) {
						toastr.success(res.desc);
						drawTable();
						reset_form();
						$("#modal_kriteria").modal("hide");
					} else {
						toastr.error(res.desc);
					}
					$("#frml_simpan").html("Simpan");
					$(".btn").attr("disabled", false);
				},
				error: function(jqXHR, namaStatus, errorThrown) {
					$("#frml_simpan").html("Simpan");
					$(".btn").attr("disabled", false);
					alert('Error get data from ajax');
				}
			});
		});

		function hapus_kriteria(id) {
			event.preventDefault();
			$("#frml_id").val(id);
			$("#jdlKonfirm").html("Konfirmasi hapus data");
			$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
			$("#frmKonfirm").modal({
				show: true,
				keyboard: false,
				backdrop: 'static'
			});
		}

		function ubah_kriteria(id) {
			event.preventDefault();
			$.ajax({
				type: "POST",
				url: "cari",
				data: "frml_id=" + id,
				dataType: "json",
				success: function(data) {
					var obj = Object.entries(data);
					obj.map((dt) => {
						$("#" + dt[0]).val(dt[1]);
					});
					$(".inputan").attr("disabled", false);
					$("#modal_kriteria").modal({
						show: true,
						keyboard: false,
						backdrop: 'static'
					});
					return false;
				}
			});
		}

		function reset_form() {
			$("#frml_id").val(0);
			$("#frm_kriteria").trigger("reset");
		}

		$("#yaKonfirm").click(function() {
			var id = $("#frml_id").val();

			$("#isiKonfirm").html("Sedang menghapus data...");
			$(".btn").attr("disabled", true);
			$.ajax({
				type: "GET",
				url: "hapus/" + id,
				success: function(d) {
					var res = JSON.parse(d);
					var msg = "";
					if (res.status == 1) {
						toastr.success(res.desc);
						$("#frmKonfirm").modal("hide");
						drawTable();
					} else {
						toastr.error(res.desc + "[" + res.err + "]");
					}
					$(".btn").attr("disabled", false);
				},
				error: function(jqXHR, namaStatus, errorThrown) {
					alert('Error get data from ajax');
				}
			});
		});

		$('.tgl').daterangepicker({
			locale: {
				format: 'DD/MM/YYYY'
			},
			showDropdowns: true,
			singleDatePicker: true,
			"autoAplog": true,
			opens: 'left'
		});


		$(document).ready(function() {
			drawTable();
			GetMap();
			// $("#obj_wisata").keyup(function() {
			// 	var query = $(this).val();
			// 	if (query != '') {
			// 		$.ajax({
			// 			method: "POST",
			// 			url: "autoSearch",
			// 			data: {
			// 				"search": query
			// 			},
			// 			success: function(data) {
			// 				$('#wisataList').fadeIn();
			// 				$("#wisataList").html(data);
			// 			}
			// 		})

			// 	} else {
			// 		$("#wisataList").html("");
			// 	}
			// });
		});
	</script>
	<script>
		$(function() {
			$.getJSON("autoSearch", function(data) {
				autoComplete = [];
				for (var i = 0, len = data.length; i < len; i++) {
					autoComplete.push(data[i]);
				}
				$("#obj_wisata").autocomplete({
					source: autoComplete,
					autofocus: true
				});
			});
		})
	</script>
	<!-- Bing map -->
	<!-- <script src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap' type='text/javascript'></script> -->


	<script type='text/javascript'>
		var map,
			directionsManagers = [],
			infobox, dataLayer,
			dir;

		var lokasi;
		var fromLatLng;
		var toLatLng;
		var jarak = [];
		var alt_latitude, alt_longitude;

		function loadMap() {
			map = new L.map('map', {
				doubleClickZoom: false
			}).locate({
				setView: true,
				maxZoom: 16
			});

			// Creating a Layer object
			// var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

			// // Adding layer to the map
			// map.addLayer(layer);
			L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
				attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map);
			var markerOptions = {
				title: "MyLocation",
				// clickable: true,
				// draggable: true
			}
		}

		function markerOnClick(location) {
			console.log(location);
			$.ajax({
				type: "POST",
				url: "getDestinationDetail",
				data: {
					'lokasi': location
				},
				dataType: "json",
				success: function(data) {
					console.log(data);
					var obj = Object.entries(data);
					obj.map((dt) => {
						$("#" + dt[0]).val(dt[1]);
					});
					$(".inputan").attr("disabled", true);
					$("#modal_destination").modal({
						show: true,
						keyboard: false,
						backdrop: 'static'
					});
					return false;
				}
			});

		}

		function GetMap() {

			// map.eachLayer(function(layer) {
			// 	map.removeLayer(layer);
			// });

			// Creating map options
			// var mapOptions = {
			// 	center: [17.385044, 78.486671],
			// 	zoom: 10
			// }

			// Creating a map object
			map = new L.map('map', {
				doubleClickZoom: false
			}).locate({
				setView: true,
				maxZoom: 16
			});
			L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
				attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
			}).addTo(map);
			// Creating a Layer object
			// var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

			// // Adding layer to the map
			// map.addLayer(layer);

			var markerOptions = {
				title: "MyLocation",
				// clickable: true,
				// draggable: true
			}
			var marker;
			var tabelJarak = $("#tableJarak tbody");
			var tabelInvers = $("#tableInvers tbody");
			var tabelRute = $("#tableRute tbody");

			var kota = [];

			map.on('load', function(e) {

				var type = e.target.layerType;
				lat = e.target._lastCenter.lat;
				lng = e.target._lastCenter.lng;
				// var type = e.layerType,
				marker = L.marker([lat, lng], markerOptions);
				// Adding marker to the map
				console.log(type);
				marker.addTo(map);

				var counter = <?php echo json_encode($mapCoor) ?>;
				var alternatif = <?php echo json_encode($alternatif); ?>;
				// console.log(alternatif);
				for (let index = 0; index < alternatif.length; index++) {
					// const element = array[index];
					fromLatLng = L.latLng(alternatif[index]['alt_latitude'], alternatif[index]['alt_longitude']);
					toLatLng = L.latLng(lat, lng);
					dis = fromLatLng.distanceTo(toLatLng);
					// console.log(dis);
					// jarak[index] = dis;
					jarak.push(dis);
					//  console.log(jarak);

				}

				console.log(jarak);

				// $.ajax({
				// 	type: 'POST',
				// 	url: 'calculateACO',
				// 	data: {
				// 		'jarak': jarak,
				// 	},
				// });
				$("#obj_simpan").on('click', function() {
					lokasi = $("#obj_wisata").val();
					console.log(lokasi);
					if (map != null) {
						// map.eachLayer(function(layer) {
						// alert(layer);
						// console.log(e.target._layers);
						map.remove();
						// map.removeLayer('CustomRouteLayer');
						// });
						loadMap();
						marker = L.marker([lat, lng], markerOptions);
						// Adding marker to the map
						console.log(type);
						marker.addTo(map);
					}
					if (lokasi != '') {
						//Load the directions module.
						// Microsoft.Maps.loadModule('Microsoft.Maps.Directions', function() {
						//Generate some routes.
						// clearRoute();
						$.ajax({
							type: "POST",
							url: "getCoordinates",
							data: {
								lokasi: lokasi
							},
							success: function(data) {
								var res = JSON.parse(data);
								alt_latitude = res.result.objWis_latitude;
								alt_longitude = res.result.objWis_longitude;
								console.log(alt_latitude, alt_longitude);
								$.ajax({
									type: "POST",
									url: "calculateACO",
									data: {
										jarak: jarak,
										kelurahan: res.kelurahan,
									},
									success: function(data) {

										$("#tabel-rute").show();
										$("#over_map").show();
										$("#rute-terbaik").empty();
										routes = data;
										resp = JSON.parse(routes);
										console.log(resp);
										$.each(resp.jarak, function(idx, element) {
											var tr = $('<tr>');
											$.each(resp.jarak, function(i, prop) {
												$('<td>').html(element[i]).appendTo(tr);
											});
											tabelJarak.append(tr);
										});

										$.each(resp.invers_matriks, function(idx, element) {
											var tr = $('<tr>');
											$.each(resp.invers_matriks, function(i, prop) {
												$('<td>').html(element[i]).appendTo(tr);
											});
											tabelInvers.append(tr);
										});
										$('#time-skor').html(resp.time + "detik");
										const sorted = Object.entries(resp.scores[0])
											.sort(([, a], [, b]) => a - b)
											.reduce(
												(r, [k, v]) => ({
													...r,
													[k]: v
												}), {}
											);
										var total_jarak = 0;
										var count = 0;
										for (let a = 0; a < resp.bestTour.length; a++) {
											// console.log(resp.bestTour.length);
											// console.log(resp.bestTour[a][2]);
											count++;
											$("#rute-terbaik").append("<p class='pt-2'> Rute terdekat   : </p>");
											for (let b = 0; b < resp.bestTour[a].length; b++) {
												// $.each(resp.bestTour, function(i, prop) {
												$("#rute-terbaik").append("<li class='list-group-item'>" + resp.cities[resp.bestTour[a][b]]['nama'] + " " + Math.abs(resp.cities[resp.bestTour[a][b]]['jarak'] / 1000).toFixed(2) + " KM</li>");
												// $('<td>').html(element[i]).appendTo(tr);
												total_jarak += parseFloat(resp.cities[resp.bestTour[a][b]]['jarak']);
												// });
											}

											$("#rute-terbaik").append("<p class='pt-2'> Total jarak tempuh : " + (parseFloat(Math.abs(total_jarak) / 1000).toFixed(2)) + " KM  </p>");

										}

										$.each(sorted, function(idx, element) {
											// console.log(resp.bestTour.length);
											// console.log(resp.bestTour[a][2]);
											// $("#rute-terbaik-ahp").append("<h5> Rute terbaik : </h5>");
											// for (let b = 0; b < resp.bestTour[a].length; b++) {
											// $.each(resp.bestTour, function(i, prop) {
											$("#rute-terbaik-ahp").append("<li class='list-group-item'> " + idx + " dengan score : " + element + "</li>");
											// $('<td>').html(element[i]).appendTo(tr);
											// });
											// }
										});
										// cities = <?php //echo json_encode($bestTour); 
													?>;
										var r = 0;
										// var randomColor = Math.floor(Math.random() * 16777215).toString(16);
										$.ajax({
											type: 'POST',
											url: 'getMyLocation',
											data: {
												'latitude': lat,
												'longitude': lng
											},

											success: function(data) {
												// console.log(data);
												// console.log(lokasi);

												var counter = 0;
												var colors = ["green", "red", "yellow", "blue", "purple"];
												// console.log('dir', typeof dir);
												$.each(sorted, function(idx, element) {
													// dir = MQ.routing.directions()

													// console.log('idx', idx);


													// dir.route({
													// 		locations: [{
													// 				latLng: {
													// 					lat: lat,
													// 					lng: lng
													// 				}
													// 			},
													// 			{
													// 				latLng: {
													// 					lat: resp.scores[1][idx],
													// 					lng: resp.scores[2][idx]
													// 				}
													// 			},


													// 			{
													// 				latLng: {
													// 					lat: alt_latitude,
													// 					lng: alt_longitude
													// 				}
													// 			},

													// 		],


													// 	},


													// )

													// CustomRouteLayer = MQ.Routing.RouteLayer.extend({
													// 	createStartMarker: function(location, stopNumber) {
													// 		var custom_icon;
													// 		var marker;

													// 		custom_icon = L.icon({
													// 			iconUrl: 'https://www.mapquestapi.com/staticmap/geticon?uri=poi-red_1.png',
													// 			iconSize: [20, 29],
													// 			iconAnchor: [10, 29],
													// 			popupAnchor: [0, -29]
													// 		});

													// 		marker = L.marker(location.latLng, {
													// 			icon: custom_icon
													// 		}).addTo(map);

													// 		return marker;
													// 	},

													// 	createEndMarker: function(location, stopNumber) {
													// 		var custom_icon;
													// 		var marker;
													// 		var split = lokasi.split("-");
													// 		// console.log(location);
													// 		// console.log(stopNumber);
													// 		custom_icon = L.icon({
													// 			iconUrl: 'https://www.mapquestapi.com/staticmap/geticon?uri=poi-blue_1.png',
													// 			iconSize: [20, 29],
													// 			iconAnchor: [10, 29],
													// 			popupAnchor: [0, -29]
													// 		});

													// 		marker = L.marker(location.latLng, {
													// 			icon: custom_icon
													// 		}).addTo(map).on('click', function(e) {
													// 			markerOnClick(split[0])
													// 		});
													// 		//bindPopup('Point B<br/>' + location.latlng + '<br/>' + location.layerPoint).openPopup();  //on('click', markerOnClick);

													// 		return marker;
													// 	}
													// });
													// // console.log(res);
													// // console.log(dir);
													// map.addLayer(new CustomRouteLayer({
													// 	directions: dir,
													// 	fitBounds: true,

													// }));
													var greenIcon = new L.Icon({
														iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
														shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.4/images/marker-shadow.png',
														iconSize: [25, 41],
														iconAnchor: [12, 41],
														popupAnchor: [1, -34],
														shadowSize: [41, 41]
													});

													var redIcon = new L.Icon({
														iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
														shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.4/images/marker-shadow.png',
														iconSize: [25, 41],
														iconAnchor: [12, 41],
														popupAnchor: [1, -34],
														shadowSize: [41, 41]
													});

													var blueIcon = new L.Icon({
														iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
														shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.3.4/images/marker-shadow.png',
														iconSize: [25, 41],
														iconAnchor: [12, 41],
														popupAnchor: [1, -34],
														shadowSize: [41, 41]
													});
													routeControl = L.Routing.control({
														waypoints: [
															L.latLng(lat, lng),
															L.latLng(resp.scores[1][idx], resp.scores[2][idx]),
															L.latLng(alt_latitude, alt_longitude)
														],
														router: new L.Routing.osrmv1({
															language: 'id',

														}),
														// geocoder: L.Control.Geocoder.nominatim(),
														routeWhileDragging: true,
														reverseWaypoints: true,
														showAlternatives: true,
														createMarker: function(i, wp, nWps) {
															if (i === nWps - 1) {
																// here change the starting and ending icons
																var marker;
																var split = lokasi.split("-");
																marker = L.marker(wp.latLng, {
																	icon: greenIcon
																}).addTo(map).on('click', function(e) {
																	markerOnClick(split[0])
																});
																return marker;
															} else if (i === 0) {
																// here change the starting and ending icons
																var marker;
																marker = L.marker(wp.latLng, {
																	icon: blueIcon
																}).addTo(map);
																return marker;
															} else {
																// here change all the others
																return L.marker(wp.latLng, {
																	icon: redIcon // here pass,
																});
															}
														},
														lineOptions: {
															styles: [{
																	color: 'black',
																	opacity: 0.15,
																	weight: 9
																}, {
																	color: 'white',
																	opacity: 0.8,
																	weight: 6
																}, {
																	color: colors[counter],
																	opacity: 1,
																	weight: 2
																}

															]
														},
														altLineOptions: {
															styles: [{
																	color: 'black',
																	opacity: 0.15,
																	weight: 9
																},
																{
																	color: 'white',
																	opacity: 0.8,
																	weight: 6
																},
																{
																	color: 'blue',
																	opacity: 0.5,
																	weight: 2
																}
															]
														}
													}).addTo(map);
													// }
													counter++;
													// 	}

													//  })
												})


											}

										});


									}
								})

							}
						})



					}


				});

			});
		}



		$("#obj_reset").on('click', function() {
			location.reload();
		});

		function clearRoute() {
			var dm = new Microsoft.Maps.Directions.DirectionsManager(map);
			dm.clearDisplay();
		}

		function getRoute(start, end) {
			dir = MQ.routing.directions();
			// console.log(data);
			dir.route({
				locations: [
					start,
					end
				],
				options: {
					dragable: false,
				}
			});


			map.addLayer(MQ.routing.routeLayer({
				directions: dir,
				fitBounds: true
			}));
			// dm.calculateDirections();
		}
	</script>