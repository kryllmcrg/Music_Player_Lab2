<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #F0F3F4;
            padding: 20px;
        }

        h1 {
            color: #007bff;
            margin-top: 20px;
        }

        #player-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #FFFFFF;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        audio {
            width: 100%;
            margin-top: 20px;
        }

        #playlist {
            list-style: none;
            padding: 0;
            margin-top: 20px;
        }

        #playlist li {
            cursor: pointer;
            padding: 10px;
            background-color: #F5F5F5;
            margin: 5px 0;
            transition: background-color 0.2s ease-in-out;
            border-radius: 5px;
        }

        #playlist li:hover {
            background-color: #ECF2FF;
        }

        #playlist li.active {
            background-color: #007bff;
            color: #fff;
        }

        form {
            text-align: center;
            margin: 20px;
        }

        /* Style the search input */
        input[type="search"] {
            padding: 10px;
            width: 300px;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Style the search button */
        button.btn-primary {
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin: 7px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        /* Style the button on hover */
        button.btn-primary:hover {
            background-color: #0056b3;
        }

        /* Modal styles */
        .modal-body {
            background-color: #F5F5F5;
        }

        .modal-content {
            border-radius: 10px;
        }

        .modal-title {
            color: #007bff;
        }

        .btn-close {
            color: #007bff;
        }

        /* Button styles */
        .btn {
            margin: 10px;
        }
    </style>
</head>

<body>
     <!-- //my addsong -->
    <div class="modal fade" id="addsongs" tabindex="-1" aria-labelledby="addsongs" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Song</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <br>

                    <form action="/addsong" method="post" enctype="multipart/form-data">
                        <input type="file" name="music">
                        <button type="submit">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <a href="#" data-bs-dismiss="modal">Close</a>
                </div>
            </div>
        </div>
    </div>


    <!-- //add to playlist modal -->
    <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggle">My Playlist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-content">

                    <div class="modal-body">

                        <?php foreach ($playlist as $item): ?>
                            <br>
                            <a href="/playlist/<?= $item['id'] ?>">
                                <?= $item['name'] ?>
                            </a>

                            <br>
                        <?php endforeach ?>


                    </div>
                    <div class="modal-footer">
                        <a href="#" data-bs-dismiss="modal">Close</a>
                        <a href="#" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Create New</a>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">Add to playlist</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/createPlaylist" method="post">
                        <input type="text" name="pname">
                        <button type="submit">Submit</button>
                    </form>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal"
                        data-bs-dismiss="modal">Back to first</button>
                </div>
            </div>
        </div>
    </div>
    <!-- //add to playlist modal end -->

       <!-- //main view :> -->
       <form action="/" method="get">
        <input type="search" name="search" placeholder="Search for a song">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <h1>Music Player</h1>
    <div class="d-flex justify-content-center">
        <a class="btn btn-primary m-2" data-bs-toggle="modal" href="#exampleModalToggle" role="button">Open Playlist</a>
        <a class="btn btn-primary m-2" data-bs-toggle="modal" href="#addsongs" role="button">Upload Songs</a>
    </div>
    <audio id="audio" controls autoplay></audio>
    <!-- Music List -->
<ul id="playlist">
    <?php foreach ($music as $music_item): ?>
        <li data-src="<?= base_url() ?>upload/<?= $music_item['file_path'] ?>">
            <?= $music_item['title'] ?>
            <button class="add-to-playlist btn btn-secondary btn-sm" data-music-id="<?= $music_item['id'] ?>">
                Add to Playlist
            </button>
        </li>
    <?php endforeach ?>
</ul>



    <!-- //add to playlist -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Select from Playlist</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <form action="/" method="post">
                        <!-- <p id="modalData"></p> -->
                        <input type="hidden" id="musicID" name="musicID">
                        <select name="playlist" class="form-control">

                          <? foreach($playlist as $item): ?>
                            <OPTION><?=$item['name']?></OPTION>
                            <? endforeach ?>

                        </select>
                        <input type="submit" name="add">
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            // Get references to the button and modal
            const modal = $("#myModal");
            const modalData = $("#modalData");
            const musicID = $("#musicID");
            // Function to open the modal with the specified data
            function openModalWithData(dataId) {
                // Set the data inside the modal content
                modalData.text("Data ID: " + dataId);
                musicID.val(dataId);
                // Display the modal
                modal.css("display", "block");
            }

            // Add click event listeners to all open modal buttons

            // When the user clicks the close button or outside the modal, close it
            modal.click(function (event) {
                if (event.target === modal[0] || $(event.target).hasClass("close")) {
                    modal.css("display", "none");
                }
            });
        });
    </script>
    <script>
    $(document).ready(function () {
        // Handle the "Add to Playlist" button click event
        $(".add-to-playlist").click(function () {
            // Get the music ID and set it as the value of the hidden input field in the modal
            var musicId = $(this).data("music-id");
            $("#musicID").val(musicId);

            // You can also dynamically populate the select dropdown with playlists here if needed

            // Show the modal
            $("#myModal").modal("show");
        });

        // Handle the modal close event
        $("#myModal").on("hidden.bs.modal", function () {
            // Clear the hidden input field when the modal is closed
            $("#musicID").val("");
        });
    });
</script>


    <script>
        const audio = document.getElementById('audio');
        const playlist = document.getElementById('playlist');
        const playlistItems = playlist.querySelectorAll('li');

        let currentTrack = 0;

        function playTrack(trackIndex) {
            if (trackIndex >= 0 && trackIndex < playlistItems.length) {
                const track = playlistItems[trackIndex];
                const trackSrc = track.getAttribute('data-src');
                audio.src = trackSrc;
                audio.play();
                currentTrack = trackIndex;
            }
        }

        function nextTrack() {
            currentTrack = (currentTrack + 1) % playlistItems.length;
            playTrack(currentTrack);
        }

        function previousTrack() {
            currentTrack = (currentTrack - 1 + playlistItems.length) % playlistItems.length;
            playTrack(currentTrack);
        }

        playlistItems.forEach((item, index) => {
            item.addEventListener('click', () => {
                playTrack(index);
            });
        });

        audio.addEventListener('ended', () => {
            nextTrack();
        });

        playTrack(currentTrack);
    </script>
     

</body>
</html>