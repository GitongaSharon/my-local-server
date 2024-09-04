function loadTableData() {
    const tableSelect = document.getElementById("table-select");
    const tableName = tableSelect.value;

    if (tableName) {
        fetch(`get_table_data.php?table=${tableName}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById("table-data-container").innerHTML = data;
            });
    } else {
        document.getElementById("table-data-container").innerHTML = "";
    }
}

function updateRecord(table, id) {
    const inputs = document.querySelectorAll(`#row-${id} input`);
    const updateData = {};

    inputs.forEach(input => {
        updateData[input.name] = input.value;
    });

    if (confirm("Are you sure you want to update this record?")) {
        fetch("update_record.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ table, id, updateData }),
        })
        .then(response => response.text())
        .then(result => {
            alert(result);
            loadTableData(); // Reload the table data after update
        });
    }
}
