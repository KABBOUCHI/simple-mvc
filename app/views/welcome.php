<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simple MVC</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">

</head>
<body class="bg-brand-lightest font-sans font-normal">
<div class="flex flex-col">

    <div class="min-h-screen flex items-center justify-center">
        <div class="flex flex-col justify-around h-full">
            <div>
                <h1 class="text-grey-darker text-center font-hairline tracking-wide text-7xl mb-6">
                    <?= $message ?>
                </h1>
                <h3 class="text-grey-darker text-center font-medium tracking-wide text-xl mb-6">
                    <?= trans('messages.hello') ?>
                </h3>
            </div>
        </div>
    </div>
</div>
</body>
</html>