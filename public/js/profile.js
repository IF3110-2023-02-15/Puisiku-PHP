function uploadFile(fileInputElement, url = '/file') {
    return new Promise((resolve, reject) => {
        // Create a new FormData instance
        let formData = new FormData();

        // Add the file to the FormData instance
        formData.append('file', fileInputElement.files[0]);

        // Create a new XMLHttpRequest
        let xhr = new XMLHttpRequest();

        // Set up the request
        xhr.open('POST', url , true);

        // Set up handlers for the request
        xhr.onload = function() {
            if (xhr.status === 200) {
                let response = JSON.parse(xhr.responseText);

                if (response.success) {
                    resolve(response.success);
                } else {
                    reject('Error: ' + xhr.responseText);
                }
            } else {
                reject('Request failed with status ' + xhr.status);
            }
        };

        xhr.send(formData);
    });
}

function parseFormDataObject(formData) {
    let object = {};
    formData.forEach((value, key) => object[key] = value);
    return object;
}

document.addEventListener('DOMContentLoaded', function () {
    const profileForm = document.getElementById('profile-form');
    const imageInput = document.getElementById('profile-image-input');
    const profileImage = document.getElementById('profile-image');
    const notification = document.getElementById('notification');
    const confirmationModal = document.getElementById("confirmation-modal");
    const closeButton = document.getElementById("close-button");
    const yesButton = document.getElementById("yes-button");
    const noButton = document.getElementById("no-button");

    if (profileForm) {
        profileForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            // Show the modal
            confirmationModal.style.display = "block";
        });

        closeButton.onclick = function() {
            confirmationModal.style.display = "none";
        }

        yesButton.onclick = async function() {
            await submitForm();
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

    async function submitForm() {
        let image_path = '';

        if (imageInput.files.length > 0) {
            try {
                image_path = await uploadFile(imageInput);
            } catch (error) {
                notification.textContent = "Failed to upload file!";
                notification.classList.add("notification-error");

                setTimeout(function() {
                    notification.textContent = "";
                    notification.classList.remove("notification-error");
                }, 2000);

                return;
            }
        }

        let formData = new FormData(profileForm);
        let formDataObject = parseFormDataObject(formData);

        formDataObject['profile-image-path'] = image_path;

        let jsonFormData = JSON.stringify(formDataObject);

        let xhr = new XMLHttpRequest();
        xhr.open('PUT', '/profile', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader('Content-Type', 'application/json');

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
        xhr.send(jsonFormData);
    }
});
