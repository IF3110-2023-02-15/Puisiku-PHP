DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Poems;
DROP TABLE IF EXISTS Playlists;
DROP TABLE IF EXISTS PlaylistItems;

-- CREATE TABLE
-- Creating the Users table
CREATE TABLE Users (
    id              SERIAL          PRIMARY KEY,
    username        VARCHAR(255)    NOT NULL,
    email           VARCHAR(255)    UNIQUE NOT NULL,
    description     TEXT,
    hashed_password VARCHAR(255)    NOT NULL,
    role            VARCHAR(255)    NOT NULL CHECK(role IN ('admin', 'creator', 'user')),
    image_path      VARCHAR(255)    DEFAULT '/img/default_user.png',
    created_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP
);

-- Creating the Poems table
CREATE TABLE Poems (
    id              SERIAL          PRIMARY KEY,
    title           VARCHAR(255)    NOT NULL,
    creator_id      INTEGER,
    genre           VARCHAR(255)    CHECK(genre IN ('Romantic', 'Patriot', 'Eligi', 'Education', 'Nature', 'Teacher')),
    content         TEXT,
    image_path      VARCHAR(255)    DEFAULT '/img/default_poem.jpg',
    audio_path      VARCHAR(255),
    year            INTEGER         CHECK(year >= 0 AND year <= EXTRACT(YEAR FROM CURRENT_DATE)), -- Add this line
    created_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP       DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (creator_id) REFERENCES Users(id) ON DELETE CASCADE
);

-- Creating the Playlists table
CREATE TABLE Playlists (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    owner_id INTEGER,
    image_path VARCHAR(255) DEFAULT '/img/default_playlist.png',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_id) REFERENCES Users(id) ON DELETE CASCADE
);

-- Creating the PlaylistItems table (to store the relationship between Playlists and Poems)
CREATE TABLE PlaylistItems (
    playlist_id INTEGER,
    poem_id INTEGER,
    PRIMARY KEY (playlist_id, poem_id),
    FOREIGN KEY (playlist_id) REFERENCES Playlists(id) ON DELETE CASCADE,
    FOREIGN KEY (poem_id) REFERENCES Poems(id) ON DELETE CASCADE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- TRIGGERS
-- Triggers to update 'updated_at' column
CREATE OR REPLACE FUNCTION update_modified_column()
RETURNS TRIGGER AS $$
BEGIN
   NEW.updated_at = now(); 
   RETURN NEW;
END;
$$ language 'plpgsql';

CREATE TRIGGER update_user_modtime 
BEFORE UPDATE ON Users 
FOR EACH ROW 
EXECUTE PROCEDURE update_modified_column();

CREATE TRIGGER update_poem_modtime 
BEFORE UPDATE ON Poems 
FOR EACH ROW 
EXECUTE PROCEDURE update_modified_column();

CREATE TRIGGER update_playlist_modtime 
BEFORE UPDATE ON Playlists 
FOR EACH ROW 
EXECUTE PROCEDURE update_modified_column();

-- DATA SEEDING
-- Seeding data into Users table, password is "password"
INSERT INTO Users (username, email, description, hashed_password, role, image_path)
VALUES 

--1 
('Dewi Lestari', 'dewilestari@example.com', 'Hai, my name is Dewi Lestari, i have a creator', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'creator', '/img/dewilestari.jpeg'),

--2
('Sapardi Djoko Damono', 'sapardidjokodamono@example.com', 'Hai, my name is Sapardi Djoko Damono, i have a creator', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'creator', '/img/gusmus.jpeg'),

--3
('Chairil Anwar', 'chairilanwar@example.com', 'Hai, my name is Chairil Anwar, i have a creator', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'creator', '/img/gusmus.jpeg'),

--4
('Kahlil Gibran', 'kahlilgibran@example.com', 'Hai, my name is Kahlil Gibran, i have a creator', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'creator', '/img/gusmus.jpeg'),

--5
('W.S Rendra', 'wsrendra@example.com', 'Hai, my name is W.S Rendra, i have a creator', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'creator', '/img/gusmus.jpeg'),

--6
('Agung Dwi Prasetyo', 'agungdwiprasetyo@example.com', 'Hai, my name is Agung Dwi Prasetyo, i have a creator', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'creator', '/img/agungdwiprasetyo.jpg'),

--7
('Gus Mus', 'gusmus@example.com', 'Hai, my name is Gus mus, i have a creator', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'creator', '/img/gusmus.jpeg'),

--8
('Mochamad Hayyu Al Fatha', 'mochamadhayyu@example.com', 'Hai, my name is Mochamad Hayyu Al Fatha, i have a creator', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'creator', '/img/agungdwiprasetyo.jpg'),

--9
('Taufik Ismail', 'taufikismail@example.com', 'Hai, my name is Taufik Ismail, i have a creator', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'creator', '/img/agungdwiprasetyo.jpg'),

--10
('Halliday Resnick', 'halliday@example.com', 'Hai, my name Halliday, i have a creator', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'creator', '/img/default_user.png'),

--11
('Jeffrey Chow', 'chow@puisiku.com', 'Hi, chow imnida!', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'user', '/img/default_user.png'),

--12
('Aulia MD', 'joli@puisiku.com', 'Hey, konco konco, gw Joli!', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'user', '/img/default_user.png'),

--13
('Tubagus', 'bagus@puisiku.com', 'Halo, gue bagus ges!', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'user', '/img/default_user.png'),

--14
('Admin', 'admin@puisiku.com', 'I am an Admin', '$2y$10$836Iq5/w0DfcI1QExTCgyuNoOpX2curnGwh1KArCRjgdvhmfOJNh6', 'admin', '/img/default_user.png');

-- Seeding data into Poems table
INSERT INTO Poems (title, creator_id, genre, content, image_path, audio_path, year)
VALUES 

-- Genre Romantic
--1
('Aku Ada', 1, 'Romantic',
E'Memanggil namamu ke ujung dunia\n
Tiada yang lebih pilu\n
Tiada yang menjawabku selain hatiku\n
Dan ombak berderu\n
Di pantai ini kau slalu sendiri\n
Tak ada jejakku di sisimu\n
Namun saat ku tiba\n
Suaraku memanggilmu akulah lautan\n
Ke mana kau selalu pulang\n
Jingga di bahuku\n
Malam di depanku\n
Dan bulan siaga sinari langkahku\n
Ku terus berjalan\n
Ku terus melangkah\n
Kuingin kutahu engkau ada\n
Memandangimu saat senja\n
Berjalan di batas dua dunia\n
Tiada yang lebih indah\n
Tiada yang lebih rindu\n
Selain hatiku\n
Andai engkau tahu\n
Di pantai itu kau tampak sendiri\n
Tak ada jejakku di sisimu\n
Namun saat kau rasa\n
Pasir yang kau pijak pergi akulah lautan\n
Memeluk pantaimu erat\n
Jingga di bahumu\n
Malam di depanmu\n
Dan bulan siaga sinari langkahmu\n
Teruslah berjalan\n
Teruslah melangkah\n
Ku tahu kau tahu aku ada.\n', 
'/img/default_poem.jpg', '/audio/audio_1.mp3', 2010),

--2
('Aku Ingin', 2, 'Romantic', 
E'Aku ingin mencintaimu dengan sederhana\n
dengan kata yang tak sempat diucapkan\n
kayu kepada api yang menjadikannya abu\n
Aku ingin mencintaimu dengan sederhana\n
dengan isyarat yang tak sempat disampaikan\n
awan kepada hujan yang menjadikannya tiada\n
Barangkali Telah Kuseka Namamu - Goenawan Mohamad\n
Barangkali telah kuseka namamu\n
dengan sol sepatu\n
Seperti dalam perang yang lalu\n
kauseka namaku\n
Barangkali kau telah menyeka bukan namaku\n
Barangkali aku telah menyeka bukan namamu\n
Barangkali kita malah tak pernah di sini\n
Hanya hutan, jauh di selatan, hujan pagi\n.', 
'/img/default_poem.jpg', '/audio/audio_1.mp3',2011),

--3 
('Cintaku jauh di pulau', 3, 'Romantic',
E'Cintaku jauh di pulau, gadis manis, sekarang iseng sendiri\n
Perahu melancar, bulan memancar di leher kukalungkan ole-ole buat si pacar angin\n
membantu/ laut terang, tapi terasaaku tidak akan sampai padanya.\n
Di air yang tenang, di angin mendayu, di perasaan penghabisan segala melaju. Ajal \n
bertakhta, sambil berkata: "Tujukan perahu ke pangkuanku saja,"\n
Amboi! Jalan sudah bertahun ku tempuh! Perahu yang bersama akan merapuh!\n
Mengapa Ajal memanggil dulu. Sebelum sempat berpeluk dengan cintaku?!\n
Manisku jauh di pulau,kalau aku mati, dia mati iseng sendiri.\n',
'/img/default_poem.jpg', '/audio/audio_1.mp3',2012),

--4
('Cinta yang agung', 4, 'Romantic',
E'Adalah ketika kamu menitikkan air mata\n
dan masih peduli terhadapnya..\n
Adalah ketika dia tidak mempedulikanmu dan kamu masih\n
menunggunya dengan setia..\n
Adalah ketika dia mulai mencintai orang lain\n
dan kamu masih bisa tersenyum sembari berkata Aku\n
turut berbahagia untukmu\n
Apabila cinta tidak berhasil…bebaskan dirimu…\n
Biarkan hatimu kembali melebarkan sayapnya\n
dan terbang ke alam bebas lagi ..\n
Ingatlah…bahwa kamu mungkin menemukan cinta dan\n
kehilangannya..\n
tapi..ketika cinta itu mati..kamu tidak perlu mati\n
bersamanya…\n
Orang terkuat bukan mereka yang selalu menang..\n
melainkan mereka yang tetap tegar ketika\n
mereka jatuh.\n',
'/img/default_poem.jpg', '/audio/audio_1.mp3',2013),

--5
('Episode', 5, 'Romantic',
E'Terkadang ada baiknya kita berduka\n
Agar terasa betapa gembira\n
Pada saatnya kita bersuka\n
Terkadang ada baiknya kita menangis,\n
Agar terasa betapa manis\n
Pada saatnya kita tertawa\n
Terkadang ada baiknya kita merana\n
Agar terasa betapa bahagia\n
Pada saatnya kita bahagia\n
Dan jika sekarang kita berpisah\n
Itupun ada baiknya juga\n
Agar terasa betapa mesra\n
Jika pada saatnya nanti\n
Kita ditakdirkan bertemu lagi.\n', 
'/img/default_poem.jpg', '/audio/audio_1.mp3',2014),

-- Genre Patriot
--6
('Penyelamat Ibu Pertiwi', 6, 'Patriot',
E'Seperti hujan yang turun membasahi bumi\n
Menjadikan tanah kering menjadi subur\n
Seperti itulah para pahlawan\n
Menjadikan negara ini merdeka dari pejajahan\n
Tak terukur perjuangan yang kau lakukan\n
Tak terhitung berapa banyak darah yang tertumpah\n
Demi tercapainya kemerdekaan\n
Demi mengusir para penjajah yang serakah\n
Usai sudah kini perjuanganmu\n
Tinggalah kami di sini yang menikmati\n
Hasil jerih payah engkau dahulu.\n',
'/img/default_poem.jpg', '/audio/audio_1.mp3', 2015),

--7
('Dipenogoro', 7, 'Patriot',
E'Di masa pembangunan ini\n
Tuan hidup kembali\n
Dan bara kagum menjadi api\n
Di depan sekali tuan menanti\n
Tak genta. Lawan banyaknya seratus kali.\n
Pedang di kanan, keris di kiri\n
Berselempang semangat yang tak bisa mati.\n
MAJU\n
Ini barisan tak bergenderang-berpalu\n
Kepercayaan tanda menyerbu\n
Sekali berarti\n
Sudah itu mati\n
MAJU\n
Bagimu Negeri\n
Menyediakan api\n
Punah di atas menghamba\n
inasa di atas ditinda\n
Sungguhpun dalam ajal baru tercapai\n
Jika hidup harus merasai\n
Maju.\n
Serbu.\n
Serang.\n
Terjang.\n
Februari 1943.\n',
'/img/default_poem.jpg', '/audio/audio_1.mp3', 2016),

--8
('Maju Tak Gentar', 8, 'Patriot', 
E'Maju tak gentar\n
Membela yang mungkar.\n
Maju tak gentar\n
Hak orang diserang.\n
Maju tak gentar\n
Pasti kita menang!\n',
'/img/default_poem.jpg', '/audio/audio_1.mp3', 2017),

--9
('Penjajah Harus Pergi dari Indonesia', 9, 'Patriot', 
E'Penjajah itu sudah merusak persatuan\n
Persatuan bangsa Indonesia\n
Karena mereka telah membunuh pahlawanku\n
Mereka juga telah menyengsarakan rakyat Indonesia\n
Maka dari itu kita harus melawan para penjajah\n
Demi Indonesia merdeka kita harus bersatu\n
Agar bangsa Indonesia bisa tetap harmonis\n
Dan bersatu agar bangsa Indonesia\n
Menjadi bangsa yang makmur.\n',
'/img/default_poem.jpg', '/audio/audio_1.mp3', 2017),

--10 
('Sebuah Jaket Berlumur Darah', 10, 'Patriot', 
E'Sebuah jaket berlumur darah\n
Kami semua telah menatapmu\n
Telah pergi duka yang agung\n
Dalam kepedihan bertahun-tahun\n
Sebuah sungai membatasi kita\n
Di bawah terik matahari Jakarta\n
Antara kebebasan dan penindasan\n
Berlapis senjata dan sangkur baja\n
Akan mundurkah kita sekarang\n
Seraya mengucapkan Selamat tinggal perjuangan\n
Berikrar setia kepada tirani\n
Dan mengenakan baju kebesaran sang pelayan?\n
Spanduk kumal itu, ya spanduk itu\n
Kami semua telah menatapmu\n
Dan di atas bangunan-bangunan\n
Menunduk bendera setengah tiang\n
Pesan itu telah sampai kemana-mana\n
Melalui kendaraan yang melintas\n
Abang-abang beca, kuli-kuli pelabuhan\n
Teriakan-teriakan di atas bis kota, pawai-pawai perkasa\n
Prosesi jenazah ke pemakaman\n
Mereka berkata\n
Semuanya berkata\n
Lanjutkan Perjuangan!\n',
'/img/default_poem.jpg', '/audio/audio_1.mp3', 2018),

--Genre Eligi
--11
('Hampa', 1, 'Eligi',
E'Sepi di luar. Sepi menekan mendesak\n
Lurus kaku pohonan. Tak bergerak\n
Sampai ke puncak. Sepi memagut\n
Tak satu kuasa melepas renggut\n
Segala menanti. Menanti. Menanti\n
Sepi\n
Tambah ini menanti jadi mencekik\n
Memberat mencekung punda\n
Sampai binasa segala. Belum apa-apa\n
Udara bertuba. Setan bertampik\n
Ini sepi terus ada. Dan menanti.\n',
'/img/default_poem.jpg', '/audio/audio_2.mp3', 2018),

--12
('Senja Di Pelabuhan Kecil', 2, 'Eligi',
E'Ini kali tidak ada yang mencari cinta\n
Di antara gudang, rumah tua, pada cerita\n
Tiang serta temali.\n
Kapal, perahu tiada berlaut\n
Menghembus diri dalam mempercaya mau berpaut\n
Gerimis mempercepat kelam\n
Ada juga kelepak elang menyinggung muram\n
Desir hari lari berenang menemu bujuk pangkal akanan\n
Tidak bergerak dan kini tanah air tidur hilang ombak\n
Tiada lagi. Aku sendirian.\n
Berjalan menyisir semenanjung\n
Masih pengap harap\n
Sekali tiba di ujung\n
Dan sekalian selamat jalan dari pantai keempat\n
Sedu penghabisan bisa terdekap.\n',
'/img/default_poem.jpg', '/audio/audio_2.mp3',  2018),

--13
('Kesaksian Akhir Abad', 3, 'Eligi',
E'Ratap tangis menerpa pintu kalbuku.\n
Bau anyir darah mengganggu tidur malamku.\n
O, tikar tafakur!\n
O, bau sungai tohor yang kotor!\n
Bagaimana aku akan bisa\n
membaca keadaan ini?\n
Di atas atap kesepian nalar pikiran\n
yang digalaukan oleh lampu-lampu kota\n
yang bertengkar dengan malam,\n
aku menyerukan namamu:\n
wahai para leluhur Nusantara!\n
O, Sanjaya!\n
Leluhur dari kebudayaan tanah.\n
O, Purnawarman!\n
Leluhur dari kebudayaan air!\n
Kedua wangsamu telah mampu\n
mempersekutukan budaya tanah dan air!\n
O, Resi Kuturan! O, Resi Nirarta!\n
Empu-empu tampan yang penuh kedamaian!\n
Telah kamu ajarkan tatanan hidup\n
yang aneka dan sejahtera,\n
yang dijaga oleh dewan hukum adat.\n
O, bagaimana aku bisa mengerti bahasa bising dari\n
bangsaku ini?\n
O, Kajao Laliddo! Bintang cemerlang Tana Ugi!\n
Negarawan yang pintar dan bijaksana!\n
Telah kamu ajarkan aturan permainan\n
di dalam benturan-benturan keinginan\n
yang berbagai ragam\n
di dalam kehidupan:\n
ade, bicara, rapang, dan wari.\n
O, lihatlah wajah-wajah berdarah\n
dan rahim yang diperkosa\n
muncul dari puing-puing tatanan hidup\n
yang porak poranda.\n
Kejahatan kasatmata\n
tertawa tanpa pengadilan.\n
Kekuasaan kekerasan\n
berak dan berdahak\n
di atas bendera kebangsaan.\n
O, anak cucuku di zaman Cybernetic!\n
Bagaimana kalian akan baca prasasti dari zaman kami?\n
Apakah kami akan mampu\n
menjadi ilham bagi kesimpulan\n
ataukah kami justru\n
menjadi sumber masalah\n
di dalam kehidupan?\n
Dengan puisi ini aku bersaksi\n
bahwa rakyat Indonesia belum merdeka.\n
Rakyat yang tanpa hak hukum\n
bukanlah rakyat merdeka.\n
Hak hukum yang tidak dilindungi\n
oleh lembaga pengadilan yang tinggi\n
adalah hukum yang ditulis di atas air.\n',
'/img/default_poem.jpg', '/audio/audio_2.mp3',  2018),

--14
('Sia - Sia', 4, 'Eligi',
E'Penghabisan kali itu kau datang\n
Membawa kembang berkarang\n
Mawar merah dan melati putih\n
Darah dan suci\n
Kau tebarkan depanku\n
Serta pandang yang memastikan: untukmu\n
Lalu kita sama termangu\n
Saling bertanya: apakah ini?\n
Cinta? Kita berdua tak mengerti\n
Sehari kita bersama. Tak gampir-menghampiri.\n
Ah! Hatiku yang tak mau memberi\n
Mampus kau dikoyak-koyak sep.\n',
'/img/default_poem.jpg', '/audio/audio_2.mp3',  2019),

--15
('Eligi Nelayan Tua', 5, 'Eligi',
E'Lelaki tua itu tersengguk-sengguk di emper gubuk\n
Bulan layu rendah di langit\n
Air mulai surut\n
dan terlena digerogoti mimpi\n
Sebentar lagi subuh tiba\n
Inikah impian penghabisan seorang nelayan\n
Kaki dan tangan kaku dibelasah encok\n
Dada seperti terbakar batuk batuk batuk\n
Berteman dengan bulan dan air surut air pasang\n
Kokok ayam dan cicit murai\n
Menyambut pagi\n
Yang bukan lagi miliknya?\n
Panorama masa lalu tergambar di layar langit\n
dengan kail memancing ikan ikan ikan\n
sembilang tenggiri selar dingkis tamban jahan\n
ikan ikan ikan\n
pancing bubu belat kelong jala jaring\n
Selamat tinggal?\n
Encok yang datang marilah kamu\n
Batuk yang masuk teruskan jalanmu\n
ikan-ikan masa lalu\n
ikan-ikanku besok\n
Dan pertarungan akan berlanjut\n
terus!\n', 
'/img/default_poem.jpg', '/audio/audio_2.mp3',  2020),

--Genre Education
--16
('Aku Dan Masa Depanku', 6, 'Education',
E'Ketika sang mentari menampakkan sinarnya\n
Diiringi kicauan burung yang menyapa\n
Detik demi detik yang berbunyi\n
Membangunkanku untuk menggapai cita\n
Buku-buku yang memandangku\n
Seolah tak rela menenggelamkanku dalam angan\n
Kutatap mentari dan berkata\n
Aku siap demi masa depanku\n
Semangat yang membara\n
Membangkitkan jiwa dan raga\n
Lonceng sekolah yang memanggil\n
Adalah awal mengumpulkan ilmu\n
Menuntut ilmu\n
Ialah candu bagiku\n
Menambah kecerdasan\n
Dan menjadi jembatan\n
Akan cita-citaku.\n',
'/img/default_poem.jpg', '/audio/audio_2.mp3',  2021),

--17
('Sumber Ilmuku', 7, 'Education',
E'Di mana?\n
Di sana\n
Bagaimana?\n
Di sana yang terbaik\n
Ya… di sana\n
Di sana aku mendapatkanmu\n
Kamulah sumber ilmuku\n
Ilmu tuk senantiasa terpana\n
Senangkah di sana?\n
Mengapa tidak?\n
Di sana sumber inspirasiku\n
Di sana kutemukan ilmuku\n
Sumber ilmuku\n
Di guruku\n
Di kawanku di orang tuaku.\n',
'/img/default_poem.jpg', '/audio/audio_2.mp3',  2021),

--18
('Pendidikan Dan Harapan', 8, 'Education',
E'Pendidikan adalah tangga harapan\n
Tangga itu menuntun manusia untuk mencapai tujuan\n
Semua manusia berhak untuk menggunakan\n
Untuk mengubah mimpi menjadi kenyataan\n
Tangga itu tidak boleh disembunyikan\n
Dari semua insan yang ingin perubahan\n
Tangga tersebut tidak boleh disalahgunakan\n
Hanya untuk meraih keuntungan\n
Tangga itu harus benar-benar kuat\n
Agar mampu merubah manusia menjadi bermartabat\n
Tangga tersebut harus selalu dirawat\n
Agar bisa membimbing kita meraih akal sehat\n
Tangga itu harus bisa beradaptasi\n
Dari zaman yang begitu kencang berlari\n
Tangga itu tidak boleh dinodai\n
Agar bisa mengantar kita menjadi manusia bermoral yang hakiki.\n',
'/img/default_poem.jpg', '/audio/audio_2.mp3',  2023),

--19
('Perjuangan Meraih Mimpi', 9, 'Education',
E'Sejuta angan dan mimpi\n
Menari di kepalaku\n
Sejuta harapan\n
Bergema di dalam hatiku\n
Ke manakah semua ini kubawa?\n
Kehidupan yang maha keras\n
Menghadang impian dengan batu rintangan\n
Takkan kulepas genggaman mimpiku\n
Melupakan imajinasi sejenak\n
Berjerih payah mewujudkan mimpi\n
Setiap jerih payah pasti terbayar\n
Berikan banyak harapan\n
Semangat perjuangan berkobar\n
Demi mimpi di masa depan\n
Takkan ku berpaling darinya\n
Kan kuraih mimpi setinggi bintang.\n',
'/img/default_poem.jpg', '/audio/audio_2.mp3',  2022),

--20
('Tujuan Ilmu', 10, 'Education',
E'Aku melangkah tanpa arah tujuan\n
Hingga impian menjadi suram\n
Aku berimajinasi seperti elang\n
Hingga rintangan terlihat ringan\n
Aku membuang waktu untuk tujuan\n
Hingga pengetahuan tampak luas dan terang\n
Aku berhasil menuntut ilmu\n
Hingga pekerjaan terasa kesenangan\n
Agar kau damai.\n',
'/img/default_poem.jpg', '/audio/audio_2.mp3',  2022),

--Genre Nature
--21
('Hutan Karet', 1, 'Nature',
E'in memoriam: Sukabumi\n
Daun-daun karet berserakan.\n
Berserakan di hamparan waktu.\n
Suara monyet di dahan-dahan.\n
Suara kalong menghalau petang.\n
Di pucuk-pucuk ilalang belalang berloncatan.\n
Berloncatan di semak-semak rindu.\n
Dan sebuah jalan melingkar-lingkar.\n
Membelit kenangan terjal.\n
Sesaat sebelum surya berlalu\n
masih kudengar suara bedug bertalu-talu.\n',
'/img/default_poem.jpg', '/audio/audio_3.mp3', 2020),

--22
('Taman di Tengah Pulau Karang', 2, 'Nature',
E'Di tengah Manhattan menjelang musim gugur\n
Dalam kepungan rimba baja, pucuknya dalam awan\n
Engkau terlalu bersendiri dengan danau kecilmu\n
Dan perlahan melepas hijau daunan\n
Bebangku panjang dan hitam, lusuh dan retak\n
Seorang lelaki tua duduk menyebar\n
Remah roti. Sementara itu berkelepak\n
Burung-burung merpati\n
Di lingir Manhattan bergelegar pengorek karang\n
Merpati pun kaget beterbangan\n
Suara mekanik dan racun rimba baja\n
Menjajarkan pohon-pohon duka\n
Musim panas terengah melepas napas\n
Pepohonan meratapinya dengan geletar ranting\n
Orang tua itu berkemas dan tersaruk pergi\n
Badai pun memutar daunan dalam kerucut\n
Makin meninggi.\n
1963.\n',
'/img/default_poem.jpg', '/audio/audio_3.mp3', 2022),

--23
('Dua Gunung  Bicara Padaku', 3, 'Nature',
E'Kepada Singgalang bertanya aku\n
Wahai gunung masa kanakku di lututmu kampung ibuku\n
Kenapa indahmu dari dahulu tak habis-habis jadi rinduku\n
kepada Merapi berkata aku\n
Wahai gunung masa bayiku di telapakmu kampung ayahku\n
Kenapa gagahmu dari dahulu tak habis-habis dari ingatanku\n
Kedua gunung tentu saja\n
Cuaca dingin bahasanya\n
Kabut putih kosa katanya\n
Rintik hujan ungkapnnya\n
Senyap biru bisikannya\n
Kepada dua gunung kuulang tanya\n
Berjawab lewat desahan jutaan daun rimba raya\n
Bergema begitu indahnya lewat margasatwa\n
Ombak nyanyian insekta betapa merdunya\n
Bertanyalah pada Yang Di Atas Sana.\n',
'/img/default_poem.jpg', '/audio/audio_3.mp3', 2018),

--24
('Hatiku Selembar Daun', 4, 'Nature',
E'Hatiku selembar daun\n
melayang jatuh di rumput\n
Nanti dulu\n
biarkan aku sejenak terbaring di sini\n
ada yang masih ingin kupandang\n
yang selama ini senantiasa luput\n
Sesaat adalah abadi\n
sebelum kau sapu tamanmu setiap pagi\n
Hanya\n
hanya suara burung yang kau dengar\n
dan tak pernah kau lihat burung itu\n
tapi tahu burung itu ada di sana\n
hanya desir angin yang kau rasa\n
dan tak pernah kau lihat angin itu\n
tapi percaya angin itu di sekitarmu\n
hanya doaku yang bergetar malam ini\n
dan tak pernah kau lihat siapa aku\n
tapi yakin aku ada dalam dirimu.\n',
'/img/default_poem.jpg', '/audio/audio_3.mp3', 2019),

--25
('Pancuran 7 Abadi', 5, 'Nature',
E'Desir angin sepoi menghembus perlahan\n
Bersama nyanyian burung di pucuk dahan\n
Airmu menari-nari dalam nestapa\n
Mencairkan luka oleh karena cinta\n
Tercium bau yang harum menawan\n
Bau harum airmu memecahkan qalbu buana\n
Tahukah kau akan qalbu buana itu?\n
Yaitu qalbu yang dirundung duka dan nestapa\n
Oh… nirwana puncak Gunung Slamet\n
Kaulah tempat kami mengingat sang Kuasa\n
Melepaskan jiwa yang bermuram durja\n
Dan merenungkan masa jaya\n
Selain air terjunmu yang menawan\n
Terdapat mata air panas yang bersahaja\n
Membuat kita bersatu dengan malam\n
Apalagi malam Jumat orang Jawa\n
Teruslah abadi kau Pancuran ketujuh\n
Bersama keenam Pancuran di bawah sana\n
Pancarkan sinar keemasan dalam airmu!\n',
'/img/default_poem.jpg', '/audio/audio_3.mp3', 2022),

--Genre Teacher 
--26
('Guru', 6, 'Teacher',
E'Barang siapa mau menjadi guru\n
Biarlah dia memulai mengajar dirinya sendiri\n
Sebelum mengajar orang lain\n
Dan biarkan pula dia mengajar dengan teladan\n
Sebelum mengajar dengan kata-kata\n
Sebab, mereka yang mengajar dirinya sendiri\n
Dengan membenarkan perbuatan-perbuatan sendiri\n
Lebih berhak atas penghormatan dan kemuliaan\n
Daripada mereka yang hanya mengajar orang lain\n
Dan membenarkan perbuatan-perbuatan orang lain.\n',
'/img/default_poem.jpg', '/audio/audio_3.mp3', 2020),

--27
('Maha Guru', 7, 'Teacher',
E'Bila mentari menyapa pagi\n
Semangat ceria selalu mengiringi\n
Bukan harta benda yang kau cari\n
Tapi pada sang ilmu kau mengabdi\n
Seperti ismanya menuntun langkah menuntun langkah\n
Menanggal jemawa memajukan peradaban manusia\n
Berlogika hati, luas ilmu, bijak bertindak\n
Bukan ajarkan basa-basi yang kau beri\n
Tapi sikap kritis yang kau hadirkan di sini\n
Meskipun kerikip caci maki kadang kau temui\n
Hormatku untukmu maha guru\n
Bintang yang tak pernah lelah memandu\n
Saat perahuku mengarung samudra.\n',
'/img/default_poem.jpg', '/audio/audio_3.mp3', 2018),

--28
('Guru', 7, 'Teacher',
E'Hangat senyummu menjadi pembuka hati kami\n
Amarahmu adalah cambuk belaian kasih bagi kami\n
Suaramu menggiring amu ke masa depan yang terang\n
Wahai sang guru..\n
Kaulah teladan, pengajar, dan pembimbing kami\n
Guratan pengabdianmu membekas pada jiwa kami\n
Hanya doa yang tulus dan semangat negeri sebagai balas jasamu\n
Terima kasih Guru\n
Semoga kebahagiaan selalu mendekapmu.\n',
'/img/default_poem.jpg', '/audio/audio_3.mp3', 2017),

--29
('Kepada Guruku', 8, 'Teacher',
E'Kulihat kau berdiri di pelupuk mataku\n
Menyampaikan pesan waktu\n
Tatkala tatapan bertemu\n
Aku menangkap sejuta cahaya darimu\n
Cahaya ilmu kian merasuk ke benakku\n
Bahkan aku berharap ia menjadi segumpal daging\n
Kau pelita di hitam legamnya jiwaku\n
Laksana tetesan air di gersangnya gurun pasir\n
Duhai guruku\n
Kau taman kehidupan\n
Berjuta ilmu kau tanamkan\n
Tanpa lelah dan putus asa\n
Berjuang mencerdaskan generasi bangsa\n
Kau mempunyai laut yang terpenuhi dengan mutiara-mutiara ilmu\n
Izinkan aku melayarinya, sehingga matiku penuh ketenangan\n
Hidupmu penuh perjuangan\n
Maka, tak berdosa jika aku memberimu gelar pahlawan.\n',
'/img/default_poem.jpg', '/audio/audio_3.mp3', 2023),

--30
('Sang Guru', 3, 'Teacher',
E'Tentang kegelapan\n
Tentang buta pada zaman dahulu kala\n
Tentang kebodohan yang merajalela\n
Dan tentang sosok penumpas itu semua\n
Ialah sang guru\n
Sosok yang ikhlas berbagi ilmu\n
1, 2, 3 ,4 dan seterusnya\n
Harapnya tetap tak lekang dimakan usia\n
Tetap tak basi dari sebuah tradisi\n
Dia tetap mulia\n
Dengan segala wibawanya\n
Masa depan?\n
Jangan kau tanyakan\n
Aku dan kamulah sang harapan\n
Menjadi lebih hebat dari apa yang ia ajarkan\n
Maka genggamlah apa yang ia percayakan.\n',
'/img/default_poem.jpg', '/audio/audio_3.mp3', 2016);

-- Seeding data into Playlists table
INSERT INTO Playlists (title, owner_id, image_path)
VALUES 
('Epic Journeys', 11, '/img/default_playlist.png'),
('Romantic Musings', 12, '/img/default_playlist.png'),
('Sad Goodbyes', 13, '/img/default_playlist.png'),
('Nature in Verse', 11, '/img/default_playlist.png'),
('Powerful Forces of Nature ', 12, '/img/default_playlist.png');

-- Seeding data into PlaylistItems table
INSERT INTO PlaylistItems (playlist_id, poem_id)
VALUES 
(1, 1),
(1, 5),
(2, 2),
(3, 3),
(4, 4),
(5, 1),
(5, 5),
(1, 11),
(1, 15),
(2, 12),
(3, 13),
(4, 14),
(5, 11),
(5, 15);
