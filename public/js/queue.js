const game = document.getElementById('game');
const checkStartScript = game.getAttribute('data-checkStart');
const checkQueueScript = game.getAttribute('data-checkQueue');
const gamePage = game.getAttribute('data-game');

checkGame();

function checkGame() {

    checkStart();
    checkQueue();
}

function checkStart() {
    fetch(checkStartScript, {
        method: "GET",
        headers: {"X-Requested-With": "XMLHttpRequest"}
    })
        .then(response => response.json())
        .then(data => handleCheckStart(data))
        .catch(error => alert(error));
}

function checkQueue() {
    fetch(checkQueueScript, {
        method: "GET",
        headers: {"X-Requested-With": "XMLHttpRequest"}
    })
        .then(response => response.json())
        .then(data => handleCheckQueue(data))
        .catch(error => alert(error));
}

function handleCheckStart(data) {
    if (data.st === 1) {
        showStartMessage();
        setTimeout(() => window.location.replace(gamePage), 5000);
    } else if (data.st === 2) {
        window.location.replace('');
    } else {
        setTimeout(checkGame, 3000);
    }
}

function handleCheckQueue(data) {

    if (data.st === 1) {
        renderUsers(data.users);
    } else if (data.st === 2) {
        window.location.replace('');
    }
}

function renderUsers(users) {
    let usersTable = document.getElementById('usersTable');
    let tempUserRow = document.getElementById('tempUser');

    usersTable.innerHTML = '';

    for (let i = 0; i < users.length; i++) {
        let newUserRow = tempUserRow.cloneNode(true);
        newUserRow.setAttribute('id', users[i].id);
        newUserRow.classList.remove('d-none');
        if (users[i].bgColor) newUserRow.classList.add(users[i].bgColor);
        newUserRow.querySelector('[data-id="number"]').innerHTML = i + 1;
        newUserRow.querySelector('[data-id="username"]').innerHTML = users[i].username;
        newUserRow.querySelector('[data-id="status"]').innerHTML = users[i].status;
        newUserRow.querySelector('[data-id="status"]').classList.add(users[i].badgeColor);

        usersTable.appendChild(newUserRow);
    }
}

function showStartMessage() {
    let startMessage = document.getElementById('startMessage'),
        loadingMessage = document.getElementById('loadingMessage');

    loadingMessage.classList.add('d-none');
    startMessage.classList.remove('d-none');
}
