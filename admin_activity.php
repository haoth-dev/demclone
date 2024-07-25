<?php
session_start();
$ipage = true;
$title = "Admin Activity Log";

// Process
require_once("function/function.php");

$logObj = new log();
$items_per_page = 10;

// Get paginated results for "All Logs"
$allLogPagination = $logObj->get_paginated_logs($logObj, 'page', 'list_admin_log_paginated', 'count_all_admin_log', $items_per_page);
$allLog = $allLogPagination['logs'];
$totalPages = $allLogPagination['totalPages'];
$page = $allLogPagination['currentPage'];


// Determine the active tab from query parameters
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'log_all';

// Header
require_once("sub/header.php");
?>

<div class="container">
    <br>
    <div class="card">
        <h5 class="card-header">Admin Log</h5>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo $activeTab == 'log_all' ? 'active' : ''; ?>" id="log-all-tab" data-bs-toggle="tab" data-bs-target="#log_all" type="button" role="tab" aria-controls="log_all">All</button>
                </li>

            </ul>

            <div class="tab-content">
                <div class="tab-pane fade <?php echo $activeTab == 'log_all' ? 'show active' : ''; ?>" id="log_all" role="tabpanel" aria-labelledby="log-all-tab">
                    <?php if (!empty($allLog)) { ?>
                        <br>
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Log Type</th>
                                <th>User</th>
                                <th>Detail</th>
                                <th>Date</th>
                            </thead>
                            <tbody>
                                <?php
                                $counter = ($page - 1) * $items_per_page + 1;
                                foreach ($allLog as $value) {
                                    $careObj = new caregiver($value['pcd_id']);
                                    echo "<tr>
                                            <td>{$counter}</td>
                                            <td>{$value['al_type']}</td>
                                            <td>{$careObj->data['pcd_name']}</td>
                                            <td>{$value['al_detail']}</td>
                                            <td>{$value['al_date']}</td>
                                          </tr>";
                                    $counter++;
                                }
                                ?>
                            </tbody>
                        </table>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $page - 1; ?>&tab=log_all" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>&tab=log_all"><?php echo $i; ?></a>
                                    </li>
                                <?php } ?>
                                <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $page + 1; ?>&tab=log_all" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    <?php } else { ?>
                        <div class="alert alert-warning" role="alert">
                            No log saved yet...
                        </div>
                    <?php } ?>
                </div>



            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var triggerTabEl = document.querySelector('#myTab button.active');
        bootstrap.Tab.getInstance(triggerTabEl).show();
    });
</script>

<?php
require_once("sub/footer.php");
?>