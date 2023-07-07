document.addEventListener("DOMContentLoaded", function() {
    let selectElement = document.getElementById('select-division');
    
    selectElement.addEventListener("change", function () {
        let selectDivision = selectElement.value;
    
        displayBusinessCards(selectDivision);
    });
  });
  

function displayBusinessCards(selectDivision) {
    let tableRows = document.querySelectorAll('#business-cards-table tr');
    let noDataMessage = document.querySelector('.no-data-message');

    //データの行数をカウントする変数
    let dataRowCount = 0;

    //tableRows[0]は、tableの<th>の表示の部分になるため、<td>から表示される、i = 1;からに設定
    for (let i = 1; i < tableRows.length; i++) {
        //行ごとの取得
        let row = tableRows[i];
        //行の2列目の値を取得 ※1列目は<tr>のため
        let division = row.cells[1].textContent;

        if (selectDivision === '') {
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

//初期表示は全ての名刺を表示する
displayBusinessCards('');