<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT id, password FROM instructors WHERE username = ? AND password = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $username, $password);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $_SESSION['instructor_id'] = $row['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Login</title>

<!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                    }
                }
            }
        }
    </script>

<!-- Bootsrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="dark:bg-gray-900 h-max absolute left-1/2 bottom-1 transform -translate-x-1/2 -translate-y-32 border-l-indigo-300 bg-[#35bafd]">
    <!-- <h2 class="text-center p-4 bg-primary color text-white">Instructor Login</h2>
    <div class="container"> -->
    
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

    
   

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-2xl overflow-hidden max-w-3xl w-full flex flex-row-reverse">

        <!-- Banner moved to the right -->
        <div class=" md:block w-1/3 bg-primary relative">

            <div class="relative left-5">                     

                <h3 class="text-white text-3xl font-bold mt-10 mb-2 ">Don't have an account yet?</h3>
                <p class="text-white mb-4">Please sign up.</p>
             </div>

            <div class="relative left-14 mt-20">
                <button class="bg-white font-bold text-primary py-2 px-4 rounded-full w-1/2 hover:bg-gray-100 transition duration-300"><a href="sign.php">Sign Up</a></button>
            </div>  

            <img src="Boy.png" class="w-32 absolute bottom-0 left-12">
        </div>

        <div class="w-full md:w-2/3 p-8">
            <h2 class="text-3xl font-bold mb-2 dark:text-white">Sign In</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">To continue to your account</p>

            <!-- Start Form -->
            <form action="" method="post">
                <!-- Email -->
                <div class="mb-4">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" placeholder="binimanoy@example.com"
                    name="username">
                </div>

                <!-- Password with Show Password button -->
                <div class="mb-4 relative">
                    <label for="password" class="form-label">Password</label>
                    <div class="relative">
                        <input type="password" class="form-control w-100 pr-10" id="password" name="password">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 dark:text-gray-400" style="top: 50%; transform: translateY(-50%); right: 10px; background: none; border: none; cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center dark:text-gray-300">
                        <input type="checkbox" class="mr-2">
                        Remember me
                    </label>
                    <a href="#" class="text-primary hover:underline">Forgot password?</a>
                </div>
                <!-- Login Button -->
                <input type="submit" value="Login" class="btn btn-outline-primary w-100 mt-4 w-100">
                <!-- <button type="submit" class="w-full bg-primary text-white py-2 rounded-md hover:bg-blue-600 transition duration-300">Login</button> -->
            </form>
            <!-- End Form -->
        </div>
    </div>


<!-- -------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
<!-- Hide Password -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {

            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Pag pinindot yung mata
            this.innerHTML = type === 'password' ? 
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>' : 
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" /><path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" /></svg>';
        });
    </script>
</body>
</html>