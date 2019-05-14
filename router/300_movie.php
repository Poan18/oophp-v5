<?php


/**
 * Show all movies.
 */
$app->router->get("movie/show-all", function () use ($app) {
    $title = "Movie database";

    $app->db->connect();
    $sql = "SELECT * FROM movie;";
    $res = $app->db->executeFetchAll($sql);

    $app->page->add("movie/header");

    $app->page->add("movie/show-all", [
        "resultset" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Search movies with title.
 */
$app->router->get("movie/search-title", function () use ($app) {
    $title = "Movie database";
    $app->db->connect();

    $searchTitle = $app->request->getGet("searchTitle");

    if ($searchTitle) {
        $sql = "SELECT * FROM movie WHERE title LIKE ?;";
        $res = $app->db->executeFetchAll($sql, [$searchTitle]);
    } else {
        $sql = "SELECT * FROM movie;";
        $res = $app->db->executeFetchAll($sql);
    }

    $app->page->add("movie/header");
    $app->page->add("movie/search-title");
    $app->page->add("movie/show-all", [
        "resultset" => $res,
    ]);


    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Search movies released between two years.
 */
$app->router->get("movie/search-year", function () use ($app) {
    $title = "Movie database";
    $app->db->connect();

    $year1 = $app->request->getGet("year1");
    $year2 = $app->request->getGet("year2");

    if ($year1 && $year2) {
        $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
        $res = $app->db->executeFetchAll($sql, [$year1, $year2]);
    } elseif ($year1) {
        $sql = "SELECT * FROM movie WHERE year >= ?;";
        $res = $app->db->executeFetchAll($sql, [$year1]);
    } elseif ($year2) {
        $sql = "SELECT * FROM movie WHERE year <= ?;";
        $res = $app->db->executeFetchAll($sql, [$year2]);
    } else {
        $sql = "SELECT * FROM movie;";
        $res = $app->db->executeFetchAll($sql);
    }

    $data = [
        "resultset" => $res,
        "year1" => $year1,
        "year2" => $year2
    ];

    $app->page->add("movie/header");
    $app->page->add("movie/search-year", $data);
    $app->page->add("movie/show-all", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * GET Select a movie.
 */
$app->router->get("movie/movie-select", function () use ($app) {
    $title = "Movie database";
    $app->db->connect();

    $movieId =  $app->request->getPost("movieId");

    $sql = "SELECT * FROM movie;";
    $res = $app->db->executeFetchAll($sql);

    $data = [
        "movies" =>  $res ?? null,
    ];

    $app->page->add("movie/header");
    $app->page->add("movie/movie-select", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * POST Select a movie.
 */
$app->router->post("movie/movie-select", function () use ($app) {
    $title = "Movie database";
    $app->db->connect();

    $movieId =  $app->request->getPost("movieId");

    if ($app->request->getPost("doDelete") && is_numeric($movieId)) {
        header("Location: movie-delete?movieId=$movieId");
        exit;
    } elseif ($app->request->getPost("doEdit") && is_numeric($movieId)) {
        header("Location: movie-edit?movieId=$movieId");
        exit;
    }
    return $app->response->redirect("movie/movie-select");
});

/**
 * GET Add a movie.
 */
$app->router->get("movie/movie-add", function () use ($app) {
    $title = "Lägg till ny film | Filmdatabas";
    $app->db->connect();


    $app->page->add("movie/header");
    $app->page->add("movie/movie-add");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * POST Add a movie.
 */
$app->router->post("movie/movie-add", function () use ($app) {
    $app->db->connect();
    $input = $app->request->getPost();
    if (isset($input["movieTitle"]) && isset($input["movieYear"]) && isset($input["movieImage"])) {
        $sql = "INSERT INTO movie(title, year, image) VALUES (?, ?, ?);";
        $app->db->execute($sql, [$input["movieTitle"], $input["movieYear"], "img/noimage.png"]);
        return $app->response->redirect("movie/show-all");
    }
});

/**
 * GET Edit movie.
 */
$app->router->get("movie/movie-edit", function () use ($app) {
    $title = "Redigera filmen | Filmdatabas";
    $app->db->connect();
    $sql = "SELECT * FROM movie WHERE id = ?;";
    $movieId = $app->request->getGet("movieId");

    $data = [
        "movie" => $app->db->executeFetchAll($sql, [$movieId])[0]
    ];

    $app->view->add("movie/header");
    $app->view->add("movie/movie-edit", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
* POST Edit movie.
*/
$app->router->post("movie/movie-edit", function () use ($app) {
    $app->db->connect();
    $input = $app->request->getPost();
    if (isset($input["movieId"]) && isset($input["movieTitle"]) && isset($input["movieYear"]) && isset($input["movieImage"])) {
        $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
        $app->db->execute($sql, [$input["movieTitle"], $input["movieYear"], $input["movieImage"], $input["movieId"]]);
        return $app->response->redirect("movie/show-all");
    }
});

/**
 * GET Delete movie.
 */
$app->router->get("movie/movie-delete", function () use ($app) {
    $title = "Ta bort film | Filmdatabas";
    $app->db->connect();
    $sql = "SELECT * FROM movie WHERE id = ?;";
    $movieId = $app->request->getGet("movieId");

    $data = [
        "movie" => $app->db->executeFetchAll($sql, [$movieId])[0]
    ];

    $app->view->add("movie/header");
    $app->view->add("movie/movie-delete", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
* POST Delete movie.
*/
$app->router->post("movie/movie-delete", function () use ($app) {
    $app->db->connect();
    $input = $app->request->getPost();

    if (isset($input["movieId"])) {
        $sql = "DELETE FROM movie WHERE id = ?;";
        $app->db->execute($sql, [$input["movieId"]]);
        return $app->response->redirect("movie/show-all");
    }
});
