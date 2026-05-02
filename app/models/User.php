<?php
class User extends Model
{
    protected $table = 'users';

    public function findByUsername($username)
    {
        return $this->findOne(['username' => $username]);
    }
    public function findByEmail($email)
    {
        return $this->findOne(['email' => $email]);
    }
    public function register($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->create($data);
    }
    public function login($username, $password)
    {
        $user = $this->findByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    public function getTotalUsers()
    {
        return $this->count();
    }

    public function getAllWithStats()
    {
        $sql = "SELECT u.id, u.username, u.full_name, u.email, u.role,
                    COUNT(w.id) as total_workouts,
                    MAX(w.date) as last_workout
                FROM {$this->table} u
                LEFT JOIN workouts w ON u.id = w.user_id
                GROUP BY u.id
                ORDER BY u.id ASC";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }
}
