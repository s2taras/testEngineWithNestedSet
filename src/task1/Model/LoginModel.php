<?php

namespace Task1\Model;

class LoginModel implements LoginModelInterface
{
    public const FAILURE_ATTEMPTS = 3;

    /** @var FileModelInterface */
    protected $fileModel;

    /** @var array */
    protected $users;

    public function __construct()
    {
        $this->fileModel = new FileModel();
        $this->users = $this->fileModel->getUsers();
    }

    /**
     * @param string|null $session
     * @return bool
     */
    public function isLoggined(?string $session): bool
    {
        return $session ? true : false;
    }

    /**
     * @param array $parameters
     * @return array
     */
    public function login(array $parameters): array
    {
        $username = $parameters['username'];
        $password = $parameters['password'];

        if (isset($this->users[$username]) && trim($this->users[$username]) == trim($password)) {
            $parameters['session'] = $username;
            return $this->getSuccessResult('Successfully loggined');
        }

        return $this->getErrorResult('Wrong parameters');
    }

    /**
     * @param string $msg
     * @return array
     */
    protected function getSuccessResult(string $msg): array
    {
        return [
            'status' => 'success',
            'message' => $msg
        ];
    }

    /**
     * @param string $msg
     * @return array
     */
    protected function getErrorResult(string $msg = 'Error'): array
    {
        return [
            'status' => 'error',
            'message' => $msg
        ];
    }

    /**
     * @param array $parameters
     */
    public function countAttempts(array $parameters)
    {
        if ($parameters['attempts'] == self::FAILURE_ATTEMPTS) {
            $parameters['attempts'] = null;
            $parameters['ban_time'] = strtotime("+1 minutes"); // 5
            return;
        }

        if ($parameters['attempts'] == null) {
            $parameters['attempts'] = 1;
        } else {
            $parameters['attempts'] += 1;
        }
    }

    /**
     * @param array $parameters
     */
    public function clearAttempts(array $parameters)
    {
        $parameters['attempts'] = null;
    }

    /**
     * @param array $parameters
     * @return bool
     */
    public function checkBanTime(array $parameters): bool
    {
        $timeNow = strtotime('now');

        if ($parameters['ban_time'] !== null && $parameters['ban_time'] > $timeNow) return true;

        if ($parameters['ban_time'] !== null && $parameters['ban_time'] < $timeNow) $parameters['ban_time'] = null;

        return false;
    }
}