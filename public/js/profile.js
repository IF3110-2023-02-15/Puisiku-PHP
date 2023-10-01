document.addEventListener('DOMContentLoaded', function () {
    let loginForm = document.getElementById('profile-form');

    if (profileForm) {
        profileForm.addEventListener('save', function (event) {
            event.preventDefault(); // Prevent default form submission

            let formData = new FormData(profileForm);

            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/profile', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        // Check the content type
                        const contentType = xhr.getResponseHeader('Content-Type');
                        if (contentType.includes('application/json')) {
                            let response = JSON.parse(xhr.responseText);

                            if (response.status === 'SUCCESS') {
                                window.location.href = '/home';
                            }
                        }
                    }
                }
            };
            xhr.send(formData);
        });
    }
});
