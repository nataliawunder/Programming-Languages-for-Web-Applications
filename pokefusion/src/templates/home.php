<!DOCTYPE html>
<!-- https://cs4640.cs.virginia.edu/xax8gw/pokefusion/ -->
<!--
Sources used: https://cs4640.cs.virginia.edu, https://getbootstrap.com/docs/4.0/utilities/spacing/, https://getbootstrap.com/docs/4.0/utilities/visibility/, https://getbootstrap.com/docs/4.0/utilities/flex/, https://getbootstrap.com/docs/4.0/components/card/, https://getbootstrap.com/docs/4.0/components/carousel/, https://getbootstrap.com/docs/4.0/components/dropdowns/, https://getbootstrap.com/docs/4.0/components/forms/, https://getbootstrap.com/docs/4.0/components/input-group/, https://getbootstrap.com/docs/4.0/components/navbar/, https://www.w3schools.com/cssref/css3_pr_flex.php, https://www.w3schools.com/cssref/index.php, https://www.w3schools.com/css/css_pseudo_classes.asp, https://www.w3schools.com/cssref/css3_pr_filter.php,   
Website link: https://cs4640.cs.virginia.edu/xax8gw/sprint2/
-->

<html lang="en" data-bs-theme="dark">
    <head>
        <!--
            Contributions: 
            Natalia: Home, Login, Register, User Profile, Gallery (HTML, CSS, JS, PHP)
            Azka: Home, Login, Register, Play implementation (HTML, CSS, JS, PHP)
        -->
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Natalia Wunder and Azka Chaudhry">
        <meta name="description" content="Home page for Pokéfusion">
        <meta name="keywords" content="Pokémon Drawing Fusion Game">

        <meta property="og:title" content="Pokéfusion">
        <meta property="og:type" content="website">
        <meta property="og:image" content="https://img.icons8.com/?size=100&id=60923&format=png&color=000000">
        <meta property="og:url" content="https://cs4640.cs.virginia.edu/xax8gw/hw2/">
        <meta property="og:description"
        content="Website for CS 4640 hosting a drawing game where users draw the fusion of two Pokémon given their sprites.">
        <meta property="og:site_name" content="Pokéfusion">

        <title>Pokéfusion Home Page</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <style>
            .modal-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-color: rgba(0, 0, 0, 0.4);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 1050;
            }

            #imageModal .card {
                background-color: #371f25
            }
                
            .modal-card {
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
                border-radius: 0.75rem;
            }
        </style>
        <link rel="stylesheet" href="styles/main.css">
        <script src="https://cdn.jsdelivr.net/npm/less"></script>
    </head>

    <body data-new-gr-c-s-check-loaded="14.1093.0" data-gr-ext-installed="">

        <nav class="navbar navbar-expand-md">
            <div class="container-fluid">
                <a class="navbar-brand" href="?command=home">Pokéfusion</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="?command=home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?command=register">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?command=login">Log In</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-3 text-center">
            <h1 class="display-4 pt-3"><span class="first-word">POKÉ</span>FUSION</h1>
            <p class="col-md-10 fs-4 text-center">Draw and share your Pokémon fusions with others!</p>
            <hr>
        </div>

        <div class="container">
            <div id="homeContainer" class="d-flex justify-content-center flex-wrap row mt-3">
                <div class="col-lg-3 col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card mb-3" style="width: 18rem;">
                        <img src="images/magikarpmachamp.png" class="card-img-top" alt="Fusion of Magikarp and Machamp">
                        <div class="card-body">
                            <p class="card-text" style="padding: 1rem;">Here is a fusion of Magikarp and Machamp.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card mb-3" style="width: 18rem;">
                        <img src="images/staryukrabby.png" class="card-img-top" alt="Fusion of Staryu and Krabby">
                        <div class="card-body">
                            <p class="card-text" style="padding: 1rem;">Here is a fusion of Staryu and Krabby.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 d-flex justify-content-center">
                    <div class="card mb-3" style="width: 18rem;">
                        <img src="images/raticatebellsprout.png" class="card-img-top" alt="Fusion of Raticate and Bellsprout.">
                        <div class="card-body">
                            <p class="card-text" style="padding: 1rem;">Here is a fusion of Raticate and Bellsprout.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion my-4" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            How to Register
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>To register, click the button below and type in your username, password, and email.</p>
                            <a href="?command=register" class="btn btn-sm">Register</a>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            How to Log In
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>By logging in, you can save and view your previous fusions you created in your profile, as well as view fusions others have created.</p>
                            <a href="?command=login" class="btn btn-sm">Log In</a>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Gameplay Rules
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            In Pokéfusion, the goal of the game is for players to creatively fuse two Pokémon into a single 
                            design. Each player is presented with the sprites of two randomly selected Generation 1 Pokémon, 
                            which they must creatively combine into one unique design. Once the drawing is complete, 
                            it can be saved and shared in the Pokéfusion Gallery, where other players can view and 
                            rate the fusion. Players can browse the gallery, leave ratings, and draw inspiration from the community's most popular fusions. You must register and log in first.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            Drawing Etiquette
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            While drawing, players are encouraged to express their creativity in fun and respectful ways. Please avoid submitting inappropriate, offensive, or disruptive content. Drawings should focus on fusing the two given Pokémon and reflect the spirit of the game. Remember, your creations will be shared in the Pokéfusion Gallery, so be considerate of others in the community.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            Sample Pokémon
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Pokéfusion will be pulling exclusively from the pool of Generation 1 Pokémon
                            like the following!
                            <div id="rapidashCard" class="card my-3 p-3">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <img src="images/rapidash.png" class="img-fluid rounded-start"
                                            alt="sprite of the pokemon Rapidash">
                                    </div>
                                    <div class="col-md-8 ">
                                        <div class="card-body">
                                            <h5 class="card-title">Rapidash</h5>
                                            <p class="card-text">When at an all-out gallop, its blazing mane
                                                sparkles, enhancing its beautiful appearance.</p>
                                            <p class="card-text"><small class="text-body-secondary">Type:
                                                    Fire</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-lg" style="max-width: 1000px;">
                <div id="carouselExampleIndicators" class="carousel slide mt-5" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="images/electrodegeodude.png" class="d-block w-100 resize" alt="Fusion of Electrode and Geodude.">
                        </div>
                        <div class="carousel-item">
                            <img src="images/voltorbmetapod.png" class="d-block w-100 resize" alt="Fusion of Voltorb and Metapod.">
                        </div>
                        <div class="carousel-item">
                            <img src="images/executorrapidash.png" class="d-block w-100 resize"
                                alt="Fusion of Exeggutor and Rapidash.">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="container">
            <footer class="py-3 my-4">
                <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                    <li class="nav-item"><a href="?command=home" class="nav-link px-2 text-muted">Home</a></li>
                    <li class="nav-item"><a href="?command=register" class="nav-link px-2 text-muted">Register</a></li>
                    <li class="nav-item"><a href="?command=login" class="nav-link px-2 text-muted">Log In</a></li>
                </ul>
                <p class="text-center text-muted">© 2025 Pokéfusion</p>
                <p class="text-center text-muted">This website is not affiliated with, endorsed, or sponsored by The Pokémon
                    Company. Pokémon and all related media are trademarks of The Pokémon Company.</p>
            </footer>
        </div>

        <div id="imageModal" class="modal-overlay" style="display: none;">
            <div class="card modal-card" style="width: 22rem;">
                <img id="modalImage" class="card-img-top" src="" alt="Fusion Image">
                <div class="card-body">
                <p id="modalCaption" class="card-text" style="padding: 1rem;"></p>
                </div>
            </div>
        </div>

        <script>
            // arrow functions yay
            (() => {
                const modal = document.getElementById("imageModal");
                const modalImg = document.getElementById("modalImage");
                const modalCaption = document.getElementById("modalCaption");
              
                document.querySelectorAll(".card-img-top").forEach(img => {
                  img.addEventListener("click", () => {
                    modalImg.src = img.src;
                    const textElement = img.closest(".card").querySelector(".card-text");
                    let caption = "";
                    if (textElement) {
                      caption = textElement.innerText;
                    }
                    modalCaption.textContent = caption;
                    modal.style.display = "flex";
                  });
                });
              
                modal.addEventListener("click", click => {
                  if (!click.target.closest(".modal-card")) {
                    modal.style.display = "none";
                  }
                });
            })();
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>

    </body>
</html>