<?php
session_start();
?>

<html>

<head>
    <title>RSA Algorithm</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">
                <h2>Digital Signature for Medical</h2>
            </a>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-4">
            <div class="col text-center">
                <h1>P : <span id="txt_p"></span> | Q : <span id="txt_q"></span> </h1>
                <button type="button" class="btn btn-primary mt-3" onclick="generateKey()">Generate Key</button>
            </div>
        </div>

        <!-- Menu Pembangkitan -->
        <div class="card mb-4 menu-pembangkitan">
            <div class="card-header text-center">
                <h4>Menu Pembangkitan</h4>
            </div>
            <div class="card-body">
                <form action="save_key.php" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="public_key">Public Key</label>
                            <textarea name="public_key" class="form-control" id="public_key" rows="5" readonly></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="private_key">Private Key</label>
                            <textarea name="private_key" class="form-control" id="private_key" rows="5" readonly></textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6 text-right">
                            <button type="submit" name="type" value="public" class="btn btn-primary">Save Public Key</button>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="submit" name="type" value="private" class="btn btn-primary">Save Private Key</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Menu Digital Signature -->
        <div class="card menu-digital-signature">
            <div class="card-header text-center">
                <h4>Menu Digital Signature</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col text-center mb-3">
                        <?php if (!isset($_SESSION["file_upload_name"])) : ?>
                            <form action="upload_file.php" method="POST" enctype="multipart/form-data">
                                <label for="file_upload">Upload a File:</label>
                                <input type="file" id="file_upload" name="file_upload" class="form-control-file">
                                <button type="submit" class="btn btn-primary mt-2">Upload</button>
                            </form>
                        <?php else : ?>
                            <form action="remove_file.php" method="POST">
                                <label>File uploaded: <?php echo $_SESSION["file_upload_name"]; ?></label>
                                <button type="submit" class="btn btn-danger mt-2">Remove</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card card-signing">
                            <div class="card-body">
                                <h5 class="card-title">Signing</h5>
                                <form action="sign_file.php" method="POST" enctype="multipart/form-data">
                                    <label for="private_key_sign">Private Key:</label>
                                    <input type="file" id="private_key_sign" name="private_key" class="form-control mb-2">
                                    <button type="submit" class="btn btn-primary btn-block">Sign</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card card-verifying">
                            <div class="card-body">
                                <h5 class="card-title">Verifying</h5>
                                <form action="verify_file.php" method="POST" enctype="multipart/form-data">
                                    <label for="public_key_verify">Public Key:</label>
                                    <input type="file" id="public_key_verify" name="public_key" class="form-control mb-2">
                                    <button type="submit" class="btn btn-primary btn-block">Verify</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            generateKey();
        });

        function generateKey() {
            $.ajax({
                method: 'POST',
                url: "generate_key.php",
                dataType: "json",
                success: function(data) {
                    $('#txt_p').text(data.p);
                    $('#txt_q').text(data.q);
                    $('#txtP').val(data.p);
                    $('#txtQ').val(data.q);
                    $('#private_key').val(data.private_key);
                    $('#public_key').val(data.public_key);
                }
            });
        }
    </script>
    <?php if (isset($_SESSION['alert_msg'])): ?>
        <script>
            alert("<?php echo $_SESSION['alert_msg']; ?>");
        </script>
        <?php unset($_SESSION['alert_msg']); ?>
    <?php endif; ?>
</body>

</html>
