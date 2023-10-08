<?php $genres = GENRES;
?>
<div class="tes">
    <!-- Only for testing, should not get username here, do it in controller -->
    <div class="horizontal-list">
        <div class="items">
            <div class="horizontal-align">
                <div>Users</div>
                <a href="/register">
                    <button class="create-size">Add User</button>
                </a>
            </div>
            <div id="users-container" class="bg-clr"></div>
        </div>
        <div class="items">
            <div class="horizontal-align">
                <div>
                    Poems
                </div>
                <a href="/creator">
                    <button id="add-poem" class="create-size">
                        Add Poem
                    </button>
                </a>
            </div>
            <div id="poems-container" class="bg-clr"></div>
        </div>

        <div class="items">
            <div class="horizontal-align">
                <div>
                    Playlists
                </div>
            </div>
            <div id="playlists-container" class="bg-clr"></div>
        </div>
    </div>

    <div id="confirmation-modal-user" class="confirmation-modal">
        <span id="close-button-user" class="close-button">&times;</span>
        <div class="modal-content">
            <h2 id="confirmation-modal-text-user"></h2>
            <div class="button-container">
                <button id="confirm-delete-user">Yes</button>
                <button id="cancel-delete-user">No</button>
            </div>
        </div>
    </div>

    <div id="confirmation-modal-poem" class="confirmation-modal">
        <span id="close-button-poem" class="close-button">&times;</span>
        <div class="modal-content">
            <h2 id="confirmation-modal-text-poem"></h2>
            <div class="button-container">
                <button id="confirm-delete-poem">Yes</button>
                <button id="cancel-delete-poem">No</button>
            </div>
        </div>
    </div>

    <div id="confirmation-modal-playlist" class="confirmation-modal">
        <span id="close-button-playlist" class="close-button">&times;</span>
        <div class="modal-content">
            <h2 id="confirmation-modal-text-playlist"></h2>
            <div class="button-container">
                <button id="confirm-delete-playlist">Yes</button>
                <button id="cancel-delete-playlist">No</button>
            </div>
        </div>
    </div>

    <div id="update-user-modal" class="update-modal">
        <div class="update-modal-content">
        <h1>Update User</h1>
        <span id="update-close-button" class="close-button">&times;</span>
                <form id="user-update-form" class="update-form" enctype="multipart/form-data">
                    <label for="update-username">Username:</label><br>
                    <input type="text" id="update-username" name="update-username" required><br>

                    <label for="description">Description:</label><br>
                    <textarea type="text" id="update-description" name="update-description" required></textarea><br>

                    <input type="radio" id="update-role-creator" name="update-role" value="user">
                    <label for="update-role-creator" id="update-radiobutton-text">Upgrade to Creator</label><br>

                    <label for="profile-image">Profile Image</label><br>
                    <input id="update-image" class="profile-input" type="file" name="update-image" accept=".jpg, .jpeg, .png"><br>

                    <input type="submit" class="margin-submit" id="update-submit" value="Submit">
                </form>
            </div>
    </div>

    <div id="update-poem-modal" class="update-modal">
        <div class="update-modal-content">
            <span id="close-poem-modal" class="close-button">&times;</span>
            <h1>Update Poem</h1>
            <form id="poem-update-form" class="update-form" enctype="multipart/form-data">
                <label for="title-update-poem">Title:</label>
                <input type="text" id="title-update-poem" name="title-update-poem" placeholder="John Doe" required><br>

                <label for="genre-update-poem">Genre:</label>
                <select id="genre-update-poem" name="genre-update-poem" required>
                    <?php foreach($genres as $genre) { ?>
                        <option value="<?php echo $genre; ?>"><?php echo $genre; ?></option>
                    <?php } ?>
                </select><br>

                <label for="content-update-poem">Content:</label>
                <textarea id="content-update-poem" name="content-update-poem" placeholder="John Doe" required></textarea><br>

                <label for="image-update-poem">Image:</label>
                <input id="image-update-poem" type="file" name="image-update-poem" accept=".jpg, .jpeg, .png"><br>

                <label for="audio-update-poem">Audio:</label>
                <input id="audio-update-poem" type="file" name="audio-update-poem" accept=".mp3"><br>

                <div class="margin-submit">
                <input type="submit" class="margin-submit" id="submit-update-poem" class="button-container" value="Submit">
                    </div>

            </form>

        </div>
    </div>

    <div id="update-playlist-modal" class="update-modal">
        <div class="update-modal-content">
            <span id="close-playlist-modal" class="close-button">&times;</span>
            <h1>Update Playlist</h1>
            <form id="playlist-update-form" class="update-form" enctype="multipart/form-data">
                <label for="title-update-playlist">Title:</label>
                <input type="text" id="title-update-playlist" name="title-update-playlist" placeholder="John Doe" required><br>

                <label for="image-update-playlist">Image:</label>
                <input id="image-update-playlist" type="file" name="image-update-playlist" accept=".jpg, .jpeg, .png"><br>


                <div class="margin-submit">
                <input type="submit" class="margin-submit" id="submit-playlist-poem" class="button-container" value="submit">
                    </div>

            </form>

        </div>
    </div>

</div>


<script defer src="/js/admin.js"></script>