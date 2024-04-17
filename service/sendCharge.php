<?php

use Source\Core\View;
use Source\Models\CafeApp\AppOrder;
use Source\Models\CafeApp\AppSubscription;
use Source\Models\User;
use Source\Support\Email;

require __DIR__ . "/../vendor/autoload.php";

$subcription = new AppSubscription();
$email = new Email();
$view = new View(__DIR__ . "/../shared/views/email");

// CHARGE OR PAST DUE: Assinaturas de hoje

$chargeNow = $subcription->find(
    "pay_status = :status AND next_due = date(NOW()) AND last_charge != DATE(now())",
    "status=active"
)->fetch(TRUE);

if ($chargeNow) {
    foreach ($chargeNow as $subscribe) {
        $user = (new User())->findById($subscribe->user_id);
        $plan = $subscribe->plan();
        $card = $subscribe->creditCard();
        $transaction = $card->transaction($plan->price);

        // charge control
        $subscribe->last_charge = date("Y-m-d");

        if ($transaction) {
            // CHARGE SUSCCESS
            $subscribe->status = "active";
            $subscribe->next_due = date("Y-m-d", strtotime($subscribe->next_due . "+{$plan->period}"));
            (new \Source\Models\CafeApp\AppOrder())->byCreditCard($user, $card, $subscribe, $transaction);

            $subject = "[PAGAMENTO CONFIRMADO] Obrigado por assinar o CaféApp";
            $body = $view->render("mail", [
                "subject" => $subject,
                "message" => "<h3>Obrigado, {$user->first_name}!</h3><p>Estamos passando apenas para agradecer por você ser um assinante CaféApp {$plan->name}.</p><p>Sua fatura deste m~es venceu hoje e já está paga de acordo com o seu plano. Qualquer dúvida estamos a disposição.</p>"
            ]);

            $email->bootstrap(
                $subject,
                $body,
                $user->email,
                "{$user->first_name} {$user->last_name}"
            )->queue();
        } else {
            // CHARGE FAIL
            $subscribe->status = "past_due";
            (new AppOrder())->byCreditCard($user, $card, $subscribe, $transaction);

            $subject = "[PAGAMENTO RECUSADO] Sua conta CaféApp precisa de atenção";
            $body = $view->render("mail", [
                "subject" => $subject,
                "message" => "<H3>Prezado, {$user->first_name}!.</H3><p>Não conseguimos cobrar seu cartão referente a fatura deste mês para a sua assinatura CaféApp. Precisamos que você veja isso.</p><p>Acesse sua conta para atualizar seus dados de pagamento, você pode cadastrar outro cartão</p><p>Se não fizer nada agora uma nova tentativa de cobrança será feita em 3 dias. Se não der certo, sua assinatura sera cancelada :/</p><p> Qualquer dúvida estamos a disposição.</p>"
            ]);

            $email->bootstrap(
                $subject,
                $body,
                $user->email,
                "{$user->first_name} {$user->last_name}"
            )->queue();
        }

        // Charge save
        $subscribe->save();
    }
}

// CHARGE OR CANCEL: Assinaturas de 3 dias


$chargeDays = $subcription->find(
    "pay_status = :status AND next_due + INTERVAL 3 DAY = date(NOW()) AND last_charge != DATE(now())",
    "status=active"
)->fetch(TRUE);

if ($chargeDays) {
    foreach ($chargeDays as $subscribe) {
        $user = (new User())->findById($subscribe->user_id);
        $plan = $subscribe->plan();
        $card = $subscribe->creditCard();
        $transaction = $card->transaction($plan->price);

        // charge control
        $subscribe->last_charge = date("Y-m-d");

        if ($transaction) {
            // CHARGE SUSCCESS
            $subscribe->status = "active";

            $subcribe->next_due = date("Y-m-d", strtotime($subscribe->next_due . "+{$plan->period}"));
            (new AppOrder())->byCreditCard($user, $card, $subscribe, $transaction);

            $subject = "[PAGAMENTO CONFIMARDO] Obrigado por assinar o CaféApp";
            $body = $view->render("mail", [
                "subject" => $subject,
                "message" => "<h3>Obrigado, {$user->first_name}!</h3><p>Estamos passando apenas para agradecer por você ser um assinante CaféApp {$plan->name}.</p><p>Sua fatura deste m~es venceu hoje e já está paga de acordo com o seu plano. Qualquer dúvida estamos a disposição.</p>"
            ]);

            $email->bootstrap(
                $subject,
                $body,
                $user->email,
                "{$user->first_name} {$user->last_name}"
            )->queue();
        } else {
            // CHARGE FAIL
            $subscribe->status = "canceled";
            $subscribe->pay_status = "canceled";


            (new AppOrder())->byCreditCard($user, $card, $subscribe, $transaction);


            $subject = "[ASSINATURA CANCELADA] Sua conta CaféApp agora é FREE";
            $body = $view->render("mail", [
                "subject" => $subject,
                "message" => "<H3>Que pena, {$user->first_name}:/</H3><p>Tentamos efetuar mais uma cobrança para sua assinatura {$plan->name} hoje, mas sem sucesso.</p><p>Como essa já é uma segunda tentativa, infelizmente sa assinatura foi cancelada. Mas calma, você pode assinar novamente a qualquer momento</p><p>Continue controlando com os recursos FREE, e assim que quiser basta assinar novamente e voltar de onde parou :)</p>"
            ]);

            $email->bootstrap(
                $subject,
                $body,
                $user->email,
                "{$user->first_name} {$user->last_name}"
            )->queue();
        }

        // Charge save
        $subscribe->save();
    }
}
