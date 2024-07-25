<?php
session_start();
$ipage = true;
$title = "Activity detail";

// Process
require_once("function/function.php");

if (isset($_GET['act_id'])) {
    $actObj = new activity($_GET['act_id']);
    $atObj = new actype();
    $atList = $atObj->list_all_actype();
}

if (isset($_POST['edit'])) {
    view_array($_POST);
}

// Header
require_once("sub/header.php");

// Content
?>

<div class="container">
  <div class="form-floating row">
    <div class="col-2">
      <a href="activity.php" class="btn btn-light btn-lg btn-block std-btn d-flex align-items-center btn-transparent btn-icon-large" role="button" aria-pressed="true"><i class="fas fa-chevron-left"> Back</i></a>
    </div>
  </div>
  <h4>Activity Details</h4>
  <?php 
    $actObj->act_card_design3($actObj->data['act_id'], $actObj->data['at_id'], $actObj->data['act_name'], $actObj->data['act_desc'], $actObj->data['act_datetime']);
  ?>
  <h5>Comments</h5>
  <br>
  <!-- Alert Container -->
  <div id="activity-comment-alert-container"></div>
  <div id="comment-loading-spinner" class="d-none"></div>
    <input type="hidden" id="c_ref_id" value=<?php echo $_GET['act_id']; ?>>
    <input type="hidden" id="c_commentor_id" value=<?php echo $_SESSION['pcd_id']; ?>>
    <div class="form-floating mb-3">
      <textarea class="form-control" id="c_content" type="text" placeholder="Comments" style="height: 10rem;" data-sb-validations="required"></textarea>
      <label for="comment">Comments</label>
    </div>
    <div class="form-floating row mb-3">
      <div class="col-12">
        <button class="btn btn-primary btn-lg btn-block std-btn" id="post" name="post" onclick="addActComment()">Post</button>
      </div>
    </div>
    <hr>
    <div id="activity-comment-card-list"></div>
  </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    fetchActivityComment();

    function fetchActivityComment() {
      var c_ref_id = $('#c_ref_id').val(); // act_id

      console.log('Fetching comments for c_ref_id:', c_ref_id);

      $.ajax({
        url: 'activity_get_comment.php',
        type: 'GET',
        data: {
          c_ref_id: c_ref_id
        },
        success: function(response) {
          console.log('AJAX response:', response);
          var array = (typeof response === 'string') ? JSON.parse(response) : response;

          if (array.success) {
            console.log('Comments fetched successfully:', array.data);
            display_list_comment(array.data);
          } else {
            console.log('Error fetching comments:', array.data);
            var errorAlert = '<div class="alert alert-danger mt-3 mb-3" role="alert">' + array.data + '</div>';
            $('#activity-comment-alert-container').html(errorAlert);
          }
        },
        error: function(error) {
          console.log('AJAX request failed:', error);
          alert('AJAX request failed. Please try again.');
        }
      });
    }

    function addActComment() {
      var c_content = $('#c_content').val();
      var c_ref_id = $('#c_ref_id').val();
      var c_task_type = "activity";
      var c_commentor_id = $('#c_commentor_id').val();

      var data = {
        "post_comment": 1,
        "c_content": c_content,
        "c_ref_id": c_ref_id,
        "c_task_type": c_task_type,
        "c_commentor_id": c_commentor_id
      };

      console.log('Posting comment data:', data);

      $.ajax({
        url: 'activity_detail_comment.php',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
          var array = (typeof response === 'string') ? JSON.parse(response) : response;

          console.log('AJAX response for posting comment:', array);

          if (array.success) {
            console.log('Comment posted successfully:', array.data);
            var successAlert = '<div class="alert alert-success mt-3 mb-3" role="alert">Comment Added!</div>';
            $('#activity-comment-alert-container').html(successAlert);
            $('#c_content').val(''); // Clear the comment input field
            fetchActivityComment(); // Fetch and display comments again
          } else {
            console.log('Error posting comment:', array.data);
            var errorAlert = '<div class="alert alert-danger mt-3 mb-3" role="alert">' + array.data + '</div>';
            $('#activity-comment-alert-container').html(errorAlert);
          }
        },
        error: function(error) {
          console.log('AJAX request failed:', error);
          alert('AJAX request failed. Please try again.');
        },
        complete: function() {
          $('#comment-loading-spinner').addClass('d-none');
        }
      });
    }

    function display_list_comment(comments) {
      // Ensure comments is an array
      if (!Array.isArray(comments)) {
        console.error('Comments data is not an array:', comments);
        return;
      }

      var card_design = '';

      comments.forEach(function(comment) {
        console.log('Displaying comment:', comment);
        card_design += `
          <div class="card mt-2 mb-2">
            <div class="card-body">
              <h5 class="card-title">${comment.pcd_name}</h5>
              <h6 class="card-subtitle mb-2 text-body-secondary">${comment.duration}</h6>
              <p class="card-text">${comment.c_content}</p>
            </div>
          </div>
        `;
      });

      $('#activity-comment-card-list').html(card_design);
    }

    // Ensure the addActComment function is globally accessible
    window.addActComment = addActComment;
  });
</script>

<?php

require_once("sub/footer.php");
?>
