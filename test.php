<!DOCTYPE html>
<html>
<head>
    <title>File Upload with Preview and Remove</title>
    <style>
        /* Style for file preview */
        .preview {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .preview img,
        .preview .pdf-icon {
            max-width: 100px;
            max-height: 100px;
        }

        .remove-btn {
            cursor: pointer;
            color: red;
        }
    </style>
</head>
<body>

<h2>File Upload with Preview and Remove</h2>
<div id="file-upload">
    <input type="file" id="fileInput" accept="image/*,.pdf">
</div>
<div id="file-preview"></div>

<script>
    // File input element
    const fileInput = document.getElementById('fileInput');

    // Preview area
    const filePreview = document.getElementById('file-preview');

    fileInput.addEventListener('change', function(event) {
        const fileList = event.target.files;

        // Clear previous previews
        filePreview.innerHTML = '';

        for (let i = 0; i < fileList.length; i++) {
            const file = fileList[i];
            const reader = new FileReader();

            reader.onload = function(event) {
                const previewDiv = document.createElement('div');
                previewDiv.classList.add('preview');

                if (file.type.includes('image')) {
                    const img = document.createElement('img');
                    img.src = event.target.result;
                    previewDiv.appendChild(img);
                } else if (file.type.includes('pdf')) {
                    const pdfIcon = document.createElement('div');
                    pdfIcon.classList.add('pdf-icon');
                    pdfIcon.textContent = 'PDF';
                    previewDiv.appendChild(pdfIcon);
                }

                const removeBtn = document.createElement('span');
                removeBtn.classList.add('remove-btn');
                removeBtn.textContent = 'Remove';
                removeBtn.addEventListener('click', function() {
                    fileInput.value = '';
                    filePreview.removeChild(previewDiv);
                });
                previewDiv.appendChild(removeBtn);

                filePreview.appendChild(previewDiv);
            };

            reader.readAsDataURL(file);
        }
    });
</script>

</body>
</html>
