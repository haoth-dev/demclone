<?php
session_start();
$ipage = true;
$title = "Ajax upload";

// Include any necessary functions
require_once("function/function.php");

$demObj = new dementia();
$demTypeList = $demObj->list_all_dem_type();
$careObj = new caregiver();
$pcList = $careObj->list_primary_caregiver();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES)) {
    $response = [];
    $photo_name = isset($_POST['pt_name']) ? sanitizeFileName($_POST['pt_name']) : 'profile_photo';
    $uploadResult = profile_upload_photo_ajax($photo_name);

    if (is_array($uploadResult) && isset($uploadResult['path'])) {
        $response['success'] = true;
        $response['html'] = $uploadResult['message'];
        $response['post'] = $_POST;
        $response['path'] = $uploadResult['path'];
    } else {
        $response['success'] = false;
        $response['error'] = $uploadResult;
    }
    echo json_encode($response);
    exit;
}

//header
require_once("sub/header.php");

//content
?>

<div class="container">
    <form id="image-upload-form" method='post'>

        <div id="targetOuter">
            <div id="targetLayer"></div>
            <img src="asset/images/photo.png" class="icon-choose-image" />

            <div class="icon-choose-image">

                <div class="mb-3">

                    <input class="form-control" type="file" id="formFile" name="userImage" onChange="showPreview(this);">
                </div>
            </div>
        </div>

        <div class="form-floating mb-3">
            <input class="form-control" id="icNumber" type="text" placeholder="Patient IC no" data-sb-validations="required" name="pt_ic" />
            <label for="icNumber">IC Number</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="fullName" type="text" placeholder="Full Name" data-sb-validations="required" name="pt_name" />
            <label for="fullName">Full Name</label>
        </div>
        <div class="form-floating mb-3">
            <input class="form-control" id="dob" type="date" placeholder="DOB" data-sb-validations="required" name="pt_dob" />
            <label for="dob">DOB</label>
        </div>

        <div class="form-floating row mb-3">
            <div class="col-12">
                <button class="btn btn-primary btn-lg btn-block std-btn" id="submitButton" type="submit" name="add" onclick="submitForm()">Add</button>
            </div>
        </div>

    </form>
</div>

<script type="text/javascript">
    function showPreview(objFileInput) {
        if (objFileInput.files[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function(e) {
                $("#targetLayer").html('<img src="' + e.target.result + '" class="upload-preview" />');
                $("#targetLayer").css('opacity', '0.7');
                $(".icon-choose-image").css('opacity', '0.5');
            }
            fileReader.readAsDataURL(objFileInput.files[0]);
        }
    }

    function submitForm() {
        var form = $("#image-upload-form")[0];
        var formData = new FormData(form);
        $.ajax({
            url: "",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                var data = JSON.parse(response);
                if (data.success) {
                    $("#targetLayer").html(data.html);
                    console.log()
                } else {
                    $("#targetLayer").html('<p>' + data.error + '</p>');
                }
            },
            error: function(response) {
                console.log("error");
                console.log(response);
            }
        });
    }
</script>
<?php

require_once("sub/footer.php");
?>