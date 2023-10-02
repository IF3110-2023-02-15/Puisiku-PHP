<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/profile.css">
    <link rel="stylesheet" href="/css/back_button.css">
    <link rel="stylesheet" href="/css/notification.css">
<body>
    <div id="notification" class="notification"></div>

    <div class="profile-header">
        <?php require_once VIEWS_DIR . 'components/buttons/back_button.php'?>
        <form id="logout-form" method="POST" action="/logout">
            <button class="btn-logout">Logout</button>
        </form>
    </div>

    <div class="profile-container">
        <h1 class="profile-title">Profile</h1>

        <img id="profile-image" class="profile-image" src="<?php echo $data['image_path']; ?>" alt="profile">

        <form id="profile-form" class="profile-form" enctype="multipart/form-data">

            <div class="profile-form-component">
                <label for="name">Username</label>
                <input class="profile-input" type="text" id="name" name="username" value="<?php echo $data['username'];?>" required>
            </div>

            <div class="profile-form-component">
                <label for="description">Description</label>
                <textarea class="profile-input" id="description" name="description" rows="4" ><?php echo $data['description'];?></textarea>
            </div>

            <div class="profile-form-component">
                <label for="profile-image">Profile Image</label>
                <input id="profile-image-input" class="profile-input" type="file" name="profile-image-path" accept=".jpg, .jpeg, .png">
            </div>

            <input class="profile-submit" type="submit" value="Update Profile">
        </form>
    </div>

    <div id="confirmation-modal" class="confirmation-modal">
        <span id="close-button" class="close-button">&times;</span>
        <div class="modal-content">
            <h2>Are you sure to update the profile?</h2>
            <div class="button-container">
                <button id="yes-button">Yes</button>
                <button id="no-button">No</button>
            </div>
        </div>
    </div>


    <script src="/js/profile.js"></script>
</body>
</html>