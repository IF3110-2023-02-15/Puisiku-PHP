<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <h1>Login</h1>

    <form id="login-form" method="POST" action="/login">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <div id="login-error-message" class="error-message"></div>

        <input type="submit" value="Submit">
    </form>

    Haven't have any account? Sign up <a href="/register">here</a>!
     
    <br><br>

    <a href="/">
        <button>
            Back to Home
        </button>   
    </a>

    <script src="/js/login.js"></script>
</body>
</html>