<?php

namespace Source\Models\CafeApp;

use Source\Core\Model;

class AppPlan extends Model
{
    public function __construct()
    {
        parent::__construct("app_plans", ["id"], ["name", "period", "period_str", "price", "status"]);
    }

    public function subscribers(?string $status = "active"): ?AppSubscription
    {
        if ($status) {
            return (new AppSubscription())->find("plan_id = :plan AND pay_status = :s", "plan={$this->id}&s={$status}");
        }

        return (new AppSubscription())->find("plan_id = :plan", "plan={$this->id}");
    }

    public function recurrence(): ?int
    {
        return ($this->subscribers()->count * $this->price);
    }
}
