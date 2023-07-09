<?php
// Set a same-site cookie for first-party contexts
// setcookie('cookie1', 'value1', ['samesite' => 'Lax']);
// Set a cross-site cookie for third-party contexts
// setcookie('cookie2', 'value2', ['samesite' => 'None', 'secure' => true]);
?>
<style>
	#map {
		height: 1500px;
		width: 100%;
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
<!-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" /> -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<!-- Bing map -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
<link rel="stylesheet" href="https://www.liedman.net/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
<form method="post">
	<div class="row">
		<div class="col-lg-8">
			<div class="form-group">

				<input type="text" autocomplete="off" name="obj_wisata" id="obj_wisata" placeholder="Cari objek wisata....." class="form-control">
				<div id="wisataList"></div>
			</div>
		</div>

		<div class="col-lg-2">
			<div class="form-group">

				<button type="button" name="obj_simpan" id="obj_simpan" class="btn btn-block btn-info">Cari</button>

			</div>
		</div>
		<div class="col-lg-2">
			<div class="form-group">

				<button type="submit" name="obj_reset" id="obj_reset" class="btn btn-block btn-danger">Reset</button>

			</div>
		</div>
	</div>
</form>

<div id="map"></div>

<div class="inner">
	<!-- <div class="row">

		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<a href="javascript:tambah()" class="btn btn-info btn-block"><i class="fa fa-plus-circle"></i> &nbsp;&nbsp;&nbsp; Tambah</a>
			</div>
		</div>
		<div class="col-md-2 col-xs-12">
			<div class="form-group">
				<a href="javascript:drawTable()" class="btn btn-info btn-block"><i class="fa fa-sync"></i> &nbsp;&nbsp;&nbsp; Refresh</a>
			</div>
		</div>

	</div> -->
	<div id="time-ahp" style="display:none;">
		<!-- <button type="button" onClick="javascript:ahp()" class="btn btn-success mt-1 mb-4">Hitung AHP</button> -->
		<h4 class="mt-3">Kecepatan Perhitungan</h4>
		<p class="p-3 bg-white" style="font-size: 18px;" id="time-skor"></p>

	</div>
	<div id="tabel-rute" class="mt-3" style="display:none;">
		<!-- <button type="button" onClick="javascript:ahp()" class="btn btn-success mt-1 mb-4">Hitung AHP</button> -->
		<h4>Rekomendasi Rute</h4>
		<ul id="rute-terbaik" class="list-group">

		</ul>
		<!-- <table id="tableRute" class="table table-bordered">
			<h4>Rute Terbaik</h4>
			<tbody>

				<tr>
					<td>
						<?php
						// foreach ($bestTour as $key) {
						// 	$cityTour = array_map(function ($cityIndex) use ($cityNames) {
						// 		return $cityNames[$cityIndex];
						// 	}, $key);
						// 	// echo  implode(" -> ", $key) . PHP_EOL ;
						// 	// echo "<br>";
						// 	echo "Best tour: " . implode(" -> ", $cityTour) . PHP_EOL;
						// 	echo "<br>";
						// }
						?>

					</td>
				</tr>
			</tbody>

		</table> -->
	</div>
	<div id="tabel-jarak" class="mt-3" style="display:none;">
		<h4>Matriks jarak</h4>
		<table id="tableJarak" class="table table-bordered" cellspacing="0" width="100%">
			<thead>
			</thead>
			<tbody>
			</tbody>

		</table>
	</div>

	<div id="tabel-invers" class="mt-3" style="display:none;">
		<h4>Invers Matriks</h4>
		<table id="tableInvers" class="table table-bordered" cellspacing="0" width="100%">
			<thead>
			</thead>
			<tbody>
			</tbody>

		</table>
	</div>

	<div id="tabel-kepentingan" class="mt-3" style="display:none;">
		<h4>Hirarki Tingkat Kepentingan</h4>
		<table id="tableKepentingan" class="table table-bordered" cellspacing="0" width="100%">
			<thead>
			</thead>
			<tbody>
			</tbody>

		</table>
	</div>


	<div id="tabel-ahp" class="mt-3" style="display:none;">
		<!-- <button type="button" onClick="javascript:ahp()" class="btn btn-success mt-1 mb-4">Hitung AHP</button> -->
		<h4>Rute Terbaik</h4>
		<!-- <ul id="rute-terbaik-ahp" class="list-group">

		</ul> -->
		<table id="tableAhp" class="table table-bordered" cellspacing="0" width="100%">
			<thead>

			</thead>
			<tbody>

			</tbody>
		</table>
	</div>


</div>

<!-- <div class="row" id="isidata">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Data Kriteria</h3>
					
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-kriteria" width="100%" style="font-size:120%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Kriteria</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="3" align="center">Tidak ada data</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div> -->

</div>


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
<!-- <script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script> -->
<!-- <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.0.0/leaflet.js" integrity="sha512-9Jj1iUqPY4FOO7kscpmGhDcw+18GDn9i/wrGf8JBZ45ALMO07aFTRGpmmtiwMxnXdfvni/p/HIZfiKibMEryqA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script> -->
<script src="https://npmcdn.com/leaflet-geometryutil"></script>
<script src="https://www.mapquestapi.com/sdk/leaflet/v2.2/mq-map.js?key=ck2OXUAJsF0iz999XGQ62jyXo8AXOVp7"></script>
<script src="https://www.mapquestapi.com/sdk/leaflet/v2.2/mq-routing.js?key=ck2OXUAJsF0iz999XGQ62jyXo8AXOVp7"></script>
<script src="https://www.liedman.net/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

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

<!-- Bing map -->
<!-- <script src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap' type='text/javascript'></script> -->


<script type='text/javascript'>
	var map,
		directionsManagers = [],
		infobox, dataLayer,
		dir, routeControl, routeLine;

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

		L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(map);
		// Adding layer to the map
		// map.addLayer(layer);

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

		// Creating a Layer object
		L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
			attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}).addTo(map);
		// var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

		// // Adding layer to the map
		// map.addLayer(layer);

		var markerOptions = {
			title: "Lokasi Saya",
			// clickable: true,
			// draggable: true
		}
		var marker;
		var tabelJarak = $("#tableJarak tbody");
		var tabelInvers = $("#tableInvers tbody");
		var tabelKepentingan = $("#tableKepentingan tbody");
		var tabelRute = $("#tableRute tbody");
		var tabelAhp = $("#tableAhp tbody");
		var tabelAhpHeader = $("#tableAhp thead");
		var tabelJarakHeader = $("#tableJarak thead");
		var tabelInversHeader = $("#tableInvers thead");
		var tabelKepentinganHeader = $("#tableKepentingan thead");
		var kota = [];

		map.on('load', function(e) {
			// alert('on load');
			console.log(e.target);
			var type = e.target.layerType;
			lat = e.target._lastCenter.lat;
			lng = e.target._lastCenter.lng;
			// var type = e.layerType,
			marker = L.marker([lat, lng], markerOptions);
			// Adding marker to the map

			marker.addTo(map);


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

			// console.log(jarak);

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
									// $("#tabel-rute").html("");
									$("#tabel-rute").show();
									$("#tabel-jarak").show();
									$("#tabel-ahp").show();
									$("#tabel-invers").show();
									// $("#tabel-kepentingan").show();
									$("#time-ahp").show();
									$("#rute-terbaik").empty();
									$("#rute-terbaik-ahp").empty();
									tabelJarak.empty();
									tabelInvers.empty();
									tabelRute.empty();
									tabelAhp.empty();
									tabelInversHeader.empty();
									tabelKepentingan.empty();
									tabelKepentinganHeader.empty();
									tabelAhpHeader.empty();
									tabelJarakHeader.empty();
									routes = data;
									resp = JSON.parse(routes);

									tabelJarakHeader.append($('<th>'));
									tabelInversHeader.append($('<th>'));
									tabelKepentinganHeader.append($('<th rowspan="2">Ukuran Alternatif</th>')); //
									// tabelKepentinganHeader.append($('<th rowspan="2">Jarak (KM)</th>'));
									tabelKepentinganHeader.append($('<th rowspan="2">Kondisi</th>'));
									tabelKepentinganHeader.append($('<th rowspan="2">Fasilitas</th>'));
									$.each(resp.alternatif_selected, function(idx, element) {
										var tr = $('<tr>');
										var tr_header_jarak = $('<th>').html(element.alt_nama);
										var tr_header_invers = $('<th>').html(element.alt_nama);

										tabelInversHeader.append(tr_header_invers);
										tabelJarakHeader.append(tr_header_jarak);
										$('<th>').html(resp.alternatif_selected[idx].alt_nama).appendTo(tr);
										// $.each(resp.alternatif_selected, function(i, prop) {
										// console.log(resp.alternatif_selected[idx].alt_nama);
										// $('<td>').html((parseFloat(Math.abs(resp.alternatif_selected[idx].alt_jarak) / 1000).toFixed(2))).appendTo(tr);
										$('<td>').html(resp.alternatif_selected[idx].alt_kondisi).appendTo(tr);
										$('<td>').html(resp.alternatif_selected[idx].alt_fasilitas).appendTo(tr);
										// });
										tabelKepentingan.append(tr);
									});
									$.each(resp.jarak, function(idx, element) {

										var tr = $('<tr>');

										//  $.each(resp.alternatif_selected, function(idx, element) {

										$('<th>').html(resp.alternatif_selected[idx].alt_nama).appendTo(tr);

										//  });
										$.each(resp.jarak, function(i, prop) {

											$('<td>').html(element[i]).appendTo(tr);
										});
										tabelJarak.append(tr);
									});

									$.each(resp.invers_matriks, function(idx, element) {
										var tr = $('<tr>');
										$('<th>').html(resp.alternatif_selected[idx].alt_nama).appendTo(tr);

										$.each(resp.invers_matriks, function(i, prop) {
											$('<td>').html(element[i]).appendTo(tr);
										});
										tabelInvers.append(tr);
									});
									$('#time-skor').html(Math.abs(resp.time).toFixed(4) + " detik");
									var total_jarak = 0;
									for (let a = 0; a < resp.bestTour.length; a++) {
										// console.log(resp.bestTour.length);
										// console.log(resp.bestTour[a][2]);
										$("#rute-terbaik").append("<li class='list-group-item'><h5> Rute terdekat " + (parseInt(a) + 1) + ": </h5> </li>");
										for (let b = 0; b < resp.bestTour[a].length; b++) {
											// $.each(resp.bestTour, function(i, prop) {
											$("#rute-terbaik").append("<li class='list-group-item'>" + resp.cities[resp.bestTour[a][b]]['nama'] + " " + parseFloat(Math.abs(resp.cities[resp.bestTour[a][b]]['jarak']) / 1000).toFixed(2) + " KM</li>");
											// $('<td>').html(element[i]).appendTo(tr);
											// });
											total_jarak += parseFloat(resp.cities[resp.bestTour[a][b]]['jarak']);
											// });
										}
										$("#rute-terbaik").append("<li class='list-group-item'> Total jarak tempuh : " + (parseFloat(Math.abs(total_jarak) / 1000).toFixed(2)) + " KM  </li>");
									}
									console.log("scores");
									console.log(resp.scores[0]);
									// const sorted = Object.keys(resp.scores[0])
									// 	.sort((key1, key2) => resp.scores[0][key1] - resp.scores[0][key2])
									// 	.reduce(
									// 		(obj, key) => ({
									// 			...obj,
									// 			[key]: resp.scores[0][key],


									// 		}), {

									// 		}

									// 	);
									const sorted = Object.entries(resp.scores[0])
										.sort(([, a], [, b]) => a - b)
										.reduce(
											(r, [k, v]) => ({
												...r,
												[k]: v
											}), {}
										)
									var tr_header = $('<tr>');
									// $.each(resp.scores, function(i, prop) {
									$('<th>').html("Alternatif").appendTo(tr_header);
									$('<th>').html("Skor").appendTo(tr_header);
									$('<th>').html("Fasilitas").appendTo(tr_header);
									$('<th>').html("Kondisi").appendTo(tr_header);
									// });
									let fasilitas = "";
									let kondisi = "";
									tabelAhpHeader.append(tr_header);
									$.each(sorted, function(idx, element) {
										var tr = $('<tr>');
										console.log('score idx');
										console.log(idx);
										if (resp.scores[3][idx] == 1) {
											fasilitas = "<span class=\"badge badge-success\">Bagus</span>";
										} else if (resp.scores[3][idx] == 2) {
											fasilitas = "<span class=\"badge badge-warning\">Sedang</span>";
										} else {
											fasilitas = "<span class=\"badge badge-danger\">Parah</span>";
										}

										if (resp.scores[4][idx] == 1) {
											kondisi = "<span class=\"badge badge-success\">Bagus</span>";
										} else if (resp.scores[4][idx] == 2) {
											kondisi = "<span class=\"badge badge-warning\">Sedang</span>";
										} else {
											kondisi = "<span class=\"badge badge-danger\">Parah</span>";
										}
										// $.each(resp.scores, function(i, prop) {
										$('<td>').html(idx).appendTo(tr);
										$('<td>').html(element).appendTo(tr);
										$('<td>').html(fasilitas).appendTo(tr);
										$('<td>').html(kondisi).appendTo(tr);
										// });
										tabelAhp.append(tr);


										// $.each(resp.bestTour, function(i, prop) {
										// $("#rute-terbaik-ahp").append("<li class='list-group-item'> " + idx + " dengan score : " + element + "</li>");
										// $('<td>').html(element[i]).appendTo(tr);
										// });
										// }
									});
									// cities = <?php //echo json_encode($bestTour); 
												?>;
									var r = 0;
									let waypoints = [];
									let colors_rute = [];
									waypoints.push(L.latLng(lat, lng));
									colors_rute.push({
										color: 'black',
										opacity: 0.15,
										weight: 9
									});
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
											// $.each(sorted, function(idx, element) {
											let color = [];
											// })
											// console.log(sorted);
											$.each(sorted, function(idx, element) {
												waypoints.push(L.latLng(resp.scores[1][idx], resp.scores[2][idx]));

												// dir = MQ.routing.directions()
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
												// 			// {
												// 			// 	street: idx+"Pekanbaru"
												// 			// },

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
												// 	maxRoutes: 5,
												// 	routeType: "shortest",
												// 	fitBounds: true,

												// }));


												// })

												counter++;
											})
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

											var waypoints_tes = [
												L.latLng(51.5, -0.1),
												L.latLng(51.508, -0.11),
												L.latLng(51.5, -0.1),
												L.latLng(51.51, -0.12),
												L.latLng(51.5, -0.1),
												L.latLng(51.512, -0.13)
											];
											waypoints.push(L.latLng(alt_latitude, alt_longitude));
											console.log('waypoints');
											console.log(waypoints_tes);

											routeControl = L.Routing.control({
												waypoints: waypoints,
												router: new L.Routing.osrmv1({
													language: 'id',

												}),
												routeWhileDragging: true,
												reverseWaypoints: true,
												showAlternatives: true,
												// addWaypoints: true,
												// routeLine: function(route) {
												// 	var line = L.Routing.line(route);
												// 	line.on('click', function(e) {
												// 		console.log(e.styles);
												// 	});
												// 	line.options.addWaypoints = false;
												// 	line.options.extendToWaypoints = false;
												// 	line.options.routeWhileDragging = false;
												// 	line.options.autoRoute = true;
												// 	line.options.useZoomParameter = false;
												// 	line.options.draggableWaypoints = false;
												// 	line.options.addWaypoints = false;
												// 	line.options.color='aqua';
												// 	console.log(line);
												// 	return line;
												// },
												lineOptions: {
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

												},
												createMarker: function(i, wp, nWps) {
													if (i === nWps - 1) {
														// here change the starting and ending icons
														var marker;
														colors_rute.push({
															color: colors[nWps - 1],
															opacity: 0.15,
															weight: 9
														});
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
														colors_rute.push({
															color: colors[0],
															opacity: 0.15,
															weight: 9
														});
														marker = L.marker(wp.latLng, {
															icon: blueIcon
														}).addTo(map);
														return marker;
													} else {
														colors_rute.push({
															color: colors[nWps],
															opacity: 0.15,
															weight: 9
														});

														// here change all the others
														return L.marker(wp.latLng, {
															icon: redIcon // here pass,
														});
													}
												},

											}).addTo(map);


											function getRandomColor() {
												var letters = '0123456789ABCDEF';
												var color = '#';
												for (var i = 0; i < 6; i++) {
													color += letters[Math.floor(Math.random() * 16)];
												}
												return color;
											}

											// }



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

		// var dm = new Microsoft.Maps.Directions.DirectionsManager(map);
		// // console.log(dm);
		// dm.clearDisplay();
		// directionsManagers.push(dm);
		// // alert(map);
		// dm.setRequestOptions({
		// 	routeMode: Microsoft.Maps.Directions.RouteMode.driving
		// });

		// dm.setRenderOptions({
		// 	autoUpdateMapView: true,
		// 	drivingPolylineOptions: {
		// 		strokeColor: color,
		// 		strokeThickness: 5
		// 	}
		// });

		// dm.addWaypoint(new Microsoft.Maps.Directions.Waypoint({
		// 	address: start
		// }));
		// dm.addWaypoint(new Microsoft.Maps.Directions.Waypoint({
		// 	address: end
		// }));
		map.addLayer(MQ.routing.routeLayer({
			directions: dir,
			fitBounds: true
		}));
		// dm.calculateDirections();
	}
</script>