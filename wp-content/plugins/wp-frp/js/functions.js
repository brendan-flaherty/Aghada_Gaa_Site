/* INITIALIZE ALL */
jQuery(document).ready(function () {
	jQuery('.one').datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		yearRange: "1899:2020"
	});
});
