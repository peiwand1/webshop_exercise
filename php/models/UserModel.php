<?php
require_once 'php/models/BaseModel.php';

class UserModel extends BaseModel
{
    public function handleLogin(string $email, string $password): bool
    {
        $user = $this->getUserByEmail($email);

        if ($user) {
            if (password_verify($password, $user["password"])) {
                $_SESSION["username"] = $user["name"];
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["user_email"] = $user["email"];
                return true;
            }
        }
        return false;
    }

    public function handleRegistration(string $email, string $name, string $password, string $passwordRepeat): int|false
    {
        if (strcmp($password, $passwordRepeat) != 0) return false; // if pass doesn't match
        if ($this->getUserByEmail($email)) return false; // if email already exists
        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (email, name, password) 
        VALUES (:email, :name, :password)"; // pass currently unencrypted
        $params = [
            'email' => $email,
            'name' => $name,
            'password' => $hashed_pass
        ];
        return DatabaseCrud::getInstance()->doInsert($sql, $params);
    }

    public function getUserByEmail(string $email): array|false
    {
        $sql = "SELECT * FROM user WHERE email = :email";
        $param = ['email' => $email];
        return DatabaseCrud::getInstance()->selectOne($sql, $param);
    }

    public function handleLogout(): void
    {
        unset($_SESSION["username"]);
        unset($_SESSION["user_id"]);
        unset($_SESSION["user_email"]);
    }

    public function deleteUser($email): bool
    {
        $sql = "SELECT * FROM user WHERE email = :email";
        $param = ['email' => $email];
        return DatabaseCrud::getInstance()->doDelete($sql, $param);
    }
}
