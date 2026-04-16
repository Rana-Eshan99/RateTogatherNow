document.addEventListener('DOMContentLoaded', function () {
    var dropZone = document.getElementById('dropZone');
    var fileUpload = document.getElementById('fileUpload');
    var organizationAvatar = document.getElementById('organizationAvatar');
    var dropZoneText = document.getElementById('dropZoneText');

    // Click to upload
    dropZone.addEventListener('click', function () {
        fileUpload.click();
    });

    // Handle file input change
    fileUpload.addEventListener('change', function (event) {
        handleFiles(event.target.files);
    });

    // Dragover event
    dropZone.addEventListener('dragover', function (event) {
        event.preventDefault();
        dropZone.classList.add('dragover');
    });

    // Dragleave event
    dropZone.addEventListener('dragleave', function (event) {
        dropZone.classList.remove('dragover');
    });

    // Drop event
    dropZone.addEventListener('drop', function (event) {
        event.preventDefault();
        dropZone.classList.remove('dragover');
        handleFiles(event.dataTransfer.files);
    });

    function handleFiles(files) {
        if (files.length > 0) {
            var file = files[0];
            if (validateFile(file)) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    organizationAvatar.src = e.target.result;
                }
                reader.readAsDataURL(file);
                // Assign the file to the file input element
                var dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileUpload.files = dataTransfer.files;
            }
        }
    }

    function validateFile(file) {
        var validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
        var maxSize = 1 * 15360 * 1024; // 15MB
        var fileUploadError = document.getElementById('fileUploadError');

        if (!validTypes.includes(file.type)) {
            fileUploadError.textContent = 'Invalid file type. Only SVG, PNG, JPG, and GIF are allowed.';
            setDefaultAvatar();
            return false;
        }

        if (file.size > maxSize) {
            fileUploadError.textContent = 'File size exceeds 15MB.'
            setDefaultAvatar();
            return false;
        }

        fileUploadError.textContent = ''; // Clear previous error message
        return true;
    }

    function setDefaultAvatar() {
        organizationAvatar.src = defaultAddOrganizationFormAvatar; // Set the defaultAvatar
    }
});
