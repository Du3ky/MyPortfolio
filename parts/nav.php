<?php
include_once 'config/Menu.php';

use config\Menu;
$menu = new Menu();
$menu->loadMenuFromDatabase();
?>


<nav class="navbar navbar-expand-lg">
    <div class="container">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a href="index.php" class="navbar-brand mx-auto mx-lg-0">First</a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-lg-5">
                <?php echo $menu->generateMenuHtml(); ?>
                <li class="nav-item">
                    <a href="manage_projects.php" class="nav-link">Manage Projects</a>
                </li>
            </ul>
        </div>
    </div>
</nav>