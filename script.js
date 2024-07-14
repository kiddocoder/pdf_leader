let MyForm = document.getElementById("MyForm");
let pdf_file = document.getElementById("pdf_file");
const uploadedMsg  = document.getElementById("uploaded-msg");
pdf_file.addEventListener("change",function(e){
    uploadedMsg.innerText = "File uploaded ";
})



MyForm.addEventListener("submit", function(e){
      e.preventDefault();
      let pdfFile = pdf_file.files[0];
      let formData = new FormData();
      formData.append("pdf_file", pdfFile);
      fetch(this.action, {
            method: "POST",
            body: formData,
      })
            .then((response) => response.json())
            .then((data) => {
                  if(data.success == true){
                        alert(data.messages);
                        MyForm.reset();
                        PDFStart('/media/' + data.fileName);
                  }else{
                        alert(data.messages);
                  }
            })
            .catch((error) => {
                  console.error('Error:', error);
            });
})


const PDFStart = nameRoute => {           
      let loadingTask = pdfjsLib.getDocument(nameRoute),
          pdfDoc = null,
          canvas = document.getElementById('canvas'),
          ctx = canvas.getContext('2d'),
          scale = 1.5;

          loadingTask.promise.then(pdfDoc_ => {
              pdfDoc = pdfDoc_;
              let numPages = pdfDoc.numPages;
              let renderPage = function(pageNumber) {
                  if (pageNumber > numPages) {
                      return;
                  }
                  pdfDoc.getPage(pageNumber).then(function(page) {
                      let viewport = page.getViewport({ scale: scale });
                      canvas.height = viewport.height;
                      canvas.width = viewport.width;
                      let renderContext = {
                          canvasContext : ctx,
                          viewport:  viewport
                      }
                      page.render(renderContext).promise.then(function() {
                          renderPage(pageNumber + 1);
                      });
                  });
              };
              renderPage(1);
          });
  }
  
  const startPdf = () => {
  }
  
  window.addEventListener('load', startPdf);

