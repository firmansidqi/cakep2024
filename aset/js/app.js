$("#pilih_bulan").change(function() {
	var id_bulan = this.value;
	window.location.assign(base_url+"index.php/admin/kegiatan/pilih_kegiatan/"+id_bulan); 
});