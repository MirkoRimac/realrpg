<?php $title = $title ?? 'Real RPG'; ?>

<?php
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }

// robust & eindeutig:
$isLoggedIn = isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] > 0;
?>

<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../includes/style.css">
    <link rel="icon" type="image/x-icon" href="sprites/logo.png">
    <title>Real RPG</title>
</head>
<!-- <body class="d-flex flex-column h-100"> -->
<body class="d-flex flex-column h-100 <?= isset($bodyClass) ? htmlspecialchars($bodyClass) : '' ?>">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark transparent-navbar"> 
    <div class="container-fluid">
        <a href="?controller=home&action=index">
            <img src="sprites/logo.png" style="width:45px" class="mx-" alt="RealRPG Logo">
        </a>
        <!-- <a class="navbar-brand fw-bold" style="color: #0097B2;" href="?controller=home&action=index">RealRPG</a> -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-2">
                <!-- Section für Links die immer Sichtbar sind -->
                
                <!-- Je nach Log-In-Status -->
                <?php if ($isLoggedIn): ?>
                <li class="nav-item"><a class="nav-link" href="?controller=dashboard&action=index">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="?controller=inventory&action=index">Inventory</a></li>
                <li class="nav-item"><a class="nav-link" href="?controller=shop&action=index">Shop</a></li>
                <li class="nav-item"><a class="nav-link text-accent" href="?controller=auth&action=logout">Logout</a></li>
                <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="?controller=auth&action=register">Register</a></li>
                <li class="nav-item"><a class="nav-link" href="?controller=auth&action=login">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    </nav>

  <!-- Slot für Seiteninhalt -->
  <main class="flex-shrink-0">
    <?= $content ?>
  </main>

<footer class="footer mt-auto py-3 text-center" >Copyright &copy; 2025 Mörko</footer>

<!-- Overlay Modal -->
<div id="modalOverlay" class="modal fade show d-none" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5); position: fixed; top:0; left:0; right:0; bottom:0; z-index: 1050;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detailed view</h5>
        <button type="button" class="btn-close close-btn" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalBody">
        <!-- Inhalte werden dynamisch per JS eingefügt -->
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script src="js/overlay.js"></script>

</body>
</html>
