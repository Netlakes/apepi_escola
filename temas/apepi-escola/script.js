document.addEventListener('DOMContentLoaded', () => {
  
  // Theme Toggle Logic (Light Mode Warm Cream as Default)
  const themeToggleBtn = document.getElementById('themeToggleBtn');
  const storedTheme = localStorage.getItem('apepi_theme') || 'light';

  applyTheme(storedTheme);

  if (themeToggleBtn) {
    themeToggleBtn.addEventListener('click', () => {
      const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
      const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
      applyTheme(newTheme);
      localStorage.setItem('apepi_theme', newTheme);
    });
  }

  function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    if (themeToggleBtn) {
      const icon = themeToggleBtn.querySelector('i');
      if (icon) {
        if (theme === 'dark') {
          icon.className = 'fa-solid fa-sun';
          themeToggleBtn.setAttribute('title', 'Mudar para Modo Claro');
          themeToggleBtn.setAttribute('aria-label', 'Mudar para Modo Claro');
        } else {
          icon.className = 'fa-solid fa-moon';
          themeToggleBtn.setAttribute('title', 'Mudar para Modo Escuro');
          themeToggleBtn.setAttribute('aria-label', 'Mudar para Modo Escuro');
        }
      }
    }
  }

  // Mobile Menu Toggling
  const mobileBtn = document.getElementById('mobileMenuBtn');
  const navLinks = document.getElementById('navLinks');

  if (mobileBtn && navLinks) {
    mobileBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      navLinks.classList.toggle('show');
      const icon = mobileBtn.querySelector('i');
      if (icon) {
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-xmark');
      }
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
      if (navLinks.classList.contains('show') && !navLinks.contains(e.target) && !mobileBtn.contains(e.target)) {
        navLinks.classList.remove('show');
        const icon = mobileBtn.querySelector('i');
        if (icon) {
          icon.className = 'fa-solid fa-bars';
        }
      }
    });

    // Close menu when any nav link is clicked
    navLinks.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        navLinks.classList.remove('show');
        const icon = mobileBtn.querySelector('i');
        if (icon) {
          icon.className = 'fa-solid fa-bars';
        }
      });
    });
  }

  // Accordion Logic for Modules
  const accordionTriggers = document.querySelectorAll('.accordion-trigger');

  accordionTriggers.forEach(trigger => {
    trigger.addEventListener('click', () => {
      const parent = trigger.parentElement;
      const panel = parent.querySelector('.accordion-panel');
      const isAlreadyActive = parent.classList.contains('active');

      // Collapse all accordions in this container
      const siblingItems = parent.parentElement.querySelectorAll('.accordion-item, .p2-accordion-item');
      siblingItems.forEach(item => {
        item.classList.remove('active');
        const p = item.querySelector('.accordion-panel, .p2-accordion-content');
        if (p) p.style.maxHeight = null;
      });

      // Toggle clicked one
      if (!isAlreadyActive) {
        parent.classList.add('active');
        if (panel) {
          panel.style.maxHeight = panel.scrollHeight + 'px';
        }
      }
    });
  });

  // Universal Formations Carousel Logic
  document.querySelectorAll('.formations-section, .courses-slider-section, section').forEach(section => {
    const wrapper = section.querySelector('.formations-carousel-wrapper');
    if (!wrapper) return;

    const prevBtn = section.querySelector('#prevForm, .prevFormBtn, .arrow-btn[aria-label="Anterior"], .arrow-btn:first-child');
    const nextBtn = section.querySelector('#nextForm, .nextFormBtn, .arrow-btn[aria-label="Próximo"], .arrow-btn:last-child');

    if (prevBtn) {
      prevBtn.addEventListener('click', (e) => {
        e.preventDefault();
        const card = section.querySelector('.formation-card');
        const cardWidth = card ? card.offsetWidth : 310;
        const scrollAmount = cardWidth + 28; // card width + gap
        wrapper.scrollBy({
          left: -scrollAmount,
          behavior: 'smooth'
        });
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        const card = section.querySelector('.formation-card');
        const cardWidth = card ? card.offsetWidth : 310;
        const scrollAmount = cardWidth + 28; // card width + gap
        wrapper.scrollBy({
          left: scrollAmount,
          behavior: 'smooth'
        });
      });
    }
  });

  // Smooth Scrolling for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      const targetId = this.getAttribute('href');
      if (targetId && targetId !== '#') {
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
          e.preventDefault();
          targetElement.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
          // Close mobile menu if open
          if (navLinks && navLinks.classList.contains('show')) {
            navLinks.classList.remove('show');
            if (mobileBtn) {
              const icon = mobileBtn.querySelector('i');
              if (icon) {
                icon.className = 'fa-solid fa-bars';
              }
            }
          }
        }
      }
    });
  });

});
