// Ensure jsPDF is loaded
if (typeof jsPDF === "undefined") {
    console.error("jsPDF library is missing. Include it in your HTML file.");
}

// Function to download result as PDF
function downloadPDF() {
    // Check if jsPDF is available
    if (typeof jsPDF === "undefined") {
        alert("Error: jsPDF library not found!");
        return;
    }

    const { jsPDF } = window.jspdf;  // Correctly get jsPDF object
    let doc = new jsPDF();

    doc.text("Semester Result", 10, 10);
    let y = 20;

    // Get table rows
    let table = document.getElementById("resultTable");
    if (!table) {
        alert("Error: Result table not found!");
        return;
    }

    let rows = table.getElementsByTagName("tr");

    // Loop through table rows
    for (let i = 0; i < rows.length; i++) {
        let rowText = "";
        let cells = rows[i].getElementsByTagName("td");

        for (let j = 0; j < cells.length; j++) {
            rowText += cells[j].innerText + "  |  ";
        }

        doc.text(rowText, 10, y);
        y += 10;
    }

    // Save PDF
    doc.save("Result.pdf");
}
