<div class="modal" id="modalChangeHouseholdName">
    <div class="card modalCard" id="ChangeHouseholdNamePropagation">
        <img src="../../public/images/icons/x-lg.svg" class="iconClose" id="closeModalChangeHouseholdName">
        <div class="card-body">
            <form class="form-active" method="post" id="ChangeHouseholdName"   novalidate>
                <div class="form-group">
                    <label for="NewHouseholdName">Novo ime domaćinstva: </label>
                    <input type="text" class="form-control" id="NewHouseholdName" name="NewHouseholdName">
                    <small class="invalid-feedback" id="errorNewHouseholdName"></small>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <button class="btn btn-lg btn-primary" name="addHousehold" type="submit">PROMENI IME!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>