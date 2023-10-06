<?php
$genres = GENRES;
?>
<div>
   <div class="creator-profile">
        <img src="<?php echo $data['image_path']; ?>" alt="Creator Image">
        <h1><?php echo $data['username']; ?></h1>
        <p><?php echo $data['email']; ?></p>
        <p><?php echo $data['description']; ?></p>
    </div>
    <div>
        <button id="add-poem-button-on-creator">Add User</button>
    </div>

    <div id="add-poem-modal" class="update-modal">
        <div class="modal-content">
            <span class="close" id="close-add-poem-modal">&times;</span>
            <!-- Content of your modal goes here -->
            <div class="modal-body">
                <p>Add Your New Poem</p>
                <form id="add-poem-form" enctype="multipart/form-data">
                    <label for="add-poem-title">Title:</label>
                    <input type="text" id="add-poem-title" name="add-poem-title" placeholder="John Doe" required><br>

                    <label for="add-poem-genre">Genre:</label>
                    <select id="add-poem-genre" name="add-poem-genre" required>
                        <?php foreach($genres as $genre) { ?>
                            <option value="<?php echo $genre; ?>"><?php echo $genre; ?></option>
                        <?php } ?>
                    </select><br>

                    <label for="add-poem-content">Content:</label>
                    <input type="text" id="add-poem-content" name="add-poem-content" placeholder="The flowers are.." required><br>

                    <label for="add-poem-image">Image:</label>
                    <input id="add-poem-image" type="file" name="add-poem-image" accept=".jpg, .jpeg, .png"><br>

                    <label for="add-poem-audio">Audio:</label>
                    <input id="add-poem-audio" type="file" name="add-poem-audio" accept=".mp3"><br>

                    <label for="add-poem-year">Year:</label>
                    <input type="number" id="add-poem-year" name="add-poem-year" placeholder="2021" required><br>

                    <button id="add-poem-submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <table id="poem-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Genre</th>
                <th>Year</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once SERVICES_DIR . 'poems/index.php';

            $id=isset($_SESSION['id'])?($_SESSION['id']):null;

            $poemService = new PoemsService();

            $poems = $poemService->getAllPoemByCreator($id);
            $rowNumber = 1;

            foreach ($poems as $poem) {
                echo "<tr>";
                echo "<td>{$rowNumber}</td>";
                echo "<td>{$poem['title']}</td>";
                echo "<td>{$poem['genre']}</td>";
                echo "<td>{$poem['year']}</td>";

                echo "<td><button class='delete-poem-list-button' data-id-delete-poem-list='{$poem['id']}'>Delete</button></td>";
                echo "<td><button class='update-poem-list-button' data-id-update-poem-list='{$poem['id']}'>Update</button></td>";
                echo "</tr>";

                $rowNumber++;
            }
            ?>
        </tbody>
    </table>

    <div id="update-poem-list-modal" class="update-modal">
        <div class="modal-content">
            <span id="close-poem-list-modal" class="close-button">&times;</span>
            <form id="poem-update-list-form" enctype="multipart/form-data">
                <label for="title-update-poem-list">Title:</label><br>
                <input type="text" id="title-update-poem-list" name="title-update-poem-list" required><br>

                <label for="genre-update-poem-list">Genre:</label><br>
                <select id="genre-update-poem-list" name="genre-update-poem-list" required>
                    <?php foreach($genres as $genre) { ?>
                        <option value="<?php echo $genre; ?>"><?php echo $genre; ?></option>
                    <?php } ?>
                </select><br>

                <label for="content-update-poem-list">Content:</label><br>
                <textarea id="content-update-poem-list" name="content-update-poem-list" required></textarea><br>

                <label for="image-update-poem-list">Image:</label><br>
                <input id="image-update-poem-list" type="file" name="image-update-poem-list" accept=".jpg, .jpeg, .png"><br>

                <label for="audio-update-poem-list">Audio:</label><br>
                <input id="audio-update-poem-list" type="file" name="audio-update-poem-list" accept=".mp3"><br>

                <button id="submit-update-poem-list">Submit</button>
            </form>
        </div>
    </div>
</div>



<script defer src="/js/creator.js"></script>