jQuery(document).ready(function () {
	jQuery("#wpl_export").click(function () {
		jQuery(".tab-export").addClass("tab-active");
		jQuery(".tab-import").removeClass("tab-active");
	})
	jQuery("#wpl_import").click(function () {
		jQuery(".tab-export").removeClass("tab-active");
		jQuery(".tab-import").addClass("tab-active");
	})
});