<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <!--
        Sources used:https://webdevtales.com/build-a-canvas-drawing-app-javascript-10-minutes/
                     https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API/Using_Fetch
    -->
    <!--
        Contributions: 
        Natalia: Home, Login, Register, User Profile, Gallery (HTML, CSS, JS, PHP)
        Azka: Home, Login, Register, Play implementation (HTML, CSS, JS, PHP)
    -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="description" content="Play Screen for Pokéfusion">
    <meta name="author" content="Natalia Wunder and Azka Chaudhry">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:title" content="Pokéfusion">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://img.icons8.com/?size=100&id=60923&format=png&color=000000">
    <meta property="og:url" content="https://cs4640.cs.virginia.edu/xax8gw/hw2/">
    <meta property="og:description"
        content="Website for CS 4640 hosting a drawing game where users draw the fusion of two Pokémon given their sprites.">
    <meta property="og:site_name" content="Pokéfusion">

    <title>Play screen for Pokéfusion</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

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
                        <a class="nav-link" href="?command=homeLoggedIn">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?command=userProfile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?command=gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="?command=play">Play</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?command=logout">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="mx-3">
        <h1 class="display-5 text-center pt-3 mt-5"><span class="first-word">Poke</span>fusion</h1>
        <hr>
    </header>

    <div class="container">
        <div id="alertContainer" class="mb-3"></div>
        <div class="card mb-3">
            <div class="card-body text-center">
                <h4 class="mb-0">Fusion prompt: <span class="fw-bold"><?php echo $pokemon1 . " + " . $pokemon2; ?></span></h4>
            </div>
        </div>

        <div class="row g-2">
            <div class="col-lg-3 col-sm-12 d-sm-block">
                <!-- <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Players</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <div class="ms-2 flex-grow-1">
                                    <div class="fw-bold">Player 1</div>
                                    <div class="small">3500 points</div>
                                </div>
                                <span class="badge bg-danger">Drawing</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <div class="ms-2 flex-grow-1">
                                    <div class="fw-bold">Player 2</div>
                                    <div class="small">5500 points</div>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <div class="ms-2 flex-grow-1">
                                    <div class="fw-bold">Player 3</div>
                                    <div class="small">300 points</div>
                                </div>
                            </li>
                        </ul>
                    </div> -->
                <div class="card">
                    <div class="card-body text-center">
                        <img src="<?php echo $imageSrc1; ?>" alt="<?php echo $pokemon1; ?>" class="img-fluid">
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body text-center">
                        <img src="<?php echo $imageSrc2; ?>" alt="<?php echo $pokemon2; ?>" class="img-fluid">
                    </div>
                </div>
            </div>

            <div class="col-lg-9 col-sm-12">
                <div class="card mb-3">
                    <canvas id="drawingCanvas" height="475" aria-label="Canvas to Draw Fusion" role="img" tabindex="0"></canvas>
                    <div class="drawing-toolbar card-footer d-flex flex-wrap justify-content-center gap-2 p-2 align-items-center">
                        <input type="color" value="#000000" class="form-control form-control-color" title="Choose drawing color" id="colorPicker">
                        <div class="px-3">
                            <input type="range" min="1" max="50" value="5" class="form-range" style="width: 100px;" title="Adjust brush size" id="sizeSlider">
                            <div id="brushSizeDisplay">Brush size: 5</div>
                        </div>
                        <button class="btn btn-sm" id="clearBtn">Clear</button>
                        <button class="btn btn-sm" id="undoBtn">Undo</button>
                        <button class="btn btn-sm" id="saveBtn">Save</button>
                    </div>
                </div>
                <!-- <div class="container-fluid">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-auto mb-3">
                                <label class="visually-hidden" for="selectPokemon1">Preference</label>
                                <select class="form-select" id="selectPokemon1">
                                    <option selected disabled>Choose...</option>
                                    <?php
                                    foreach ($allPokemon as $pokemon) {
                                        echo "<option value=\"$pokemon\">$pokemon</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-auto mb-3 text-center">
                                +
                            </div>
                            <div class="col-auto mb-3">
                                <label class="visually-hidden" for="selectPokemon2">Preference</label>
                                <select class="form-select" id="selectPokemon2">
                                    <option selected disabled>Choose...</option>
                                    <?php
                                    foreach ($allPokemon as $pokemon) {
                                        echo "<option value=\"$pokemon\">$pokemon</option>";
                                    }
                                    ?>
                                </select>
                            </div>
    
                            <div class="col-auto mb-3 text-center">
                                <input class="btn btn-sm" type="submit" value="Submit">
                            </div>
                        </div>
                    </div> -->
            </div>

            <!-- <div class="col-lg-3 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Chat</h5>
                        </div>
                        <div class="card-body p-2">
                            <div class="border p-2 mb-2 small">
                                <div class="mb-2">
                                    <strong>Player 1:</strong> lorem ipsum something something something
                                </div>
                                <div class="mb-2">
                                    <strong>Player 2:</strong> wow
                                </div>
                            </div>
                            <div class="input-group form-group">
                                <input type="text" class="form-control" placeholder="Type a message...">
                                <button class="btn" type="button">Send</button>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0">Players</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <div class="ms-2 flex-grow-1">
                                    <div class="fw-bold">Player 1</div>
                                    <div class="small">3500 points</div>
                                </div>
                                <span class="badge bg-danger">Drawing</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <div class="ms-2 flex-grow-1">
                                    <div class="fw-bold">Player 2</div>
                                    <div class="small">5500 points</div>
                                </div>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <div class="ms-2 flex-grow-1">
                                    <div class="fw-bold">Player 3</div>
                                    <div class="small">300 points</div>
                                </div>
                            </li>
                        </ul>
                </div> -->
        </div>

    </div>

    <div class="container">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="?command=homeLoggedIn" class="nav-link px-2 text-muted">Home</a></li>
                <li class="nav-item"><a href="?command=gallery" class="nav-link px-2 text-muted">Gallery</a></li>
                <li class="nav-item"><a href="?command=userProfile" class="nav-link px-2 text-muted">Profile</a></li>
                <li class="nav-item"><a href="?command=play" class="nav-link px-2 text-muted">Play</a></li>
                <li class="nav-item"><a href="?command=logout" class="nav-link px-2 text-muted">Log Out</a></li>
            </ul>
            <p class="text-center text-muted">© 2025 Pokéfusion</p>
            <p class="text-center text-muted">This website is not affiliated with, endorsed, or sponsored by The Pokémon
                Company. Pokémon and all related media are trademarks of The Pokémon Company.</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('drawingCanvas');
            const ctx = canvas.getContext('2d');

            //initial state
            let painting = false;
            // let brushColor = '#000000';
            // let brushSize = 5;
            let drawnShapes = [];
            let lastImageData = null;
            let bgColor = '#ffffff';

            var brush = {
                color: "#000000",
                size: 5
            }

            function initializeCanvas() {
                const parentWidth = canvas.parentElement.clientWidth;
                if (canvas.width !== parentWidth) {
                    //save current drawing before resize
                    if (canvas.width > 0 && canvas.height > 0) {
                        lastImageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    }

                    canvas.width = parentWidth;

                    if (lastImageData) { //restore the drawing after resize 
                        ctx.fillStyle = bgColor;
                        ctx.fillRect(0, 0, canvas.width, canvas.height);
                        ctx.putImageData(lastImageData, 0, 0);
                    }
                }
            }

            initializeCanvas();
            ctx.fillStyle = bgColor;
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            let resizeTimeout;
            window.addEventListener('resize', function() { //makes it so while adjusting window size, initializeCanvas isn't spam-called
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(initializeCanvas, 100);
            });

            function startDrawing(e) {
                painting = true;
                draw(e);
            }

            function endDrawing() {
                if (!painting) return;
                painting = false;
                ctx.stroke(); //finish stroke
                ctx.beginPath(); //reset path

                saveState(); //save state for undo
            }

            function draw(e) {
                if (!painting) return;

                // Get coordinates with proper offsetting for mouse or touch
                const x = getEventX(e);
                const y = getEventY(e);

                ctx.lineWidth = brush.size;
                ctx.lineCap = 'round';
                ctx.strokeStyle = brush.color;
                ctx.lineTo(x, y);
                ctx.stroke();
                ctx.beginPath();
                ctx.moveTo(x, y);
            }

            function getEventX(e) {
                if (e.touches && e.touches[0]) {
                    return e.touches[0].clientX - canvas.getBoundingClientRect().left;
                }
                return e.offsetX;
            }

            function getEventY(e) {
                if (e.touches && e.touches[0]) {
                    return e.touches[0].clientY - canvas.getBoundingClientRect().top;
                }
                return e.offsetY;
            }

            function saveState() { //save the current state for undo
                const canvasData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                drawnShapes.push(canvasData);

                if (drawnShapes.length > 20) { //limited undo history
                    drawnShapes.shift();
                }
            }

            function showAlert(message, type = 'success') {
                const alertContainer = document.getElementById('alertContainer');

                const alertDiv = document.createElement('div');
                alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
                alertDiv.innerHTML = `${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
                alertContainer.appendChild(alertDiv);

                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alertDiv);
                    bsAlert.close();
                }, 5000);
            }

            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mouseup', endDrawing);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseleave', endDrawing);

            canvas.addEventListener('touchstart', function(e) {
                e.preventDefault(); //prevents scrolling 
                startDrawing(e);
            });
            canvas.addEventListener('touchend', function(e) {
                e.preventDefault();
                endDrawing();
            });
            canvas.addEventListener('touchmove', function(e) {
                e.preventDefault();
                draw(e);
            });

            function setupDrawingTools() {
                const colorPicker = document.getElementById('colorPicker');
                const sizeSlider = document.getElementById('sizeSlider');
                const clearBtn = document.getElementById('clearBtn');
                const undoBtn = document.getElementById('undoBtn');
                const saveBtn = document.getElementById('saveBtn');

                colorPicker.addEventListener('input', (e) => {
                    brush.color = e.target.value;
                });

                $('#sizeSlider').on('input', function() {
                    brush.size = parseInt($(this).val());
                    $('#brushSizeDisplay').text('Brush size: ' + brush.size);
                });

                clearBtn.addEventListener('click', () => {
                    ctx.fillStyle = bgColor;
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    drawnShapes = [];
                    saveState();
                    showAlert('Canvas cleared', 'info');
                });

                undoBtn.addEventListener('click', () => {
                    if (drawnShapes.length > 1) {
                        drawnShapes.pop(); //removes latest state
                        ctx.putImageData(drawnShapes[drawnShapes.length - 1], 0, 0); //then applies previous state
                    } else if (drawnShapes.length === 1) {
                        //if only one state remains, clear to initial bg
                        ctx.fillStyle = bgColor;
                        ctx.fillRect(0, 0, canvas.width, canvas.height);
                        drawnShapes = [];
                    }
                });

                saveBtn.addEventListener('click', saveDrawing);
            }

            async function saveDrawing() {
                const imageData = canvas.toDataURL('image/png');

                // here is where json is used
                try {
                    const response = await fetch('?command=saveDrawing', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            imageData: imageData,
                            title: document.querySelector('.fw-bold').textContent
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        showAlert('Drawing saved successfully!', 'success');
                    } else {
                        showAlert('Failed to save drawing.', 'danger');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showAlert('An error occurred while saving the drawing.', 'danger');
                }
            }

            setupDrawingTools();
            saveState(); //save initial state (blank canvas)

        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>

<!-- current issue to note: screen size impacts drawing size so they look wonky when saving to profile with different sizes -->