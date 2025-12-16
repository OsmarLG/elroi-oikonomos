import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    const elements = document.querySelectorAll('.reveal');

    if (!elements.length) return;

    const observer = new IntersectionObserver(
        entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('reveal-active');
                } else {
                    entry.target.classList.remove('reveal-active');
                }
            });
        },
        {
            threshold: 0.15,
        }
    );

    elements.forEach(el => observer.observe(el));
});
