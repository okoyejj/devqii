# DEVQII Website

## Project overview
This project builds a complete, production-ready website for DEVQII (Developer Village & Queensway International Institute) using plain HTML, CSS, JavaScript and PHP. The site is designed to be uploaded directly into GoDaddy shared hosting public_html and to work without a build step or persistent server.

## Folder structure
- index.php — Home page
- about.php — About DEVQII
- programme.php — HND Software Engineering
- admissions.php — Admissions overview
- apply.php — Admissions form page
- process-application.php — Server-side form handling
- thank-you.html — Success confirmation page
- contact.php — Contact and FAQ page
- student-experience.php — Flexible learning experience
- careers.php — Careers overview
- privacy.php — Privacy policy
- terms.php — Terms and conditions
- 404.html — Custom error page
- .htaccess — HTTPS, security and rewrite rules
- robots.txt — Search bot instructions
- sitemap.xml — Sitemap
- config.example.php — Example mail configuration
- includes/ — Shared header, footer and navigation
- assets/css/ — Stylesheets
- assets/js/ — JavaScript
- assets/images/ — Images and image source notes

## Local testing
1. Install a local PHP environment such as XAMPP, MAMP or Laragon.
2. Place the project folder in the web root (for example htdocs/DEVQII).
3. Start Apache and PHP.
4. Open http://localhost/DEVQII/ in your browser.

## PHP configuration
The site uses PHP only for the admissions form. The form is designed to work with standard PHP hosting. On GoDaddy shared hosting, PHP is usually available by default.

## PHPMailer configuration
PHPMailer is optional. If you want to use it:
1. Install PHPMailer in the project or on the server.
2. Rename config.example.php to config.php and place it outside public_html if possible.
3. Set MAILER_ENABLED to true and provide SMTP values.

## GoDaddy SMTP configuration
For GoDaddy shared hosting, use the SMTP details supplied by your hosting account or a third-party SMTP provider such as Google Workspace or SendGrid.
Recommended settings:
- SMTP host: your provider host
- Port: 587
- Encryption: tls
- Username: your SMTP account
- Password: your SMTP password

If the form cannot send mail on the hosting account, the fallback uses PHP mail().

## Changing contact information
Edit the relevant content in:
- index.php
- about.php
- contact.php
- process-application.php
- includes/footer.php

## Replacing images
The site currently uses remote images from Unsplash for development. Before production deployment:
1. Download the images you want to use.
2. Save them in assets/images/.
3. Replace the src values in the HTML/PHP pages with the local file paths.
4. Keep the original source notes in assets/images/image-sources.txt.

## Uploading to GoDaddy public_html
1. Compress the project files into a zip archive.
2. Log in to GoDaddy and open the hosting dashboard.
3. Open File Manager and navigate to public_html.
4. Upload the files and extract them.
5. Ensure the root contains index.php and the other site files.
6. Make sure .htaccess is uploaded as-is.

## Connecting the domain devqii.co.uk
1. Point the domain to the GoDaddy hosting account.
2. Verify the domain is using the correct nameservers.
3. Ensure the SSL certificate is installed.
4. Confirm the site is reachable at https://devqii.co.uk/.

## Enabling SSL in GoDaddy
1. Open the GoDaddy Domains or Hosting dashboard.
2. Find SSL Certificates.
3. Enable auto-renew or install the certificate for the domain.
4. Confirm that HTTPS redirects work as configured in .htaccess.

## Verifying the contact form
1. Test the form locally first.
2. Submit a test application.
3. Confirm the message arrives in the configured inbox.
4. If mail fails, verify PHP mail settings and SMTP credentials.

## Testing mobile responsiveness
Use browser developer tools and test the following breakpoints:
- 320px mobile
- 768px tablet
- 1024px desktop

## Updating sitemap.xml
When new pages are added or URLs change, update sitemap.xml with the new canonical links.

## Recommended file permissions
- Files: 644
- Folders: 755
- PHP files: 644
- .htaccess: 644

## Backup instructions
1. Download the complete public_html folder regularly.
2. Keep a copy of config.php outside the web root.
3. Backup the website database if one is added later.

## Launch checklist
- [ ] Site loads on HTTPS
- [ ] Navigation works on mobile and desktop
- [ ] Form validation works
- [ ] Contact form sends mail or shows a clear error
- [ ] Sitemap and robots.txt are present
- [ ] SSL is active
- [ ] Images are replaced with local assets if required
