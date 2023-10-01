<div class="tes">
    <!-- Only for testing, should not get username here, do it in controller -->
    <div class="horizontal-list">
        <div class="items">
            <div class="horizontal-align">
                <div>
                    Users
                </div>
                <button class="create-size">
                    Add User
                </button>
            </div>
            <div class="bg-clr">
                <ol class="space">
                    <?php foreach ($usernames as $username): ?>
                        <li><?php echo $username; ?>
                            <button class="update-button">
                                <svg class="hover-button" width="8" height="16" viewBox="0 0 8 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.10243 2.96037C3.08655 2.96037 3.8917 2.32131 3.8917 1.54024C3.8917 0.759175 3.08655 0.120117 2.10243 0.120117C1.11838 0.120117 0.313232 0.759175 0.313232 1.54024C0.313232 2.32131 1.11838 2.96037 2.10243 2.96037ZM2.10243 4.38051C1.11838 4.38051 0.313232 5.01956 0.313232 5.80061C0.313232 6.58172 1.11838 7.22078 2.10243 7.22078C3.08655 7.22078 3.8917 6.58172 3.8917 5.80061C3.8917 5.01956 3.08655 4.38051 2.10243 4.38051ZM2.10243 8.64089C1.11838 8.64089 0.313232 9.27995 0.313232 10.061C0.313232 10.8421 1.11838 11.4812 2.10243 11.4812C3.08655 11.4812 3.8917 10.8421 3.8917 10.061C3.8917 9.27995 3.08655 8.64089 2.10243 8.64089Z" fill="#D49B92"/>
                                </svg>
                            </button>
                            <button class="update-button">
                                <svg class="hover-button" width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6M14 10V17M10 10V17" stroke="#D49B92" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> </g>
                                </svg>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
        
        <div class="items">
            <div class="horizontal-align">
                <div>
                    Poems
                </div>
                <button class="create-size">
                    Add Poem
                </button>
            </div>
            <div class="bg-clr">
                <ol class="space">
                    <?php foreach ($listofplaylist as $lists): ?>
                        <li><?php echo $lists['title']; ?>
                            <span>
                                <svg width="4" height="8" viewBox="0 0 4 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.10243 2.96037C3.08655 2.96037 3.8917 2.32131 3.8917 1.54024C3.8917 0.759175 3.08655 0.120117 2.10243 0.120117C1.11838 0.120117 0.313232 0.759175 0.313232 1.54024C0.313232 2.32131 1.11838 2.96037 2.10243 2.96037ZM2.10243 4.38051C1.11838 4.38051 0.313232 5.01956 0.313232 5.80061C0.313232 6.58172 1.11838 7.22078 2.10243 7.22078C3.08655 7.22078 3.8917 6.58172 3.8917 5.80061C3.8917 5.01956 3.08655 4.38051 2.10243 4.38051ZM2.10243 8.64089C1.11838 8.64089 0.313232 9.27995 0.313232 10.061C0.313232 10.8421 1.11838 11.4812 2.10243 11.4812C3.08655 11.4812 3.8917 10.8421 3.8917 10.061C3.8917 9.27995 3.08655 8.64089 2.10243 8.64089Z" fill="#D49B92"/>
                                </svg>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>

        <div class="items">
            <div class="horizontal-align">
                <div>
                    Playlists
                </div>
                <button class="create-size">
                    Add Playlist
                </button>
            </div>
            <div class="bg-clr">
                <ol class="space">
                    <?php foreach ($poemtitles as $poemtitle): ?>
                        <li><?php echo $poemtitle['title']; ?>
                            <span>
                                <svg class="trash-button" width="4" height="8" viewBox="0 0 4 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.10243 2.96037C3.08655 2.96037 3.8917 2.32131 3.8917 1.54024C3.8917 0.759175 3.08655 0.120117 2.10243 0.120117C1.11838 0.120117 0.313232 0.759175 0.313232 1.54024C0.313232 2.32131 1.11838 2.96037 2.10243 2.96037ZM2.10243 4.38051C1.11838 4.38051 0.313232 5.01956 0.313232 5.80061C0.313232 6.58172 1.11838 7.22078 2.10243 7.22078C3.08655 7.22078 3.8917 6.58172 3.8917 5.80061C3.8917 5.01956 3.08655 4.38051 2.10243 4.38051ZM2.10243 8.64089C1.11838 8.64089 0.313232 9.27995 0.313232 10.061C0.313232 10.8421 1.11838 11.4812 2.10243 11.4812C3.08655 11.4812 3.8917 10.8421 3.8917 10.061C3.8917 9.27995 3.08655 8.64089 2.10243 8.64089Z" fill="#D49B92"/>
                                </svg>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </div>
</div>

<script src="/js/admin.js"></script>