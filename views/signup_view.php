<?php include '../views/header.php'; ?>
<div class="main">
    <div class="content">
        <h1>Sign Up</h1>

        <div class="container">
            <form action="/signup.php" method="post">
                <?php if ($error): ?>
                    <p style="color:tomato"><?= $error ?></p>
                <?php endif; ?>

                <p><label for="username">Username:</label>
                <input id="username" type="text" name="username" placeholder="Enter your username" required></p>

                <p><label for="password">Password:</label>
                <input id="password" type="password" name="password" placeholder="Enter your password" required></p>

                <p><input type="submit" value="Sign Up"></p>

                <div style="color:black;font-size:10pt;text-align:center">Already have an eSports account?&nbsp;<a href="/login.php">Please log in here.</a></div>
            </form>
        </div>

<?php include '../views/footer.php'; ?>
