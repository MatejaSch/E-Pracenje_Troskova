<div class="modal" id="modalCost">
    <div class="card">
        <img src="../../public/images/icons/x-lg.svg" width="16px" id="closeCost" class="iconClose">
        <div class="card-body">
            <form class="form-active" method="post" id="formInsertCost" novalidate>
                <div class="form-group">
                    <label for="costName">NAZIV TROŠKA</label>
                    <input class="form-control" name="costName" id="costName" type="text">
                    <small class="invalid-feedback" id="errorCostName"></small>
                </div>
                <div class="form-group">
                    <label for="costPrice">CENA TROŠKA</label>
                    <input class="form-control" name="costPrice" id="costPrice" type="number">
                    <small class="invalid-feedback" id="errorCostPrice"></small>
                </div>
                <div class="form-group">
                    <label for="chooseCat2">IZABERI KATEGORIJU</label><br>
                    <select id="chooseCat2" name="category"></select><br>
                    <small class="invalid-feedback" id="errorCostCategory"></small>
                </div>
                <div class="form-group">
                    <label for="costDescription">OPIS TROŠKA</label><br>
                    <textarea name="costDescription" id="costDescription"></textarea>
                    <small class="invalid-feedback" id="errorCostDescription"></small>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <button class="btn btn-lg btn-primary" name="forgot" type="submit">DODAJ TROŠAK!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal" id="modalWish">
    <div class="card modalCard">
        <img src="../../public/images/icons/x-lg.svg" width="16px" id="closeWish" class="iconClose">
        <div class="card-body">
            <form class="form-active" method="post" id="formInsertWish" novalidate>
                <div class="form-group">
                    <label for="wishName">NAZIV ŽELJE</label>
                    <input class="form-control" name="wishName" id="wishName" type="text">
                    <small class="invalid-feedback" id="errorWishName"></small>
                </div>
                <div class="form-group">
                    <label for="wishPrice">CENA ŽELJE</label>
                    <input class="form-control" name="wishPrice" id="wishPrice" type="number">
                    <small class="invalid-feedback" id="errorWishPrice"></small>
                </div>
                <div class="form-group">
                    <label for="chooseCat">IZABERI KATEGORIJU</label><br>
                    <select id="chooseCat" name="category"></select><br>
                    <small class="invalid-feedback" id="errorWishCategory"></small>
                </div>
                <div class="form-group">
                    <label for="date-real">DATUM ŽELJENOG OSTVARENJA ŽELJE</label>
                    <input type="date" id="date-real"  class="form-control" name="date-real">
                    <small class="invalid-feedback" id="errorWishDate"></small>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <button class="btn btn-lg btn-primary" name="forgot" type="submit">DODAJ ŽELJU!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>