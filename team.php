<?php $current_page = 'team'; $page_title = 'Meet the Team | DEVQII'; $meta_description = 'Meet the DEVQII leadership and academic team shaping practical software engineering education in Cameroon.'; $canonical_path = 'team.php'; ?>
<?php include_once 'includes/header.php'; ?>
<section class="section">
  <div class="container">
    <p class="badge">Meet the Team</p>
    <h1 class="section-title">The people building DEVQII</h1>
    <p class="section-intro">DEVQII is led by a committed team focused on practical education, flexible access and graduate outcomes that prepare learners for modern software engineering careers.</p>
    <div class="team-grid">
      <article class="team-card">
        <div class="team-photo">
          <img class="team-photo-playne" src="assets/images/playne-fuondjing-ngequi.jpeg" alt="Mrs. Playne Fuondjing Ngequi, DEVQII cofounder" loading="lazy">
        </div>
        <div class="team-body">
          <p class="team-role">President/Cofounder</p>
          <h2>Mrs. Playne Fuondjing Ngequi</h2>
          <p>Mrs. Playne Fuondjing Ngequi is the President/Cofounder of DEVQII and the founder of Queensway International. A retired midwife, she studied and worked in the United Kingdom before returning to Cameroon, where she continued her professional service in healthcare before building a long-standing commitment to education.</p>
          <details class="team-more">
            <summary><span class="summary-open">Read more</span><span class="summary-close">Show less</span></summary>
            <p>Through Queensway International, she has helped develop nursery, primary, secondary and higher education pathways. At DEVQII, she brings decades of care, leadership and educational stewardship to a partnership that combines strong academic foundations with the technical expertise of Developer Village.</p>
          </details>
        </div>
      </article>
      <article class="team-card">
        <div class="team-photo">
          <img class="team-photo-okoye" src="assets/images/okoye-bilikha.png" alt="Okoye N. Bilikha, DEVQII cofounder" loading="lazy">
        </div>
        <div class="team-body">
          <p class="team-role">Cofounder</p>
          <h2>Okoye N. Bilikha</h2>
          <p>Okoye N. Bilikha is a cofounder of DEVQII and the founder of Developer Village. With a background in software engineering, government digital services, cloud platforms and enterprise systems, he brings practical technical leadership to the institute's curriculum, delivery model and innovation strategy.</p>
          <details class="team-more">
            <summary><span class="summary-open">Read more</span><span class="summary-close">Show less</span></summary>
            <p>His work focuses on helping learners move from theory into real engineering practice: building applications, using modern development tools, working in teams and creating portfolios that meet international professional standards. Together with Queensway International, Developer Village gives DEVQII a distinctive blend of educational experience, professionalism and technical know-how.</p>
          </details>
        </div>
      </article>
      <article class="team-card">
        <div class="team-photo">
          <img class="team-photo-modest" src="assets/images/modest-eyong.png" alt="Modest Eyong, DEVQII Head of Software Engineering" loading="lazy">
        </div>
        <div class="team-body">
          <p class="team-role">Head of Software Engineering</p>
          <h2>Modest Eyong</h2>
          <p>Modest Eyong is a results-driven Software Engineer and Cloud Architect with strong expertise in designing, building and deploying scalable, secure and highly available cloud-native systems.</p>
          <details class="team-more">
            <summary><span class="summary-open">Read more</span><span class="summary-close">Show less</span></summary>
            <p>He brings end-to-end experience across software development, cloud infrastructure, containerization, network engineering and application delivery. His work focuses on building reliable systems, improving deployment workflows and creating robust technical architectures that support performance, scalability and long-term maintainability.</p>
            <p>At DEVQII, Modest provides senior technical leadership in software engineering, helping shape practical delivery standards, cloud engineering capability and the development discipline required for modern software teams.</p>
          </details>
        </div>
      </article>
      <article class="team-card">
        <div class="team-photo">
          <img class="team-photo-lesly" src="assets/images/leslie.jpeg" alt="Muluh Ndah Awa Lesly, DEVQII Software Engineer" loading="lazy">
        </div>
        <div class="team-body">
          <p class="team-role">Software Engineer</p>
          <h2>Muluh Ndah Awa Lesly</h2>
          <p>Muluh Ndah Awa Lesly is a graduate and seasoned software engineer based in Yaounde, Cameroon, with a strong focus on modern web and cloud-based application development.</p>
          <details class="team-more">
            <summary><span class="summary-open">Read more</span><span class="summary-close">Show less</span></summary>
            <p>He has solid experience building scalable, maintainable and user-focused software solutions using TypeScript, Node.js, MongoDB, SQL and microfrontend architecture. His technical interests also include cloud technologies, API development, backend systems, frontend engineering and software architecture.</p>
            <p>Lesly approaches software development with maturity, ownership and a strong engineering mindset. At DEVQII, he is focused on strengthening his technical expertise, collaborating with other technology professionals and contributing to practical digital solutions that create measurable value.</p>
          </details>
        </div>
      </article>
      <article class="team-card">
        <div class="team-photo">
          <?php if (is_file(__DIR__ . '/assets/images/amungwat-marion-jones.jpeg')): ?>
          <img class="team-photo-marion" src="assets/images/amungwat-marion-jones.jpeg" alt="Amungwat Marion Jones, DEVQII team member and cybersecurity graduate" loading="lazy">
          <?php else: ?>
          <span class="team-initials" aria-hidden="true">AMJ</span>
          <?php endif; ?>
        </div>
        <div class="team-body">
          <p class="team-role">Cybersecurity Graduate</p>
          <h2>Amungwat Marion Jones</h2>
          <p>Amungwat Marion Jones is a Cybersecurity graduate from ICT University with a strong interest in technology and a commitment to continuous learning. She brings a collaborative approach and enthusiasm for applying her academic knowledge as part of the DEVQII team.</p>
          <details class="team-more">
            <summary><span class="summary-open">Read more</span><span class="summary-close">Show less</span></summary>
            <p>Marion values the exchange of ideas and the opportunity to learn alongside fellow technology professionals. At DEVQII, she looks forward to contributing her skills, developing her practical experience and supporting the institute's commitment to technology education and teamwork.</p>
          </details>
        </div>
      </article>
      <article class="team-card team-card-upcoming">
        <div class="team-placeholder" aria-hidden="true">+</div>
        <div class="team-body">
          <p class="team-role">More members coming soon</p>
          <h2>Academic and industry team</h2>
          <p>Additional lecturers, mentors and support staff will be added as DEVQII grows its academic delivery, innovation hub and graduate employment services.</p>
        </div>
      </article>
    </div>
  </div>
</section>
<?php include_once 'includes/footer.php'; ?>
