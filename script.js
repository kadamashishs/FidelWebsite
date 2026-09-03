/* Dynamic header offset + anchor navigation handling
   - computes header height on load/resize and sets CSS variable --header-offset
   - intercepts same-page/hash links and applies an offset scroll so headings are visible
   - on page load, if there's a location.hash, scrolls to the target with offset
   - retains simple active nav highlighting for multipage links
*/

// Enable runtime debug logging by setting `window.DEBUG_SCROLL = true` in devtools.
window.DEBUG_SCROLL = window.DEBUG_SCROLL || false;

const contactForm = document.getElementById('contactForm');
const contactMessage = document.getElementById('contactMessage');

if (contactForm) {
  contactForm.addEventListener('submit', (event) => {
    event.preventDefault();
    const formData = new FormData(contactForm);
    const selectedRecipients = Array.from(contactForm.querySelectorAll('input[name="recipient"]:checked'));
    if (!selectedRecipients.length) {
      if (contactMessage) contactMessage.textContent = 'Please select at least one company.';
      return;
    }

    const recipientEmail = selectedRecipients.map(recipient => recipient.dataset.email).join(',');
    const recipientNames = selectedRecipients.map(recipient => recipient.value).join(' and ');
    const subject = `Website enquiry for ${recipientNames}`;
    const body = [
      `Name: ${formData.get('name')}`,
      `Email: ${formData.get('email')}`,
      '',
      formData.get('message')
    ].join('\n');

    window.location.href = `mailto:${recipientEmail}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    if (contactMessage) contactMessage.textContent = `Opening your email app for ${recipientNames}.`;
  });
}

function updateHeaderOffset() {
  const header = document.querySelector('.site-header');
  if (!header) return;
  // Read layout synchronously (single read)
  const height = header.offsetHeight || 0;

  // Write styles inside requestAnimationFrame to batch writes and avoid layout thrash
  if (window._headerOffsetRaf) cancelAnimationFrame(window._headerOffsetRaf);
  window._headerOffsetRaf = requestAnimationFrame(() => {
    const prev = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--header-offset')) || 0;
    if (prev !== height) {
      document.documentElement.style.setProperty('--header-offset', `${height}px`);
      // Keep body padding in sync for fixed header (only write if changed)
      document.body.style.paddingTop = `${height}px`;
      if (window.DEBUG_SCROLL) console.log('[scroll-debug] updateHeaderOffset applied:', height);
    }
    window._headerOffsetRaf = null;
  });
}

function scrollToElementWithOffset(el, behavior = 'smooth') {
  if (!el) return;
  const headerOffset = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--header-offset')) || 0;
  const rect = el.getBoundingClientRect();
  const targetY = window.pageYOffset + rect.top - headerOffset - 8; // small gap
  if (window.DEBUG_SCROLL) {
    console.log('[scroll-debug] headerOffset:', headerOffset, 'el id:', el.id, 'rect.top:', rect.top, 'pageYOffset:', window.pageYOffset, 'targetY:', targetY);
  }
  window.scrollTo({ top: targetY, behavior });
}

function performScrollWithDelay(el, behavior = 'smooth', delay = 120) {
  if (!el) return;
  const doScroll = () => scrollToElementWithOffset(el, behavior);
  if (window.DEBUG_SCROLL) console.log('[scroll-debug] performScrollWithDelay delay=', delay, 'el id=', el.id);
  if (document.fonts && document.fonts.ready) {
    // Wait for fonts/layout to stabilize or timeout
    const race = Promise.race([
      document.fonts.ready,
      new Promise(resolve => setTimeout(resolve, delay))
    ]);
    race.then(() => {
      if (window.DEBUG_SCROLL) console.log('[scroll-debug] fonts.ready resolved, performing scroll');
      doScroll();
    });
  } else {
    setTimeout(doScroll, delay);
  }
}

function handleHashOnLoad() {
  if (location.hash) {
    const id = decodeURIComponent(location.hash.slice(1));
    const target = document.getElementById(id);
    if (target) {
      // wait briefly for fonts/layout then scroll to the explicit anchor or target
      performScrollWithDelay(target, 'auto', 140);
    }
  }
}

function fixHiddenHeadingsOnLoad() {
  // if any section heading is hidden under the header, nudge it into view
  const headerOffset = parseInt(getComputedStyle(document.documentElement).getPropertyValue('--header-offset')) || 0;
  const candidates = document.querySelectorAll('.section, .hero');
  for (const el of candidates) {
    const rect = el.getBoundingClientRect();
    if (rect.top < headerOffset && rect.bottom > headerOffset) {
      // this element is partially hidden under the header
      performScrollWithDelay(el, 'auto', 120);
      break;
    }
  }
}

function initIndustryScroller() {
  const carousel = document.querySelector('.industry-carousel');
  if (!carousel) return;

  const speedPxPerTick = 1;
  const tickMs = 28;
  let timerId = null;

  // wait for images inside the carousel to load (or timeout) before measuring widths
  const imgs = Array.from(carousel.querySelectorAll('img'));
  function waitForImages(timeoutMs = 800) {
    if (!imgs.length) return Promise.resolve();
    return new Promise((resolve) => {
      let settled = 0;
      const onDone = () => {
        settled++;
        if (settled >= imgs.length) resolve();
      };

      imgs.forEach(img => {
        if (img.complete) return onDone();
        img.addEventListener('load', onDone, { once: true });
        img.addEventListener('error', onDone, { once: true });
      });

      // safety timeout
      setTimeout(resolve, timeoutMs);
    });
  }

  waitForImages(1200).then(() => {
    requestAnimationFrame(() => {
      const originalItems = Array.from(carousel.children);
      const originalWidth = carousel.scrollWidth || carousel.clientWidth;

      // Clone originals until we have at least twice the original width or reach a safe limit
      let clones = 0;
      while (carousel.scrollWidth < originalWidth * 2 && clones < 6) {
        originalItems.forEach(n => carousel.appendChild(n.cloneNode(true)));
        clones++;
      }

      const cycleWidth = originalWidth;

      function stop() {
        if (timerId) clearInterval(timerId);
        timerId = null;
      }

      function start() {
        if (timerId || carousel.scrollWidth <= carousel.clientWidth) return;
        timerId = setInterval(() => {
          carousel.scrollLeft += speedPxPerTick;
          if (carousel.scrollLeft >= cycleWidth) {
            carousel.scrollLeft -= cycleWidth;
          }
        }, tickMs);
      }

      carousel.addEventListener('mouseenter', stop);
      carousel.addEventListener('focusin', stop);
      carousel.addEventListener('mouseleave', start);
      carousel.addEventListener('focusout', start);

      start();
    });
  });
}

function initDetailModal() {
  const modal = document.getElementById('detailModal');
  if (!modal) return;

  const title = document.getElementById('detailModalTitle');
  const sections = document.getElementById('detailModalSections');
  const image = document.getElementById('detailModalImage');
  const closeButton = modal.querySelector('.detail-modal-close');
  let lastTrigger = null;

  function close() {
    modal.hidden = true;
    document.body.classList.remove('modal-open');
    if (lastTrigger) lastTrigger.focus();
  }

  function open(trigger) {
    const heading = trigger.querySelector('h3');
    const template = trigger.querySelector('.detail-template');
    if (!heading || !template) return;

    lastTrigger = trigger;
    title.textContent = heading.textContent;
    sections.replaceChildren(template.content.cloneNode(true));
    image.src = trigger.dataset.detailImage || '';
    image.alt = heading.textContent;
    modal.hidden = false;
    document.body.classList.add('modal-open');
    closeButton.focus();
  }

  document.querySelectorAll('.detail-trigger').forEach(trigger => {
    trigger.addEventListener('click', () => open(trigger));
    trigger.addEventListener('keydown', event => {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        open(trigger);
      }
    });
  });

  closeButton.addEventListener('click', close);
  modal.addEventListener('click', event => {
    if (event.target === modal) close();
  });
  document.addEventListener('keydown', event => {
    if (!modal.hidden && event.key === 'Escape') close();
  });
}

function interceptAnchorClicks() {
  document.addEventListener('click', (e) => {
    const a = e.target.closest('a');
    if (!a) return;
    const href = a.getAttribute('href') || '';
    // parse the absolute URL to compare pathnames
    let url;
    try {
      url = new URL(href, location.href);
    } catch (err) {
      url = null;
    }

    // If the link targets the same document (either '#id' or 'page.html#id' with same pathname),
    // intercept and perform an offset scroll using our handler.
    if (url && url.hash) {
      // same-page navigation when pathname matches
      if (url.pathname === location.pathname) {
        const id = decodeURIComponent(url.hash.slice(1));
        const target = document.getElementById(id);
        if (target) {
          e.preventDefault();
          history.pushState(null, '', `#${id}`);
          performScrollWithDelay(target, 'smooth', 80);
        }
      }
      // otherwise allow browser to navigate to other page; that page's on-load handler will scroll.
      return;
    }
  });
}

function setActiveNavLinks() {
  const navLinks = document.querySelectorAll('.nav-links a');
  if (!navLinks.length) return;
  const current = window.location.pathname.split('/').pop() || 'index.html';
  navLinks.forEach(link => {
    const href = link.getAttribute('href') || '';
    const normalized = href.replace('./', '').split('#')[0];
    const isActive = normalized === current || (normalized === 'index.html' && current === '');
    link.classList.toggle('active', isActive);
  });
}

window.addEventListener('DOMContentLoaded', () => {
  updateHeaderOffset();
  // If there's a hash, scroll to it. Otherwise ensure top section is visible below header.
  handleHashOnLoad();
  if (!location.hash) {
    const firstSection = document.querySelector('.section, .hero');
    if (firstSection) {
      // ensure the first visible section isn't hidden under header
      performScrollWithDelay(firstSection, 'auto', 80);
    }
  }
  interceptAnchorClicks();
  setActiveNavLinks();
  initIndustryScroller();
  initDetailModal();
  // extra check to fix cases where browser scroll positions hide headings
  setTimeout(fixHiddenHeadingsOnLoad, 160);
});

window.addEventListener('resize', () => {
  // update header offset on resize
  updateHeaderOffset();
});

// initial call in case script loads after DOMContentLoaded
updateHeaderOffset();

// Observe header size changes so offset stays accurate (handles wrapping nav, active border, etc.)
(function initHeaderResizeObserver() {
  const header = document.querySelector('.site-header');
  if (!header) return;
  if ('ResizeObserver' in window) {
    const ro = new ResizeObserver(() => {
      updateHeaderOffset();
    });
    ro.observe(header);
  }
})();
