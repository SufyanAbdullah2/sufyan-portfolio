import '../css/portfolio.css';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const menuButton = document.querySelector('.menu-toggle');
const menu = document.querySelector('.site-menu');

menuButton?.addEventListener('click', () => {
    const isOpen = menuButton.getAttribute('aria-expanded') === 'true';
    menuButton.setAttribute('aria-expanded', String(!isOpen));
    menu?.classList.toggle('is-open', !isOpen);
    document.body.classList.toggle('menu-open', !isOpen);
});

menu?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => {
        menu.classList.remove('is-open');
        menuButton?.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('menu-open');
    });
});

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (!reduceMotion) {
    const progress = document.querySelector('.scroll-progress');
    const art = document.querySelector('.hero-art');
    const nav = document.querySelector('.nav-wrap');

    const updateScrollProgress = () => {
        const scrollableHeight = document.documentElement.scrollHeight - window.innerHeight;
        const progressRatio = scrollableHeight > 0 ? window.scrollY / scrollableHeight : 0;

        progress?.style.setProperty('transform', `scaleX(${progressRatio})`);
        nav?.classList.toggle('is-scrolled', window.scrollY > 24);
    };

    window.addEventListener('scroll', updateScrollProgress, { passive: true });
    updateScrollProgress();

    art?.addEventListener('pointermove', (event) => {
        if (event.pointerType === 'touch') {
            return;
        }

        const bounds = art.getBoundingClientRect();
        const x = (event.clientX - bounds.left) / bounds.width;
        const y = (event.clientY - bounds.top) / bounds.height;

        art.style.setProperty('--pointer-x', `${x * 100}%`);
        art.style.setProperty('--pointer-y', `${y * 100}%`);
        art.style.setProperty('--tilt-x', `${(0.5 - y) * 7}deg`);
        art.style.setProperty('--tilt-y', `${(x - 0.5) * 7}deg`);
    });

    art?.addEventListener('pointerleave', () => {
        art.style.setProperty('--tilt-x', '0deg');
        art.style.setProperty('--tilt-y', '0deg');
    });

    if (window.matchMedia('(pointer: fine)').matches) {
        document.querySelectorAll('.project-image').forEach((card) => {
            card.addEventListener('pointermove', (event) => {
                if (event.pointerType === 'touch') {
                    return;
                }

                const bounds = card.getBoundingClientRect();
                const x = (event.clientX - bounds.left) / bounds.width;
                const y = (event.clientY - bounds.top) / bounds.height;

                card.style.setProperty('--spotlight-x', `${x * 100}%`);
                card.style.setProperty('--spotlight-y', `${y * 100}%`);
                card.style.setProperty('--card-tilt-x', `${(0.5 - y) * 2.5}deg`);
                card.style.setProperty('--card-tilt-y', `${(x - 0.5) * 2.5}deg`);
            });

            card.addEventListener('pointerleave', () => {
                card.style.setProperty('--card-tilt-x', '0deg');
                card.style.setProperty('--card-tilt-y', '0deg');
            });
        });
    }

    const hero = document.querySelector('.hero');

    if (hero) {
        gsap.from('.hero-title .line > span', {
            yPercent: 115,
            duration: 1.15,
            stagger: 0.13,
            ease: 'power4.out',
            delay: 0.15,
        });

        gsap.from('.hero-meta, .hero-kicker, .hero-bottom > *', {
            opacity: 0,
            y: 18,
            duration: 0.8,
            stagger: 0.1,
            ease: 'power2.out',
            delay: 0.55,
        });
    }

    gsap.utils.toArray('.reveal').forEach((element) => {
        gsap.fromTo(element,
            { opacity: 0, y: 35 },
            {
                opacity: 1,
                y: 0,
                duration: 0.9,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: element,
                    start: 'top 88%',
                    once: true,
                },
            }
        );
    });

    if (hero) {
        gsap.to('.hero-art', {
            y: -22,
            scrollTrigger: {
                trigger: hero,
                start: 'top top',
                end: 'bottom top',
                scrub: 1.2,
            },
        });
    }
} else {
    document.querySelector('.scroll-progress')?.style.setProperty('transform', 'scaleX(0)');
}
