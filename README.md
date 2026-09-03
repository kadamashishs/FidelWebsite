# FidelWebsite

Static HTML, CSS, and JavaScript website for Fidel Projects. There is no build command and no server-side runtime.

## Test locally

Open `index.html` in a browser, or serve the folder locally if you want to test navigation through a local web server.

## Deploy with Netlify

Netlify is the simplest first-time option for this static site.

1. Create an account at `https://www.netlify.com/`.
2. Choose **Add new site** and **Deploy manually**.
3. Drag the entire `firstproject` folder into the upload area.
4. Confirm the deployed site works using the temporary Netlify URL.
5. Open **Domain management**, choose **Add a domain**, and enter `fidel-projects.com`.
6. Add the DNS records Netlify displays at the company where you purchased the domain.
7. Add both the root domain and `www` version if Netlify offers that option.
8. Set the preferred domain and wait for DNS propagation. Netlify will provision HTTPS automatically.

Keep `index.html` in the top level of the deployed folder. Do not upload only the `assets` folder.

## DNS guidance

Use the exact DNS values shown by Netlify because they can vary by account. Remove conflicting old website records before adding the new ones. DNS changes can take from a few minutes to 48 hours to become visible worldwide.

## Before launch

- Test every navigation link and the Contact email workflow.
- Confirm the logo and all images load on the deployed HTTPS URL.
- Replace placeholder client/team images before publishing if required.
- Submit `https://fidel-projects.com/sitemap.xml` to Google Search Console after the domain is live.
