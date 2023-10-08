document.addEventListener('DOMContentLoaded', function () {
    let loginForm = document.getElementById('login-form');
    let loginErrorMessage = document.getElementById('login-error-message');

    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            let formData = new FormData(loginForm);

            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/login', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        const contentType = xhr.getResponseHeader('Content-Type');
                        if (contentType.includes('application/json')) {
                            console.log(xhr.responseText);
                            let response = JSON.parse(xhr.responseText);

                            if (response.status === 'SUCCESS') {
                                window.location.href = '/poems';
                            } else {
                                loginErrorMessage.textContent = 'Login failed. Please check your email and password.';
                            }
                        } else {
                            console.error('Invalid content type in response:', contentType);
                        }
                    } else {
                        console.error('Error occurred during login request.');
                    }
                }
            };
            xhr.send(formData);
        });
    }
});
