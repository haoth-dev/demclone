<?php
session_start();
$ipage = true;
$title = "Admin Log";

// Process
require_once("function/function.php");

$logObj = new log();
$items_per_page = 10;

// Get paginated results for "All Logs"
$allLogPagination = $logObj->get_paginated_logs($logObj, 'page', 'list_admin_log_paginated', 'count_all_admin_log', $items_per_page);
$allLog = $allLogPagination['logs'];
$totalPages = $allLogPagination['totalPages'];
$page = $allLogPagination['currentPage'];

// Get paginated results for "Access Logs"
$accessLogPagination = $logObj->get_paginated_logs($logObj, 'access_page', 'list_access_log_paginated', 'count_access_log', $items_per_page);
$accessLog = $accessLogPagination['logs'];
$accessTotalPages = $accessLogPagination['totalPages'];
$accessPage = $accessLogPagination['currentPage'];

// Get paginated results for "Event Logs"
$eventLogPagination = $logObj->get_paginated_logs($logObj, 'event_page', 'list_event_log_paginated', 'count_event_log', $items_per_page);
$eventLog = $eventLogPagination['logs'];
$eventTotalPages = $eventLogPagination['totalPages'];
$eventPage = $eventLogPagination['currentPage'];



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
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo $activeTab == 'log_access' ? 'active' : ''; ?>" id="log-access-tab" data-bs-toggle="tab" data-bs-target="#log_access" type="button" role="tab" aria-controls="log_access">Access Log</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?php echo $activeTab == 'log_event' ? 'active' : ''; ?>" id="log-activity-tab" data-bs-toggle="tab" data-bs-target="#log_event" type="button" role="tab" aria-controls="log_event">Event Log</button>
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

                <div class="tab-pane fade <?php echo $activeTab == 'log_access' ? 'show active' : ''; ?>" id="log_access" role="tabpanel" aria-labelledby="log-access-tab">
                    <?php if (!empty($accessLog)) { ?>
                        <br>
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>User</th>
                                <th>Detail</th>
                                <th>Date</th>
                            </thead>
                            <tbody>
                                <?php
                                $counter = ($accessPage - 1) * $items_per_page + 1;
                                foreach ($accessLog as $value) {
                                    $careObj = new caregiver($value['pcd_id']);
                                    echo "<tr>
                                            <td>{$counter}</td>
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
                                <li class="page-item <?php echo ($accessPage <= 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?access_page=<?php echo $accessPage - 1; ?>&tab=log_access" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for ($i = 1; $i <= $accessTotalPages; $i++) { ?>
                                    <li class="page-item <?php echo ($i == $accessPage) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?access_page=<?php echo $i; ?>&tab=log_access"><?php echo $i; ?></a>
                                    </li>
                                <?php } ?>
                                <li class="page-item <?php echo ($accessPage >= $accessTotalPages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?access_page=<?php echo $accessPage + 1; ?>&tab=log_access" aria-label="Next">
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

                <div class="tab-pane fade <?php echo $activeTab == 'log_event' ? 'show active' : ''; ?>" id="log_event" role="tabpanel" aria-labelledby="log-event-tab">
                    <?php if (!empty($eventLog)) { ?>
                        <br>
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>User</th>
                                <th>Detail</th>
                                <th>Date</th>
                            </thead>
                            <tbody>
                                <?php
                                $counter = ($eventPage - 1) * $items_per_page + 1;
                                foreach ($eventLog as $value) {
                                    $careObj = new caregiver($value['pcd_id']);
                                    echo "<tr>
                                            <td>{$counter}</td>
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
                                <li class="page-item <?php echo ($eventPage <= 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?event_page=<?php echo $eventPage - 1; ?>&tab=log_event" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for ($i = 1; $i <= $eventTotalPages; $i++) { ?>
                                    <li class="page-item <?php echo ($i == $eventPage) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?event_page=<?php echo $i; ?>&tab=log_event"><?php echo $i; ?></a>
                                    </li>
                                <?php } ?>
                                <li class="page-item <?php echo ($eventPage >= $eventTotalPages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?event_page=<?php echo $eventPage + 1; ?>&tab=log_event" aria-label="Next">
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