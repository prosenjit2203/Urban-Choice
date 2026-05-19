<?php 

require_once __DIR__ . "/../models/User.php";

class ProfileController {

    private $user;

    public function __construct() {

        $this->user = new User();
    }

    // UPDATE PROFILE

    public function update() {

        session_start();

        if (!isset($_SESSION["user_id"])) {

            header(
                "Location: ../views/login.php"
            );
        }

        $id = $_SESSION["user_id"];

        $old = $this->user->findById($id);

        $picture = $old["profile_picture"];

        // NEW IMAGE

        if (
            !empty($_FILES["picture"]["name"])
        ) {

            $picture =
            time()
            . "_"
            . $_FILES["picture"]["name"];

            move_uploaded_file(
                $_FILES["picture"]["tmp_name"],
                "../public/uploads/" . $picture
            );
        }

        // UPDATE PROFILE

        $this->user->updateProfile(
            $id,
            $_POST["name"],
            $_POST["email"],
            $_POST["address"],
            $_POST["phone"],
            $picture
        );

        // CHANGE PASSWORD

        if (
            !empty($_POST["new_password"])
        ) {

            if (
                password_verify(
                    $_POST["current_password"],
                    $old["password_hash"]
                )
            ) {

                $hashed = password_hash(
                    $_POST["new_password"],
                    PASSWORD_DEFAULT
                );

                $this->user->changePassword(
                    $id,
                    $hashed
                );
            }
        }

        header(
            "Location: ../views/profile.php?success=1"
        );
    }
}

// ROUTER

if (isset($_GET["action"])) {

    $profile = new ProfileController();

    if ($_GET["action"] == "update") {

        $profile->update();
    }
}
?>