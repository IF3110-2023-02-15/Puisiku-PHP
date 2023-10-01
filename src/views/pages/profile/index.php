<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/profile.css">
<body id="grad">
    
    <div class="btn-home">
    <a href="/">Back To Home</a>
    </div>
    
    <div class="center">
        <div class="container">
            <h1 class="title">Update Profile</h1>
            <form id="profile-form" method="POST" action="/profile">
                <label class="label-text" for="name"> Nama:</label> <br>
                <input class="style-input" type="text" id="name" name="name" value="<?php echo $data['username'];?>"><br><br>

                <label class="label-text" for="text">Description:</label> <br>
                <input class="style-input" type="text" id="description" name="description" value="<?php echo $data['description'];?>"><br><br>

                
                <div class="img-profile">
                    <h2 class="tag-image">You Profile</h2>
                    <img class="img" src="/img/queencard.jpeg" alt="profile">
                    <input class="choose" type="file" name="img-profile">
                    <!-- <form action="/upload" method="post" enctype="multipart/form-data">
                        <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg, .jpeg, .png">
                        <input type="submit" value="Upload Image" name="submit">
                    </form> -->
                </div>

                <div class="center-submit">
                    <input class="sbmt-style" type="submit" value="save">       
                </div>   
            </form>

            <form id="profile-form" method="POST" action="/logout">
                <button class="btn-logout">Logout</button> 
            </form>
        </div>
    </div>    

    <script src="/js/profile.js"></script>
</body>
</html>