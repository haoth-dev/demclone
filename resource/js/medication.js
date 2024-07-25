function meds_detail(button) {
    var meds_id = $(button).siblings('.meds_id_val').val();
    $('#modal_meds_id').val(meds_id);  // Set the hidden input field
    // console.log(meds_id);
    $.ajax({
        url: 'medication.php',//antar ke mana
        method: 'POST',//apa methodnya
        dataType: 'json',//apa data typenya
        data: {
            'ajax_detail_btn': 1,//untuk isset rh php
            'ajax_meds_id': meds_id
        },
        success: function (array) {//kalau ajax success ngantar

            loadMedsModal(array);

            // console.log(array.medsData);
        },
        error: function (array) {
            console.log("failed");
        }
    });
}

function loadMedsModal(array) {
    // $('#view_meds_data').html(array);
    var div_list_user = document.getElementById('view_meds_data');
    var content = "";
    content += "";


    content += "<div class='card'>"
        + "  <div class='card-body'>"
        + " <h5 class='card-title'>" + array.medsData['meds_name'] + "</h5>"
        + " <p class='card-text'>" + array.medsData['meds_desc'] + "</p>"
        + " </div>"
        + "</div>"


    div_list_user.innerHTML = content;
    $('#medsDetailModal').modal('show');
}

function meds_update_form(button) {
    var meds_id = $(button).siblings('.meds_id_val').val();
    if (!meds_id) {
        meds_id = $(button).closest('tr').find('.meds_id_val').val();
    }

    $('#update_meds_id').val(meds_id);  // Set the hidden input field
    $.ajax({
        url: 'medication.php',
        method: 'POST',
        dataType: 'json',
        data: {
            'ajax_modal_btn': 1,
            'ajax_meds_id': meds_id
        },
        success: function (array) {

            loadMedsUpdateModal(array);
        },
        error: function (array) {
            console.log(array.medsData);
        }
    });
}

function loadMedsUpdateModal(array) {
    var div_list_user = document.getElementById('update_meds_data');
    var content = "";

    content += "<div class='card'>"
        + "  <div class='card-body'>"
        + " <h5 class='card-title'>" + array.medsData['meds_name'] + "</h5>"
        + " <p class='card-text'>" + array.medsData['meds_desc'] + "</p>"
        + " </div>"
        + "</div>";

    div_list_user.innerHTML = content;
    $('#medsUpdateModal').modal('show');
}

function assign_meds() {
    var pcd_id = $('#pcd_id').val();
    var pt_id = $('#patientName').val();
    var meds_id = $('#medsName').val();
    var pcm_qty = $('#qtyPerServ').val();
    var pcm_unit = $('#medsUnit').val();
    var pcm_freq = $('#freqPerDay').val();
    var pcm_remark = $('#sideEffect').val();

    // Validate input values
    if (pcd_id && pt_id && meds_id && pcm_qty && pcm_freq) {
        $.ajax({
            url: 'medication_intake.php',
            method: 'POST',
            dataType: 'json',
            data: {
                assign_btn: 1,
                pcd_id: pcd_id,
                pt_id: pt_id,
                meds_id: meds_id,
                pcm_qty: pcm_qty,
                pcm_unit: pcm_unit,
                pcm_freq: pcm_freq,
                pcm_remark: pcm_remark
            },
            success: function (array) {
                // Handle the response from the server
                if (array.success) {
                    alert("Assign Meds success");
                    window.location.replace("medication_intake.php?add_result=success");
                }
                else {
                    console.log('post fail')
                }


            },
            error: function (xhr, status, error) {
                // Handle any errors
                console.error(xhr.responseText);
                alert('An error occurred while assigning medication.');
            }
        });
    } else {
        alert('Please fill all the fields.');
    }
}

function assign_meds_edit() {
    var pcd_id = $('#pcd_id').val();
    var pcm_id = $('#pcm_id').val();
    var pt_id = $('#patientName').val();
    var meds_id = $('#medsName').val();
    var pcm_qty = $('#qtyPerServ').val();
    var pcm_unit = $('#medsUnit').val();
    var pcm_freq = $('#freqPerDay').val();
    var pcm_remark = $('#sideEffect').val();

    // Validate input values
    if (pcd_id && pt_id && meds_id && pcm_qty && pcm_freq) {
        $.ajax({
            url: 'medication_assigned_edit.php',
            method: 'POST',
            dataType: 'json',
            data: {
                edit_btn: 1,
                pcd_id: pcd_id,
                pcm_id: pcm_id,
                pt_id: pt_id,
                meds_id: meds_id,
                pcm_qty: pcm_qty,
                pcm_unit: pcm_unit,
                pcm_freq: pcm_freq,
                pcm_remark: pcm_remark
            },
            success: function (array) {
                // Handle the response from the server
                if (array.success) {
                    alert("Edit success");
                    window.location.replace("medication_intake.php?edit_result=success");
                    //console.log(array.data);
                }
                else {
                    console.log(array.error);
                }


            },
            error: function (xhr, status, error, array) {
                // Handle any errors
                console.error(xhr.responseText);
                console.log(array.error);
                alert('An error occurred while assigning medication.');
            }
        });
    } else {
        alert('Please fill all the fields.');
    }
}


//delete assigned medication zone start
function handleDeleteButtonClick(button) {
    var pcm_id = button.getAttribute('data-pcm-id');

    $.ajax({
        url: 'medication_intake.php',
        method: 'POST',
        dataType: 'json',
        data: {
            delete_btn: 1,
            pcm_id: pcm_id,
        },
        success: function (array) {
            // Handle the response from the server
            if (array.success) {
                alert("Delete success");
                console.log(array.data);
                window.location.replace("medication_intake.php?delete=success");

            }
            else {
                alert("Delete Failed");
                window.location.replace("medication_intake.php?delete=failed");
                // console.log(array.error);
            }


        },
        error: function (xhr, status, error, array) {
            // Handle any errors
            console.error(xhr.responseText);
            console.log(array.error);
            alert('An error occurred while Deleting Meds Assigned Data.');
        }
    });

    // Add any additional logic for handling the delete action here
}
//delete assigned medication zone end

//for tab design

/**


 * 
 */

