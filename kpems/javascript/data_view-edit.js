document.addEventListener("DOMContentLoaded", function () {
    // Fetch the table data when the user selects a table from the dropdown
    document.getElementById("table-select").addEventListener("change", function () {
        const selectedTable = this.value;

        if (selectedTable) {
            fetch(`get_table_data.php?table=${selectedTable}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        displayTableData(data, selectedTable);
                    } else {
                        alert('No data available or table does not exist.');
                        document.getElementById("data-view-edit-grid").innerHTML = '';
                    }
                })
                .catch(error => console.error("Error fetching table data:", error));
        } else {
            alert('Please select a valid table.');
        }
    });

    // Function to display the table data in a grid format
    function displayTableData(data, table) {
        const grid = document.getElementById("data-view-edit-grid");
        grid.innerHTML = ""; // Clear previous data

        if (data.length === 0) {
            grid.innerHTML = "<p>No data available.</p>";
            return;
        }

        // Create table headers
        const headers = Object.keys(data[0]);
        let headerRow = "<tr>";
        headers.forEach(header => {
            headerRow += `<th>${header}</th>`;
        });
        headerRow += "<th>Actions</th></tr>"; // Add an "Actions" column
        grid.innerHTML = `<table><thead>${headerRow}</thead><tbody></tbody></table>`;

        // Populate table rows
        data.forEach(row => {
            let rowHTML = "<tr>";
            headers.forEach(header => {
                rowHTML += `<td contenteditable="true" data-column="${header}">${row[header]}</td>`;
            });
            rowHTML += `<td><button class="update-button" data-id="${row[headers[0]]}" data-table="${table}">Update</button></td></tr>`;
            grid.querySelector("tbody").innerHTML += rowHTML;
        });

        // Add event listeners to the update buttons
        document.querySelectorAll(".update-button").forEach(button => {
            button.addEventListener("click", function () {
                const row = this.closest("tr");
                const data = {};
                const table = this.getAttribute("data-table");
                const primary_key_value = this.getAttribute("data-id");

                row.querySelectorAll("td[contenteditable='true']").forEach(cell => {
                    const column = cell.getAttribute("data-column");
                    data[column] = cell.textContent.trim();
                });

                if (confirm("Are you sure you want to update this record?")) {
                    updateRecord(table, primary_key_value, data);
                }
            });
        });
    }

    // Function to send the updated data to the server for saving
    function updateRecord(table, primary_key_value, data) {
        const postData = {
            table: table,
            primary_key_value: primary_key_value,
            data: data
        };

        fetch("update_record.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(postData)
        })
        .then(response => response.text())
        .then(result => {
            alert(result); // Display the result from the server
        })
        .catch(error => console.error("Error updating record:", error));
    }
});

