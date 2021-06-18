<div class="modal" id="modalChangePW">
    <div class="card modalCard">
        <img src="../public/images/icons/x-lg.svg" id="closeChangePWForm" class="iconClose">
        <div class="card-body">
            <form class="form-active" method="post" id="changePWForm" action="checkChangePassword.php" novalidate>
                <div class="form-group">
                    <label for="newPassword">NOVA LOZINKA</label>
                    <input class="form-control" name="newPassword" id="newPassword" type="password">
                    <small class="invalid-feedback" id="errorNewPassword"></small>
                    <label for="confirmNewPassword">POTVRDI NOVU LOZINKU</label>
                    <input class="form-control" name="confirmNewPassword" id="confirmNewPassword" type="password">
                    <small class="invalid-feedback" id="errorConfirmNewPassword"></small>
                    <input type="hidden" name="code" id="code">
                </div>
                <div class="row">
                    <div class="col text-center">
                        <button class="btn btn-lg btn-primary" name="change" type="submit">PROMENI LOZINKU</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
