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
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
        <th>Actions</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
        <td>
            <a class="icons" href="<?= url("cms/edit?id=" . esc($row->id)) ?>" title="Edit this content">
                <i class="fa fa-edit" aria-hidden="true"></i>
            </a>
            <a class="icons" href="<?= url("cms/delete?id=" . esc($row->id)) ?>" title="Delete this content">
                <i class="fa fa-trash-alt" aria-hidden="true"></i>
            </a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
