<div class="modal" id="modalProfileInfo">
    <div class="card">
        <img src="../../public/images/icons/x-lg.svg" width="16px" id="closeProfileInfo" class="iconClose">
        <div class="card-body">
            <div class="card-title">
                PROFILNI PODACI
            </div>
            <div><hr></div>

            <form id="formProfileInfo" method="post" novalidate>
                <div class="form-row">
                    <div class="form-group col">
                        <label for="name">IME</label>
                        <input class="form-control" id="name" name="name" type="text">
                        <small class="invalid-feedback" id="errorName"></small>
                    </div>
                    <div class="form-group col">
                        <label for="lastname">PREZIME</label>
                        <input class="form-control" id="lastname" name="lastname" type="text">
                        <small class="invalid-feedback" id="errorLastname"></small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="phone">TELEFON</label>
                        <input class="form-control" id="phone" name="phone" type="tel">
                        <small class="invalid-feedback" id="errorPhone"></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="address">ADRESA</label>
                        <input class="form-control" id="address" name="address" type="text">
                        <small class="invalid-feedback" id="errorAddress"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <button class="btn btn-lg btn-primary" name="updateProfileInfo" id="updateProfileInfo" type="submit">PROMENI PODATKE!</button>
                    </div>
                </div>
            </form>

            <form id="formChangePassword" method="post" action="" novalidate style="margin-top: 40px;">
                <div class="form-group">
                    <label for="oldPassword">STARA LOZINKA</label>
                    <input class="form-control" id="oldPassword" name="oldPassword" type="password">
                    <small class="invalid-feedback" id="errorOldPassword"></small>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="newPassword">NOVA LOZINKA</label>
                        <input class="form-control" id="newPassword" name="newPassword" type="password">
                        <small class="invalid-feedback" id="errorNewPassword"></small>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="newPasswordConfirm">POTVRDI LOZINKU</label>
                        <input class="form-control" id="newPasswordConfirm" name="newPasswordConfirm" type="password">
                        <small class="invalid-feedback" id="errorNewPasswordConfirm"></small>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <button class="btn btn-lg btn-primary" id="changePassword" type="submit">PROMENI LOZINKU!</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>