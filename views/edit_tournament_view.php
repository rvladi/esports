<?php include '../views/header.php'; ?>
    <div class="main">
        <div class="content">
            <h1>Edit your event</h1>
            <div class="container">
                <form action="/edit_tournament.php" method="post">
                    <input type="hidden" name="id" value="<?= $tournament['id'] ?>">

                    <label for="title">Event Name</label>
                    <input type="text" id="title" name="title" value="<?= $tournament['title'] ?>" required>

                    <label for="game">Game</label>
                    <select id="game" name="game" required>
                        <?php foreach ($games as $game): ?>
                            <option value="<?= $game['id'] ?>" <?php if ($game['id'] === $tournament['game_id']) echo 'selected'; ?>><?= $game['name'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="platform">Platform</label>
                    <select id="platform" name="platform" required>
                        <?php foreach ($platforms as $platform): ?>
                            <option value="<?= $platform['id'] ?>" <?php if ($platform['id'] === $tournament['platform_id']) echo 'selected'; ?>><?= $platform['name'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="region">Region</label>
                    <select id="region" name="region" required>
                        <?php foreach ($regions as $region): ?>
                            <option value="<?= $region['id'] ?>" <?php if ($region['id'] === $tournament['region_id']) echo 'selected'; ?>><?= $region['name'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="date">Date</label>
                    <input type="date" name="date" value="<?= $tournament['date'] ?>" required>

                    <label for="time">Time</label>
                    <input type="time" name="time" value="<?= $tournament['time'] ?>" required>

                    <label for="description">Event Description</label>
                    <textarea id="description" name="description" style="height:200px" required><?= $tournament['description'] ?></textarea>

                    <input type="submit" value="Submit">
                </form>
            </div>
<?php include '../views/footer.php'; ?>
