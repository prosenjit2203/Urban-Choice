<?php

require_once __DIR__ . "/../models/User.php";

class AuthController {

    private $user;

    public function __construct() {

        $this->user = new User();
    }

    // REGISTER

    public function register() {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $name = trim($_POST["name"]);

            $email = trim($_POST["email"]);

            $password = trim($_POST["password"]);

            $role = trim($_POST["role"]);

            $address = trim($_POST["address"]);

            $phone = trim($_POST["phone"]);

            // VALIDATION

            if (
                empty($name) ||
                empty($email) ||
                empty($password)
            ) {

                die("All fields required");
            }

            if (strlen($password) < 8) {

                die("Password must be 8 characters");
            }

            if (
                $this->user->findByEmail($email)
            ) {

                die("Email already exists");
            }

            // IMAGE

            $picture = "default.png";

            if (
                !empty($_FILES["picture"]["name"])
            ) {

                $allowed = [
                    "image/jpeg",
                    "image/png"
                ];

                if (
                    !in_array(
                        $_FILES["picture"]["type"],
                        $allowed
                    )
                ) {

                    die("Only JPG/PNG allowed");
                }

                if (
                    $_FILES["picture"]["size"] > 2000000
                ) {

                    die("Image too large");
                }

                $picture = time()
                . "_"
                . $_FILES["picture"]["name"];

                move_uploaded_file(
                    $_FILES["picture"]["tmp_name"],
                    "../public/uploads/" . $picture
                );
            }

            // HASH PASSWORD

            $hashed = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // CREATE USER

            $this->user->create(
                $name,
                $email,
                $hashed,
                $role,
                $address,
                $phone,
                $picture
            );

            header(
                "Location: ../views/login.php"
            );
        }
    }

    // LOGIN

    public function login() {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $email = trim($_POST["email"]);

            $password = trim($_POST["password"]);

            $remember = isset(
                $_POST["remember"]
            );

            $user = $this->user->findByEmail(
                $email
            );

            if (
                $user &&
                password_verify(
                    $password,
                    $user["password_hash"]
                )
            ) {

                session_start();

                $_SESSION["user_id"] =
                $user["id"];

                $_SESSION["name"] =
                $user["name"];

                $_SESSION["role"] =
                $user["role"];

                // REMEMBER ME

                if ($remember) {

                    setcookie(
                        "remember_user",
                        $user["id"],
                        time() + (86400 * 30),
                        "/"
                    );
                }

                header(
                    "Location: ../views/home.php"
                );

            } else {

                die("Invalid Login");
            }
        }
    }

    // AUTO LOGIN

    public static function autoLogin() {

        if (
            !isset($_SESSION["user_id"]) &&
            isset($_COOKIE["remember_user"])
        ) {

            $user = (new User())->findById(
                $_COOKIE["remember_user"]
            );

            if ($user) {

                $_SESSION["user_id"] =
                $user["id"];

                $_SESSION["name"] =
                $user["name"];

                $_SESSION["role"] =
                $user["role"];
            }
        }
    }

    // LOGOUT

    public function logout() {

        session_start();

        session_destroy();

        setcookie(
            "remember_user",
            "",
            time() - 3600,
            "/"
        );

        header(
            "Location: ../views/login.php"
        );
    }
}

// ROUTER

if (isset($_GET["action"])) {

    $auth = new AuthController();

    if ($_GET["action"] == "register") {

        $auth->register();
    }

    if ($_GET["action"] == "login") {

        $auth->login();
    }

    if ($_GET["action"] == "logout") {

        $auth->logout();
    }
}
?>