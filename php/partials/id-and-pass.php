<?php

namespace partials;

function idAndPass() {

?>

    <div class="form-group">
        <label for="id">ユーザーID</label>
        <input id="id" type="text" name="id" class="form-control validate-target" minlength="4" maxlength="10" pattern="[a-zA-Z0-9]+" autofocus required/>
        <div class="invalid-feedback"></div>
    </div>
    <div class="form-group">
        <label for="pwd">パスワード</label>
        <input id="pwd" type="password" name="pwd" class="form-control validate-target" minlength="4" pattern="[a-zA-Z0-9]+" required/>
        <div class="invalid-feedback"></div>
    </div>

<?php

}
