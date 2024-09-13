function animateValue(id, start, end, duration) {
    let obj = document.getElementById(id);
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        obj.innerText = Math.floor(progress * (end - start) + start);
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateValue("students-count", 0, 372, 1000);  
            animateValue("success-rate", 0, 12, 1000);     
            observer.unobserve(entry.target);  
        }
    });
}, { threshold: 0.5 });

// Cible les éléments à observer
observer.observe(document.getElementById('students-count'));
observer.observe(document.getElementById('success-rate'));