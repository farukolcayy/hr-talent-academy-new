

function exportExcel(headerExcel, worksheetExcel, filenameExcel, dataExcel) {

    $("#loader_form").fadeIn();

    setTimeout(() => {
        const header = headerExcel;
        const data = [];


        let workbook = new ExcelJS.Workbook();
        let worksheet = workbook.addWorksheet(worksheetExcel);

        Object.values(dataExcel).forEach(val => {

            var _temp = [];

            for (const [key, value] of Object.entries(val)) {

                var _a = "";

                if (value === "" || value === null) {
                    _a = "null";
                } else {
                    _a = value;
                }

                if (key === "academyOption") {

                    if (_a.indexOf("İnsan Kaynakları") !== -1) {
                        _temp.push("1");
                    } else {
                        _temp.push("");
                    }
                    if (_a.indexOf("Dijital Dönüşüm ve Büyük Veri") !== -1 || _a.indexOf("Big Data") !== -1 || _a.indexOf("Büyük Veri") !== -1) {
                        _temp.push("1");
                    } else {
                        _temp.push("");
                    }
                    if (_a.indexOf("Girişimcilik") !== -1) {
                        _temp.push("1");
                    } else {
                        _temp.push("");
                    }
                    if (_a.indexOf("Satış Pazarlama ve Finans") !== -1 || _a.indexOf("Satış Pazarlama") !== -1) {
                        _temp.push("1");
                    } else {
                        _temp.push("");
                    }
                    if (_a.indexOf("E-Ticaret ve Influencer Marketing") !== -1 || _a.indexOf("Endüstri 4.0") !== -1) {
                        _temp.push("1");
                    } else {
                        _temp.push("");
                    }

                }
                else {
                    _temp.push(value);
                }

            }

            data.push(_temp);

        });

        let headerRow = worksheet.addRow(header);

        // Cell Style : Fill and Border
        headerRow.eachCell((cell, number) => {
            cell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: 'FFFFFF00' },
                bgColor: { argb: 'FF0000FF' }
            }
            cell.border = { top: { style: 'thin' }, left: { style: 'thin' }, bottom: { style: 'thin' }, right: { style: 'thin' } }
        });

        // Add Data and Conditional Formatting
        data.forEach(d => {
            let row = worksheet.addRow(d);
            let qty = row.getCell(1);
            let color = 'FF99FF99';
            // if (+qty.value < 500) {
            //     color = 'FF9999'
            // }
            qty.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: { argb: color }
            }

        }
        );

        workbook.xlsx.writeBuffer().then((data) => {
            let blob = new Blob([data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            saveAs(blob, filenameExcel + '.xlsx').onwriteend = function() { $("#loader_form").fadeOut(); }
        });
    }, 1000);

}