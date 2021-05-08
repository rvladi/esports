<?php include '../views/header.php'; ?>
<div class="main">
    <div class="content">
        <div class="container" style="background: #12222f">
            <h1>Thank you</h1>
            <h4>for joining a tournament!</h4>
            <img src="/images/<?= $tournament['image'] ?>" width="50%" height="20%"
                 style="margin-left: auto; margin-right: auto; display: block">
            <h1 class="game"><?= $tournament['game'] ?></h1>
            <p>Event name: <?= $tournament['title'] ?></p>
            <p>Date: <?= $tournament['date'] ?></p>
            <p>Time: <?= $tournament['time'] ?></p>
            <p>Platform: <?= $tournament['platform'] ?></p>
            <p>Region: <?= $tournament['region'] ?></p>
            <p>Description: <?= $tournament['description'] ?></p>
            <p>Participants: <?= $tournament['participants'] ?></p>
        </div>

<?php include '../views/footer.php'; ?>
