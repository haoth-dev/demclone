function assign_sc(button) {
    var scd_id = $(button).siblings('.pcd_id_val').val();
    var pcsc_status = $(button).siblings('.pcsc_status_val').val();
    var caregiverId = button.previousElementSibling.value; // Fetch the hidden input value
    var patientName = button.closest('.card').querySelector('.card-header').textContent; // Fetch the patient name from the card header
    var patientId = button.closest('.card').querySelector('.pt_id_val').value;

    $.ajax({
        url: 'patient.php',
        method: 'POST',
        data: {
            "ajax_assign_btn": 1,
            "scd_id": scd_id,
            "pt_id": patientId,
            "pcsc_status": pcsc_status,

        },
        dataType: 'json',
        success: function (array) {
            if (array.success) {
                console.log(array.data);
                window.location.reload(true);
            }
            else {
                console.log('post fail');
            }
        },
        error: function (array) {
            console.log('ajax failed');
        }
    });

}

function delete_sc(button) {
    // Find the closest pcd_id_val input
    let pcdIdInput = button.closest('tr').querySelector('.pcd_id_val');
    var scaregiverEmail = button.previousElementSibling.value; // Fetch the hidden input value
    if (pcdIdInput) {
        let scd_id = pcdIdInput.value;
        //  console.log(scaregiverEmail);
        //   console.log(scd_id); // You can replace this with any action you want
        // For example, you can make an AJAX call or show a confirmation dialog

        $.ajax({
            url: 'patient.php',
            method: 'POST',
            data: {
                "ajax_delete_btn": 1,
                "scd_id": scd_id,
                "scd_email": scaregiverEmail,

            },
            dataType: 'json',
            success: function (array) {
                if (array.success) {
                    console.log('data deleted');
                    window.location.reload(true);
                }
                else {
                    console.log('delete fail');
                }
            },
            error: function (array) {
                console.log('ajax failed');
            }
        });
    }
}

//for tab desigb
/**


 */

