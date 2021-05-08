<?php session_start(); ?>
<?php include '../views/header.php'; ?>
<header class="parallax"></header>
<div class="main">
    <div class="content">
        <h1>Create your tournaments here!</h1>
        <div class="container" style="color: #12222f">

            <img src="/images/tools.png"
                 style="float:left; margin-right: 30px">

            <p>Anyone can create a tournament on eSports for any supported game.</p>
            <p>Thousands of independent event organizers use the eSports platform every month.</p>
            <p>eSports is and will always be 100% free for organizers and players.</p>
            <br/>
            <form action="/create_tournament.php" method="get">
                <input id="button" type="submit" value="Create my tournament!">
            </form>
        </div>
<?php include '../views/footer.php'; ?>
