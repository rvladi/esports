<?php include '../views/header.php'; ?>
<div class="main">
    <div class="content">
        <div class="container" style="background: #12222f">
    	<img src="/images/<?= $tournament['image'] ?>" width="50%" height="20%" style="margin-left: auto; margin-right: auto; display: block">
    	<h1 class="game"><?= $tournament['game'] ?></h1>
        <p>Event name: <?= $tournament['title'] ?></p>
        <p>Date: <?= $tournament['date'] ?></p>
        <p>Time: <?= $tournament['time'] ?></p>
        <p>Platform: <?= $tournament['platform'] ?></p>
        <p>Region: <?= $tournament['region'] ?></p>
        <p>Description: <?= $tournament['description'] ?></p>
        <p>Participants: <?= $tournament['participants'] ?></p>

        <form>

            <input type="hidden" name="id" value="<?= $tournament['id'] ?>">

            <table border="0">
                <tr>
                	<?php if ($tournament['joined']): ?>
                		<td><input style="float:left" type="submit" value="Leave tournament" formaction="/leave_tournament.php" formmethod="get"></td>
                	<?php else: ?>
                    	<td><input type="submit" value="Join tournament" formaction="/join_tournament.php" formmethod="get"></td>
                	<?php endif; ?>

                    <?php if ($tournament['created']): ?>
                        <td><input type="submit" value="Edit tournament" formaction="/edit_tournament.php" formmethod="get"></td>
                        <td><input type="submit" value="Delete tournament" formaction="/delete_tournament.php" formmethod="post"></td>
                    <?php endif; ?>
                </tr>
            <table>

    	</form>

		<p><button type="button" onclick="window.history.back()">Back to tournaments</button></p>

        </div>

<?php include '../views/footer.php'; ?>
