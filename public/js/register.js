document.addEventListener('DOMContentLoaded', function () {
    let registerForm = document.getElementById('register-form');
    let registerErrorMessage = document.getElementById('register-error-message');
    console.log(registerErrorMessage, registerForm);
    if (registerForm) {
        registerForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            let formData = new FormData(registerForm);

            let xhr = new XMLHttpRequest();
            xhr.open('POST', '/register', true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        let response = JSON.parse(xhr.responseText);

                        if (response.status === 'SUCCESS') {
                            window.location.href = '/poems';
                        } else {
                            // Set the innerHTML of the error message div
                            registerErrorMessage.textContent = response.message;
                        }
                    } else {
                        console.error('Error occurred during registration request.');
                    }
                }
            };
            xhr.send(formData);
        });
    }
});
