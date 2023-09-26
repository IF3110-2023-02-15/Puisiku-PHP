<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <h1>Register</h1>

    <form id="register-form" method="POST" action="/register">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <br><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>

        <br><br>

        <div id="register-error-message" class="error-message"></div>

        <input type="submit" value="Submit">
    </form>

    <a href="/">
        <button>
            Back to Home
        </button>   
    </a>

    <script src="/js/register.js"></script>
</body>
</html>