<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/public/css/reset.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Post</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<div class="container">
    <br>
    <div class="row">
        <div class="col-6">
            <?php if($data['message']): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><i class="fa fa-check"></i></strong> <?php echo $data['message'];  ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php elseif($data['error']): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fa fa-close"></i></strong> <?php echo $data['error']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif ?>

            <a class="btn btn-primary" href="/"><i class="fa fa-home"></i> Go to homepage</a>
            <hr>
            <h3 class="text-center">Post</h3><br>
            <form id="form-create" enctype="multipart/form-data">
                <div class="mb-3 row">
                    <label class="col-form-label"><b>Title</b></label>
                    <div class="col-12">
                        <input type="text" class="form-control" name="title">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-form-label"><b>Description</b></label>
                    <div class="col-12">
                        <textarea type="text" class="form-control" name="content" style="height: 150px"></textarea>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" name="images[]" accept="image/x-png,image/gif,image/jpeg" multiple>
                </div>
                <input type="hidden" class="form-control" name="user_id" value="<?php echo $_SESSION['id'] ?>">
            </form>
            <button id="create-post" type="button" class="btn btn-success">Save</button>
            <br>
        </div>
    </div>
</div>

<script>
    $('#create-post').on('click', function () {
        let form = new FormData(document.querySelector('#form-create'));
        fetch("/posts/create", {
            method: "POST",
            body: form
        })
        .then(res => res.json())
        .then(res => {
            console.log(res)
            Swal.fire({
                position: 'center',
                icon: res.ok ? 'success' : 'error',
                title: res.message,
                showConfirmButton: false,
                timer: 2000
            })
        })
        .catch(e => {
            console.error("alalala loi roif");
        })
    });
</script>
</body>
</html>
