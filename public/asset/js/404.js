document.addEventListener('DOMContentLoaded', function() {
    const yarnTrail = document.querySelector('.yarn-trail');
    yarnTrail.style.width = `${Math.random() * 300 + 100}px`;

    // Button click navigation
    document.querySelector('.home-button').addEventListener('click', function() {
        window.location.href = '/';
    });

    // Animate cat movement across screen
    const catWrapper = document.querySelector('.cat-wrapper');
    let direction = 1;
    let position = 0;
    function moveCat() {
        position += direction * 2;
        if (position > 50 || position < -50) direction *= -1;
        catWrapper.style.left = `calc(50% + ${position}px)`;
        requestAnimationFrame(moveCat);
    }
    moveCat();
});