<?php
// index.php
require_once __DIR__ . '/functions.php';
if (isLoggedIn()) {
    $user = currentUser();
    header('Location: ' . ($user['role'] === 'candidate'
        ? 'candidate_dashboard.php'
        : 'company_dashboard.php'
    ));
} else {
    header('Location: login.php');
}
exit;
