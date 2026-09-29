document.addEventListener('DOMContentLoaded', () => {
  
  // Theme Toggle Logic (Dark Mode "Terra, Madeira e Folhas" as Default)
  const themeToggleBtn = document.getElementById('themeToggleBtn');
  const storedTheme = localStorage.getItem('apepi_theme') || 'dark';

  applyTheme(storedTheme);

  if (themeToggleBtn) {
    themeToggleBtn.addEventListener('click', () => {
      const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
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

  // Mobile Navigation & Dropdown Accordion Support
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

    // Handle Dropdown Clicks on Mobile
    const dropdownParents = navLinks.querySelectorAll('.menu-item-has-children, .has-dropdown');
    dropdownParents.forEach(parentItem => {
      const parentLink = parentItem.querySelector(':scope > a');
      if (parentLink) {
        parentLink.addEventListener('click', (e) => {
          // If on mobile/tablet view
          if (window.innerWidth <= 1024) {
            e.preventDefault();
            e.stopPropagation();
            
            // Toggle current dropdown
            const isOpen = parentItem.classList.contains('dropdown-open');
            
            // Close other sibling dropdowns
            dropdownParents.forEach(other => {
              if (other !== parentItem) {
                other.classList.remove('dropdown-open');
              }
            });

            if (!isOpen) {
              parentItem.classList.add('dropdown-open');
            } else {
              parentItem.classList.remove('dropdown-open');
            }
          }
        });
      }
    });

    // Close mobile nav when clicking a leaf link (link without dropdown)
    navLinks.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', (e) => {
        const parentLi = link.parentElement;
        const hasChildren = parentLi.classList.contains('menu-item-has-children') || parentLi.classList.contains('has-dropdown');
        
        // If clicking a sub-link or regular item without dropdown, close mobile menu
        if (!hasChildren || window.innerWidth > 1024) {
          navLinks.classList.remove('show');
          const icon = mobileBtn.querySelector('i');
          if (icon) {
            icon.className = 'fa-solid fa-bars';
          }
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
      const siblingItems = parent.parentElement.querySelectorAll('.accordion-item');
      siblingItems.forEach(item => {
        item.classList.remove('active');
        const p = item.querySelector('.accordion-panel');
        if (p) p.style.maxHeight = null;
      });

      // Toggle clicked one
      if (!isAlreadyActive) {
        parent.classList.add('active');
        panel.style.maxHeight = panel.scrollHeight + 'px';
      }
    });
  });

  // Home Formations Carousel Logic
  const formationsGrid = document.getElementById('formationsGrid');
  const prevForm = document.getElementById('prevForm');
  const nextForm = document.getElementById('nextForm');

  if (formationsGrid && prevForm && nextForm) {
    const scrollAmount = 340; // width of card + gap

    prevForm.addEventListener('click', () => {
      formationsGrid.scrollBy({
        left: -scrollAmount,
        behavior: 'smooth'
      });
    });

    nextForm.addEventListener('click', () => {
      formationsGrid.scrollBy({
        left: scrollAmount,
        behavior: 'smooth'
      });
    });
  }

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
