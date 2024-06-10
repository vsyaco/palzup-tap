// tap.js
document.addEventListener("DOMContentLoaded", function() {
    let points = 0;
    let boost = 1;
    let energy = 100;
    const maxEnergy = 100;
    const energyDepletionRate = maxEnergy / 30; // Depletes over 1 minute
    const tapBoostIncrease = 0.1; // Each tap adds 0.1 seconds worth of energy
    let tapCount = 0;
    let tapLimit = 2; // Default tap limit
    let tapEnergyLimit = 100; // Default tap limit
    let lastTapTime = 0;
    let scoreInLast5Seconds = 0;

    const pointsDisplay = document.getElementById("points");
    const chainImage = document.getElementById("chainImage");
    const boostValueDisplay = document.getElementById("boostValue");
    const boostProgress = document.getElementById("boostProgress");

    // Ensure Telegram WebApp is initialized
    Telegram.WebApp.ready();

    // Get user data
    const user = Telegram.WebApp.initDataUnsafe.user;
    if (user) {
        localStorage.setItem('telegramUser', JSON.stringify(user));

        // Fetch additional user data from the server
        fetch(`/telegram_user/${user.id}`)
            .then(response => response.json())
            .then(data => {
                // Update points display with scores_all
                if (data && data.score_all) {
                    points = data.score_all;
                    pointsDisplay.textContent = points;
                }
            })
            .catch(error => {
                console.error('Error fetching user data:', error);
            });
    }

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
        tapLimit = (energy > 0) ? tapEnergyLimit : 2;
    }

    function handleTap(event) {
        event.preventDefault(); // Prevent default behavior

        const now = Date.now();

        if (now - lastTapTime >= 1000) {
            tapCount = 0; // Reset tap count every second
            lastTapTime = now;
        }

        for (let i = 0; i < event.touches.length; i++) {
            if (tapCount < tapLimit) {
                points += boost;
                scoreInLast5Seconds += boost;

                if (energy > 0) {
                    energy += (tapBoostIncrease * (maxEnergy / 60)); // Increase energy by tapBoostIncrease seconds
                    if (energy > maxEnergy) {
                        energy = maxEnergy;
                    }
                } else {
                    // If no energy, reset boost and update display
                    boost = 1;
                    // boostValueDisplay.textContent = `${boost}x`;
                }
                pointsDisplay.textContent = points;
                updateProgressBar();

                // Visual effect for tap
                const tapEffect = document.createElement("div");
                tapEffect.className = "tap-effect";
                tapEffect.textContent = `+${boost}`;

                // Position the effect at the touch position
                const rect = chainImage.getBoundingClientRect();
                const x = event.touches[i].clientX - rect.left;
                const y = event.touches[i].clientY - rect.top;
                tapEffect.style.left = `${x}px`;
                tapEffect.style.top = `${y}px`;

                chainImage.appendChild(tapEffect);

                setTimeout(() => {
                    tapEffect.remove();
                }, 1000);

                // Vibrate on tap
                Telegram.WebApp.HapticFeedback.impactOccurred('heavy');

                tapCount++;
            }
        }
    }

    chainImage.addEventListener("touchstart", handleTap);

    // Deplete energy every second
    setInterval(depleteEnergy, 1000);

    // Initialize the progress bar
    updateProgressBar();

    // Send collected scores every 5 seconds
    setInterval(function() {
        if (scoreInLast5Seconds > 0) {
            const userData = localStorage.getItem('telegramUser');
            if (userData) {
                const data = {
                    score: scoreInLast5Seconds,
                    user: JSON.parse(userData)
                };

                fetch('/scores', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Laravel CSRF token
                    },
                    body: JSON.stringify(data)
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });

                // Reset the score counter
                scoreInLast5Seconds = 0;
            }
        }
    }, 1000);
});
