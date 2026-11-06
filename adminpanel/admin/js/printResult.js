const doc = new jsPDF();
const pageHtml = "../../../pages/result.php";
doc.fromHTML(pageHtml);
const pdfData = doc.output();

const blob = new Blob([pdfData], {
  type: application / pdf,
});

const url = URL.createObjectURL(blob);

document.querySelector("#download-pdf").href = url;
document.querySelector("#download-pdf").download = "result.pdf";
