<?php
include 'partials/header.php';

// CSRF protection: generate token if not set
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// get inputs from failed registration, sanitize for output
$username = isset($_SESSION['signup_data']['username']) ? htmlspecialchars($_SESSION['signup_data']['username'], ENT_QUOTES, 'UTF-8') : null;
$telephone = isset($_SESSION['signup_data']['telephone']) ? htmlspecialchars($_SESSION['signup_data']['telephone'], ENT_QUOTES, 'UTF-8') : null;

$service_number = isset($_SESSION['signup_data']['service_number']) ? htmlspecialchars($_SESSION['signup_data']['service_number'], ENT_QUOTES, 'UTF-8') : null;
$service_branch = isset($_SESSION['signup_data']['service_branch']) ? htmlspecialchars($_SESSION['signup_data']['service_branch'], ENT_QUOTES, 'UTF-8') : null;

$gender = isset($_SESSION['signup_data']['gender']) ? htmlspecialchars($_SESSION['signup_data']['gender'], ENT_QUOTES, 'UTF-8') : null;
$about = isset($_SESSION['signup_data']['about']) ? htmlspecialchars($_SESSION['signup_data']['about'], ENT_QUOTES, 'UTF-8') : null;
$email = isset($_SESSION['signup_data']['email']) ? htmlspecialchars($_SESSION['signup_data']['email'], ENT_QUOTES, 'UTF-8') : null;
$password = isset($_SESSION['signup_data']['password']) ? htmlspecialchars($_SESSION['signup_data']['password'], ENT_QUOTES, 'UTF-8') : null;
$confirm_password = isset($_SESSION['signup_data']['confirm_password']) ? htmlspecialchars($_SESSION['signup_data']['confirm_password'], ENT_QUOTES, 'UTF-8') : null;
$confirm_human = isset($_SESSION['signup_data']['confirm_human']) ? htmlspecialchars($_SESSION['signup_data']['confirm_human'], ENT_QUOTES, 'UTF-8') : null;

// if all is fine
unset($_SESSION['signup_data']);
?>

<main id="public_main">

  <?php if (isset($_SESSION['signup'])) : ?>
    <div class="alert_message error" id="alert_message">
      <p>
        <?= htmlspecialchars($_SESSION['signup'], ENT_QUOTES, 'UTF-8');
        unset($_SESSION['signup']);
        ?>
      </p>
    </div>
  <?php endif ?>

  <div class="main_log">
    <div class="hero_section">
      <div class="hero_title">
        <h1>Register New User</h1>
      </div>

      <div class="hero_sub">
        <p>
          Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iste est exercitationem placeat accusantium dolore molestiae distinctio quod cum eaque vitae.
        </p>
      </div>
    </div>

    <form action="<?= ROOT_URL ?>admin/dev_mod/signup_logic.php" enctype="multipart/form-data" method="POST" autocomplete="off">
      <!-- CSRF token for security -->
      <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

      <div class="standard_login">


      
        <input type="text" id="username" name="username" value="<?= $username ?>" placeholder="Full Name" maxlength="50" pattern="[A-Za-z0-9_ ]{3,50}" autofocus>
        <input type="tel" name="telephone" value="<?= $telephone ?>" placeholder="Telephone" maxlength="13" pattern="[0-9+\-\s]{7,20}">

        <!-- service details -->
        <input
          type="text"
          id="service_number"
          name="service_number"
          value="<?= $service_number ?>"
          maxlength="10"
          placeholder="Enter user's service number"
          onkeydown="return event.key !== ' '">

        <select name="service_branch">
          <option value="" disabled <?= $service_branch == '' ? 'selected' : '' ?>>Select Service Branch</option>
          <option value="Ghana Police Service" <?= $service_branch == 'Ghana Police Service' ? 'selected' : '' ?>>Ghana Police Service</option>
          <option value="Ghana Armed Forces" <?= $service_branch == 'Ghana Armed Forces' ? 'selected' : '' ?>>Ghana Armed Forces</option>
          <option value="Ghana Prison Service" <?= $service_branch == 'Ghana Prison Service' ? 'selected' : '' ?>>Ghana Prison Service</option>
          <option value="Ghana National Fire Service" <?= $service_branch == 'Ghana National Fire Service' ? 'selected' : '' ?>>Ghana National Fire Service</option>
          <option value="National Security" <?= $service_branch == 'National Security' ? 'selected' : '' ?>>National Security</option>
          <option value="National Signals Bureau" <?= $service_branch == 'National Signals Bureau' ? 'selected' : '' ?>>National Signals Bureau</option>
          <option value="Ghana Immigration Service" <?= $service_branch == 'Ghana Immigration Service' ? 'selected' : '' ?>>Ghana Immigration Service</option>
          <option value="Ghana Customs Service" <?= $service_branch == 'Ghana Customs Service' ? 'selected' : '' ?>>Ghana Customs Service</option>
        </select>


        <select name="gender">
          <option value="" disabled <?= $gender == '' ? 'selected' : '' ?>>Gender</option>
          <option value="Male" <?= $gender == 'Male' ? 'selected' : '' ?>>Male</option>
          <option value="Female" <?= $gender == 'Female' ? 'selected' : '' ?>>Female</option>
        </select>

        <textarea name="about" placeholder="Tell us about yourself." maxlength="500"><?= $about ?></textarea>

        <input type="email" name="email" value="<?= $email ?>" placeholder="Email" maxlength="100">
        <input type="password" name="password" value="<?= $password ?>" placeholder="Password" minlength="8" maxlength="100" autocomplete="new-password">
        <input type="password" name="confirm_password" value="<?= $confirm_password ?>" placeholder="Confirm Password" minlength="8" maxlength="100" autocomplete="new-password">

        <label for="avatar">
          <i class="fa-solid fa-image"></i>
        </label>
        <input type="file" id="avatar" name="avatar" accept="image/*" style="display: none;" />

        <!-- Where the selected file names will be shown -->
        <div id="file-names"></div>


        <style>
          label i {
            font-size: 1.5rem;
            cursor: pointer;
          }

          label i:hover {
            color: var(--color_warning);
          }
        </style>

        <input type="text" name="confirm_human" class="confirm_human" value="<?= $confirm_human ?>" placeholder="confirm_human" maxlength="100">

        <input type="submit" name="submit" value="Register">
      </div>
    </form>



  </div>
</main>

<?php
include '../../partials/footer.php';
?>