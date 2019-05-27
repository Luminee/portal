<?php

namespace Luminee\Portal\Foundation;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Luminee\Portal\Repositories\PortalRepository;

trait GLaDOS
{
    protected $portal;

    public function __construct(PortalRepository $portal)
    {
        $this->portal = $portal;
    }

    public function portalLogin($value, $password, $field = 'phone', $type_code = null, $account_id = null)
    {
        $user = $this->getPortalUser($field, $value, $password);

        $account = $this->getPortalAccount($user->id, $type_code, $account_id);
        if (is_array($account)) return $account;

        return $this->makeToken($account->id);
    }

    protected function makeToken($sub)
    {
        $payload = JWTFactory::make(['sub' => $sub]);
        return JWTAuth::encode($payload)->get();
    }

    protected function getPortalUser($field, $value, $password)
    {
        if (empty($user = $this->portal->findUser($value, $field))) {
            throw new \Exception('User not found');
        }
        if (!password_verify($password, $user->password)) {
            throw  new \Exception('Password not correct');
        }
        return $user;
    }

    protected function getPortalAccount($user_id, $type_code, $account_id)
    {
        if (!is_null($account_id) && $account = $this->portal->findAccount($account_id)) {
            return $account;
        }
        if (empty($accounts = $this->portal->listAccount($user_id, $type_code))) {
            throw new \Exception('Account not found');
        }
        if (count($accounts) == 1) {
            return $accounts[0];
        }
        return $accounts;
    }

    public function portalCheck($request)
    {
        if ($token = $request->header('authorization')) {
            if (!starts_with($token, 'Bearer ')) {
                $token = "Bearer " . $token;
            }
            $request->headers->set('authorization', $token);
        }

        if (!$token = JWTAuth::getToken()) {
            throw new \Exception('token not found');
        }
        return JWTAuth::getPayload($token)->get('sub');
    }

}