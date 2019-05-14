<?php


/**
 * Show textfilters.
 */
$app->router->get("textfilter", function () use ($app) {
    $title = "Textfilter";

    $app->page->add("MyTextFilter/textfilter-start");
    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Show textfilter for BBCode.
 */
$app->router->get("textfilter/bbcode", function () use ($app) {
    $title = "BBCode-Textfilter";

    $myTextFilter = new Pon\MyTextFilter\MyTextFilter();
    $currFilter = "bbcode";
    $text = file_get_contents(__DIR__ . "/../content/text/bbcode.txt");
    $html = $myTextFilter->parse($text, $currFilter);

    $data = [
        "filterName" => "BBCode",
        "text" => $text ?? null,
        "html" => $html ?? null

    ];

    $app->page->add("MyTextFilter/textfilterExample", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Show textfilter for clickable.
 */
$app->router->get("textfilter/clickable", function () use ($app) {
    $title = "Clickable-Textfilter";

    $myTextFilter = new Pon\MyTextFilter\MyTextFilter();
    $currFilter = "link";

    $text = file_get_contents(__DIR__ . "/../content/text/clickable.txt");
    $html = $myTextFilter->parse($text, $currFilter);

    $data = [
        "filterName" => "Clickable",
        "text" => $text ?? null,
        "html" => $html ?? null

    ];

    $app->page->add("MyTextFilter/textfilterExample", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Show textfilter for markdown.
 */
$app->router->get("textfilter/markdown", function () use ($app) {
    $title = "Markdown-Textfilter";

    $myTextFilter = new Pon\MyTextFilter\MyTextFilter();
    $currFilter = "markdown";

    $text = file_get_contents(__DIR__ . "/../content/text/sample.md");
    $html = $myTextFilter->parse($text, $currFilter);

    $data = [
        "filterName" => "Markdown",
        "text" => $text ?? null,
        "html" => $html ?? null

    ];

    $app->page->add("MyTextFilter/textfilterExample", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Show textfilter for nl2br.
 */
$app->router->get("textfilter/nl2br", function () use ($app) {
    $title = "Nl2br-Textfilter";

    $myTextFilter = new Pon\MyTextFilter\MyTextFilter();
    $currFilter = "bbcode, nl2br";

    $text = file_get_contents(__DIR__ . "/../content/text/bbcode.txt");
    $html = $myTextFilter->parse($text, $currFilter);

    $data = [
        "filterName" => "BBCode kombinerad med Nl2br",
        "text" => $text ?? null,
        "html" => $html ?? null

    ];

    $app->page->add("MyTextFilter/textfilterExample", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});
