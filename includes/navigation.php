<?php
$current_page = isset($current_page) ? $current_page : 'index';
$nav_items = [
    ['slug' => 'index', 'label' => 'Home', 'url' => 'index.php'],
    ['slug' => 'about', 'label' => 'About', 'url' => 'about.php'],
    ['slug' => 'programme', 'label' => 'Programme', 'url' => 'programme.php'],
    ['slug' => 'admissions', 'label' => 'Admissions', 'url' => 'admissions.php'],
    ['slug' => 'student-experience', 'label' => 'Experience', 'url' => 'student-experience.php'],
    ['slug' => 'team', 'label' => 'Team', 'url' => 'team.php'],
    ['slug' => 'careers', 'label' => 'Careers', 'url' => 'careers.php'],
    ['slug' => 'contact', 'label' => 'Contact', 'url' => 'contact.php']
];
?>
<nav class="site-nav" aria-label="Primary">
  <a class="brand" href="index.php" aria-label="DEVQII home">
    <img class="brand-logo" src="assets/images/logo.svg" alt="DEVQII" width="104" height="64">
  </a>
  <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-menu">
    <span></span><span></span><span></span>
    <span class="sr-only">Toggle menu</span>
  </button>
  <div class="nav-links" id="primary-menu">
    <ul>
      <?php foreach ($nav_items as $item): ?>
        <li>
          <a class="nav-link <?php echo $current_page === $item['slug'] ? 'active' : ''; ?>" href="<?php echo $item['url']; ?>">
            <?php echo htmlspecialchars($item['label']); ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
    <a class="button button-small button-primary nav-apply" href="admissions.php">Apply</a>
  </div>
</nav>
