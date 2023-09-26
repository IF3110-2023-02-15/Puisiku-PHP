<!DOCTYPE html>
<html>
<head>
    <title>Error Page</title>
</head>
<body>
    <div class="error-container">
        <h1>Error: <?php echo $code; ?></h1>
        <p>Sorry, something went wrong.</p>

        <a href="/">
            <button>Back to Home</button>
        </a>
    </div>
</body>
</html>