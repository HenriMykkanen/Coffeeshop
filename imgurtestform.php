<?php
require('templates/header.php');
require('templates/navigation.php');
?>

<body>
    <div class="container">
        <div class="row justify-content-center" style="padding-bottom:20vh">
            <div class="col-lg-12 col-xs-10">
                <form method="post" action="imgurupload.php" class="form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control">
                    </div>
                    <div id="preview"></div>
                    <div class="form-group">
                        <input type="submit" class="form-control btn-primary" name="submit" value="Upload to Imgur" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require('templates/footer.php'); ?>
    <script>
        // https://codingstatus.com/preview-an-image-before-uploading-using-php/
        function imagePreview(fileInput) {
            if (fileInput.files && fileInput.files[0]) {
                var fileReader = new FileReader();
                fileReader.onload = function(event) {
                    $('#preview').html('<img src="' + event.target.result + '" width="300" height="auto"/>');
                };
                fileReader.readAsDataURL(fileInput.files[0]);
            }
        }
        $('#image').change(function() {
            imagePreview(this);
        });
    </script>
</body>