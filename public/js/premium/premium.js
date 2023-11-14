const subscribeModal = document.querySelector('.subscribe-modal');
const premiumNotification = document.getElementById('premium-notification');

function openSubscribeModal() {
    subscribeModal.style.display = 'block';
}

function closeSubscribeModal() {
    subscribeModal.style.display = 'none';
}

function subscribe(creatorId) {
    let formData = new FormData();
    formData.append('creatorId', creatorId);

    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/premium', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.onload = function() {
        if (xhr.status === 200) {
            premiumNotification.textContent = 'Subscribed to creator!';
            premiumNotification.classList.add('notification-success');

            closeSubscribeModal()

            let response = JSON.parse(xhr.responseText);
            if (response.success) {
                window.location.href = '/premium/' + creatorId;
            } else {
                premiumNotification.textContent = 'An error occurred while subscribing!';
                premiumNotification.classList.add('notification-error');
            }
        } else {
            premiumNotification.textContent = 'An error occurred while subscribing!';
            premiumNotification.classList.add('notification-error');
        }

        setTimeout(function() {
            premiumNotification.textContent = "";
            premiumNotification.classList.remove( "notification-success", "notification-error");
        }, 3000);
    }
    xhr.send(formData)
}
