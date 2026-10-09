<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$current_page = 'admissions';
$page_title = 'Apply to DEVQII';
$meta_description = 'Apply to DEVQII for the 2026/2027 academic year using our admissions form.';
$canonical_path = 'apply.php';
$flash_message = $_SESSION['flash_message'] ?? '';
$flash_type = $_SESSION['flash_type'] ?? 'success';
$old_input = $_SESSION['old_input'] ?? [];
unset($_SESSION['flash_message'], $_SESSION['flash_type'], $_SESSION['old_input']);

function old_value($key, $default = '') {
    global $old_input;
    return htmlspecialchars($old_input[$key] ?? $default, ENT_QUOTES, 'UTF-8');
}

function selected_value($key, $value) {
    global $old_input;
    return (($old_input[$key] ?? '') === $value) ? ' selected' : '';
}

function checked_value($key) {
    global $old_input;
    return !empty($old_input[$key]) ? ' checked' : '';
}
?>
<?php include_once 'includes/header.php'; ?>
    <section class="section">
      <div class="container">
        <p class="badge">Admissions Form</p>
        <h1 class="section-title">Application form</h1>
        <p class="section-intro">Please complete the form below and the admissions team will contact you shortly.</p>
        <div class="grid-2" style="margin-bottom: 2rem;">
          <div class="panel">
            <h3 style="margin-top: 0; color: var(--blue);">Need help?</h3>
            <p><strong>Okoye Bilikha</strong><br><a href="https://wa.me/447456948517">+44 7456 948517</a></p>
            <p><strong>Ndive Njumbe</strong><br><a href="https://wa.me/237677308819">+237 677 308819</a></p>
          </div>
          <div class="panel">
            <h3 style="margin-top: 0; color: var(--blue);">Why DEVQII?</h3>
            <p>✓ Registered with Ministry of Higher Education<br>✓ Cameroon HND Software Engineering<br>✓ UK-informed international standards<br>✓ Evening & Saturday classes<br>✓ Real project-based learning</p>
          </div>
        </div>
        <?php if (!empty($flash_message)): ?>
          <div class="<?php echo $flash_type === 'error' ? 'error' : 'success'; ?>" role="alert">
            <?php echo htmlspecialchars($flash_message); ?>
          </div>
        <?php endif; ?>
        <form class="panel" action="process-application.php" method="post" data-validate="true" novalidate>
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
          <div class="honeypot">
            <label for="website">Leave this blank</label>
            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
          </div>
          <div class="form-grid">
            <div>
              <label for="full_name">Full name</label>
              <input id="full_name" name="full_name" type="text" value="<?php echo old_value('full_name'); ?>" required>
            </div>
            <div>
              <label for="email">Email</label>
              <input id="email" name="email" type="email" value="<?php echo old_value('email'); ?>" required>
            </div>
            <div>
              <label for="telephone">Telephone</label>
              <input id="telephone" name="telephone" type="tel" value="<?php echo old_value('telephone'); ?>" required>
            </div>
            <div>
              <label for="whatsapp">WhatsApp number</label>
              <input id="whatsapp" name="whatsapp" type="tel" value="<?php echo old_value('whatsapp'); ?>" required>
            </div>
            <div>
              <label for="city">City</label>
              <input id="city" name="city" type="text" value="<?php echo old_value('city'); ?>" required>
            </div>
            <div>
              <label for="qualification">Highest qualification</label>
              <select id="qualification" name="qualification" required>
                <option value="">Select</option>
                <option<?php echo selected_value('qualification', 'GCE Advanced Level'); ?>>GCE Advanced Level</option>
                <option<?php echo selected_value('qualification', 'Baccalauréat'); ?>>Baccalauréat</option>
                <option<?php echo selected_value('qualification', 'Equivalent recognised qualification'); ?>>Equivalent recognised qualification</option>
              </select>
            </div>
            <div>
              <label for="employment_status">Current employment status</label>
              <select id="employment_status" name="employment_status" required>
                <option value="">Select</option>
                <option<?php echo selected_value('employment_status', 'Employed'); ?>>Employed</option>
                <option<?php echo selected_value('employment_status', 'Self-employed'); ?>>Self-employed</option>
                <option<?php echo selected_value('employment_status', 'Student'); ?>>Student</option>
                <option<?php echo selected_value('employment_status', 'Unemployed'); ?>>Unemployed</option>
              </select>
            </div>
            <div>
              <label for="study_schedule">Preferred study schedule</label>
              <select id="study_schedule" name="study_schedule" required>
                <option value="">Select</option>
                <option<?php echo selected_value('study_schedule', 'Evenings'); ?>>Evenings</option>
                <option<?php echo selected_value('study_schedule', 'Saturdays'); ?>>Saturdays</option>
                <option<?php echo selected_value('study_schedule', 'Evenings and Saturdays'); ?>>Evenings and Saturdays</option>
              </select>
            </div>
            <div>
              <label for="contact_method">Preferred contact method</label>
              <select id="contact_method" name="contact_method" required>
                <option value="">Select</option>
                <option<?php echo selected_value('contact_method', 'Email'); ?>>Email</option>
                <option<?php echo selected_value('contact_method', 'Telephone'); ?>>Telephone</option>
                <option<?php echo selected_value('contact_method', 'WhatsApp'); ?>>WhatsApp</option>
              </select>
            </div>
            <div style="grid-column:1 / -1;">
              <label for="message">Message</label>
              <textarea id="message" name="message"><?php echo old_value('message'); ?></textarea>
            </div>
            <div style="grid-column:1 / -1;">
              <label class="checkbox-row" for="consent">
                <input id="consent" name="consent" type="checkbox" required<?php echo checked_value('consent'); ?>>
                <span>I consent to being contacted about DEVQII admissions.</span>
              </label>
            </div>
          </div>
          <p class="error" data-form-error></p>
          <div class="hero-actions" style="margin-top:1rem;">
            <button class="button button-primary" type="submit">Submit Application</button>
            <a class="button button-secondary" href="index.php">Back home</a>
          </div>
        </form>
      </div>
    </section>
  <script src="assets/js/validation.js"></script>
<?php include_once 'includes/footer.php'; ?>
