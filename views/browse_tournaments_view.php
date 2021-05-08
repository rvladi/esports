<?php include '../views/header.php'; ?>
<div class="main">
    <div class="content">
        <h1>Browse Events</h1>

        <form action="/browse_tournaments.php" method="get">
            <div class="grid-container">
                <div>
                    <select name="game" id="game">
                        <option value="0">All games</option>
                        <?php foreach($games as $game): ?>
                            <option value="<?= $game['id'] ?>" <?php if ($game['selected']) echo 'selected'; ?>><?= $game['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <select name="platform" id="platform">
                        <option value="0">All platforms</option>
                        <?php foreach($platforms as $platform): ?>
                            <option value="<?= $platform['id'] ?>" <?php if ($platform['selected']) echo 'selected'; ?>><?= $platform['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <select name="region" id="region">
                        <option value="0">All regions</option>
                        <?php foreach($regions as $region): ?>
                            <option value="<?= $region['id'] ?>" <?php if ($region['selected']) echo 'selected'; ?>><?= $region['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="start_date">From:</label>
                    <input type="date" name="start_date" id="start_date" value="<?= $start_date ?>">
                    <label for="end_date">To:</label>
                    <input type="date" name="end_date" id="end_date" value="<?= $end_date ?>">
                </div>
            </div>
            <input type="Submit" value="Filter">
        </form>

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
