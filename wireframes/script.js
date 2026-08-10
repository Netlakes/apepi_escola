

document.addEventListener('DOMContentLoaded', () => {
  
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
        if (theme === 'light') {
          icon.className = 'fa-solid fa-moon';
          themeToggleBtn.setAttribute('title', 'Mudar para Modo Escuro');
          themeToggleBtn.setAttribute('aria-label', 'Mudar para Modo Escuro');
        } else {
          icon.className = 'fa-solid fa-sun';
          themeToggleBtn.setAttribute('title', 'Mudar para Modo Claro');
          themeToggleBtn.setAttribute('aria-label', 'Mudar para Modo Claro');
        }
      }
    }
  }

  const mobileBtn = document.getElementById('mobileMenuBtn');
  const navLinks = document.getElementById('navLinks');

  if (mobileBtn && navLinks) {
    mobileBtn.addEventListener('click', () => {
      navLinks.classList.toggle('show');
      const icon = mobileBtn.querySelector('i');
      if (icon) {
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-xmark');
      }
    });
  }

  const filterBtns = document.querySelectorAll('.filter-btn');
  const courseCards = document.querySelectorAll('.course-card');

  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      filterBtns.forEach(b => {
        b.classList.remove('active');
        b.classList.remove('btn-primary');
        if (b.classList.contains('pill-btn')) {
          b.classList.remove('active');
        } else {
          b.classList.add('btn-outline');
        }
      });

      btn.classList.add('active');
      if (!btn.classList.contains('pill-btn')) {
        btn.classList.add('btn-primary');
        btn.classList.remove('btn-outline');
      }

      const filter = btn.getAttribute('data-filter');

      courseCards.forEach(card => {
        if (filter === 'all' || card.getAttribute('data-category') === filter) {
          card.style.display = 'flex';
          card.style.opacity = '0';
          card.style.transform = 'translateY(10px)';
          setTimeout(() => {
            card.style.transition = 'all 0.3s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
          }, 50);
        } else {
          card.style.display = 'none';
        }
      });
    });
  });

  const sliderTrack = document.querySelector('.hero-slides-track');
  const slides = document.querySelectorAll('.hero-slide');
  const prevBtn = document.querySelector('.slider-prev-btn');
  const nextBtn = document.querySelector('.slider-next-btn');
  const dots = document.querySelectorAll('.slider-dot');
  const counter = document.querySelector('.slider-counter');
  const progressBar = document.querySelector('.slider-progress-bar');
  const heroSliderContainer = document.querySelector('.hero-slider-container');

  if (slides.length > 0 && sliderTrack) {
    let currentSlide = 0;
    const totalSlides = slides.length;
    const slideDuration = 6000; 
    let slideTimer = null;
    let progressInterval = null;
    let startTime = 0;

    function goToSlide(index) {
      currentSlide = (index + totalSlides) % totalSlides;
      sliderTrack.style.transform = `translateX(-${currentSlide * 100}%)`;

      slides.forEach((slide, i) => {
        slide.classList.toggle('active', i === currentSlide);
      });

      dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === currentSlide);
      });

      if (counter) {
        counter.textContent = `0${currentSlide + 1} / 0${totalSlides}`;
      }

      resetTimer();
    }

    function resetTimer() {
      clearInterval(slideTimer);
      clearInterval(progressInterval);
      if (progressBar) progressBar.style.width = '0%';
      
      startTime = Date.now();
      
      progressInterval = setInterval(() => {
        const elapsed = Date.now() - startTime;
        const pct = Math.min(100, (elapsed / slideDuration) * 100);
        if (progressBar) progressBar.style.width = `${pct}%`;
      }, 50);

      slideTimer = setInterval(() => {
        goToSlide(currentSlide + 1);
      }, slideDuration);
    }

    function pauseTimer() {
      clearInterval(slideTimer);
      clearInterval(progressInterval);
    }

    if (prevBtn) prevBtn.addEventListener('click', () => goToSlide(currentSlide - 1));
    if (nextBtn) nextBtn.addEventListener('click', () => goToSlide(currentSlide + 1));

    dots.forEach((dot, i) => {
      dot.addEventListener('click', () => goToSlide(i));
    });

    if (heroSliderContainer) {
      heroSliderContainer.addEventListener('mouseenter', pauseTimer);
      heroSliderContainer.addEventListener('mouseleave', resetTimer);

      let touchStartX = 0;
      let touchEndX = 0;

      heroSliderContainer.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        pauseTimer();
      }, { passive: true });

      heroSliderContainer.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        if (touchStartX - touchEndX > 50) {
          goToSlide(currentSlide + 1);
        } else if (touchEndX - touchStartX > 50) {
          goToSlide(currentSlide - 1);
        } else {
          resetTimer();
        }
      }, { passive: true });
    }

    goToSlide(0);
  }

  const videoModal = document.getElementById('videoModal');
  const modalCloseBtn = document.getElementById('modalCloseBtn');
  const trailerTriggers = document.querySelectorAll('.hero-trailer-trigger, .thumb-play-trigger, #heroTrailerBtn, #thumbPlayBtn');

  function openModal() {
    if (videoModal) {
      videoModal.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeModal() {
    if (videoModal) {
      videoModal.classList.remove('active');
      document.body.style.overflow = '';
    }
  }

  trailerTriggers.forEach(btn => {
    btn.addEventListener('click', openModal);
  });

  if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeModal);

  if (videoModal) {
    videoModal.addEventListener('click', (e) => {
      if (e.target === videoModal) {
        closeModal();
      }
    });
  }

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
        }
      }
    });
  });
});
