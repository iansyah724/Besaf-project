<script>
	$(document).ready(function() {

		$(document).on('click', 'li.demo', function() {
			$('li.demo').removeClass('active');
			$(this).addClass('active');
		})

		$('div.m-content').css({
			background: "none"
		});

		$('a.nav-link').on('click', function() {
			$('a.nav-link').removeClass('active');
			$(this).data().addClass('active');
		});

		$(document).on('mouseenter', '.hover', function() {
			$(this).addClass('shadow-lg');
			$(this).addClass('border');
		});

		$(document).on('mouseleave', '.hover', function() {
			$('.hover').removeClass('shadow-lg');
			$('.hover').removeClass('border');
		});

		/*Menampilkan semua komunitas.*/
		function get_community() {
			$.ajax({
				url: "<?php echo base_url('api/Komunitas/show'); ?>",
				method: "POST",
				async: true,
				success: function(req) {
					html = '';
					if (req.error == true) {
						html += '\
						<div class="col-md-12 m-portlet m-portlet--mobile">\
							<div class="m-portlet__body">\
								<h4 class="text-center">' + req.message + '</h4>\
							</div>\
						</div>';
					} else {
						$.each(req.data, function(index, obj) {
							html += '\
							<div class="col-sm-4">\
								<a href="<?php echo base_url('Community/info/'); ?>' + obj.komunitas_id + '" style="text-decoration: none">\
									<div class="m-portlet m-portlet--mobile hover">\
										<div class="row no-gutters">\
											<div class="col-xs-5">\
												<div style="padding: 5px;">\
													<img src="<?php echo base_url('api/img/komunitas/') ?>' + obj.foto_identitas + '" style="max-height: 85px; max-width: 85px; padding: 3px; margin-top: 5px" class="border">\
												</div>\
											</div>\
											<div class="col-xs-7">\
												<div class="m-portlet__body">\
													<h5 class="m-portlet__head-text">\
														' + obj.nama + '\
													</h5>\
													' + obj.jumlah_member + ' Member\
												</div>\
											</div>\
										</div>\
									</div>\
								</a>\
							</div>';
						});
					}
					$('div#daftar-komunitas').html(html);
				}
			})
		}
		get_community();

		/*Menampilkan komunitas user*/
		function my_community() {
			$.ajax({
				url: "<?php echo base_url('api/Komunitas/my'); ?>",
				method: "POST",
				async: true,
				data: {
					id: 3
				},
				success: function(req) {
					my_community = '';
					if (req.error == true) {
						my_community += '\
						<div class="col-3">\
							<a href="#">\
								<div style="padding: 5px; width: 80%; height: 130px; background: #BEB9B9; border-radius: 5px"></div>\
							</a>\
						</div>\
						';
					} else {
						$.each(req.data, function(index, obj) {
							if (index < 4) {
								my_community += '\
								<div class="col-3">\
									<a href="<?php echo base_url('Community/info/') ?>' + obj.komunitas_id + '">\
										<img src="<?php echo base_url('api/img/komunitas/') ?>' + obj.foto + '" alt="" class="hover rounded" style="width: 100%">\
									</a>\
								</div>\
								';
							}
						})
					}
					$('div.my-community').html(my_community);
				}
			})
		}
		my_community()

		function my_community_selengkapnya() {
			$.ajax({
				url: "<?php echo base_url('api/Komunitas/my'); ?>",
				method: "POST",
				async: true,
				data: {
					id: 3
				},
				success: function(req) {
					my_community_selengkapnya = '';
					if (req.error == true) {
						my_community_selengkapnya += '';
					} else {
						$.each(req.data, function(index, obj) {
							if (index >= 4) {
								my_community_selengkapnya += '\
								<div class="col-3">\
									<a href="<?php echo base_url('Community/info/') ?>' + obj.komunitas_id + '">\
										<img src="<?php echo base_url('api/img/komunitas/') ?>' + obj.foto + '" alt="" class="hover rounded" style="width: 100%">\
									</a>\
								</div>\
								';
							}
						})
					}
					$('div.my-community-selengkapnya').html(my_community_selengkapnya);
				}
			})
		}
		my_community_selengkapnya();

		/*Menampilkan tournament2*/
		function show_tournament(jadwal) {
			$.ajax({
				url: "<?php echo base_url('api/Turnamen/show') ?>",
				method: "POST",
				data: {
					jadwal: jadwal
				},
				async: true,
				success: function(req) {
					html = '';
					if (req.error == true) {
						html += '\
						<div class="m-portlet m-portlet--mobile">\
							<div class="m-portlet__body">\
								<h5 class="text-center">' + req.message + '</h5>\
							</div>\
						</div>';
						$('div.all-turnamen').html('')
					} else {
						$.each(req.data, function(index, obj) {
							if (obj.entry == '1') {
								entry = "Free";
							} else {
								entry = "Group / Squad";
							}
							html += '\
							<a href="<?php echo base_url('turnamen/info/') ?>' + obj.id + '" style="text-decoration: none">\
								<div class="m-portlet m-portlet--mobile hover">\
									<div class="row">\
										<div class="col-md-3">\
											<div style="padding: 5%; margin-top: 2px;" align="center">\
												<img src="<?php echo base_url('api/img/turnamen/') ?>' + obj.image + '" style="width: 100%; max-height: 200px; max-width: 200px" class="rounded border">\
											</div>\
										</div>\
										<div class="col-md-9">\
											<div class="m-portlet__head">\
												<div class="m-portlet__head-caption">\
													<div class="m-portlet__head-title">\
														<h3 class="m-portlet__head-text">\
															' + obj.nama + '\
														</h3>\
													</div>\
												</div>\
											</div>\
											<div class="m-portlet__body">\
												<div class="row">\
													<div class="col-sm-2">\
														ENTRY\
														<br><b>' + entry + '</b>\
													</div>\
													<div class="col-sm-2">\
														SLOTS\
														<br><b>' + obj.slots + '</b>\
													</div>\
													<div class="col-sm-2">\
														TIME \
														<br><b>' + obj.date_start + '</b>\
													</div>\
													<div class="col-sm-2">\
														CLOSE IN \
														<br>' + obj.date_end + '\
													</div>\
													<div class="col-sm-3" align="right">\
														Cookies\
														<br>' + obj.cookies + '\
													</div>\
														<i class="fa fa-cookie-bite text-warning" style="font-size: 30px"></i>\
													<!-- </div> -->\
												</div>\
											</div>\
										</div>\
									</div>\
								</div>\
							</a>';
						})
					}
					$('div.all-turnamen').html(html);
				}
			})
		}
		show_tournament()
		$(document).on('change', 'select.jadwal', function() {
			show_tournament(this.value);
		})


		/*Menampilkan tournament terlaris*/
		function terlaris() {
			$.ajax({
				url: "<?php echo base_url('api/Turnamen/terlaris'); ?>",
				method: "POST",
				async: true,
				success: function(req) {
					html = '';
					if (req.error == true) {
						html += '\
						<div class="col-md-12" align="center">\
							<big>Belum tersedia</big>\
						</div>\
						';
					} else {
						$.each(req.data, function(index, obj) {
							html += '\
							<div class="col-4" align="center">\
								<a href="<?php echo base_url('turnamen/info/') ?>' + obj.id + '">\
									<div class="m-portlet m-portlet--mobile hover p-2">\
										<img src="<?php echo base_url('api/img/turnamen/'); ?>' + obj.image + '" alt="turnament.JPG" style="width: 100%; max-height: 150px; max-width: 150px">\
									</div>\
								</a>\
							</div>\
							';
						})
					}
					$('div.turnamen-terlaris').html(html);
				}
			})
		}
		terlaris();

		/*upload foto*/
		$(document).on('change', 'input.file', function(e) {
			file = e.target.files[0];
			$('label.label-file').html(file.name);
			canvasResize(file, {
				width: 400,
				height: 400,
				crop: true,
				quality: 100,
				// rotate: 90,
				callback: function(data) {
					$('input.foto_identitas').val(data);
					$('img.foto_identitas').attr('src', data);
				}
			});
		})

		/*membuat komunitas*/
		$(document).on('submit', 'form.buat-komunitas', function() {
			nama = $('input.nama').val();
			deskripsi = $('textarea.deskripsi').val();
			kategori = $('select.kategori').val();
			game_id = $('select.game_id').val();
			nomor_identitas = $('input.nomor_identitas').val();
			foto_identitas = $('input.foto_identitas').val();
			nomor_telpon = $('input.nomor_telpon').val();
			$.ajax({
				url: "<?php echo base_url('api/Komunitas/create'); ?>",
				method: "POST",
				data: {
					nama: nama,
					deskripsi: deskripsi,
					kategori: kategori,
					game_id: game_id,
					nomor_identitas: nomor_identitas,
					foto_identitas: foto_identitas,
					nomor_telpon: nomor_telpon,
					user_id: '<?php echo $this->session->userdata('user_id'); ?>'
				},
				success: function(req) {
					if (req.error == true) {
						notif('div.pesan-tambah', 'danger', req.message);
					} else {
						notif('div.pesan', 'success', req.message);
						$('input.nama').val('');
						$('textarea.deskripsi').val('');
						$('select.kategori').val('');
						$('select.game_id').val('');
						$('input.nomor_identitas').val('');
						$('input.foto_identitas').val('');
						$('input.nomor_telpon').val('');
						$('div#buat').modal('hide');
						my_community_selengkapnya();
						my_community();
						get_community();
					}
				}
			})
			return false;
		})

		function get_discover() {
			$.ajax({
				url: "<?php echo base_url('api/Discover/show'); ?>",
				method: "POST",
				async: true,
				success: function(req) {
					html = '';
					if (req.data == '') {
						html += '\
						<div class="col-md-12" align="center">\
							' + req.message + '\
						</div>\
						'
					} else {
						html += '\
						<div class="col-md-12"></div>\
						'
					}
					$('div.discover').html(html);
				}
			})
		}

		get_discover();

		function notif(data, type, message) {
			$(data).html('\
				<div class="alert alert-' + type + '">\
					' + message + '\
					<button class="close pull-right" data-dismiss="alert" type="button"></button>\
				</div>\
				');
		}
	});
</script>