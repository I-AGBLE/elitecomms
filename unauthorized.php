<?php
include 'partials/header.php';
?>



<main>
  <center>
    <h1>You've been blocked out from accessing elite<span>comms</span> services!</h1>
    <p>Contact your system administrator now.</p>
    <li><a href="logout_logic.php" id="logout">Logout</a></li>

    <div class="extras">
      <p>
        Want to know more <a href="<?= ROOT_URL ?>about.php">About Us</a>? Take
        some time to read our <a href="<?= ROOT_URL ?>tnc.php">Terms And Conditions</a>
        to know about our community guidelines.
      </p>
    </div>
  </center>
</main>


<?php
include 'partials/footer.php';
?>