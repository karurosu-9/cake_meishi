//リストで選択された値を取得する処理
document.addEventListener("DOMContentLoaded", function () {
    let selectElement = document.getElementById('select-division');

    selectElement.addEventListener("change", function () {
        let selectDivision = selectElement.value;

        displayBusinessCards(selectDivision);
    });
});

//リストで選択された値と一致するデータを表示させる処理
function displayBusinessCards(selectDivision) {
    let tableRows = document.querySelectorAll('#business-cards-table tr');
    let noDataMessage = document.querySelector('.no-data-message');

    //データの行数をカウントする変数
    let dataRowCount = 0;

    //tableRows[0]は、tableの<th>の表示の部分になるため、<td>から表示される、i = 1;からに設定
    for (let i = 1; i < tableRows.length; i++) {
        //行ごとの取得
        let row = tableRows[i];
        //行の1列目の値を取得 ※row.cells[0]が1列目の値を取得することになる
        let division = row.cells[0].textContent;

        if (selectDivision === '-- 全てのデータを表示する --') {
            row.style.display = 'table-row';
            dataRowCount++;
        } else if (division === selectDivision) {
            row.style.display = 'table-row';
            dataRowCount++;
        } else {
            row.style.display = 'none';
        }
    }

    //絞り込み結果が0だった時のメッセージの表示
    if (noDataMessage) {
        if (dataRowCount === 0) {
            noDataMessage.style.display = 'block';
        } else {
            noDataMessage.style.display = 'none';
        }
    }
}
