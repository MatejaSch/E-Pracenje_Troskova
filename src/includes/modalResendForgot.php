<div class="modal" id="modalResend">
    <div class="card modalCard">
        <img src="../public/images/icons/x-lg.svg" class="iconClose">
        <div class="card-body">
            <form class="form-active" method="post" action="resendVerification.php" id="resendForm" novalidate>
                <div class="form-group">
                    <label for="resendEmail">E-MAIL</label>
                    <input class="form-control" name="resendEmail" id="resendEmail" type="email">
                    <small class="invalid-feedback" id="errorResendEmail"></small>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <button class="btn btn-lg btn-primary" name="resend" type="submit">Ponovno slanje potvrdnog koda!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="modalForgot">
    <div class="card modalCard">
        <img src="../public/images/icons/x-lg.svg" class="iconClose">
        <div class="card-body">
            <form class="form-active" method="post" id="forgotForm" novalidate>
                <div class="form-group">
                    <label for="forgotEmail">E-MAIL</label>
                    <input class="form-control" name="forgotEmail" id="forgotEmail" type="email">
                    <small class="invalid-feedback" id="errorForgotEmail"></small>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <button class="btn btn-lg btn-primary" name="forgot" type="submit" id="forgotPasswordSubmitButton">Zatraži promenu šifre!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

