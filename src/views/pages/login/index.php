<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Register">
    <title>Login</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/login.css">
</head>
<body id="grad">
    <div class="center">
        <div class="container">
            <h1 class="title">Login</h1>

            <form id="login-form" method="POST" action="/login">
                <label class="label-text" for="email">Email:</label> <br>
                <input class="style-input" type="email" id="email" name="email" placeholder="john@example.com" required><br><br>

                <label class="label-text" for="password">Password:</label> <br>
                <input class="style-input" type="password" id="password" name="password" placeholder="********"required><br><br>

                <div id="login-error-message" class="error-message"></div>

                <div class="center-submit">
                    <input class="sbmt-style" type="submit" value="Submit">
                </div>
                

            </form>

            <div class="plain-text">
                Don't have an account? <a class="link" href="/register">Sign up here!</a>
            </div>

            <a class="center-back" href="/">
                Back to Home
            </a>
        </div>
    </div>

    <script src="/js/login.js"></script>
</body>
</html>