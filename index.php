<?php
include 'partials/header.php';


// get inputs from failed login
$service_number_or_email = $_SESSION['signin_data']['service_number_or_email'] ?? null;
$password = $_SESSION['signin_data']['password'] ?? null;;
$confirm_human = $_SESSION['signin_data']['confirm_human'] ?? null;;


?>
















<main id="public_main">

  <?php if (isset($_SESSION['signin'])) : ?>
    <div class="alert_message error" id="alert_message">
      <p>
        <?= $_SESSION['signin'];
        unset($_SESSION['signin']);
        ?>
      </p>
    </div>

  <?php elseif (isset($_SESSION['delete_profile_success'])) : ?>
    <div class="alert_message success" id="alert_message">
      <p>
        <?= $_SESSION['delete_profile_success'];
        unset($_SESSION['delete_profile_success']);
        ?>
      </p>
    </div>

  <?php elseif (isset($_SESSION['signup_success'])) : ?>
    <div class="alert_message success" id="alert_message">
      <p>
        <?= $_SESSION['signup_success'];
        unset($_SESSION['signup_success']);
        ?>
      </p>
    </div>
  <?php endif ?>

  <div class="main_log">
    <div class="hero_section">
      <div class="hero_title">
        <h1>Welcome to elite<span>comms</span></h1>
      </div>

      <div class="hero_sub">
        <p>
          This project is in partial fulfilment of the requirement 
          for the award of the Degree of Master of Science in Information Technology
          from the BlueCrest University College, Accra.
        </p>
      </div>
    </div>






    <form action="<?= ROOT_URL ?>index_logic.php" method="POST">

      <div class="standard_login">
        <input type="text" id="service_number_or_email" name="service_number_or_email" value="<?= $service_number_or_email ?>" placeholder="Service Number or Email" autofocus>
        <input type="password" name="password" value="<?= $password ?>" placeholder="Password">
        <input type="text" name="confirm_human" value="<?= $confirm_human ?>" placeholder="confirm_human" class="confirm_human">
        <input type="submit" name="submit" value="Login">
      </div>

    </form>








    <div class="extras">
      <p>
        Want to know more  <a href="<?= ROOT_URL ?>about.php">About Us</a>? Take
        some time to read our <a href="<?= ROOT_URL ?>tnc.php">Terms And Conditions</a> 
        to know about our community guidelines.
      </p>
    </div>
  </div>
</main>





<?php
include 'partials/footer.php';
?>