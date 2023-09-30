<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/register.css">
</head>
<body id="grad">
    <div class="center">
        <div class="container">
            <h1 class="title">Register</h1>

            <form id="register-form" method="POST" action="/register">
                <label class="label-text" for="username">Username:</label> <br>
                <input class="style-input" type="text" id="username" name="username" placeholder="John Doe" required>

                <br><br>

                <label class="label-text" for="email">Email:</label> <br>
                <input class="style-input" type="email" id="email" name="email" placeholder="john@example.com" required>

                <br><br>

                <label class="label-text" for="password">Password:</label> <br>
                <input class="style-input" type="password" id="password" name="password" placeholder="********" required>

                <br><br>

                <label class="label-text" for="confirm_password">Confirm Password:</label> <br>
                <input class="style-input" type="password" id="confirm_password" name="confirm_password" placeholder="********" required>

                <br><br>

                <div id="register-error-message" class="error-message"></div>

                <div class="center-submit">
                    <input class="sbmt-style" type="submit" value="Submit">
                </div>

            </form>

            <a class="center-back" href="/">
                Back to Home
            </a>

            <script src="/js/register.js"></script>
        </div>
        
    </div>
</body>
</html>