<form method="post">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="movieId"/>

    <p>
        <label>Title:<br>
        <input type="text" name="movieTitle" required/>
        </label>
    </p>

    <p>
        <label>Year:<br>
        <input type="number" name="movieYear" required/>
    </p>

    <p>
        <label>Image:<br>
        <input type="text" name="movieImage" required/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Save">
        <input type="reset" value="Reset">
    </p>
    </fieldset>
</form>
