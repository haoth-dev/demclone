function admin_med_search() {
    var meds_name = $('#meds_search_input').val();
    if (!meds_name.trim()) {
        alert("Please enter a medication name.");
        return;
    }

    $.ajax({
        url: 'admin_medlib_search.php',
        method: 'POST',
        dataType: 'json',
        data: {
            'post_search_btn': 1,
            'meds_name': meds_name
        },
        success: function (response) {
            if (response.success) {
                var successAlert = '<div class="alert alert-success" role="alert">Search found. </div>';
                $('#alert-container').html(successAlert);
                updateSearchResults(response.data);
                console.log(response.data);
            } else {
                var errorAlert = '<div class="alert alert-danger" role="alert">No result found</div>';
                $('#alert-container').html(errorAlert);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Error in AJAX request:", textStatus, errorThrown);
            alert("An error occurred while processing your request. Please try again.");
        },
        complete: function () {
            // Hide loading spinner
            $('#loading-spinner').addClass('d-none');
        }
    });
}

function updateSearchResults(data) {
    var resultsTable = $('#search_results');
    resultsTable.empty();
    if (data.length > 0) {
        $.each(data, function (index, item) {
            var row = `<tr>
                <td>${index + 1}</td>
                <td>${item.meds_name}</td>
                <td>${item.pcd_name}</td>
                <td>${item.meds_added_date}</td>
                 <td><a href="admin_medlib_edit.php?meds_id=${item.meds_id}&&page=search" class="btn btn-outline-info"> <i class="fas fa-pen"></i></a></td>
            </tr>`;
            resultsTable.append(row);
        });
    } else {
        resultsTable.append('<tr><td colspan="5" class="text-center">No results found</td></tr>');
    }
}