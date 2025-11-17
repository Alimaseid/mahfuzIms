<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Expired</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h1 class="display-4 text-danger mb-3">419 | Page Expired</h1>
        <p class="lead text-muted mb-4">
            Sorry, your session has expired. Please refresh the page and try again.
        </p>
        <a href="<?php echo e(url()->previous()); ?>" class="btn btn-primary">Go Back</a>
        <a href="<?php echo e(url('/')); ?>" class="btn btn-outline-secondary ms-2">Home</a>
    </div>
</body>

</html>
<?php /**PATH C:\Users\Halima\Documents\ims\resources\views/expired.blade.php ENDPATH**/ ?>