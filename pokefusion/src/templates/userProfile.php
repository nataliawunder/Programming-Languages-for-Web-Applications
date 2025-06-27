<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <!--
        Contributions: 
        Natalia: Home, Login, Register, User Profile, Gallery (HTML, CSS, JS, PHP)
        Azka: Home, Login, Register, Play implementation (HTML, CSS, JS, PHP)
    -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="description" content="User Profile of Pokéfusion">
    <meta name="author" content="Natalia Wunder and Azka Chaudhry">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="Pokéfusion">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://img.icons8.com/?size=100&id=60923&format=png&color=000000">
    <meta property="og:url" content="https://cs4640.cs.virginia.edu/xax8gw/hw2/">
    <meta property="og:description"
        content="Website for CS 4640 hosting a drawing game where users draw the fusion of two Pokémon given their sprites.">
    <meta property="og:site_name" content="Pokéfusion">

    <title>User Profile Screen for Pokéfusion</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="styles/main.css">
    <script src="https://cdn.jsdelivr.net/npm/less"></script>
</head>

<body data-new-gr-c-s-check-loaded="14.1093.0" data-gr-ext-installed="">
    <nav class="navbar navbar-expand-md">
        <div class="container-fluid">
            <a class="navbar-brand" href="?command=homeLoggedIn">Pokéfusion</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="?command=homeLoggedIn">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="?command=userProfile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?command=gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?command=play">Play</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?command=logout">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="mx-3">
        <h1 class="display-6 pt-3 mt-5"><span class="first-word"><?= $username ?>'s</span> Profile</h1>
        <hr>
        <div class="text-center">
            <?= $message ?>
        </div>
    </header>

    <div id="userInfoContainer" class="mb-4">
        <div id="userInfo">...</div>
    </div>

    <nav class="navbar">
        <div class="container-fluid">
            <form class="d-flex w-100 form-group" method="GET">
                <input type="hidden" name="command" value="userProfile">
                <input class="form-control me-2 flex-fill" type="search" name="search"
                    placeholder="Search drawings by title" aria-label="Search">
                <button class="btn" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div id="drawingHolder" class="d-flex justify-content-center align-items-start flex-wrap row mt-3">
        <?php if (empty($drawings)): ?>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 d-flex justify-content-center">
                <p class='alert alert-danger'>No drawings found.</p>
            </div>
        <?php else: ?>
            <?php foreach ($drawings as $drawing): ?>
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card mb-3 drawing-card"
                        data-title="<?= htmlspecialchars($drawing['title']) ?>"
                        data-img="<?= htmlspecialchars($drawing['img_url']) ?>"
                        data-rating="<?= intval($drawing['rating']) ?>"
                        data-id="<?= $drawing['id'] ?>"
                        style="max-width: 18rem; cursor: pointer;">
                        <div class="card-body text-center">
                            <h5 class="card-title mt-3"><?= htmlspecialchars($drawing['title']) ?></h5>
                            <p>Rating: <?php
                                $rating = intval($drawing['rating']);
                                if (intval($drawing['rating']) != 0) {
                                    echo str_repeat("⭐", $rating);
                                } else {
                                    echo "Unrated";
                                }
                                ?>
                            </p>
                        </div>
                        <img src="<?= htmlspecialchars($drawing['img_url']) ?>" class="card-img-bottom" alt="Fusion of <?= $drawing['title'] ?>">
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>


    <div class="container">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="?command=homeLoggedIn" class="nav-link px-2 text-muted">Home</a></li>
                <li class="nav-item"><a href="?command=userProfile" class="nav-link px-2 text-muted">Profile</a></li>
                <li class="nav-item"><a href="?command=gallery" class="nav-link px-2 text-muted">Gallery</a></li>
                <li class="nav-item"><a href="?command=play" class="nav-link px-2 text-muted">Play</a></li>
                <li class="nav-item"><a href="?command=logout" class="nav-link px-2 text-muted">Log Out</a></li>
            </ul>
            <p class="text-center text-muted">© 2025 Pokéfusion</p>
            <p class="text-center text-muted">This website is not affiliated with, endorsed, or sponsored by The Pokémon
                Company. Pokémon and all related media are trademarks of The Pokémon Company.</p>
        </footer>
    </div>

    <div class="modal fade" id="drawingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="drawingModalTitle">Drawing Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="drawingModalImage" src="" class="img-fluid mb-3" alt="Fusion Image">
                    <h4 id="drawingModalInfo"></h4>
                    <h5 id="drawingModalRating"></h5>
                </div>
                <div class="modal-footer">
                    <form method="POST" action="?command=userProfile">
                        <input type="hidden" id="drawingModalDeleteId" name="drawingToDelete" value="">
                        <button type="submit" class="btn btn-danger">Delete Drawing</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            modal = new bootstrap.Modal(document.getElementById("drawingModal"));
            modalTitle = document.getElementById("drawingModalTitle");
            modalImg = document.getElementById("drawingModalImage");
            modalInfo = document.getElementById("drawingModalInfo");
            modalRating = document.getElementById("drawingModalRating");
            deleteInput = document.getElementById("drawingModalDeleteId");

            document.querySelectorAll(".drawing-card").forEach(card => {
                card.addEventListener("click", function() {
                    title = this.getAttribute("data-title");
                    img = this.getAttribute("data-img");
                    rating = this.getAttribute("data-rating");
                    id = this.getAttribute("data-id");

                    modalTitle.innerText = title;
                    modalImg.src = img;
                    modalImg.alt = "Fusion of " + title;
                    modalInfo.innerText = "Fusion of Pokémon: " + title;
                    if (rating != 0) {
                        modalRating.innerText = "Rating: " + "⭐".repeat(rating);
                    }
                    else {
                        modalRating.innerText = "Rating: Unrated";
                    }
                    
                    deleteInput.value = id;

                    modal.show();
                });
            });

            async function userInfo() {
                try {
                    const response = await fetch('?command=userInfoAPI');
                    const data = await response.json();
                    const userInfoElement = document.getElementById('userInfo');
                    userInfoElement.innerHTML = `
                    <ul>
                        <li class="list-group-item"><strong>Email:</strong> ${data.email}</li>
                        <li class="list-group-item"><strong>User ID:</strong> ${data.user_id}</li>
                    </ul>
                `;
                } catch (error) {
                    console.error('Error fetching user info:', error);
                    document.getElementById('userInfo').textContent = 'Error loading user information.'; 
                }
            }
            userInfo();
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>