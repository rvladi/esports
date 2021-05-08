<?php include '../views/header.php'; ?>
<div class="main">
    <div class="content">
        <h1>Joined Tournaments</h1>

        <div class="grid-container">
            <?php foreach ($tournaments as $tournament): ?>
                <a href="/show_tournament.php?id=<?= $tournament['id'] ?>">
                    <div class="grid-item">
                        <div class="gameImage">
                            <img src="/images/<?= $tournament['image'] ?>" width="100%" height="50%">
                        </div>

                        <div class="gameTitle">
                            <p><?= $tournament['game'] ?></p>
                        </div>

                        <div class="eventName">
                            <p>Event name: <?= $tournament['title'] ?></p>
                        </div>

                        <div class="eventDate">
                            <p>Date: <?= $tournament['date'] ?></p>
                        </div>

                        <div class="eventDate">
                            <p>Time: <?= $tournament['time'] ?></p>
                        </div>

                        <div class="eventPlatform">
                            <p>Platform: <?= $tournament['platform'] ?></p>
                        </div>

                        <div class="eventRegion">
                            <p>Region: <?= $tournament['region'] ?></p>
                        </div>

                    </div>
                </a>
            <?php endforeach; ?>
        </div>

<?php include '../views/footer.php'; ?>
