<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>403 - Unauthorized</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <section class="flex flex-col items-center justify-center min-h-screen px-6 py-8 mx-auto lg:py-0">
        <div class="flex flex-col items-center justify-center text-center">

            <h1 class="mb-4 text-7xl tracking-tight font-extrabold lg:text-9xl text-brand dark:text-brand-light">
                403
            </h1>
            <p class="mb-4 text-3xl tracking-tight font-bold text-gray-900 md:text-4xl dark:text-white">
                Access Denied.
            </p>
            <p class="mb-4 text-lg font-light text-gray-500 dark:text-gray-400">
                Sorry, you are not authorized to access this page.
            </p>
            <a href="/"
                class="inline-flex text-white bg-brand hover:bg-brand-strong focus:ring-4 focus:outline-none focus:ring-brand-medium font-medium rounded-lg text-sm px-5 py-2.5 text-center my-4">
                Back to Homepage
            </a>
        </div>
    </section>
</body>

</html>
