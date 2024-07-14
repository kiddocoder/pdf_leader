
<!DOCTYPE html>
<html>
<head>
     <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="author" content="Kiddo Coder Pro">
      <meta name="description" content="PDF Converter Using JavaScript">
      <title>PDF Converter Using JavaScript</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body>
<div class="container">
    <form id="MyForm" action="save.php" method="post" enctype="multipart/form-data">
        <div class="file-upload">
                  <label for="file-upload-input">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span id="uploaded-msg">Upload PDF</span>
                  </label>
                  <input type="file" id="pdf_file" accept=".pdf">
            </div>
            <hr>
        <input id="process" type="submit" value="Insert into Database">
    </form>
    <div class="preview" id="cnv">
           <canvas id="canvas"></canvas>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.8.335/pdf.min.js"></script>
<script src="script.js"></script>
</body>
</html>
