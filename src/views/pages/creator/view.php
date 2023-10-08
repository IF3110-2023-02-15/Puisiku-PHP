<?php
$genres = GENRES;
require_once SERVICES_DIR . 'poems/index.php';

$id=isset($_SESSION['id'])?($_SESSION['id']):null;
$poemService=new PoemsService();
$datapoem = $poemService->getData($id);
?>
<div class="scrollable-creator">
        <div id="notification" class="notification"></div>
        <div class="creator-data">
            <div class="creator-img-box">
                <img class="img-creator-page" src="<?php echo $data['image_path']; ?>" alt="Creator Image">
            </div>
            <div class="creator-data-box">
                <p class="creator-name"><?php echo $data['username']; ?></p>
                <p class="creator-email"><?php echo $data['email']; ?></p>
                <div class="creator-description">
                    <p><?php echo $data['description']; ?></p>
                </div>
            </div>
        </div>

        <div class="center-list-poem">
            <div class="add-poem-btn">
                <button class="creator-add-poem" id="add-poem-button-on-creator">Add Poem</button>
            </div >
        </div>
        <div class="center-list-poem">
            <div id ="poem-list-container" class="poem-creator-table"></div>
        </div>
    </div>

</div>

<div id="add-poem-modal" class="add-modal">
        <div class="add-modal-content">
            <span class="close-button" id="close-add-poem-modal">&times;</span>
                <h1>Add Your New Poem</h1>
                <form id="add-poem-form" class="add-form" enctype="multipart/form-data">
                    <label for="add-poem-title">Title:</label>
                    <input type="text" id="add-poem-title" name="add-poem-title" placeholder="John Doe" required><br>

                    <label for="add-poem-genre">Genre:</label>
                    <select id="add-poem-genre" name="add-poem-genre" required>
                        <?php foreach($genres as $genre) { ?>
                            <option value="<?php echo $genre; ?>"><?php echo $genre; ?></option>
                        <?php } ?>
                    </select><br>

                    <label for="add-poem-content">Content:</label>
                    <textarea type="text" id="add-poem-content" name="add-poem-content" placeholder="The flowers are.." required></textarea><br>

                    <label for="add-poem-image">Image:</label>
                    <input id="add-poem-image" type="file" name="add-poem-image" accept=".jpg, .jpeg, .png"><br>

                    <label for="add-poem-audio">Audio:</label>
                    <input id="add-poem-audio" type="file" name="add-poem-audio" accept=".mp3"><br>
                    
                    <label for="add-poem-year">Year:</label><br>
                    <input type="number" id="add-poem-year" name="add-poem-year" min="0" max="2023" value="2023" required><br>
                    
                    <div class="margin-submit">
                    <input type="submit" id="add-poem-submit" value="Submit">
                    </div>
                </form>
        </div>
    </div>

    <div id="update-poem-list-modal" class="update-modal">
        <div class="update-modal-content">
        <div class="update-modal-content">
            <span id="close-poem-list-modal" class="close-button">&times;</span>
            <h1>Update Poem</h1>
            <form id="poem-update-list-form" class="update-form" enctype="multipart/form-data">
                <label for="title-update-poem-list">Title:</label>
                <input type="text" id="title-update-poem-list" name="title-update-poem-list" placeholder="John Doe" required><br>

                <label for="genre-update-poem-list">Genre:</label>
                <select id="genre-update-poem-list" name="genre-update-poem-list" required>
                    <?php foreach($genres as $genre) { ?>
                        <option value="<?php echo $genre; ?>" <?php echo ($datapoem['genre'] === $genre) ? 'selected' : ''; ?>><?php echo $genre; ?></option>
                    <?php } ?>
                </select><br>

                <label for="content-update-poem-list">Content:</label>
                <textarea id="content-update-poem-list" name="content-update-poem-list" placeholder="John Doe" required></textarea><br>

                <label for="image-update-poem-list">Image:</label>
                <input id="image-update-poem-list" type="file" name="image-update-poem-list" accept=".jpg, .jpeg, .png"><br>

                <label for="audio-update-poem-list">Audio:</label>
                <input id="audio-update-poem-list" type="file" name="audio-update-poem-list" accept=".mp3"><br>

                <div class="margin-submit">
                <input type="submit" class="margin-submit" id="submit-update-poem-list" class="button-container" value="Submit">
                    </div>

            </form>

        </div>
    </div>

    <div id="confirmation-modal-poem-list" class="confirmation-modal">
        <span id="close-button-poem-list" class="close-button">&times;</span>
        <div class="modal-content">
            <h2 id="confirmation-modal-text-poem-list">Apa</h2>
            <div class="button-container">
                <button id="confirm-delete-poem-list">Yes</button>
                <button id="cancel-delete-poem-list">No</button>
            </div>
        </div>
    </div>


<script defer src="/js/creator.js"></script>