start();
const checkGame = setInterval(start, 3000);

function start() {
    fetch(startScript, {method: "GET"})
        .then(response => response.json())
        .then(data => handleStart(data))
        .catch(error => alert('Something went wrong. Please refresh the page!'));
}

function handleStart(data) {
    if (data.st === 1) {
        showStartMessage();
        clearInterval(checkGame);
        setTimeout(() => window.location.replace(gamePage), 5000);
    }
}

function showStartMessage() {
    let startMessage = document.getElementById('#startMessage');
    startMessage.classList.remove('d-none');
}