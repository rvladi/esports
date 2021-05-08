<?php include '../views/header.php'; ?>
<div class="main">
    <div class="content">
        <h1>Log In</h1>

        <div class="container">
            <form action="/login.php" method="post">
                <?php if ($error): ?>
                    <p style="color:tomato"><?= $error ?></p>
                <?php endif; ?>

                <p><label for="username">Username:</label>
                <input id="username" type="text" name="username" placeholder="Enter your username" required></p>

                <p><label for="password">Password:</label>
                <input id="password" type="password" name="password" placeholder="Enter your password" required></p>

                <p><input type="hidden" name="location" value="<?= $location ?>"></p>
                <p><input type="submit" value="Log In"></p>

                <div style="color:black;font-size:10pt;text-align:center">Don't have an eSports account yet?&nbsp;<a href="/signup.php">Please sign up here.</a></div>
            </form>
        </div>

<?php include '../views/footer.php'; ?>
