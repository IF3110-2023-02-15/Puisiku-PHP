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
                <form>
                    <label>Title:</label>
                    <input type="text" id="add-poem-title" name="add-poem-title" placeholder="John Doe" required><br>

                    <label>Genre:</label>
                    <select id="add-poem-genre" name="add-poem-genre" required>
                        <?php foreach($genres as $genre) { ?>
                            <option value="<?php echo $genre; ?>"><?php echo $genre; ?></option>
                        <?php } ?>
                    </select><br>

                    <label>Content:</label>
                    <input type="text" id="add-poem-content" name="add-poem-content" placeholder="The flowers are.." required><br>

                    <label>Image:</label>
                    <input id="add-poem-image" type="file" name="add-poem-image" accept=".jpg, .jpeg, .png"><br>

                    <label>Audio:</label>
                    <input id="add-poem-audio" type="file" name="add-poem-audio" accept=".mp3"><br>

                    <label>Year:</label>
                    <input type="number" id="add-poem-year" name="add-poem-year" placeholder="2021" required><br>

                    <button id="add-poem-submit">Submit</button>
                </form>


                <!-- <form id="add-poem-form" enctype="multipart/form-data">
                    <label>Title:</label>
                    <input type="text" id="add-poem-title" name="add-poem-title" placeholder="John Doe" required><br>
                    
                    <label>Genre:</label>
                    <select id="add-poem-genre" name="add-poem-genre" required>
                        <?php foreach($genres as $genre) { ?>
                            <option value="<?php echo $genre; ?>"><?php echo $genre; ?></option>
                        <?php } ?>
                    </select><br>

                    <label>Content:</label>
                    <textarea type="text" id="add-poem-content" name="add-poem-content" placeholder="The flowers are blooming.." required><br>

                    <label>Image:</label>
                    <input id="add-poem-image" type="file" name="add-poem-image" accept=".jpg, .jpeg, .png"><br>

                    <label>Audio:</label>
                    <input id="add-poem-audio" type="file" name="add-poem-audio" accept=".mp3"><br>

                    <label>Year:</label>
                    <input type="number" id="add-poem-year" name="add-poem-year" placeholder="2021" required><br>

                    <button id="add-poem-submit">Submit</button>
                </form> -->
            </div>
        </div>
    </div>
</div>



<script defer src="/js/creator.js"></script>