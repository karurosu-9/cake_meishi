//addアクションのjsコード
function keisan() {
    for (let i = 1; i <= 5; i++) {
        //単価の値を取得
        let unit_price = document.getElementById('unit_price' + i).value;
        //数量の値を取得
        let quantity = document.getElementById('quantity' + i).value;
        //.valueを付けると値を取得しようとする為、valueは不要
        let amountElement = document.getElementById('amount' + i);

        if (unit_price !== '' && quantity !== '') {
            if (isFinite(quantity)) {
                let addAmount = unit_price * quantity;
                amountElement.value = addAmount;
            } else {
                amountElement.value = unit_price;
            }
        } else {
            amountElement.value = "";
        }
    }
}
