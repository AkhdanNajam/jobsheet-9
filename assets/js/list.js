async function muatDaftar() {
    const table = document.querySelector(".table-responsive table");
    const tbody = table && table.querySelector("tbody");
    const loading = document.getElementById("loading-indicator");

    if (!table || !tbody) return;

    const columns = Array.from(table.querySelectorAll("thead th"));
    const fields = columns
        .filter(function (column) {
            return column.dataset.field;
        })
        .map(function (column) {
            return {
                field: column.dataset.field,
                fallback: column.dataset.fallback || ""
            };
        });
    const hasActions = columns.some(function (column) {
        return column.hasAttribute("data-actions");
    });

    if (loading) loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        const response = await fetch(table.dataset.source);

        if (!response.ok) {
            throw new Error("Gagal mengambil data (status " + response.status + ")");
        }

        const records = await response.json();

        records.forEach(function (record) {
            const row = document.createElement("tr");

            fields.forEach(function (column) {
                const cell = document.createElement("td");
                const value = record[column.field];
                cell.textContent = value == null ? column.fallback : value;
                row.appendChild(cell);
            });

            if (hasActions) {
                const cell = document.createElement("td");
                const editButton = document.createElement("button");
                editButton.type = "button";
                editButton.textContent = "Edit";

                const deleteButton = document.createElement("button");
                deleteButton.type = "button";
                deleteButton.className = "btn-hapus";
                deleteButton.textContent = "Hapus";

                cell.append(editButton, " ", deleteButton);
                row.appendChild(cell);
            }

            tbody.appendChild(row);
        });
    } catch (error) {
        const row = document.createElement("tr");
        const cell = document.createElement("td");
        cell.colSpan = columns.length;
        cell.textContent = "Gagal memuat data: " + error.message;
        row.appendChild(cell);
        tbody.appendChild(row);
    } finally {
        if (loading) loading.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", muatDaftar);
