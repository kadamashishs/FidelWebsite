# Fidel Projects WordPress Project

This folder contains a classic WordPress theme converted from the static Fidel Projects website. The source static website remains in the repository root and is not modified by this theme project.

## Project layout

- `fidel-projects-theme/` — installable WordPress theme source.
- `fidel-projects-theme/assets/css/site.css` — theme presentation, based on the static site's brand system.
- `fidel-projects-theme/assets/js/site.js` — responsive navigation, reveals, project carousel, and shared interactions.
- `fidel-projects-theme/assets/images/` — copied image, logo, and icon assets.

## Install on WordPress

1. Confirm the hosting account has a working WordPress installation and PHP 7.4+ (PHP 8.x recommended).
2. Zip the `fidel-projects-theme` folder so the ZIP contains that folder at its root.
3. In WordPress Admin, open **Appearance → Themes → Add New → Upload Theme**, upload the ZIP, and activate it.
4. Open **Appearance → Customize → Site Identity** and upload the Fidel SVG as the site logo. If SVG uploads are blocked by the host, use the provided PNG logo or have the administrator enable a trusted SVG upload method.
5. In **Appearance → Menus**, create a menu with Home, About, Services, Projects, and Contact, then assign it to **Primary Navigation**. Assign a footer menu if required.
6. Create pages for Home, About, Services, Projects, and Contact. Add the actual page copy in the block editor. For the homepage, use the title as the hero heading and the excerpt as the hero supporting text; add other editable sections in the page content area.
7. Set **Settings → Reading → Your homepage displays → A static page**, then select Home.
8. On the Contact page, choose the **Contact Page** template in page settings. Configure the enquiry email, phone, and LinkedIn URL under **Appearance → Customize → Fidel Contact Details**.
9. Add project entries under **Projects → Add New** and capability entries under **Services → Add New**. Use excerpts and featured images; the homepage shows recent published entries. Replace demonstration fallback examples with approved project content before launch.
10. Open **Settings → Permalinks** and save once to refresh the custom Project and Service routes.
11. Test all pages, mobile navigation, project carousel, email delivery, SSL, and canonical domain on staging before directing live traffic.

## Editable content

- Pages and homepage body sections: WordPress block editor.
- Hero title: Home page title.
- Hero supporting copy: Home page excerpt.
- Hero image: **Appearance → Customize → Header Image**.
- Logo: **Appearance → Customize → Site Identity**.
- Projects and Services: dedicated dashboard content types with title, excerpt, body, and featured image.
- Contact details: theme Customizer settings.

## Contact form delivery

The Contact Page template posts to WordPress `admin-post.php`, verifies a nonce, sanitizes values, and sends mail through `wp_mail()`. The hosting provider must configure outbound mail or an SMTP plugin/service. Test message delivery in staging; successful form submission does not by itself guarantee the host can deliver email.

## Notes and limitations

- The source project was static; this theme adds the WordPress structure and editable content types, but the organisation still needs to create pages/menus and enter final approved copy in WordPress.
- WordPress is not bundled here. Install this theme into the target WordPress instance; do not upload the theme folder as a replacement for the WordPress installation.
- PHP is not installed in the conversion workspace, so PHP lint could not be run locally. Validate the theme on a staging WordPress site before production deployment.
- Confirm the host supports the minimum WordPress/PHP versions and permits the chosen SVG logo upload method.
