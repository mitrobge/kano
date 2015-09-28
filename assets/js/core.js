$(function() {

	$(".tbl_repeat tbody").tableDnD({
		onDrop: function(table, row) {
			var orders = $.tableDnD.serialize();
			$.post('presentation/admin_categories.php', { orders : orders });
		}
	});

});
