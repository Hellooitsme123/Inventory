//const { isNull } = require("lodash");

// Call the dataTables jQuery plugin
$(document).ready(function () {
	var table = $('#dataTable').DataTable();
	if ($('#dataTable').hasClass("foodTable")) {
		// Custom search functionality
		console.log("higher");
		$.fn.dataTable.ext.search.push(
			function (settings, data, dataIndex) {
				console.log(data,"hi");
				var expirationDate = new Date(data[4]); // Assuming the expiration date is in the 5th column (0-indexed)
				var today = new Date();
				var daysUntilExpired = (expirationDate - today) / (1000 * 60 * 60 * 24); // Difference in days

				// If @almost_expired is used, filter by "almost expired" condition
				if ($('input[type="search"]').val().indexOf('@almost_expired') !== -1) {
					return daysUntilExpired <= 21 && daysUntilExpired >= 0;
				}

				// If @expired is used, filter by "expired" condition
				if ($('input[type="search"]').val().indexOf('@expired') !== -1) {
					return daysUntilExpired < 0; // Expired
				}

				return true;
			}
		);

		// Trigger a redraw when the search input changes
		$('input[type="search"]').unbind().bind('keyup', function(e) {
			var searchTerm = $(this).val(); // Get the current search term
	
			if (searchTerm.indexOf('@almost_expired') !== -1 || searchTerm.indexOf('@expired') !== -1) {
				// If the search term contains our custom query, force a redraw with custom filtering
				console.log('obogo');
				table.search('').draw();
			} else {
				console.log('obogo2');
				// Otherwise, let DataTables do the default search
				table.search(searchTerm).draw();
			}
		});
	}
});
