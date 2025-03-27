<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body>
    <section class="bg-black dark:bg-black">
        <div class="flex flex-col items-center  justify-center p-8 mx-auto md:h-screen">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <span class="text-grafik italic font-bold text-4xl">MyShotTracker</span>
            </a>
            <div
                class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 bg-primary border-secondary dark:bg-primary dark:border-secondary">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1
                        class="text-xl italic font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Sign Up to <span class="text-grafik">your account</span>
                    </h1>
                    <form class="space-y-4 md:space-y-6" action="{{ route('users.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="flex flex-row gap-6">

                            <div>

                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="image">Upload file</label>
                                <input name="image"
                                    class="block w-full text-sm text-gray-900 border border-secondary rounded-lg cursor-pointer bg-primary dark:text-gray-400 focus:outline-none dark:bg-primary dark:border-secondary dark:placeholder-gray-400"
                                    id="image" type="file">
                            </div>
                            <div>
                                <label for="role"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                                <select name="role" id="role"
                                    class="bg-primary border border-secondary text-gray-900 rounded-lg block w-full p-2 dark:bg-primary dark:border-secondary dark:text-white">
                                    <option value="Pemain" selected>Role</option>
                                    <option value="Pemain">Pemain</option>
                                    <option value="Pelatih">Pelatih</option>
                                </select>
                            </div>

                        </div>
                        <div>
                            <label for="text"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Player Name</label>
                            <input type="text" name="name" id="text"
                                class="bg-primary border border-secondary text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-primary dark:border-secondary dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="John Doe" required="">
                        </div>

                        <div>
                            <label for="email"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                            <input type="email" name="email" id="email"
                                class="bg-primary border border-secondary text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-primary dark:border-secondary dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="name@company.com" required="">
                        </div>

                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-primary border border-secondary text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-primary dark:border-secondary dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required="">
                        </div>
                        <button type="submit" name="submit"
                            class="py-2.5 w-full px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-primary rounded-lg border border-gray-200 hover:bg-primary hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-primary dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Sign
                            Up</button>

                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            Have an account? <a href="{{ route('login') }}"
                                class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
