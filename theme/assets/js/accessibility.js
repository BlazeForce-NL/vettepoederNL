(() => {
  'use strict';
  const root = document.documentElement;
  const textButton = document.querySelector('[data-site-text-size]');
  const contrastButton = document.querySelector('[data-site-contrast]');
  const readButton = document.querySelector('[data-site-read]');
  const readLabel = document.querySelector('[data-site-read-label]');
  const stopButton = document.querySelector('[data-site-stop]');
  const status = document.querySelector('[data-site-a11y-status]');
  const language = document.documentElement.lang || 'nl-NL';
  const english = language.toLowerCase().startsWith('en');
  const t = (nl, en) => english ? en : nl;
  let reading = false;
  let paused = false;
  let queue = [];
  let queueIndex = 0;
  const store = (key, value) => { try { localStorage.setItem(key, String(value)); } catch (e) {} };
  const announce = message => { if (status) status.textContent = message; };
  if (localStorage.getItem('site-text-large') === 'true') root.classList.add('site-text-large');
  if (localStorage.getItem('site-high-contrast') === 'true') root.classList.add('site-high-contrast');
  const sync = () => {
    textButton?.setAttribute('aria-pressed', String(root.classList.contains('site-text-large')));
    contrastButton?.setAttribute('aria-pressed', String(root.classList.contains('site-high-contrast')));
  };
  textButton?.addEventListener('click', () => {
    const active = root.classList.toggle('site-text-large');
    store('site-text-large', active);
    sync();
    announce(active ? t('Grotere tekst ingeschakeld.', 'Larger text enabled.') : t('Normale tekstgrootte ingeschakeld.', 'Normal text size enabled.'));
  });
  contrastButton?.addEventListener('click', () => {
    const active = root.classList.toggle('site-high-contrast');
    store('site-high-contrast', active);
    sync();
    announce(active ? t('Hoog contrast ingeschakeld.', 'High contrast enabled.') : t('Standaardcontrast ingeschakeld.', 'Default contrast enabled.'));
  });
  const chunksFromPage = () => {
    const main = document.querySelector('main');
    if (!main) return [];
    const text = [...main.querySelectorAll('h1,h2,h3,p,li')]
      .filter(el => !el.closest('nav,form,.actions'))
      .map(el => el.innerText.trim())
      .filter(Boolean)
      .join('. ')
      .replace(/\s+/g, ' ');
    const sentences = text.match(/[^.!?]+[.!?]+|[^.!?]+$/g) || [];
    const chunks = [];
    let chunk = '';
    for (const sentence of sentences) {
      if ((chunk + sentence).length > 220 && chunk) { chunks.push(chunk.trim()); chunk = sentence; }
      else { chunk += ' ' + sentence; }
    }
    if (chunk.trim()) chunks.push(chunk.trim());
    return chunks;
  };
  const updateSpeechControls = () => {
    if (!readButton || !readLabel || !stopButton) return;
    readButton.setAttribute('aria-pressed', String(reading && !paused));
    readLabel.textContent = reading ? (paused ? t('Ga verder met voorlezen', 'Continue reading') : t('Pauzeer voorlezen', 'Pause reading')) : t('Lees pagina voor', 'Read page aloud');
    stopButton.hidden = !reading;
  };
  const speakNext = () => {
    if (!reading || queueIndex >= queue.length) {
      reading = false; paused = false; updateSpeechControls(); announce(t('Voorlezen voltooid.', 'Reading completed.')); return;
    }
    const utterance = new SpeechSynthesisUtterance(queue[queueIndex]);
    utterance.lang = language;
    utterance.rate = .95;
    utterance.onend = () => { queueIndex += 1; speakNext(); };
    utterance.onerror = () => { reading = false; paused = false; updateSpeechControls(); announce(t('Voorlezen is gestopt door de browser.', 'Reading was stopped by the browser.')); };
    window.speechSynthesis.speak(utterance);
  };
  const stopSpeech = () => {
    window.speechSynthesis?.cancel(); reading = false; paused = false; queue = []; queueIndex = 0; updateSpeechControls(); announce(t('Voorlezen gestopt.', 'Reading stopped.'));
  };
  if (!('speechSynthesis' in window) || !('SpeechSynthesisUtterance' in window)) {
    if (readButton) readButton.disabled = true;
  } else {
    readButton?.addEventListener('click', () => {
      if (reading && !paused) { window.speechSynthesis.pause(); paused = true; updateSpeechControls(); announce(t('Voorlezen gepauzeerd.', 'Reading paused.')); return; }
      if (reading && paused) { window.speechSynthesis.resume(); paused = false; updateSpeechControls(); announce(t('Voorlezen hervat.', 'Reading resumed.')); return; }
      queue = chunksFromPage(); queueIndex = 0;
      if (!queue.length) { announce(t('Er is geen leesbare hoofdinhoud gevonden.', 'No readable main content was found.')); return; }
      window.speechSynthesis.cancel(); reading = true; paused = false; updateSpeechControls(); announce(t('Voorlezen gestart.', 'Reading started.')); speakNext();
    });
    stopButton?.addEventListener('click', stopSpeech);
    window.addEventListener('pagehide', () => window.speechSynthesis.cancel());
  }
  sync(); updateSpeechControls();
})();
