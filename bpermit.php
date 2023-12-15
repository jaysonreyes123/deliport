<?php require_once('./config.php'); ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Permit Upload</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<style>
  #header{
    height:70vh;
    width:calc(100%);
    position:relative;
    top:-1em;
  }
  #header:before{
    content:"";
    position:absolute;
    height:calc(100%);
    width:calc(100%);
    background-image:url(<?= validate_image($_settings->info("cover")) ?>);
    background-size:cover;
    background-repeat:no-repeat;
    background-position: center center;
  }
  #header>div{
    position:absolute;
    height:calc(100%);
    width:calc(100%);
    z-index:2;
  }

  #top-Nav a.nav-link.active {
      color: #343a40;
      font-weight: 900;
      position: relative;
  }
  #top-Nav a.nav-link.active:before {
    content: "";
    position: absolute;
    border-bottom: 2px solid #343a40;
    width: 33.33%;
    left: 33.33%;
    bottom: 0;
  }
  @media (max-width:760px){
    #top-Nav a.nav-link.active {
      background: #343a40db;
      color: #fff;
    }
    #top-Nav a.nav-link.active:before {
      content: "";
      position: absolute;
      border-bottom: 2px solid #343a40;
      width: 100%;
      left: 0;
      bottom: 0;
    }
    h1.w-100.text-center.site-title.px-5{
      font-size:2.5em !important;
    }
  }
</style>
</head>
<?php require_once('inc/header.php') ?>
<body class="layout-top-nav layout-fixed layout-navbar-fixed" style="height: auto;">
    <div class="wrapper">
        <?php $page = isset($_GET['page']) ? $_GET['page'] : 'bpermit'; ?>
        <?php require_once('topbar.php') ?>

        <center><h1 style="margin-top: 300px;"> Please Upload Your Business Permit<h1></center><br /><br />

        <form style="position: center; margin: 0px 300px 0px 300px;" id="uploadForm" enctype="multipart/form-data">
            <center><input style="border:solid; border-radius: 50px; padding: 20px; width: 500px;" type="file" name="myfile"/></center>
            <center><input style="margin-top: 50px; width: 200px;" type="submit" value="Upload" class="btn btn-primary"></center>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            $('#uploadForm').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: 'uploaded.php',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            // Display SweetAlert on success
                            Swal.fire({
                                icon: 'success',
                                title: 'File Uploaded',
                                text: response.message,
                            });
                        } else {
                            // Display SweetAlert on error
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message,
                            });
                        }
                    },
                    error: function () {
                        // Display SweetAlert on general error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred during the upload process.',
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>