<?php
$genres = GENRES;
?>
<div>
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
    <div>
        <div class="center-list-poem">
            <div class="add-poem-btn">
                <button class="creator-add-poem" id="add-poem-button-on-creator">Add Poem</button>
            </div >
        </div>
        <div class="center-list-poem">
            <div class="poem-creator-table">
                <table id="poem-table" class="table-size">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Genre</th>
                            <th>Year</th>
                            <th>Delete</th>
                            <th>Update</th>
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

                                echo "<td><button class='delete-poem-list-button' data-id-delete-poem-list='{$poem['id']}'><svg width='20px' height='20px' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'> <path d='M12 10V17M8 10V17M19 9H22M19 14H22M19 19H21M16 6V16.2C16 17.8802 16 18.7202 15.673 19.362C15.3854 19.9265 14.9265 20.3854 14.362 20.673C13.7202 21 12.8802 21 11.2 21H8.8C7.11984 21 6.27976 21 5.63803 20.673C5.07354 20.3854 4.6146 19.9265 4.32698 19.362C4 18.7202 4 17.8802 4 16.2V6M2 6H18M14 6L13.7294 5.18807C13.4671 4.40125 13.3359 4.00784 13.0927 3.71698C12.8779 3.46013 12.6021 3.26132 12.2905 3.13878C11.9376 3 11.523 3 10.6936 3H9.30643C8.47705 3 8.06236 3 7.70951 3.13878C7.39792 3.26132 7.12208 3.46013 6.90729 3.71698C6.66405 4.00784 6.53292 4.40125 6.27064 5.18807L6 6' stroke='#AA7c75' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'></path> </g></svg></button></td>";
                                echo "<td><button class='update-poem-list-button' data-id-update-poem-list='{$poem['id']}'><svg width='20px' height='20px' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'><g id='SVGRepo_bgCarrier' stroke-width='0'></g><g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g><g id='SVGRepo_iconCarrier'> <path d='M16 3.98999H8C6.93913 3.98999 5.92178 4.41135 5.17163 5.1615C4.42149 5.91164 4 6.92912 4 7.98999V17.99C4 19.0509 4.42149 20.0682 5.17163 20.8184C5.92178 21.5685 6.93913 21.99 8 21.99H16C17.0609 21.99 18.0783 21.5685 18.8284 20.8184C19.5786 20.0682 20 19.0509 20 17.99V7.98999C20 6.92912 19.5786 5.91164 18.8284 5.1615C18.0783 4.41135 17.0609 3.98999 16 3.98999Z' stroke='#AA7c75' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> <path d='M9 2V7' stroke='#AA7c75' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> <path d='M15 2V7' stroke='#AA7c75' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> <path d='M8 16H14' stroke='#AA7c75' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> <path d='M8 12H16' stroke='#AA7c75' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path> </g></svg></button></td>";
                                echo "</tr>";

                                $rowNumber++;
                            }
                            ?>
                        </tbody>
                </table>
            </div>
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

                    <label for="add-poem-year">Year:</label>
                    <input type="number" id="add-poem-year" name="add-poem-year" min="0" max="2023" value="2023" required><br>

                    <button id="add-poem-submit">Submit</button>
                </form>
        </div>
    </div>

    <div id="update-poem-list-modal" class="update-modal">
        <div class="update-modal-content">
            <span id="close-poem-list-modal" class="close-button">&times;</span>
            <h1>Update Poem</h1>
            <form id="poem-update-list-form" class="update-form" enctype="multipart/form-data">
                <label for="title-update-poem-list">Title:</label><br>
                <input type="text" id="title-update-poem-list" name="title-update-poem-list" value="<?php echo $datapoem['title'];?>"required><br>

                <label for="genre-update-poem-list">Genre:</label><br>
                <select id="genre-update-poem-list" name="genre-update-poem-list" required>
                    <?php foreach($genres as $genre) { ?>
                        <option value="<?php echo $genre; ?>" <?php echo ($datapoem['genre'] === $genre) ? 'selected' : ''; ?>><?php echo $genre; ?></option>
                    <?php } ?>
                </select><br>

                <label for="content-update-poem-list">Content:</label><br>
                <textarea id="content-update-poem-list" name="content-update-poem-list" required><?php echo $datapoem['content'];?></textarea><br>

                <label for="image-update-poem-list">Image:</label><br>
                <input id="image-update-poem-list" type="file" name="image-update-poem-list" accept=".jpg, .jpeg, .png"><br>

                <label for="audio-update-poem-list">Audio:</label><br>
                <input id="audio-update-poem-list" type="file" name="audio-update-poem-list" accept=".mp3"><br>

                <button id="submit-update-poem-list" class="button-container">Submit</button>
            </form>
        </div>
    </div>


<script defer src="/js/creator.js"></script>