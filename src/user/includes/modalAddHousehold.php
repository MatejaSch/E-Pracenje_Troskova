<div class="modal" id="modalAddHousehold">
    <div class="card modalCard">
        <img src="../../public/images/icons/x-lg.svg" class="iconClose" id="closeModalHousehold">
        <div class="card-body">
            <form class="form-active" method="post" id="addHousehold"  action="addHousehold.php" novalidate>
                <div class="form-group">
                    <label for="householdName">NAZIV DOMAĆINSTVA: </label>
                    <input type="text" class="form-control" id="householdName" name="householdName">
                    <small class="invalid-feedback" id="errorHouseholdName"></small>
                    <input type="hidden" value="<?php echo $_SESSION['id']?>" name="userId">
                </div>
                <div class="row">
                    <div class="col text-center">
                        <button class="btn btn-lg btn-primary" name="addHousehold" type="submit">NAPRAVI!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>