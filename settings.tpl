{$message}
<form method="post" enctype="multipart/form-data">
    <fieldset>
        <legend>{l s="Starter PrestaShop Module"}</legend>

        <div class="opt clearfix">
            <label for="quote">{l s="Quote"}</label>
            <div class="margin-form">
                <input id="quote" type="text" name="quote" value="{$quote}" style="width:250px">
            </div>
        </div>
        <div class="opt clearfix">
            <label for="author">{l s="Author"}</label>
            <div class="margin-form">
                <input id="author" type="text" name="author" value="{$author}" style="width:250px">
            </div>
        </div>

        <div class="margin-form">
            <input class="button" type="submit" name="saveBtn" value="Save">
        </div>
    </fieldset>
</form>