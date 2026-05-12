import './bootstrap';

import Alpine from 'alpinejs';
import Lenis from 'lenis';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

window.Alpine = Alpine;

// Initialize GSAP ScrollTrigger
gsap.registerPlugin(ScrollTrigger);
window.gsap = gsap;

// Initialize Lenis Smooth Scroll
const lenis = new Lenis({
    duration: 1.2,
    easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
    smoothWheel: true,
});

function raf(time) {
    lenis.raf(time);
    requestAnimationFrame(raf);
}

requestAnimationFrame(raf);
window.lenis = lenis;

Alpine.start();
