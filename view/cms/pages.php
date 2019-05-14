<?php
namespace Anax\View;

if (!$resultset) {
    return;
}
?>

<table class="movie-table">
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Status</th>
        <th>Published</th>
        <th>Deleted</th>
    </tr>
<?php foreach ($resultset as $row) :?>
    <tr>
        <td><?= $row->id ?></td>
        <td><a href="<?= url("cms/page-view?path=" . esc($row->path)) ?>"><?= esc($row->title) ?></a></td>
        <td><?= $row->type ?></td>
        <td><?= $row->status ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->deleted ?></td>
    </tr>
<?php endforeach; ?>
</table>
