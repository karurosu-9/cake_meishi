//フォームに入力した値を取得する処理
document.addEventListener('DOMContentLoaded', function () {
    let inputElement = document.getElementById('input-string');

    inputElement.addEventListener('input', function () {
        //trim()で入力値の余分な空白を取り除く
        let inputString = inputElement.value.trim();

        displayInputString(inputString);
    })
})

//入力した値と一致する名前を表示させる処理
function displayInputString(inputString) {
    let tableRows = document.querySelectorAll('#change-table tr');
    let noDataMessage = document.querySelector('.no-data-message');

    //データの数をカウント 初期値は0
    tableRowsCount = 0;

    for (let i = 1; i < tableRows.length; i++) {
        row = tableRows[i];
        //trim()で表示されている値の余分な空白を取り除く
        tableString = row.cells[1].textContent.trim();

        if (inputString === '') {
            row.style.display = 'table-row';
            tableRowsCount++;
        } else if (tableString.includes(inputString)) {
            row.style.display = 'table-row';
            tableRowsCount++;
        } else {
            row.style.display = 'none';
        }

        //絞り込み結果が0であった時の表示
        if (tableRowsCount === 0) {
            noDataMessage.style.display = 'block';
        } else {
            noDataMessage.style.display = 'none';
        }
    }
}