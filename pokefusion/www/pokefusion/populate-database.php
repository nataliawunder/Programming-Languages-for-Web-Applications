<?php
    // Note that these are for the local Docker container
//     $host = "db";
//     $port = "5432";
//     $database = "example";
//     $user = "localuser";
//     $password = "cs4640LocalUser!";

    $host = "localhost";
    $port = "5432";
    $database = "xax8gw";
    $user = "xax8gw";
    $password = "4aoSBVXZqYWM";

    // server
    // public static $db = [
    //     "host" => "localhost",
    //     "port" => 5432,
    //     "user" => "xax8gw",
    //     "pass" => "4aoSBVXZqYWM",
    //     "database" => "xax8gw"
    // ];

    // Contributions: 
    // Natalia: Home, Login, Register, User Profile, Gallery (HTML, CSS, JS, PHP)
    // Azka: Home, Login, Register, Play implementation (HTML, CSS, JS, PHP)

    $dbHandle = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");

    if ($dbHandle) {
        echo "Success connecting to database<br>\n";
    } else {
        die("An error occurred connecting to the database");
    }

    // Drop tables and sequences (that are created later)
    // drop tables
    $res  = pg_query($dbHandle, "drop table if exists pokefusion_users cascade;");
    $res  = pg_query($dbHandle, "drop table if exists pokefusion_games cascade;");
    $res  = pg_query($dbHandle, "drop table if exists pokefusion_drawings cascade;");

    // drop join tables
    $res  = pg_query($dbHandle, "drop table if exists pokefusion_user_games cascade;");
    $res  = pg_query($dbHandle, "drop table if exists pokefusion_drawing_ratings cascade;");

    // drop sequences
    $res  = pg_query($dbHandle, "drop sequence if exists pokefusion_user_seq cascade;");
    $res  = pg_query($dbHandle, "drop sequence if exists pokefusion_game_seq cascade;");
    $res  = pg_query($dbHandle, "drop sequence if exists pokefusion_drawings_seq cascade;");


    // Create sequences
    $res  = pg_query($dbHandle, "create sequence pokefusion_user_seq;");
    $res  = pg_query($dbHandle, "create sequence pokefusion_game_seq;");
    $res  = pg_query($dbHandle, "create sequence pokefusion_drawings_seq;");

    // Create tables
    // user table with unique id, username, email, password
    $res  = pg_query($dbHandle, "create table pokefusion_users (
            id int primary key default nextval('pokefusion_user_seq'),
            username text unique,
            email text unique,
            password text);");

    // games table with unique id, user id, word id, score, and won to track the user, word, score and if won
    $res  = pg_query($dbHandle, "create table pokefusion_games (
            id int primary key default nextval('pokefusion_game_seq'),
            user_id int references pokefusion_users(id) on delete cascade);");
    
    // drawing table with unique id, user id, the rating given, 
    $res  = pg_query($dbHandle, "create table pokefusion_drawings (
            id int primary key default nextval('pokefusion_drawings_seq'),
            user_id int references pokefusion_users(id) on delete cascade,
            rating int default 0,
            img_url text,
            title text);");

    // drawing_ratings table, join table with users and ratings to track averages
    $res  = pg_query($dbHandle, "create table pokefusion_drawing_ratings (
            id serial primary key,
            user_id int references pokefusion_users(id) on delete cascade,
            drawing_id int references pokefusion_drawings(id) on delete cascade,
            rating int check (rating between 0 and 5),
            unique(user_id, drawing_id));");

    // user_games table, join table with users and games to track the users stats: user id, total games, games won, win rate, highest score, and avg score
    $res  = pg_query($dbHandle, "create table pokefusion_user_games (
            user_id int references pokefusion_users(id) on delete cascade,
            total_games int default 0,
            games_won int default 0,
            highest_score int default 0,
            avg_score float default 0.0,
            primary key (user_id));");

    echo "Done!";