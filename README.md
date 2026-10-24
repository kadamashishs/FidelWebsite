# Fidel Projects Website

This repository is a static website built with HTML, CSS, and browser JavaScript. It has no build step, server-side runtime, or WordPress theme integration.

## WordPress compatibility

The site can be served by a web host that also offers WordPress hosting, but it is not installable or editable as a WordPress theme. Uploading these files does not add them to the WordPress admin editor. To manage the pages through WordPress, the site must first be converted into a WordPress theme or rebuilt as WordPress pages.

If WordPress is already installed on the target domain, confirm how the host chooses its document root and default index file before deploying. Do not overwrite an existing WordPress site unless replacing it is intentional and backed up.

## Deploy as a static site

Upload only the website files to the intended public document root or static hosting project:

- `index.html`, `about.html`, `services.html`, `projects.html`, `contact.html`, and `404.html`
- `style.css` and `script.js`
- `assets/`
- `robots.txt` and `sitemap.xml`

Do not upload `.git/`, `.github/`, SSH key files, backups, or local workspace files. In particular, keep `gitssh`, `SSHKey`, and all private credentials outside the public web root. The top-level `index.html` must remain at the root of the deployed site.

For Netlify, use **Add new site → Deploy manually** and deploy a clean folder containing only the website files listed above. For cPanel or similar hosting, upload those same files into the domain's configured document root. Hosting controls vary; follow the provider's instructions for SSL, domain routing, and custom 404 pages.

## Contact form behavior

The current contact form uses a `mailto:` link to prepare an email in the visitor's email application. It does not submit to a server or store enquiries. For dependable web enquiries, connect it to a form provider or a backend endpoint before launch.

## Before launch

- Confirm whether the target is static hosting or a WordPress-managed site.
- Verify the domain document root and preferred canonical domain.
- Test page navigation, assets, mobile layout, and the contact workflow on the deployed HTTPS URL.
- Replace placeholder team and client content with organisation-approved material.
- Confirm canonical URLs and `sitemap.xml` match the live domain.
- Configure a real form endpoint if enquiries must be received without a local email application.
- Submit the live sitemap to Google Search Console after launch.
