<?php
$array = array(
	"Bagus" => 1,
	"Sedang" => 2,
	"Parah" => 3,
);
?>
<div class="inner">
	<div class="row">

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

	</div>
	<div class="row" id="isidata">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h3 class="card-title">Data Alternatif</h3>

				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-bordered table-hover" id="tabel-alternatif" width="100%" style="font-size:120%;">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama Alternatif</th>
								<th>Jarak (KM)</th>
								<th>Kondisi</th>
								<th>Fasilitas</th>
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
	</div>
</div>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_alternatif" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title"><i class="glyphicon glyphicon-info"></i> Form Alternatif</h3>
			</div>
			<form role="form col-lg" name="Alternatif" id="frm_alternatif">
				<div class="modal-body form">
					<div class="row">
						<input type="hidden" id="alt_id" name="alt_id" value="">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Nama Alternatif</label>
								<input type="text" class="form-control" name="alt_nama" id="alt_nama" required>
							</div>
							<div class="form-group">
								<label>Objek Wisata</label>
								<select name="alt_objWis_id" class="form-control" id="alt_objWis_id">
									<?php foreach ($objek_wisata as $obj) : ?>
										<option value="<?= $obj->objWis_id; ?>"><?= $obj->objWis_nama; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<label>Kondisi</label>
								<select name="alt_kondisi" class="form-control" id="alt_kondisi">
									<?php foreach ($array as $key => $value) : ?>
										<option value="<?= $value; ?>"><?= $key; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<label>Fasilitas</label>
								<select name="alt_fasilitas" class="form-control" id="alt_fasilitas">
									<?php foreach ($array as $key => $value) : ?>
										<option value="<?= $value; ?>"><?= $key; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<label>Kelurahan</label>
								<input type="text" class="form-control" name="alt_kelurahan" id="alt_kelurahan" required>
							</div>
							<div class="form-group">
								<label>Latitude</label>
								<input type="text" class="form-control" name="alt_latitude" id="alt_latitude" required>
							</div>

							<div class="form-group">
								<label>Longitude</label>
								<input type="text" class="form-control" name="alt_longitude" id="alt_longitude" required>
							</div>

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" id="alt_simpan" class="btn btn-info">Simpan</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="reset_form()">Batal</button>
				</div>
			</form>
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
<script src="<?= base_url("assets"); ?>/plugins/select2/js/select2.full.min.js"></script>

<!-- Toastr -->
<script src="<?= base_url("assets"); ?>/plugins/toastr/toastr.min.js"></script>

<script>
	var save_method; //for save method string
	var table;

	function drawTable() {
		$('#tabel-alternatif').DataTable({
			"destroy": true,
			dom: 'Bfrtip',
			lengthMenu: [
				[10, 25, 50, -1],
				['10 rows', '25 rows', '50 rows', 'Show all']
			],
			// buttons: [
			// 	'copy', 'csv', 'excel', 'pdf', 'print', 'pageLength'
			// ]
			buttons: [
				'pageLength'
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
				"url": "ajax_list_alternatif/",
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
		$("#alt_id").val(0);
		$("#frm_alternatif").trigger("reset");
		$('#modal_alternatif').modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	$("#frm_alternatif").submit(function(e) {
		e.preventDefault();
		$("#alt_simpan").html("Menyimpan...");
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
					$("#modal_alternatif").modal("hide");
				} else {
					toastr.error(res.desc);
				}
				$("#alt_simpan").html("Simpan");
				$(".btn").attr("disabled", false);
			},
			error: function(jqXHR, namaStatus, errorThrown) {
				$("#alt_simpan").html("Simpan");
				$(".btn").attr("disabled", false);
				alert('Error get data from ajax');
			}
		});
	});

	function hapus_alternatif(id) {
		event.preventDefault();
		$("#alt_id").val(id);
		$("#jdlKonfirm").html("Konfirmasi hapus data");
		$("#isiKonfirm").html("Yakin ingin menghapus data ini ?");
		$("#frmKonfirm").modal({
			show: true,
			keyboard: false,
			backdrop: 'static'
		});
	}

	function ubah_alternatif(id) {
		event.preventDefault();
		$.ajax({
			type: "POST",
			url: "cari",
			data: "alt_id=" + id,
			dataType: "json",
			success: function(data) {
				var obj = Object.entries(data);
				obj.map((dt) => {
					$("#" + dt[0]).val(dt[1]);
				});
				$(".inputan").attr("disabled", false);
				$("#modal_alternatif").modal({
					show: true,
					keyboard: false,
					backdrop: 'static'
				});
				return false;
			}
		});
	}

	function reset_form() {
		$("#alt_id").val(0);
		$("#frm_alternatif").trigger("reset");
	}

	$("#yaKonfirm").click(function() {
		var id = $("#alt_id").val();

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

	$('#alt_objWis_id').select2({
		// dropdownParent: $("#modal_alternatif  .modal-content")
		theme: 'bootstrap4'
	});

	$(document).ready(function() {
		drawTable();
	});
</script>