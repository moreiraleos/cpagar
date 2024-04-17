<?php

namespace Source\Models\CafeApp;

use Source\Core\Model;
use Source\Models\User;

class AppWallet extends Model
{
    public function __construct()
    {
        parent::__construct("app_wallets", ["id"], ["user_id", "wallet"]);
    }

    public function start(User $user): AppWallet
    {
        if (!$this->find("user_id = :user", "user=$user->id")->count()) {
            $this->user_id = $user->id;
            $this->wallet = "Minha carteira";
            $this->free = true;
            $this->save();
        }
        return $this;
    }

    /**
     * @return object
     */
    public function balance(): object
    {
        return (new AppInvoice())->balanceWallet($this);
    }
}
