document.addEventListener("DOMContentLoaded", () => {
  const toggleThemeBtn = document.getElementById('toggleThemeBtn');
  const themeIcon = document.getElementById('themeIcon');

  let temaAtual = localStorage.getItem('tema') || 'escuro';

  function aplicarTema(tema) {
    const htmlEl = document.documentElement;

    if (tema === 'claro') {
      htmlEl.setAttribute('data-bs-theme', 'light');
      if (themeIcon) themeIcon.textContent = 'Claro';
    } else {
      htmlEl.setAttribute('data-bs-theme', 'dark');
      if (themeIcon) themeIcon.textContent = 'Escuro';
    }

    localStorage.setItem('tema', tema);
  }

  aplicarTema(temaAtual);

  if (toggleThemeBtn) {
    toggleThemeBtn.addEventListener('click', () => {
      temaAtual = temaAtual === 'escuro' ? 'claro' : 'escuro';
      aplicarTema(temaAtual);
    });
  }
});
