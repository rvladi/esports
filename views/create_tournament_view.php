<?php include '../views/header.php'; ?>
<div class="main">
    <div class="content">
        <h1>Create your event</h1>
        <div class="container">
            <form action="/create_tournament.php" method="post">
                <label for="title">Event Name</label>
                <input type="text" id="title" name="title" placeholder="Name of your event" required>

                <label for="game">Game</label>
                <select id="game" name="game" required>
                    <option value="" selected disabled>Select a game</option>
                    <?php foreach ($games as $game): ?>
                        <option value="<?= $game['id'] ?>"><?= $game['name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="platform">Platform</label>
                <select id="platform" name="platform" required>
                    <option value="" selected disabled>Select a platform</option>
                    <?php foreach ($platforms as $platform): ?>
                        <option value="<?= $platform['id'] ?>"><?= $platform['name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="region">Region</label>
                <select id="region" name="region" required>
                    <option value="" selected disabled>Select a region</option>
                    <?php foreach ($regions as $region): ?>
                        <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="date">Date</label>
                <input type="date" name="date" required>

                <label for="time">Time</label>
                <input type="time" name="time" required>

                <label for="description">Event Description</label>
                <textarea id="description" name="description" placeholder="Write the description of your event..."
                          style="height:200px" required></textarea>

                <input type="submit" value="Submit">
            </form>
        </div>
<?php include '../views/footer.php'; ?>
