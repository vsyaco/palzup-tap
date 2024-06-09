// script.js
document.addEventListener("DOMContentLoaded", function() {
    let points = 0;
    let boost = 1;
    let energy = 100;
    const maxEnergy = 100;
    const energyDepletionRate = maxEnergy / 60; // Depletes over 1 minute
    const tapBoostIncrease = 0.1; // Each tap adds 0.2 seconds worth of energy
    let tapCount = 0;
    let tapLimit = 2; // Default tap limit
    let lastTapTime = 0;

    const pointsDisplay = document.getElementById("points");
    const chainImage = document.getElementById("chainImage");
    const boostValueDisplay = document.getElementById("boostValue");
    const boostProgress = document.getElementById("boostProgress");

    function updateProgressBar() {
        boostProgress.style.width = `${(energy / maxEnergy) * 100}%`;
    }

    function depleteEnergy() {
        energy -= energyDepletionRate;
        if (energy < 0) {
            energy = 0;
        }
        updateProgressBar();

        // Update tap limit based on energy
        tapLimit = (energy > 0) ? 6 : 2;
    }

    chainImage.addEventListener("click", function(event) {
        const now = Date.now();

        if (now - lastTapTime >= 1000) {
            tapCount = 0; // Reset tap count every second
            lastTapTime = now;
        }

        if (tapCount < tapLimit) {
            points += boost;
            if (energy > 0) {
                energy += (tapBoostIncrease * (maxEnergy / 60)); // Increase energy by tapBoostIncrease seconds
                if (energy > maxEnergy) {
                    energy = maxEnergy;
                }
            } else {
                // If no energy, reset boost and update display
                boost = 1;
                boostValueDisplay.textContent = `${boost}x`;
            }
            pointsDisplay.textContent = points;
            updateProgressBar();

            // Visual effect for tap
            const tapEffect = document.createElement("div");
            tapEffect.className = "tap-effect";
            tapEffect.textContent = `+${boost}`;

            // Position the effect at the click position
            const rect = chainImage.getBoundingClientRect();
            tapEffect.style.left = `${event.clientX - rect.left}px`;
            tapEffect.style.top = `${event.clientY - rect.top}px`;

            chainImage.parentElement.appendChild(tapEffect);

            setTimeout(() => {
                tapEffect.remove();
            }, 1000);

            tapCount++;
        }
    });

    // Deplete energy every second
    setInterval(depleteEnergy, 1000);

    // Initialize the progress bar
    updateProgressBar();
});
