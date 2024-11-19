<?php
include_once "config/Project.php";
use config\Project;

// Inicializácia triedy Project
$project = new Project();

// Spracovanie formulárov pre CRUD operácie
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'create') {
            $project->createProject($_POST['title'], $_POST['description'], $_POST['image']);
        } elseif ($_POST['action'] === 'update') {
            $project->updateProject((int)$_POST['id'], $_POST['title'], $_POST['description'], $_POST['image']);
        }
    }
}

// Odstránenie projektu
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $project->deleteProject((int)$_GET['delete']);
}

// Načítanie všetkých projektov
$projects = $project->getAllProjects();
?>
<!doctype html>
<html lang="en">
<?php include_once "parts/head.php"; ?>
<body>
<!-- Navigačné menu -->
<?php include_once "parts/nav.php"; ?>

<main>
    <!-- Hlavná sekcia -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1>Manage Projects</h1>
                    <p class="mb-4">Tu môžete pridávať, upravovať alebo odstraňovať projekty.</p>
                </div>
            </div>

            <!-- Formulár na pridanie nového projektu -->
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto">
                    <form method="post" class="custom-form">
                        <input type="hidden" name="action" value="create">
                        <div class="mb-3">
                            <label for="title" class="form-label">Názov projektu</label>
                            <input type="text" class="form-control" name="title" id="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Popis projektu</label>
                            <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Cesta k obrázku</label>
                            <input type="text" class="form-control" name="image" id="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Pridať projekt</button>
                    </form>
                </div>
            </div>

            <!-- Zobrazenie všetkých projektov -->
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="text-center">Existujúce projekty</h2>
                    <?php if (!empty($projects)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Názov</th>
                                    <th>Popis</th>
                                    <th>Obrázok</th>
                                    <th>Akcie</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($projects as $proj): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($proj['id']); ?></td>
                                        <td><?= htmlspecialchars($proj['title']); ?></td>
                                        <td><?= htmlspecialchars($proj['description']); ?></td>
                                        <td>
                                            <?php if (!empty($proj['image'])): ?>
                                                <img src="<?= htmlspecialchars($proj['image']); ?>" alt="<?= htmlspecialchars($proj['title']); ?>" style="max-width: 100px;">
                                            <?php else: ?>
                                                No image
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <!-- Formulár na úpravu projektu -->
                                            <form method="post" class="mb-2">
                                                <input type="hidden" name="action" value="update">
                                                <input type="hidden" name="id" value="<?= $proj['id']; ?>">
                                                <input type="text" name="title" value="<?= htmlspecialchars($proj['title']); ?>" class="form-control mb-2">
                                                <textarea name="description" class="form-control mb-2"><?= htmlspecialchars($proj['description']); ?></textarea>
                                                <input type="text" name="image" value="<?= htmlspecialchars($proj['image']); ?>" class="form-control mb-2">
                                                <button type="submit" class="btn btn-success btn-sm">Uložiť</button>
                                            </form>
                                            <!-- Odkaz na odstránenie projektu -->
                                            <a href="?delete=<?= $proj['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Naozaj chcete odstrániť tento projekt?');">Odstrániť</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-center">Žiadne projekty na zobrazenie.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Pätová časť stránky -->
<?php include_once "parts/footer.php"; ?>
</body>
</html>
