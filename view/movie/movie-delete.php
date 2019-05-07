<form method="post">
    <fieldset>
    <legend>Delete</legend>
    <input type="hidden" name="movieId" value="<?= $movie->id ?>"/>

    <p>
        <label>Title:<br>
        <input type="text" name="movieTitle" value="<?= $movie->title ?>" disabled/>
        </label>
    </p>

    <p>
        <label>Year:<br>
        <input type="number" name="movieYear" value="<?= $movie->year ?>" disabled/>
    </p>

    <p>
        <label>Image:<br>
        <input type="text" name="movieImage" value="<?= $movie->image ?>" disabled/>
        </label>
    </p>

    <p>
        <input type="submit" name="doDelete" value="Delete">
    </p>
    </fieldset>
</form>
