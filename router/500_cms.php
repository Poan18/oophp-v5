<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Show content within database
 */
$app->router->get("cms/show-all", function () use ($app) {
    $title = "CMS";

    $app->db->connect();
    $sql = "SELECT * FROM content;";
    $res = $app->db->executeFetchAll($sql);

    $app->page->add("cms/header");

    $app->page->add("cms/show-all", [
        "res" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Show all blog posts
 */
$app->router->get("cms/blog", function () use ($app) {
    $title = "Blogg";

    $app->db->connect();
    $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE type=?
AND (deleted IS NULL OR deleted > NOW())
AND published <= NOW()
ORDER BY published DESC
;
EOD;
    $res = $app->db->executeFetchAll($sql, ["post"]);

    $app->page->add("cms/header");
    $app->page->add("cms/blog", [
        "res" => $res,
    ]);


    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Show specific blog post with filter
 */
$app->router->get("cms/blog-post", function () use ($app) {
    $title = "Blogg post";
    $myTextFilter = new Pon\MyTextFilter\MyTextFilter();
    $app->db->connect();

    $slug = $app->request->getGet("slug");

    $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM content
WHERE
slug = ?
AND (deleted IS NULL OR deleted > NOW())
AND published <= NOW()
;
EOD;
    $content = $app->db->executeFetch($sql, [$slug]);
    $filteredText = $myTextFilter->parse($content->data, $content->filter);

    $data = [
        "content"   => $content,
        "filteredText"   => $filteredText
    ];

    $app->page->add("cms/header");
    $app->page->add("cms/blogpost", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Show overview with admin features
 */
$app->router->get("cms/admin", function () use ($app) {
    $title = "Admin content";

    $app->db->connect();
    $sql = "SELECT * FROM content;";
    $res = $app->db->executeFetchAll($sql);

    $app->page->add("cms/header");

    $app->page->add("cms/admin", [
        "resultset" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Show table with all pages.
 */
$app->router->get("cms/pages", function () use ($app) {
    $title = "View pages";

    $app->db->connect();

    $sql = <<<EOD
    SELECT
        *,
        CASE
            WHEN (deleted <= NOW()) THEN "isDeleted"
            WHEN (published <= NOW()) THEN "isPublished"
            ELSE "notPublished"
        END AS status
    FROM content
    WHERE type=?
    ;
EOD;

    $res = $app->db->executeFetchAll($sql, ["page"]);

    $app->page->add("cms/header");
    $app->page->add("cms/pages", [
        "resultset" => $res,
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Show specific page.
 */
$app->router->get("cms/page-view", function () use ($app) {
    $title = "View page";

    $app->db->connect();
    $path = $app->request->getGet("path");
    $myTextFilter = new Pon\MyTextFilter\MyTextFilter();
    $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
    path = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;
    $content = $app->db->executeFetch($sql, [$path, "page"]);
    $filteredText = $myTextFilter->parse($content->data, $content->filter);

    $app->page->add("cms/header");

    $app->page->add("cms/page", [
        "content" => $content,
        "filteredText" => $filteredText
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Edit specific ID.
 */
$app->router->get("cms/edit", function () use ($app) {
    $title = "View page";

    $app->db->connect();
    $contentId = $app->request->getGet("id");

    $sql = "SELECT * FROM content WHERE id = ?;";

    $content = $app->db->executeFetch($sql, [(int)$contentId]);

    $app->page->add("cms/header");
    $app->page->add("cms/edit", [
        "content" => $content
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Save specific ID.
 */
$app->router->post("cms/edit", function () use ($app) {
    $app->db->connect();
    $params = getPost([
        "contentTitle",
        "contentPath",
        "contentSlug",
        "contentData",
        "contentType",
        "contentFilter",
        "contentPublish",
        "contentId"
    ]);

    if (!$params["contentSlug"]) {
        $params["contentSlug"] = slugify($params["contentTitle"]);
    }

    if (!$params["contentPath"]) {
        $params["contentPath"] = null;
    }

    $sql = "SELECT slug, id FROM content;";
    $contents = $app->db->executeFetchAll($sql);

    foreach ($contents as $content) {
        if ($params["contentSlug"] == $content->slug && $params["contentId"] != $content->id) {
            $params["contentSlug"] = $params["contentSlug"] . "-" . $params["contentId"];
        }
    }

    $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
    $app->db->execute($sql, array_values($params));

    return $app->response->redirect("cms/edit?id=" . $params["contentId"]);
});

/**
 * GET Delete specific content with ID.
 */
$app->router->get("cms/delete", function () use ($app) {
    $title = "Delete content";

    $app->db->connect();
    $contentId = $app->request->getGet("id");

    $sql = "SELECT id, title FROM content WHERE id = ?;";

    $content = $app->db->executeFetch($sql, [(int)$contentId]);

    $app->page->add("cms/header");
    $app->page->add("cms/delete", [
        "content" => $content
    ]);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * POST Delete specific content with ID.
 */
$app->router->post("cms/delete", function () use ($app) {
    $app->db->connect();
    $contentId = getPost("contentId");

    $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";

    $app->db->execute($sql, [(int)$contentId]);
    return $app->response->redirect("cms/admin");
});

/**
 * GET Delete specific content with ID.
 */
$app->router->get("cms/create", function () use ($app) {
    $title = "Create content";

    $app->page->add("cms/header");
    $app->page->add("cms/create");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * POST Delete specific content with ID.
 */
$app->router->post("cms/create", function () use ($app) {
    $app->db->connect();
    $title = getPost("contentTitle");

    $sql = "INSERT INTO content (title) VALUES (?);";
    $app->db->execute($sql, [$title]);
    $id = $app->db->lastInsertId();
    return $app->response->redirect("cms/edit?id=$id");
});
