<?php
include 'partials/header.php';


// get inputs from failed login
$telephone_or_username = $_SESSION['signin_data']['telephone_or_username'] ?? null;
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
        <input type="text" id="username" name="telephone_or_username" value="<?= $telephone_or_username ?>" placeholder="Telephone or Username" autofocus>
        <input type="password" name="password" value="<?= $password ?>" placeholder="Password">
        <input type="text" name="confirm_human" value="<?= $confirm_human ?>" placeholder="confirm_human" class="confirm_human">
        <input type="submit" name="submit" value="Login">
      </div>

    </form>








    <div class="extras">
      <p>
        Lorem ipsum dolor sit <a href="<?= ROOT_URL ?>about.php">About Us</a> amet consectetur adipising elit. Esse deleniti provident eveniet! <a href="<?= ROOT_URL ?>tnc.php">Terms And Conditions</a> Porro quasi omnis recusandae rem, unde ab ipsum.
      </p>
    </div>
  </div>
</main>





<?php
include 'partials/footer.php';
?>