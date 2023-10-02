document.addEventListener('DOMContentLoaded', function () {
    let profileForm = document.getElementById('profile-form');
    let imageInput = document.getElementById('profile-image-input');
    let profileImage = document.getElementById('profile-image');
    let notification = document.getElementById('notification');
    let confirmationModal = document.getElementById("confirmation-modal");
    let closeButton = document.getElementById("close-button");
    let yesButton = document.getElementById("yes-button");
    let noButton = document.getElementById("no-button");

    if (profileForm) {
        profileForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            // Show the modal
            confirmationModal.style.display = "block";
        });

        closeButton.onclick = function() {
            confirmationModal.style.display = "none";
        }

        yesButton.onclick = function() {
            submitForm();
            confirmationModal.style.display = "none";
        }

        noButton.onclick = function() {
            confirmationModal.style.display = "none";
        }

        imageInput.addEventListener('change', function(e) {
            var reader = new FileReader();

            reader.onload = function(event) {
                profileImage.src = event.target.result;
            }

            reader.readAsDataURL(e.target.files[0]);
        });
    }

    function submitForm() {
        let formData = new FormData(profileForm);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/profile', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Check the content type
                const contentType = xhr.getResponseHeader('Content-Type');
                if (contentType.includes('application/json')) {
                    let response = JSON.parse(xhr.responseText);
                    if ('success' in response) {
                        notification.textContent = "Successfully update user information!";
                        notification.classList.add("notification-success");
                    } else {
                        notification.textContent = "An error occurred when updating user information.";
                        notification.classList.add("notification-error");
                    }
                    // Show the notification for 3 seconds
                    setTimeout(function() {
                        notification.textContent = "";
                        notification.classList.remove("notification-success", "notification-error");
                    }, 2000);
                }
            }
        };
        xhr.send(formData);
    }
});
