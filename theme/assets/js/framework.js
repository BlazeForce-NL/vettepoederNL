(() => {
  'use strict';
  const toggle = document.querySelector('[data-menu-toggle]');
  const nav = document.getElementById('site-navigation');
  const closeMenu = () => { if (!toggle || !nav) return; toggle.setAttribute('aria-expanded', 'false'); nav.classList.remove('is-open'); };
  toggle?.addEventListener('click', () => {
    const open = toggle.getAttribute('aria-expanded') !== 'true';
    toggle.setAttribute('aria-expanded', String(open));
    nav?.classList.toggle('is-open', open);
  });
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMenu(); });
  nav?.addEventListener('click', e => { if (e.target.closest('a')) closeMenu(); });

  let lightbox;
  const ensureLightbox = () => {
    if (lightbox) return lightbox;
    lightbox = document.createElement('div');
    lightbox.className = 'pf-lightbox';
    lightbox.hidden = true;
    lightbox.innerHTML = '<button type="button" aria-label="Sluiten">×</button><img alt="">';
    document.body.appendChild(lightbox);
    lightbox.addEventListener('click', e => { if (e.target === lightbox || e.target.closest('button')) lightbox.hidden = true; });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && lightbox) lightbox.hidden = true; });
    return lightbox;
  };
  document.addEventListener('click', e => {
    const link = e.target.closest('[data-pf-lightbox], .wp-block-gallery a[href$=".jpg"], .wp-block-gallery a[href$=".jpeg"], .wp-block-gallery a[href$=".png"], .wp-block-gallery a[href$=".webp"]');
    if (!link) return;
    e.preventDefault();
    const box = ensureLightbox();
    const img = box.querySelector('img');
    img.src = link.href;
    img.alt = link.querySelector('img')?.alt || '';
    box.hidden = false;
  });
})();
